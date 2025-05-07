<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FacilitatorWiseReportExport;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;

class FacilitatorWiseReportController extends Controller
{
    public $curdate = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->curdate = Carbon::now()->format('d-m-Y');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $total = 0;
        if (!empty($request->get('Search'))) {
            Session::put('facilitator_filter_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('facilitator_filter_session');
        }
        if ($request->ajax()) {
            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');
            $session_data = Session::get('facilitator_filter_session');
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
            
            // $query = "SELECT
            //         a.id,
            //         a.name as fac_name,
            //         c.name as country_name,
            //         d.name as state_name,
            //         d.id   as st_id,
            //         e.name as district_name,
            //         z.*
            //     FROM
            //         users a
            //     INNER JOIN user_location_relation b ON
            //         a.id = b.user_id
            //     INNER JOIN countries c ON
            //         b.country_id = c.id
            //     INNER JOIN states d ON
            //         b.state_id = d.id
            //     LEFT JOIN district e ON
            //         b.district_id = e.id
            //     LEFT JOIN(
            //         SELECT
            //             user_id,
            //             SUM(
            //                 CASE WHEN(a.status = 'P' || a.status = 'D') THEN 1 ELSE 0
            //             END
            //     ) AS total,
            //     SUM(
            //         CASE WHEN(a.status = 'D') THEN 1 ELSE 0
            //     END
            //     ) AS done
            //     FROM
            //         (
            //         SELECT
            //             user_id,
            //         STATUS AS
            //     STATUS
            //     FROM
            //         task_assignment
            //     WHERE
            //         1 = 1 AND is_deleted = 0 $main_query_where_date
            //     ) a
            //     GROUP BY
            //         user_id
            //     ) z ON a.id=z.user_id
            //     WHERE
            //         a.is_deleted = 0 AND b.is_deleted = 0 AND a.u_type = 'F' $main_query_where ";

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
            $query .= " LIMIT " . $limit . " OFFSET " . $start . " ";

            // prd($query);
            $result = DB::select($query);

            $total = count($result);

            foreach ($result as $res) {
                $total_task = 0;
                $done = 0;
                if ($res->total != '') {
                    $total_task =  $res->total;
                }
                if ($res->done != '') {
                    $done =  $res->done;
                }
                $row = [];
                $row[] = (++$start) . "<br>";
                $row[] = $res->country_name;
                $row[] = $res->state_name;
                $row[] = $res->fac_name;
                $row[] = $total_task;
                $row[] = $done;
                $row[] = $total_task - $done;
                $state_id= 0;
                if($res->state_id !='')
                {
                  $state_id= $res->state_id;
                }
                else{
                    $state_id= 0;
                }
                $btns  = '';

                $btns .= '<span class="dropdown-item getdetail" onclick="getTaskDetails(' . $res->id . ',' . $state_id . ')" style="cursor:pointer"><span class="badge badge-warning">View Task</span></a></span>';

                $row[] = $btns;
                $data[] = $row;
            }

            $output = array(
                "draw"            => $request->post('draw'),
                "recordsTotal"    => $total,
                "recordsFiltered" => $total,
                "data"            => $data,
            );
            echo json_encode($output);
            exit;
        }
        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        return view('facilitatorWiseReport.list')->with($data);
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

    public function export(Request $request)
    {
        return Excel::download(new FacilitatorWiseReportExport(), 'FacilitatorWiseReportExport' . pdf_date() . '.xlsx');
        //return Excel::download(new FacilitatorWiseReportExport(), 'FacilitatorWiseReportExport.xlsx');
    }

    public function get_task_assignment_details(Request $request)
    {
        $userID = $request->get('userID');

        $userID = $request->get('userID');
        $query = "SELECT a.name FROM users a WHERE id = $userID ";
        $data['name'] = DB::select($query)[0]->name;
        $name = $data['name'];

        $tbody = '<table id="taskTable" class="table mytable" style="width: 100% !important;">
        <thead class="back-color">
        <th colspan="10" style="text-align:center; font-size:20px;"> ' . $name . ' </th>
        </thead>
        <thead class="back-color">
        <tr>
            <th>S.No</th>
            <th>UIN</th>
            <th>Assignment Type</th>
            <th>Task</th>
            <th>Task Assign Date</th>
            <th>Task Submitted Date</th>
            <th>Manager Status</th>
            <th>Manager Verified</th>
            <th>QA Status</th>
            <th>QA Verified </th>

        </tr>
        </thead><tbody>';
        if (request()->ajax()) {
            if ($request->get('userID') != '') {

                $userID = $request->get('userID');
                $state_id = $request->get('state_id');
                $query = "SELECT assignment_type as type FROM `task_assignment` where user_id = $userID ";
                $res = DB::select($query);


                $query = "SELECT * FROM (SELECT
                'FEDERATION' AS type,
                '1' AS type_id,
                a.id,
                b.assignment_id,
                a.uin AS uin,
                b.task,
                b.task_a1,
                b.qa_status,
                b.manger_date,
                b.quality_date,
                b.quality_status,
                b.created_at,
                b.status,
                b.updated_at,
                b.updated_task
                
            FROM
                federation_mst a
            INNER JOIN federation_sub_mst d ON
                a.id = d.federation_mst_id
            INNER JOIN federation_profile e ON
                d.id = e.federation_sub_mst_id
            INNER JOIN(
                SELECT
                    a.status,
                    a.assignment_id,
                    a.task,
                    a.task_a1,
                    a.created_at,
                    a.updated_at,
                    a.user_id,
                    b.qa_status,
                    b.manger_date,
                    b.quality_date,
                    b.quality_status,
                    b.assignment_type,
                    b.updated_at as updated_task
                FROM
                    task_assignment a
                LEFT JOIN task_qa_assignment b ON
                    a.assignment_id = b.assignment_id AND a.asgtkn=b.asgtkn 
                WHERE
                    a.assignment_type = 'FD' AND a.user_id = $userID AND a.is_deleted=0 
                
            ) b
            ON
                a.id = b.assignment_id
            WHERE
                a.is_deleted = 0 AND e.state_id = $state_id
                
            UNION ALL
            
            SELECT
                'CLUSTER' AS type,
                '2' AS type_id,
                a.id,
                b.assignment_id,
                a.uin AS uin,
                b.task,
                b.task_a1,
                b.qa_status,
                b.manger_date,
                b.quality_date,
                b.quality_status,
                b.created_at,
                b.status,
                b.updated_at,
                b.updated_task
            FROM
                cluster_mst a
            INNER JOIN cluster_sub_mst d ON
                a.id = d.cluster_mst_id
            INNER JOIN cluster_profile e ON
                d.id = e.cluster_sub_mst_id
            INNER JOIN(
                SELECT
                    a.status,
                    a.assignment_id,
                    a.task,
                    a.task_a1,
                    a.created_at,
                    a.updated_at,
                    a.user_id,
                    b.qa_status,
                    b.manger_date,
                    b.quality_date,
                    b.quality_status,
                    b.assignment_type,
                    b.updated_at as updated_task
                FROM
                    task_assignment a
                LEFT JOIN task_qa_assignment b ON
                    a.assignment_id = b.assignment_id AND a.asgtkn=b.asgtkn
                WHERE
                    a.assignment_type = 'CL' AND a.user_id = $userID AND a.is_deleted=0 
               
            ) b
            ON
                a.id = b.assignment_id
            WHERE
                a.is_deleted = 0 AND e.state_id = $state_id
            
            UNION ALL

            SELECT
                'SHG' AS type,
                '3' AS type_id,
                a.id,
                b.assignment_id,
                a.uin AS uin,
                b.task,
                b.task_a1,
                b.qa_status,
                b.manger_date,
                b.quality_date,
                b.quality_status,
                b.created_at,
                b.status,
                b.updated_at,
                b.updated_task
            FROM
                shg_mst a
            INNER JOIN shg_sub_mst d ON
                a.id = d.shg_mst_id
            INNER JOIN shg_profile e ON
                d.id = e.shg_sub_mst_id
            INNER JOIN(
                SELECT
                    a.status,
                    a.assignment_id,
                    a.task,
                    a.task_a1,
                    a.created_at,
                    a.updated_at,
                    a.user_id,b.qa_status,
                    b.manger_date,
                    b.quality_date,
                    b.quality_status,
                    b.assignment_type,
                    b.updated_at as updated_task
                FROM
                    task_assignment a
                LEFT JOIN task_qa_assignment b ON
                    a.assignment_id = b.assignment_id AND a.asgtkn=b.asgtkn
                WHERE
                    a.assignment_type = 'SH' AND a.user_id = $userID AND a.is_deleted=0 
                
            ) b
            ON
                a.id = b.assignment_id
            WHERE
                a.is_deleted = 0 AND e.state_id = $state_id
                
            UNION ALL

            SELECT
            'FAMILY' AS type,
            '4' AS type_id,
            a.id,
            b.assignment_id,
            a.uin AS uin,
            b.task,
            b.task_a1,
            b.qa_status,
            b.manger_date,
            b.quality_date,
            b.quality_status,
            b.created_at,
            b.status,
            b.updated_at,
            b.updated_task
            FROM
                family_mst a
            INNER JOIN family_sub_mst d ON
                a.id = d.family_mst_id
            INNER JOIN family_profile e ON
                d.id = e.family_sub_mst_id
            INNER JOIN(
                SELECT
                    a.status,
                    a.assignment_id,
                    a.task,
                    a.task_a1,
                    a.created_at,
                    a.updated_at,
                    a.user_id,
                    b.qa_status,
                    b.manger_date,
                    b.quality_date,
                    b.quality_status,
                    b.assignment_type,
                    b.updated_at as updated_task
                FROM
                    task_assignment a
                LEFT JOIN task_qa_assignment b ON
                    a.assignment_id = b.assignment_id  AND a.asgtkn=b.asgtkn
                WHERE
                    a.assignment_type = 'FM' AND a.user_id = $userID
                AND a.is_deleted=0  
                
            ) b
            ON
                a.id = b.assignment_id
            WHERE
                a.is_deleted = 0 AND e.fp_state_id = $state_id)m ORDER BY m.created_at DESC ";

                $result = DB::select($query);
                // prd($query);

                if (!empty($result)) {
                    $i = 1;
                    foreach ($result as $row) {
                        $part = '';
                        if ($row->type == 'FAMILY') {
                            if ($row->task == 'A') {
                                $part = ' - ' . $row->task_a1;
                            }
                        }
                        if ($row->task == 'A') {
                            $task = 'Analytics';
                        } else {
                            $task = 'Rating';
                        }
                        if ($row->status == 'D') {
                            if ($row->qa_status == 'P') {
                                $dm_status = 'Pending';
                            }
                            if ($row->qa_status == 'V') {
                                $dm_status = 'Verified';
                            }
                            if ($row->qa_status == 'R') {
                                $dm_status = 'Rejected';
                            }
                            if ($row->qa_status == '') {
                                $dm_status = '-';
                            }
                        } else {
                            $dm_status = '-';
                        }
                        if ($row->quality_status == 'P') {
                            $quality_status = 'Pending';
                        }
                        if ($row->quality_status == 'V') {
                            $quality_status = 'Verified';
                        }
                        if ($row->quality_status == 'R') {
                            $quality_status = 'Rejected';
                        }
                        if ($row->quality_status == '') {
                            $quality_status = '-';
                        }
                        if ($row->status == 'D') {
                            $submit_status = change_date_month_name_char($row->updated_at);
                        } else {
                            $submit_status = '-';
                        }

                        $manager_date = change_date_month_name_char($row->manger_date);
                        $quality_date = change_date_month_name_char($row->quality_date);

                        $tbody .= '<tr>
                        <td> ' . $i . ' </td>
                        <td> ' . $row->uin . ' </td>
                        <td> ' . $row->type . ' </td>
                        <td> ' . $task . $part . ' </td>
                        <td> ' . change_date_month_name_char($row->created_at) . ' </td>
                        
                        <td> ' . $submit_status . ' </td>
                        
                        <td> ' . $dm_status . ' </td>
                        <td> ' . $manager_date . ' </td>
                        
                        <td> ' . $quality_status . ' </td>
                        <td> ' . $quality_date . ' </td>
                        
                        </tr>';
                        $i++;
                    }
                }
            }
        }
        $tbody .= '</tbody></table>';
        echo $tbody;
        exit;
    }

