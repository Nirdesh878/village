<?php

namespace App\Exports;
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


class FamilyExport implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $fac_list = DB::table('users')
            ->where('parent_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->select(DB::raw('group_concat(users.id) AS ids'))
            ->get()->toArray();
        $list  = $fac_list[0]->ids;
        $query = "SELECT
        *
    FROM
        (
        SELECT
            z.*,
            d.agency_name,
            e.name AS country_name,
            f.name AS state_name,
            g.name AS district_name,
            Y.uin,
            Y.id AS ids,
            Y.status,
            Y.created_at AS created,
            Y.cluster_uin,
            h.name_of_federation,
            b.name_of_cluster,
            j.shgName,
            X.status AS family_status,
            X.analytics,
            X.rating,
            X.flag,
            X.dm_p1,
            X.dm_p2,
            X.qa_p1,
            X.qa_p2,
            X.qa_r,
            X.dm_r,
            X.locked,
            X.updated_at AS updated,
            X.family_mst_id,
            X.recalled
        FROM
            family_mst AS Y
        INNER JOIN family_sub_mst AS X
        ON
            Y.id = X.family_mst_id
        INNER JOIN family_profile AS z
        ON
            X.id = z.family_sub_mst_id
        INNER JOIN shg_mst AS i
        ON
            i.uin = Y.shg_uin
        INNER JOIN shg_sub_mst AS w
        ON
            i.id = w.shg_mst_id
        INNER JOIN shg_profile AS j
        ON
            j.shg_sub_mst_id = w.id
        LEFT JOIN cluster_mst AS a
        ON
            i.cluster_uin = a.uin
        LEFT JOIN cluster_sub_mst AS v
        ON
            a.id = v.cluster_mst_id
        LEFT JOIN cluster_profile AS b
        ON
            b.cluster_sub_mst_id = v.id
        INNER JOIN federation_mst AS c
        ON
            i.federation_uin = c.uin
        INNER JOIN federation_sub_mst AS u
        ON
            c.id = u.federation_mst_id
        INNER JOIN federation_profile AS h
        ON
            h.federation_sub_mst_id = u.id
        INNER JOIN agency AS d
        ON
            Y.agency_id = d.agency_id
        LEFT JOIN countries AS e
        ON
            z.fp_country_id = e.id
        LEFT JOIN states AS f
        ON
            z.fp_state_id = f.id
        LEFT JOIN district AS g
        ON
            z.fp_district_id = g.id
        WHERE
            Y.is_deleted = 0";
            if ($user->u_type == 'M') {
                // $query .= " AND Y.created_by = $user->id";
                if($user_geo[0]->district_id == ''){
                    $district_list = 0;
                } else{

                    $district_list = $user_geo[0]->district_id;
                }

                $state_id = $user_geo[0]->state_id;

                $query .= " AND (CASE WHEN Y.created_by > 1 THEN 1 ELSE 0 END = 1 AND Y.created_by = $user->id AND  Y.is_deleted = 0)
     OR
                (CASE WHEN Y.created_by < 2 THEN 1 ELSE 0 END = 1 AND (z.fp_district_id IN ($district_list) OR z.fp_state_id = $state_id ))";

            }
    $query .=") a
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
                assignment_type = 'FM'
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


        $familys = DB::select($query);

        return collect($familys);
    }

    public function map($res): array
    {
                if ($res->dm_p1 == 'V' && $res->qa_p1 == 'V' && $res->dm_p2 == 'V' && $res->qa_p2 == 'V' && $res->locked == 1) {
                    $visit = 'Locked';
                } elseif ($res->dm_p1 == 'V' && $res->dm_p2 == 'V' && $res->qa_p1 == 'V' && $res->qa_p2 == 'V') {
                    $visit = 'Initial Rating';
                } elseif ($res->dm_p1 == 'V' && $res->dm_p2 == 'V') {
                    $visit = 'Analytics Complete';
                } else if (($res->dm_p1 == 'P' && $res->dm_p2 == 'P')) {
                    $visit = 'Both Visit Completed';
                } else if (($res->dm_p1 == 'V' && $res->dm_p2 == 'P' )) {
                    $visit = 'Both Visit Completed';
                } else if ($res->dm_p2 == 'R' && $res->dm_p1 == 'V' && $res->flag == 1) {
                    $visit = 'Second Visit Rejected';
                } else if ($res->dm_p1 == 'P' or $res->dm_p1 == 'V') {
                    $visit = 'Second Visit Pending ';
                } else if ($res->dm_p1 == 'R' && $res->flag == 1) {
                    $visit = 'First Visit Rejected';
                } elseif ($res->dm_p1 == 'N') {
                    $visit = 'First Visit Pending';
                } elseif ($res->recalled == 1) {
                    $visit = 'Recalled';
                } else {
                    $visit = 'Created';
                }
                if ($res->locked == 1) {
                    $locked = 'Yes';
                } elseif ($res->locked == 0) {
                    $locked = 'No';
                }
                $result ='';
                if($visit !='Created'){
                    $result =$res->analysis_rating;
                }
                else
                {
                    $result ='';
                }

            return [
                $this->counter++,
                $res->uin,
                // $res->agency_name,
                $res->name_of_federation,
                ($res->name_of_cluster != '' OR $res->name_of_cluster == 'NULL') ? $res->name_of_cluster : '-',
                $res->shgName,
                $res->fp_member_name,
                $res->fp_spouse_name,
                // $res->country_name,
                // $res->state_name,
                // $res->district_name,
                $res->fp_village,
                $visit,
                $result,
                $res->name,
                $locked,
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
                $event->sheet->getStyle('A1:K1')->applyFromArray([
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

            ['S.No','UIN','Federation','Cluster','SHG','SHG Member Name','Spouse Name','Village','Status','Current Result','Name of Facilitator','Locked']
        ];
    }

    public function title(): string
    {
        return 'FamilyExport';
    }
}
