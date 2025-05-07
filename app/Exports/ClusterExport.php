<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;



class ClusterExport implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $user_geo = DB::table('user_location_relation')
        ->where('user_id', $user->id)
        ->where('is_deleted', '=', 0)
        ->orderBy('country_id')
        ->get()->toArray();
        $query = " SELECT
        *
    FROM
        (
        SELECT
            b.*,
            d.agency_name,
            e.name AS country_name,
            f.name AS state_name,
            g.name AS district_name,
            a.uin,
            a.id AS ids,
            a.srlm_code,
            a.status,
            a.federation_uin,
            h.name_of_federation,
            s.status AS clust_status,
            s.analytics,
            s.dm_a,
            s.qa_a,
            s.dm_r,
            s.qa_r,
            s.flag,
            s.updated_at as updated,
            s.locked
        FROM
            cluster_mst AS a
        INNER JOIN cluster_sub_mst AS s
        ON
            s.cluster_mst_id = a.id
        INNER JOIN cluster_profile AS b
        ON
            b.cluster_sub_mst_id = s.id
        INNER JOIN federation_mst AS c
        ON
            a.federation_uin = c.uin
        INNER JOIN federation_sub_mst AS X
        ON
            X.federation_mst_id = c.id
        INNER JOIN federation_profile AS h
        ON
            h.federation_sub_mst_id = X.id
        INNER JOIN agency AS d
        ON
            a.agency_id = d.agency_id
        LEFT JOIN countries AS e
        ON
            b.country_id = e.id
        LEFT JOIN states AS f
        ON
            b.state_id = f.id
        LEFT JOIN district AS g
        ON
            b.district_id = g.id
        WHERE
            a.is_deleted = 0";
             if ($user->u_type == 'M') {
                // $query .= " AND (Y.created_by = $user->id OR z.fp_district IN($district_list)) ";
                if($user_geo[0]->district_id == ''){
                    $district_list = 0;
                } else{

                    $district_list = $user_geo[0]->district_id;
                }

                $state_id = $user_geo[0]->state_id;

                $query .= " AND (CASE WHEN a.created_by > 1 THEN 1 ELSE 0 END = 1 AND a.created_by = $user->id AND  a.is_deleted = 0 )
                   OR
                (CASE WHEN a.created_by < 2 THEN 1 ELSE 0 END = 1 AND (b.district_id IN ($district_list) OR b.state_id = $state_id ) AND  a.is_deleted = 0)" ;
            }

    $query .= ") a
    LEFT JOIN(
        SELECT
            *
        FROM
            (
            SELECT
                assignment_type,
                assignment_id,
                SUBSTRING_INDEX(
                    GROUP_CONCAT(user_id
                ORDER BY
                    id
                DESC
                    ),
                    ',',
                    1
                ) AS user_id
            FROM
                task_assignment
            WHERE
                assignment_type = 'CL'
            GROUP BY
                assignment_id
        ) a
    INNER JOIN(
        SELECT
            b.id,
            b.name
        FROM
            users b
        WHERE
            b.is_deleted = 0 AND b.roles_c = 3
    ) b
    ON
        a.user_id = b.id
    ) b
    ON
        a.ids = b.assignment_id
    ORDER BY
        a.updated
    DESC
        ";
        $federations = DB::select($query);

        return collect($federations);
    }

    public function map($res): array
    {
        $visit = 'Created';
        if ($res->dm_a == 'V' && $res->qa_a == 'V' && $res->locked == 1) {
            $visit = 'Locked';
        } elseif ($res->dm_a == 'V' && $res->qa_a == 'V') {
            $visit = 'Initial Rating';
        } elseif ($res->dm_a == 'V' && $res->qa_a == 'P') {
            $visit = 'Analytics Complete';
        } elseif ($res->dm_a == 'P') {
            $visit = 'Visit Complete';
        } elseif ($res->dm_a == 'N' && $res->flag == 0) {
            $visit = 'Visit Pending';
        } elseif ($res->dm_a == 'R' && $res->flag == 1) {
            $visit = 'Visit Reassigned';
        }
        if ($res->locked == 1) {
            $locked = 'Yes';
        } elseif ($res->locked == 0) {
            $locked = 'No';
        }
        $result = '';
        if ($visit != 'Created') {
            $result = $res->analysis_rating;
        } else {
            $result = '';
        }
        return [
            $this->counter++,
            $res->uin,
            $res->agency_name,
            $res->name_of_federation,
            $res->name_of_cluster,
            change_date_month_name_char(str_replace('/', '-', $res->cluster_formed)),
            $res->country_name,
            $res->state_name,
            $res->district_name,
            $res->block,
            $res->contact_name,
            $res->web_email,
            $res->web_mobile,
            $visit,
            $result,
            $res->name,
            $locked,
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
                $event->sheet->getStyle('A1:Q1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'color' => ['argb' => '#CCCCCC'],
                    ],
                ]);
            },
        ];
    }

    public function headings(): array
    {
        return [

            ['S.No', 'UIN', 'Agency', 'Federation', 'Cluster', 'Cluster formed', 'Country', 'State', 'District', 'Block', 'Contact Name', 'Email', 'Number', 'Status','Current Result', 'Name of Facilitator', 'Locked'],
        ];
    }

    public function title(): string
    {
        return 'ClusterExport';
    }
}
