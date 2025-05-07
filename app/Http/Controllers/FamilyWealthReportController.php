<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FamilyWealthReport;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FamilyWealthReportController extends Controller
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
        //die('hi');
        if (!empty($request->get('Search'))) {
            Session::put('fam_filter_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('fam_filter_session');
        }
        $session_data = Session::get('fam_filter_session');
        if ($request->ajax()) {
            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');
            //prd($session_data);
            $query = "SELECT
                    Y.uin,
                    t.fp_member_name,
                    t.fp_spouse_name,
                    t.fp_aadhar_no,
                    t.fp_wealth_rank,
                    t.analysis_rating,
                    h.name_of_federation,
                    b.name_of_cluster,
                    j.shgName,
                    t.fp_state,
                    t.fp_district,
                    t.fp_country,
                    d.agency_name
                FROM
                    family_mst AS Y
                INNER JOIN family_sub_mst AS X
                ON
                    Y.id = X.family_mst_id
                INNER JOIN family_profile AS t
                ON
                    X.id = t.family_sub_mst_id
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
                    Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";

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
                if(trim($session_data['dt_from'])!='' && trim($session_data['dt_to'])!='' && isset($session_data['dt_from']) && isset($session_data['dt_to'])){
                    $dt_from = change_date_format(trim($session_data['dt_from']));
                    $dt_to = change_date_format(trim($session_data['dt_to']));
                    $query .= " AND date(Y.created_at) between '".$dt_from."' AND '".$dt_to."' ";
                }
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

            $families = DB::select($query);
            $total = count($families);

            $query .= "limit $limit ";
            $query .= "offset $start";

            $families = DB::select($query);

            // $total = count($families);

            foreach ($families as $family) {

                $row = [];
                $row[] = ++$start;
                $row[] = $family->uin;
                if (!empty($session_data))
                {
                    if (!empty($session_data['group'])) {
                        if ($session_data['group'] == "FM" && !empty($session_data['federation'])) {
                            $row[] = $family->fp_spouse_name;
                            $row[] = aadhar($family->fp_aadhar_no);
                            $row[] = $family->shgName;
                            $row[] = $family->name_of_cluster != '' ? $family->name_of_cluster : 'N/A';
                            $row[] = $family->name_of_federation;
                            $row[] = $family->agency_name;
                        } elseif ($session_data['group'] == "AG" && !empty($session_data['federation'])) {
                            $row[] = $family->fp_member_name;
                            $row[] = $family->fp_spouse_name;
                            $row[] = aadhar($family->fp_aadhar_no);
                            $row[] = $family->shgName;
                            $row[] = $family->name_of_cluster != '' ? $family->name_of_cluster : 'N/A';
                            $row[] = $family->name_of_federation;
                        } elseif ($session_data['group'] == "FD" && !empty($session_data['federation'])) {
                            $row[] = $family->fp_member_name;
                            $row[] = $family->fp_spouse_name;
                            $row[] = aadhar($family->fp_aadhar_no);
                            $row[] = $family->shgName;
                            $row[] = $family->name_of_cluster != '' ? $family->name_of_cluster : 'N/A';
                            $row[] = $family->agency_name;
                        } elseif ($session_data['group'] == "CL" && !empty($session_data['federation'])) {
                            $row[] = $family->fp_member_name;
                            $row[] = $family->fp_spouse_name;
                            $row[] = aadhar($family->fp_aadhar_no);
                            $row[] = $family->shgName;
                            $row[] = $family->name_of_federation;
                            $row[] = $family->agency_name;
                        } elseif ($session_data['group'] == "SH" && !empty($session_data['federation'])) {
                            $row[] = $family->fp_member_name;
                            $row[] = $family->fp_spouse_name;
                            $row[] = aadhar($family->fp_aadhar_no);
                            $row[] = $family->name_of_cluster != '' ? $family->name_of_cluster : 'N/A';
                            $row[] = $family->name_of_federation;
                            $row[] = $family->agency_name;
                        }
                        elseif ($session_data['group'] == "FM" && empty($session_data['federation'])) {
                            $row[] = $family->fp_member_name;
                            $row[] = $family->fp_spouse_name;
                            $row[] = aadhar($family->fp_aadhar_no);
                            $row[] = $family->shgName;
                            $row[] = $family->name_of_cluster != '' ? $family->name_of_cluster : 'N/A';
                            $row[] = $family->name_of_federation;
                            $row[] = $family->agency_name;
                        }elseif ($session_data['group'] == "AG" && empty($session_data['federation'])) {
                            $row[] = $family->fp_member_name;
                            $row[] = $family->fp_spouse_name;
                            $row[] = aadhar($family->fp_aadhar_no);
                            $row[] = $family->shgName;
                            $row[] = $family->name_of_cluster != '' ? $family->name_of_cluster : 'N/A';
                            $row[] = $family->name_of_federation;
                            $row[] = $family->agency_name;
                        }elseif ($session_data['group'] == "FD" && empty($session_data['federation'])) {
                            $row[] = $family->fp_member_name;
                            $row[] = $family->fp_spouse_name;
                            $row[] = aadhar($family->fp_aadhar_no);
                            $row[] = $family->shgName;
                            $row[] = $family->name_of_cluster != '' ? $family->name_of_cluster : 'N/A';
                            $row[] = $family->name_of_federation;
                            $row[] = $family->agency_name;
                        }elseif ($session_data['group'] == "CL" && empty($session_data['federation'])) {
                            $row[] = $family->fp_member_name;
                            $row[] = $family->fp_spouse_name;
                            $row[] = aadhar($family->fp_aadhar_no);
                            $row[] = $family->shgName;
                            $row[] = $family->name_of_cluster != '' ? $family->name_of_cluster : 'N/A';
                            $row[] = $family->name_of_federation;
                            $row[] = $family->agency_name;
                        }elseif ($session_data['group'] == "SH" && empty($session_data['federation'])) {
                            $row[] = $family->fp_member_name;
                            $row[] = $family->fp_spouse_name;
                            $row[] = aadhar($family->fp_aadhar_no);
                            $row[] = $family->shgName;
                            $row[] = $family->name_of_cluster != '' ? $family->name_of_cluster : 'N/A';
                            $row[] = $family->name_of_federation;
                            $row[] = $family->agency_name;
                        }

                    }
                    else
                    {
                        $row[] = $family->fp_member_name;
                        $row[] = $family->fp_spouse_name;
                        $row[] = aadhar($family->fp_aadhar_no);
                        $row[] = $family->shgName;
                        $row[] = $family->name_of_cluster != '' ? $family->name_of_cluster : 'N/A';
                        $row[] = $family->name_of_federation;
                        $row[] = $family->agency_name;
                    }

                    if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                        {
                            $row[] = $family->fp_district;
                            $row[] = $family->fp_state;
                        }
                        elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district']))
                        {
                            $row[] = $family->fp_district;
                        }

                }

                else{
                    $row[] = $family->fp_member_name;
                    $row[] = $family->fp_spouse_name;
                    $row[] = aadhar($family->fp_aadhar_no);
                    $row[] = $family->shgName;
                    $row[] = $family->name_of_cluster;
                    $row[] = $family->name_of_federation;
                    $row[] = $family->agency_name;
                    $row[] = $family->fp_district;
                    $row[] = $family->fp_state;
                }



                // $row[] = $family->fp_district;
                // $row[] = $family->fp_state;

                $row[] = !empty($family->fp_wealth_rank) > 0 ? $family->fp_wealth_rank : '-';
                if ($family->analysis_rating != '') {
                    $row[] = !empty($family->analysis_rating) > 0 ? $family->analysis_rating : 0;
                    $x1 = ((float)($family->analysis_rating) * 100) / 100;
                    $x2 = $x1 >= 90 ? 'green' : ($x1 >= 75 ? 'yellow' : ($x1 >= 60 ? 'grey' : 'red_status'));
                    $row[] =  "<div class='status_analysis " . $x2 . "' style='margin-left: 35%;margin-bottom: 8%;margin-top: 7%;'></div>";
                } else {
                    $row[] = '-';
                    $row[] = '-';
                }

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
            $where = '';
            if (!empty($session_data['Search'])) {
                if (!empty($session_data['state']))
                    if ($session_data['state'] != '' && $session_data['state'] > 0)
                        $where .= " AND t.fp_state_id = '".$session_data['state']."' ";
                if (!empty($session_data['district']))
                    if ($session_data['district'] != '' && $session_data['district'] > 0)
                        $where .= " AND t.fp_district_id = '".$session_data['district']."' ";
                if (!empty($session_data['country']))
                    if ($session_data['country'] != '' && $session_data['country'] > 0)
                        $where .= " AND t.fp_country_id = '".$session_data['country']."' ";
                if(trim($session_data['dt_from'])!='' && trim($session_data['dt_to'])!='' && isset($session_data['dt_from']) && isset($session_data['dt_to'])){
                    $dt_from = change_date_format(trim($session_data['dt_from']));
                    $dt_to = change_date_format(trim($session_data['dt_to']));
                    $where .= " AND date(Y.created_at) between '".$dt_from."' AND '".$dt_to."' ";
                }
                if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        if($session_data['group'] == 'AG')
                        {
                            $where .= " AND ( d.agency_name like '%".$text_search."%' )";
                        }
                        if($session_data['group'] == 'FM')
                        {
                            $where .= " AND ( t.fp_member_name like '%".$text_search."%' )";
                        }
                        if($session_data['group'] == 'SH')
                        {
                            $where .= " AND ( j.shgName like '%".$text_search."%' )";
                        }
                        if($session_data['group'] == 'CL')
                        {
                            $where .= " AND ( b.name_of_cluster like '%".$text_search."%' )";
                        }
                        if($session_data['group'] == 'FD')
                        {
                            $where .= " AND ( h.name_of_federation like '%".$text_search."%' )";
                        }

                }
            }

            // very poor and destitue
            $query_vpoor = "SELECT
                    COUNT(t.fp_wealth_rank) as total,
                    COUNT(CASE WHEN t.analysis_rating >= 90 THEN 1 END ) AS Rich,
                    COUNT(CASE WHEN(t.analysis_rating >= 75 AND t.analysis_rating <= 89 ) THEN 1 END ) AS MPoor,
                    COUNT(CASE WHEN(t.analysis_rating >= 60 AND t.analysis_rating <= 74 ) THEN 1 END ) AS Poor,
                    COUNT(CASE WHEN(t.analysis_rating < 60 AND t.analysis_rating != '' ) THEN 1 END) AS VPoor
                FROM
                    family_mst AS Y
                INNER JOIN family_sub_mst AS X
                ON
                    Y.id = X.family_mst_id
                INNER JOIN family_profile AS t
                ON
                    X.id = t.family_sub_mst_id
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
                    Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1 AND t.fp_wealth_rank != '' and (t.fp_wealth_rank = 'very poor' OR t.fp_wealth_rank = 'destitute') $where ";

            $data['vpoor'] = DB::select($query_vpoor);

            // poor
            $query_poor = "SELECT
                    COUNT(t.fp_wealth_rank) as total,
                    COUNT(CASE WHEN t.analysis_rating >= 90 THEN 1 END ) AS Rich,
                    COUNT(CASE WHEN(t.analysis_rating >= 75 AND t.analysis_rating <= 89 ) THEN 1 END ) AS MPoor,
                    COUNT(CASE WHEN(t.analysis_rating >= 60 AND t.analysis_rating <= 74 ) THEN 1 END ) AS Poor,
                    COUNT(CASE WHEN(t.analysis_rating < 60 AND t.analysis_rating != '' ) THEN 1 END) AS VPoor
                FROM
                    family_mst AS Y
                INNER JOIN family_sub_mst AS X
                ON
                    Y.id = X.family_mst_id
                INNER JOIN family_profile AS t
                ON
                    X.id = t.family_sub_mst_id
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
                    Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1 AND t.fp_wealth_rank != '' and (t.fp_wealth_rank = 'poor') $where ";
            $data['poor'] = DB::select($query_poor);

            // medium poor
            $query_mediumpoor = "SELECT
                    COUNT(t.fp_wealth_rank) as total,
                    COUNT(CASE WHEN t.analysis_rating >= 90 THEN 1 END ) AS Rich,
                    COUNT(CASE WHEN(t.analysis_rating >= 75 AND t.analysis_rating <= 89 ) THEN 1 END ) AS MPoor,
                    COUNT(CASE WHEN(t.analysis_rating >= 60 AND t.analysis_rating <= 74 ) THEN 1 END ) AS Poor,
                    COUNT(CASE WHEN(t.analysis_rating < 60 AND t.analysis_rating != '' ) THEN 1 END) AS VPoor
                FROM
                    family_mst AS Y
                INNER JOIN family_sub_mst AS X
                ON
                    Y.id = X.family_mst_id
                INNER JOIN family_profile AS t
                ON
                    X.id = t.family_sub_mst_id
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
                    Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1 AND t.fp_wealth_rank != '' and (t.fp_wealth_rank = 'medium poor') $where ";
            $data['mediumpoor'] = DB::select($query_mediumpoor);

            $query_rich = "SELECT
                    COUNT(t.fp_wealth_rank) as total,
                    COUNT(CASE WHEN t.analysis_rating >= 90 THEN 1 END ) AS Rich,
                    COUNT(CASE WHEN(t.analysis_rating >= 75 AND t.analysis_rating <= 89 ) THEN 1 END ) AS MPoor,
                    COUNT(CASE WHEN(t.analysis_rating >= 60 AND t.analysis_rating <= 74 ) THEN 1 END ) AS Poor,
                    COUNT(CASE WHEN(t.analysis_rating < 60 AND t.analysis_rating != '' ) THEN 1 END) AS VPoor
                FROM
                    family_mst AS Y
                INNER JOIN family_sub_mst AS X
                ON
                    Y.id = X.family_mst_id
                INNER JOIN family_profile AS t
                ON
                    X.id = t.family_sub_mst_id
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
                    Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1 AND t.fp_wealth_rank != '' and (t.fp_wealth_rank = 'rich') $where ";
            $data['medium_rich'] = DB::select($query_rich);

            $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();



            //prd($data['family_rank']);
        return view('FamilyWealthReport.list')->with($data);
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
        return Excel::download(new FamilyWealthReport(), 'FamilyWealthReport'.pdf_date().'.xlsx');
        //return Excel::download(new FamilyWealthReport(), 'FamilyWealthReport.xlsx');
    }
    public function exportPDF()
    {
        $session_data = Session::get('fam_filter_session');

        $res = [];

        $query = "SELECT
                    Y.uin,
                    t.fp_member_name,
                    t.fp_spouse_name,
                    t.fp_aadhar_no,
                    t.fp_wealth_rank,
                    t.analysis_rating,
                    h.name_of_federation,
                    b.name_of_cluster,
                    j.shgName,
                    t.fp_state,
                    t.fp_district,
                    t.fp_country,
                    d.agency_name
                FROM
                    family_mst AS Y
                INNER JOIN family_sub_mst AS X
                ON
                    Y.id = X.family_mst_id
                INNER JOIN family_profile AS t
                ON
                    X.id = t.family_sub_mst_id
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
                    Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";

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
                if(trim($session_data['dt_from'])!='' && trim($session_data['dt_to'])!='' && isset($session_data['dt_from']) && isset($session_data['dt_to'])){
                    $dt_from = change_date_format(trim($session_data['dt_from']));
                    $dt_to = change_date_format(trim($session_data['dt_to']));
                    $query .= " AND date(Y.created_at) between '".$dt_from."' AND '".$dt_to."' ";

                }
            }
            $query .= " ORDER BY t.analysis_rating DESC ";
        $res['families'] = DB::select($query);
        $res['session_data'] =  $session_data;
        // return view('family-wealth-report_export_pdf')->with($data);
        view()->share('res', $res);
        $pdf_doc = PDF::loadView('pdf.family-wealth-report_export_pdf', $res)->setPaper('a3', 'landscape');
        return $pdf_doc->download('Family-Wealth-Report_'.pdf_date().'.pdf');
        //return $pdf_doc->stream('family-wealth-report.pdf');
    }
}
