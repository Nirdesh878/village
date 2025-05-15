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


class Agriculture implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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

        $query = "WITH Rankes AS (SELECT
            f.id,
            f.uin, 
            fp.fp_member_name,
            fp.fp_wealth_rank,
            sp.shgName,
            cp.name_of_cluster,
            fedp.name_of_federation,
            fp.analysis_rating,
            fas.fa_land_type,
            fas.fa_total_land_owned,
            fa.crop,
            fa.production_quantity_type,
            fa.production_per_year,
            fa.no_of_season,
            fa.consumption,
            fa.sold_in_year,
            fa.price_per_unit,
            fa.total_sale_value,
            ROW_NUMBER() OVER (PARTITION BY f.id ORDER BY fa.id) AS agriculture
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
            INNER JOIN family_assets AS fas
            ON f.id = fas.family_sub_mst_id
            LEFT JOIN family_agriculture_production_this_year AS fa
            ON f.id = fa.family_sub_mst_id
            WHERE  s.is_deleted = 0 AND f.is_deleted = 0 AND fa.production_type ='Agriculture'  ";

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

        $query .= " ORDER  BY f.id ) ";
        // prd($query);
        $query .= "SELECT
         agriculture,
             id,
             uin,
             fp_member_name,
             fp_wealth_rank,
             shgName,
             name_of_cluster,
             name_of_federation,
             analysis_rating,
             fa_land_type,
             fa_total_land_owned,
              MAX(CASE WHEN agriculture = 1 THEN crop END) AS crop1,
              MAX(CASE WHEN agriculture = 1 THEN production_quantity_type END) AS production_quantity_type1,
              MAX(CASE WHEN agriculture = 1 THEN production_per_year END) AS production_per_year1,
              MAX(CASE WHEN agriculture = 1 THEN no_of_season END) AS no_of_season1,
              MAX(CASE WHEN agriculture = 1 THEN consumption END) AS consumption1,
              MAX(CASE WHEN agriculture = 1 THEN sold_in_year END) AS sold_in_year1,
              MAX(CASE WHEN agriculture = 1 THEN price_per_unit END) AS price_per_unit1,
              MAX(CASE WHEN agriculture = 1 THEN total_sale_value END) AS total_sale_value1,
              MAX(CASE WHEN agriculture = 2 THEN crop END) AS crop2,
              MAX(CASE WHEN agriculture = 2 THEN production_quantity_type END) AS production_quantity_type2,
              MAX(CASE WHEN agriculture = 2 THEN production_per_year END) AS production_per_year2,
              MAX(CASE WHEN agriculture = 2 THEN no_of_season END) AS no_of_season2,
              MAX(CASE WHEN agriculture = 2 THEN consumption END) AS consumption2,
              MAX(CASE WHEN agriculture = 2 THEN sold_in_year END) AS sold_in_year2,
              MAX(CASE WHEN agriculture = 2 THEN price_per_unit END) AS price_per_unit2,
              MAX(CASE WHEN agriculture = 2 THEN total_sale_value END) AS total_sale_value2,
              MAX(CASE WHEN agriculture = 3 THEN crop END) AS crop3,
              MAX(CASE WHEN agriculture = 3 THEN production_quantity_type END) AS production_quantity_type3,
              MAX(CASE WHEN agriculture = 3 THEN production_per_year END) AS production_per_year3,
              MAX(CASE WHEN agriculture = 3 THEN no_of_season END) AS no_of_season3,
              MAX(CASE WHEN agriculture = 3 THEN consumption END) AS consumption3,
              MAX(CASE WHEN agriculture = 3 THEN sold_in_year END) AS sold_in_year3,
              MAX(CASE WHEN agriculture = 3 THEN price_per_unit END) AS price_per_unit3,
              MAX(CASE WHEN agriculture = 3 THEN total_sale_value END) AS total_sale_value3,
              SUM(total_sale_value) AS total_sale

               FROM Rankes
               GROUP BY id
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
            $res->fa_land_type,
            $res->fa_total_land_owned,
            $res->crop1,
            $res->production_quantity_type1,
            $res->production_per_year1,
            $res->no_of_season1,
            $res->consumption1,
            $res->sold_in_year1,
            $res->price_per_unit1,
            $res->total_sale_value1,

            $res->crop2,
            $res->production_quantity_type2,
            $res->production_per_year2,
            $res->no_of_season2,
            $res->consumption2,
            $res->sold_in_year2,
            $res->price_per_unit2,
            $res->total_sale_value2,

            $res->crop3,
            $res->production_quantity_type3,
            $res->production_per_year3,
            $res->no_of_season3,
            $res->consumption3,
            $res->sold_in_year3,
            $res->price_per_unit3,
            $res->total_sale_value3,

            $res->total_sale,


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
                $event->sheet->getStyle('A1:AI1')->applyFromArray([
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
                'LAND SIZE',
                'Total Land owned and cultivated',
                'CROP 1',
                'Production Qty (UNITS) 1',
                'Prod per YEAR 1',
                'No. Of Seasons 1',
                'Consumption 1',
                'Sold during the year 1',
                'Price per unit 1',
                'Total Sales (THIS YEAR) 1',

                'CROP 2',
                'Production Qty (UNITS) 2',
                'Prod per YEAR 2',
                'No. Of Seasons 2',
                'Consumption 2',
                'Sold during the year 2',
                'Price per unit 2',
                'Total Sales (THIS YEAR) 2',

                'CROP 3',
                'Production Qty (UNITS) 3',
                'Prod per YEAR 3',
                'No. Of Seasons 3',
                'Consumption 3',
                'Sold during the year 3',
                'Price per unit 3',
                'Total Sales (THIS YEAR) 3',
                'Total all sales'
            ]
        ];
    }

    public function title(): string
    {
        return 'Family Agriculture';
    }
}
