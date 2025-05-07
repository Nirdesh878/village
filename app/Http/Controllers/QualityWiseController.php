<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QualityWiseReportExport;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;

class QualityWiseController extends Controller
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
        $user = Auth::User();

        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
        if ($request->ajax()) {
            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');

            $query = "SELECT
                    a.id,
                    a.name as quality,
                    b.total,
                    b.done_task,
                    b.Pending_task
                FROM
                    (
                        (
                        SELECT
                            NAME,
                            id
                        FROM
                            users
                        WHERE
                            u_type = 'QA' AND is_deleted = 0
                    ) a
                LEFT JOIN(
                    SELECT
                        a.quality_verified,
                        COUNT(*) AS total,
                        SUM(CASE WHEN (a.quality_status = 'V' OR a.quality_status = 'R')  THEN 1 ELSE 0 END ) AS done_task,
                        SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END ) AS Pending_task,
                        is_deleted
                FROM
                    task_qa_assignment a
                INNER JOIN(
                    SELECT
                        assignment_id,
                        MAX(id) AS ids,
                        assignment_type
                    FROM
                        task_qa_assignment
                    WHERE is_deleted = 0
                    GROUP BY
                        assignment_type,
                        assignment_id
                    ORDER BY
                        assignment_type
                ) b
                ON
                    a.id = b.ids
                WHERE
                    a.quality_verified != 0 AND a.is_deleted = 0
                GROUP BY
                    a.quality_verified
                ) b
                ON
                    a.id = b.quality_verified
                )";

            $query .= " ORDER BY a.id LIMIT " . $limit . " OFFSET " . $start . " ";
            //prd($query);
            $result = DB::select($query);
            //prd($result);
            $total = count($result);

            foreach ($result as $res) {

                $row = [];
                $row[] = (++$start);
                $row[] = $res->quality;
                $row[] = $res->total != '' ? $res->total : '0';
                $row[] = $res->done_task != '' ? $res->done_task : '0';
                $row[] = $res->Pending_task != '' ? $res->Pending_task : '0';

                $btns  = '';

                $btns .= '<span class="dropdown-item getdetail" onclick="getTaskDetails(' . $res->id . ')" style="cursor:pointer"><span class="badge badge-warning">View Task</span></a></span>';

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
        return view('QualityWiseReport.list')->with($data);
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
        return Excel::download(new QualityWiseReportExport(), 'QualityWiseReportExport' . $this->curdate . '.xlsx');
    }

    public function get_quality_task_assignment_details(Request $request)
    {
        $userID = $request->get('userID');
        // prd($userID);
        $userID = $request->get('userID');
        $query = "SELECT a.name FROM users a WHERE id = $userID ";
        $data['name'] = DB::select($query)[0]->name;
        $name = $data['name'];
        // prd($name);

        $tbody = '<table id="taskTable" class="table mytable" style="width: 100% !important;">
        <thead class="back-color">
        <th colspan="7" style="text-align:center; font-size:20px;"> '.$name.' </th>
        </thead>
        <thead class="back-color">
        <tr>
            <th>S.No</th>
            <th>Assignment Type</th>
            <th>UIN</th>
            <th>Task</th>
            <th>Quality Status</th>
            <th>Task Assigned Date</th>
            <th>Task Completed Date</th>
        </tr>
        </thead><tbody>';
        if (request()->ajax()) {
            if ($request->get('userID') != '') {
                $userID = $request->get('userID');
                $query = "SELECT * FROM
                (
                SELECT
                    'FEDERATION' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.quality_status,
                    b.quality_date,
                    b.created_at
                FROM
                    federation_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id
                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'FD' AND b.quality_verified=$userID

                    UNION ALL

                    SELECT
                    'CLUSTER' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.quality_status,
                    b.quality_date,
                    b.created_at
                FROM
                    cluster_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id
                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'CL' AND b.quality_verified=$userID

                    UNION ALL

                    SELECT
                    'SHG' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.quality_status,
                    b.quality_date,
                    b.created_at
                FROM
                    shg_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id
                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'SH' AND b.quality_verified=$userID
                    UNION ALL
                    SELECT
                    'FAMILY' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.quality_status,
                    b.quality_date,
                    b.created_at
                FROM
                    family_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id
                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'FM' AND (b.task_a1='P2' OR b.task = 'R') AND b.quality_verified = $userID ) a ORDER BY a.created_at DESC";

                $result = DB::select($query);
                // prd($result);
                if (!empty($result)) {
                    $i = 1;
                    $task_type = '-';
                    $task_a1 = '-';
                    $quality_status = '-';
                    foreach ($result as $row) {
                        if ($row->task == 'A') {
                            $task_type = 'Analysis';
                        } else {
                            $task_type = 'Rating';
                        }
                        $task_a1 = '';
                        // if ($row->type == 'FAMILY') {
                        //     if ($row->task == 'A') {
                        //         //$task_a1 = '-'.$row->task_a1;
                        //     }
                        // }

                        if ($row->quality_status == 'P') {
                            $quality_status = 'Pending';
                        }
                        if ($row->quality_status == 'V') {
                            $quality_status = 'Verified';
                        }
                        if ($row->quality_status == 'R') {
                            $quality_status = 'Rejected';
                        }
                        $quality_date = change_date_month_name_char($row->quality_date);
                        $tbody .= '<tr>
                        <td> ' . $i . ' </td>
                        <td> ' . $row->type . ' </td>
                        <td> ' . $row->uin . ' </td>
                        <td> ' . $task_type .$task_a1 . ' </td>
                        <td> ' . $quality_status . ' </td>
                        <td> ' . change_date_month_name_char($row->created_at). ' </td>
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

    public function export_Pdf(Request $request)
    {
        $data = [];
        $total = 0;


        $query = "SELECT
                    a.id,
                    a.name as quality,
                    b.total,
                    b.done_task,
                    b.Pending_task
                FROM
                    (
                        (
                        SELECT
                            NAME,
                            id
                        FROM
                            users
                        WHERE
                            u_type = 'QA' AND is_deleted = 0
                    ) a
                LEFT JOIN(
                    SELECT
                        a.quality_verified,
                        COUNT(*) AS total,
                        SUM(CASE WHEN (a.quality_status = 'V' OR a.quality_status = 'R')  THEN 1 ELSE 0 END ) AS done_task,
                        SUM(CASE WHEN a.quality_status = 'P' THEN 1 ELSE 0 END ) AS Pending_task,
                        a.is_deleted
                FROM
                    task_qa_assignment a
                INNER JOIN(
                    SELECT
                        assignment_id,
                        MAX(id) AS ids,
                        assignment_type
                    FROM
                        task_qa_assignment
                    WHERE is_deleted=0
                    GROUP BY
                        assignment_type,
                        assignment_id
                    ORDER BY
                        assignment_type
                ) b
                ON
                    a.id = b.ids
                WHERE
                    a.quality_verified != 0 AND a.is_deleted=0
                GROUP BY
                    a.quality_verified
                ) b
                ON
                    a.id = b.quality_verified
                )";




        $result = DB::select($query);
        //prd($result);



        view()->share('result', $result);
        $pdf_doc = PDF::loadView('pdf.qualityWiseReportPdf', $result)->setPaper('a4', 'landscape');
        //prd($result);
        return $pdf_doc->download('Quality_Wise_Report'.'_'.pdf_date().'.pdf');
    }
    public function export_qualityWisePdf(Request $request)
    {

        $userID = $request->get('userID');
        $query = "SELECT * FROM
        (
        SELECT
        'FEDERATION' as type,
        a.id,
        b.assignment_id,
        a.uin,
        b.task,
        b.task_a1,
        b.quality_status,
        b.quality_date,
        c.qa_a,
        c.qa_r,
        c.locked,
        b.created_at
    FROM
        federation_mst a
    INNER JOIN federation_sub_mst c ON
        a.id = c.federation_mst_id
    INNER JOIN task_qa_assignment b ON
        a.id = b.assignment_id
    WHERE
        a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'FD' AND b.quality_verified=$userID

        UNION ALL

        SELECT
        'CLUSTER' as type,
        a.id,
        b.assignment_id,
        a.uin,
        b.task,
        b.task_a1,
        b.quality_status,
        b.quality_date,
        c.qa_a,
        c.qa_r,
        c.locked,
        b.created_at
    FROM
        cluster_mst a
    INNER JOIN cluster_sub_mst c ON
        a.id = c.cluster_mst_id
    INNER JOIN task_qa_assignment b ON
        a.id = b.assignment_id
    WHERE
        a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'CL' AND b.quality_verified=$userID

        UNION ALL

        SELECT
        'SHG' as type,
        a.id,
        b.assignment_id,
        a.uin,
        b.task,
        b.task_a1,
        b.quality_status,
        b.quality_date,
        c.qa_a,
        c.qa_r,
        c.locked,
        b.created_at
    FROM
        shg_mst a
    INNER JOIN shg_sub_mst c ON
        a.id = c.shg_mst_id
    INNER JOIN task_qa_assignment b ON
        a.id = b.assignment_id
    WHERE
        a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'SH' AND b.quality_verified=$userID

    UNION ALL

        SELECT
        'FAMILY' as type,
        a.id,
        b.assignment_id,
        a.uin,
        b.task,
        b.task_a1,
        b.quality_status,
        b.quality_date,
        c.qa_p2,
        c.qa_r,
        c.locked,
        b.created_at
    FROM
        family_mst a
    INNER JOIN family_sub_mst c ON
        a.id = c.family_mst_id
    INNER JOIN task_qa_assignment b ON
        a.id = b.assignment_id
    WHERE
        a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'FM' AND (b.task_a1='P2' OR b.task = 'R') AND b.quality_verified=$userID ) a ORDER BY a.created_at DESC";

        $data['result'] = DB::select($query);
        //prd($data['result']);
        $query = "SELECT a.name FROM users a WHERE id = $userID ";
        $data['name'] = DB::select($query);
        $m_name = $data['name'][0]->name;
        //prd($data);
        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.qualityTaskAssignmentPdf', $data)->setPaper('a4', 'landscape');
        //prd($data);
        return $pdf_doc->download($m_name.'_'.pdf_date().'.pdf');
    }
}
