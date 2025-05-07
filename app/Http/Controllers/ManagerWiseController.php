<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ManagerWiseReportExport;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;

class ManagerWiseController extends Controller
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
            name AS quality,
                SUM(total) AS total,
                SUM(done_task) AS done_task,
                SUM(pending_task) AS Pending_task,
                verified_by AS id
            FROM
                (
                SELECT
                    u.name,
                    a.id,
                    a.assignment_type,
                    a.assignment_id,
                    a.task_a1,
                    a.verified_by,
                    COUNT(*) AS total,
                    SUM(
                        CASE WHEN(
                            (
                                a.qa_status = 'V' OR a.qa_status = 'R'
                            )
                        ) THEN 1 ELSE 0
                    END
            ) AS done_task,
            SUM(
                CASE WHEN(a.qa_status = 'P') THEN 1 ELSE 0
            END
            ) AS pending_task
            FROM
                task_qa_assignment AS a
            INNER JOIN users AS u
            ON
                a.verified_by = u.id
                WHERE a.is_deleted = 0 AND u.is_deleted = 0
            GROUP BY
                a.verified_by,
                a.assignment_type,
                a.assignment_id,
                a.task_a1
            ORDER BY
                assignment_type
            ) AS a
            GROUP BY
                verified_by";

            $result = DB::select($query);
        // prd($query);
            $total = count($result);
            // prd($result);
            foreach ($result as $res) {

                $row = [];
                $row[] = (++$start);
                $row[] = $res->quality;
                $row[] = $res->total != '' ? $res->total : '0';
                $row[] = $res->done_task != '' ? $res->done_task : '0';
                $row[] = $res->Pending_task != '' ? $res->Pending_task : '0';

                $btns  = '';

                $btns .= '<span class="dropdown-item getdetail" onclick="getTaskDetails(' . $res->id . ')"  style="cursor:pointer"><span class="badge badge-warning">View Task</span></a></span>';

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
            // $userID = $request->get('userID');
            // prd($userID);
            // $query = "SELECT a.name FROM users a WHERE id = $userID ";
            // $data['m_name'] = DB::select($query);

        return view('ManagerWiseReport.list')->with($data);
    }
    public function export_Pdf(Request $request)
    {
        $data = [];
        $total = 0;

        $query = "SELECT
            name AS quality,
                SUM(total) AS total,
                SUM(done_task) AS done_task,
                SUM(pending_task) AS Pending_task,
                verified_by AS id
            FROM
                (
                SELECT
                    u.name,
                    a.id,
                    a.assignment_type,
                    a.assignment_id,
                    a.task_a1,
                    a.verified_by,
                    COUNT(*) AS total,
                    SUM(
                        CASE WHEN(
                            (
                                a.qa_status = 'V' OR a.qa_status = 'R'
                            )
                        ) THEN 1 ELSE 0
                    END
            ) AS done_task,
            SUM(
                CASE WHEN(a.qa_status = 'P') THEN 1 ELSE 0
            END
            ) AS pending_task
            FROM
                task_qa_assignment AS a
            INNER JOIN users AS u
            ON
                a.verified_by = u.id
                WHERE a.is_deleted = 0 AND u.is_deleted = 0
            GROUP BY
                a.verified_by,
                a.assignment_type,
                a.assignment_id,
                a.task_a1
            ORDER BY
                assignment_type
            ) AS a
            GROUP BY
                verified_by";



        $result = DB::select($query);
        $total = count($result);
        //prd($result);


        view()->share('result', $result);
        $pdf_doc = PDF::loadView('pdf.managerWiseReportPdf', $result)->setPaper('a4', 'landscape');
        //prd($result);
        return $pdf_doc->download('Manager_Wise_Report' . '_' . $this->curdate . '.pdf');
    }
    public function export_managerWisePdf(Request $request)
    {

        $userID = $request->get('userID');
        //prd($userID);
        $query = "SELECT * FROM
        (
        SELECT
                    'FEDERATION' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.qa_status,
                    b.manger_date,
                    b.created_at
                FROM
                    federation_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id
                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'FD' AND b.verified_by=$userID

                    UNION ALL

                    SELECT
                    'CLUSTER' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.qa_status,
                    b.manger_date,
                    b.created_at
                FROM
                    cluster_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id
                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'CL' AND b.verified_by=$userID

                    UNION ALL

                    SELECT
                    'SHG' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.qa_status,
                    b.manger_date,
                    b.created_at
                FROM
                    shg_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id
                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'SH' AND b.verified_by=$userID
                    UNION ALL
                    SELECT
                    'FAMILY' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.qa_status,
                    b.manger_date,
                    b.created_at
                FROM
                    family_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id
                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'FM' AND b.verified_by = $userID ) a ORDER BY a.created_at DESC";

        $data['result'] = DB::select($query);
        // prd($data['result']);
        $userID = $request->get('userID');
        // prd($userID);

        $query = "SELECT a.name FROM users a WHERE id = $userID ";
        $data['name'] = DB::select($query);
        $m_name = $data['name'][0]->name;
        $date= date("d-m-Y h:i:s");
        $report=$m_name.'_'.$date.'.pdf';

        view()->share('data$data', $data);
        $pdf_doc = PDF::loadView('pdf.managerTaskAssignmentPdf', $data)->setPaper('a4', 'landscape');
        //prd($result);
        return $pdf_doc->download($report.'_'.pdf_date().'.pdf');
    }
    public function export(Request $request)
    {
        return Excel::download(new ManagerWiseReportExport(), 'ManagerWiseReportExport_'.pdf_date().'.xlsx');
        //return Excel::download(new FacilitatorWiseReportExport(), 'FacilitatorWiseReportExport.xlsx');
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
    public function show(Request $request)
    {
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



    public function get_manager_task_assignment_details(Request $request)
    {

        // prd($data['name']);
        $userID = $request->get('userID');
        // prd($userID);
        $userID = $request->get('userID');
        $query = "SELECT a.name FROM users a WHERE id = $userID ";
        $data['name'] = DB::select($query)[0]->name;
        $name = $data['name'];

        $tbody = '

        <table id="taskTable" class="table mytable" style="width: 100% !important;">
        <thead class="back-color">
        <th colspan="7" style="text-align:center; font-size:20px;" id="manager_name"> '.$name.' </th>
        </thead>
        <thead class="back-color">

        <tr>
            <th>S.No</th>
            <th>Assignment Type</th>
            <th>UIN</th>
            <th>Task</th>
            <th>DM Status</th>
            <th>Task Assigned Date</th>
            <th>Task Completed Date</th>
        </tr>
        </thead><tbody>';
        if (request()->ajax()) {
            if ($request->get('userID') != '') {
                $userID = $request->get('userID');
                // prd($userID);
                $query = "SELECT * FROM
                (
                SELECT
                    'FEDERATION' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.qa_status,
                    b.manger_date,
                    b.created_at

                FROM
                    federation_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id


                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'FD' AND b.verified_by=$userID

                    UNION ALL

                    SELECT
                    'CLUSTER' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.qa_status,
                    b.manger_date,
                    b.created_at
                FROM
                    cluster_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id

                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'CL' AND b.verified_by=$userID

                    UNION ALL

                    SELECT
                    'SHG' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.qa_status,
                    b.manger_date,
                    b.created_at
                FROM
                    shg_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id
                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'SH' AND b.verified_by=$userID
                    UNION ALL
                    SELECT
                    'FAMILY' as type,
                    a.id,
                    b.assignment_id,
                    a.uin,
                    b.task,
                    b.task_a1,
                    b.qa_status,
                    b.manger_date,
                    b.created_at
                FROM
                    family_mst a
                INNER JOIN task_qa_assignment b ON
                    a.id = b.assignment_id
                WHERE
                    a.is_deleted = 0 AND b.is_deleted = 0 AND b.assignment_type = 'FM' AND b.verified_by = $userID ) a ORDER BY a.created_at DESC";

                $result = DB::select($query);
                // prd($result);
                if (!empty($result)) {
                    $i = 1;
                    $task_type = '-';
                    $task_a1 = '-';
                    $qa_status = '-';
                    foreach ($result as $row) {
                        if ($row->task == 'A') {
                            $task_type = 'Analysis';
                        } else {
                            $task_type = 'Rating';
                        }
                        $task_a1 = '';
                        if ($row->type == 'FAMILY') {
                            if ($row->task == 'A') {
                                $task_a1 = '-' . $row->task_a1;
                            }
                        }

                        if ($row->qa_status == 'P') {
                            $qa_status = 'Pending';
                        }
                        if ($row->qa_status == 'V') {
                            $qa_status = 'Verified';
                        }
                        if ($row->qa_status == 'R') {
                            $qa_status = 'Rejected';
                        }
                        $manager_date = change_date_month_name_char($row->manger_date);

                        $tbody .= '<tr>
                        <td> ' . $i . ' </td>
                        <td> ' . $row->type . ' </td>
                        <td> ' . $row->uin . ' </td>
                        <td> ' . $task_type . $task_a1 . ' </td>
                        <td> ' . $qa_status . ' </td>
                        <td> ' . change_date_month_name_char($row->created_at). ' </td>
                        <td> ' . $manager_date . ' </td>
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



}
