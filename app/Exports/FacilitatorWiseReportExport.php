<?php

namespace App\Exports;

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
use Carbon\Carbon;
class FacilitatorWiseReportExport implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
{
    public $curdate = '';
    public $counter = 1;
    public function __construct()
    {

        $this->curdate = Carbon::now()->format('d-m-Y');
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::user();
        $session_data = Session::get('facilitator_filter_session');
        $res = [];
        $main_query_where = '';
        $main_query_where_date = '';
            if (!empty($session_data['Search'])) {
                if (!empty($session_data['country']))
                    if ($session_data['country'] != '' && $session_data['country'] > 0)
                        $main_query_where .= " AND b.country_id = '" . $session_data['country'] . "' ";
                if (!empty($session_data['state']))
                    if ($session_data['state'] != '' && $session_data['state'] > 0)
                        $main_query_where .= " AND b.state_id = '" . $session_data['state'] . "' ";
                if (!empty($session_data['district']))
                    if ($session_data['district'] != '' && $session_data['district'] > 0)
                        $main_query_where .= " AND b.district_id = '" . $session_data['district'] . "' ";

                if (!empty($session_data['facilitator'])) {
                    $text_search = $session_data['facilitator'];
                    $group_type = $session_data['facilitator'];
                    $main_query_where .= " AND a.name LIKE '" . "%" . $session_data['facilitator'] . "%" . "' ";
                }

                if (trim($session_data['dt_from']) != '' && trim($session_data['dt_to']) != '' && isset($session_data['dt_from']) && isset($session_data['dt_to'])) {
                    $dt_from = change_date_format(trim($session_data['dt_from']));
                    $dt_to = change_date_format(trim($session_data['dt_to']));
                    $main_query_where_date .= " AND date(created_at) between '" . $dt_from . "' AND '" . $dt_to . "' ";
                }
            }
            
            $query = "SELECT
            id,
        fac_name,
        country_name,
        state_name,
        id AS st_id,
        district_name,
        user_id,
        state_id,
        SUM(total) as total,
        SUM(done) as done
        FROM
            (
            SELECT
                a.id,
                a.name AS fac_name,
                c.name AS country_name,
                d.name AS state_name,
                d.id AS st_id,
                e.name AS district_name
            FROM
                users a
            INNER JOIN user_location_relation b ON
                a.id = b.user_id
            INNER JOIN countries c ON
                b.country_id = c.id
            INNER JOIN states d ON
                b.state_id = d.id
            LEFT JOIN district e ON
                b.district_id = e.id
            WHERE
                a.u_type = 'F' AND a.is_deleted =0 $main_query_where
            GROUP BY
                a.id,
                d.id
        ) a
        LEFT JOIN(
            SELECT b.user_id,
                e.state_id,
                SUM(
                    CASE WHEN(b.status = 'P' || b.status = 'D') THEN 1 ELSE 0
                END
        ) AS total,
        SUM(
            CASE WHEN(b.status = 'D') THEN 1 ELSE 0
        END
        ) AS done
        FROM
            federation_mst a
        INNER JOIN federation_sub_mst d ON
            a.id = d.federation_mst_id
        INNER JOIN federation_profile e ON
            d.id = e.federation_sub_mst_id
        INNER JOIN(
            SELECT
                a.assignment_id,
                a.user_id,
                a.status
            FROM
                task_assignment a
            WHERE
                a.assignment_type = 'FD' AND a.is_deleted = 0 $main_query_where_date
        ) b
        ON
            a.id = b.assignment_id
        GROUP BY
            b.user_id,
            e.state_id
            UNION ALL
                SELECT b.user_id,
                e.state_id,
                SUM(
                    CASE WHEN(b.status = 'P' || b.status = 'D') THEN 1 ELSE 0
                END
        ) AS total,
        SUM(
            CASE WHEN(b.status = 'D') THEN 1 ELSE 0
        END
        ) AS done
        FROM
            cluster_mst a
        INNER JOIN cluster_sub_mst d ON
            a.id = d.cluster_mst_id
        INNER JOIN cluster_profile e ON
            d.id = e.cluster_sub_mst_id
        INNER JOIN(
            SELECT
                a.assignment_id,
                a.user_id,
                a.status
            FROM
                task_assignment a
            WHERE
                a.assignment_type = 'CL' AND a.is_deleted = 0 $main_query_where_date
        ) b
        ON
            a.id = b.assignment_id
        GROUP BY
            b.user_id,
            e.state_id
            UNION ALL
            SELECT b.user_id,
                e.state_id,
                SUM(
                    CASE WHEN(b.status = 'P' || b.status = 'D') THEN 1 ELSE 0
                END
        ) AS total,
        SUM(
            CASE WHEN(b.status = 'D') THEN 1 ELSE 0
        END
        ) AS done
        FROM
            shg_mst a
        INNER JOIN shg_sub_mst d ON
            a.id = d.shg_mst_id
        INNER JOIN shg_profile e ON
            d.id = e.shg_sub_mst_id
        INNER JOIN(
            SELECT
                a.assignment_id,
                a.user_id,
                a.status
            FROM
                task_assignment a
            WHERE
                a.assignment_type = 'SH' AND a.is_deleted = 0 $main_query_where_date
        ) b
        ON
            a.id = b.assignment_id
        GROUP BY
            b.user_id,
            e.state_id
         UNION ALL
                SELECT b.user_id,
                e.fp_state_id as state_id,
                SUM(
                    CASE WHEN(b.status = 'P' || b.status = 'D') THEN 1 ELSE 0
                END
        ) AS total,
        SUM(
            CASE WHEN(b.status = 'D') THEN 1 ELSE 0
        END
        ) AS done
        FROM
            family_mst a
        INNER JOIN family_sub_mst d ON
            a.id = d.family_mst_id
        INNER JOIN family_profile e ON
            d.id = e.family_sub_mst_id
        INNER JOIN(
            SELECT
                a.assignment_id,
                a.user_id,
                a.status
            FROM
                task_assignment a
            WHERE
                a.assignment_type = 'FM' AND a.is_deleted = 0 $main_query_where_date
        ) b
        ON
            a.id = b.assignment_id
        GROUP BY
            b.user_id,
            e.fp_state_id
        
        ) b
        ON
            a.id = b.user_id AND a.st_id = b.state_id
            GROUP BY
            a.id,
            b.state_id";
            $result = DB::select($query);
            //prd($result);

        return collect($result);

    }

