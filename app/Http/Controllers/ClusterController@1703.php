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
        $user_geo = DB::table('user_location_relation')
                ->where('user_id', $user->id)
                ->where('is_deleted', '=', 0)
                ->orderBy('country_id')
                ->get()->toArray();
        if ($request->ajax()) {
            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');
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
                    s.flag
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
                $subquery = '';
                foreach ($user_geo as $user_details) {
                    $check = 1;
                    if (!empty($user_details->district_id)) {
                        $check = 0;
                        if ($subquery != '') {
                            $subquery .= ' or ';
                        }
                        $subquery.= " b.district_id in ( $user_details->district_id )";
                    }
                    if (!empty($user_details->state_id) && ($check == 1)) {
                        if ($subquery != '') {
                            $subquery .= ' or ';
                        }
                        $subquery.= " b.state_id = $user_details->state_id ";
                    }
                }
                if ($subquery != '') {
                    $query .= ' and  ('.$subquery .')';
                }
            }
            if ($txt_search != '') {
                $query .= " AND (b.name_of_cluster like '%$txt_search%' ";
                $query .= " or h.name_of_federation like '%$txt_search%' )";
            }
            $clusters = DB::select($query);
            $total = count($clusters);
            $query.= " ORDER BY
                    s.updated_at
                DESC,a.id DESC
                LIMIT $limit OFFSET $start";
            //prd($query);
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
                $row[] =change_date_month_name_char($cluster->created_at);
                $row[] =change_date_month_name_char($cluster->updated_at);
                // $row[] = change_monthName_to_date($cluster->created_at);
                // $row[] = change_date_format_display($cluster->updated_at);
                $row[] = $cluster->locked == 1 ? 'Yes':'No';



                // $row[] = $cluster->srlm_code;

                $row[] = $cluster->status == 'A' ? '<span class="status-active">Active</span>' : '<span class="status-inactive">InActive</span>';
                $btns = '';

                $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('cluster.edit', $cluster->ids) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                $btns .= '<a class="btn btn-success btn-link btn-sm" rel="tooltip" title="View" data-original-title="View" href="' . route('cluster.show', $cluster->ids) . '" style="padding:0px;margin-left:5px"><i class="c-white-500 ti-eye"></i></a>';
                $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $cluster->ids . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';

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

        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
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

            //prd($request->all());
            try {
                $validation_arr = [
                    'agency_id' => ['required'],
                    'federation_id' => ['required'],
                    'name_of_cluster' => ['required'],
                    'cluster_formed' => ['required'],
                    // 'srlm_code' => ['required'],
                    'country' => ['required'],
                    'state' => ['required'],
                    // 'district' => ['required'],
                    // 'status' => ['required'],
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
                    //prd($web_mobile['0']);
                    // prd($web_mobile[0].','.$web_email[0].','.$contact_name[0]);
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
                            // $cluster_mst->srlm_code = $request->post('srlm_code');
                            $cluster_mst->created_by = $user->id;
                            // echo 'A'.substr($temp_rand, -3).'FEDVI'.rand(1000000, 9999999);
                            // die();
                            $qry = "SELECT * FROM fcsnode_mst WHERE tkn='" . $request->post("federation_id") . "'";
                            $data = DB::select($qry);
                            //prd($data);
                            $pid = !empty($data[0]->id) > 0 ? $data[0]->id : 0;

                            $result = $cluster_mst->save();
                            //prd($key);

                            $ClusterProfile = array(
                                'cluster_sub_mst_id' => $cluster_mst->id,
                                'name_of_cluster' => $value,
                                'country_id' => $request->post('country'),
                                'state_id' => $request->post('state'),
                                'district_id' => $request->post('district'),
                                'name_of_country' => getName('countries', 'name', $request->post('country')),
                                'name_of_state' => getName('states', 'name', $request->post('state')),
                                'name_of_district' => getName('district', 'name', $request->post('district')),
                                'no_of_of_cluster_in_cluster' =>'',
                                'web_mobile' => $web_mobile[$key],
                                 'web_email' => $web_email[$key],
                                 'contact_name' => $contact_name[$key],
                                 'block' => $request->post('block'),
                                //'cluster_formed'=> change_date_format($request->post('cluster_formed')),
                                'cluster_formed' => $cluster_formed[$key],
                                // 'office_location' => '',
                                // 'shg_at_time_creation' => '',
                                // 'cluster_members_at_time_creation' => '',
                                // 'total_SHGs' => '',
                                // 'total_members' => '',
                                // 'president' => '',
                                // 'secretary' => '',
                                // 'treasure' => '',
                                // 'book_keeper_name' => '',
                                // 'contact_number' => '',
                                // 'no_of_of_shg_in_cluster' => '',

                                'created_by' => $user->id
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
            // prd($request->all());

            //  $search = $request->post('search');

            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');



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

            $clusters = DB::select($query);
            // prd($clusters );
            $total = count($clusters);
            $query .= " ORDER BY
                    z.created_at
                DESC
                LIMIT $limit OFFSET $start";
            //prd($query);
            $clusters = DB::select($query);
            // prd($clusters );
            foreach ($clusters as $cluster) {
                $row = [];
                $row[] = ++$start;

                $row[] = $cluster->name_of_cluster;
                $row[] = $cluster->uin;

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

            // prd($request->all());
            $agency = $request->post('agency_id');
            $country = $request->post('country');
            // prd($country);
            $state = $request->post('state');
            $district = $request->post('district');
            $agency = $request->post('agency_id');
            $federation_id = $request->post('federation_id');



            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');
            // $txt_search = $request->post('search')['value'];

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
                    $query .= " AND Y.federation_uin = '" . $federation_id. "' ";
                }
            }
            $clusters = DB::select($query);
            // prd($clusters );
            $total = count($clusters);



            foreach ($clusters as $cluster) {
                $row = [];
                $row['sn'] = ++$start;

                $row['cluster_name'] = $cluster->name_of_cluster;
                $row['uin'] = $cluster->uin;
                // $row[] = $cluster->srlm_code;



                $data[] = $row;
            }
            //  prd($request->post('draw'));
            $output = array(
                "draw"            => $request->post('draw'),
                "recordsTotal"    => $total,
                "recordsFiltered" => $total,
                "data"            => $data,
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
        foreach ($challenge_type as $key1 => $val) {
            $data['challenges_action'][$key1]['name'] = $val;
            foreach ($data['challenges'] as $key => $val1) {
                $temp = json_decode($val1->action);
                if (!empty($temp)) {
                    if ($key1 == 0) {
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
            }
        }

        $data['observation'] = DB::table('cluster_observation as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        //analysis 1
        $count = 0;
        $data['show1'] = '';
        $data['analysis_1'] = '';
        if (!empty($data['governance']) > 0) {
            if (($data['governance'][0]->first_election_date) != '') {
                $count += 1;
            }
            if (($data['governance'][0]->date_last_election) != '') {
                $count += 1;
            }
        }
        if ($count != 0) {
            $data['analysis_1'] = $count == 2 ? 5 : ($count == 1 ? 3 : 0);
            $x1_data = ($data['analysis_1'] * 100) / 5;
            $data['show1'] = $x1_data >= 90 ? 'green' : ($x1_data >= 75 ? 'yellow' : ($x1_data >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_1'] = 0;
            $data['show1'] = 'red_status';
        }

        //analysis 2
        $x2 = ($data['analysis'][0]->Average_participation_of);
        $data['analysis_data']['Average_participation_of'] = '';
        $data['analysis_data']['color1'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Average_participation_of'] = ($x2 == 100 ? 5 : ($x2 >= 80 ? 4 : ($x2 >= 60 ? 3 : 2)));
            if($x2 == 100)
            {
                $data['analysis_data']['color1'] = 'green';
            }
            elseif($x2 >= 80 && $x2 <= 99)
            {
                $data['analysis_data']['color1'] = 'yellow';
            }
            elseif($x2 >= 60 && $x2 <= 79)
            {
                $data['analysis_data']['color1'] = 'grey';
            }
            elseif ($x2 < 59) {
                $data['analysis_data']['color1'] = 'red_status';
            }
            //$x4 = ($data['analysis_data']['Average_participation_of'] * 100) / 5;
            //$data['analysis_data']['color1'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['Average_participation_of'] = 0;
            $data['analysis_data']['color1'] = 'red_status';
        }

        //analysis 3
        $count3 = $data['analysis'][0]->Cluster_Book_updation;
        
        $data['analysis_data']['Cluster_Book_updation'] = '';
        $data['analysis_data']['color2'] = '';
        if ($count3 != '') {
            
            
            if($count3 == 'Fully updated')
            {
                $data['analysis_data']['Cluster_Book_updation'] = 5;
                $data['analysis_data']['color2'] = 'green';
            }
            if($count3 == 'Partially updated')
            {
                $data['analysis_data']['Cluster_Book_updation'] = 4;
                $data['analysis_data']['color2'] = 'yellow';
            }
            if($count3 == 'Book not updated')
            {
                $data['analysis_data']['Cluster_Book_updation'] = 0;
                $data['analysis_data']['color2'] = 'red_status';
            }
            
            
            
            //$x4 = ($data['analysis_data']['Cluster_Book_updation'] * 100) / 5;
            //$data['analysis_data']['color2'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['Cluster_Book_updation'] = '--';
            $data['analysis_data']['color2'] = '';
        }
        //analysis 4
         
        
        $data['analysis_data']['Percentage_of_Defunct'] = '';
        $data['analysis_data']['color3'] = '';
        $nine_b = $data['profile'][0]->shg_at_time_creation;
        $ten_b  = $data['profile'][0]->total_SHGs;
        //prd($nine_b.'<<<'.$ten_b);
        if($nine_b > 0 || $nine_b > 0)
        {
            $diff = round((($nine_b - $ten_b)/$nine_b)*100);
            //prd($diff);
            if(($ten_b >= $nine_b) || ($diff <= 5))
            {
                $data['analysis_data']['Percentage_of_Defunct'] = 5;
                $data['analysis_data']['color3'] = 'green';
            }
            elseif($diff >= 6 &&  $diff <= 10)
            {
                $data['analysis_data']['Percentage_of_Defunct'] = 4;
                $data['analysis_data']['color3'] = 'yellow';
            }
            elseif ($diff >= 11 && $diff <= 20) {
                $data['analysis_data']['Percentage_of_Defunct'] = 3;
                $data['analysis_data']['color3'] = 'grey';
            } else {
                $data['analysis_data']['Percentage_of_Defunct'] = 1;
                $data['analysis_data']['color3'] = 'red_status';
            }
        }
        else{
            $data['analysis_data']['Percentage_of_Defunct'] = '--';
        }

     
        //analysis 5
        $count4 = $data['analysis'][0]->External_audit_completed;
        $data['analysis_data']['External_audit_completed'] = '';
        $data['analysis_data']['color4'] = '';
        if ($count4 != '') {
            $data['analysis_data']['External_audit_completed'] = ($count4 == 'Yes' ? 5 : 0);
            if ($count4 == 'Yes') {
                $data['analysis_data']['color4'] = 'green';
            } elseif ($count4 == 'No') {
                $data['analysis_data']['color4'] = 'red_status';
            }
            //$x4 = ($data['analysis_data']['External_audit_completed'] * 100) / 5;
            //$data['analysis_data']['color4'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['External_audit_completed'] = 0;
            $data['analysis_data']['color4'] = 'red_status';
        }
        $data['total1'] = (float)$data['analysis_data']['Average_participation_of'] + (float)$data['analysis_data']['Cluster_Book_updation'] + (float)$data['analysis_data']['Percentage_of_Defunct'] + (float)$data['analysis_data']['External_audit_completed'] + (float)$data['analysis_1'];
        $total_gover = ($data['total1'] * 100) / 25;
        $data['score']=$total_gover;
        $data['tcolor1'] = $total_gover >= 90 ? 'green' : ($total_gover >= 75 ? 'yellow' : ($total_gover >= 60 ? 'grey' : 'red_status'));

        //analysis 6
        $x2 = (str_replace('%', '', $data['analysis'][0]->Coverage_of_target));
        $data['analysis_data']['Coverage_of_target'] = '';
        $data['analysis_data']['color5'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Coverage_of_target'] = (($x2 >= 80 ? 5 : ($x2 >= 60 ? 4 : ($x2 >= 40 ? 3 : 2))));
            if ($x2 >= 80 && $x2 <= 100) {
                $data['analysis_data']['color5'] = 'green';
            } elseif ($x2 >= 60 && $x2 <= 79) {
                $data['analysis_data']['color5'] = 'yellow';
            } elseif ($x2 >= 40 && $x2 <= 59) {
                $data['analysis_data']['color5'] = 'grey';
            } elseif ($x2 < 40) {
                $data['analysis_data']['color5'] = 'red_status';
            }
            //$x4 = ($data['analysis_data']['Coverage_of_target'] * 100) / 5;
            //$data['analysis_data']['color5'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['Coverage_of_target'] = 0;
            $data['analysis_data']['color5'] = 'red_status';
        }
        //analysis 7
        $x2 = $data['analysis'][0]->Percentage_of_poorest_benefiting_from_all_loans;
        $data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] = '';
        $data['analysis_data']['color6'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] = (($x2 >= 75 ? 5 : ($x2 >= 60 ? 4 : ($x2 >= 40 ? 3 : 1))));
            if ($x2 >= 75 && $x2 <= 100) {
                $data['analysis_data']['color6'] = 'green';
            } elseif ($x2 >= 50 && $x2 <= 74) {
                $data['analysis_data']['color6'] = 'yellow';
            } elseif ($x2 >= 30 && $x2 <= 49) {
                $data['analysis_data']['color6'] = 'grey';
            } elseif ($x2 < 30) {
                $data['analysis_data']['color6'] = 'red_status';
            }
            //$x4 = ($data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] * 100) / 5;
            //$data['analysis_data']['color6'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] = 0;
            $data['analysis_data']['color6'] = 'red_status';
        }
        //analysis 8
        $x2 = $data['analysis'][0]->Representation_of_Poorest;
        $data['analysis_data']['Representation_of_Poorest'] = '';
        $data['analysis_data']['color55'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Representation_of_Poorest'] = (($x2 >= 60 ? 5 : ($x2 >= 40 ? 4 : ($x2 >= 25 ? 3 : 1))));
            if ($x2 >= 60) {
                $data['analysis_data']['color55'] = 'green';
            } elseif ($x2 >= 40 && $x2 <= 59) {
                $data['analysis_data']['color55'] = 'yellow';
            } elseif ($x2 >= 25 && $x2 <= 39) {
                $data['analysis_data']['color55'] = 'grey';
            } elseif ($x2 < 25) {
                $data['analysis_data']['color55'] = 'red_status';
            }
            //$x4 = ($data['analysis_data']['Representation_of_Poorest'] * 100) / 5;
            //$data['analysis_data']['color55'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['Representation_of_Poorest'] = 0;
            $data['analysis_data']['color55'] = 'red_status';
        }
        $data['total2'] = (float)$data['analysis_data']['Coverage_of_target'] + (float)$data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] + (float)$data['analysis_data']['Representation_of_Poorest'];
        $total_in = ($data['total2'] * 100) / 15;
        $data['score1']=$total_in;
        $data['tcolor2'] = $total_in >= 90 ? 'green' : ($total_in >= 75 ? 'yellow' : ($total_in >= 60 ? 'grey' : 'red_status'));

        //analysis 9
        $count11 = $data['efficiency'][0]->group_prepare;
        $data['analysis_data']['group_prepare'] = '';
        $data['analysis_data']['color1111'] = '';
        if ($count11 != '') {
            $data['analysis_data']['group_prepare'] = ($count11 == 'Yes' ? 5 : 0);
            $x4 = ($data['analysis_data']['group_prepare'] * 100) / 5;
            $data['analysis_data']['color1111'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['group_prepare'] = 0;
            $data['analysis_data']['color1111'] = 'red_status';
        }
        //analysis 11
        $count4 = $data['analysis'][0]->Cluster_is_covering_its;
        
        $data['analysis_data']['Cluster_is_covering_its'] = '';
        $data['analysis_data']['color7'] = '';
        if ($count4 != '') {
            $data['analysis_data']['Cluster_is_covering_its'] = ($count4 == 'Yes' ? 5 : 0);
            if ($count4 == 'Yes') {
                $data['analysis_data']['color7'] = 'green';
            } elseif ($count4 == 'No') {
                $data['analysis_data']['color7'] = 'red_status';
            }
            //$x4 = ($data['analysis_data']['Cluster_is_covering_its'] * 100) / 5;
            //$data['analysis_data']['color7'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['Cluster_is_covering_its'] = 0;
            $data['analysis_data']['color7'] = 'red_status';
        }
        //analysis 10
        $x2 = (int)$data['analysis'][0]->Time_taken_to_disburse;
        
        $data['analysis_data']['Time_taken_to_disburse'] = '';
        $data['analysis_data']['color8'] = '';
        if ($x2 != '') {
            if ($x2 <= 2) {
                $data['analysis_data']['Time_taken_to_disburse'] = 5;
                $data['analysis_data']['color8'] = 'green';
            } elseif ($x2 > 2 && $x2 <= 3) {
                $data['analysis_data']['Time_taken_to_disburse'] = 4;
                $data['analysis_data']['color8'] = 'yellow';
            } elseif ($x2 > 3 && $x2 <= 5) {
                $data['analysis_data']['Time_taken_to_disburse'] = 3;
                $data['analysis_data']['color8'] = 'grey';
            } elseif ($x2 > 5) {
                $data['analysis_data']['Time_taken_to_disburse'] = 1;
                $data['analysis_data']['color8'] = 'red_status';
            }
            //$x4 = ($data['analysis_data']['Time_taken_to_disburse'] * 100) / 5;
            //$data['analysis_data']['color8'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['Time_taken_to_disburse'] = '--' ;
            $data['analysis_data']['color8'] = 'red_status';
        }

        $data['total3'] = (float)$data['analysis_data']['Cluster_is_covering_its'] + (float)$data['analysis_data']['Time_taken_to_disburse'] + (float)$data['analysis_data']['group_prepare'];
        $total_ef = ($data['total3'] * 100) / 15;
        $data['score2']=$total_ef;
        $data['tcolor3'] = $total_ef >= 90 ? 'green' : ($total_ef >= 75 ? 'yellow' : ($total_ef >= 60 ? 'grey' : 'red_status'));

        //analysis 12
        $x2 = (str_replace('%', '', $data['analysis'][0]->Repayment_rate_of_cluster_loan));
        $data['analysis_data']['Repayment_rate_of_cluster_loan'] = '';
        $data['analysis_data']['color9'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Repayment_rate_of_cluster_loan'] = (($x2 >= 95 ? 10 : ($x2 >= 85 ? 7 : ($x2 >= 70 ? 5 : 2))));
            if ($x2 >= 95) {
                $data['analysis_data']['color9'] = 'green';
            } elseif ($x2 >= 80 && $x2 <= 94) {
                $data['analysis_data']['color9'] = 'yellow';
            } elseif ($x2 >= 70 && $x2 <= 79) {
                $data['analysis_data']['color9'] = 'grey';
            } elseif ($x2 < 70) {
                $data['analysis_data']['color9'] = 'red_status';
            }
            //$x4 = ($data['analysis_data']['Repayment_rate_of_cluster_loan'] * 100) / 10;
            //$data['analysis_data']['color9'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['Repayment_rate_of_cluster_loan'] = 0;
            $data['analysis_data']['color9'] = 'red_status';
        }
        //analysis 13
        $x2 = (str_replace('%', '', $data['analysis'][0]->Cluster_loan_PAR));
        $data['analysis_data']['Cluster_loan_PAR'] = '';
        $data['analysis_data']['color10'] = '';
        if ($x2 != '') {
            if ($x2 == 0) {
                $data['analysis_data']['Cluster_loan_PAR'] = 10;
                $data['analysis_data']['color10'] = 'green';
            }
            if ($x2 >= 1 && $x2 <= 5) {
                $data['analysis_data']['Cluster_loan_PAR'] = 7;
                $data['analysis_data']['color10'] = 'yellow';
            }
            if ($x2 >= 6 && $x2 <= 10) {
                $data['analysis_data']['Cluster_loan_PAR'] = 5;
                $data['analysis_data']['color10'] = 'grey';
            }
            if ($x2 > 10) {
                $data['analysis_data']['Cluster_loan_PAR'] = 2;
                $data['analysis_data']['color10'] = 'red_status';
            }

        } else {
            $data['analysis_data']['Cluster_loan_PAR'] = 0 ;
            $data['analysis_data']['color10'] = 'red_status';

        }
        //analysis 14
        $x2 = $data['analysis'][0]->Percentage_members_assisted_more_than_one;
        $data['analysis_data']['Percentage_members_assisted_more_than_one'] = '';
        $data['analysis_data']['color11'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Percentage_members_assisted_more_than_one'] = (($x2 >= 75 ? 5 : ($x2 >= 50 ? 4 : ($x2 >= 25 ? 3 : 1))));
            if ($x2 >= 75) {
                $data['analysis_data']['color11'] = 'green';
            } elseif ($x2 >= 50 && $x2 <= 74) {
                $data['analysis_data']['color11'] = 'yellow';
            } elseif ($x2 >= 25 && $x2 <= 49) {
                $data['analysis_data']['color11'] = 'grey';
            } elseif ($x2 < 25) {
                $data['analysis_data']['color11'] = 'red_status';
            }
            //$x4 = ($data['analysis_data']['Percentage_members_assisted_more_than_one'] * 100) / 5;
            //$data['analysis_data']['color11'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['Percentage_members_assisted_more_than_one'] = 0;
            $data['analysis_data']['color11'] = 'red_status';
        }
        //analysis 15
        $x2 = $data['analysis'][0]->Percentage_Livelihood_purposes;
        $data['analysis_data']['Percentage_Livelihood_purposes'] = '';
        $data['analysis_data']['color12'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Percentage_Livelihood_purposes'] = (($x2 >= 90 ? 5 : ($x2 >= 75 ? 4 : ($x2 >= 60 ? 3 : 1))));
            if ($x2 >= 90) {
                $data['analysis_data']['color12'] = 'green';
            } elseif ($x2 >= 75 && $x2 <= 89) {
                $data['analysis_data']['color12'] = 'yellow';
            } elseif ($x2 >= 60 && $x2 <= 74) {
                $data['analysis_data']['color12'] = 'grey';
            } elseif ($x2 < 60) {
                $data['analysis_data']['color12'] = 'red_status';
            }
            //$x4 = ($data['analysis_data']['Percentage_Livelihood_purposes'] * 100) / 5;
            //$data['analysis_data']['color12'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['Percentage_Livelihood_purposes'] = 0;
            $data['analysis_data']['color12'] = 'red_status';
        }
        $data['total4'] = (float)$data['analysis_data']['Repayment_rate_of_cluster_loan'] + (float)$data['analysis_data']['Cluster_loan_PAR'] + (float)$data['analysis_data']['Percentage_members_assisted_more_than_one'] + (float)$data['analysis_data']['Percentage_Livelihood_purposes'];
        $total_cr = ($data['total4'] * 100) / 30;
        $data['score3']=$total_cr;
        $data['tcolor4'] = $total_cr >= 90 ? 'green' : ($total_cr >= 75 ? 'yellow' : ($total_cr >= 60 ? 'grey' : 'red_status'));

        //analysis 16
        
        $total_member = (int)$data['profile'][0]->total_members ;
        // $voluntary_saving = (int)$data['saving'][0]->voluntary_savings_inception ;
        $data['analysis_data']['Percentage_of_the_cluster'] = '';
        $data['analysis_data']['color111'] = '';
        // if ($total_member > 0) {
        //     $res12 = ($voluntary_saving / $total_member) * 100 ;
        //     $x2 = round($res12, 2);
        // }
        $x2 = $data['analysis'][0]->Percentage_of_the_cluster;
        if ($x2 != '') {
            $data['analysis_data']['Percentage_of_the_cluster'] = (($x2 >= 90 ? 10 : ($x2 >= 75 ? 7 : ($x2 >= 60 ? 4 : 2))));
            //prd($data['analysis_data']['Percentage_of_the_cluster']);
            $x4 = ($data['analysis_data']['Percentage_of_the_cluster'] * 100) / 10;
            $data['analysis_data']['color111'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['Percentage_of_the_cluster'] = 0;
            $data['analysis_data']['color111'] = 'red_status';
        }

        // analysis 17
        $lsf = (int)$data['saving'][0]->members ;
        $data['analysis_data']['compulsory_savings'] = '';
        $data['analysis_data']['color112'] = '';
        $count12 = '';
        if ($total_member > 0) {
            $res12 = ($lsf / $total_member) * 100 ;
            $count12 = round($res12, 2);
        }
        //prd($count12);
        if ($count12 != '') {
            $data['analysis_data']['compulsory_savings'] = (($count12 >= 90 ? 5 : ($count12 >= 75 ? 4 : ($count12 >= 60 ? 3 : 1))));
            $x12 = ($data['analysis_data']['compulsory_savings'] * 100) / 5;
            $data['analysis_data']['color112'] = $x12 >= 90 ? 'green' : ($x12 >= 75 ? 'yellow' : ($x12 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_data']['compulsory_savings'] = 0;
            $data['analysis_data']['color112'] ='red_status';
        }

        $data['total5'] = (float)$data['analysis_data']['Percentage_of_the_cluster'] + (float)$data['analysis_data']['compulsory_savings'];
        $total_sv = ($data['total5'] * 100) / 30;
        $data['score4']=$total_sv;
        $data['tcolor5'] = $total_sv >= 90 ? 'green' : ($total_sv >= 75 ? 'yellow' : ($total_sv >= 60 ? 'grey' : 'red_status'));

        $data['grand_total'] = $data['total1'] + $data['total2'] + $data['total3'] + $data['total4'] + $data['total5'];
        $total_grd = ($data['grand_total'] * 100) / 100;
        $data['grdcolor'] = $total_grd >= 90 ? 'green' : ($total_grd >= 75 ? 'yellow' : ($total_grd >= 60 ? 'grey' : 'red_status'));
        $data['show_final_status'] = $data['grdcolor'] == 'green' ? 'Minimal Risk' : ($data['grdcolor'] == 'yellow' ? ' Low Risk' : ($data['grdcolor'] == 'grey' ? 'Moderate Risk' : 'High Risk'));
        return view('cluster.view', compact('cluster'))->with($data);
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

        $data= $this->mainPDF($cluster_id);

        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.clustercardPdf', $data)->setPaper('a4', 'landscape');
        //prd($result);
        return $pdf_doc->download('Cluster_Rating_Card_'.$data['uin'] .'_'.pdf_date().'.pdf');
    }
    public function export(Request $request)
    {
        return Excel::download(new ClusterExport(), 'ClusterExport_'.pdf_date().'.xlsx');
    }

    public function clusterPDF(Request $request)
    {
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
                a.federation_uin,
                h.name_of_federation,
                s.status AS clust_status,
                s.analytics,
                s.dm_a,
                    s.qa_a,
                    s.dm_r,
                    s.qa_r,
                    s.updated_at,
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

        $query.= " ORDER BY s.updated_at DESC,a.id DESC ";

        $data = DB::select($query);
        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.clusterPdf', $data)->setPaper('a3', 'landscape');
        return $pdf_doc->download('Cluster_PDF_'.pdf_date().'.pdf');
    }
    public function mainPDF($cluster_id)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data['u_type'] = $user->u_type;

        $cluster = Cluster::find($cluster_id);
        $data['uin']= $cluster->uin;
        
        $data['cluster'] = $cluster;
        $data['cluster_ids'] = $cluster->id;

        $data['agency_id'] = $cluster->agency_id;
        // $data['quality_check'] = ($request->get('task_id') == NULL) ? 0 : 1;
        $data['quality_check'] = 1;
        //prd($data['quality_check']);
        $t_q_a = DB::table('task_qa_assignment as y')
            ->select('y.*')
            ->where('y.assignment_id', '=', $cluster->id)
            ->where('y.assignment_type', '=', 'CL')
            ->get()->toArray();
        //prd($t_q_a);
        // $data['task_id'] = $request->get('task_id') ?? ($t_q_a[0]->id) ?? NULL;
        $data['task_id'] = 1;
        $data['user_id'] =  null;
        //$data['user_id'] = $request->get('user_id') ?? ($t_q_a[0]->user_id) ?? NULL;
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

        //$data['profile_bank'] = json_decode($data['profile'][0]->Federation_Bank_ac);

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
        // prd($data['efficiency']);
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
        foreach ($challenge_type as $key1 => $val) {
            $data['challenges_action'][$key1]['name'] = $val;
            foreach ($data['challenges'] as $key => $val1) {
                $temp = json_decode($val1->action);
                if (!empty($temp)) {
                    if ($key1 == 0) {
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_describe_action;
                        continue;
                    }
                    if ($key1 == 1) {
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_responsible;
                        continue;
                    }
                    if ($key1 == 2) {
                        $data['challenges_action'][$key1]['action'][$key] = change_date_month_name_char(str_replace('/','-',$temp[0]->sa_action_completed));
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
            }
        }

        $data['observation'] = DB::table('cluster_observation as a')
            ->where('is_deleted', '=', 0)
            ->where('a.cluster_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        //analysis 1
        $count = 0;
        $data['show1'] = '';
        $data['analysis_1'] = '';
        if (!empty($data['governance']) > 0) {
            if (($data['governance'][0]->first_election_date) != '') {
                $count += 1;
            }
            if (($data['governance'][0]->date_last_election) != '') {
                $count += 1;
            }
        }
        if ($count != 0) {
            $data['analysis_1'] = $count == 2 ? 5 : ($count == 1 ? 3 : 0);
            $x1_data = ($data['analysis_1'] * 100) / 5;
            $data['show1'] = $x1_data >= 90 ? 'green' : ($x1_data >= 75 ? 'yellow' : ($x1_data >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_1'] = 0;
            $data['show1'] = 'red';
        }

        //analysis 2
        $x2 = ($data['analysis'][0]->Average_participation_of);
        $data['analysis_data']['Average_participation_of'] = '';
        $data['analysis_data']['color1'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Average_participation_of'] = ($x2 == 100 ? 5 : ($x2 >= 80 ? 4 : ($x2 >= 60 ? 3 : 2)));
            if($x2 == 100)
            {
                $data['analysis_data']['color1'] = 'green';
            }
            elseif($x2 >= 80 && $x2 <= 99)
            {
                $data['analysis_data']['color1'] = 'yellow';
            }
            elseif($x2 >= 60 && $x2 <= 79)
            {
                $data['analysis_data']['color1'] = 'grey';
            }
            elseif ($x2 < 59) {
                $data['analysis_data']['color1'] = 'red';
            }
            //$x4 = ($data['analysis_data']['Average_participation_of'] * 100) / 5;
            //$data['analysis_data']['color1'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Average_participation_of'] = 0;
            $data['analysis_data']['color1'] = 'red';
        }

        //analysis 3
        $count3 = $data['analysis'][0]->Cluster_Book_updation;
        
        $data['analysis_data']['Cluster_Book_updation'] = '';
        $data['analysis_data']['color2'] = '';
        if ($count3 != '') {
            
            
            if($count3 == 'Fully updated')
            {
                $data['analysis_data']['Cluster_Book_updation'] = 5;
                $data['analysis_data']['color2'] = 'green';
            }
            if($count3 == 'Partially updated')
            {
                $data['analysis_data']['Cluster_Book_updation'] = 4;
                $data['analysis_data']['color2'] = 'yellow';
            }
            if($count3 == 'Book not updated')
            {
                $data['analysis_data']['Cluster_Book_updation'] = 0;
                $data['analysis_data']['color2'] = 'red';
            }
            
            
            
            //$x4 = ($data['analysis_data']['Cluster_Book_updation'] * 100) / 5;
            //$data['analysis_data']['color2'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Cluster_Book_updation'] = '--';
            $data['analysis_data']['color2'] = '';
        }
        
        //analysis 4
        $data['analysis_data']['Percentage_of_Defunct'] = '';
        $data['analysis_data']['color3'] = '';
        $nine_b = $data['profile'][0]->shg_at_time_creation;
        $ten_b  = $data['profile'][0]->total_SHGs;
        //prd($nine_b.'<<<'.$ten_b);
        if($nine_b > 0 || $nine_b > 0)
        {
            $diff = round((($nine_b - $ten_b)/$nine_b)*100);
            //prd($diff);
            if(($ten_b >= $nine_b) || ($diff <= 5))
            {
                $data['analysis_data']['Percentage_of_Defunct'] = 5;
                $data['analysis_data']['color3'] = 'green';
            }
            elseif($diff >= 6 &&  $diff <= 10)
            {
                $data['analysis_data']['Percentage_of_Defunct'] = 4;
                $data['analysis_data']['color3'] = 'yellow';
            }
            elseif ($diff >= 11 && $diff <= 20) {
                $data['analysis_data']['Percentage_of_Defunct'] = 3;
                $data['analysis_data']['color3'] = 'grey';
            } else {
                $data['analysis_data']['Percentage_of_Defunct'] = 1;
                $data['analysis_data']['color3'] = 'red';
            }
        }
        else{
            $data['analysis_data']['Percentage_of_Defunct'] = '--';
        }
        //analysis 5
        $count4 = $data['analysis'][0]->External_audit_completed;
        $data['analysis_data']['External_audit_completed'] = '';
        $data['analysis_data']['color4'] = '';
        if ($count4 != '') {
            $data['analysis_data']['External_audit_completed'] = ($count4 == 'Yes' ? 5 : 0);
            if ($count4 == 'Yes') {
                $data['analysis_data']['color4'] = 'green';
            } elseif ($count4 == 'No') {
                $data['analysis_data']['color4'] = 'red';
            }
            //$x4 = ($data['analysis_data']['External_audit_completed'] * 100) / 5;
            //$data['analysis_data']['color4'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['External_audit_completed'] = 0;
            $data['analysis_data']['color4'] = 'red';
        }
        $data['total1'] = (float)$data['analysis_data']['Average_participation_of'] + (float)$data['analysis_data']['Cluster_Book_updation'] + (float)$data['analysis_data']['Percentage_of_Defunct'] + (float)$data['analysis_data']['External_audit_completed'] + (float)$data['analysis_1'];
        $total_gover = ($data['total1'] * 100) / 25;
        $data['score']=$total_gover;
        $data['tcolor1'] = $total_gover >= 90 ? 'green' : ($total_gover >= 75 ? 'yellow' : ($total_gover >= 60 ? 'grey' : 'red'));

        //analysis 6
        $x2 = (str_replace('%', '', $data['analysis'][0]->Coverage_of_target));
        $data['analysis_data']['Coverage_of_target'] = '';
        $data['analysis_data']['color5'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Coverage_of_target'] = (($x2 >= 80 ? 5 : ($x2 >= 60 ? 4 : ($x2 >= 40 ? 3 : 2))));
            if ($x2 >= 80 && $x2 <= 100) {
                $data['analysis_data']['color5'] = 'green';
            } elseif ($x2 >= 60 && $x2 <= 79) {
                $data['analysis_data']['color5'] = 'yellow';
            } elseif ($x2 >= 40 && $x2 <= 59) {
                $data['analysis_data']['color5'] = 'grey';
            } elseif ($x2 < 40) {
                $data['analysis_data']['color5'] = 'red';
            }
            //$x4 = ($data['analysis_data']['Coverage_of_target'] * 100) / 5;
            //$data['analysis_data']['color5'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Coverage_of_target'] = 0;
            $data['analysis_data']['color5'] = 'red';
        }
        //analysis 7
        $x2 = $data['analysis'][0]->Percentage_of_poorest_benefiting_from_all_loans;
        $data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] = '';
        $data['analysis_data']['color6'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] = (($x2 >= 75 ? 5 : ($x2 >= 60 ? 4 : ($x2 >= 40 ? 3 : 1))));
            if ($x2 >= 75 && $x2 <= 100) {
                $data['analysis_data']['color6'] = 'green';
            } elseif ($x2 >= 50 && $x2 <= 74) {
                $data['analysis_data']['color6'] = 'yellow';
            } elseif ($x2 >= 30 && $x2 <= 49) {
                $data['analysis_data']['color6'] = 'grey';
            } elseif ($x2 < 30) {
                $data['analysis_data']['color6'] = 'red';
            }
            //$x4 = ($data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] * 100) / 5;
            //$data['analysis_data']['color6'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] = 0;
            $data['analysis_data']['color6'] = 'red';
        }
        //analysis 8
        $x2 = $data['analysis'][0]->Representation_of_Poorest;
        $data['analysis_data']['Representation_of_Poorest'] = '';
        $data['analysis_data']['color55'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Representation_of_Poorest'] = (($x2 >= 60 ? 5 : ($x2 >= 40 ? 4 : ($x2 >= 25 ? 3 : 1))));
            if ($x2 >= 60) {
                $data['analysis_data']['color55'] = 'green';
            } elseif ($x2 >= 40 && $x2 <= 59) {
                $data['analysis_data']['color55'] = 'yellow';
            } elseif ($x2 >= 25 && $x2 <= 39) {
                $data['analysis_data']['color55'] = 'grey';
            } elseif ($x2 < 25) {
                $data['analysis_data']['color55'] = 'red';
            }
            //$x4 = ($data['analysis_data']['Representation_of_Poorest'] * 100) / 5;
            //$data['analysis_data']['color55'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Representation_of_Poorest'] = 0;
            $data['analysis_data']['color55'] = 'red';
        }
        $data['total2'] = (float)$data['analysis_data']['Coverage_of_target'] + (float)$data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] + (float)$data['analysis_data']['Representation_of_Poorest'];
        $total_in = ($data['total2'] * 100) / 15;
        $data['score1']=$total_in;
        $data['tcolor2'] = $total_in >= 90 ? 'green' : ($total_in >= 75 ? 'yellow' : ($total_in >= 60 ? 'grey' : 'red'));

        //analysis 9
        $count11 = $data['efficiency'][0]->group_prepare;
        
        $data['analysis_data']['group_prepare'] = '';
        $data['analysis_data']['color1111'] = '';
        if ($count11 != '') {
            $data['analysis_data']['group_prepare'] = ($count11 == 'Yes' ? 5 : 0);
            $x4 = ($data['analysis_data']['group_prepare'] * 100) / 5;
            $data['analysis_data']['color1111'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
            
        } else {
            $data['analysis_data']['group_prepare'] = 0;
            $data['analysis_data']['color1111'] = 'red';
        }
        //analysis 11
        $count4 = $data['analysis'][0]->Cluster_is_covering_its;
        
        $data['analysis_data']['Cluster_is_covering_its'] = '';
        $data['analysis_data']['color7'] = '';
        if ($count4 != '') {
            $data['analysis_data']['Cluster_is_covering_its'] = ($count4 == 'Yes' ? 5 : 0);
            if ($count4 == 'Yes') {
                $data['analysis_data']['color7'] = 'green';
            } elseif ($count4 == 'No') {
                $data['analysis_data']['color7'] = 'red';
            }
            //$x4 = ($data['analysis_data']['Cluster_is_covering_its'] * 100) / 5;
            //$data['analysis_data']['color7'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Cluster_is_covering_its'] = 0;
            $data['analysis_data']['color7'] = 'red';
        }
        //analysis 10
        $x2 = (int)$data['analysis'][0]->Time_taken_to_disburse;
        
        $data['analysis_data']['Time_taken_to_disburse'] = '';
        $data['analysis_data']['color8'] = '';
        if ($x2 != '') {
            if ($x2 <= 2) {
                $data['analysis_data']['Time_taken_to_disburse'] = 5;
                $data['analysis_data']['color8'] = 'green';
            } elseif ($x2 > 2 && $x2 <= 3) {
                $data['analysis_data']['Time_taken_to_disburse'] = 4;
                $data['analysis_data']['color8'] = 'yellow';
            } elseif ($x2 > 3 && $x2 <= 5) {
                $data['analysis_data']['Time_taken_to_disburse'] = 3;
                $data['analysis_data']['color8'] = 'grey';
            } elseif ($x2 > 5) {
                $data['analysis_data']['Time_taken_to_disburse'] = 1;
                $data['analysis_data']['color8'] = 'red';
            }
            //$x4 = ($data['analysis_data']['Time_taken_to_disburse'] * 100) / 5;
            //$data['analysis_data']['color8'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Time_taken_to_disburse'] = '--' ;
            $data['analysis_data']['color8'] = 'red';
        }

        $data['total3'] = (float)$data['analysis_data']['Cluster_is_covering_its'] + (float)$data['analysis_data']['Time_taken_to_disburse'] + (float)$data['analysis_data']['group_prepare'];
        $total_ef = ($data['total3'] * 100) / 15;
        $data['score2']=$total_ef;
        $data['tcolor3'] = $total_ef >= 90 ? 'green' : ($total_ef >= 75 ? 'yellow' : ($total_ef >= 60 ? 'grey' : 'red'));

        //analysis 12
        $x2 = (str_replace('%', '', $data['analysis'][0]->Repayment_rate_of_cluster_loan));
        $data['analysis_data']['Repayment_rate_of_cluster_loan'] = '';
        $data['analysis_data']['color9'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Repayment_rate_of_cluster_loan'] = (($x2 >= 95 ? 10 : ($x2 >= 85 ? 7 : ($x2 >= 70 ? 5 : 2))));
            if ($x2 >= 95) {
                $data['analysis_data']['color9'] = 'green';
            } elseif ($x2 >= 80 && $x2 <= 94) {
                $data['analysis_data']['color9'] = 'yellow';
            } elseif ($x2 >= 70 && $x2 <= 79) {
                $data['analysis_data']['color9'] = 'grey';
            } elseif ($x2 < 70) {
                $data['analysis_data']['color9'] = 'red';
            }
            //$x4 = ($data['analysis_data']['Repayment_rate_of_cluster_loan'] * 100) / 10;
            //$data['analysis_data']['color9'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Repayment_rate_of_cluster_loan'] = 0;
            $data['analysis_data']['color9'] = 'red';
        }
        //analysis 13
        $x2 = (str_replace('%', '', $data['analysis'][0]->Cluster_loan_PAR));
        $data['analysis_data']['Cluster_loan_PAR'] = '';
        $data['analysis_data']['color10'] = '';
        if ($x2 != '') {
            if ($x2 == 0) {
                $data['analysis_data']['Cluster_loan_PAR'] = 10;
                $data['analysis_data']['color10'] = 'green';
            }
            if ($x2 >= 1 && $x2 <= 5) {
                $data['analysis_data']['Cluster_loan_PAR'] = 7;
                $data['analysis_data']['color10'] = 'yellow';
            }
            if ($x2 >= 6 && $x2 <= 10) {
                $data['analysis_data']['Cluster_loan_PAR'] = 5;
                $data['analysis_data']['color10'] = 'grey';
            }
            if ($x2 > 10) {
                $data['analysis_data']['Cluster_loan_PAR'] = 2;
                $data['analysis_data']['color10'] = 'red';
            }

        } else {
            $data['analysis_data']['Cluster_loan_PAR'] = 0 ;
            $data['analysis_data']['color10'] = 'red';

        }
        //analysis 14
        $x2 = $data['analysis'][0]->Percentage_members_assisted_more_than_one;
        $data['analysis_data']['Percentage_members_assisted_more_than_one'] = '';
        $data['analysis_data']['color11'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Percentage_members_assisted_more_than_one'] = (($x2 >= 75 ? 5 : ($x2 >= 50 ? 4 : ($x2 >= 25 ? 3 : 1))));
            if ($x2 >= 75) {
                $data['analysis_data']['color11'] = 'green';
            } elseif ($x2 >= 50 && $x2 <= 74) {
                $data['analysis_data']['color11'] = 'yellow';
            } elseif ($x2 >= 25 && $x2 <= 49) {
                $data['analysis_data']['color11'] = 'grey';
            } elseif ($x2 < 25) {
                $data['analysis_data']['color11'] = 'red';
            }
            //$x4 = ($data['analysis_data']['Percentage_members_assisted_more_than_one'] * 100) / 5;
            //$data['analysis_data']['color11'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Percentage_members_assisted_more_than_one'] = 0;
            $data['analysis_data']['color11'] = 'red';
        }
        //analysis 15
        $x2 = $data['analysis'][0]->Percentage_Livelihood_purposes;
        $data['analysis_data']['Percentage_Livelihood_purposes'] = '';
        $data['analysis_data']['color12'] = '';
        if ($x2 != '') {
            $data['analysis_data']['Percentage_Livelihood_purposes'] = (($x2 >= 90 ? 5 : ($x2 >= 75 ? 4 : ($x2 >= 60 ? 3 : 1))));
            if ($x2 >= 90) {
                $data['analysis_data']['color12'] = 'green';
            } elseif ($x2 >= 75 && $x2 <= 89) {
                $data['analysis_data']['color12'] = 'yellow';
            } elseif ($x2 >= 60 && $x2 <= 74) {
                $data['analysis_data']['color12'] = 'grey';
            } elseif ($x2 < 60) {
                $data['analysis_data']['color12'] = 'red';
            }
            //$x4 = ($data['analysis_data']['Percentage_Livelihood_purposes'] * 100) / 5;
            //$data['analysis_data']['color12'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Percentage_Livelihood_purposes'] = 0;
            $data['analysis_data']['color12'] = 'red';
        }
        $data['total4'] = (float)$data['analysis_data']['Repayment_rate_of_cluster_loan'] + (float)$data['analysis_data']['Cluster_loan_PAR'] + (float)$data['analysis_data']['Percentage_members_assisted_more_than_one'] + (float)$data['analysis_data']['Percentage_Livelihood_purposes'];
        $total_cr = ($data['total4'] * 100) / 30;
        $data['score3']=$total_cr;
        $data['tcolor4'] = $total_cr >= 90 ? 'green' : ($total_cr >= 75 ? 'yellow' : ($total_cr >= 60 ? 'grey' : 'red'));

        //analysis 16
        
        $total_member = (int)$data['profile'][0]->total_members ;
        // $voluntary_saving = (int)$data['saving'][0]->voluntary_savings_inception ;
        $data['analysis_data']['Percentage_of_the_cluster'] = '';
        $data['analysis_data']['color111'] = '';
        // if ($total_member > 0) {
        //     $res12 = ($voluntary_saving / $total_member) * 100 ;
        //     $x2 = round($res12, 2);
        // }
        $x2 = $data['analysis'][0]->Percentage_of_the_cluster;
        if ($x2 != '') {
            $data['analysis_data']['Percentage_of_the_cluster'] = (($x2 >= 90 ? 10 : ($x2 >= 75 ? 7 : ($x2 >= 60 ? 4 : 2))));
            //prd($data['analysis_data']['Percentage_of_the_cluster']);
            $x4 = ($data['analysis_data']['Percentage_of_the_cluster'] * 100) / 10;
            $data['analysis_data']['color111'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Percentage_of_the_cluster'] = 0;
            $data['analysis_data']['color111'] = 'red';
        }

        // analysis 17
        $lsf = (int)$data['saving'][0]->members ;
        $data['analysis_data']['compulsory_savings'] = '';
        $data['analysis_data']['color112'] = '';
        $count12 = '';
        if ($total_member > 0) {
            $res12 = ($lsf / $total_member) * 100 ;
            $count12 = round($res12, 2);
        }
        //prd($count12);
        if ($count12 != '') {
            $data['analysis_data']['compulsory_savings'] = (($count12 >= 90 ? 5 : ($count12 >= 75 ? 4 : ($count12 >= 60 ? 3 : 1))));
            $x12 = ($data['analysis_data']['compulsory_savings'] * 100) / 5;
            $data['analysis_data']['color112'] = $x12 >= 90 ? 'green' : ($x12 >= 75 ? 'yellow' : ($x12 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['compulsory_savings'] = 0;
            $data['analysis_data']['color112'] ='red';
        }

        $data['total5'] = (float)$data['analysis_data']['Percentage_of_the_cluster'] + (float)$data['analysis_data']['compulsory_savings'];
        $total_sv = ($data['total5'] * 100) / 30;
        $data['score4']=$total_sv;
        $data['tcolor5'] = $total_sv >= 90 ? 'green' : ($total_sv >= 75 ? 'yellow' : ($total_sv >= 60 ? 'grey' : 'red'));

        $data['grand_total'] = $data['total1'] + $data['total2'] + $data['total3'] + $data['total4'] + $data['total5'];
        $total_grd = ($data['grand_total'] * 100) / 100;
        $data['grdcolor'] = $total_grd >= 90 ? 'green' : ($total_grd >= 75 ? 'yellow' : ($total_grd >= 60 ? 'grey' : 'red'));
        $data['show_final_status'] = $data['grdcolor'] == 'green' ? 'Minimal Risk' : ($data['grdcolor'] == 'yellow' ? ' Low Risk' : ($data['grdcolor'] == 'grey' ? 'Moderate Risk' : 'High Risk'));
        //return view('cluster_details_pdf')->with($data);

        $file_name = $data['profile'][0]->name_of_cluster;
        // view()->share('res', $data);
        // $pdf_doc = PDF::loadView('pdf.cluster_details_pdf', $data)->setPaper('a3', 'landscape');
        // return $pdf_doc->download($file_name.'_'.$cluster->uin.'_'.pdf_date().'.pdf');
        return $data;
    }

    public function exportPDF($cluster_id)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data= $this->mainPDF($cluster_id);
        
        $file_name = $data['profile'][0]->name_of_cluster;
        view()->share('res', $data);
        $pdf_doc = PDF::loadView('pdf.cluster_details_pdf', $data)->setPaper('a3', 'landscape');
        return $pdf_doc->download($file_name.'_'.$data['uin'].'_'.pdf_date().'.pdf');
    }

    public function exportclusterPDF($cluster_id)
    {
        
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data['u_type'] = $user->u_type;
        $data= $this->mainPDF($cluster_id);

        $file_name = $data['profile'][0]->name_of_cluster;
        view()->share('res', $data);
        $pdf_doc = PDF::loadView('pdf.clusterDetailCardPdf', $data)->setPaper('a3', 'landscape');
        return $pdf_doc->download($file_name.'_'.$data['uin'].'_'.pdf_date().'.pdf');
    }
}
