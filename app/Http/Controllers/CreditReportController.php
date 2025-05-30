<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CreditReport;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreditReportController extends Controller
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
        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('/qualitycheck')->with('error', 'You do not have access to this page.');
         }
        $total = 0;
        if (!empty($request->POST('Search'))) {
            Session::put('credit_filter_session', $request->all());
        }
        if (!empty($request->POST('clear'))) {
            $request->session()->forget('credit_filter_session');
        }

        if ($request->ajax()) {
            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');
            $session_data = Session::get('credit_filter_session');
            //prd($session_data);
            $txt_search = $request->post('search')['value'];
            DB::enableQueryLog();
            $query = "SELECT
                    Y.uin,
                    X.id as sub_mst,
                    t.fp_member_name,
                    t.fp_spouse_name,
                    t.fp_aadhar_no,
                    t.fp_wealth_rank,
                    t.analysis_rating,
                    h.name_of_federation,
                    b.name_of_cluster,
                    j.shgName,
                    d.agency_name,
                    tt.principal
                FROM
                    family_mst AS Y
                INNER JOIN family_sub_mst AS X
                ON
                    Y.id = X.family_mst_id
                INNER JOIN family_profile AS t
                ON
                    X.id = t.family_sub_mst_id
                INNER JOIN family_loan_repayment AS tt
                ON
                    X.id = tt.family_sub_mst_id
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
                WHERE
                    Y.is_deleted = 0 AND X.qa_p2='V' AND X.locked=1 ";
            if (!empty($session_data['Search'])) {
                if (!empty($session_data['state']))
                    if ($session_data['state'] != '' && $session_data['state'] > 0)
                        $query .= " AND t.fp_state_id = '".$session_data['state']."' ";
                if (!empty($session_data['district']))
                    if ($session_data['district'] != '' && $session_data['district'] > 0)
                        $query .= " AND t.fp_district_id = '".$session_data['district']."' ";
                if (!empty($session_data['country']))
                    if ($session_data['country'] != '' && $session_data['country'] > 0)
                        $query .= " AND t.fp_country_id = '".$session_data['country']."' ";
                if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        if($session_data['group'] == 'AG')
                        {
                            $query .= " AND ( d.agency_name like '%".$text_search."%' )";
                        }
                        if($session_data['group'] == 'FM')
                        {
                            $query .= " AND ( t.fp_member_name like '%".$text_search."%' )";
                        }
                        if($session_data['group'] == 'SH')
                        {
                            $query .= " AND ( j.shgName like '%".$text_search."%' )";
                        }
                        if($session_data['group'] == 'CL')
                        {
                            $query .= " AND ( b.name_of_cluster like '%".$text_search."%' )";
                        }
                        if($session_data['group'] == 'FD')
                        {
                            $query .= " AND ( h.name_of_federation like '%".$text_search."%' )";
                        }

                }
            }
            $query .= " ORDER BY t.analysis_rating DESC ";
            $credit_result = DB::select($query);
            $total = count($credit_result);
            $query .= "limit $limit ";
            $query .= "offset $start";
            $credit_result = DB::select($query);
            //prd($aaa);
            foreach ($credit_result as $credit) {

                $row = [];
                $row[] = ++$start;
                $row[] = $credit->uin;
                $row[] = $credit->fp_member_name;
                $row[] = $credit->fp_spouse_name;
                $row[] = aadhar($credit->fp_aadhar_no);
                $row[] = $credit->shgName;
                $row[] = $credit->name_of_cluster;
                $row[] = $credit->name_of_federation;
                $row[] = $credit->analysis_rating;
                $row[] = '₹' .$credit->principal;
                $row[] = '<a data-toggle="modal" data-id="'.$credit->sub_mst.'" href="#exampleModalCenter" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter"><i class="c-white-500 ti-eye"></i></a>';
                $row[] = '-';
                $row[] ='<a data-toggle="modal" data-id="'.$credit->sub_mst.'" href="#exampleModalCenter1" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter1"><i class="c-white-500 ti-eye"></i></a>';

                $row[] = '₹' .$credit->principal;
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
        return view('creditreport.list')->with($data);
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
        return Excel::download(new CreditReport(), 'CreditReport'.pdf_date().'.xlsx');

    }
}
