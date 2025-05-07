<?php
namespace App\Exports\federation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;
use DateTime;


class FederationParameterWiseAnalysis implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
{

    public $curdate = '';
    public $counter = 1;
    public function __construct()
    {
        $this->curdate = Carbon::now()->format('d-m-Y');
    }

    public function collection()
    {
        $user = Auth::user();
        $session_data = Session::get('federation_export_session');
        // prd($session_data);

        $query = "SELECT
        fed.id


     FROM
         federation_mst AS fed
          INNER JOIN federation_profile AS fedp
          ON fed.id = fedp.federation_sub_mst_id
          INNER JOIN agency AS ag
          ON fed.agency_id = ag.agency_id


          WHERE fed.is_deleted = 0";

          if(!empty($session_data['Search'])){
            if(!empty($session_data['agency'])){
                $agency = $session_data['agency'];
                $query .=" AND fed.agency_id = $agency  ";
             }
             if(!empty($session_data['federation'])){
                $query .=" AND fed.uin = '" . $session_data['federation'] . "' ";
             }

          }

          $federation = DB::select($query);
        //  prd($federation);
        $data=[];
        foreach ($federation as $res){
            $data[] = $this->fed_analysis($res->id);
        }

        // prd($data);
        return collect($data);
    }

    public function map($res): array
    {


            return [
                $this->counter++,
                $res['uin'],
                $res['name_of_federation'],
                $res['analysis_rating'],
                $res['NRLM_code'],
                $res['name_of_district'],
                $res['name_of_state'],
                $res['agency_name'],

         (string)$res['total_1to8'],
         (string)$res['total_9to11'],
         (string)$res['total_12to14'],
         (string)$res['total_15to20'],
         (string)$res['total_21to22'],
         (string)$res['total_23to25'],
         (string)$res['analysis_final_total'],
            ];
    }

