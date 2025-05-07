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


class SHGInclusionBasic implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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

        $isClusterSelected = !empty($session_data['cluster']);

        $query = "SELECT
        s.id,
        s.uin AS uin ,
        sp.shgName AS shg_name,
        sp.analysis_rating AS Risk_Rating,
        sp.shg_code AS NRLM_code,
        cp.name_of_cluster AS cluster_name,
        fedp.name_of_federation AS federation_name,
        sp.village AS village,
        si.wealth_ranking  AS `Wealth_ranking_poverty_mapping`,
        si.poverty_mapping_date  AS `Date_of_1st_Poverty_mapping`,
        si.wealth_last_update_date AS `Date_of_last_update`,
        sp.current_members AS `Current_members`,
        si.no_of_visual_poorest AS `No_of_Poorest_and_Vulnerable_Members`,
        si.no_of_visual_poor AS `Number_of_Poor_members`,
        si.no_of_visual_medium_poor AS `Number_of_medium_poor`,
        si.no_of_visual_rich AS `Number_of_Rich`,
        si.no_of_sc_caste AS `Number_of_SC_ST`,
        si.no_of_obc_caste AS `Number_of_OBC`,
        si.no_of_other_caste AS `Number_of_others`,
        si.no_of_leadership_poor AS `Number_of_poor_poorest_in_current_office_bearer_position`,
        si.is_service_for_poor AS `Have_service_or_product_for_poorest_and_Vulnerable_members`,
        si.service_for_poor AS `TYPE_service_product`,
        si.no_of_member_benefited_service AS `Members_benfettied_from_service_during_last_12_months`,
        si.result_of_service AS `Result_or_impact_of_service`

     FROM
        shg_mst AS s 
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN shg_inclusion AS si
        ON si.shg_sub_mst_id = s.id
        WHERE s.is_deleted = 0 ";

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
            $res->Risk_Rating,
            $res->NRLM_code,
            $res->cluster_name,
            $res->federation_name,
            $res->village,
            $res->Wealth_ranking_poverty_mapping,
            $res->Date_of_1st_Poverty_mapping,
            $res->Date_of_last_update,
            $res->Current_members,
            $res->No_of_Poorest_and_Vulnerable_Members,
            $res->Number_of_Poor_members,
            $res->Number_of_medium_poor,
            $res->Number_of_Rich,
            $res->Number_of_SC_ST,
            $res->Number_of_OBC,
            $res->Number_of_others,
            $res->Number_of_poor_poorest_in_current_office_bearer_position,
            $res->Have_service_or_product_for_poorest_and_Vulnerable_members,
            $res->TYPE_service_product,
            $res->Members_benfettied_from_service_during_last_12_months,
            $res->Result_or_impact_of_service
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
                $event->sheet->getStyle('A1:X1')->applyFromArray([
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
                'NRLM Code',
                'Cluster Name',
                'Federation Name',
                'Name Of Village',
                'Wealth Ranking/Poverty Mapping',
                'If Yes, Date Of 1st Poverty Mapping',
                'Date Of Last Update ( in 12 months)',
                'Current Members',
                'No Of Poorest and Vulnerable Members',
                'Number of Poor members',
                'Number Of Medium Poor',
                'Number Of Rich',
                'Number Of SC/ST',
                'Number Of OBC',
                'Number Of Others',
                'Number Of Poor & Poorest in Current Office Bearer Position',
                'does SHG Have Service or Product For Poorest and Vulnerable Members',
                'If Yes, Type - Service/Product',
                'How Many Members Benfettied  From Service During Last 12 Months',
                'Result or Impact  Of Service'
            ]
        ];
    }

    public function title(): string
    {
        return 'SHG Inclusion Basic';
    }
}
