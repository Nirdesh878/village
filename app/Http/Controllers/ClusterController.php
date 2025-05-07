<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\ClusterProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\FcsnodeMst;
use App\Models\ClusterSubMst;
use App\Models\ClusterAnalysis;
use App\Models\ClusterChallenges;
use App\Models\ClusterCreditrecovery;
use App\Models\ClusterEfficiency;
use App\Models\ClusterGovernance;
use App\Models\ClusterInclusion;
use App\Models\ClusterSaving;
use App\Models\ClusterRating;
use App\Models\ClusterObservation;
use PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClusterExport;
use \stdClass;
use App\Rules\ClusterNRLMCode;
use Illuminate\Support\Facades\Session;
use App\Models\TaskQaAssignment;
use App\Models\TaskAssignment;



class ClusterController extends Controller
{
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
        if($user->u_type == 'QA' ){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
        $user_geo = DB::table('user_location_relation')
            ->where('user_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->orderBy('country_id')
            ->get()->toArray();
        if ($request->ajax()) {
            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');
            $txt_search = $request->post('search')['value'];

            $query = " SELECT
                b.*,
                d.agency_name,
                e.name AS country_name,
                f.name AS state_name,
                g.name AS district_name,
                a.uin,
                a.id AS ids,
                a.srlm_code,
                a.status,
                a.created_at as created,
                a.federation_uin,
                h.name_of_federation,
                s.status AS clust_status,
                s.analytics,
                s.dm_a,
                s.qa_a,
                s.dm_r,
                s.qa_r,
                s.updated_at,
                s.locked,
                s.flag,
                s.status_flag,
                s.recalled

            FROM
                cluster_mst AS a
            INNER JOIN cluster_sub_mst AS s
            ON
                s.cluster_mst_id = a.id
            INNER JOIN cluster_profile AS b
            ON
                b.cluster_sub_mst_id = s.id
            INNER JOIN federation_mst AS c
            ON
                a.federation_uin = c.uin
            INNER JOIN federation_sub_mst AS X
            ON
                X.federation_mst_id = c.id
            INNER JOIN federation_profile AS h
            ON
                h.federation_sub_mst_id = X.id
            INNER JOIN agency AS d
            ON
                a.agency_id = d.agency_id
            LEFT JOIN countries AS e
            ON
                b.name_of_country = e.id
            LEFT JOIN states AS f
            ON
                b.name_of_state = f.id
            LEFT JOIN district AS g
            ON
                b.name_of_district = g.id
            WHERE
                a.is_deleted = 0";
            if ($user->u_type == 'M') {
                // $query .= " AND a.created_by = $user->id ";
                if ($user_geo[0]->district_id == '') {
                    $district_list = 0;
                } else {

                    $district_list = $user_geo[0]->district_id;
                }


                $state_id = $user_geo[0]->state_id;

                $query .= " AND (CASE WHEN a.created_by > 1 THEN 1 ELSE 0 END = 1 AND a.created_by = $user->id and a.is_deleted = 0";
                if ($txt_search != '') {
                    $query .= " AND (b.name_of_cluster like '%$txt_search%' ";
                    $query .= " or h.name_of_federation like '%$txt_search%' ";
                    $query .= " or SUBSTRING(a.uin, LENGTH(a.uin) - 3) LIKE '%$txt_search%' )";
                }

                $query .= " )
                OR
                (CASE WHEN a.created_by < 2 THEN 1 ELSE 0 END = 1 AND (b.district_id IN($district_list) or b.state_id = $state_id ) and a.is_deleted = 0";
                if ($txt_search != '') {
                    $query .= " AND (b.name_of_cluster like '%$txt_search%' ";
                    $query .= " or h.name_of_federation like '%$txt_search%' ";
                    $query .= " or SUBSTRING(a.uin, LENGTH(a.uin) - 3) LIKE '%$txt_search%' )";
                }

                $query .= " )";
            }
            if ($user->u_type != 'M') {
                if ($txt_search != '') {
                    $query .= " AND (b.name_of_cluster like '%$txt_search%' ";
                    $query .= " or h.name_of_federation like '%$txt_search%' ";
                    $query .= " or SUBSTRING(a.uin, LENGTH(a.uin) - 3) LIKE '%$txt_search%' )";
                }
            }
            $clusters = DB::select($query);
            $total = count($clusters);
            $query .= " ORDER BY
                    s.updated_at
                DESC,a.id DESC
                LIMIT $limit OFFSET $start";
            $clusters = DB::select($query);

            foreach ($clusters as $cluster) {
                $visit = 'Created';
                if ($cluster->dm_a == 'V' && $cluster->qa_a == 'V' && $cluster->locked == 1) {
                    $visit = 'Locked';
                } elseif ($cluster->dm_a == 'V' && $cluster->qa_a == 'V') {
                    $visit = 'Initial Rating';
                } elseif ($cluster->dm_a == 'V' && $cluster->qa_a == 'P') {
                    $visit = 'Analytics Complete';
                } elseif ($cluster->dm_a == 'P') {
                    $visit = 'Visit Complete';
                } elseif ($cluster->dm_a == 'N' && $cluster->flag == 0) {
                    $visit = 'Visit Pending';
                } elseif ($cluster->dm_a == 'R' && $cluster->flag == 1) {
                    $visit = 'Visit Reassigned';
                }
                elseif ($cluster->recalled == 1 ) {
                    $visit = 'Recalled';
                }

                $row = [];
                $row[] = ++$start;
                $row[] = $cluster->uin;
                $row[] = $cluster->name_of_cluster;
                $row[] = $cluster->name_of_federation;
                $row[] = $visit;
                $row[] = change_date_month_name_char($cluster->created);
                $row[] = change_date_month_name_char($cluster->updated_at);
                $row[] = $cluster->locked == 1 ? 'Yes' : 'No';
                $row[] = $cluster->status == 'A' ? '<span class="status-active">Active</span>' : '<span class="status-inactive">InActive</span>';
                $btns = '';

                if($user->u_type !='M'){
                    $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('cluster.edit', $cluster->ids) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                    $btns .= '<a class="btn btn-success btn-link btn-sm" rel="tooltip" title="View" data-original-title="View" href="' . route('cluster.show', $cluster->ids) . '" style="padding:0px;margin-left:5px"><i class="c-white-500 ti-eye"></i></a>';
                    $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $cluster->ids . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';
                }
                elseif($user->u_type =='M'){
                     if($cluster->status_flag == 1){
                        $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit"  " style="padding:0px;margin:0pxopacity: 0.3;"><i class="c-white-500 ti-pencil"></i></a>';
                        $btns .= '<a class="btn btn-success btn-link btn-sm" rel="tooltip" title="View" data-original-title="View"  style="padding:0px;margin-left:5px;opacity: 0.3;"><i class="c-white-500 ti-eye"></i></a>';
                        if($user->delete_inex != 'D'){
                        $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove"  title="Delete User"  style="padding:0px;margin:0pxopacity: 0.3;"><i class="c-white-500 ti-trash"></i></a>';
                        }
                     }
                     else{
                        $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('cluster.edit', $cluster->ids) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                    $btns .= '<a class="btn btn-success btn-link btn-sm" rel="tooltip" title="View" data-original-title="View" href="' . route('cluster.show', $cluster->ids) . '" style="padding:0px;margin-left:5px"><i class="c-white-500 ti-eye"></i></a>';
                    if($user->delete_inex != 'D'){
                    $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $cluster->ids . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';
                    }
                     }
                }
                $row[] = $btns;
                $data[] = $row;
            }

            $output = array(
                "draw" => $request->post('draw'),
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $data,
            );
            echo json_encode($output);
            exit;
        }
        return view('cluster.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];

        $user = Auth::User();
        $user_geo = DB::table('user_location_relation')
            ->select(DB::raw('GROUP_CONCAT(state_id) as state_ids'))
            ->where('user_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->orderBy('country_id')
            ->get()->toArray();
        $states_id = $user_geo[0]->state_ids;
        $query = "SELECT * from agency WHERE is_deleted = 0";
        if ($user->u_type == 'M') {

            // $query .= " AND state in ($states_id)";
            $query .= " AND agency_id in ($user->agency_id)";

        }
        $data['agency'] = DB::select($query);
        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        return view('cluster.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
    {

        /* Check post either add or update */
        if ($request->isMethod('post')) {

            try {
                $validation_arr = [
                    'agency_id' => ['required'],
                    'federation_id' => ['required'],
                    'name_of_cluster' => ['required'],
                    'cluster_formed' => ['required'],
                    'country' => ['required'],
                    'state' => ['required'],
                    'nrlm_code' => ['required', new ClusterNRLMCode],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request) {
                    $temp_rand = '';

                    $user = Auth::User();

                    $cluster_name = $request->post('name_of_cluster');
                    $cluster_formed = $request->post('cluster_formed');
                    $contact_name = $request->post('contact_name');
                    $web_email = $request->post('web_email');
                    $web_mobile = $request->post('web_mobile');
                    $nrlm = $request->post('nrlm_code');

                    if (count($cluster_name) > 0) {
                        foreach ($cluster_name as $key => $value) {
                            $cluster_mst = new Cluster();

                            //uin
                            $country_code = getCountryCodeByID($request->post('country'));
                            $state_code = strtoupper(getStateCodeByID($request->post('state')));
                            $district_code = strtoupper(substr(getName('district', 'name', $request->post('district')), 0, 2));
                            $uin = checkAndGenerateUIN($country_code, $state_code, $district_code, 'cluster_mst', 'CL');
                            //prd($uin);
                            $cluster_mst->uin = $uin;

                            $temp_rand = $request->post('agency_id');
                            $cluster_mst->agency_id = $temp_rand;
                            $cluster_mst->status = 'A';
                            $cluster_mst->federation_uin = $request->post('federation_id');
                            $cluster_mst->tkn = substr(md5(mt_rand()), 0, 16);
                            $cluster_mst->created_by = $user->id;
                            $qry = "SELECT * FROM fcsnode_mst WHERE tkn='" . $request->post("federation_id") . "'";
                            $data = DB::select($qry);
                            $pid = !empty($data[0]->id) > 0 ? $data[0]->id : 0;
                            $result = $cluster_mst->save();

                            $ClusterProfile = array(
                                'cluster_sub_mst_id' => $cluster_mst->id,
                                'name_of_cluster' => $value,
                                'country_id' => $request->post('country'),
                                'state_id' => $request->post('state'),
                                'district_id' => $request->post('district'),
                                'name_of_country' => getName('countries', 'name', $request->post('country')),
                                'name_of_state' => getName('states', 'name', $request->post('state')),
                                'name_of_district' => getName('district', 'name', $request->post('district')),
                                'no_of_of_cluster_in_cluster' => '',
                                'web_mobile' => $web_mobile[$key],
                                'web_email' => $web_email[$key],
                                'contact_name' => $contact_name[$key],
                                'block' => $request->post('block'),
                                'cluster_formed' => $cluster_formed[$key],
                                'vo_code' => $nrlm[$key],
                                'created_by' => $user->id,
                            );

                            $result = $this->Submaster($cluster_mst->id, $pid, $uin, $temp_rand, $ClusterProfile);
                        }
                        if ($result) {
                            return true;
                        }
                    }
                });
                if ($result) {
                    return redirect('cluster')->with(['message' => 'Cluster saved successfully.']);
                }
            } catch (\Exception $e) {
                prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }
        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        return view('cluster.list')->with($data);
    }
    public function cluster_table(Request $request)
    {
        $data = [];
        $user = Auth::User();
        $user_geo = DB::table('user_location_relation')
            ->where('user_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->orderBy('country_id')
            ->get()->toArray();

        $data = [];
        if ($request->ajax()) {
            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');
            $query = " SELECT
            z.name_of_cluster,
            X.id,
            z.created_at,
            Y.uin
                FROM
                    cluster_mst AS Y
                INNER JOIN cluster_sub_mst AS X
                ON
                    Y.id = X.cluster_mst_id
                INNER JOIN cluster_profile AS z
                ON
                    X.id = z.cluster_sub_mst_id

                WHERE
                    Y.is_deleted = 0 ";
            if ($user->u_type == 'M') {
                $query .= " AND Y.created_by = $user->id";
            }

            $clusters = DB::select($query);
            $total = count($clusters);
            $query .= " ORDER BY
                    z.created_at
                DESC
                LIMIT $limit OFFSET $start";
            $clusters = DB::select($query);
            foreach ($clusters as $cluster) {
                $row = [];
                $row[] = ++$start;
                $row[] = $cluster->name_of_cluster;
                $row[] = $cluster->uin;
                $data[] = $row;
            }

            $output = array(
                "draw" => $request->post('draw'),
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $data,
            );
            echo json_encode($output);
            exit;
        }
        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        return view('cluster.add')->with($data);
    }
    public function cluster_table_second(Request $request)
    {
        $data = [];
        $user = Auth::User();

        $user_geo = DB::table('user_location_relation')
            ->where('user_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->orderBy('country_id')
            ->get()->toArray();
        $data = [];
        if ($request->ajax()) {
            $country = $request->post('country');
            $state = $request->post('state');
            $district = $request->post('district');
            $agency = $request->post('agency_id');
            $federation_id = $request->post('federation_id');
            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');
            $query = " SELECT
            z.name_of_cluster,
            X.id,
            Y.uin
                FROM
                    cluster_mst AS Y
                INNER JOIN cluster_sub_mst AS X
                ON
                    Y.id = X.cluster_mst_id
                INNER JOIN cluster_profile AS z
                ON
                    X.id = z.cluster_sub_mst_id

                WHERE
                    Y.is_deleted = 0 ";
            if ($user->u_type == 'M') {
                $query .= " AND Y.created_by = $user->id";
            }
            if (!empty($agency)) {
                if (!empty($agency)) {
                    $query .= " AND Y.agency_id = '" . $agency . "' ";
                }

                if (!empty($country)) {
                    $query .= " AND z.country_id = '" . $country . "' ";
                }
                if (!empty($state)) {
                    $query .= " AND z.state_id = '" . $state . "' ";
                }
                if (!empty($district)) {
                    $query .= " AND z.district_id = '" . $district . "' ";
                }
                if (!empty($federation_id)) {
                    $query .= " AND Y.federation_uin = '" . $federation_id . "' ";
                }
            }
            // prd($query);
            $clusters = DB::select($query);
            $total = count($clusters);

            foreach ($clusters as $cluster) {
                $row = [];
                $row['sn'] = ++$start;
                $row['cluster_name'] = $cluster->name_of_cluster;
                $row['uin'] = $cluster->uin;
                $data[] = $row;
            }
            $output = array(
                "draw" => $request->post('draw'),
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $data,
            );
            echo json_encode($data);
            exit;
        }

        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        return view('cluster.add')->with($data);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cluster  $cluster
     * @return \Illuminate\Http\Response
     */
    public function show(Cluster $cluster, Request $request)
    {
        //die($cluster);
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        //prd($user);
        $data['u_type'] = $user->u_type;
        $data['cluster_ids'] = $cluster->id;
        $data['dm_id'] = $user->id;
        $data['agency_id'] = $cluster->agency_id;
        $data['quality_check'] = ($request->get('task_id') == null) ? 0 : 1;
        //prd($data['quality_check']);
        $t_q_a = DB::table('task_qa_assignment as y')
            ->select('y.*')
            ->where('y.assignment_id', '=', $cluster->id)
            ->where('y.assignment_type', '=', 'CL')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()->toArray();
        //prd($t_q_a);
        $data['task_id'] = $request->get('task_id') ?? ($t_q_a[0]->id) ?? null;
        $data['user_id'] = $request->get('user_id') ?? ($t_q_a[0]->user_id) ?? null;
        $data['qa_status'] = $t_q_a[0]->qa_status ?? null;
        $data['qa_remark'] = $t_q_a[0]->remark ?? null;
        $data['qa_readonly'] = ($data['qa_status'] == 'R' || $data['qa_status'] == 'V') ? 'readonly' : '';
        $data['quality_status'] = $t_q_a[0]->quality_status ?? null;
        $data['quality_remark'] = $t_q_a[0]->quality_remark ?? null;
        $data['manager_date'] = $t_q_a[0]->manger_date ?? null;
        $data['quality_date'] = $t_q_a[0]->quality_date ?? null;
        $data['qa_readonly1'] = ($data['quality_status'] == 'R' || $data['quality_status'] == 'V') ? 'readonly' : '';
        $data['agency'] = DB::table('agency as a')
            ->select('a.agency_name')
            ->where('is_deleted', '=', 0)
            ->where('a.agency_id', '=', $cluster->agency_id)
            ->get()->toArray();
        $query = "Select id,qa_status from cluster_sub_mst where cluster_mst_id=$cluster->id";
        $result = DB::select($query);
        $data['manager_status']=$result[0]->qa_status;
        $query_2 = "Select b.name_of_federation from federation_mst a inner join federation_sub_mst c on a.id=c.federation_mst_id inner join federation_profile b on c.id=b.federation_sub_mst_id where a.is_deleted=0 and a.uin='$cluster->federation_uin' ";
        $data['fed_profile'] = DB::select($query_2);
        //prd($data['fed_profile']);
        $data['profile'] = DB::table('cluster_profile as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        //$data['profile_bank'] = json_decode($data['profile'][0]->Federation_Bank_ac);
        $data['photos'] = DB::table('cluster_upload_photos_videos as a')
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['governance'] = DB::table('cluster_governance as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $temp = (stripslashes($data['governance'][0]->Cluster_Subcommittee_object));
        $data['governance_service'] = json_decode($temp);
        //prd($data['governance_service']);
        $data['inclusion'] = DB::table('cluster_inclusion as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['efficiency'] = DB::table('cluster_efficiency as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $temp = (stripslashes($data['efficiency'][0]->Cluster_Commit_Efficiency_Training_object));
        $data['efficiency_1'] = json_decode($temp);
        $temp = '';
        $temp = (stripslashes($data['efficiency'][0]->Cluster_SAC_Efficiency_Training_object));
        $data['efficiency_2'] = json_decode($temp);
        // $temp = '';
        // $temp = (stripslashes($data['efficiency'][0]->who_received_other));
        // $data['efficiency_3'] = json_decode($temp);
        //prd($data['efficiency_1']);
        $data['creditrecovery'] = DB::table('cluster_creditrecovery as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();


        $data['saving'] = DB::table('cluster_saving as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $data['analysis'] = DB::table('cluster_analysis as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $challenge_type = array(
            'Describe Action to address the challenge',
            'Who would be responsible for action. Specify name',
            'When would action be completed (date)',
            'Is there any support from project office needed to complete action',
            'What kind of support is needed',
            'Was action completed by expected date (Y/N/NA)',
            'Has action been changed/revised during last visit (Y/N)',
            'Facilitator to fill which is the revised/changed action'
        );
        $data['challenges'] = DB::table('cluster_challenges as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
            // prd($data['challenges']);
        foreach ($challenge_type as $key1 => $val) {
            $data['challenges_action'][$key1]['name'] = $val;
            foreach ($data['challenges'] as $key => $val1) {
                $temp = json_decode($val1->action);
                //pr($temp);
                if (!empty($temp)) {
                    if ($key1 == 0 ) {
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_describe_action;
                        continue;
                    }
                    if ($key1 == 1) {
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_responsible;
                        continue;
                    }
                    if ($key1 == 2) {
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_action_completed;
                        continue;
                    }
                    if ($key1 == 3) {
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_SHG_Cluster_complete;
                        continue;
                    }
                    if ($key1 == 4) {
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_support_needed;
                        continue;
                    }
                    if ($key1 == 5) {
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_expected_date;

                        continue;
                    }
                    if ($key1 == 6) {
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_changed_rating;
                        continue;
                    }
                    if ($key1 == 7) {
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_facilitator;
                        continue;
                    }
                }
                else {
                    if ($key1 == 0 ) {
                        $data['challenges_action'][$key1]['action'][$key] = 'N/A';
                        continue;
                    }
                    if ($key1 == 1) {
                        $data['challenges_action'][$key1]['action'][$key] = 'N/A';
                        continue;
                    }
                    if ($key1 == 2) {
                        $data['challenges_action'][$key1]['action'][$key] = 'N/A';
                        continue;
                    }
                    if ($key1 == 3) {
                        $data['challenges_action'][$key1]['action'][$key] = 'N/A';
                        continue;
                    }
                    if ($key1 == 4) {
                        $data['challenges_action'][$key1]['action'][$key] = 'N/A';
                        continue;
                    }
                    if ($key1 == 5) {
                        $data['challenges_action'][$key1]['action'][$key] = 'N/A';

                        continue;
                    }
                    if ($key1 == 6) {
                        $data['challenges_action'][$key1]['action'][$key] = 'N/A';
                        continue;
                    }
                    if ($key1 == 7) {
                        $data['challenges_action'][$key1]['action'][$key] = 'N/A';
                        continue;
                    }
                }
            }

        }
        // prd($data['challenges_action']);
        $data['observation'] = DB::table('cluster_observation as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $ID =  $result[0]->id;

        $query = "SELECT
        a.*,
        b.name ,
        c.name_of_cluster
        FROM
            `cluster_remarks` AS a
        LEFT JOIN users AS b
        ON
            a.user_id = b.id
        LEFT JOIN cluster_profile AS c
        ON
            a.cluster_id = c.cluster_sub_mst_id
        WHERE
            a.cluster_id = $ID
            ORDER BY a.updated_at DESC
            ";
       $data['remarks'] = DB::select($query);

        $analysis = cluster_analysis($ID);
        $xfinal = $analysis['grand_total'];


        $query = "UPDATE cluster_profile set analysis_rating= '$xfinal' WHERE cluster_sub_mst_id=$ID";
        $result = DB::update($query);
        return view('cluster.view', compact('cluster'))->with($data)->with($analysis);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cluster  $cluster
     * @return \Illuminate\Http\Response
     */
    public function edit(Cluster $cluster)
    {
        $data['cluster_profile'] = DB::table('cluster_profile as p')
            ->select('p.*', 's.id', 'f.id', 'p.id as profile_id')
            ->where('f.is_deleted', '=', 0)
            ->join('cluster_sub_mst as s', 'p.cluster_sub_mst_id', '=', 's.id')
            ->join('cluster_mst as f', 's.cluster_mst_id', '=', 'f.id')
            ->where('s.cluster_mst_id', '=', $cluster->id)
            ->get()->toArray();
        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        $data['edit'] = 1;
        //prd($data);
        return view('cluster.edit', compact('cluster'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cluster  $cluster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cluster $cluster)
    {
        $view = 'cluster.edit';

        /* Check post either add or update */
        if ($request->isMethod('PATCH')) { //prd($request->all());
            try {
                $validation_arr = [
                    'agency_id' => ['required'],
                    'federation_id' => ['required'],
                    'name_of_cluster' => ['required'],
                    'cluster_formed'=>['required'],
                    // 'srlm_code' => ['required'],
                    'country' => ['required'],
                    'state' => ['required'],
                    // 'district' => ['required'],
                    'status' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $result = DB::transaction(function () use ($request, $cluster) {
                    $user = Auth::User();
                    //prd($user);
                    if ($request->post('id') > 0) {
                        $cluster_mst = Cluster::find($request->post('id'));
                        $cluster_mst->status = $request->post('status');
                        $cluster_mst->updated_by = $user->id;
                    } else {
                        return redirect('cluster')->with(['message' => 'Cluster id does not exist.']);
                        exit();
                    }
                    //$temp_rand = $request->post('agency_id');
                    //$cluster_mst->agency_id = $temp_rand;
                    //$cluster_mst->status = $request->post('status');
                    $cluster_mst->federation_uin = $request->post('federation_id');
                    $cluster_mst->srlm_code = $request->post('srlm_code');
                    //prd($request->post('federation_id'));
                    //$cluster_mst->tkn = substr(md5(mt_rand()), 0, 16);
                    //$uin = 'A'.substr($temp_rand, -3).'CLTVI'.rand(1000000, 9999999);
                    //$cluster_mst->uin = $uin;
                    //prd( $cluster_mst);
                    $result = $cluster_mst->save();

                    if ($cluster_mst->id > 0) {
                        $qry = "SELECT * FROM fcsnode_mst WHERE uin='" . $request->post("federation_id") . "'";
                        $data = DB::select($qry);
                        //prd($data);
                        $pid = !empty($data[0]->id) > 0 ? $data[0]->id : 0;
                        //prd($pid);
                        /*$fcsnode_mst = "UPDATE fcsnode_mst set pid= $pid WHERE uin='$nuincd'";
        Yii::app()->db->createCommand($fcsnode_mst)->execute();*/
                        FcsnodeMst::where([['uin', '=', $cluster_mst->uin]])->update(['pid' => $pid]);
                        $profile_id = $request->post('profile_id');
                        //prd($profile_id);
                        $user_details = ClusterProfile::find($profile_id);
                        //prd($user_details);
                        $user_details->name_of_cluster = $request->post('name_of_cluster');
                        $user_details->country_id = $request->post('country');
                        $user_details->state_id = $request->post('state');
                        $user_details->district_id = $request->post('district');
                        $user_details->name_of_country = getName('countries', 'name', $request->post('country'));
                        $user_details->name_of_state = getName('states', 'name', $request->post('state'));
                        $user_details->name_of_district = getName('district', 'name', $request->post('district'));
                        $user_details->web_email = ($request->post('email'));
                        $user_details->web_mobile = ($request->post('mobile'));
                        $user_details->contact_name = ($request->post('contact_name'));
                        $user_details->block = ($request->post('block'));
                        $user_details->no_of_of_shg_in_cluster = $request->post('no_of_of_shg_in_cluster');
                        //$user_details->cluster_formed = change_date_format($request->post('cluster_formed'));
                        $user_details->cluster_formed = change_date_monthName($request->post('cluster_formed'));
                        $user_details->office_location = $request->post('office_location');
                        $user_details->shg_at_time_creation = $request->post('shg_at_time_creation');
                        $user_details->cluster_members_at_time_creation = $request->post('cluster_members_at_time_creation');
                        $user_details->total_SHGs = $request->post('total_SHGs');
                        $user_details->total_members = $request->post('total_members');
                        $user_details->president = $request->post('president');
                        $user_details->secretary = $request->post('secretary');
                        $user_details->treasure = $request->post('Treasurer');
                        $user_details->book_keeper_name = $request->post('book_keeper_name');
                        $user_details->contact_number = $request->post('contact_number');

                        $user_details->updated_by = $user->id;
                        $user_details->updated_at = date('Y-m-d H:i:s');
                        //prd($user_details);
                        $result = $user_details->save();
                    }

                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('cluster')->with(['message' => 'Cluster updated successfully.']);
                }
            } catch (\Exception $e) {
                prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        return view($view);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cluster  $cluster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cluster $cluster)
    {
        $query="SELECT count(*) as count FROM shg_mst WHERE cluster_uin = '$cluster->uin' AND is_deleted = 0";
        $shg_count = DB::select($query)[0]->count;
        try {
            if($shg_count == 0)
            {
                if ($cluster->id != '') {
                    $user_details = Cluster::find($cluster->id);
                    $user_details->is_deleted = 1;
                    $user_details->save();

                    TaskQaAssignment::where('assignment_id', $cluster->id)->where('assignment_type', 'CL')->update(['is_deleted' => 1]);
                    TaskAssignment::where('assignment_id', $cluster->id)->where('assignment_type', 'CL')->update(['is_deleted' => 1]);

                    $data['message'] = 'Cluster Deleted Successfully';
                    echo json_encode($data);
                } else {
                    $data['message'] = 'Invalid Request';
                    echo json_encode($data);
                }
            }
            else
        {
            $data['message'] = "Total number of SHG created under this Cluster are $shg_count . Please delete SHG first";
            echo json_encode($data);
        }

        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }
    public function submaster($cluster_mst_id, $pid, $nuincd, $agency_id, $ClusterProfile)
    {

        //Manage relation of eaech
        $modelnw = new FcsnodeMst();
        $modelnw->pid = $pid;
        $modelnw->uin = $nuincd;
        $modelnw->type = 'C';
        $modelnw->agency_id = $agency_id;
        $modelnw->tkn = substr(md5(mt_rand()), 0, 16);
        $modelnw->created_at = date('Y-m-d H:i:s');
        $modelnw->save();

        $modeln = new ClusterSubMst();
        $modeln->cluster_mst_id = $cluster_mst_id;
        $modeln->created_at = date('Y-m-d H:i:s');
        $modeln->save();
        $cluster_sub_mst_id =  $modeln->id;

        $model_profile = new ClusterProfile();
        $model_profile->cluster_sub_mst_id = $cluster_sub_mst_id;
        $model_profile->name_of_cluster = (trim($ClusterProfile['name_of_cluster']));
        $model_profile->name_of_district = (trim($ClusterProfile['name_of_district']));
        $model_profile->name_of_state = (trim($ClusterProfile['name_of_state']));
        $model_profile->name_of_country = (trim($ClusterProfile['name_of_country']));
        $model_profile->web_email = trim($ClusterProfile['web_email']);
        $model_profile->web_mobile = trim($ClusterProfile['web_mobile']);
        $model_profile->block = trim($ClusterProfile['block']);
        $model_profile->contact_name = trim($ClusterProfile['contact_name']);
        $model_profile->district_id = (trim($ClusterProfile['district_id']));
        $model_profile->state_id = (trim($ClusterProfile['state_id']));
        $model_profile->country_id = (trim($ClusterProfile['country_id']));
        //$model_profile->no_of_of_shg_in_cluster = (int) (trim($ClusterProfile['no_of_of_shg_in_cluster']));
        $model_profile->cluster_formed = change_date_monthName(trim($ClusterProfile['cluster_formed'])) ?? null;
        //$model_profile->office_location = (trim($ClusterProfile['office_location']));
        //$model_profile->shg_at_time_creation = (int) (trim($ClusterProfile['shg_at_time_creation']));
        //$model_profile->cluster_members_at_time_creation = (int) (trim($ClusterProfile['cluster_members_at_time_creation']));
        //$model_profile->total_SHGs = (int) (trim($ClusterProfile['total_SHGs']));
        //$model_profile->total_members = (int) (trim($ClusterProfile['total_members']));
        //$model_profile->president = (trim($ClusterProfile['president']));
        //$model_profile->secretary = (trim($ClusterProfile['secretary']));
        //$model_profile->treasure = (trim($ClusterProfile['treasure']));
        //$model_profile->book_keeper_name = (trim($ClusterProfile['book_keeper_name']));
        //$model_profile->contact_number = (trim($ClusterProfile['contact_number']));
        $model_profile->created_by = (trim($ClusterProfile['created_by']));
        $model_profile->vo_code = (trim($ClusterProfile['vo_code']));
        $model_profile->created_at = date('Y-m-d H:i:s');
        $model_profile->save();

        $model_analysis = new ClusterAnalysis();
        $model_analysis->cluster_sub_mst_id = $cluster_sub_mst_id;
        $model_analysis->created_at = date('Y-m-d H:i:s');
        $model_analysis->save();

        $model_challenges = new ClusterChallenges();
        $model_challenges->cluster_sub_mst_id = $cluster_sub_mst_id;
        $model_challenges->created_at = date('Y-m-d H:i:s');
        $model_challenges->save();

        $model_creditrecovery = new ClusterCreditrecovery();
        $model_creditrecovery->cluster_sub_mst_id = $cluster_sub_mst_id;
        $model_creditrecovery->created_at = date('Y-m-d H:i:s');
        $model_creditrecovery->save();

        $model_efficiency = new ClusterEfficiency();
        $model_efficiency->cluster_sub_mst_id = $cluster_sub_mst_id;
        $model_efficiency->created_at = date('Y-m-d H:i:s');
        $model_efficiency->save();

        $model_governance = new ClusterGovernance();
        $model_governance->cluster_sub_mst_id = $cluster_sub_mst_id;
        $model_governance->created_at = date('Y-m-d H:i:s');
        $model_governance->save();

        $model_inclusion = new ClusterInclusion();
        $model_inclusion->cluster_sub_mst_id = $cluster_sub_mst_id;
        $model_inclusion->created_at = date('Y-m-d H:i:s');
        $model_inclusion->save();

        $model_saving = new ClusterSaving();
        $model_saving->cluster_sub_mst_id = $cluster_sub_mst_id;
        $model_saving->created_at = date('Y-m-d H:i:s');
        $model_saving->save();

        $model_rating = new ClusterRating();
        $model_rating->cluster_sub_mst_id = $cluster_sub_mst_id;
        $model_rating->rating = json_encode(array());
        $model_rating->created_at = date('Y-m-d H:i:s');
        $model_rating->save();

        $model_observation = new ClusterObservation();
        $model_observation->cluster_sub_mst_id = $cluster_sub_mst_id;
        $model_observation->created_at = date('Y-m-d H:i:s');
        $model_observation->save();


        return true;
    }
    public function export_clusterCardPDF($cluster_id)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data['u_type'] = $user->u_type;

        $data = $this->mainPDF($cluster_id);
        $analysis = cluster_analysis($cluster_id);
        $viewData = array_merge($data, $analysis);
        view()->share('data', $viewData);
        $pdf_doc = PDF::loadView('pdf.clustercardPdf', $viewData)->setPaper('a4', 'landscape');
        //prd($result);
        return $pdf_doc->stream('Cluster_Rating_Card_'.$data['uin'] .'_'.pdf_date().'.pdf');
    }
    public function export(Request $request)
    {
        return Excel::stream(new ClusterExport(), 'ClusterExport_'.pdf_date().'.xlsx');
    }

    public function clusterPDF(Request $request)
    {
        $user = Auth::User();
        $user_geo = DB::table('user_location_relation')
            ->where('user_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->orderBy('country_id')
            ->get()->toArray();

        $query = " SELECT
            *
        FROM
            (
            SELECT
                b.*,
                d.agency_name,
                e.name AS country_name,
                f.name AS state_name,
                g.name AS district_name,
                a.uin,
                a.id AS ids,
                a.srlm_code,
                a.status,
                a.federation_uin,
                h.name_of_federation,
                s.status AS clust_status,
                s.analytics,
                s.dm_a,
                s.qa_a,
                s.dm_r,
                s.qa_r,
                s.flag,
                s.updated_at as updated,
                s.locked
            FROM
                cluster_mst AS a
            INNER JOIN cluster_sub_mst AS s
            ON
                s.cluster_mst_id = a.id
            INNER JOIN cluster_profile AS b
            ON
                b.cluster_sub_mst_id = s.id
            INNER JOIN federation_mst AS c
            ON
                a.federation_uin = c.uin
            INNER JOIN federation_sub_mst AS X
            ON
                X.federation_mst_id = c.id
            INNER JOIN federation_profile AS h
            ON
                h.federation_sub_mst_id = X.id
            INNER JOIN agency AS d
            ON
                a.agency_id = d.agency_id
            LEFT JOIN countries AS e
            ON
                b.country_id = e.id
            LEFT JOIN states AS f
            ON
                b.state_id = f.id
            LEFT JOIN district AS g
            ON
                b.district_id = g.id
            WHERE
                a.is_deleted = 0";
                  if ($user->u_type == 'M') {
                    // $query .= " AND (Y.created_by = $user->id OR z.fp_district IN($district_list)) ";
                    if($user_geo[0]->district_id == ''){
                        $district_list = 0;
                    } else{

                        $district_list = $user_geo[0]->district_id;
                    }

                    $state_id = $user_geo[0]->state_id;

                    $query .= " AND (CASE WHEN a.created_by > 1 THEN 1 ELSE 0 END = 1 AND a.created_by = $user->id AND  a.is_deleted = 0 )
                       OR
                    (CASE WHEN a.created_by < 2 THEN 1 ELSE 0 END = 1 AND (b.district_id IN ($district_list) OR b.state_id = $state_id ) AND  a.is_deleted = 0)" ;
                }

        $query .= ") a
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
                    assignment_type = 'CL'
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

        $data = DB::select($query);
        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.clusterPdf', $data)->setPaper('a3', 'landscape');
        return $pdf_doc->stream('Cluster_PDF_' . pdf_date() . '.pdf');
    }
    public function mainPDF($cluster_id)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data['u_type'] = $user->u_type;

        $cluster = Cluster::find($cluster_id);
        $data['uin'] = $cluster->uin;

        $data['cluster'] = $cluster;
        $data['cluster_ids'] = $cluster->id;

        $data['agency_id'] = $cluster->agency_id;
        $data['quality_check'] = 1;
        $t_q_a = DB::table('task_qa_assignment as y')
            ->select('y.*')
            ->where('y.assignment_id', '=', $cluster->id)
            ->where('y.assignment_type', '=', 'CL')
            ->get()->toArray();
        $data['task_id'] = 1;
        $data['user_id'] = null;
        $data['qa_status'] = $t_q_a[0]->qa_status ?? null;
        $data['qa_remark'] = $t_q_a[0]->remark ?? null;
        $data['qa_readonly'] = ($data['qa_status'] == 'R' || $data['qa_status'] == 'V') ? 'readonly' : '';
        $data['agency'] = DB::table('agency as a')
            ->select('a.agency_name')
            ->where('is_deleted', '=', 0)
            ->where('a.agency_id', '=', $cluster->agency_id)
            ->get()->toArray();
        $query = "Select id from cluster_sub_mst where cluster_mst_id=$cluster->id";
        $result = DB::select($query);
        $query_2 = "Select b.name_of_federation from federation_mst a inner join federation_sub_mst c on a.id=c.federation_mst_id inner join federation_profile b on c.id=b.federation_sub_mst_id where a.is_deleted=0 and a.uin='$cluster->federation_uin' ";
        $data['fed_profile'] = DB::select($query_2);

        $data['profile'] = DB::table('cluster_profile as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['governance'] = DB::table('cluster_governance as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $temp = (stripslashes($data['governance'][0]->Cluster_Subcommittee_object));
        $data['governance_service'] = json_decode($temp);
        $data['inclusion'] = DB::table('cluster_inclusion as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['efficiency'] = DB::table('cluster_efficiency as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $temp = (stripslashes($data['efficiency'][0]->Cluster_Commit_Efficiency_Training_object));
        $data['efficiency_1'] = json_decode($temp);
        $temp = '';
        $temp = (stripslashes($data['efficiency'][0]->Cluster_SAC_Efficiency_Training_object));
        $data['efficiency_2'] = json_decode($temp);
        $temp = '';

        $data['creditrecovery'] = DB::table('cluster_creditrecovery as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['saving'] = DB::table('cluster_saving as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $data['analysis'] = DB::table('cluster_analysis as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $challenge_type = array(
            // 'Describe Action to address the challenge',
            // 'Who would be responsible for action. Specify name',
            'When would action be completed (date)',
            // 'Is there any support from project office needed to complete action',
            // 'What kind of support is needed',
            // 'Was action completed by expected date (Y/N/NA)',
            // 'Has action been changed/revised during last visit (Y/N)',
            // 'Facilitator to fill which is the revised/changed action',
        );
        $data['challenges'] = DB::table('cluster_challenges as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        foreach ($challenge_type as $key1 => $val) {
            $data['challenges_action'][$key1]['name'] = $val;
            foreach ($data['challenges'] as $key => $val1) {
                $temp = json_decode($val1->action);
                if (!empty($temp)) {
                    if ($key1 == 0) {
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_describe_action;
                        $data['challenges_action'][$key1]['ch_actions'][$key] = change_date_month_name_char(str_replace('/', '-', $temp[0]->sa_action_completed));
                        continue;
                    }
                    // if ($key1 == 1) {
                    //     $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_responsible;
                    //     continue;
                    // }
                    // if ($key1 == 2) {
                    //     $data['challenges_action'][$key1]['action'][$key] = change_date_month_name_char(str_replace('/', '-', $temp[0]->sa_action_completed));
                    //     continue;
                    // }
                    // if ($key1 == 3) {
                    //     $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_SHG_Cluster_complete;
                    //     continue;
                    // }
                    // if ($key1 == 4) {
                    //     $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_support_needed;
                    //     continue;
                    // }
                    // if ($key1 == 5) {
                    //     $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_expected_date;

                    //     continue;
                    // }
                    // if ($key1 == 6) {
                    //     $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_changed_rating;
                    //     continue;
                    // }
                    // if ($key1 == 7) {
                    //     $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_facilitator;
                    //     continue;
                    // }
                }
            }
        }
        $actionArray =[];
        $dateArray   =[];
        // prd($data['challenges_action'][0]['ch_actions']);
        if(!empty($data['challenges_action'][0]['action'])){
            $actionArray = $data['challenges_action'][0]['action'];
        }
        if(!empty($data['challenges_action'][0]['ch_actions']))
        {
            $dateArray = $data['challenges_action'][0]['ch_actions'];
        }


        // pr($action);
        // prd($complete_date);
        $resultArray = [];

        foreach ($actionArray as $key => $action) {
            $object = new stdClass();
            $object->action = $action;
            $object->complete_date = $dateArray[$key];
            $resultArray[] = $object;
        }

        $data['actions']=$resultArray;

        $challenge_types = array(
            'Describe Action to address the challenge',
            'Who would be responsible for action. Specify name',
            'When would action be completed (date)',
            'Is there any support from project office needed to complete action',
            'What kind of support is needed',
            // 'Was action completed by expected date (Y/N/NA)',
            // 'Has action been changed/revised during last visit (Y/N)',
            // 'Facilitator to fill which is the revised/changed action',
        );

        foreach ($challenge_types as $key1 => $val) {
            $data['challenges_actions'][$key1]['name'] = $val;
            foreach ($data['challenges'] as $key => $val1) {
                $temp = json_decode($val1->action);
                if (!empty($temp)) {
                    if ($key1 == 0) {
                        $data['challenges_actions'][$key1]['ch_actions'][$key] = $temp[0]->sa_action_completed != '' ? change_date_month_name_char(str_replace('/', '-', $temp[0]->sa_action_completed)) : 'N/A';
                        $data['challenges_actions'][$key1]['action'][$key] = $temp[0]->sa_describe_action;
                        continue;
                    }
                    if ($key1 == 1) {
                        $data['challenges_actions'][$key1]['action'][$key] = $temp[0]->sa_responsible;
                        continue;
                    }
                    if ($key1 == 2) {
                        $data['challenges_actions'][$key1]['action'][$key] = $temp[0]->sa_action_completed != '' ? change_date_month_name_char(str_replace('/', '-', $temp[0]->sa_action_completed)) : 'N/A';
                        continue;
                    }
                    if ($key1 == 3) {
                        $data['challenges_actions'][$key1]['action'][$key] = $temp[0]->sa_SHG_Cluster_complete;
                        continue;
                    }
                    if ($key1 == 4) {
                        $data['challenges_actions'][$key1]['action'][$key] = $temp[0]->sa_support_needed;
                        continue;
                    }
                    if ($key1 == 5) {
                        $data['challenges_actions'][$key1]['action'][$key] = $temp[0]->sa_expected_date;
                        continue;
                    }
                    // if ($key1 == 6) {
                    //     $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_changed_rating;
                    //     continue;
                    // }
                    // if ($key1 == 7) {
                    //     $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_facilitator;
                    //     continue;
                    // }
                }
            }
        }


        $data['observation'] = DB::table('cluster_observation as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();


        $file_name = $data['profile'][0]->name_of_cluster;
        return $data;
    }

    public function exportPDF($cluster_id)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data= $this->mainPDF($cluster_id);

        $file_name = $data['profile'][0]->name_of_cluster;
        $analysis = cluster_analysis($cluster_id);
        $viewData = array_merge($data, $analysis);
        view()->share('data', $viewData);
        $pdf_doc = PDF::loadView('pdf.cluster_details_pdf', $viewData)->setPaper('a3', 'landscape');
        return $pdf_doc->stream($file_name.'_'.$data['uin'].'_'.pdf_date().'.pdf');
    }

    public function exportclusterPDF($cluster_id)
    {

        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data['u_type'] = $user->u_type;
        $data= $this->mainPDF($cluster_id);
          $analysis = cluster_analysis($cluster_id);
        $viewData = array_merge($data, $analysis);
        view()->share('data', $viewData);

        return view('pdf.ClusterDetailsCardsPDF')->with($viewData);

        // $pdf_doc = PDF::loadView('pdf.clusterDetailCardPdf', $data)->setPaper('a3', 'landscape');
        // return $pdf_doc->stream($file_name . '_' . $data['uin'] . '_' . pdf_date() . '.pdf');
    }

    public function check_nrlm_code(Request $request){
            $nrml = $request->get('inputValue');
            $fed_id = $request->get('fed_id');
            $res = DB::table('cluster_profile')
            ->where('vo_code', $nrml)
            ->where('is_deleted', 0)
            ->get();
        $total = $res->count();
        echo $total;

    }

    public function getLatLongCluster(Request $request)
    {

        $data = [];
        if ($request->post('filter') == 'Search') {
            $federation = $request->input('federation');
            // prd($federation);
            $dateArr = array('federation' => $federation);
            Session::put('cluster_session', $request->all());
        }
        if (!empty($request->post('filter') == 'clear')) {
            $request->session()->forget('cluster_session');
        }


        if ($request->ajax()) {
            $session_data = Session::get('cluster_session');


            $query = " SELECT
            b.latitude,
            b.longitude,
            b.location_name,
            b.upload_date_time,
            b.lat_long_date_time,
            b.name_of_cluster,
            d.agency_name,
            b.id

        FROM
            cluster_mst AS a
        INNER JOIN cluster_sub_mst AS s
        ON
            s.cluster_mst_id = a.id
        INNER JOIN cluster_profile AS b
        ON
            b.cluster_sub_mst_id = s.id
        INNER JOIN federation_mst AS c
        ON
            a.federation_uin = c.uin
        INNER JOIN federation_sub_mst AS X
        ON
            X.federation_mst_id = c.id
        INNER JOIN federation_profile AS h
        ON
            h.federation_sub_mst_id = X.id
        INNER JOIN agency AS d
        ON
            a.agency_id = d.agency_id
        LEFT JOIN countries AS e
        ON
            b.name_of_country = e.id
        LEFT JOIN states AS f
        ON
            b.name_of_state = f.id
        LEFT JOIN district AS g
        ON
            b.name_of_district = g.id

            INNER JOIN (SELECT a.*
                FROM task_assignment AS a
                JOIN (
                    SELECT assignment_id, MAX(updated_at) AS max_updated_at
                    FROM task_assignment
                    WHERE assignment_type = 'CL' AND `status` = 'D'
                    GROUP BY assignment_id
                ) AS b ON a.assignment_id = b.assignment_id AND a.updated_at = b.max_updated_at
                ORDER BY a.updated_at DESC) as ta ON a.id = ta.assignment_id
                LEFT JOIN users as ur
                ON ur.id = ta.user_id
        WHERE
            a.is_deleted = 0  AND b.longitude != '' AND b.latitude != '' ";

            if (!empty($session_data['state'])) {
                if ($session_data['state'] != '' && $session_data['state'] > 0) {
                    $query .= " AND b.state_id = '" . $session_data['state'] . "' ";
                }
            }
            if (!empty($session_data['district'])) {
                if ($session_data['district'] != '' && $session_data['district'] > 0) {
                    $query .= " AND b.district_id = '" . $session_data['district'] . "' ";
                }
            }
            if (!empty($session_data['country'])) {
                if ($session_data['country'] != '' && $session_data['country'] > 0) {
                    $query .= " AND b.country_id = '" . $session_data['country'] . "' ";
                }
            }
            if(empty($session_data['Fac_id'])){
                if (!empty($session_data['agency_id'])) {
                    $text_search = $session_data['agency_id'];
                    $query .= " AND a.agency_id ='" . $session_data['agency_id'] . "' ";
                }
            }
            if (!empty($session_data['Fac_id'])) {
                $text_search = $session_data['Fac_id'];
                $query .= " AND ta.user_id ='" . $session_data['Fac_id'] . "' ";
            }

            // if (!empty($session_data['agency_id'])) {
            //     $text_search = $session_data['agency_id'];
            //     $query .= " AND a.agency_id ='" . $session_data['agency_id'] . "' ";
            // }
            // if (!empty($session_data['cluster_id'])) {
            //     $text_search = $session_data['cluster_id'];
            //     $query .= " AND a.id ='" . $session_data['cluster_id'] . "' ";
            // }
            // if (!empty($session_data['federation_id'])) {
            //     $text_search = $session_data['federation_id'];
            //     $query .= " AND a.id ='" . $session_data['federation_id'] . "' ";
            // }
            $result = DB::select(DB::raw($query));
            return json_encode($result);
            // exit;
        }
        $query = "SELECT * from agency WHERE is_deleted = 0";
        $data['agency'] = DB::select($query);

        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        return view('cluster.map')->with($data);
    }

    public function mapDatatableCluster(Request $request)
    {

        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
        }
        $data = [];

        if ($request->ajax()) {
            $session_data = Session::get('cluster_session');

            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');
            $txt_search = $request->post('search')['value'];

            $query = " SELECT
                b.*,
                d.agency_name,
                e.name AS country_name,
                f.name AS state_name,
                g.name AS district_name,
                a.uin,
                a.id AS ids,
                a.srlm_code,
                a.status,
                a.created_at as created,
                a.federation_uin,
                h.name_of_federation,
                s.status AS clust_status,
                s.analytics,
                s.dm_a,
                s.qa_a,
                s.dm_r,
                s.qa_r,
                s.updated_at,
                s.locked,
                s.flag,
                s.status_flag

            FROM
                cluster_mst AS a
            INNER JOIN cluster_sub_mst AS s
            ON
                s.cluster_mst_id = a.id
            INNER JOIN cluster_profile AS b
            ON
                b.cluster_sub_mst_id = s.id
            INNER JOIN federation_mst AS c
            ON
                a.federation_uin = c.uin
            INNER JOIN federation_sub_mst AS X
            ON
                X.federation_mst_id = c.id
            INNER JOIN federation_profile AS h
            ON
                h.federation_sub_mst_id = X.id
            INNER JOIN agency AS d
            ON
                a.agency_id = d.agency_id
            LEFT JOIN countries AS e
            ON
                b.name_of_country = e.id
            LEFT JOIN states AS f
            ON
                b.name_of_state = f.id
            LEFT JOIN district AS g
            ON
                b.name_of_district = g.id";

                if (!empty($session_data['Fac_id'])) {
            if ($session_data['Fac_id'] != '' && $session_data['Fac_id'] > 0) {
                $query .= " INNER JOIN (SELECT a.*
                FROM task_assignment AS a
                JOIN (
                    SELECT assignment_id, MAX(updated_at) AS max_updated_at
                    FROM task_assignment
                    WHERE assignment_type = 'CL' AND `status` = 'D'
                    GROUP BY assignment_id
                ) AS b ON a.assignment_id = b.assignment_id AND a.updated_at = b.max_updated_at
                ORDER BY a.updated_at DESC) as ta ON a.id = ta.assignment_id ";
            }
        }
        $query .= " where a.is_deleted = 0  AND b.longitude != '' AND b.latitude != '' ";


            if (!empty($session_data['state'])) {
                if ($session_data['state'] != '' && $session_data['state'] > 0) {
                    $query .= " AND b.state_id = '" . $session_data['state'] . "' ";
                }
            }
            if (!empty($session_data['district'])) {
                if ($session_data['district'] != '' && $session_data['district'] > 0) {
                    $query .= " AND b.district_id = '" . $session_data['district'] . "' ";
                }
            }
            if (!empty($session_data['country'])) {
                if ($session_data['country'] != '' && $session_data['country'] > 0) {
                    $query .= " AND b.country_id = '" . $session_data['country'] . "' ";
                }
            }
            if(empty($session_data['Fac_id'])){
                if (!empty($session_data['agency_id'])) {
                    $text_search = $session_data['agency_id'];
                    $query .= " AND a.agency_id ='" . $session_data['agency_id'] . "' ";
                }
            }
            if (!empty($session_data['Fac_id'])) {
                $text_search = $session_data['Fac_id'];
                $query .= " AND ta.user_id ='" . $session_data['Fac_id'] . "' ";
            }


            if ($txt_search != '') {
                $query .= " AND (b.name_of_cluster like '%$txt_search%' ";
                $query .= " or h.name_of_federation like '%$txt_search%' ";
                $query .= " or a.uin like '%$txt_search%' )";
            }
            $clusters = DB::select($query);
            $total = count($clusters);
            $query .= " ORDER BY
                    s.updated_at
                DESC,a.id DESC
                LIMIT $limit OFFSET $start";
            $clusters = DB::select($query);

            foreach ($clusters as $cluster) {
                $visit = 'Created';
                if ($cluster->dm_a == 'V' && $cluster->qa_a == 'V' && $cluster->locked == 1) {
                    $visit = 'Locked';
                } elseif ($cluster->dm_a == 'V' && $cluster->qa_a == 'V') {
                    $visit = 'Initial Rating';
                } elseif ($cluster->dm_a == 'V' && $cluster->qa_a == 'P') {
                    $visit = 'Analytics Complete';
                } elseif ($cluster->dm_a == 'P') {
                    $visit = 'Visit Complete';
                } elseif ($cluster->dm_a == 'N' && $cluster->flag == 0) {
                    $visit = 'Visit Pending';
                } elseif ($cluster->dm_a == 'R' && $cluster->flag == 1) {
                    $visit = 'Visit Reassigned';
                }

                $row = [];
                $row[] = ++$start;
                $row[] = $cluster->uin;
                $row[] = $cluster->name_of_cluster;
                $row[] = $cluster->name_of_federation;
                $row[] = $visit;
                $row[] = change_date_month_name_char($cluster->created_at);
                $row[] = change_date_month_name_char($cluster->updated_at);
                $row[] = $cluster->locked == 1 ? 'Yes' : 'No';

                $data[] = $row;
            }

            $output = array(
                "draw" => $request->post('draw'),
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $data,
            );
            echo json_encode($output);
            exit;
        }
        $query = "SELECT * from agency WHERE is_deleted = 0";
        $data['agency'] = DB::select($query);

        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        return view('cluster.map')->with($data);
    }
}
