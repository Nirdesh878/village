<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\FederationSubMst;
use App\Models\ClusterSubMst;
use App\Models\ShgSubMst;
use App\Models\FamilySubMst;

class LockedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::select('select value from settings where name = ?', ['lock']);
        $days = $result[0]->value;
        //prd($days);
        $query = "SELECT
                a.id,
                b.quality_date
            FROM
                (
                SELECT
                    a.id
                FROM
                    family_mst a
                INNER JOIN family_sub_mst b ON
                    a.id = b.family_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_p1 = 'V' AND b.qa_p2 = 'V' AND b.locked=0) a
            INNER JOIN(
                SELECT
                    assignment_id,
                    task_a1,
                    SUBSTRING_INDEX(GROUP_CONCAT(quality_status ORDER BY id DESC),',',1) AS STATUS ,
                    quality_date
                FROM
                    task_qa_assignment
                WHERE
                    assignment_type = 'FM' AND task_a1 = 'P2' AND quality_status = 'V'
                GROUP BY
                    assignment_id
            ) b
            ON
                a.id = b.assignment_id ";
        $result_family = DB::select($query);
        if (!empty($result_family)) {
            foreach ($result_family as $key => $data_new) {
                $date1=date('Y-m-d');
                $date2=$data_new->quality_date;
                $date2 = date("Y-m-d", strtotime($date2));
                $date3=date_create($date1);
                $date4=date_create($date2);
                $diff=date_diff($date4, $date3);
                $diff = $diff->format("%a");
                if ($diff > $days) {
                    FamilySubMst::where([['family_mst_id', '=', $data_new->id]])->update(['locked' => 1]);
                }
            }
        }

        $query_shg = "SELECT
                a.id,
                b.quality_date
            FROM
                (
                SELECT
                    a.id
                FROM
                        shg_mst a
                    INNER JOIN shg_sub_mst b ON
                        a.id = b.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND b.qa_a = 'V' AND b.locked=0) a
            INNER JOIN(
                SELECT
                    assignment_id,
                    task,
                    SUBSTRING_INDEX(GROUP_CONCAT(quality_status ORDER BY id DESC),',',1) AS STATUS ,
                    quality_date
                FROM
                    task_qa_assignment
                WHERE
                    assignment_type = 'SH' AND task = 'A' AND quality_status = 'V'
                GROUP BY
                    assignment_id
            ) b
            ON
                a.id = b.assignment_id";
        $result_shg = DB::select($query_shg);
        if (!empty($result_shg)) {
            foreach ($result_shg as $key => $data_new) {
                $date1=date('Y-m-d');
                $date2=$data_new->quality_date;
                $date2 = date("Y-m-d", strtotime($date2));
                $date3=date_create($date1);
                $date4=date_create($date2);
                $diff=date_diff($date4, $date3);
                $diff = $diff->format("%a");
                if ($diff > $days) {
                    ShgSubMst::where([['shg_mst_id', '=', $data_new->id]])->update(['locked' => 1]);
                }
            }
        }

        $query_clus = "SELECT
                a.id,
                b.assignment_id,
                b.task,
                b.STATUS,
                b.quality_date
            FROM
                (
                SELECT
                    a.id
                FROM
                        cluster_mst a
                    INNER JOIN cluster_sub_mst b ON
                        a.id = b.cluster_mst_id
                    INNER JOIN cluster_profile AS j
                    ON
                    j.cluster_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND b.dm_a = 'V' AND b.locked = 0) a
            INNER JOIN(
                SELECT
                    assignment_id,
                    task,
                    SUBSTRING_INDEX(GROUP_CONCAT(quality_status ORDER BY id DESC),',',1) AS STATUS ,
                    quality_date
                FROM
                    task_qa_assignment
                WHERE
                    assignment_type = 'CL' AND task = 'A' AND quality_status = 'V'
                GROUP BY
                    assignment_id
            ) b
            ON
                a.id = b.assignment_id";
        $result_clus = DB::select($query_clus);
        if (!empty($result_clus)) {
            foreach ($result_clus as $key => $data_new) {
                $date1=date('Y-m-d');
                $date2=$data_new->quality_date;
                $date2 = date("Y-m-d", strtotime($date2));
                $date3=date_create($date1);
                $date4=date_create($date2);
                $diff=date_diff($date4, $date3);
                $diff = $diff->format("%a");
                if ($diff > $days) {
                    ClusterSubMst::where([['cluster_mst_id', '=', $data_new->id]])->update(['locked' => 1]);
                }
            }
        }

        $query_fed = "SELECT
                a.id,
                b.assignment_id,
                b.task,
                b.STATUS,
                b.quality_date
            FROM
                (
                SELECT
                    a.id
                FROM
                    federation_mst a
                    INNER JOIN federation_sub_mst b ON
                        a.id = b.federation_mst_id
                    INNER JOIN federation_profile j ON
                    j.federation_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND b.dm_a = 'V' AND b.qa_a = 'V' AND b.locked = 0) a
            INNER JOIN(
                SELECT
                    assignment_id,
                    task,
                    SUBSTRING_INDEX(GROUP_CONCAT(quality_status ORDER BY id DESC),',',1) AS STATUS ,
                    quality_date
                FROM
                    task_qa_assignment
                WHERE
                    assignment_type = 'FD' AND task = 'A' AND quality_status = 'V'
                GROUP BY
                    assignment_id
            ) b
            ON
                a.id = b.assignment_id";
        $result_fed = DB::select($query_fed);
        if (!empty($result_fed)) {
            foreach ($result_fed as $key => $data_new) {
                $date1=date('Y-m-d');
                $date2=$data_new->quality_date;
                $date2 = date("Y-m-d", strtotime($date2));
                $date3=date_create($date1);
                $date4=date_create($date2);
                $diff=date_diff($date4, $date3);
                $diff = $diff->format("%a");
                if ($diff > $days) {
                    FederationSubMst::where([['federation_mst_id', '=', $data_new->id]])->update(['locked' => 1]);
                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
