<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logindetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class logsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::User();
        $data = [];
        if (!empty($request->get('Search'))) {
            Session::put('logs_filter_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('logs_filter_session');
        }
        $session_data = Session::get('logs_filter_session');

        if ($request->ajax()) {

            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');
            $txt_search = $request->post('search')['value'];

            $query = "SELECT
                a.*,b.name,b.u_type,c.name as country , s.name as state , d.name as district
            FROM
                login_details AS a
            INNER JOIN users b ON
                a.user_id = b.id
            LEFT JOIN user_location_relation u ON
                b.id = u.user_id
            LEFT JOIN countries c ON
                u.country_id = c.id
            LEFT JOIN states s ON
                u.state_id = s.id
            LEFT JOIN district d ON
                u.district_id = d.id
            WHERE
                b.is_deleted = 0

            ";
             if (!empty($session_data['Search'])) {
                if (!empty($session_data['group'])) {

                    if ($session_data['group'] != '' && $session_data['group'] > 0) {
                        $query .= " AND a.u_type = '" . $session_data['group'] . "' ";
                    }

                 }
                 if (!empty($session_data['country'])) {
                    if ($session_data['country'] != '' && $session_data['country'] > 0) {
                        $query .= " AND u.country_id = '" . $session_data['country'] . "' ";
                    }
                }
                if (!empty($session_data['state'])) {
                    if ($session_data['state'] != '' && $session_data['state'] > 0) {
                        $query .= " AND u.state_id = '" . $session_data['state'] . "' ";
                    }
                }

                if (!empty($session_data['district'])) {
                    $district_id = $session_data['district'];
                    if ($session_data['district'] != '' && $session_data['district'] > 0) {
                        $query .= " AND u.district_id IN ($district_id)";
                    }
                }


            }

            // prd($query);
            $logs = DB::select($query);
            $total = count($logs);
            $query .= " ORDER BY
                    a.created_at
                 DESC
                LIMIT $limit OFFSET $start";
            // prd($query);
            $logs = DB::select($query);
            // prd($logs);
            foreach ($logs as $res) {
               $action ='';
                if($res->action==1)
                {
                    $action = 'Logged In';
                }
                else if($res->action==0)
                {
                    $action = 'Logged Out';
                }
                if($res->u_type == 'M')
                {
                    $u_type = 'District Manager';
                }
                else if($res->u_type == 'F')
                {
                    $u_type = 'Facilitator';
                }
                else if($res->u_type == 'QA')
                {
                    $u_type = 'Quality Manager';
                }
                else if($res->u_type == 'A')
                {
                    $u_type = 'Admin';
                }else if ($res->u_type == 'CEO')
                {
                    $u_type = 'CEO';
                }
                $row = [];
                $row[] = ++$start;
                $row[] = $res->name;
                $row[] = $u_type;
                $row[] = $res->user_ip;
                $row[] = $res->country;
                $row[] = $res->state;
                $row[] = $res->district;
                $row[] =change_date_month_name_char( $res->created_at);
                $row[] = date('h:i a ', strtotime($res->created_at));

                $row[] = $action;




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
        return view('logs.list')->with($data);
    }
}