    public function exportPDF()
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
        // $query = "SELECT
        //                 a.id,
        //                 a.name as fac_name,
        //                 c.name as country_name,
        //                 d.name as state_name,
        //                 d.id   as st_id,
        //                 e.name as district_name,
        //                 z.*
        //             FROM
        //                 users a
        //             INNER JOIN user_location_relation b ON
        //                 a.id = b.user_id
        //             INNER JOIN countries c ON
        //                 b.country_id = c.id
        //             INNER JOIN states d ON
        //                 b.state_id = d.id
        //             LEFT JOIN district e ON
        //                 b.district_id = e.id
        //             LEFT JOIN(
        //                 SELECT
        //                     user_id,
        //                     SUM(
        //                         CASE WHEN(a.status = 'P' || a.status = 'D') THEN 1 ELSE 0
        //                     END
        //             ) AS total,
        //             SUM(
        //                 CASE WHEN(a.status = 'D') THEN 1 ELSE 0
        //             END
        //             ) AS done
        //             FROM
        //                 (
        //                 SELECT
        //                     user_id,
        //                 STATUS AS
        //             STATUS
        //             FROM
        //                 task_assignment
        //             WHERE
        //                 1 = 1 AND is_deleted = 0 $main_query_where_date
        //             ) a
        //             GROUP BY
        //                 user_id
        //             ) z ON a.id=z.user_id
        //             WHERE
        //                 a.is_deleted = 0 AND b.is_deleted = 0 AND a.u_type = 'F' $main_query_where ";
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
                a.u_type = 'F' AND a.is_deleted =0
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
                a.assignment_type = 'FD' AND a.is_deleted = 0
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
                a.assignment_type = 'CL' AND a.is_deleted = 0
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
                a.assignment_type = 'SH' AND a.is_deleted = 0
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
                a.assignment_type = 'FM' AND a.is_deleted = 0
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




