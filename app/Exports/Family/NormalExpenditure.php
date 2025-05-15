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


class NormalExpenditure implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        SUM(CASE WHEN e_type = 'Food/grocery' THEN e_total_amount ELSE 0 END ) AS food,
        SUM(CASE WHEN e_type = 'House rent/lease' THEN e_total_amount ELSE 0 END ) AS house_rent,
        SUM(CASE WHEN e_type = 'House repair, if any' THEN e_total_amount ELSE 0 END ) AS house_repair,
        SUM(CASE WHEN e_type = 'Education' THEN e_total_amount ELSE 0 END ) AS Education,
        SUM(CASE WHEN e_type = 'Health/medical' THEN e_total_amount ELSE 0 END ) AS Health,
        SUM(CASE WHEN e_type = 'Gas (if they have gas connection)' THEN e_total_amount ELSE 0 END ) AS Gas,
        SUM(CASE WHEN e_type = 'Water charges' THEN e_total_amount ELSE 0 END ) AS Water_Charges,
        SUM(CASE WHEN e_type = 'Electricity (if they have power)' THEN e_total_amount ELSE 0 END ) AS Electricity,
        SUM(CASE WHEN e_type = 'Cable tv/dish' THEN e_total_amount ELSE 0 END ) AS Cable_Dish,
        SUM(CASE WHEN e_type = 'Internet/wifi' THEN e_total_amount ELSE 0 END ) AS Internet_wifi,
        SUM(CASE WHEN e_type = 'Phone (mobile)' THEN e_total_amount ELSE 0 END ) AS Phone,
        SUM(CASE WHEN e_type = 'Clothes' THEN e_total_amount ELSE 0 END ) AS Clothes,
        SUM(CASE WHEN e_type = 'Entertainment e.g. cinema, eating out, etc' THEN e_total_amount ELSE 0 END ) AS Entertainment,
        SUM(CASE WHEN e_type = 'Petrol (if they have car/motorbike, etc)' THEN e_total_amount ELSE 0 END ) AS Petrol,
        SUM(CASE WHEN e_type = 'Motorbike/bike repair' THEN e_total_amount ELSE 0 END ) AS bike_repair,
        SUM(CASE WHEN e_type = 'Insurance (if any specify)' THEN e_total_amount ELSE 0 END ) AS Insurance,
        SUM(CASE WHEN e_type = 'Transportation (if they use public transportation bus, etc or train/air)' THEN e_total_amount ELSE 0 END ) AS transpotation,
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

     WHERE  s.is_deleted = 0 AND f.is_deleted = 0 AND fe.e_cat = 'Normal Expenditure'";

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

            $res->food,
            $res->house_rent,
            $res->house_repair,
            $res->Education,
            $res->Health,
            $res->Gas,
            $res->Water_Charges,
            $res->Electricity,
            $res->Cable_Dish,
            $res->Internet_wifi,
            $res->Phone,
            $res->Clothes,
            $res->Entertainment,
            $res->Petrol,
            $res->bike_repair,
            $res->Insurance,
            $res->transpotation,
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
                $event->sheet->getStyle('A1:AA1')->applyFromArray([
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

                'Food/Grocery',
                'House Rent/lease',
                'House repair',
                'Education',
                'Health Medical',
                'Gas',
                'Water Charges',
                'Electricity',
                'Cable TV /Dish',
                'Internet wifi',
                'Phone',
                'Clothes',

                'Entertainment',
                'Petrol',
                'Motorbike/bike repair',
                'Insurance',
                'Transportation',
                'Other',
                'TOTAL NORMAL  (amount)'
            ]
        ];
    }

    public function title(): string
    {
        return 'Normal Expenditure';
    }
}
