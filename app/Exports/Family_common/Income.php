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


class Income implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        fp.fp_earning_an_income AS members,
        fi.agriculture AS agriculture,
        fi.livestock AS livestock,
        fi.horticulture AS horticulture ,
        fi.fixed_income_amount AS fixed_income_amount,
        fi.casual_income_amount AS  SEASONAL_INCOME,
        fi.trade_income_amount AS TRADE_BUSINESS,
        fi.money_lending,
        fi.pension_income_monthly AS PENSION ,
        fi.other_income AS OTHETR_INCOME,
        (COALESCE(fi.agriculture,0) +
        COALESCE(fi.livestock,0) +
        COALESCE(fi.horticulture,0) +
        COALESCE(fi.fixed_income_amount,0) +
        COALESCE(fi.casual_income_amount,0) +
        COALESCE(fi.trade_income_amount,0) +
        COALESCE(fi.money_lending,0)+
        COALESCE(fi.pension_income_monthly,0)+
        COALESCE(fi.other_income,0)) AS Total_Income,
        fmi.earning_description AS Earning_Description 
        --  fi.e_total_amount AS Total_Income
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
        INNER JOIN family_income_this_year AS fi
        ON f.id = fi.family_sub_mst_id
        LEFT JOIN family_member_information AS fmi
        ON f.id = fmi.family_sub_mst_id


     WHERE  s.is_deleted = 0 AND f.is_deleted = 0 ";

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
            $res->members,
            $res->agriculture,
            $res->livestock,
            $res->horticulture,
            $res->fixed_income_amount,
            $res->SEASONAL_INCOME,
            $res->TRADE_BUSINESS,
            $res->money_lending,
            $res->PENSION,
            $res->OTHETR_INCOME,
            $res->Total_Income,
            $res->Earning_Description,

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
                'TOTAL MEMBERS EARNING',
                'AGRICULTURE (amount)',
                'LIVESTOCK (amount)',
                'HORTICULTURE (amount)',
                'TOTAL FIXED INCOME FOR WHOLE FAMILY- (amount)',
                'TOTAL SEASONAL  INCOME FOR WHOLE FAMILY (amount)',
                'TRADE BUSINESS (amount)',
                'INCOME FROM MONEY -LENDING',
                'TOTAL PENSION FOR WHOLE FAMILY (amount)',
                'TOTAL OTHERS INCOME FOR WHOLE FAMILY0,', 
                'TOTAL INCOME  (amount)',
                'Earning Description'
            ]
        ];
    }

    public function title(): string
    {
        return 'Family Income';
    }
}