        $res['dataset'] = DB::select($query);
        $res['session_data'] =  $session_data;
        view()->share('res', $res);
        $pdf_doc = PDF::loadView('pdf.facilitatorWiseReportPdf', $res)->setPaper('a4', 'landscape');
        return $pdf_doc->download('Facilitator_Wise_Report_' . pdf_date() . '.pdf');
        //return $pdf_doc->download('facilitatorwisereport.pdf');
    }
    public function export_taskPDF(Request $request)
    {

        $userID = $request->get('userID');

        $state_id = $request->get('state_id');
        $query = "SELECT assignment_type as type FROM `task_assignment` where user_id = $userID ";
        $res = DB::select($query);

        $query = "SELECT * FROM (SELECT
                'FEDERATION' AS type,
                '1' AS type_id,
                a.id,
                b.assignment_id,
                a.uin AS uin,
                b.task,
                b.task_a1,
                b.qa_status,
                b.manger_date,
                b.quality_date,
                b.quality_status,
                b.created_at,
                b.status,
                b.updated_at,
                b.updated_task
                
            FROM
                federation_mst a
            INNER JOIN federation_sub_mst d ON
                a.id = d.federation_mst_id
            INNER JOIN federation_profile e ON
                d.id = e.federation_sub_mst_id
            INNER JOIN(
                SELECT
                    a.status,
                    a.assignment_id,
                    a.task,
                    a.task_a1,
                    a.created_at,
                    a.updated_at,
                    a.user_id,
                    b.qa_status,
                    b.manger_date,
                    b.quality_date,
                    b.quality_status,
                    b.assignment_type,
                    b.updated_at as updated_task
                FROM
                    task_assignment a
                LEFT JOIN task_qa_assignment b ON
                    a.assignment_id = b.assignment_id AND a.asgtkn=b.asgtkn 
                WHERE
                    a.assignment_type = 'FD' AND a.user_id = $userID AND a.is_deleted=0 
                
            ) b
            ON
                a.id = b.assignment_id
            WHERE
                a.is_deleted = 0 AND e.state_id = $state_id
                
            UNION ALL
            
            SELECT
                'CLUSTER' AS type,
                '2' AS type_id,
                a.id,
                b.assignment_id,
                a.uin AS uin,
                b.task,
                b.task_a1,
                b.qa_status,
                b.manger_date,
                b.quality_date,
                b.quality_status,
                b.created_at,
                b.status,
                b.updated_at,
                b.updated_task
            FROM
                cluster_mst a
            INNER JOIN cluster_sub_mst d ON
                a.id = d.cluster_mst_id
            INNER JOIN cluster_profile e ON
                d.id = e.cluster_sub_mst_id
            INNER JOIN(
                SELECT
                    a.status,
                    a.assignment_id,
                    a.task,
                    a.task_a1,
                    a.created_at,
                    a.updated_at,
                    a.user_id,
                    b.qa_status,
                    b.manger_date,
                    b.quality_date,
                    b.quality_status,
                    b.assignment_type,
                    b.updated_at as updated_task
                FROM
                    task_assignment a
                LEFT JOIN task_qa_assignment b ON
                    a.assignment_id = b.assignment_id AND a.asgtkn=b.asgtkn
                WHERE
                    a.assignment_type = 'CL' AND a.user_id = $userID AND a.is_deleted=0 
               
            ) b
            ON
                a.id = b.assignment_id
            WHERE
                a.is_deleted = 0 AND e.state_id = $state_id
            
            UNION ALL

            SELECT
                'SHG' AS type,
                '3' AS type_id,
                a.id,
                b.assignment_id,
                a.uin AS uin,
                b.task,
                b.task_a1,
                b.qa_status,
                b.manger_date,
                b.quality_date,
                b.quality_status,
                b.created_at,
                b.status,
                b.updated_at,
                b.updated_task
            FROM
                shg_mst a
            INNER JOIN shg_sub_mst d ON
                a.id = d.shg_mst_id
            INNER JOIN shg_profile e ON
                d.id = e.shg_sub_mst_id
            INNER JOIN(
                SELECT
                    a.status,
                    a.assignment_id,
                    a.task,
                    a.task_a1,
                    a.created_at,
                    a.updated_at,
                    a.user_id,b.qa_status,
                    b.manger_date,
                    b.quality_date,
                    b.quality_status,
                    b.assignment_type,
                    b.updated_at as updated_task
                FROM
                    task_assignment a
                LEFT JOIN task_qa_assignment b ON
                    a.assignment_id = b.assignment_id AND a.asgtkn=b.asgtkn
                WHERE
                    a.assignment_type = 'SH' AND a.user_id = $userID AND a.is_deleted=0 
                
            ) b
            ON
                a.id = b.assignment_id
            WHERE
                a.is_deleted = 0 AND e.state_id = $state_id
                
            UNION ALL

            SELECT
            'FAMILY' AS type,
            '4' AS type_id,
            a.id,
            b.assignment_id,
            a.uin AS uin,
            b.task,
            b.task_a1,
            b.qa_status,
            b.manger_date,
            b.quality_date,
            b.quality_status,
            b.created_at,
            b.status,
            b.updated_at,
            b.updated_task
            FROM
                family_mst a
            INNER JOIN family_sub_mst d ON
                a.id = d.family_mst_id
            INNER JOIN family_profile e ON
                d.id = e.family_sub_mst_id
            INNER JOIN(
                SELECT
                    a.status,
                    a.assignment_id,
                    a.task,
                    a.task_a1,
                    a.created_at,
                    a.updated_at,
                    a.user_id,
                    b.qa_status,
                    b.manger_date,
                    b.quality_date,
                    b.quality_status,
                    b.assignment_type,
                    b.updated_at as updated_task
                FROM
                    task_assignment a
                LEFT JOIN task_qa_assignment b ON
                    a.assignment_id = b.assignment_id  AND a.asgtkn=b.asgtkn
                WHERE
                    a.assignment_type = 'FM' AND a.user_id = $userID
                AND a.is_deleted=0  
                
            ) b
            ON
                a.id = b.assignment_id
            WHERE
                a.is_deleted = 0 AND e.fp_state_id = $state_id)m ORDER BY m.created_at DESC ";

        $data['result'] = DB::select($query);

        // prd($data['result']);
        $query = "SELECT a.name FROM users a WHERE id = $userID ";
        $data['name'] = DB::select($query);

        $qry = "SELECT a.name FROM users a WHERE id = $userID";
        $name = DB::select($qry);
        $fac_name = $name[0]->name;
        $date = date("d-m-Y h:i:s");
        $report = $fac_name . '_' . $date . '.pdf';

        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.taskassignedReportPdf', $data)->setPaper('a3', 'landscape');

        return $pdf_doc->download($report);
    }
}
