<?php
namespace App\Exports\Cluster;
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


class ClusterParameterWiseAnalysis implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $session_data = Session::get('cluster_export_session');
        // prd($session_data);

        $query = "SELECT
        cl.id


     FROM
         cluster_mst AS cl
          INNER JOIN cluster_profile AS clp
          ON cl.id = clp.cluster_sub_mst_id
          INNER JOIN federation_mst as fed
          on fed.uin = cl.federation_uin
          INNER JOIN federation_profile as fedp
          on fed.id = fedp.federation_sub_mst_id
          INNER JOIN agency AS ag
          ON cl.agency_id = ag.agency_id

          WHERE cl.is_deleted = 0";
          if(!empty($session_data['Search'])){
            if(!empty($session_data['agency'])){
                $agency = $session_data['agency'];
                $query .=" AND cl.agency_id = $agency  ";
             }
             if(!empty($session_data['cluster'])){
                $query .=" AND cl.uin = '" . $session_data['cluster'] . "' ";
             }
             if(!empty($session_data['federation'])){
                $query .=" AND fed.uin = '" . $session_data['federation'] . "' ";
             }

          }


        $cluster = DB::select($query);

        $data=[];
        foreach ($cluster as $res){
            $data[] = $this->cluster_analysis($res->id);
        }


        return collect($data);
    }

    public function map($res): array
    {


            return [
                $this->counter++,
                $res['uin'],
                $res['name_of_cluster'],
                $res['analysis_rating'],
                $res['NRLM_code'],
                $res['name_of_district'],
                $res['name_of_state'],
                $res['name_of_federation'],
                $res['agency_name'],


        (string)$res['total1'],
        (string)$res['total2'],
        (string)$res['total3'],
        (string)$res['total4'],
        (string)$res['total5'],

        (string)$res['grand_total'],

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
                $event->sheet->getStyle('A1:AS1')->applyFromArray([
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
            'Name Of Cluster',
            'Risk Rating',
            'NRLM Code ',
            'District Name',
            'State Name',
            'Federation name',
            'Agency Name',


            'Governance',
            'Inclusion',
            'Efficiency',
            'Credit Portfolio',
            'Savings',
            'Overall Rating ',




            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Parameter wise Analysis ';
    }

    function cluster_analysis($clus_id){

        $query = "SELECT
                    clp.*,
                    cl.*,
                    fedp.name_of_federation,
                    ag.agency_name

                FROM
                    cluster_mst AS cl
                    INNER JOIN cluster_profile AS clp
                    ON cl.id = clp.cluster_sub_mst_id
                    INNER JOIN federation_mst as fed
                    on fed.uin = cl.federation_uin
                    INNER JOIN federation_profile as fedp
                    on fed.id = fedp.federation_sub_mst_id
                    INNER JOIN agency AS ag
                    ON cl.agency_id = ag.agency_id
                WHERE
                    cl.is_deleted = 0 and cl.id = $clus_id";
                $profile= DB::select($query)[0];

                $data['id'] = $profile->id;
                $data['uin'] = $profile->uin;
                $data['name_of_federation'] = $profile->name_of_federation;
                $data['name_of_cluster'] = $profile->name_of_cluster;
                $data['analysis_rating'] = $profile->analysis_rating;
                $data['NRLM_code'] = $profile->vo_code;
                $data['name_of_district'] = $profile->name_of_district;
                $data['name_of_state'] = $profile->name_of_state;
                $data['agency_name'] = $profile->agency_name;

        $saving = DB::table('cluster_saving as a')
                ->where('is_deleted', '=', 0)
                ->where('a.cluster_sub_mst_id', '=', $clus_id)
                ->get()->toArray();
        $efficiency = DB::table('cluster_efficiency as a')
                ->where('is_deleted', '=', 0)
                ->where('a.cluster_sub_mst_id', '=', $clus_id)
                ->get()->toArray();
        $profile = DB::table('cluster_profile as a')
                ->where('is_deleted', '=', 0)
                ->where('a.cluster_sub_mst_id', '=', $clus_id)
                ->get()->toArray();

        $analysis = DB::table('cluster_analysis as a')
                ->where('is_deleted', '=', 0)
                ->where('a.cluster_sub_mst_id', '=', $clus_id)
                ->get()->toArray();

        $governance = DB::table('cluster_governance as a')
                ->where('is_deleted', '=', 0)
                ->where('a.cluster_sub_mst_id', '=', $clus_id)
                ->get()->toArray();

        $inclusion = DB::table('cluster_inclusion as a')
                ->where('is_deleted', '=', 0)
                ->where('a.cluster_sub_mst_id', '=', $clus_id)
                ->get()->toArray();
        //indicator  1
        $count = 0;
        $data['analysis_1'] = '';
        if (!empty($governance) > 0) {
            if (($governance[0]->first_election_date) != '') {
                $count += 1;
            }
            if (($governance[0]->date_last_election) != '') {
                $count += 1;
            }
        }
        if ($count != 0) {
            $data['analysis_1'] = $count == 2 ? 5 : ($count == 1 ? 3 : 0);
        } else {
            $data['analysis_1'] = 0;
        }

        //analysis 2
        $x2 = ($analysis[0]->Average_participation_of);
        $data['Average_participation_of'] = '';
        if ($x2 != '') {
            $data['Average_participation_of'] = ($x2 == 100 ? 5 : ($x2 >= 80 ? 4 : ($x2 >= 60 ? 3 : 2)));
        } else {
            $data['Average_participation_of'] = 0;
        }

        //analysis 3
        $count3 = $analysis[0]->Cluster_Book_updation;

        $data['Cluster_Book_updation'] = '';
        if ($count3 != '') {

            if ($count3 == 'Fully updated') {
                $data['Cluster_Book_updation'] = 5;
            }
            if ($count3 == 'Partially updated') {
                $data['Cluster_Book_updation'] = 4;
            }
            if ($count3 == 'Book not updated') {
                $data['Cluster_Book_updation'] = 0;
            }
        } else {
            $data['Cluster_Book_updation'] = '';
        }
        //analysis 4

        $data['Percentage_of_Defunct'] = '';
        $nine_b = $profile[0]->shg_at_time_creation;
        $ten_b = $profile[0]->total_SHGs;
        if ($nine_b > 0 || $nine_b > 0) {
            $diff = round((($nine_b - $ten_b) / $nine_b) * 100);
            if (($ten_b >= $nine_b) || ($diff <= 5)) {
                $data['Percentage_of_Defunct'] = 5;
            } elseif ($diff >= 6 && $diff <= 10) {
                $data['Percentage_of_Defunct'] = 4;
            } elseif ($diff >= 11 && $diff <= 20) {
                $data['Percentage_of_Defunct'] = 3;
            } else {
                $data['Percentage_of_Defunct'] = 1;
            }
        } else {
            $data['Percentage_of_Defunct'] = '';
        }

        //analysis 5
        $count4 = $analysis[0]->External_audit_completed;
        $data['External_audit_completed'] = '';
        if ($count4 != '') {
            $data['External_audit_completed'] = ($count4 == 'Yes' ? 5 : 0);
            if ($count4 == 'Yes') {
            } elseif ($count4 == 'No') {
            }
        } else {
            $data['External_audit_completed'] = 0;
        }


        //analysis 6
        // $x2 = (str_replace('%', '', $analysis[0]->Coverage_of_target));
        // $data['Coverage_of_target'] = '';
        // if ($x2 != '') {
        //     $data['Coverage_of_target'] = (($x2 >= 80 ? 5 : ($x2 >= 60 ? 4 : ($x2 >= 40 ? 3 : 2))));
        // } else {
        //     $data['Coverage_of_target'] = 0;
        // }

        $poorest = $inclusion[0]->poorest_board_members !='' ?  $inclusion[0]->poorest_board_members : 0 ;
        $poor = $inclusion[0]->poor_board_members !='' ?  $inclusion[0]->poor_board_members : 0 ;
        $members = $poorest + $poor;
        $data['poor_current_leadership'] = '';
        $total_SHGs = $inclusion[0]->total_board_members !='' ? $inclusion[0]->total_board_members :0;
        $x2 ='';
        if($members !=0 || $total_SHGs !=0){
            $x2 = ($members/$total_SHGs)*100;
        }
        if ($x2 != '') {
            $data['poor_current_leadership'] = (($x2 >= 60 ? 5 : ($x2 >= 40 ? 4 : ($x2 >= 25 ? 3 : 1))));

        } else {
            $data['poor_current_leadership'] = 0;
        }

        //analysis 7
        $x2 = $analysis[0]->Percentage_of_poorest_benefiting_from_all_loans;
        $data['Percentage_of_poorest_benefiting_from_all_loans'] = '';
        if ($x2 != '') {
            $data['Percentage_of_poorest_benefiting_from_all_loans'] = (($x2 >= 75 ? 5 : ($x2 >= 60 ? 4 : ($x2 >= 40 ? 3 : 1))));

        } else {
            $data['Percentage_of_poorest_benefiting_from_all_loans'] = 0;
        }
        //analysis 8
        $x2 = $analysis[0]->Representation_of_Poorest;
        $data['Representation_of_Poorest'] = '';
        if ($x2 != '') {
            $data['Representation_of_Poorest'] = (($x2 >= 60 ? 5 : ($x2 >= 40 ? 4 : ($x2 >= 25 ? 3 : 1))));

        } else {
            $data['Representation_of_Poorest'] = 0;
        }


        //analysis 9
        $count11 = $efficiency[0]->group_prepare;
        $data['group_prepare'] = '';
        if ($count11 != '') {
            $data['group_prepare'] = ($count11 == 'Yes' ? 5 : 0);

        } else {
            $data['group_prepare'] = 0;
        }

        //analysis 11
        $count4 = $analysis[0]->Cluster_is_covering_its;
        $data['Cluster_is_covering_its'] = '';
        if ($count4 != '') {
            $data['Cluster_is_covering_its'] = ($count4 == 'Yes' ? 5 : 0);

        } else {
            $data['Cluster_is_covering_its'] = 0;
        }


        // indicator 11
        $count11 = $efficiency[0]->time_taken_to_approve_loan;
        $data['time_taken_to_approve_loan'] = '';
        if ($count11 != '') {
            $data['time_taken_to_approve_loan'] =  (($count11 <=5  ? 5 : ($count11 <=10  ? 4 : ($count11 <= 15 ? 3 : 1))));
        } else {
            $data['time_taken_to_approve_loan'] = 0;
        }


        //analysis 10
        $x2 = (int) $analysis[0]->Time_taken_to_disburse;
        $data['Time_taken_to_disburse'] = '';
        if ($x2 != '') {
            if ($x2 <= 2) {
                $data['Time_taken_to_disburse'] = 5;
            } elseif ($x2 > 2 && $x2 <= 3) {
                $data['Time_taken_to_disburse'] = 4;
            } elseif ($x2 > 3 && $x2 <= 5) {
                $data['Time_taken_to_disburse'] = 3;
            } elseif ($x2 > 5) {
                $data['Time_taken_to_disburse'] = 1;
            }
        } else {
            $data['Time_taken_to_disburse'] = '';
        }






        $cluster_formed = $profile[0]->cluster_formed;

        $pattern = '/^\d{2}\/\d{2}\/\d{4}$/';


        if (preg_match($pattern, $cluster_formed)) {
            $originalDate = DateTime::createFromFormat('d/m/Y', $cluster_formed);

            $formattedDate = $originalDate->format('d/M/Y');
        }
        else{
            $formattedDate = $cluster_formed;
        }

        $currentnewDate = new DateTime();
        $currentDate = strftime('%d/%b/%Y', $currentnewDate->getTimestamp());
        $date1 = DateTime::createFromFormat('d/M/Y', $formattedDate);
        $date2 = DateTime::createFromFormat('d/M/Y', $currentDate);

        // Calculate the difference
        $interval = $date1->diff($date2);
        // Get the difference in years, months, and days
        $years = $interval->y;     // Total years
        $months = $interval->m;    // Remaining months after subtracting full years
        $days = $interval->d;      // Remaining days

        // To get the total number of months, include years as well:
        $totalMonths = ($years * 12) + $months;



        //analysis 12
        $x2 = (str_replace('%', '', $analysis[0]->Repayment_rate_of_cluster_loan));
        $data['Repayment_rate_of_cluster_loan'] = '';
        $data['color9'] = '';
        if ($x2 != '') {
            $data['Repayment_rate_of_cluster_loan'] = (($x2 >= 95 ? 10 : ($x2 >= 85 ? 7 : ($x2 >= 70 ? 5 : 2))));

        } else {

            $data['Repayment_rate_of_cluster_loan'] = (($totalMonths <= 1 ? 10 : ($totalMonths <=2 ? 5 : ($totalMonths > 3 ? 0 : 0))));

        }
        //analysis 13
        $x2 = (str_replace('%', '', $analysis[0]->Cluster_loan_PAR));
        $data['Cluster_loan_PAR'] = '';
        $data['color10'] = '';
        if ($x2 != '') {
            if ($x2 == 0) {
                $data['Cluster_loan_PAR'] = 10;
            }
            if ($x2 >= 1 && $x2 <= 5) {
                $data['Cluster_loan_PAR'] = 7;
            }
            if ($x2 >= 6 && $x2 <= 10) {
                $data['Cluster_loan_PAR'] = 5;
            }
            if ($x2 > 10) {
                $data['Cluster_loan_PAR'] = 2;
            }
        } else {
            $data['Cluster_loan_PAR'] = 0;
        }
        //analysis 14
        $x2 = $analysis[0]->Percentage_members_assisted_more_than_one;
        $data['Percentage_members_assisted_more_than_one'] = '';
        if ($x2 != '') {
            $data['Percentage_members_assisted_more_than_one'] = (($x2 >= 75 ? 5 : ($x2 >= 50 ? 4 : ($x2 >= 25 ? 3 : 1))));

        } else {
            $data['Percentage_members_assisted_more_than_one'] = 0;
        }
        //analysis 15
        $x2 = $analysis[0]->Percentage_Livelihood_purposes;
        $data['Percentage_Livelihood_purposes'] = '';
        if ($x2 != '') {
            $data['Percentage_Livelihood_purposes'] = (($x2 >= 90 ? 5 : ($x2 >= 75 ? 4 : ($x2 >= 60 ? 3 : 1))));

        } else {
            $data['Percentage_Livelihood_purposes'] = 0;
        }




        //analysis 16

        $total_member = (int) $profile[0]->total_members;
        $data['Percentage_of_the_cluster'] = '';

        $x2 = $analysis[0]->Percentage_of_the_cluster;
        if ($x2 != '') {
            $data['Percentage_of_the_cluster'] = (($x2 >= 90 ? 10 : ($x2 >= 75 ? 7 : ($x2 >= 60 ? 4 : 2))));

        } else {
            $data['Percentage_of_the_cluster'] = 0;
        }

        // analysis 17
        $lsf = (int) $saving[0]->members;
        $data['compulsory_savings'] = '';
        $count12 = '';
        if ($total_member > 0) {
            $res12 = ($lsf / $total_member) * 100;
            $count12 = round($res12, 2);
        }
        //prd($count12);
        if ($count12 != '') {
            $data['compulsory_savings'] = (($count12 >= 90 ? 5 : ($count12 >= 75 ? 4 : ($count12 >= 60 ? 3 : 1))));
        } else {
            $data['compulsory_savings'] = 0;
        }

        $data['total1'] = (float) $data['Average_participation_of'] + (float) $data['Cluster_Book_updation'] + (float) $data['Percentage_of_Defunct'] + (float) $data['External_audit_completed'] + (float) $data['analysis_1'];

        $data['total2'] = (float) $data['poor_current_leadership'] + (float) $data['Percentage_of_poorest_benefiting_from_all_loans'] + (float) $data['Representation_of_Poorest'];

        $data['total3'] = (float) $data['Cluster_is_covering_its'] + (float) $data['Time_taken_to_disburse'] + (float) $data['time_taken_to_approve_loan'];

        $data['total4'] = (float) $data['Repayment_rate_of_cluster_loan'] + (float) $data['Cluster_loan_PAR'] + (float) $data['Percentage_members_assisted_more_than_one'] + (float) $data['Percentage_Livelihood_purposes'];

        $data['total5'] = (float) $data['Percentage_of_the_cluster'] + (float) $data['compulsory_savings'];


        $data['grand_total'] = $data['total1'] + $data['total2'] + $data['total3'] + $data['total4'] + $data['total5'];


        return $data;


    }
}