    public function map($res): array
    {
        $total_task = '0';
        $done = '0';
        $pending = '0' ;
        if($res->total != '')
        {
            $total_task =  $res->total;
        }

        if($res->done != '')
        {
            $done =  $res->done;
        }
        if($total_task == $done)
        {
            $pending= '0';  
        }
        else{
            $pending= $total_task - $done;
        }
        
       
        return [
            $this->counter++,
            $res->country_name,
            $res->state_name,
            $res->fac_name,
            $total_task ,
            $done,
            $pending ,

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
                $event->sheet->getStyle('A1:A6')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'color' => ['argb' => '#CCCCCC' ]
                    ]
                ]);

                $event->sheet->getStyle('A8:G8')->applyFromArray([
                    'font' => ['bold' => true]
                ]);

            },
        ];
    }

    public function headings(): array
    {
        $session_data = Session::get('facilitator_filter_session');
        if (!empty($session_data)){
            return [
                ['Country',(getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']):"-")],
                ['State',(getStateName($session_data['country'],$session_data['state']) != '' ? getStateName($session_data['country'],$session_data['state']):"-")],
                ['District',(getDistrictName($session_data['state'],$session_data['district']) != '' ? getDistrictName($session_data['state'],$session_data['district']):"-")],
                ['Facilitator',($session_data['facilitator'] != '' ? $session_data['facilitator']: "-")],
                ['Date From',($session_data['dt_from'] != '' ? change_date_month_name_char(str_replace('/','-',$session_data['dt_from'])): "-")],
                ['Date To',($session_data['dt_to'] != '' ? change_date_month_name_char(str_replace('/','-',$session_data['dt_to'])): "-")],
                [],
                ['S.No','Country','State','Facilitator Name','Total Task Assigned','Total Task Completed','Total Task Pending']
            ];
        }
        else{
            return [
                ['Country',getCountryByID(101)],
                ['State',"-"],
                ['District',"-"],
                ['Facilitator',"-"],
                ['Date From',"-"],
                ['Date To',"-"],
                [],
                ['S.No','Country','State','Facilitator Name','Total Task Assigned','Total Task Completed','Total Task Pending']
            ];
        }
    }

    public function title(): string
    {
        return 'Facilitator_Wise_Report_'.pdf_date().' ';
    }
}
