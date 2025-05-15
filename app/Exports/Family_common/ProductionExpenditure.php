<?php

namespace App\Exports\Family;

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


class ProductionExpenditure implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $session_data = Session::get('family_export_session');

        $isClusterSelected = !empty($session_data['cluster']);

        $query = "SELECT
        f.id,
        f.uin,
        fp.fp_member_name,
        sp.shgName,
        cp.name_of_cluster,
        fedp.name_of_federation,
        fp.fp_wealth_rank,
        fp.analysis_rating,
        SUM(CASE WHEN e_type = 'Seeds' THEN e_total_amount ELSE 0 END ) AS Seeds,
        SUM(CASE WHEN e_type = 'Irrigation' THEN e_total_amount ELSE 0 END ) AS Irrigation,
        SUM(CASE WHEN e_type = 'Pesticides' THEN e_total_amount ELSE 0 END ) AS Pesticides,
        SUM(CASE WHEN e_type = 'Fertilizer' THEN e_total_amount ELSE 0 END ) AS Fertilizer,
        SUM(CASE WHEN e_type = 'Tractor/machines' THEN e_total_amount ELSE 0 END ) AS Tractor_machines,
        SUM(CASE WHEN e_type = 'Labor' THEN e_total_amount ELSE 0 END ) AS Labor,
        SUM(CASE WHEN e_type = 'Feed' THEN e_total_amount ELSE 0 END ) AS Feed,
        SUM(CASE WHEN e_type = 'Fodder (if livestock)' THEN e_total_amount ELSE 0 END ) AS Fodder,
        SUM(CASE WHEN e_type = 'Vet/health (if livestock)' THEN e_total_amount ELSE 0 END ) AS Vet_health,
        SUM(CASE WHEN e_type = 'Asset insurance' THEN e_total_amount ELSE 0 END ) AS asset_insurance,
        SUM(CASE WHEN e_sub_type = 'Other' THEN e_total_amount ELSE 0 END ) AS Other,
        SUM(e_total_amount) AS total
     FROM
      family_mst AS f 
        INNER JOIN family_profile AS fp ON f.id = fp.family_sub_mst_id
        INNER JOIN shg_mst AS s ON f.shg_uin = s.uin
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN family_expenditure_this_year AS fe
        ON f.id = fe.family_sub_mst_id

     WHERE s.is_deleted = 0 AND f.is_deleted = 0 AND fe.e_cat = 'Production/Business Expenses'";

        if ($isClusterSelected) {
            $query .= " AND c.is_deleted = 0 ";
        }

        if (!empty($session_data['Search'])) {
            if (!empty($session_data['agency'])) {
                $agency = $session_data['agency'];
                $query .= " AND f.agency_id = $agency  ";
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
            if (!empty($session_data['family'])) {
                $query .= " AND f.uin = '" . $session_data['family'] . "' ";
            }
        }
        $query .= " GROUP BY f.id  ORDER BY f.id
         ";
        // prd($query);
        $familys = DB::select($query);
        // prd($familys);
        return collect($familys);
    }

    public function map($res): array
    {

        $WealthData = getMstCommonData(7,$res->fp_wealth_rank);
        $wealthName = $WealthData->isNotEmpty() ? $WealthData[0]->common_values : 'N/A';

        return [
            $this->counter++,
            $res->uin,
            $res->fp_member_name,
            $res->shgName,
            $res->name_of_cluster,
            $res->name_of_federation,
            $wealthName,
            $res->analysis_rating,

            $res->Seeds,
            $res->Irrigation,
            $res->Pesticides,
            $res->Fertilizer,
            $res->Tractor_machines,
            $res->Labor,
            $res->Feed,
            $res->Fodder,
            $res->Vet_health,
            $res->asset_insurance,
            $res->Other,
            $res->total,


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
                $event->sheet->getStyle('A1:T1')->applyFromArray([
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
                'SHG MEMBER NAME',
                'NAME OF SHG',
                'CLUSTER NAME ',
                'FEDERATION NAME',
                'WEALTH/POVERTY RANKING',
                'RISK RATING/SCORE CARD',

                'Seeds',
                'Irrigation',
                'Pesticides',
                'Fertilizer',
                'Tractor/Machines',
                'Labor',
                'Feed',
                'Fodder',
                'Vet_health',
                'asset_insurance',
                'Other',
                'Total PRODUCTION/BUSINESS (amount)'
            ]
        ];
    }

    public function title(): string
    {
        return 'Production/Business Expenditure';
    }
}
