<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Credit_loan;
use Illuminate\Support\Facades\Auth;

class CreditLoanReportController extends Controller
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
            return redirect('/qualitycheck')->with('error', 'You do not have access to this page.');
         }
        if (!empty($request->get('Search'))) {
            Session::put('credit_loan_filter_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('credit_loan_filter_session');
        }
        $session_data = Session::get('credit_loan_filter_session');

        // pr($session_data);
        $query = "SELECT
                SUM(c.principal) as loan_demand,
                SUM(d.uloan_amount) as loan_approved,
                SUM(e.loan_amount) as loan_disbursed
            FROM
                family_mst a
            INNER JOIN family_sub_mst b ON
                a.id = b.family_mst_id
            INNER JOIN family_profile f ON
                b.id = f.family_sub_mst_id
            INNER JOIN family_loan_repayment c ON
                b.id = c.family_sub_mst_id
            INNER JOIN family_loan_approvel d ON
                b.id = d.family_sub_mst_id
            INNER JOIN family_loan_disbursement e ON
                b.id = e.family_sub_mst_id
            INNER JOIN agency g ON
                a.agency_id = g.agency_id
            INNER JOIN shg_mst h ON
                a.shg_uin = h.uin
            LEFT JOIN cluster_mst i ON
                a.cluster_uin = i.uin
            INNER JOIN federation_mst j ON
                a.federation_uin = j.uin
            WHERE
            a.is_deleted = 0 AND b.qa_p2='V' AND b.locked=1";

                // a.is_deleted = 0 AND b.qa_p2='V' AND (d.get_verified = 'Verified' OR e.get_loan = 'Yes')AND b.locked=1";

        if (!empty($session_data['Search'])) {
            // pr("hello");
            if (!empty($session_data['federation'])) {
                $text = $session_data['federation'];
                preg_match('#\((.*?)\)#', $text, $match);
                $uin = $match[1];
            }

            // prd($uin);
            if (!empty($session_data['state'])) {


                    $query .= " AND f.fp_state_id = '" . $session_data['state'] . "' ";

            }
            if (!empty($session_data['district'])) {

                    $query .= " AND f.fp_district_id = '" . $session_data['district'] . "' ";

            }
            if (!empty($session_data['country'])) {
                    $query .= " AND f.fp_country_id = '" . $session_data['country'] . "' ";
            }


            if (!empty($session_data['group'] == 'FD')) {
                if (!empty($session_data['federation'])) {
                        $query .= " AND a.federation_uin = '" . $uin . "' ";

                }
            }
            if (!empty($session_data['group'] == 'CL')) {
                if (!empty($session_data['federation'])) {
                        $query .= " AND a.cluster_uin = '" . $uin . "' ";
                    }

            }
            if (!empty($session_data['group'] == 'SH')) {
                if (!empty($session_data['federation'])) {
                        $query .= " AND a.shg_uin = '" . $uin . "' ";
                }
            }
            if (!empty($session_data['group'] == 'FM')) {
                // prd("kkk");
                if (!empty($session_data['federation'])) {
                        $query .= " AND a.uin = '" . $uin . "' ";

                }
            }
            if (!empty($session_data['group'] == 'AG')) {
                if (!empty($session_data['federation'])) {

                        $query .= " AND a.agency_id = '" . $uin . "' ";

                }
            }
        }
        // prd($query);


        $data['loans'] = DB::select($query);
        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        //prd($data['loans']);

        return view('creditloanreport.list')->with($data);
    }
    public function export_pdf()
    {
        $session_data = Session::get('credit_loan_filter_session');
        $query = "SELECT
        SUM(c.principal) as loan_demand,
        SUM(d.uloan_amount) as loan_approved,
        SUM(e.loan_amount) as loan_disbursed
            FROM
                family_mst a
            INNER JOIN family_sub_mst b ON
                a.id = b.family_mst_id
            INNER JOIN family_profile f ON
                b.id = f.family_sub_mst_id
            INNER JOIN family_loan_repayment c ON
                b.id = c.family_sub_mst_id
            INNER JOIN family_loan_approvel d ON
                b.id = d.family_sub_mst_id
            INNER JOIN family_loan_disbursement e ON
                b.id = e.family_sub_mst_id
            INNER JOIN agency g ON
                a.agency_id = g.agency_id
            INNER JOIN shg_mst h ON
                a.shg_uin = h.uin
            LEFT JOIN cluster_mst i ON
                a.cluster_uin = i.uin
            INNER JOIN federation_mst j ON
                a.federation_uin = j.uin
            WHERE
                a.is_deleted = 0 AND b.qa_p2='V' AND (d.get_verified = 'Verified' OR e.get_loan = 'Yes')AND b.locked=1";

            if (!empty($session_data['Search'])) {
                // pr("hello");
                if (!empty($session_data['federation'])) {
                    $text = $session_data['federation'];
                    preg_match('#\((.*?)\)#', $text, $match);
                    $uin = $match[1];
                }

                // prd($uin);
                if (!empty($session_data['state'])) {


                        $query .= " AND f.fp_state_id = '" . $session_data['state'] . "' ";

                }
                if (!empty($session_data['district'])) {

                        $query .= " AND f.fp_district_id = '" . $session_data['district'] . "' ";

                }
                if (!empty($session_data['country'])) {
                        $query .= " AND f.fp_country_id = '" . $session_data['country'] . "' ";
                }


                if (!empty($session_data['group'] == 'FD')) {
                    if (!empty($session_data['federation'])) {
                            $query .= " AND a.federation_uin = '" . $uin . "' ";

                    }
                }
                if (!empty($session_data['group'] == 'CL')) {
                    if (!empty($session_data['federation'])) {
                            $query .= " AND a.cluster_uin = '" . $uin . "' ";
                        }

                }
                if (!empty($session_data['group'] == 'SH')) {
                    if (!empty($session_data['federation'])) {
                            $query .= " AND a.shg_uin = '" . $uin . "' ";
                    }
                }
                if (!empty($session_data['group'] == 'FM')) {
                    // prd("kkk");
                    if (!empty($session_data['federation'])) {
                            $query .= " AND a.uin = '" . $uin . "' ";

                    }
                }
                if (!empty($session_data['group'] == 'AG')) {
                    if (!empty($session_data['federation'])) {

                            $query .= " AND a.agency_id = '" . $uin . "' ";

                    }
                }
            }
        $data['loans'] = DB::select($query);
        // prd($data['loans']);
        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.creditLoanPdf', $data)->setPaper('a4', 'landscape');

        return $pdf_doc->download('Credit_loan_PDF' . pdf_date() . '.pdf');
    }

    public function export(Request $request)
    {

        return Excel::download(new Credit_loan(), 'Credit_loan' . pdf_date() . '.xlsx');
    }

    public function get_credit_suggestion(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('query')) {
                $group = $request->get('group');
                $query = $request->get('query');
                $country= $request->get('country');
                $state = $request->get('state');
                $district = $request->get('district');
                //prd($group);
                if ($group == "FD") {
                    $res =DB::table('federation_profile as a')
                    ->join('federation_mst as b', 'b.id', '=', 'a.federation_sub_mst_id')
                    ->select('a.name_of_federation', 'b.uin')
                    ->where('a.name_of_federation', 'like', '%'.$query.'%')
                    ->where('b.is_deleted', '=', 0);

                    if ($country>0) {
                        $res->where('a.country_id', '=', $country);
                    }
                    if ($state>0) {
                        $res->where('a.state_id', '=', $state);
                    }
                    if ($district>0) {
                        $res->where('a.district_id', '=', $district);
                    }
                    $data =$res->get()->toArray();
                    // prd($data);
                    $output ='<ul class="dropdown-menu" style="display:block;">';
                    if (count($data) > 0) {
                        foreach ($data as $row) {
                            $output .='<li><a href="javascript:;" class="record" style="width:300px;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->name_of_federation.' ('.$row->uin.')</a></li>';
                        }
                    } else {
                        $output .='<li><a href="javascript:;" class="norecord" style="width:300px;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
                    }


                    $output .='</ul>';
                    echo $output;
                }

                if ($group == "CL") {
                    //prd($group);
                    $res =DB::table('cluster_profile as a')
                        ->join('cluster_mst as b', 'b.id', '=', 'a.cluster_sub_mst_id')
                        ->select('a.name_of_cluster', 'b.uin')
                        ->where('a.name_of_cluster', 'like', '%'.$query.'%')
                        ->where('b.is_deleted', '=', 0);
                    if ($country>0) {
                        $res->where('a.country_id', '=', $country);
                    }
                    if ($state>0) {
                        $res->where('a.state_id', '=', $state);
                    }
                    if ($district>0) {
                        $res->where('a.district_id', '=', $district);
                    }
                    $data =$res->get()->toArray();
                    $output ='<ul class="dropdown-menu" style="display:block;">';
                    if (count($data) > 0) {
                        foreach ($data as $row) {
                            $output .='<li><a href="javascript:;" class="record" style="width:300px;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->name_of_cluster.' ('.$row->uin.')</a></li>';
                        }
                    } else {
                        $output .='<li><a href="javascript:;" class="norecord" style="width:300px;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
                    }


                    $output .='</ul>';
                    echo $output;
                }
                if ($group == "SH") {
                    //prd($group);
                    $res =DB::table('shg_profile as a')
                            ->join('shg_mst as b', 'b.id', '=', 'a.shg_sub_mst_id')
                            ->select('a.shgName', 'b.uin')
                            ->where('a.shgName', 'like', '%'.$query.'%')
                            ->where('b.is_deleted', '=', 0);
                    if ($country>0) {
                        $res->where('a.country_id', '=', $country);
                    }
                    if ($state>0) {
                        $res->where('a.state_id', '=', $state);
                    }
                    if ($district>0) {
                        $res->where('a.district_id', '=', $district);
                    }
                    $data =$res->get()->toArray();
                    $output ='<ul class="dropdown-menu" style="display:block;">';
                    if (count($data) > 0) {
                        foreach ($data as $row) {
                            $output .='<li><a href="javascript:;" class="record" style="width:300px;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->shgName.'('.$row->uin.')</a></li>';
                        }
                    } else {
                        $output .='<li><a href="javascript:;" class="norecord" style="width:300px;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
                    }


                    $output .='</ul>';
                    echo $output;
                }
                if ($group == "FM") {
                    //prd($group);
                    $res =DB::table('family_profile as a')
                                ->join('family_mst as b', 'b.id', '=', 'a.family_sub_mst_id')
                                ->select('a.fp_member_name', 'b.uin')
                                ->where('a.fp_member_name', 'like', '%'.$query.'%')
                                ->where('b.is_deleted', '=', 0);
                    if ($country>0) {
                        $res->where('a.fp_country_id', '=', $country);
                    }
                    if ($state>0) {
                        $res->where('a.fp_state_id', '=', $state);
                    }
                    if ($district>0) {
                        $res->where('a.fp_district_id', '=', $district);
                    }
                    $data =$res->get()->toArray();
                    $output ='<ul class="dropdown-menu" style="display:block;">';
                    if (count($data) > 0) {
                        foreach ($data as $row) {
                            $output .='<li><a href="javascript:;" class="record" style="width:300px;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->fp_member_name.' ('.$row->uin.')</a></li>';
                        }
                    } else {
                        $output .='<li><a href="javascript:;" class="norecord" style="width:300px;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
                    }


                    $output .='</ul>';
                    echo $output;
                }
                if ($group == "AG") {
                    //prd($group);
                    $res =DB::table('agency')
                                    ->where('agency_name', 'like', '%'.$query.'%')
                                    ->where('is_deleted', '=', 0);
                    if ($country>0) {
                        $res->where('country', '=', $country);
                    }
                    if ($state>0) {
                        $res->where('state', '=', $state);
                    }

                    $data =$res->get()->toArray();
                    $output ='<ul class="dropdown-menu" style="display:block;">';
                    if (count($data) > 0) {
                        foreach ($data as $row) {
                            $output .='<li><a href="javascript:;" class="record" style="width:300px;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->agency_name.' ('.$row->agency_id.')</a></li>';
                        }
                    } else {
                        $output .='<li><a href="javascript:;" class="norecord" style="width:300px;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
                    }


                    $output .='</ul>';
                    echo $output;
                }
            }
        }
    }
}
