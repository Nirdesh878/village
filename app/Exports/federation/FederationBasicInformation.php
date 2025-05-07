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


class FederationBasicInformation implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        fedp.id,
        fed.uin AS uin ,
        fedp.name_of_federation AS federattion_name,
        fedp.analysis_rating AS risk_rating,
        fedp.clf_code AS NRLM_code,
        fedp.name_of_district AS district_name,
        fedp.name_of_state AS state_name,
        ag.agency_name AS ajency_name,
        fedp.date_federation_was_found AS date_of_registration,
        fedp.registration_no AS registration_no,
        fedp.legal_status AS `legal_status`,
        fedp.clusters_at_time_creation AS `clusters_at_time`,
        fedp.shg_at_time_creation AS `shg_at_time_creation`,
        fedp.members_at_time_creation AS `members_at_time_creation`,
        fedp.total_clusters AS `current_cluster`,
        fedp.total_SHGs AS `current_shg`,
        fedp.total_members AS `current_member`,
        fedp.president AS `Current_leadership_president`,
        fedp.secretary AS `Current_leadership_secretary`,
        fedp.Treasurer AS `Current_leadership_treasurert`,
        fedp.book_keeper_name AS `Current_book_keeper_name`,
        fedp.date_of_appointment AS `Date_of_Appointment`,
        JSON_LENGTH(Federation_Bank_ac) AS no_of_bank_account,
        JSON_UNQUOTE(JSON_EXTRACT(Federation_Bank_ac, '$[0].account_number')) AS bank_account_1_number,
        JSON_UNQUOTE(JSON_EXTRACT(Federation_Bank_ac, '$[1].account_number')) AS bank_account_2_number,
        JSON_UNQUOTE(JSON_EXTRACT(Federation_Bank_ac, '$[2].account_number')) AS bank_account_3_number

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

         // $query .="  GROUP BY s.id
         // ";
        // prd($query);
        $federation = DB::select($query);
        //  prd($federation);
        return collect($federation);
    }

    public function map($res): array
    {


            return [
                $this->counter++,
                $res->uin,
                $res->federattion_name,
                $res->risk_rating,
                $res->NRLM_code,
                $res->district_name,
                $res->state_name,
                $res->ajency_name,

        (string)$res->date_of_registration,
        (string)$res->registration_no,
        (string)$res->legal_status,
        (string)$res->clusters_at_time,
        (string)$res->shg_at_time_creation,
        (string)$res->members_at_time_creation,
        (string)$res->current_cluster,
        (string)$res->current_shg,
        (string)$res->current_member,
        (string)$res->Current_leadership_president,
        (string)$res->Current_leadership_secretary,
        (string)$res->Current_leadership_treasurert,
        (string)$res->Current_book_keeper_name,
        (string)$res->Date_of_Appointment,
        (string)$res->no_of_bank_account,
        (string)$res->bank_account_1_number,
        (string)$res->bank_account_2_number,
        (string)$res->bank_account_3_number


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
                $event->sheet->getStyle('A1:Z1')->applyFromArray([
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


            'Date of Registration',
            'Registration No',
            'Legal Status',
            'Clusters At Time Of Formation',
            'SHGs At Time Of Formation',
            'Members At Time Of Formation',
            'Current Clusters',
            'Current SHGs',
            'Current Members',
            'Current Leadership Names - President',
            'Current Leadership Names - Secretary',
            'Current Leadership Names - Treasurer',
            'Current Book- Keeper',
            'Date Of Appointment',
            'No Of Bank Accounts',
            'Bank Account 1',
            'Bank Account 2',
            'Bank Account 3'
            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Basic Information';
    }
}
