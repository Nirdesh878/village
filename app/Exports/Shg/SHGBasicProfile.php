<?php

namespace App\Exports\Shg;

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


class SHGBasicProfile implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $session_data = Session::get('shg_export_session');
        // prd($session_data);

        $isClusterSelected = !empty($session_data['cluster']);

        $query = "SELECT
        s.id,
        s.uin AS uin ,
        sp.shgName AS shg_name,
        sp.analysis_rating AS risk_rating,
        sp.shg_code AS NRLM_code,
        cp.name_of_cluster AS cluster_name,
        fedp.name_of_federation AS federation_name,
        sp.village AS village,
        sp.formed AS date_formed,
        sp.members_at_creation AS `Members_at_time_of_creation`,
        sp.current_members AS `Current_Members`,
        sp.members_left AS `Memebers_left_since_creation`,
        sp.members_neighborhood AS `Members_from_same_neighbourhood`,
        sp.president AS `Current_leadership_names_President`,
        sp.secretary AS `Current_eadership_names_Secretary1`,
        sp.treasure AS `Current_leadership_names_Treasurer2`,
        sp.book_keeper_name AS `Current_Book_Keeper`,
        sp.book_keeper_date AS `Date_of_Appointment`,
        case when sp.shg_basicProfile_restructured !='' then 'Yes' ELSE 'No' END  AS `SHG_restructured_Yes_or_No`,
        case when sp.shg_basicProfile_restructured !='' then sp.shg_basicProfile_restructured ELSE '' END  AS `SHG_restructured`,
        ag.agency_name AS `Which_agency_formed_the_SHG`
     FROM
        shg_mst AS s 
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN agency AS ag
        ON s.agency_id = ag.agency_id
        WHERE s.is_deleted = 0";

        if ($isClusterSelected) {
            $query .= " AND c.is_deleted = 0 ";
        }

        if (!empty($session_data['Search'])) {
            if (!empty($session_data['agency'])) {
                $agency = $session_data['agency'];
                $query .= " AND s.agency_id = $agency  ";
            }
            if (!empty($session_data['federation'])) {
                $query .= " AND fed.uin = '" . $session_data['federation'] . "' ";
            }
            if (!empty($session_data['cluster'])) {
                $query .= " AND c.uin = '" . $session_data['cluster'] . "' ";
            }
            if (!empty($session_data['shg'])) {
                $query .= " AND s.uin = '" . $session_data['shg'] . "' ";
            }
        }

        $query .= "  GROUP BY s.id
         ";
        // prd($query);
        $familys = DB::select($query);
        // prd($familys);
        return collect($familys);
    }

    public function map($res): array
    {


        return [
            $this->counter++,
            $res->uin,
            $res->shg_name,
            $res->risk_rating,
            $res->NRLM_code,
            $res->cluster_name,
            $res->federation_name,
            $res->village,
            $res->date_formed,
            $res->Members_at_time_of_creation,
            $res->Current_Members,
            $res->Memebers_left_since_creation,
            $res->Members_from_same_neighbourhood,
            $res->Current_leadership_names_President,
            $res->Current_eadership_names_Secretary1,
            $res->Current_leadership_names_Treasurer2,
            $res->Current_Book_Keeper,
            $res->Date_of_Appointment,
            $res->SHG_restructured_Yes_or_No,
            $res->SHG_restructured,
            $res->Which_agency_formed_the_SHG

        ];
    }

    public function columnFormats(): array
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:U1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'color' => ['argb' => '#CCCCCC']
                    ]
                ]);
            },
        ];
    }

    public function headings(): array
    {
        return [

            [
                'S.No',
                'UIN',
                'Name Of SHG',
                'Risk Rating',
                'NRLM Code ',
                'Cluster Name',
                'Federation Name',
                'Name Of Village',
                'Date Formed',
                'Members At Time Of Creation',
                'Current Members',
                'Memebers Left Since Creation',
                'Members From Same Neighbourhood',
                'Current Leadership Names - President/Animator',
                'Current Leadership Names - Secretary/ Representative 1',
                'Current Leadership Names - Treasurer/Representative 2',
                'Current Book- Keeper',
                'Date Of Appointment',
                'SHG Restructured? Yes Or No',
                'If Yes - Restructred Date',
                'Which Agency Formed The SHG'
            ]
        ];
    }

    public function title(): string
    {
        return 'SHG Basic Profile';
    }
}
