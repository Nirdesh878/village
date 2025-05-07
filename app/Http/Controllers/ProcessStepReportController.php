<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProcessStepReport;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ProcessStepReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->curdate = Carbon::now()->format('d-m-Y');
    }
    public function index(Request $request)
    {
        $data = [];
        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
        }
        // prd($request->all());


        if (!empty($request->get('Search'))) {
            Session::put('process_filter_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('process_filter_session');
        }
        $session_data = Session::get('process_filter_session');


        if (!empty($session_data['Search'])) {
            if (!empty($session_data['group'])) {
                if ($session_data['group'] == 'AG') {
                    $agency_id = $session_data['agency_id'];
                    $data['agency_id'] = $agency_id;
                    // prd($agency_id);
                    //  agency total task
                    $query = "SELECT SUM(total) as total FROM (SELECT
                                    COUNT(*) AS total
                                FROM
                                    federation_mst a
                                INNER JOIN federation_sub_mst b ON
                                    a.id = b.federation_mst_id
                                WHERE
                                    a.is_deleted = 0 AND b.dm_a != '' AND a.agency_id = $agency_id

                                UNION ALL

                                    SELECT
                                        COUNT(*) AS total
                                    FROM
                                        cluster_mst a
                                    INNER JOIN cluster_sub_mst b ON
                                        a.id = b.cluster_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.dm_a != '' AND a.agency_id = $agency_id

                                UNION ALL

                                    SELECT
                                        COUNT(*) AS total
                                    FROM
                                        shg_mst a
                                    INNER JOIN shg_sub_mst b ON
                                        a.id = b.shg_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.dm_a != '' AND a.agency_id = $agency_id

                                UNION ALL

                                    SELECT
                                        COUNT(*) AS total
                                    FROM
                                        family_mst a
                                    INNER JOIN family_sub_mst b ON
                                        a.id = b.family_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.dm_p1 != '' AND a.agency_id = $agency_id )a
                                    ";


                    $data['total_task'] = DB::select($query);

                    $query = "SELECT SUM(locked) as total_locked FROM (SELECT
                                    COUNT(b.locked) AS locked
                                FROM
                                    federation_mst a
                                INNER JOIN federation_sub_mst b ON
                                    a.id = b.federation_mst_id
                                WHERE
                                    a.is_deleted = 0 AND b.locked = 1 AND a.agency_id = $agency_id

                                UNION ALL

                                    SELECT
                                        COUNT(b.locked) AS locked
                                    FROM
                                        cluster_mst a
                                    INNER JOIN cluster_sub_mst b ON
                                        a.id = b.cluster_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND  b.locked = 1 AND a.agency_id = $agency_id

                                UNION ALL

                                    SELECT
                                        COUNT(b.locked) AS locked
                                    FROM
                                        shg_mst a
                                    INNER JOIN shg_sub_mst b ON
                                        a.id = b.shg_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.locked = 1 AND a.agency_id = $agency_id

                                UNION ALL

                                    SELECT
                                        COUNT(b.locked) AS locked
                                    FROM
                                        family_mst a
                                    INNER JOIN family_sub_mst b ON
                                        a.id = b.family_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.locked = 1 AND a.agency_id = $agency_id )a
                                    ";


                    $data['locked'] = DB::select($query);


                    // prd($total_task_agency);
                    if (!empty($data['total_task'])) {
                        $total_task = $data['total_task'][0]->total;
                    } else {
                        $total_task = 0;
                    }

                    // total task done
                    $query_done = "SELECT SUM(total) as total FROM (SELECT
                                        COUNT(*) AS total
                                    FROM
                                        federation_mst a
                                    INNER JOIN federation_sub_mst b ON
                                        a.id = b.federation_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND (b.dm_a = 'P' OR b.dm_a = 'V' OR b.dm_a = 'R') AND a.agency_id = $agency_id
                                        UNION ALL

                                    SELECT
                                        COUNT(*) AS total
                                    FROM
                                        cluster_mst a
                                    INNER JOIN cluster_sub_mst b ON
                                        a.id = b.cluster_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND (b.dm_a = 'P' OR b.dm_a = 'V' OR b.dm_a = 'R') AND a.agency_id = $agency_id

                                        UNION ALL

                                    SELECT
                                        COUNT(*) AS total
                                    FROM
                                        shg_mst a
                                    INNER JOIN shg_sub_mst b ON
                                        a.id = b.shg_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND (b.dm_a = 'P' OR b.dm_a = 'V' OR b.dm_a = 'R') AND a.agency_id = $agency_id

                                        UNION ALL

                                    SELECT
                                        COUNT(*) AS total
                                    FROM
                                        family_mst a
                                    INNER JOIN family_sub_mst b ON
                                        a.id = b.family_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND (b.dm_p1 = 'P' OR b.dm_p1 = 'V' OR b.dm_p1 = 'R') AND (b.dm_p2 = 'P' OR b.dm_p2 = 'V' OR b.dm_p2 = 'R') AND a.agency_id = $agency_id)a";

                    $data['total_done'] = DB::select($query_done);

                    //  prd($data['total_done']);
                    if (!empty($data['total_done'])) {
                        $total_done = $data['total_done'][0]->total;
                    } else {
                        $total_done = 0;
                    }

                    // total pending
                    $data['total_pending'] = $total_task - $total_done;
                    // prd($data['pending']);

                    // total agency_task_r

                    $query_task_r = "SELECT SUM(total) as total FROM (SELECT
                                        COUNT(*) AS total
                                    FROM
                                        federation_mst a
                                    INNER JOIN federation_sub_mst b ON
                                        a.id = b.federation_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.qa_a = 'V' AND b.dm_r != '' AND a.agency_id = $agency_id

                                    UNION ALL

                                    SELECT
                                        COUNT(*) AS total
                                    FROM
                                        cluster_mst a
                                    INNER JOIN cluster_sub_mst b ON
                                        a.id = b.cluster_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.qa_a = 'V' AND b.dm_r != '' AND a.agency_id = $agency_id

                                        UNION ALL

                                    SELECT
                                        COUNT(*) AS total
                                    FROM
                                        shg_mst a
                                    INNER JOIN shg_sub_mst b ON
                                        a.id = b.shg_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.qa_a = 'V' AND b.dm_r != '' AND a.agency_id = $agency_id

                                        UNION ALL

                                    SELECT
                                        COUNT(*) AS total
                                    FROM
                                        family_mst a
                                    INNER JOIN family_sub_mst b ON
                                        a.id = b.family_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.qa_p2 = 'V' AND (b.dm_r = 'P' or b.dm_r = 'V' or b.dm_r = 'R') AND a.agency_id = $agency_id)a
                                    ";

                    $data['total_task_r'] = DB::select($query_task_r);
                    if (!empty($data['total_task_r'])) {
                        $total_task_r = $data['total_task_r'][0]->total;
                    } else {
                        $total_task_r = 0;
                    }

                    // total task_r done
                    $query_done_r = "SELECT SUM(total) as total_done FROM (SELECT
                            COUNT(*) AS total
                        FROM
                            federation_mst a
                        INNER JOIN federation_sub_mst b ON
                            a.id = b.federation_mst_id
                        WHERE
                            a.is_deleted = 0 AND (b.dm_r = 'P' OR b.dm_r = 'V' OR b.dm_r = 'R') AND a.agency_id = $agency_id

                        UNION ALL

                        SELECT
                            COUNT(*) AS total
                        FROM
                            cluster_mst a
                        INNER JOIN cluster_sub_mst b ON
                            a.id = b.cluster_mst_id
                        WHERE
                            a.is_deleted = 0 AND (b.dm_r = 'P' OR b.dm_r = 'V' OR b.dm_r = 'R') AND a.agency_id = $agency_id

                            UNION ALL

                        SELECT
                            COUNT(*) AS total
                        FROM
                            shg_mst a
                        INNER JOIN shg_sub_mst b ON
                            a.id = b.shg_mst_id
                        WHERE
                            a.is_deleted = 0 AND (b.dm_r = 'P' OR b.dm_r = 'V' OR b.dm_r = 'R') AND a.agency_id = $agency_id

                             UNION ALL

                        SELECT
                            COUNT(*) AS total
                        FROM
                            family_mst a
                        INNER JOIN family_sub_mst b ON
                            a.id = b.family_mst_id
                        WHERE
                            a.is_deleted = 0 AND (b.dm_r = 'P' OR b.dm_r = 'V' OR b.dm_r = 'R') AND a.agency_id = $agency_id)a";

                    $data['total_done_r'] = DB::select($query_done_r);
                    if (!empty($data['total_done_r'])) {
                        $total_done_r = $data['total_done_r'][0]->total_done;
                    } else {
                        $total_done_r = 0;
                    }


                    $data['total_pending_r'] = $total_task_r - $total_done_r;
                    // prd($data['total_done_r']);



                    //  total agency dm task

                    $dm_task = " SELECT
                                SUM(ManagerReject) as ManagerReject,
                                SUM(ManagerVerified) as ManagerVerified,
                                SUM(QualityReject) as QualityReject,
                                SUM(QualityVerified) as QualityVerified
                                FROM
                                (
                                SELECT
                                    SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                    SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                    SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                    SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                    SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                    SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                            FROM
                                federation_mst a
                            INNER JOIN task_qa_assignment b ON
                                a.id = b.assignment_id
                            WHERE
                                a.is_deleted = 0 AND b.assignment_type = 'FD' AND b.task = 'A' AND a.agency_id = $agency_id
                            UNION ALL
                            SELECT
                                    SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                    SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                    SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                    SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                    SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                    SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                            FROM
                                cluster_mst a
                            INNER JOIN task_qa_assignment b ON
                                a.id = b.assignment_id
                            WHERE
                                a.is_deleted = 0 AND b.assignment_type = 'CL' AND b.task = 'A' AND a.agency_id = $agency_id
                            UNION ALL
                            SELECT
                                SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                    SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                    SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                    SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                    SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                    SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                            FROM
                                shg_mst a
                            INNER JOIN task_qa_assignment b ON
                                a.id = b.assignment_id
                            WHERE
                                a.is_deleted = 0 AND b.assignment_type = 'SH' AND b.task = 'A' AND a.agency_id = $agency_id
                            UNION ALL
                            SELECT
                                SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                    SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                    SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                    SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                    SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                    SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                            FROM
                                family_mst a
                            INNER JOIN task_qa_assignment b ON
                                a.id = b.assignment_id
                            WHERE
                                a.is_deleted = 0 AND b.assignment_type = 'FM' AND b.task = 'A' AND a.agency_id = $agency_id
                            )a";
                    $data['dm_task'] = DB::select($dm_task);

                    $dm_task_r = " SELECT
                                SUM(ManagerReject) as ManagerReject_r,
                                SUM(ManagerVerified) as ManagerVerified_r,
                                SUM(QualityReject) as QualityReject_r,
                                SUM(QualityVerified) as QualityVerified_r
                                FROM
                                (
                                SELECT
                                    SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                    SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                    SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                    SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                    SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                    SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                            FROM
                                federation_mst a
                            INNER JOIN task_qa_assignment b ON
                                a.id = b.assignment_id
                            WHERE
                                a.is_deleted = 0 AND b.assignment_type = 'FD' AND b.task = 'R' AND a.agency_id = $agency_id
                            UNION ALL
                            SELECT
                                    SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                    SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                    SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                    SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                    SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                    SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                            FROM
                                cluster_mst a
                            INNER JOIN task_qa_assignment b ON
                                a.id = b.assignment_id
                            WHERE
                                a.is_deleted = 0 AND b.assignment_type = 'CL' AND b.task = 'R' AND a.agency_id = $agency_id
                            UNION ALL
                            SELECT
                                SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                    SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                    SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                    SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                    SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                    SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                            FROM
                                shg_mst a
                            INNER JOIN task_qa_assignment b ON
                                a.id = b.assignment_id
                            WHERE
                                a.is_deleted = 0 AND b.assignment_type = 'SH' AND b.task = 'R' AND a.agency_id = $agency_id
                            UNION ALL
                            SELECT
                                SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                    SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                    SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                    SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                    SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                    SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                            FROM
                                family_mst a
                            INNER JOIN task_qa_assignment b ON
                                a.id = b.assignment_id
                            WHERE
                                a.is_deleted = 0 AND b.assignment_type = 'FM' AND b.task = 'R' AND a.agency_id = $agency_id
                            )a";
                    $data['dm_task_r'] = DB::select($dm_task_r);

                    //prd($data['dm_task_r']);

                    $query = "SELECT a.agency_name FROM agency a WHERE agency_id = $agency_id";
                    $data['agency_name'] = DB::select($query);
                }
                //family
                elseif ($session_data['group'] == 'FM') {
                    $task = 'family';
                    $query_total_p1 = "SELECT
                            count(*) as total
                        FROM
                            " . $task . "_mst a
                        INNER JOIN " . $task . "_sub_mst b ON
                            a.id = b." . $task . "_mst_id
                        WHERE
                            a.is_deleted = 0 and b.dm_p1 != '' ";
                    $data['total_task_p1'] = DB::select($query_total_p1);

                    if (!empty($data['total_task_p1'])) {
                        $total_task_p1 = $data['total_task_p1'][0]->total;
                    } else {
                        $total_task_p1 = 0;
                    }


                    $query_total_p2 = "SELECT
                            count(*) as total
                        FROM
                            " . $task . "_mst a
                        INNER JOIN " . $task . "_sub_mst b ON
                            a.id = b." . $task . "_mst_id
                        WHERE
                            a.is_deleted = 0 AND b.dm_p2 != ''";
                    $data['total_task_p2'] = DB::select($query_total_p2);
                    if (!empty($data['total_task_p2'])) {
                        $total_task_p2 = $data['total_task_p2'][0]->total;
                    } else {
                        $total_task_p2 = 0;
                    }

                    $data['family_total_task'] = $total_task_p1 ;
                    $query_total_r = "SELECT
                            count(*) as total
                        FROM
                            " . $task . "_mst a
                        INNER JOIN " . $task . "_sub_mst b ON
                            a.id = b." . $task . "_mst_id
                        WHERE
                            a.is_deleted = 0 AND b.qa_p1 = 'V' AND b.qa_p2 = 'V' AND (b.dm_r = 'P' or b.dm_r = 'V' or b.dm_r = 'R') ";
                    $data['total_task_r'] = DB::select($query_total_r);
                    if (!empty($data['total_task_r'])) {
                        $total_task_r = $data['total_task_r'][0]->total;
                    } else {
                        $total_task_r = 0;
                    }


                    $query_done_p1 = "SELECT
                            count(*) as total
                        FROM
                            " . $task . "_mst a
                        INNER JOIN " . $task . "_sub_mst b ON
                            a.id = b." . $task . "_mst_id
                        WHERE
                            a.is_deleted = 0 AND (b.dm_p1 = 'V' OR b.dm_p1 = 'P' OR b.dm_p1 = 'R')";
                    $data['total_done_p1'] = DB::select($query_done_p1);
                    if (!empty($data['total_done_p1'])) {
                        $total_done_p1 = $data['total_done_p1'][0]->total;
                    } else {
                        $total_done_p1 = 0;
                    }


                    $query_done_p2 = "SELECT
                            count(*) as total
                        FROM
                            " . $task . "_mst a
                        INNER JOIN " . $task . "_sub_mst b ON
                            a.id = b." . $task . "_mst_id
                        WHERE
                            a.is_deleted = 0 AND (b.dm_p2 = 'V' OR b.dm_p2 = 'P' OR b.dm_p2 = 'R') ";
                    $data['total_done_p2'] = DB::select($query_done_p2);
                    if (!empty($data['total_done_p2'])) {
                        $total_done_p2 = $data['total_done_p2'][0]->total;
                    } else {
                        $total_done_p2 = 0;
                    }
                    //  total submitted
                    $data['total_task_submitted'] = $total_done_p2 + $total_done_p1;

                    $query_done_r = "SELECT
                            count(*) as total
                        FROM
                            " . $task . "_mst a
                        INNER JOIN " . $task . "_sub_mst b ON
                            a.id = b." . $task . "_mst_id
                        WHERE
                            a.is_deleted = 0 AND (b.dm_r = 'V' OR b.dm_r = 'P' OR b.dm_r = 'R') ";
                    $data['total_done_r'] = DB::select($query_done_r);
                    //prd($data['total_done']);
                    if (!empty($data['total_done_r'])) {
                        $total_done_r = $data['total_done_r'][0]->total;
                    } else {
                        $total_done_r = 0;
                    }

                    $data['total_pending_p1'] = $total_task_p1 - $total_done_p1;
                    $data['total_pending_p2'] = $total_task_p2 - $total_done_p2;
                    $data['total_pending_r'] = $total_task_r - $total_done_r;
                    $data['total_task_pending'] = $data['total_pending_p1'] + $data['total_pending_p2'];

                    $dm_task_p1 = "SELECT
                        a.assignment_type,
                        a.task,
                        COUNT(*) as Total,
                        SUM(CASE WHEN a.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                        SUM(CASE WHEN a.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                        SUM(CASE WHEN a.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                        SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END) QualityPending,
                        SUM(CASE WHEN a.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                        SUM(CASE WHEN a.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                    FROM
                        task_qa_assignment a
                    WHERE
                        a.is_deleted = 0 AND a.assignment_type = 'FM' AND a.task = 'A' AND  task_a1 = 'P1' ";
                    $data['dm_task_p1'] = DB::select($dm_task_p1);

                    $dm_task_p2 = "SELECT
                        a.assignment_type,
                        a.task,
                        COUNT(*) as Total,
                        SUM(CASE WHEN a.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                        SUM(CASE WHEN a.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                        SUM(CASE WHEN a.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                        SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END) QualityPending,
                        SUM(CASE WHEN a.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                        SUM(CASE WHEN a.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                    FROM
                        task_qa_assignment a
                    WHERE
                        a.is_deleted = 0 AND a.assignment_type = 'FM' AND a.task = 'A' AND  task_a1 = 'P2' ";
                    $data['dm_task_p2'] = DB::select($dm_task_p2);


                    $dm_task_r = "SELECT
                        a.assignment_type,
                        a.task,
                        COUNT(*) as Total,
                        SUM(CASE WHEN a.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending_r,
                        SUM(CASE WHEN a.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject_r,
                        SUM(CASE WHEN a.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified_r,
                        SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END) QualityPending_r,
                        SUM(CASE WHEN a.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject_r,
                        SUM(CASE WHEN a.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified_r
                    FROM
                        task_qa_assignment a
                    WHERE
                        a.is_deleted = 0 AND a.assignment_type = 'FM' AND a.task = 'R' ";
                    $data['dm_task_r'] = DB::select($dm_task_r);

                    $qury = "SELECT
                        SUM(CASE WHEN b.locked = 1 THEN 1 ELSE 0 END) AS family_locked,
                        SUM(CASE WHEN (b.locked = 1  AND c.get_verified = 'Verified') THEN 1 ELSE 0 END)  AS family_verified,
                        SUM(CASE WHEN (b.locked = 1  AND c.get_verified = 'Verified' AND d.get_loan = 'Yes') THEN 1 ELSE 0 END)  AS family_get_loan
                    FROM
                        family_mst a
                    INNER JOIN family_sub_mst b ON
                        a.id = b.family_mst_id
                        INNER JOIN family_loan_approvel c ON
                        b.id=c.family_sub_mst_id
                        INNER JOIN family_loan_disbursement d ON
                        b.id=d.family_sub_mst_id
                    WHERE
                        a.is_deleted = 0";

                    $data['family_loan'] = DB::select($qury);



                    $family_Sql = "SELECT
                    count(m.id) AS Family_Total,
                    IFNULL(SUM(case when (s.qa_p2='V' AND s.locked=1) then 1 ELSE 0 END),0) AS Fully_Completed,
                    IFNULL(SUM(case when (p.analysis_rating>=90 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS green_analysis,
                    IFNULL(SUM(case when (p.analysis_rating>=75 AND p.analysis_rating <= 89 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS yellow_analysis,
                    IFNULL(SUM(case when (p.analysis_rating>=60 AND p.analysis_rating <= 74 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS grey_analysis,
                    IFNULL(SUM(case when (p.analysis_rating<60 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS red_analysis
                    FROM family_mst AS m
                    INNER JOIN family_sub_mst AS s  ON m.id = s.family_mst_id
                    INNER JOIN family_profile AS p  ON s.id = p.family_sub_mst_id
                    WHERE m.is_deleted=0 and m.status='A' and s.status='A' and s.dm_p1 != '' ";
                    //prd($family_Sql);
                    $familt_row = DB::select($family_Sql);
                    $data['Family_a'] = ($familt_row);
                    // prd( $data['Family_a']);

                } else {
                    if ($session_data['group'] == 'FD') {
                        $task = 'federation';
                    }
                    if ($session_data['group'] == 'CL') {
                        $task = 'cluster';
                    }
                    if ($session_data['group'] == 'SH') {
                        $task = 'shg';
                    }

                    // total loked
                    $query_locked = "SELECT count(locked) as total_locked
                    FROM
                        " . $task . "_mst a
                    INNER JOIN " . $task . "_sub_mst b ON
                        a.id = b." . $task . "_mst_id
                    WHERE
                        a.is_deleted = 0 AND b.locked = 1 ";
                    $data['locked'] = DB::select($query_locked);



                    //total task
                    $query_total_task = "SELECT
                        count(*) as total
                    FROM
                        " . $task . "_mst a
                    INNER JOIN " . $task . "_sub_mst b ON
                        a.id = b." . $task . "_mst_id
                    WHERE
                        a.is_deleted = 0 and b.dm_a != '' ";
                    $data['total_task'] = DB::select($query_total_task);
                    if (!empty($data['total_task'])) {
                        $total_task = $data['total_task'][0]->total;
                    } else {
                        $total_task = 0;
                    }
                    // prd($query_total_task);
                    //submitted
                    $query_done = "SELECT
                        count(*) as total
                    FROM
                        " . $task . "_mst a
                    INNER JOIN " . $task . "_sub_mst b ON
                        a.id = b." . $task . "_mst_id
                    WHERE
                        a.is_deleted = 0 AND (b.dm_a = 'P' OR b.dm_a = 'V' OR b.dm_a = 'R') ";
                    $data['total_done'] = DB::select($query_done);
                    //prd($data['total_done'][0]->total);
                    if (!empty($data['total_done'])) {
                        $total_done = $data['total_done'][0]->total;
                    } else {
                        $total_done = 0;
                    }
                    $data['total_pending'] = $total_task  - $total_done;



                    $dm_task = "SELECT
                        a.assignment_type,
                        a.task,
                        COUNT(*) as Total,
                        SUM(CASE WHEN a.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                        SUM(CASE WHEN a.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                        SUM(CASE WHEN a.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                        SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END) QualityPending,
                        SUM(CASE WHEN a.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                        SUM(CASE WHEN a.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                    FROM
                        task_qa_assignment a
                    WHERE
                        a.is_deleted = 0 AND a.assignment_type = '" . $session_data['group'] . "' AND a.task = 'A' ";
                    $data['dm_task'] = DB::select($dm_task);

                    $dm_task_r = "SELECT
                        a.assignment_type,
                        a.task,
                        COUNT(*) as Total,
                        SUM(CASE WHEN a.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending_r,
                        SUM(CASE WHEN a.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject_r,
                        SUM(CASE WHEN a.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified_r,
                        SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END) QualityPending_r,
                        SUM(CASE WHEN a.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject_r,
                        SUM(CASE WHEN a.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified_r
                    FROM
                        task_qa_assignment a
                    WHERE
                        a.is_deleted = 0 AND a.assignment_type = '" . $session_data['group'] . "' AND a.task = 'R' ";
                    $data['dm_task_r'] = DB::select($dm_task_r);

                    // prd($dm_task);



                    //total task rating
                    $query_total_r = "SELECT
                            count(*) as total
                        FROM
                            " . $task . "_mst a
                        INNER JOIN " . $task . "_sub_mst b ON
                            a.id = b." . $task . "_mst_id
                        WHERE
                            a.is_deleted = 0 AND b.qa_a = 'V' AND b.dm_r != ''  ";
                    $data['total_task_r'] = DB::select($query_total_r);
                    if (!empty($data['total_task_r'])) {
                        $total_task_r = $data['total_task_r'][0]->total;
                    } else {
                        $total_task_r = 0;
                    }

                    //rating done QA
                    $query_done_r = "SELECT
                        count(*) as total
                    FROM
                        " . $task . "_mst a
                    INNER JOIN " . $task . "_sub_mst b ON
                        a.id = b." . $task . "_mst_id
                    WHERE
                        a.is_deleted = 0 AND (b.dm_r = 'P' OR b.dm_r = 'V' OR b.dm_r = 'R') ";
                    $data['total_done_r'] = DB::select($query_done_r);
                    if (!empty($data['total_done_r'])) {
                        $total_done_r = $data['total_done_r'][0]->total;
                    } else {
                        $total_done_r = 0;
                    }

                    //pending rating
                    $data['total_pending_r'] = $total_task_r  - $total_done_r;
                }
            }
        }
        $data['task'] = '';
        if (!empty($session_data['Search'])) {
            if ($session_data['group'] == 'FM') {
                $data['task'] = 'Family';
            }
            if ($session_data['group'] == 'FD') {
                $data['task'] = 'Federation';
            }
            if ($session_data['group'] == 'CL') {
                $data['task'] = 'Cluster';
            }
            if ($session_data['group'] == 'SH') {
                $data['task'] = 'SHG';
            }
            if ($session_data['group'] == 'AG') {
                $data['task'] = 'Agency';
            }
        }
        //prd($data['task']);
        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();


        // prd($data['agency_name']);

        //prd($data);
        return view('processStepreport.list')->with($data);
    }
    public function export_pdf(Request $request)
    {
        $data = [];


        // prd($agency_id);
        if (!empty($request->get('Search'))) {
            Session::put('process_filter_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('process_filter_session');
        }

        $session_data = Session::get('process_filter_session');
        if (!empty($session_data)) {
            $data['group'] = $session_data['group'];
            $res['session_data'] =  $session_data;

            if (!empty($session_data['Search'])) {
                if (!empty($session_data['group'])) {
                    if ($session_data['group'] == 'AG') {
                        $agency_id = $session_data['agency_id'];
                        $data['agency_id'] = $agency_id;
                        //  agency total task
                        $query = "SELECT SUM(total) as total FROM (SELECT
                                        COUNT(*) AS total
                                    FROM
                                        federation_mst a
                                    INNER JOIN federation_sub_mst b ON
                                        a.id = b.federation_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.dm_a != '' AND a.agency_id = $agency_id

                                    UNION ALL

                                        SELECT
                                            COUNT(*) AS total
                                        FROM
                                            cluster_mst a
                                        INNER JOIN cluster_sub_mst b ON
                                            a.id = b.cluster_mst_id
                                        WHERE
                                            a.is_deleted = 0 AND b.dm_a != '' AND a.agency_id = $agency_id

                                    UNION ALL

                                        SELECT
                                            COUNT(*) AS total
                                        FROM
                                            shg_mst a
                                        INNER JOIN shg_sub_mst b ON
                                            a.id = b.shg_mst_id
                                        WHERE
                                            a.is_deleted = 0 AND b.dm_a != '' AND a.agency_id = $agency_id

                                    UNION ALL

                                        SELECT
                                            COUNT(*) AS total
                                        FROM
                                            family_mst a
                                        INNER JOIN family_sub_mst b ON
                                            a.id = b.family_mst_id
                                        WHERE
                                            a.is_deleted = 0 AND b.dm_p1 != '' AND a.agency_id = $agency_id )a
                                        ";


                        $data['total_task'] = DB::select($query);

                        $query = "SELECT SUM(locked) as total_locked FROM (SELECT
                                    COUNT(b.locked) AS locked
                                FROM
                                    federation_mst a
                                INNER JOIN federation_sub_mst b ON
                                    a.id = b.federation_mst_id
                                WHERE
                                    a.is_deleted = 0 AND b.locked = 1 AND a.agency_id = $agency_id

                                UNION ALL

                                    SELECT
                                        COUNT(b.locked) AS locked
                                    FROM
                                        cluster_mst a
                                    INNER JOIN cluster_sub_mst b ON
                                        a.id = b.cluster_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND  b.locked = 1 AND a.agency_id = $agency_id

                                UNION ALL

                                    SELECT
                                        COUNT(b.locked) AS locked
                                    FROM
                                        shg_mst a
                                    INNER JOIN shg_sub_mst b ON
                                        a.id = b.shg_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.locked = 1 AND a.agency_id = $agency_id

                                UNION ALL

                                    SELECT
                                        COUNT(b.locked) AS locked
                                    FROM
                                        family_mst a
                                    INNER JOIN family_sub_mst b ON
                                        a.id = b.family_mst_id
                                    WHERE
                                        a.is_deleted = 0 AND b.locked = 1 AND a.agency_id = $agency_id )a
                                    ";


                        $data['locked'] = DB::select($query);

                        // prd($total_task_agency);
                        if (!empty($data['total_task'])) {
                            $total_task = $data['total_task'][0]->total;
                        } else {
                            $total_task = 0;
                        }

                        // total task done
                        $query_done = "SELECT SUM(total) as total FROM (SELECT
                                            COUNT(*) AS total
                                        FROM
                                            federation_mst a
                                        INNER JOIN federation_sub_mst b ON
                                            a.id = b.federation_mst_id
                                        WHERE
                                            a.is_deleted = 0 AND (b.dm_a = 'P' OR b.dm_a = 'V' OR b.dm_a = 'R') AND a.agency_id = $agency_id
                                            UNION ALL

                                        SELECT
                                            COUNT(*) AS total
                                        FROM
                                            cluster_mst a
                                        INNER JOIN cluster_sub_mst b ON
                                            a.id = b.cluster_mst_id
                                        WHERE
                                            a.is_deleted = 0 AND (b.dm_a = 'P' OR b.dm_a = 'V' OR b.dm_a = 'R') AND a.agency_id = $agency_id

                                            UNION ALL

                                        SELECT
                                            COUNT(*) AS total
                                        FROM
                                            shg_mst a
                                        INNER JOIN shg_sub_mst b ON
                                            a.id = b.shg_mst_id
                                        WHERE
                                            a.is_deleted = 0 AND (b.dm_a = 'P' OR b.dm_a = 'V' OR b.dm_a = 'R') AND a.agency_id = $agency_id

                                            UNION ALL

                                        SELECT
                                            COUNT(*) AS total
                                        FROM
                                            family_mst a
                                        INNER JOIN family_sub_mst b ON
                                            a.id = b.family_mst_id
                                        WHERE
                                            a.is_deleted = 0 AND (b.dm_p1 = 'P' OR b.dm_p1 = 'V' OR b.dm_p1 = 'R') AND (b.dm_p2 = 'P' OR b.dm_p2 = 'V' OR b.dm_p2 = 'R') AND a.agency_id = $agency_id)a";

                        $data['total_done'] = DB::select($query_done);

                        //  prd($data['total_done']);
                        if (!empty($data['total_done'])) {
                            $total_done = $data['total_done'][0]->total;
                        } else {
                            $total_done = 0;
                        }

                        // total pending
                        $data['total_pending'] = $total_task - $total_done;
                        // prd($data['pending']);

                        // total agency_task_r

                        $query_task_r = "SELECT SUM(total) as total FROM (SELECT
                                            COUNT(*) AS total
                                        FROM
                                            federation_mst a
                                        INNER JOIN federation_sub_mst b ON
                                            a.id = b.federation_mst_id
                                        WHERE
                                            a.is_deleted = 0 AND b.qa_a = 'V' AND b.dm_r != '' AND a.agency_id = $agency_id

                                        UNION ALL

                                        SELECT
                                            COUNT(*) AS total
                                        FROM
                                            cluster_mst a
                                        INNER JOIN cluster_sub_mst b ON
                                            a.id = b.cluster_mst_id
                                        WHERE
                                            a.is_deleted = 0 AND b.qa_a = 'V' AND b.dm_r != '' AND a.agency_id = $agency_id

                                            UNION ALL

                                        SELECT
                                            COUNT(*) AS total
                                        FROM
                                            shg_mst a
                                        INNER JOIN shg_sub_mst b ON
                                            a.id = b.shg_mst_id
                                        WHERE
                                            a.is_deleted = 0 AND b.qa_a = 'V' AND b.dm_r != '' AND a.agency_id = $agency_id

                                            UNION ALL

                                        SELECT
                                            COUNT(*) AS total
                                        FROM
                                            family_mst a
                                        INNER JOIN family_sub_mst b ON
                                            a.id = b.family_mst_id
                                        WHERE
                                            a.is_deleted = 0 AND b.qa_p2 = 'V' AND (b.dm_r = 'P' or b.dm_r = 'V' or b.dm_r = 'R') AND a.agency_id = $agency_id)a
                                        ";

                        $data['total_task_r'] = DB::select($query_task_r);
                        if (!empty($data['total_task_r'])) {
                            $total_task_r = $data['total_task_r'][0]->total;
                        } else {
                            $total_task_r = 0;
                        }

                        // total task_r done
                        $query_done_r = "SELECT SUM(total) as total_done FROM (SELECT
                                COUNT(*) AS total
                            FROM
                                federation_mst a
                            INNER JOIN federation_sub_mst b ON
                                a.id = b.federation_mst_id
                            WHERE
                                a.is_deleted = 0 AND (b.dm_r = 'P' OR b.dm_r = 'V' OR b.dm_r = 'R') AND a.agency_id = $agency_id

                            UNION ALL

                            SELECT
                                COUNT(*) AS total
                            FROM
                                cluster_mst a
                            INNER JOIN cluster_sub_mst b ON
                                a.id = b.cluster_mst_id
                            WHERE
                                a.is_deleted = 0 AND (b.dm_r = 'P' OR b.dm_r = 'V' OR b.dm_r = 'R') AND a.agency_id = $agency_id

                                UNION ALL

                            SELECT
                                COUNT(*) AS total
                            FROM
                                shg_mst a
                            INNER JOIN shg_sub_mst b ON
                                a.id = b.shg_mst_id
                            WHERE
                                a.is_deleted = 0 AND (b.dm_r = 'P' OR b.dm_r = 'V' OR b.dm_r = 'R') AND a.agency_id = $agency_id

                                 UNION ALL

                            SELECT
                                COUNT(*) AS total
                            FROM
                                family_mst a
                            INNER JOIN family_sub_mst b ON
                                a.id = b.family_mst_id
                            WHERE
                                a.is_deleted = 0 AND (b.dm_r = 'P' OR b.dm_r = 'V' OR b.dm_r = 'R') AND a.agency_id = $agency_id)a";

                        $data['total_done_r'] = DB::select($query_done_r);
                        if (!empty($data['total_done_r'])) {
                            $total_done_r = $data['total_done_r'][0]->total_done;
                        } else {
                            $total_done_r = 0;
                        }


                        $data['total_pending_r'] = $total_task_r - $total_done_r;
                        // prd($data['total_done_r']);



                        //  total agency dm task

                        $dm_task = " SELECT
                                    SUM(ManagerReject) as ManagerReject,
                                    SUM(ManagerVerified) as ManagerVerified,
                                    SUM(QualityReject) as QualityReject,
                                    SUM(QualityVerified) as QualityVerified
                                    FROM
                                    (
                                    SELECT
                                        SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                        SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                        SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                        SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                        SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                        SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                                FROM
                                    federation_mst a
                                INNER JOIN task_qa_assignment b ON
                                    a.id = b.assignment_id
                                WHERE
                                    a.is_deleted = 0 AND b.assignment_type = 'FD' AND b.task = 'A' AND a.agency_id = $agency_id
                                UNION ALL
                                SELECT
                                        SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                        SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                        SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                        SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                        SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                        SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                                FROM
                                    cluster_mst a
                                INNER JOIN task_qa_assignment b ON
                                    a.id = b.assignment_id
                                WHERE
                                    a.is_deleted = 0 AND b.assignment_type = 'CL' AND b.task = 'A' AND a.agency_id = $agency_id
                                UNION ALL
                                SELECT
                                    SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                        SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                        SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                        SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                        SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                        SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                                FROM
                                    shg_mst a
                                INNER JOIN task_qa_assignment b ON
                                    a.id = b.assignment_id
                                WHERE
                                    a.is_deleted = 0 AND b.assignment_type = 'SH' AND b.task = 'A' AND a.agency_id = $agency_id
                                UNION ALL
                                SELECT
                                    SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                        SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                        SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                        SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                        SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                        SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                                FROM
                                    family_mst a
                                INNER JOIN task_qa_assignment b ON
                                    a.id = b.assignment_id
                                WHERE
                                    a.is_deleted = 0 AND b.assignment_type = 'FM' AND b.task = 'A' AND a.agency_id = $agency_id
                                )a";
                        $data['dm_task'] = DB::select($dm_task);

                        $dm_task_r = " SELECT
                                    SUM(ManagerReject) as ManagerReject_r,
                                    SUM(ManagerVerified) as ManagerVerified_r,
                                    SUM(QualityReject) as QualityReject_r,
                                    SUM(QualityVerified) as QualityVerified_r
                                    FROM
                                    (
                                    SELECT
                                        SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                        SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                        SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                        SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                        SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                        SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                                FROM
                                    federation_mst a
                                INNER JOIN task_qa_assignment b ON
                                    a.id = b.assignment_id
                                WHERE
                                    a.is_deleted = 0 AND b.assignment_type = 'FD' AND b.task = 'R' AND a.agency_id = $agency_id
                                UNION ALL
                                SELECT
                                        SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                        SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                        SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                        SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                        SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                        SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                                FROM
                                    cluster_mst a
                                INNER JOIN task_qa_assignment b ON
                                    a.id = b.assignment_id
                                WHERE
                                    a.is_deleted = 0 AND b.assignment_type = 'CL' AND b.task = 'R' AND a.agency_id = $agency_id
                                UNION ALL
                                SELECT
                                    SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                        SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                        SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                        SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                        SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                        SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                                FROM
                                    shg_mst a
                                INNER JOIN task_qa_assignment b ON
                                    a.id = b.assignment_id
                                WHERE
                                    a.is_deleted = 0 AND b.assignment_type = 'SH' AND b.task = 'R' AND a.agency_id = $agency_id
                                UNION ALL
                                SELECT
                                    SUM(CASE WHEN b.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                                        SUM(CASE WHEN b.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                                        SUM(CASE WHEN b.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                                        SUM(CASE WHEN b.quality_status = 'P' THEN 1 ELSE 0 END ) QualityPending,
                                        SUM(CASE WHEN b.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                                        SUM(CASE WHEN b.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                                FROM
                                    family_mst a
                                INNER JOIN task_qa_assignment b ON
                                    a.id = b.assignment_id
                                WHERE
                                    a.is_deleted = 0 AND b.assignment_type = 'FM' AND b.task = 'R' AND a.agency_id = $agency_id
                                )a";
                        $data['dm_task_r'] = DB::select($dm_task_r);



                        $query = "SELECT a.agency_name FROM agency a WHERE agency_id = $agency_id";
                        $data['agency_name'] = DB::select($query);
                    }
                    //family
                    elseif ($session_data['group'] == 'FM') {
                        $task = 'family';
                        $query_total_p1 = "SELECT
                                count(*) as total
                            FROM
                                " . $task . "_mst a
                            INNER JOIN " . $task . "_sub_mst b ON
                                a.id = b." . $task . "_mst_id
                            WHERE
                                a.is_deleted = 0 and b.dm_p1 != '' ";
                        $data['total_task_p1'] = DB::select($query_total_p1);

                        if (!empty($data['total_task_p1'])) {
                            $total_task_p1 = $data['total_task_p1'][0]->total;
                        } else {
                            $total_task_p1 = 0;
                        }


                        $query_total_p2 = "SELECT
                                count(*) as total
                            FROM
                                " . $task . "_mst a
                            INNER JOIN " . $task . "_sub_mst b ON
                                a.id = b." . $task . "_mst_id
                            WHERE
                                a.is_deleted = 0 AND b.dm_p2 != ''";
                        $data['total_task_p2'] = DB::select($query_total_p2);
                        if (!empty($data['total_task_p2'])) {
                            $total_task_p2 = $data['total_task_p2'][0]->total;
                        } else {
                            $total_task_p2 = 0;
                        }

                        $data['family_total_task'] = $total_task_p1 ;
                        $query_total_r = "SELECT
                                count(*) as total
                            FROM
                                " . $task . "_mst a
                            INNER JOIN " . $task . "_sub_mst b ON
                                a.id = b." . $task . "_mst_id
                            WHERE
                                a.is_deleted = 0 AND b.qa_p1 = 'V' AND b.qa_p2 = 'V' AND (b.dm_r = 'P' or b.dm_r = 'V' or b.dm_r = 'R') ";
                        $data['total_task_r'] = DB::select($query_total_r);
                        if (!empty($data['total_task_r'])) {
                            $total_task_r = $data['total_task_r'][0]->total;
                        } else {
                            $total_task_r = 0;
                        }


                        $query_done_p1 = "SELECT
                                count(*) as total
                            FROM
                                " . $task . "_mst a
                            INNER JOIN " . $task . "_sub_mst b ON
                                a.id = b." . $task . "_mst_id
                            WHERE
                                a.is_deleted = 0 AND (b.dm_p1 = 'V' OR b.dm_p1 = 'P' OR b.dm_p1 = 'R')";
                        $data['total_done_p1'] = DB::select($query_done_p1);
                        if (!empty($data['total_done_p1'])) {
                            $total_done_p1 = $data['total_done_p1'][0]->total;
                        } else {
                            $total_done_p1 = 0;
                        }


                        $query_done_p2 = "SELECT
                                count(*) as total
                            FROM
                                " . $task . "_mst a
                            INNER JOIN " . $task . "_sub_mst b ON
                                a.id = b." . $task . "_mst_id
                            WHERE
                                a.is_deleted = 0 AND (b.dm_p2 = 'V' OR b.dm_p2 = 'P' OR b.dm_p2 = 'R') ";
                        $data['total_done_p2'] = DB::select($query_done_p2);
                        if (!empty($data['total_done_p2'])) {
                            $total_done_p2 = $data['total_done_p2'][0]->total;
                        } else {
                            $total_done_p2 = 0;
                        }
                        //  total submitted
                        $data['total_task_submitted'] = $total_done_p2 + $total_done_p1;

                        $query_done_r = "SELECT
                                count(*) as total
                            FROM
                                " . $task . "_mst a
                            INNER JOIN " . $task . "_sub_mst b ON
                                a.id = b." . $task . "_mst_id
                            WHERE
                                a.is_deleted = 0 AND (b.dm_r = 'V' OR b.dm_r = 'P' OR b.dm_r = 'R') ";
                        $data['total_done_r'] = DB::select($query_done_r);
                        //prd($data['total_done']);
                        if (!empty($data['total_done_r'])) {
                            $total_done_r = $data['total_done_r'][0]->total;
                        } else {
                            $total_done_r = 0;
                        }

                        $data['total_pending_p1'] = $total_task_p1 - $total_done_p1;
                        $data['total_pending_p2'] = $total_task_p2 - $total_done_p2;
                        $data['total_pending_r'] = $total_task_r - $total_done_r;
                        $data['total_task_pending'] = $data['total_pending_p1'] + $data['total_pending_p2'];

                        $dm_task_p1 = "SELECT
                            a.assignment_type,
                            a.task,
                            COUNT(*) as Total,
                            SUM(CASE WHEN a.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                            SUM(CASE WHEN a.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                            SUM(CASE WHEN a.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                            SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END) QualityPending,
                            SUM(CASE WHEN a.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                            SUM(CASE WHEN a.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                        FROM
                            task_qa_assignment a
                        WHERE
                            a.is_deleted = 0 AND a.assignment_type = 'FM' AND a.task = 'A' AND  task_a1 = 'P1' ";
                        $data['dm_task_p1'] = DB::select($dm_task_p1);

                        $dm_task_p2 = "SELECT
                            a.assignment_type,
                            a.task,
                            COUNT(*) as Total,
                            SUM(CASE WHEN a.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                            SUM(CASE WHEN a.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                            SUM(CASE WHEN a.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                            SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END) QualityPending,
                            SUM(CASE WHEN a.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                            SUM(CASE WHEN a.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                        FROM
                            task_qa_assignment a
                        WHERE
                            a.is_deleted = 0 AND a.assignment_type = 'FM' AND a.task = 'A' AND  task_a1 = 'P2' ";
                        $data['dm_task_p2'] = DB::select($dm_task_p2);


                        $dm_task_r = "SELECT
                            a.assignment_type,
                            a.task,
                            COUNT(*) as Total,
                            SUM(CASE WHEN a.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending_r,
                            SUM(CASE WHEN a.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject_r,
                            SUM(CASE WHEN a.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified_r,
                            SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END) QualityPending_r,
                            SUM(CASE WHEN a.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject_r,
                            SUM(CASE WHEN a.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified_r
                        FROM
                            task_qa_assignment a
                        WHERE
                            a.is_deleted = 0 AND a.assignment_type = 'FM' AND a.task = 'R' ";
                        $data['dm_task_r'] = DB::select($dm_task_r);

                        $qury = "SELECT
                            SUM(CASE WHEN b.locked = 1 THEN 1 ELSE 0 END) AS family_locked,
                            SUM(CASE WHEN (b.locked = 1  AND c.get_verified = 'Verified') THEN 1 ELSE 0 END)  AS family_verified,
                            SUM(CASE WHEN (b.locked = 1  AND c.get_verified = 'Verified' AND d.get_loan = 'Yes') THEN 1 ELSE 0 END)  AS family_get_loan
                        FROM
                            family_mst a
                        INNER JOIN family_sub_mst b ON
                            a.id = b.family_mst_id
                            INNER JOIN family_loan_approvel c ON
                            b.id=c.family_sub_mst_id
                            INNER JOIN family_loan_disbursement d ON
                            b.id=d.family_sub_mst_id
                        WHERE
                            a.is_deleted = 0";

                        $data['family_loan'] = DB::select($qury);



                        $family_Sql = "SELECT
                        count(m.id) AS Family_Total,
                        IFNULL(SUM(case when (s.qa_p2='V' AND s.locked=1) then 1 ELSE 0 END),0) AS Fully_Completed,
                        IFNULL(SUM(case when (p.analysis_rating>=90 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS green_analysis,
                        IFNULL(SUM(case when (p.analysis_rating>=75 AND p.analysis_rating <= 89 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS yellow_analysis,
                        IFNULL(SUM(case when (p.analysis_rating>=60 AND p.analysis_rating <= 74 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS grey_analysis,
                        IFNULL(SUM(case when (p.analysis_rating<60 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS red_analysis
                        FROM family_mst AS m
                        INNER JOIN family_sub_mst AS s  ON m.id = s.family_mst_id
                        INNER JOIN family_profile AS p  ON s.id = p.family_sub_mst_id
                        WHERE m.is_deleted=0 and m.status='A' and s.status='A' and s.dm_p1 != '' ";
                        //prd($family_Sql);
                        $familt_row = DB::select($family_Sql);
                        $data['Family_a'] = ($familt_row);
                        // prd( $data['Family_a']);

                    } else {
                        if ($session_data['group'] == 'FD') {
                            $task = 'federation';
                        }
                        if ($session_data['group'] == 'CL') {
                            $task = 'cluster';
                        }
                        if ($session_data['group'] == 'SH') {
                            $task = 'shg';
                        }

                        // total loked
                        $query_locked = "SELECT count(locked) as total_locked
                    FROM
                        " . $task . "_mst a
                    INNER JOIN " . $task . "_sub_mst b ON
                        a.id = b." . $task . "_mst_id
                    WHERE
                        a.is_deleted = 0 AND b.locked = 1 ";
                        $data['locked'] = DB::select($query_locked);

                        //total task
                        $query_total_task = "SELECT
                            count(*) as total
                        FROM
                            " . $task . "_mst a
                        INNER JOIN " . $task . "_sub_mst b ON
                            a.id = b." . $task . "_mst_id
                        WHERE
                            a.is_deleted = 0 and b.dm_a != '' ";
                        $data['total_task'] = DB::select($query_total_task);
                        if (!empty($data['total_task'])) {
                            $total_task = $data['total_task'][0]->total;
                        } else {
                            $total_task = 0;
                        }
                        // prd($query_total_task);
                        //submitted
                        $query_done = "SELECT
                            count(*) as total
                        FROM
                            " . $task . "_mst a
                        INNER JOIN " . $task . "_sub_mst b ON
                            a.id = b." . $task . "_mst_id
                        WHERE
                            a.is_deleted = 0 AND (b.dm_a = 'P' OR b.dm_a = 'V' OR b.dm_a = 'R') ";
                        $data['total_done'] = DB::select($query_done);
                        //prd($data['total_done'][0]->total);
                        if (!empty($data['total_done'])) {
                            $total_done = $data['total_done'][0]->total;
                        } else {
                            $total_done = 0;
                        }
                        $data['total_pending'] = $total_task  - $total_done;



                        $dm_task = "SELECT
                            a.assignment_type,
                            a.task,
                            COUNT(*) as Total,
                            SUM(CASE WHEN a.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending,
                            SUM(CASE WHEN a.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject,
                            SUM(CASE WHEN a.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified,
                            SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END) QualityPending,
                            SUM(CASE WHEN a.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject,
                            SUM(CASE WHEN a.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified
                        FROM
                            task_qa_assignment a
                        WHERE
                            a.is_deleted = 0 AND a.assignment_type = '" . $session_data['group'] . "' AND a.task = 'A' ";
                        $data['dm_task'] = DB::select($dm_task);

                        $dm_task_r = "SELECT
                            a.assignment_type,
                            a.task,
                            COUNT(*) as Total,
                            SUM(CASE WHEN a.qa_status = 'P' THEN 1 ELSE 0 END) ManagerPending_r,
                            SUM(CASE WHEN a.qa_status = 'R' THEN 1 ELSE 0 END) ManagerReject_r,
                            SUM(CASE WHEN a.qa_status = 'V' THEN 1 ELSE 0 END) ManagerVerified_r,
                            SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END) QualityPending_r,
                            SUM(CASE WHEN a.quality_status = 'R' THEN 1 ELSE 0 END) QualityReject_r,
                            SUM(CASE WHEN a.quality_status = 'V' THEN 1 ELSE 0 END) QualityVerified_r
                        FROM
                            task_qa_assignment a
                        WHERE
                            a.is_deleted = 0 AND a.assignment_type = '" . $session_data['group'] . "' AND a.task = 'R' ";
                        $data['dm_task_r'] = DB::select($dm_task_r);

                        // prd($dm_task);



                        //total task rating
                        $query_total_r = "SELECT
                                count(*) as total
                            FROM
                                " . $task . "_mst a
                            INNER JOIN " . $task . "_sub_mst b ON
                                a.id = b." . $task . "_mst_id
                            WHERE
                                a.is_deleted = 0 AND b.qa_a = 'V' AND b.dm_r != ''  ";
                        $data['total_task_r'] = DB::select($query_total_r);
                        if (!empty($data['total_task_r'])) {
                            $total_task_r = $data['total_task_r'][0]->total;
                        } else {
                            $total_task_r = 0;
                        }

                        //rating done QA
                        $query_done_r = "SELECT
                            count(*) as total
                        FROM
                            " . $task . "_mst a
                        INNER JOIN " . $task . "_sub_mst b ON
                            a.id = b." . $task . "_mst_id
                        WHERE
                            a.is_deleted = 0 AND (b.dm_r = 'P' OR b.dm_r = 'V' OR b.dm_r = 'R') ";
                        $data['total_done_r'] = DB::select($query_done_r);
                        if (!empty($data['total_done_r'])) {
                            $total_done_r = $data['total_done_r'][0]->total;
                        } else {
                            $total_done_r = 0;
                        }

                        //pending rating
                        $data['total_pending_r'] = $total_task_r  - $total_done_r;
                    }
                }
            }
            $data['task'] = '';
            if (!empty($session_data['Search'])) {
                if ($session_data['group'] == 'FM') {
                    $data['task'] = 'family';
                }
                if ($session_data['group'] == 'FD') {
                    $data['task'] = 'federation';
                }
                if ($session_data['group'] == 'CL') {
                    $data['task'] = 'cluster';
                }
                if ($session_data['group'] == 'SH') {
                    $data['task'] = 'shg';
                }
                if ($session_data['group'] == 'AG') {
                    $data['task'] = 'agency';
                }
            }
        }
        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        if (!empty($session_data)) {
            if ($session_data['group'] == 'AG') {
                $query = "SELECT a.agency_name FROM agency a WHERE agency_id = $agency_id";
                $data['agency_name'] = DB::select($query);
            }
        }
        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.processStepPdf', $data)->setPaper('a3', 'landscape');
        //prd($result);
        return $pdf_doc->download('Process_Step_Details' . '_' . pdf_date() . '.pdf');
    }
    public function get_tasks_list(Request $request)
    {
        // prd($request->all());
        $tbody = '<table id="taskTable" class="table mytable" style="width: 100% !important;">
        <thead class="back-color">
        <tr>
            <th>S.No</th>
            <th>UIN</th>
            <th>Name</th>
            <th>Country</th>
            <th>State</th>
            <th>District</th>
            <th>Created At</th>
        </tr>
        </thead><tbody style="font-size:14px;">';

        if (request()->ajax()) {
            $group = $request->get('group');
            $type = $request->get('type');
            $agency_id = $request->get('agency');
            // pr($group);

            if ($group == 'FM') {
                $group_type = 'family';
            } elseif ($group == 'FD') {
                $group_type = 'federation';
            } elseif ($group == 'CL') {
                $group_type = 'cluster';
            } elseif ($group == 'SH') {
                $group_type = 'shg';
            }


            // prd($group_type);
            if ($group == 'AG') {
                if ($type == 'A') {
                    $query = "SELECT
              c.name_of_federation as name ,
              c.name_of_country as country,
              c.name_of_district as district,
              c.name_of_state as state,
              a.created_at,
              a.uin
          FROM
              federation_mst a
          INNER JOIN federation_sub_mst b ON
              a.id = b.federation_mst_id
              INNER JOIN federation_profile c ON
              b.id = c.federation_sub_mst_id
          WHERE
              a.is_deleted = 0 AND b.dm_a != '' AND a.agency_id = $agency_id


          UNION ALL

          SELECT
              c.name_of_cluster as name,
              c.name_of_country as country,
              c.name_of_district as district,
              c.name_of_state as state,
              a.created_at,
              a.uin
          FROM
              cluster_mst a
          INNER JOIN cluster_sub_mst b ON
              a.id = b.cluster_mst_id
              INNER JOIN cluster_profile c ON
              b.id = c.cluster_sub_mst_id
          WHERE
              a.is_deleted = 0 AND b.dm_a != '' AND a.agency_id = $agency_id

              UNION ALL

          SELECT
              c.shgName as name,
              c.name_of_country as country,
              c.name_of_district as district,
              c.name_of_state as state,
              a.created_at,
              a.uin
          FROM
              shg_mst a
          INNER JOIN shg_sub_mst b ON
              a.id = b.shg_mst_id
              INNER JOIN shg_profile c ON
              b.id = c.shg_sub_mst_id
          WHERE
              a.is_deleted = 0 AND b.dm_a != '' AND a.agency_id = $agency_id

               UNION ALL

          SELECT
              c.fp_member_name as name,
              c.fp_country as country,
              c.fp_district as district,
              c.fp_state as state,
              a.created_at,
              a.uin
          FROM
              family_mst a
          INNER JOIN family_sub_mst b ON
              a.id = b.family_mst_id
              INNER JOIN family_profile c ON
              b.id = c.family_sub_mst_id
          WHERE
              a.is_deleted = 0 AND b.dm_p1 != '' AND a.agency_id = $agency_id";
                }
                if ($type == 'R') {
                    $query = "SELECT
                    c.name_of_federation as name ,
                    c.name_of_country as country,
                    c.name_of_district as district,
                    c.name_of_state as state,
                    a.created_at,
                    a.uin
                FROM
                    federation_mst a
                INNER JOIN federation_sub_mst b ON
                    a.id = b.federation_mst_id
                    INNER JOIN federation_profile c ON
                    b.id = c.federation_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_a = 'V' AND b.dm_r != '' AND a.agency_id = $agency_id


                UNION ALL

                SELECT
                    c.name_of_cluster as name,
                    c.name_of_country as country,
                    c.name_of_district as district,
                    c.name_of_state as state,
                    a.created_at,
                    a.uin
                FROM
                    cluster_mst a
                INNER JOIN cluster_sub_mst b ON
                    a.id = b.cluster_mst_id
                    INNER JOIN cluster_profile c ON
                    b.id = c.cluster_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_a = 'V' AND b.dm_r != '' AND a.agency_id = $agency_id

                    UNION ALL

                SELECT
                    c.shgName as name,
                    c.name_of_country as country,
                    c.name_of_district as district,
                    c.name_of_state as state,
                    a.created_at,
                    a.uin
                FROM
                    shg_mst a
                INNER JOIN shg_sub_mst b ON
                    a.id = b.shg_mst_id
                    INNER JOIN shg_profile c ON
                    b.id = c.shg_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_a = 'V' AND b.dm_r != '' AND a.agency_id = $agency_id

                     UNION ALL

                SELECT
                    c.fp_member_name as name,
                    c.fp_country as country,
                    c.fp_district as district,
                    c.fp_state as state,
                    a.created_at,
                    a.uin
                FROM
                    family_mst a
                INNER JOIN family_sub_mst b ON
                    a.id = b.family_mst_id
                    INNER JOIN family_profile c ON
                    b.id = c.family_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_p2 = 'V' AND (b.dm_r = 'P' or b.dm_r = 'V' or b.dm_r = 'R') AND a.agency_id = $agency_id";
                }
            } elseif ($group == 'FM') {
                $field = 'fp_member_name';
                $query = " SELECT
                        a.id,
                        a.created_at,
                        a.uin,
                        c.$field as name,
                        c.fp_country as country,
                        c.fp_state as state,
                        c.fp_district as district
                    FROM
                        " . $group_type . "_mst a
                    INNER JOIN " . $group_type . "_sub_mst b ON
                        a.id = b." . $group_type . "_mst_id
                    INNER JOIN " . $group_type . "_profile c ON
                        b.id = c." . $group_type . "_sub_mst_id
                    WHERE
                        a.is_deleted = 0";

                if ($type == 'P1') {
                    $query .= "  AND b.dm_p1 != ''";
                }


                if ($type == 'R') {
                    $query .= "  AND b.qa_p2 = 'V' AND (b.dm_r = 'P' or b.dm_r = 'V' or b.dm_r = 'R')  ";
                }
            } else {
                $field = "name_of_" . $group_type;
                if ($group_type == 'shg') {
                    $field = 'shgName';
                }
                $query = " SELECT
                    a.id,
                    a.created_at,
                    a.uin,
                    c.$field as name,
                    c.name_of_district as district,
                    c.name_of_state as state,
                    c.name_of_country as country
                FROM
                    " . $group_type . "_mst a
                INNER JOIN " . $group_type . "_sub_mst b ON
                    a.id = b." . $group_type . "_mst_id
                INNER JOIN " . $group_type . "_profile c ON
                    b.id = c." . $group_type . "_sub_mst_id
                WHERE
                    a.is_deleted = 0";
                if ($type == 'A') {
                    $query .= "  AND b.dm_a !='' ";
                }
                if ($type == 'R') {
                    $query .= "  AND b.qa_a = 'V' AND b.dm_r != '' ";
                }
                $result = DB::select($query);
            }
            // $query .= " ORDER BY
            //         a.created_at DESC
            //     ";
            $result = DB::select($query);
            // prd($result);
            if ($result != '') {
                $i = 1;
                foreach ($result as $row) {
                    $tbody .= '<tr>
                    <td> ' . $i . ' </td>
                    <td> ' . $row->uin . ' </td>
                    <td> ' . $row->name . ' </td>
                    <td> ' . $row->country  . ' </td>
                    <td> ' . $row->state . ' </td>
                    <td> ' . $row->district  . ' </td>
                    <td> ' . change_date_month_name_char(str_replace('/','-',$row->created_at)) . ' </td>
                    </tr>';
                    $i++;
                }
            }
        }
        $tbody .= '</tbody></table>';
        echo $tbody;
        exit;
    }
}
