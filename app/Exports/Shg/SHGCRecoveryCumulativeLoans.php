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


class SHGCRecoveryCumulativeLoans implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
{

    public $curdate = '';
    public $counter = 1;
    public function __construct()
    {
        $this->curdate = Carbon::now()->format('d-m-Y');
    }

    public function collection()
    {

        // dd("receh");
        $user = Auth::user();
        $session_data = Session::get('shg_export_session');
        // prd($session_data);

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
        sc.interest_charged,
        sc.percent_charged,
        si.no_of_visual_poorest AS `No_of_Poorest_and_Vulnerable_Members`,
        si.no_of_visual_poor AS `Number_of_Poor_members`,
        si.no_of_visual_medium_poor AS `Number_of_medium_poor`,
        si.no_of_visual_rich AS `Number_of_Rich`,
        SUM(sc.no_of_internal_poorest +
            sc.no_of_external_poorest +
            sc.no_of_vi_poorest +
            sc.no_of_bank_external_poorest +
            sc.no_of_other_external_poorest +
            sc.no_of_internal_poor +
            sc.no_of_external_poor +
            sc.no_of_vi_poor +
            sc.no_of_bank_external_poor +
            sc.no_of_other_external_poor +
            sc.no_of_internal_medium +
            sc.no_of_external_medium +
            sc.no_of_vi_medium +
            sc.no_of_other_external_medium +
            sc.no_of_bank_external_medium +
            sc.no_of_internal_rich +
            sc.no_of_external_rich +
            sc.no_of_vi_rich +
            sc.no_of_other_external_rich +
            sc.no_of_bank_external_rich) AS total_loans,
            SUM(sc.no_of_internal_poorest_amount +
            sc.no_of_external_poorest_amount +
            sc.no_of_vi_poorest_amount +
            sc.no_of_bank_external_poorest_amount +
            sc.no_of_other_external_poorest_amount +
            sc.no_of_internal_poor_amount +
            sc.no_of_external_poor_amount +
            sc.no_of_vi_poor_amount +
            sc.no_of_bank_external_poor_amount +
            sc.no_of_other_external_poor_amount +
            sc.no_of_internal_medium_amount +
            sc.no_of_external_medium_amount +
            sc.no_of_vi_medium_amount +
            sc.no_of_other_external_medium_amount +
            sc.no_of_bank_external_medium_amount +
            sc.no_of_internal_rich_amount +
            sc.no_of_external_rich_amount +
            sc.no_of_vi_rich_amount +
            sc.no_of_other_external_rich_amount +
            sc.no_of_bank_external_rich_amount) AS total_loans_amount,

            sc.no_of_internal_poorest AS internal_very_poor,
            sc.no_of_internal_poor AS internal_poor,
            sc.no_of_internal_medium AS internal_medium,
            sc.no_of_internal_rich AS internal_rich,
            sc.no_of_internal_poorest_amount AS internal_very_poor_amount,
            sc.no_of_internal_poor_amount AS internal_poor_amount,
            sc.no_of_internal_medium_amount AS internal_medium_amount,
            sc.no_of_internal_rich_amount AS internal_rich_amount,

            sc.no_of_external_poorest AS fed_very_poor,
            sc.no_of_external_poor AS fed_poor,
            sc.no_of_external_medium AS fed_medium,
            sc.no_of_external_rich AS fed_rich,
            sc.no_of_external_poorest_amount AS fed_very_poor_amount,
            sc.no_of_external_poor_amount AS fed_poor_amount,
            sc.no_of_external_medium_amount AS fed_medium_amount,
            sc.no_of_external_rich_amount AS fed_rich_amount,

            sc.no_of_bank_external_poorest AS bank_very_poor,
            sc.no_of_bank_external_poor AS bank_poor,
            sc.no_of_bank_external_medium AS bank_medium,
            sc.no_of_bank_external_rich AS bank_rich,
            sc.no_of_bank_external_poorest_amount AS bank_very_poor_amount,
            sc.no_of_bank_external_poor_amount AS bank_poor_amount,
            sc.no_of_bank_external_medium_amount AS bank_medium_amount,
            sc.no_of_bank_external_rich_amount AS bank_rich_amount,

            sc.no_of_other_external_poorest AS other_very_poor,
            sc.no_of_other_external_poor AS other_poor,
            sc.no_of_other_external_medium AS other_medium,
            sc.no_of_other_external_rich AS other_rich,
            sc.no_of_other_external_poorest_amount AS other_very_poor_amount,
            sc.no_of_other_external_poor_amount AS other_poor_amount,
            sc.no_of_other_external_medium_amount AS other_medium_amount,
            sc.no_of_other_external_rich_amount AS other_rich_amount,

            sc.cumulative_internal_interest AS internal_intrest_total,
            sc.cumulative_federation_interest AS federation_intrest_total,
            sc.cumulative_bank_interest AS bank_intrest_total,
            sc.cumulative_other_interest AS other_intrest_total,
            sc.total_cumulative_interest as total_intrest
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
            INNER JOIN shg_creditrecovery AS sc
            ON sc.shg_sub_mst_id = s.id
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
        $shgs = DB::select($query);
        // prd($shgs);
        return collect($shgs);
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

            $res->interest_charged,
            $res->percent_charged,

            $res->No_of_Poorest_and_Vulnerable_Members,
            $res->Number_of_Poor_members,
            $res->Number_of_medium_poor,
            $res->Number_of_Rich,
            $res->total_loans,
            $res->total_loans_amount,

            $res->internal_very_poor,
            $res->internal_poor,
            $res->internal_medium,
            $res->internal_rich,
            $res->internal_very_poor_amount,
            $res->internal_poor_amount,
            $res->internal_medium_amount,
            $res->internal_rich_amount,

            $res->fed_very_poor,
            $res->fed_poor,
            $res->fed_medium,
            $res->fed_rich,
            $res->fed_very_poor_amount,
            $res->fed_poor_amount,
            $res->fed_medium_amount,
            $res->fed_rich_amount,

            $res->bank_very_poor,
            $res->bank_poor,
            $res->bank_medium,
            $res->bank_rich,
            $res->bank_very_poor_amount,
            $res->bank_poor_amount,
            $res->bank_medium_amount,
            $res->bank_rich_amount,

            $res->other_very_poor,
            $res->other_poor,
            $res->other_medium,
            $res->other_rich,
            $res->other_very_poor_amount,
            $res->other_poor_amount,
            $res->other_medium_amount,
            $res->other_rich_amount,

            $res->internal_intrest_total,
            $res->federation_intrest_total,
            $res->bank_intrest_total,
            $res->other_intrest_total,
            $res->total_intrest,



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
                $event->sheet->getStyle('A1:BA1')->applyFromArray([
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
                'Name of SHG',
                'Risk Rating',
                'NRLM Code',
                'Cluster Name',
                'Federation Name',
                'Name of Village',
                'Interest Type charged by SHG',
                'Interest rate charged by SHG',
                'No of Poorest and Vulnerable Members',
                'Number of Poor members',
                'Number of medium poor',
                'Number of Rich',
                'Total No. Of Loans Disbursed - last 3 years',
                'Total Amount Disbursed - last 3 years',
                'Internal loans Cumulative No. in last 3 years - Very Poor category',
                'Internal loans Cumulative No. in last 3 years  -  Poor category',
                'Internal loans Cumulative No. in last 3 years  - Medium category',
                'Internal loans Cumulative No. in last 3 years  - Rich category',
                'Internal loans Cumulative Amount in last 3 years  - Very Poor category',
                'Internal loans Cumulative Amount in last 3 years -  Poor category',
                'Internal loans Cumulative Amount in last 3 years - Medium category',
                'Internal loans Cumulative Amount in last 3 years   - Rich category',
                'Federation/ Cluster loans Cumulative No. in last 3 years  - Very Poor category',
                'Federation/Cluster  loans Cumulative No. in last 3 years  - Poor category',
                'Federation/Cluster  loans Cumulative No. in last 3 years - Medium Category',
                'Federation/Cluster  loans Cumulative No. in last 3 years  - Rich Category',
                'Federation/Cluster  loans Cumulative Amount in last 3 years - Very Poor category',
                'Federation/Cluster  loans Cumulative Amount in last 3 years - Poor Category',
                'Federation/Cluster  loans Cumulative Amount in last 3 years - Medium Category',
                'Federation/Cluster  loans Cumulative Amount in last 3 years - Rich Category',
                'Bank loans Cumulative No. in last 3 years - Very Poor category',
                'Bank loans Cumulative No. in last 3 years - Poor category',
                'Bank loans Cumulative No. in last 3 years - Medium Category',
                'Bank  loans Cumulative No. in last 3 years  - Rich Category',
                'Bank loans Cumulative Amount in last 3 years - Very Poor category',
                'Bank loans Cumulative Amount in last 3 years - Poor Category',
                'Bank loans Cumulative Amount in last 3 years - Medium Category',
                'Bank loans Cumulative Amount in last 3 years - Rich Category',
                'Other  loans Cumulative No. in last 3 years - Very Poor category',
                'Other loans Cumulative No. in last 3 years - Poor category',
                'Other loans Cumulative No. in last 3 years - Medium Category',
                'Other loans Cumulative No. in last 3 years  - Rich Category',
                'Other  loans Cumulative Amount in last 3 years - Very Poor category',
                'Other loans Cumulative Amount in last 3 years - Poor Category',
                'Other loans Cumulative Amount in last 3 years - Medium Category',
                'Other loans Cumulative Amount in last 3 years - Rich Category',
                'Cumulative Interest Income - Internal Loan',
                'Cumulative Interest Income - Federation Loan',
                'Cumulative Interest Income - Bank Loan',
                'Cumulative Interest Income - Other Loan',
                'Cumulative Interest Income - Total'
            ]
        ];
    }

    public function title(): string
    {
        return 'SHG Cumulative loans';
    }
}