    public function columnFormats(): array
    {
        return [

        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:O1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'color' => ['argb' => '#CCCCCC' ]
                    ]
                ]);
            },
        ];
    }

    public function headings(): array
    {
        return [

            ['S.No',
            'UIN',
            'Name Of Federation',
            'Risk Rating',
            'NRLM Code ',
            'District Name',
            'State Name',
            'Agency Name',

            'Governance',
            'Inclusion',
            'Efficiency',
            'Credit Portfolio',
            'Sustainability',
            'Risk Mitigation',
            'Overall Rating'
            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Parameter-Wise Analysis';
    }

    function fed_analysis($fed_id){
        $query = "SELECT
            fedp.*,
            fed.*,
            ag.agency_name

        FROM
            federation_mst AS fed
        INNER JOIN federation_profile AS fedp ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN agency AS ag ON fed.agency_id = ag.agency_id
        WHERE
            fed.is_deleted = 0 and fed.id = $fed_id";
        $profile= DB::select($query)[0];

        $data['id'] = $profile->id;
        $data['uin'] = $profile->uin;
        $data['name_of_federation'] = $profile->name_of_federation;
        $data['analysis_rating'] = $profile->analysis_rating;
        $data['NRLM_code'] = $profile->clf_code;
        $data['name_of_district'] = $profile->name_of_district;
        $data['name_of_state'] = $profile->name_of_state;
        $data['agency_name'] = $profile->agency_name;



        $governance = DB::table('federation_governance as a')
                ->where('is_deleted', '=', 0)
                ->where('a.federation_sub_mst_id', '=', $fed_id)
                ->get()->toArray();
        $analysis = DB::table('federation_analysis as a')
                ->where('is_deleted', '=', 0)
                ->where('a.federation_sub_mst_id', '=', $fed_id)
                ->get()->toArray();

        $efficiency = DB::table('federation_efficiency as a')
                ->where('is_deleted', '=', 0)
                ->where('a.federation_sub_mst_id', '=', $fed_id)
                ->get()->toArray();

        //analysis 1
        $count = 0;
        $data['analysis_1'] = 0;
        if(!empty($governance)){
            if (($governance[0]->last_two_election_conducted) == 'Yes') {
                $count += 1;
            }

            if (($governance[0]->last_two_election_conducted_2nd) == 'Yes') {
                $count += 1;
            }

            if (($governance[0]->last_two_election_conducted_3rd) == 'Yes') {
                $count += 1;
            }
        }
        if ($count != 0) {
            $data['analysis_1'] = $count == 3 ? 4 : ($count == 2 ? 3 : ($count == 1 ? 1 : 0));
        } else {
            $data['analysis_1'] = 0;
        }

        //analysis 2
        $count1 = '';
        $data['analysis_2'] = 0;
        $average = $analysis[0]->average_metting_attendance;

        if ($average != '') {
            $count1 = (($average >= 90 ? 5 : ($average >= 75 ? 4 : ($average >= 60 ? 3 : 1))));
            $data['analysis_2'] = $count1;
        } else {
            $data['analysis_2'] = 0;
        }

        //analysis 3
        $count3 = $analysis[0]->federation_book_updation;
        $data['analysis_3'] = 0;
        if ($count3 != '') {
            $data['analysis_3'] = $count3 == 'Fully updated' ? 8 : ($count3 == 'Partially updated' ? 4 : ($count == 'Cash book only updated' ? 2 : 0));
        } else {
            $data['analysis_3'] = 0;
        }

        //analysis 4
        $count4 = $analysis[0]->federation_annual_plan_and_budget_approval;
        $data['analysis_4'] = 0;
        if ($count4 != '') {
            $data['analysis_4'] = $count4 == 'Yes' ? 3 : 0;
        } else {
            $data['analysis_4'] = 0;
        }

        //analysis 5
        $count5 = '';
        $data['analysis_5'] = 0;
        $average_result = (int) $analysis[0]->achievement_last_year_annual_plan;

        if ($average_result != '') {
            $average1 = $average_result * 20;
            $count5 = (($average1 > 60 ? 2 : ($average1 >= 50 ? 1 : 0)));
            $data['analysis_5'] = $count5;
        } else {
            $data['show5'] = '';
        }

        //analysis 6
        $result = $analysis[0]->grade_federation_obtained_during_last_1_year;
        $data['analysis_6'] = 0;
        // if ($result != '') {
        // $data['analysis_6'] = $result == 'A' ? 3 : ($result == 'B' ? 2 : ($result == 'C' ? 1 : 0));
        // }


        //analysis 7
        $data['analysis_7'] = 0;

        $nine_b = $profile->shg_at_time_creation;
        $ten_b = $profile->total_SHGs;

        if ($nine_b != 0 || $nine_b > 0) {
            $diff = round((($nine_b - $ten_b) / $nine_b) * 100);
            if (($ten_b >= $nine_b) || ($diff <= 5)) {
                $data['analysis_7'] = 3;
            } elseif ($diff >= 6 && $diff <= 10) {
                $data['analysis_7'] = 2;
            } elseif ($diff >= 11 && $diff <= 20) {
                $data['analysis_7'] = 1;
            } else {
                $data['analysis_7'] = 0;
            }
        } else {
            $data['analysis_7'] = 0;
        }

        //analysis 8
        $data['analysis_8'] = '';
        if($governance[0]->external_audit == 'Yes'){
            $result8 = $governance[0]->issues_highlighted_resolved;
            if( $result8 == 'all'){
                $data['analysis_8'] = 5;
            }elseif($result8 == 'mostly'){
                $data['analysis_8'] = 4;
            }elseif($result8 == 'partially'){
                $data['analysis_8'] = 3;
            }elseif($result8 == 'none'){
                $data['analysis_8'] = 2;
            }

        } else {
            $data['analysis_8'] = 0;
        }


        //analysis 9
        $result9 = (float) $analysis[0]->coverage_of_target_mobilization;
        $data['analysis_9'] = 0;
        if ($result9 != 0) {
            $data['analysis_9'] = ($result9 >= 80 ? 5 : ($result9 >= 60 ? 4 : ($result9 >= 40 ? 3 : 1)));

        } else {
            $data['analysis_9'] = 0;
        }

        //analysis10
        $result10 = (float) $analysis[0]->per_of_poorest_families_benefiting;
        $data['analysis_10'] = 0;

        if ($result10 != '') {
            $data['analysis_10'] = $result10 > 75 ? 5 : ($result10 > 60 ? 4 : ($result10 > 30 ? 3 : 0));
        } else {
            $data['analysis_10'] = 0;
        }
        //analysis 11
        $result11 = (float) $analysis[0]->poorest_category_board_members;
        $data['analysis_11'] = 0;

        if ($result11 != 0) {
            $data['analysis_11'] = ($result11 >= 60 ? 5 : ($result11 >= 40 ? 4 : ($result11 >= 25 ? 3 : 1)));
        } else {
            $data['analysis_11'] = 0;
        }



        //analysis 12
        $result12 = $analysis[0]->time_taken_to_approve_loan;
        $data['analysis_12'] = 0;

        if ($result12 != '') {
            $data['analysis_12'] = $result12 <= 5 ? 4 : ($result12 <= 10 ? 3 : ($result12 <= 15 ? 2 : 1));

        } else {
            $data['analysis_12'] = 0;
        }

        // analysis 26
    $result26 = $efficiency[0]->time_taken_to_give_money_from_approval;
    $data['analysis_26'] = '';
    if($result26 !=''){
        $data['analysis_26'] = ($result26 <= 3 ? 3 : ($result26 <= 5 ? 2 : ($result26 <= 7 ? 1 : 0)));

    }

        //analysis 13
        $count13 = '';
        $result13 = $analysis[0]->cost_per_active_client;
        $data['analysis_13'] = 0;
        if ($result13 != '') {
            $data['analysis_13'] = ($result13 <= 2 ? 3 : ($result13 <= 3 ? 2 : ($result13 <= 5 ? 1 : 0)));
        } else {
            $data['analysis_13'] = 0;
        }

        //analysis 14
        $count14 = '';
        $result14 = $analysis[0]->operating_expense_ratio;
        $data['analysis_14'] = 0;

        if ($result14 != '') {
            $data['analysis_14'] = ($result14 < 5 ? 5 : ($result14 <= 10 ? 4 : ($result14 <= 15 ? 3 : ($result14 > 15 ? 1 : 0))));
        } else {
            $data['analysis_14'] = 0;
        }



        $federation_profile = DB::table('federation_profile as a')
                ->where('is_deleted', '=', 0)
                ->where('a.federation_sub_mst_id', '=', $fed_id)
                ->get()->toArray();


        $fed_formed = $federation_profile[0]->date_federation_was_found;
        $pattern = '/^\d{2}\/\d{2}\/\d{4}$/';


        if (preg_match($pattern, $fed_formed)) {
            $originalDate = DateTime::createFromFormat('d/m/Y', $fed_formed);

            $formattedDate = $originalDate->format('d/M/Y');
        }
        else{
            $formattedDate = $fed_formed;
        }

        $currentnewDate = new DateTime();
        $currentDate = strftime('%d/%b/%Y', $currentnewDate->getTimestamp());
        $date1 = DateTime::createFromFormat('d/M/Y', $formattedDate);
        $date2 = DateTime::createFromFormat('d/M/Y', $currentDate);
        // prd("jhj");
        // Calculate the difference
        // pr($date2);
        $years = 0;
        if($date1 !='' && $date2 !=''){
         $interval = $date1->diff($date2);
         $years = $interval->y;
        }
        // Get the difference in years, months, and days

        // prd($years);
        //analysis 15
        $result15 = $analysis[0]->per_of_members_benefited_from_federation;
        $data['analysis_15'] = 0;

        if ($result15 != '') {
            $data['analysis_15'] = $result15 > 80 ? 5 : ($result15 > 60 ? 4 : ($result15 > 50 ? 3 : 1));
        } else {
            $data['analysis_15'] =  (($years < 3 ? 5 : ($years <=5 ? 3 : ($years >5 ? 0 : 0))));

        }

        //analysis 16
        $result16 = (float) (str_replace('%', '', $analysis[0]->repayment_rate_of_federation_loan));
        $data['analysis_16'] = 0;

        if ($result16 != 0) {
            $data['analysis_16'] = $result16 >= 95 ? 10 : ($result16 >= 80 ? 8 : ($result16 >= 70 ? 6 : 2));
        } else {
            $data['analysis_16'] = 0;
        }

        //analysis 17
        $result17 = (float) (str_replace('%', '', $analysis[0]->repayment_of_Bank_loan_by_the_federation));
        $data['analysis_17'] = 0;

        if ($result17 != 0) {
            $data['analysis_17'] = $result17 > 95 ? 5 : ($result17 >= 80 ? 4 : ($result17 > 70 ? 3 : 1));
        } else {
            $data['analysis_17'] = 0;
        }

        //analysis 18
        $result18 = (float) $analysis[0]->federation_loan_PAR_90;
        $data['analysis_18'] = 0;

        if ($result18 != '') {
            if ($result18 < 1) {
                $data['analysis_18'] = 5;
            }
            if ($result18 >= 1 && $result18 <= 5) {
                $data['analysis_18'] = 3;
            }
            if ($result18 > 5 && $result18 <= 10) {
                $data['analysis_18'] = 1;
            }
            if ($result18 > 10) {
                $data['analysis_18'] = 0;
            }
        } else {
            $data['analysis_18'] = 0;
        }

        //analysis 19
        $result19 = (float) $analysis[0]->livelihood_purposes_of_all_loans;
        $data['analysis_19'] = 0;
        if ($result19 != 0) {
            $data['analysis_19'] = ($result19 >= 90 ? 3 : ($result19 >= 75 ? 2 : ($result19 >= 60 ? 1 : 0)));

        } else {
            $data['analysis_19'] = 0;
        }
        //analysis 20
        $count20 = '';
        $result20 = (float) $analysis[0]->rotation_of_funds;
        $data['analysis_20'] = 0;
        if ($result20 != '') {
            $data['analysis_20'] = ($result20 > 0.7) ? 2 : ((($result20 >= 0.5) && ($result20 <= 0.7)) ? 1 : 0);
        } else {
            $data['analysis_20'] = 0;
        }



        //analysis 21
        $result21 = $analysis[0]->does_federation_cover_own_income;
        $data['analysis_21'] = 0;
        if ($result21 != '') {
            $data['analysis_21'] = $result21 == 'Yes' ? 3 : 0;
        } else {
            $data['analysis_21'] = 0;
        }

        //analysis 22
        $result22 = $analysis[0]->loan_security_fund_established;
        $data['analysis_22'] = 0;

        if ($result22 != '') {
            $data['analysis_22'] = $result22 == 'Yes' ? 3 : 0;
        } else {
            $data['analysis_22'] = 0;
        }


        //analysis 23
        $count23 = '';
        $result23 = (float) (str_replace('%', '', $analysis[0]->members_covered_under_life_insurance));
        $data['analysis_23'] = 0;
        if ($result23 != 0) {
            $data['analysis_23'] = ($result23 >= 90 ? 3 : ($result23 >= 75 ? 2 : ($result23 >= 60 ? 1 : 0)));
        } else {
            $data['analysis_23'] = 0;
        }

        //analysis 24
        $count24 = '';
        $result24 = (float) (str_replace('%', '', $analysis[0]->availed_members_covered_loan_insurance));
        $data['analysis_24'] = 0;
        if ($result24 != 0) {
            $data['analysis_24'] = $result24 >= 90 ? 3 : ($result24 >= 75 ? 2 : ($result24 >= 60 ? 1 : 0));
        } else {
            $data['analysis_24'] = 0;
        }

        //analysis 25
        $count25 = '';
        $result25 = (float) (str_replace('%', '', $analysis[0]->animals_insured_purchased));
        $data['analysis_25'] = 0;
        if ($result25 != 0) {
            $data['analysis_25']  = $result25 >= 90 ? 3 : ($result25 >= 75 ? 2 : ($result25 >= 60 ? 1 : 0));
        } else {
            $data['analysis_25'] = 0;
        }

        // total 1 to 8 Governance
        $data['total_1to8'] = (float) $data['analysis_1'] + (float) $data['analysis_2'] + (float) $data['analysis_3'] + (float) $data['analysis_4'] + (float) $data['analysis_5'] + (float) $data['analysis_7'] + (float) $data['analysis_8'];


        //total 9 to 11 inclusion
        $data['total_9to11'] = (float) $data['analysis_9'] + (float) $data['analysis_10'] + (float) $data['analysis_11'];


        //total 12 to 14 Efficiency
        $data['total_12to14'] = (float) $data['analysis_12'] + (float) $data['analysis_13'] + (float) $data['analysis_14'] + (float) $data['analysis_26'];



        //total 15 to 20 Credit History
        $data['total_15to20'] = (float) $data['analysis_15'] + (float) $data['analysis_16']  + (float) $data['analysis_18'] + (float) $data['analysis_19'] + (float) $data['analysis_20'];


        //total 21 to 22 Sustainability
        $data['total_21to22'] = (float) $data['analysis_21'] + (float) $data['analysis_22'];


        //total 23 to 25 Risk Mitigation
        $data['total_23to25'] = (float) $data['analysis_23'] + (float) $data['analysis_24'] + (float) $data['analysis_25'];


        //  overall total
        $data['analysis_final_total'] = $data['total_23to25'] + $data['total_21to22'] + $data['total_15to20'] + $data['total_12to14'] + $data['total_9to11'] + $data['total_1to8'];


        return $data;

    }
}
