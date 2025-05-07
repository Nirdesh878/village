<?php

namespace App\Http\Controllers;

use App\Models\Federation;
use App\Models\FederationProfile;
use App\Models\FederationSubMst;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\FederationAnalysis;
use App\Models\FederationChallenges;
use App\Models\FederationCredithistory;
use App\Models\FederationEfficiency;
use App\Models\FederationGovernance;
use App\Models\FederationInclusion;
use App\Models\FederationRiskMitigation;
use App\Models\FederationSustainability;
use App\Models\FederationRating;
use App\Models\FederationObservation;
use App\Models\FcsnodeMst;
use PDF;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FederationExport;
use \stdClass;
use App\Rules\NRLMCode;


class FederationController extends Controller
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
        $user = Auth::User();
        // prd($user);
        $user_geo = DB::table('user_location_relation')
            ->where('user_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->orderBy('country_id')
            ->get()->toArray();

        $data = [];
        if ($request->ajax()) {

            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');
            $txt_search = $request->post('search')['value'];
            $query = " SELECT
                    a.*,
                    b.agency_name,
                    c.name AS country_name,
                    d.name AS state_name,
                    e.name AS district_name,
                    f.uin,
                    f.created_at as created,
                    f.id AS ids,
                    f.status,
                    f.srlm_code,
                    s.analytics,
                    s.rating,
                    s.dm_a,
                    s.qa_a,
                    s.dm_r,
                    s.qa_r,
                    s.updated_at,
                    s.locked,
                    s.flag,
                    s.status_flag

                FROM
                    federation_mst AS f
                INNER JOIN federation_sub_mst AS s
                ON
                    s.federation_mst_id = f.id
                INNER JOIN federation_profile AS a
                ON
                    a.federation_sub_mst_id = s.id
                INNER JOIN agency AS b
                ON
                    f.agency_id = b.agency_id
                LEFT JOIN countries AS c
                ON
                    a.name_of_country = c.id
                LEFT JOIN states AS d
                ON
                    a.name_of_state = d.id
                LEFT JOIN district AS e
                ON
                    a.name_of_district = e.id
                WHERE
                    f.is_deleted = 0 ";

            if ($user->u_type == 'M') {
                // $query .= " AND a.created_by = $user->id ";
                $district_list = $user_geo[0]->district_id;

                $state_id = $user_geo[0]->state_id;

                $query .= " AND (CASE WHEN f.created_by > 1 THEN 1 ELSE 0 END = 1 AND f.created_by = $user->id)
                OR
                (CASE WHEN f.created_by < 2 THEN 1 ELSE 0 END = 1 AND (a.district_id IN($district_list)  ))";

            }
            if ($txt_search != '') {
                $query .= " AND (a.name_of_federation like '%$txt_search%' ";
                $query .= " or f.uin like '%$txt_search%' )";
            }
            $federations = DB::select($query);
            $total = count($federations);
            $query .= " ORDER BY
                    s.updated_at
                DESC,f.id DESC
                LIMIT $limit OFFSET $start";
            $federations = DB::select($query);
            // prd($query);
            foreach ($federations as $federation) {
                $visit = 'Created';
                if ($federation->dm_a == 'V' && $federation->qa_a == 'V' && $federation->locked == 1) {
                    $visit = 'Locked';
                } elseif ($federation->dm_a == 'V' && $federation->qa_a == 'V') {
                    $visit = 'Initial Rating';
                } elseif ($federation->dm_a == 'V' && $federation->qa_a == 'P') {
                    $visit = 'Analytics Complete';
                } elseif ($federation->dm_a == 'P') {
                    $visit = 'Visit Complete';
                } elseif ($federation->dm_a == 'N' && $federation->flag == 0) {
                    $visit = 'Visit Pending';
                } elseif ($federation->dm_a == 'R' && $federation->flag == 1) {
                    $visit = 'Visit Reassigned';
                }

                $row = [];
                $row[] = ++$start;
                $row[] = $federation->uin;
                $row[] = $federation->name_of_federation;
                $row[] = $visit;
                $row[] = change_date_month_name_char($federation->created);
                $row[] = change_date_month_name_char($federation->updated_at);
                $row[] = $federation->locked == 1 ? 'Yes' : 'No';

                $row[] = $federation->status == 'A' ? '<span class="status-active">Active</span>' : '<span class="status-inactive">InActive</span>';

                $btns = '';
                if($user->u_type !='M'){
                    $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('federation.edit', $federation->ids) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                    $btns .= '<a class="btn btn-success btn-link btn-sm" rel="tooltip" title="View" data-original-title="View" href="' . route('federation.show', $federation->ids) . '" style="padding:0px;margin-left:5px"><i class="c-white-500 ti-eye"></i></a>';
                    $btns .= '<a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $federation->ids . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';
                }
                elseif($user->u_type =='M'){
                    
                    if($federation->status_flag == 1  ){
                        $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit"  style="padding:0px;margin:0px;opacity: 0.3;"><i class="c-white-500 ti-pencil"></i></a>';

                        $btns .= '<a class="btn btn-success btn-link btn-sm" rel="tooltip" title="View" data-original-title="View"  style="padding:0px;margin-left:5px;opacity: 0.3;"><i class="c-white-500 ti-eye"></i></a>';

                        $btns .= '<a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove"  style="padding:0px;margin:0px;opacity: 0.3;"><i class="c-white-500 ti-trash"></i></a>';
                    

                    }
                    else{
                        
                        $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('federation.edit', $federation->ids) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                        $btns .= '<a class="btn btn-success btn-link btn-sm" rel="tooltip" title="View" data-original-title="View" href="' . route('federation.show', $federation->ids) . '" style="padding:0px;margin-left:5px"><i class="c-white-500 ti-eye"></i></a>';
                        $btns .= '<a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $federation->ids . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';

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
        return view('federation.list')->with($data);
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
        return view('federation.add')->with($data);
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
            // prd($request->all());
            try {
                $validation_arr = [
                    'agency_id' => ['required'],
                    'name_of_federation' => ['required'],
                    'date_federation_was_found' => ['required'],
                    //'srlm_code' => ['required'],
                    'country' => ['required'],
                    'state' => ['required'],
                    'district' => ['required'],

                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request) {

                    $temp_rand = '';

                    $user = Auth::User();
                    $federation_name = $request->post('name_of_federation');
                    $federation_formed = $request->post('date_federation_was_found');
                    $contact_name = $request->post('contact_name');
                    $web_email = $request->post('web_email');
                    $web_mobile = $request->post('web_mobile');
                    $block = $request->post('block');
                    if (count($federation_name) > 0) {
                        foreach ($federation_name as $key => $value) {
                            $federation_mst = new Federation();

                            $temp_rand = $request->post('agency_id');
                            $federation_mst->agency_id = $temp_rand;
                            $federation_mst->status = 'A';
                            $federation_mst->tkn = substr(md5(mt_rand()), 0, 16);
                            $federation_mst->srlm_code = $request->post('srlm_code');
                            //uin
                            $country_code = strtoupper(getCountryCodeByID($request->post('country')));
                            $state_code = strtoupper(getStateCodeByID($request->post('state')));
                            $district_code = strtoupper(substr(getName('district', 'name', $request->post('district')), 0, 2));
                            $uin = checkAndGenerateUIN($country_code, $state_code, $district_code, 'federation_mst', 'FD');
                            //prd($uin);
                            $federation_mst->uin = $uin;

                            $federation_mst->created_by = $user->id;

                            $result = $federation_mst->save();

                            $FederationProfile = new FederationProfile();
                            // prd( $web_mobile[$key]);
                            $FederationProfile = array(
                                'name_of_federation' => $value,
                                'country_id' => $request->post('country'),
                                'state_id' => $request->post('state'),
                                'district_id' => $request->post('district'),
                                'name_of_country' => getName('countries', 'name', $request->post('country')),
                                'name_of_state' => getName('states', 'name', $request->post('state')),
                                'name_of_district' => getName('district', 'name', $request->post('district')),
                                'date_federation_was_found' => $federation_formed[$key],
                                'web_mobile' => $web_mobile[$key],
                                'web_email' => $web_email[$key],
                                'contact_name' => $contact_name[$key],
                                'block' => $block[$key],

                            );

                            $result = $this->Submaster($federation_mst->id, $uin, $temp_rand, $FederationProfile);
                        }
                        if ($result) {
                            return true;
                        }
                    }
                });
                if ($result) {
                    return redirect('federation')->with(['message' => 'Federation saved successfully.']);
                }
            } catch (\Exception $e) {
                prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }
        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        return view('federation.list')->with($data);
    }
    public function federation_table(Request $request)
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
            z.name_of_federation,
            X.id,
            z.created_at,
            Y.uin
                FROM
                    federation_mst AS Y
                INNER JOIN federation_sub_mst AS X
                ON
                    Y.id = X.federation_mst_id
                INNER JOIN federation_profile AS z
                ON
                    X.id = z.federation_sub_mst_id

                WHERE
                    Y.is_deleted = 0 ";
            if ($user->u_type == 'M') {
                $query .= "AND Y.created_by = $user->id";
            }

            $federations = DB::select($query);
            $total = count($federations);
            $query .= " ORDER BY
                    z.created_at
                DESC
                LIMIT $limit OFFSET $start";
            $federations = DB::select($query);
            foreach ($federations as $federation) {

                $row = [];
                $row[] = ++$start;

                $row[] = $federation->name_of_federation;
                $row[] = $federation->uin;

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

        return view('federation.add')->with($data);
    }
    public function federation_table_second(Request $request)
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

            $agency = $request->post('agency_id');
            $country = $request->post('country');
            $state = $request->post('state');
            $district = $request->post('district');
            $agency = $request->post('agency_id');
            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');

            $query = " SELECT
            z.name_of_federation,
            X.id,
            Y.uin
                FROM
                    federation_mst AS Y
                INNER JOIN federation_sub_mst AS X
                ON
                    Y.id = X.federation_mst_id
                INNER JOIN federation_profile AS z
                ON
                    X.id = z.federation_sub_mst_id

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
            }
            $federations = DB::select($query);
            $total = count($federations);

            foreach ($federations as $federation) {

                $row = [];
                $row['sn'] = ++$start;

                $row['federation_name'] = $federation->name_of_federation;
                $row['uin'] = $federation->uin;

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

        return view('federation.add')->with($data);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Federation  $federation
     * @return \Illuminate\Http\Response
     */
    public function show(Federation $federation, Request $request)
    {

        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        //prd($user);

        $data['federation_ids'] = $federation->id;
        $data['u_type'] = $user->u_type;
        $data['agency_id'] = $federation->agency_id;
        $data['dm_id'] = $user->id;
        $data['quality_check'] = ($request->get('task_id') == NULL) ? 0 : 1;
        //prd($data['quality_check']);
        $t_q_a = DB::table('task_qa_assignment as y')
            ->select('y.*')
            ->where('y.assignment_id', '=', $federation->id)
            ->where('y.assignment_type', '=', 'FD')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()->toArray();
        //prd($t_q_a);
        $data['task_id'] = $request->get('task_id') ?? ($t_q_a[0]->id) ?? NULL;
        $data['user_id'] = $request->get('user_id') ?? ($t_q_a[0]->user_id) ?? NULL;
        $data['qa_status'] = $t_q_a[0]->qa_status ?? NULL;
        $data['qa_remark'] = $t_q_a[0]->remark ?? NULL;
        $data['manager_date'] = $t_q_a[0]->manger_date ?? NULL;
        $data['quality_status'] = $t_q_a[0]->quality_status ?? NULL;
        $data['quality_remark'] = $t_q_a[0]->quality_remark ?? NULL;
        $data['quality_date'] = $t_q_a[0]->quality_date ?? NULL;
        $data['qa_readonly'] = ($data['qa_status'] == 'R' || $data['qa_status'] == 'V') ? 'readonly' : '';
        $data['qa_readonly1'] = ($data['quality_status'] == 'R' || $data['quality_status'] == 'V') ? 'readonly' : '';
        //prd($data['manager_date']);
        $data['agency'] = DB::table('agency as a')
            ->select('a.agency_name')
            ->where('is_deleted', '=', 0)
            ->where('a.agency_id', '=', $federation->agency_id)
            ->get()->toArray();
        $query = "Select id,qa_status from federation_sub_mst where federation_mst_id=$federation->id";
        $result = DB::select($query);
        //prd($result);
        $data['manager_status'] = $result[0]->qa_status;
        //prd($data['manager_status']);
        $data['profile'] = DB::table('federation_profile as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $data['photos'] = DB::table('federation_upload_photos_videos as a')
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['profile_bank'] = json_decode($data['profile'][0]->Federation_Bank_ac);

        $data['governance'] = DB::table('federation_governance as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        // prd($data['governance'][0]->Defunct_SHGs);
        $data['governance_6'] = json_decode($data['governance'][0]->Federation_Commit_Governance_Training_object);
        $data['governance_7'] = json_decode($data['governance'][0]->Federation_SAC_Governance_Training_object);
        $data['governance_8'] = json_decode($data['governance'][0]->Federation_BOOK_Governance_Training_object);
        //prd($data['governance_7']);

        $data['inclusion'] = DB::table('federation_inclusion as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['efficiency'] = DB::table('federation_efficiency as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['credithistory'] = DB::table('federation_credithistory as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $data['repayment_ration'] = 0;
        $data['sustainability'] = DB::table('federation_sustainability as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $data['sustainability_service'] = json_decode($data['sustainability'][0]->Federation_Sustainability_Service);
        //prd($data['sustainability_service']);
        $data['risk_mitigation'] = DB::table('federation_risk_mitigation as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['analysis'] = DB::table('federation_analysis as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        //prd($data['analysis']);
        $data['observation'] = DB::table('federation_observation as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
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

        $data['challenges'] = DB::table('federation_challenges as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        //prd($data['challenges']);
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
                        $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_action_completed != '' ? change_date_month_name_char(str_replace('/', '-', $temp[0]->sa_action_completed)) : 'N/A';
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

        //prd($data['challenges_action']);

        $ID = $result[0]->id;

        //analysis 1
        $count = 0;
        $data['show1'] = '';
        $data['analysis_1'] = '';
        if (($data['governance'][0]->last_two_election_conducted) == 'Yes')
            $count += 1;
        if (($data['governance'][0]->last_two_election_conducted_2nd) == 'Yes')
            $count += 1;
        if (($data['governance'][0]->last_two_election_conducted_3rd) == 'Yes')
            $count += 1;
        // prd($count);
        if ($count != 0) {
            $data['analysis_1'] = $count == 3 ? 4 : ($count == 2 ? 3 : ($count == 1 ? 1 : 0));

            // $x1 = ($data['analysis_1'] * 100) / 4;
            $data['show1'] = $count == 3 ? 'green' : ($count == 2 ? 'yellow' : ($count == 1 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_1'] = 0;

            $x1 = ($data['analysis_1'] * 100) / 4;
            $data['show1'] = $x1 >= 90 ? 'green' : ($x1 >= 75 ? 'yellow' : ($x1 >= 60 ? 'grey' : 'red_status'));
        }


        //analysis 2
        $count1 = '';
        $data['show2'] = '';
        $data['analysis_2'] = '';
        $average = $data['analysis'][0]->average_metting_attendance;

        if ($average != '') {
            $count1 = (($average >= 90 ? 5 : ($average >= 75 ? 4 : ($average >= 60 ? 3 : 1))));
            $data['analysis_2'] = $count1;
            if ($average >= 100) {
                $data['show2'] = 'green';
            } elseif ($average >= 80 && $average <= 99) {
                $data['show2'] = 'yellow';
            } elseif ($average >= 60 && $average <= 79) {
                $data['show2'] = 'grey';
            } elseif ($average < 59) {
                $data['show2'] = 'red_status';
            }
            //$x2 = ((int)$data['analysis_2'] * 100) / 5;
            //$data['show2'] = $x2 >= 90 ? 'green' : ($x2 >= 75 ? 'yellow' : ($x2 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_2'] = 0;
            $data['show2'] = 'red_status';
        }


        //analysis 3
        $count3 = $data['analysis'][0]->federation_book_updation;

        $data['analysis_3'] = '';
        $data['show3'] = '';
        if ($count3 != '') {
            $data['analysis_3'] = $count3 == 'Fully updated' ? 5 : ($count3 == 'Partially updated' ? 3 : ($count == 'Book not updated' ? 1 : 0));
            if ($count3 == 'Fully updated') {
                $data['show3'] = 'green';
            } elseif ($count3 == 'Partially updated') {
                $data['show3'] = 'yellow';
            } elseif ($count3 == 'Books not updated') {
                $data['show3'] = 'red_status';
            }

            //$x3 = ($data['analysis_3'] * 100) / 5;
            //$data['show3'] = $x3 >= 90 ? 'green' : ($x3 >= 75 ? 'yellow' : ($x3 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_3'] = 0;
            $data['show3'] = 'red_status';
        }

        //analysis 4
        $count4 = $data['analysis'][0]->federation_annual_plan_and_budget_approval;
        $data['analysis_4'] = '';
        $data['show4'] = '';

        if ($count4 != '') {
            $data['analysis_4'] = $count4 == 'Yes' ? 3 : 0;
            if ($count4 == 'Yes') {
                $data['show4'] = 'green';
            } elseif ($count4 == 'No') {
                $data['show4'] = 'red_status';
            }
            //$x4 = ($data['analysis_4'] * 100) / 3;
            //$data['show4'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_4'] = 0;
            $data['show4'] = 'red_status';
        }


        //analysis 5

        $count5 = '';
        $data['analysis_5'] = '';
        $data['show5'] = '';
        $average_result = (int)$data['analysis'][0]->achievement_last_year_annual_plan;

        if ($average_result != '') {
            $average1 = $average_result * 20;
            $count5 = (($average1 > 60 ? 2 : ($average1 >= 50 ? 1 : 0)));

            $data['analysis_5'] = $count5;
            // $x5 = ($data['analysis_5'] * 100) / 2;
            // $data['show5'] = $x5 >= 90 ? 'green' : ($x5 >= 75 ? 'yellow' : ($x5 >= 60 ? 'grey' : 'red_status'));
            if ($average_result > 3) {
                $data['show5'] = 'green';
            } else if ($average_result >= 2 && $average_result <= 3) {
                $data['show5'] = 'yellow';
            } else if ($average_result == 1) {
                $data['show5'] = 'grey';
            } else if ($average_result == 0) {
                $data['show5'] = 'red_status';
            }
        } else {
            $data['analysis_5'] = '--';
            $data['show5'] = '';
        }

        //analysis 6 grade_federation_obtained_during_last_1_year
        $result = $data['analysis'][0]->grade_federation_obtained_during_last_1_year;
        $data['analysis_6'] = '';
        $data['show6'] = '';

        if ($result != '') {
            $data['analysis_6'] = $result == 'A' ? 3 : ($result == 'B' ? 2 : ($result == 'C' ? 1 : 0));
            $x6 = ($data['analysis_6'] * 100) / 3;
            if ($result == 'A') {
                $data['show6'] = 'green';
            }
            if ($result == 'B') {
                $data['show6'] = 'yellow';
            }
            if ($result == 'C') {
                $data['show6'] = 'grey';
            }
            if ($result == 'D') {
                $data['show6'] = 'red_status';
            }
            //$data['show6'] = $x6>=90 ? 'green' :($x6>=75 ? 'yellow' :($x6>=60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_6'] = 0;
            $data['show6'] = 'red_status';
        }

        //analysis 7
        $data['analysis_7'] = '';
        $data['show7'] = '';

        $nine_b = $data['profile'][0]->shg_at_time_creation;
        $ten_b  = $data['profile'][0]->total_SHGs;

        if ($nine_b != 0 || $nine_b > 0) {
            $diff = round((($nine_b - $ten_b) / $nine_b) * 100);
            //prd($diff);
            if (($ten_b >= $nine_b) || ($diff <= 5)) {
                $data['analysis_7'] = 3;
                $data['show7'] = 'green';
            } elseif ($diff >= 6 &&  $diff <= 10) {
                $data['analysis_7'] = 2;
                $data['show7'] = 'yellow';
            } elseif ($diff >= 11 && $diff <= 20) {
                $data['analysis_7'] = 1;
                $data['show7'] = 'grey';
            } else {
                $data['analysis_7'] = 0;
                $data['show7'] = 'red_status';
            }
        } else {
            $data['analysis_7'] = '--';
        }

        //analysis 8
        $result8 = $data['analysis'][0]->last_year_audit_completed;
        $data['analysis_8'] = '';
        $data['show8'] = '';
        // prd($result8);
        if ($result8 != '') {
            $data['analysis_8'] = $result8 == 'Yes' ? 5 : 0;
            if ($result8 == 'Yes') {
                $data['show8'] = 'green';
            } elseif ($result8 == 'No') {
                $data['show8'] = 'red_status';
            }
            //$x8 = ($data['analysis_8'] * 100) / 5;
            //$data['show8'] = $x8 >= 90 ? 'green' : ($x8 >= 75 ? 'yellow' : ($x8 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_8'] = 0;
            $data['show8'] = 'red_status';
        }

        $data['total_1to8'] = (float)$data['analysis_1'] + (float)$data['analysis_2'] + (float)$data['analysis_3'] + (float)$data['analysis_4'] + (float)$data['analysis_5'] + (float)$data['analysis_6'] + (float)$data['analysis_7'] + (float)$data['analysis_8'];
        $x1to8 = ($data['total_1to8'] * 100) / 30;
        $data['score'] = $x1to8;
        $data['show_1to8'] = $x1to8 >= 90 ? 'green' : ($x1to8 >= 75 ? 'yellow' : ($x1to8 >= 60 ? 'grey' : 'red_status'));
        $count9 = 0;

        //analysis 9
        $result9 = (float)$data['analysis'][0]->coverage_of_target_mobilization;
        $data['analysis_9'] = '';
        $data['show9'] = '';
        if ($result9 != 0) {
            $data['analysis_9'] = ($result9 >= 80 ? 5 : ($result9 >= 60 ? 4 : ($result9 >= 40 ? 3 : 1)));
            if ($result9 >= 80 && $result9 <= 100) {
                $data['show9'] = 'green';
            } elseif ($result9 >= 60 && $result9 <= 79) {
                $data['show9'] = 'yellow';
            } elseif ($result9 >= 40 && $result9 <= 59) {
                $data['show9'] = 'grey';
            } elseif ($result9 < 40) {
                $data['show9'] = 'red_status';
            }
            // $x9 = ($data['analysis_9'] * 100) / 5;
            //$data['show9'] = ($result9 >= 80 ? 'green' : ($result9 >= 60 ? 'yellow' : ($result9 >= 40 ? 'grey' : 'red_status')));
        } else {
            $data['analysis_9'] = 0;
            $data['show9'] = 'red_status';
        }


        //analysis10
        $result10 = (float)$data['analysis'][0]->per_of_poorest_families_benefiting;
        $data['analysis_10'] = '';
        $data['show10'] = '';

        if ($result10 != '') {
            $data['analysis_10'] = $result10 > 75 ? 5 : ($result10 > 60 ? 4 : ($result10 > 30 ? 3 :  0));
            //$x10 = ($data['analysis_10'] * 100) / 5;
            //$data['show10'] = $x10 >= 90 ? 'green' : ($x10 >= 75 ? 'yellow' : ($x10 >= 60 ? 'grey' : 'red_status'));
            if ($result10 >= 75 && $result10 <= 100) {
                $data['show10'] = 'green';
            } elseif ($result10 >= 50 && $result10 <= 74) {
                $data['show10'] = 'yellow';
            } elseif ($result10 >= 30 && $result10 <= 49) {
                $data['show10'] = 'grey';
            } elseif ($result10 < 30) {
                $data['show10'] = 'red_status';
            }
        } else {
            $data['analysis_10'] = 0;
            $data['show10'] = 'red_status';
        }
        //analysis 11
        $result11 = (float)$data['analysis'][0]->poorest_category_board_members;
        $data['analysis_11'] = '';
        $data['show11'] = '';

        if ($result11 != 0) {
            $data['analysis_11'] = ($result11 >= 60 ? 5 : ($result11 >= 40 ? 4 : ($result11 >= 25 ? 3 : 1)));
            if ($result11 > 60) {
                $data['show11'] = 'green';
            } elseif ($result11 >= 40 && $result11 <= 59) {
                $data['show11'] = 'yellow';
            } elseif ($result11 >= 25 && $result11 <= 39) {
                $data['show11'] = 'grey';
            } elseif ($result11 < 25) {
                $data['show11'] = 'red_status';
            }

            //$x11 = ($data['analysis_11'] * 100) / 5;
            //$data['show11'] = $x11 >= 90 ? 'green' : ($x11 >= 75 ? 'yellow' : ($x11 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_11'] = 0;
            $data['show11'] = 'red_status';
        }

        //total 9 to 11
        $data['total_9to11'] = (float)$data['analysis_9'] + (float)$data['analysis_10'] + (float)$data['analysis_11'];
        $x9to11 = ($data['total_9to11'] * 100) / 15;
        $data['score1'] = $x9to11;
        $data['show_9to11'] = $x9to11 >= 90 ? 'green' : ($x9to11 >= 75 ? 'yellow' : ($x9to11 >= 60 ? 'grey' : 'red_status'));

        //analysis 12
        $result12 = $data['analysis'][0]->time_taken_to_approve_loan;
        $data['analysis_12'] = '';
        $data['show12'] = '';

        if ($result12 != '') {
            $data['analysis_12'] = $result12 <= 5 ? 5 : ($result12 <= 10 ? 4 : ($result12 <= 15 ? 3 : 1));
            if ($result12 <= 5) {
                $data['show12'] = 'green';
            } elseif ($result12 >= 6 && $result12 <= 10) {
                $data['show12'] = 'yellow';
            } elseif ($result12 >= 11 && $result12 <= 15) {
                $data['show12'] = 'grey';
            } elseif ($result12 > 15) {
                $data['show12'] = 'red_status';
            }
            //$x12 = ($data['analysis_12'] * 100) / 5;
            //$data['show12'] = $x12 >= 90 ? 'green' : ($x12 >= 75 ? 'yellow' : ($x12 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_12'] = 0;
            $data['show12'] = 'red_status';
        }

        //analysis 13
        $count13 = '';
        $result13 = $data['analysis'][0]->cost_per_active_client;
        $data['analysis_13'] = '';
        $data['show13'] = '';
        if ($result13 != '') {
            $count13 = ($result13 < 5 ? 5 : ($result13 <= 7 ? 4 : ($result13 <= 10 ? 3 : ($result13 > 10 ? 1 : 0))));
            $data['analysis_13'] = $count13;
            if ($result13 < 5) {
                $data['show13'] = 'green';
            } elseif ($result13 >= 5 && $result13 <= 7) {
                $data['show13'] = 'yellow';
            } elseif ($result13 >= 8 && $result13 <= 10) {
                $data['show13'] = 'grey';
            } elseif ($result13 > 10) {
                $data['show13'] = 'red_status';
            }
            //$x13 = ($data['analysis_13'] * 100) / 5;
            //$data['show13'] = $x13 >= 90 ? 'green' : ($x13 >= 75 ? 'yellow' : ($x13 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_13'] = '--';
            $data['show13'] = '--';
        }


        //analysis 14
        $count14 = '';
        $result14 = $data['analysis'][0]->operating_expense_ratio;
        $data['analysis_14'] = '';
        $data['show14'] = '';

        if ($result14 != '') {
            $count14 = ($result14 < 5 ? 5 : ($result14 <= 10 ? 4 : ($result14 <= 15 ? 3 : ($result14 > 15 ? 1 : 0))));
            $data['analysis_14'] = $count14;
            if ($result14 <= 5) {
                $data['show14'] = 'green';
            } elseif ($result14 >= 6 && $result14 <= 10) {
                $data['show14'] = 'yellow';
            } elseif ($result14 >= 11 && $result14 <= 15) {
                $data['show14'] = 'grey';
            } elseif ($result14 > 15) {
                $data['show14'] = 'red_status';
            }
            //$x14 = ($data['analysis_14'] * 100) / 5;
            //$data['show14'] = $x14 >= 90 ? 'green' : ($x14 >= 75 ? 'yellow' : ($x14 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_14'] = 0;
            $data['show14'] = 'red_status';
        }

        //total 12 to 14
        $data['total_12to14'] = (float)$data['analysis_12'] + (float)$data['analysis_13'] + (float)$data['analysis_14'];
        $x12to14 = ($data['total_12to14'] * 100) / 15;
        $data['score2'] = $x12to14;
        $data['show_12to14'] = $x12to14 >= 90 ? 'green' : ($x12to14 >= 75 ? 'yellow' : ($x12to14 >= 60 ? 'grey' : 'red_status'));

        //analysis 15
        $result15 = $data['analysis'][0]->per_of_members_benefited_from_federation;
        $data['analysis_15'] = '';
        $data['show15'] = '';

        if ($result15 != '') {
            $data['analysis_15'] = $result15 > 80 ? 5 : ($result15 > 60 ? 4 : ($result15 > 50 ? 3 :  1));
            if ($result15 >= 80 && $result15 <= 100) {
                $data['show15'] = 'green';
            } elseif ($result15 >= 60 && $result15 <= 79) {
                $data['show15'] = 'yellow';
            } elseif ($result15 >= 50 && $result15 <= 59) {
                $data['show15'] = 'grey';
            } elseif ($result15 < 50) {
                $data['show15'] = 'red_status';
            }
            //$x15 = ($data['analysis_15'] * 100) / 5;
            //$data['show15'] = $result15 > 80 ? 'green' : ($result15 > 60 ? 'yellow' : ($result15 > 50 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_15'] = 0;
            $data['show15'] = 'red_status';
        }

        //analysis 16
        $result16 = (float)(str_replace('%', '', $data['analysis'][0]->repayment_rate_of_federation_loan));
        $data['analysis_16'] = '';
        $data['show16'] = '';

        if ($result16 != 0) {
            $data['analysis_16'] = $result16 >= 95 ? 5 : ($result16 >= 80 ? 4 : ($result16 >= 70 ? 3 :  1));
            if ($result16 >= 95) {
                $data['show16'] = 'green';
            } elseif ($result16 >= 80 && $result16 <= 94) {
                $data['show16'] = 'yellow';
            } elseif ($result16 >= 70 && $result16 <= 79) {
                $data['show16'] = 'grey';
            } elseif ($result16 < 70) {
                $data['show16'] = 'red_status';
            }
            //$x16 = ($data['analysis_16'] * 100) / 5;
            //$data['show16'] = $x16 >= 90 ? 'green' : ($x16 >= 75 ? 'yellow' : ($x16 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_16'] = 0;
            $data['show16'] = 'red_status';
        }

        //analysis 17
        $result17 = (float)(str_replace('%', '', $data['analysis'][0]->repayment_of_Bank_loan_by_the_federation));
        $data['analysis_17'] = '';
        $data['show17'] = '';

        if ($result17 != 0) {
            $data['analysis_17'] = $result17 > 95 ? 5 : ($result17 >= 80 ? 4 : ($result17 > 70 ? 3 :  1));
            if ($result17 >= 95) {
                $data['show17'] = 'green';
            } elseif ($result17 >= 80 && $result17 <= 94) {
                $data['show17'] = 'yellow';
            } elseif ($result17 >= 70 && $result17 <= 79) {
                $data['show17'] = 'grey';
            } elseif ($result17 < 70) {
                $data['show17'] = 'red_status';
            }
            //$x17 = ($data['analysis_17'] * 100) / 5;
            //$data['show17'] = $x17 >= 90 ? 'green' : ($x17 >= 75 ? 'yellow' : ($x17 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_17'] = '--';
        }

        //analysis 18
        $result18 = (float)$data['analysis'][0]->federation_loan_PAR_90;
        $data['analysis_18'] = '';
        $data['show18'] = '';

        if ($result18 != '') {
            if ($result18 < 1) {
                $data['analysis_18'] = 5;
                $data['show18'] = 'green';
            }
            if ($result18 >= 1 && $result18 <= 5) {
                $data['analysis_18'] = 3;
                $data['show18'] = 'yellow';
            }
            if ($result18 > 5 && $result18 <= 10) {
                $data['analysis_18'] = 1;
                $data['show18'] = 'grey';
            }
            if ($result18 > 10) {
                $data['analysis_18'] = 1;
                $data['show18'] = 'red_status';
            }
            //$data['analysis_18'] = $result18 < 1 ? 5 : ($result18 < 5 ? 3 : ($result18 < 10 ? 1 :  0));
            // $x18 = ($data['analysis_18'] * 100) / 5;
            // $data['show18'] = $x18 >= 90 ? 'green' : ($x18 >= 75 ? 'yellow' : ($x18 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_18'] = 0;
            $data['show18'] = 'red_status';
        }


        //analysis 19
        $result19 = (float)$data['analysis'][0]->livelihood_purposes_of_all_loans;
        $data['analysis_19'] = '';
        $data['show19'] = '';
        if ($result19 != 0) {
            $data['analysis_19'] = ($result19 >= 90 ? 3 : ($result19 >= 75 ? 2 : ($result19 >= 60 ? 1 :  0)));
            if ($result19 >= 90) {
                $data['show19'] = 'green';
            } elseif ($result19 >= 75 && $result19 <= 89) {
                $data['show19'] = 'yellow';
            } elseif ($result19 >= 60 && $result19 <= 74) {
                $data['show19'] = 'grey';
            } elseif ($result19 < 60) {
                $data['show19'] = 'red_status';
            }
            //$x191 = ($data['analysis_19'] * 100) / 3;
            //$x19 = round($x191, 2);
            //$data['show19'] = $x19 >= 90 ? 'green' : ($x19 >= 75 ? 'yellow' : ($x19 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_19'] = 0;
            $data['show19'] = 'red_status';
        }
        //analysis 20
        $count20 = '';
        $result20 = (float)$data['analysis'][0]->rotation_of_funds;
        $data['analysis_20'] = '';
        $data['show20'] = '';
        if ($result20 != '') {
            $data['analysis_20'] = ($result20 > 0.7) ? 2 : ((($result20 >= 0.5) && ($result20 <= 0.7)) ? 1 : 0);
            if ($result20 >= 0.7) {
                $data['show20'] = 'green';
            } elseif ($result20 >= 0.5 && $result20 <= 0.69) {
                $data['show20'] = 'yellow';
            } elseif ($result20 >= 0.4 && $result20 <= 0.59) {
                $data['show20'] = 'grey';
            } elseif ($result20 < 0.4) {
                $data['show20'] = 'red_status';
            }
            //$x20 = ($data['analysis_20'] * 100) / 2;
            //$data['show20'] = $x20 >= 90 ? 'green' : ($x20 >= 75 ? 'yellow' : ($x20 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_20'] = 0;
            $data['show20'] = 'red_status';
        }


        //total 15 to 20
        $data['total_15to20'] = (float)$data['analysis_15'] + (float)$data['analysis_16'] + (float)$data['analysis_17'] + (float)$data['analysis_18'] + (float)$data['analysis_19'] + (float)$data['analysis_20'];
        $x15to20 = ($data['total_15to20'] * 100) / 25;
        $data['score3'] = $x15to20;
        $data['show_15to20'] = $x15to20 >= 90 ? 'green' : ($x15to20 >= 75 ? 'yellow' : ($x15to20 >= 60 ? 'grey' : 'red_status'));

        //analysis 21
        $result21 = $data['analysis'][0]->does_federation_cover_own_income;
        $data['analysis_21'] = '';
        $data['show21'] = '';
        if ($result21 != '') {
            $data['analysis_21'] = $result21 == 'Yes' ? 3 : 0;
            if ($result21 == "Yes") {
                $data['show21'] = 'green';
            } elseif ($result21 == "No") {
                $data['show21'] = 'red_status';
            }
            //$x21 = ($data['analysis_21'] * 100) / 3;
            //$data['show21'] = $x21 >= 90 ? 'green' : ($x21 >= 75 ? 'yellow' : ($x21 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_21'] =  0;
            $data['show21'] = 'red_status';
        }

        //analysis 22
        $result22 = $data['analysis'][0]->loan_security_fund_established;
        $data['analysis_22'] = '';
        $data['show22'] = '';

        if ($result22 != '') {
            $data['analysis_22'] = $result22 == 'Yes' ? 3 : 0;
            if ($result22 == "Yes") {
                $data['show22'] = 'green';
            } elseif ($result22 == "No") {
                $data['show22'] = 'red_status';
            }
            //$x22 = ($data['analysis_22'] * 100) / 3;
            //$data['show22'] = $x22 >= 90 ? 'green' : ($x22 >= 75 ? 'yellow' : ($x22 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_22'] =  0;
            $data['show22'] = 'red_status';
        }
        //total 21 to 22
        $data['total_21to22'] = (float)$data['analysis_21'] + (float)$data['analysis_22'];
        $x21to22 = ($data['total_21to22'] * 100) / 6;
        $data['score4'] = $x21to22;
        $data['show_21to22'] = $x21to22 >= 90 ? 'green' : ($x21to22 >= 75 ? 'yellow' : ($x21to22 >= 60 ? 'grey' : 'red_status'));

        //analysis 23
        $count23 = '';
        $result23 = (float)(str_replace('%', '', $data['analysis'][0]->members_covered_under_life_insurance));
        $data['analysis_23'] = '';
        $data['show23'] = '';
        if ($result23 != 0) {
            $count23 = ($result23 >= 90 ? 3 : ($result23 >= 75 ? 2 : ($result23 >= 60 ? 1 :  0)));
            $data['analysis_23'] = $count23;
            if ($result23 >= 90) {
                $data['show23'] = 'green';
            } elseif ($result23 >= 75 && $result23 <= 89) {
                $data['show23'] = 'yellow';
            } elseif ($result23 >= 60 && $result23 <= 74) {
                $data['show23'] = 'grey';
            } elseif ($result23 < 60) {
                $data['show23'] = 'red_status';
            }
            //$x23 = ($data['analysis_23'] * 100) / 3;
            //$data['show23'] = $x23 >= 90 ? 'green' : ($x23 >= 75 ? 'yellow' : ($x23 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_23'] = 0;
            $data['show23'] = 'red_status';
        }

        //analysis 24
        $count24 = '';
        $result24 = (float)(str_replace('%', '', $data['analysis'][0]->availed_members_covered_loan_insurance));
        $data['analysis_24'] = '';
        $data['show24'] = '';
        if ($result24 != 0) {
            $count24 = $result24 >= 90 ? 3 : ($result24 >= 75 ? 2 : ($result24 >= 60 ? 1 :  0));
            $data['analysis_24'] = $count24;
            if ($result24 >= 90) {
                $data['show24'] = 'green';
            } elseif ($result24 >= 75 && $result24 <= 89) {
                $data['show24'] = 'yellow';
            } elseif ($result24 >= 60 && $result24 <= 74) {
                $data['show24'] = 'grey';
            } elseif ($result24 < 60) {
                $data['show24'] = 'red_status';
            }
            //$x24 = ($data['analysis_24'] * 100) / 3;
            //$data['show24'] = $x24 >= 90 ? 'green' : ($x24 >= 75 ? 'yellow' : ($x24 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_24'] = 0;
            $data['show24'] = 'red_status';
        }

        //analysis 25
        $count25 = '';
        $result25 = (float)(str_replace('%', '', $data['analysis'][0]->animals_insured_purchased));
        $data['analysis_25'] = '';
        $data['show25'] = '';
        if ($result25 != 0) {
            $count25 = $result25 >= 90 ? 3 : ($result25 >= 75 ? 2 : ($result25 >= 60 ? 1 :  0));
            $data['analysis_25'] = $count25;
            if ($result25 >= 90) {
                $data['show25'] = 'green';
            } elseif ($result25 >= 75 && $result25 <= 89) {
                $data['show25'] = 'yellow';
            } elseif ($result25 >= 60 && $result25 <= 74) {
                $data['show25'] = 'grey';
            } elseif ($result25 < 60) {
                $data['show25'] = 'red_status';
            }
            //$x25 = ($data['analysis_25'] * 100) / 3;
            //$data['show25'] = $x25 >= 90 ? 'green' : ($x25 >= 75 ? 'yellow' : ($x25 >= 60 ? 'grey' : 'red_status'));
        } else {
            $data['analysis_25'] = 0;
            $data['show25'] = 'red_status';
        }
        //total 23 to 25
        $data['total_23to25'] = (float)$data['analysis_23'] + (float)$data['analysis_24'] + (float)$data['analysis_25'];
        $x23to25 = ($data['total_23to25'] * 100) / 9;
        $data['score5'] = $x23to25;
        $data['show_23to25'] = $x23to25 >= 90 ? 'green' : ($x23to25 >= 75 ? 'yellow' : ($x23to25 >= 60 ? 'grey' : 'red_status'));

        $data['analysis_final_total'] =  $data['total_23to25'] + $data['total_21to22'] + $data['total_15to20'] + $data['total_12to14'] + $data['total_9to11'] + $data['total_1to8'];
        $xfinal = ($data['analysis_final_total'] * 100) / 100;
        $data['show_final_total'] = $xfinal >= 90 ? 'green' : ($xfinal >= 75 ? 'yellow' : ($xfinal >= 60 ? 'grey' : 'red_status'));
        $data['show_final_status'] = $data['show_final_total'] == 'green' ? 'Minimal Risk' : ($data['show_final_total'] == 'yellow' ? ' Low Risk' : ($data['show_final_total'] == 'grey' ? 'Moderate Risk' : 'High Risk'));

        $query = "SELECT
        a.*,
        b.name ,
        c.name_of_federation
        FROM
            `federation_remarks` AS a
        LEFT JOIN users AS b
        ON
            a.user_id = b.id
        LEFT JOIN federation_profile AS c
        ON
            a.fed_id = c.federation_sub_mst_id
        WHERE
            a.fed_id = $ID
            ORDER BY a.updated_at DESC
            ";
       $data['remarks'] = DB::select($query);
        //prd($data);
        // $exportedPDF = $this->exportPDF($data);
        return view('federation.view', compact('federation'))->with($data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Federation  $federation
     * @return \Illuminate\Http\Response
     */
    public function edit(Federation $federation)
    {
        // prd($federation->id);
        $data['federation_profile'] = DB::table('federation_profile as p')
            ->select('p.*', 's.id', 'f.id', 'p.id as profile_id')
            ->where('f.is_deleted', '=', 0)
            ->join('federation_sub_mst as s', 'p.federation_sub_mst_id', '=', 's.id')
            ->join('federation_mst as f', 's.federation_mst_id', '=', 'f.id')
            ->where('s.federation_mst_id', '=', $federation->id)
            ->get()->toArray();
        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        $data['edit'] = 1;
        //prd($data);
        return view('federation.edit', compact('federation'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Federation  $federation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Federation $federation)
    {
        $view = 'federation.edit';

        /* Check post either add or update */
        if ($request->isMethod('PATCH')) {
            try {
                $validation_arr = [
                    'agency_id' => ['required'],
                    'name_of_federation' => ['required'],
                    'country' => ['required'],
                    'state' => ['required'],
                    'date_federation_was_found' => ['required'],
                    'status' => ['required'],
                    'district' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request, $federation) {


                    $user = Auth::User();
                    //prd($user);
                    if ($request->post('id') > 0) {

                        $federation_mst = Federation::find($request->post('id'));
                        $federation_mst->srlm_code = $request->post('srlm_code');
                        $federation_mst->status = $request->post('status');
                        $federation_mst->updated_by = $user->id;
                    } else {

                        return redirect('federation')->with(['message' => 'Federation id does not exist.']);
                        exit();
                    }

                    $result = $federation_mst->save();
                    //prd($federation_mst->id);
                    if ($federation_mst->id > 0) {
                        $profile_id = $request->post('profile_id');
                        $user_details = FederationProfile::find($profile_id);
                        $user_details->name_of_federation = $request->post('name_of_federation');
                        $user_details->country_id = $request->post('country');
                        $user_details->state_id = $request->post('state');
                        $user_details->district_id = $request->post('district');
                        $user_details->name_of_country = getName('countries', 'name', $request->post('country'));
                        $user_details->name_of_state = getName('states', 'name', $request->post('state'));
                        $user_details->name_of_district = getName('district', 'name', $request->post('district'));
                        $user_details->date_federation_was_found = $request->post('date_federation_was_found') ?? NULL;
                        $user_details->registration_no = $request->post('registration_no');
                        $user_details->web_email = ($request->post('email'));
                        $user_details->web_mobile = ($request->post('mobile'));
                        $user_details->block = ($request->post('block'));
                        $user_details->contact_name = ($request->post('contact_name'));
                        $user_details->clusters_at_time_creation = $request->post('clusters_at_time_creation') ?? 0;
                        $user_details->shg_at_time_creation = $request->post('shg_at_time_creation') ?? 0;
                        $user_details->members_at_time_creation = $request->post('members_at_time_creation') ?? 0;
                        $user_details->total_clusters = $request->post('total_clusters') ?? 0;
                        $user_details->total_SHGs = $request->post('total_SHGs');
                        $user_details->total_members = $request->post('total_members') ?? 0;
                        $user_details->president = $request->post('president');
                        $user_details->secretary = $request->post('secretary');
                        $user_details->Treasurer = $request->post('Treasurer');
                        $user_details->book_keeper_name = $request->post('book_keeper_name');
                        $user_details->updated_by = $user->id;
                        $user_details->updated_at = date('Y-m-d H:i:s');
                        $result = $user_details->save();
                    }

                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('federation')->with(['message' => 'Federation updated successfully.']);
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
     * @param  \App\Models\Federation  $federation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Federation $federation)
    {

        $query = "SELECT count(*) as count FROM cluster_mst WHERE federation_uin = '$federation->uin' AND is_deleted = 0";
        $cluster_count = DB::select($query)[0]->count;
        $query = "SELECT count(*) as count FROM shg_mst WHERE federation_uin = '$federation->uin' AND is_deleted = 0";
        $shg_count = DB::select($query)[0]->count;


        try {
            if ($cluster_count == 0 && $shg_count == 0) {
                if ($federation->id != '') {
                    $user_details = Federation::find($federation->id);
                    $user_details->is_deleted = 1;
                    $user_details->save();

                    $data['message'] = 'Federation Deleted Successfully';
                    echo json_encode($data);
                } else {
                    $data['message'] = 'Invalid Request';
                    echo json_encode($data);
                }
            } else {
                $data['message'] = "Total number of Cluster $cluster_count and SHG $shg_count  created under this Federation . Please delete these Cluster and SHG first";
                echo json_encode($data);
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }
    public function submaster($federation_mst_id, $nuincd, $agency_id, $FederationProfile)
    {
        //Manage relation of eaech
        $modelnw = new FcsnodeMst();
        $modelnw->uin = $nuincd;
        $modelnw->pid = 0;
        $modelnw->type = 'F';
        $modelnw->agency_id = $agency_id;
        $modelnw->tkn = substr(md5(mt_rand()), 0, 16);
        $modelnw->created_at = date('Y-m-d H:i:s');
        $modelnw->save();


        $modeln = new FederationSubMst();
        $modeln->federation_mst_id = $federation_mst_id;
        $modeln->created_at = date('Y-m-d H:i:s');
        $modeln->save();
        $federation_sub_mst_id = $modeln->id;


        $model_profile = new FederationProfile();
        $model_profile->federation_sub_mst_id = $federation_sub_mst_id;
        $model_profile->name_of_federation = (trim($FederationProfile['name_of_federation']));
        $model_profile->name_of_district = (trim($FederationProfile['name_of_district']));
        $model_profile->name_of_state = (trim($FederationProfile['name_of_state']));
        $model_profile->name_of_country = (trim($FederationProfile['name_of_country']));
        $model_profile->district_id = (trim($FederationProfile['district_id']));
        $model_profile->state_id = (trim($FederationProfile['state_id']));
        $model_profile->country_id = (trim($FederationProfile['country_id']));
        $model_profile->date_federation_was_found = (trim($FederationProfile['date_federation_was_found'])) ?? NULL;
        $model_profile->web_email = trim($FederationProfile['web_email']);
        $model_profile->web_mobile = trim($FederationProfile['web_mobile']);
        $model_profile->contact_name = trim($FederationProfile['contact_name']);
        $model_profile->block = trim($FederationProfile['block']);
        // $model_profile->registration_no = (trim($FederationProfile['registration_no']));
        // $model_profile->clusters_at_time_creation = (trim($FederationProfile['clusters_at_time_creation']));
        // $model_profile->shg_at_time_creation = (trim($FederationProfile['shg_at_time_creation']));
        // $model_profile->members_at_time_creation = (trim($FederationProfile['members_at_time_creation']));
        // $model_profile->total_clusters = (trim($FederationProfile['total_clusters']));
        // $model_profile->total_SHGs = (trim($FederationProfile['total_SHGs']));
        // $model_profile->total_members = (trim($FederationProfile['total_members']));
        // $model_profile->president = (trim($FederationProfile['president']));
        // $model_profile->secretary = (trim($FederationProfile['secretary']));
        // $model_profile->Treasurer = (trim($FederationProfile['Treasurer']));
        // $model_profile->book_keeper_name = (trim($FederationProfile['book_keeper_name']));
        $model_profile->created_at = date('Y-m-d H:i:s');
        $model_profile->save();


        $model_analysis = new FederationAnalysis();
        $model_analysis->federation_sub_mst_id = $federation_sub_mst_id;
        $model_analysis->created_at = date('Y-m-d H:i:s');
        $model_analysis->save();

        $model_challenges = new FederationChallenges();
        $model_challenges->federation_sub_mst_id = $federation_sub_mst_id;
        $model_challenges->created_at = date('Y-m-d H:i:s');
        $model_challenges->save();

        $model_credithistory = new FederationCredithistory();
        $model_credithistory->federation_sub_mst_id = $federation_sub_mst_id;
        $model_credithistory->created_at = date('Y-m-d H:i:s');
        $model_credithistory->save();

        $model_efficiency = new FederationEfficiency();
        $model_efficiency->federation_sub_mst_id = $federation_sub_mst_id;
        $model_efficiency->created_at = date('Y-m-d H:i:s');
        $model_efficiency->save();

        $model_governance = new FederationGovernance();
        $model_governance->federation_sub_mst_id = $federation_sub_mst_id;
        $model_governance->created_at = date('Y-m-d H:i:s');
        $model_governance->save();

        $model_inclusion = new FederationInclusion();
        $model_inclusion->federation_sub_mst_id = $federation_sub_mst_id;
        $model_inclusion->created_at = date('Y-m-d H:i:s');
        $model_inclusion->save();

        $model_riskMitigation = new FederationRiskMitigation();
        $model_riskMitigation->federation_sub_mst_id = $federation_sub_mst_id;
        $model_riskMitigation->created_at = date('Y-m-d H:i:s');
        $model_riskMitigation->save();

        $model_sustainability = new FederationSustainability();
        $model_sustainability->federation_sub_mst_id = $federation_sub_mst_id;
        $model_sustainability->created_at = date('Y-m-d H:i:s');
        $model_sustainability->save();

        $model_rating = new FederationRating();
        $model_rating->federation_sub_mst_id = $federation_sub_mst_id;
        $model_rating->created_at = date('Y-m-d H:i:s');
        $model_rating->rating = json_encode(array());
        $model_rating->save();

        $model_observation = new FederationObservation();
        $model_observation->federation_sub_mst_id = $federation_sub_mst_id;
        $model_observation->created_at = date('Y-m-d H:i:s');
        $model_observation->save();
        return true;
    }
    public function export_federationCardPDF($federation_id)
    {

        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data = $this->mainPDF($federation_id);



        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.federationcardPdf', $data)->setPaper('a4', 'landscape');
        //prd($result);
        return $pdf_doc->download('Federation_Rating_Card_' . $data['uin'] . '_' . pdf_date() . '.pdf');
    }

    public function export(Request $request)
    {

        return Excel::download(new FederationExport(), 'FederationExport_' . pdf_date() . '.xlsx');
    }

    public function federationPDF(Request $request)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $query = "SELECT
        *
    FROM
        (
        SELECT
            a.*,
            b.agency_name,
            c.name AS country_name,
            d.name AS state_name,
            e.name AS district_name,
            f.uin,
            f.id AS ids,
            f.status,
            f.srlm_code,
            s.analytics,
            s.rating,
            s.dm_a,
            s.qa_a,
            s.dm_r,
            s.qa_r,
            s.flag,
            s.updated_at as updated,
            s.locked
        FROM
            federation_mst AS f
        INNER JOIN federation_sub_mst AS s
        ON
            s.federation_mst_id = f.id
        INNER JOIN federation_profile AS a
        ON
            a.federation_sub_mst_id = s.id
        INNER JOIN agency AS b
        ON
            f.agency_id = b.agency_id
        LEFT JOIN countries AS c
        ON
            a.country_id = c.id
        LEFT JOIN states AS d
        ON
            a.state_id = d.id
        LEFT JOIN district AS e
        ON
            a.district_id = e.id
        WHERE
            f.is_deleted = 0 ";
        if ($user->u_type == 'M') {
            $query .= "AND f.created_by = $user->id and (s.dm_a = 'P' OR s.dm_a = '' OR s.dm_r = 'P' OR s.dm_r = '')";
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
                assignment_type = 'FD'
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
        // prd($query);
        $data = DB::select($query);
        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.federationPdf', $data)->setPaper('a3', 'landscape');
        return $pdf_doc->download('Federation_PDF_' . pdf_date() . '.pdf');
    }


    public function federationDetailsCardPdf($federation_id)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data = $this->mainPDF($federation_id);
        $file_name = $data['profile'][0]->name_of_federation;
        view()->share('res', $data);
        $pdf_doc = PDF::loadView('pdf.federationDetailsCardPdf', $data)->setPaper('a3', 'landscape');
        return $pdf_doc->download($file_name . '_' . $data['uin'] . '_' . pdf_date() . '.pdf');
    }


    public function exportPDF($federation_id)
    {
        // prd("hhh");
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();

        $data = $this->mainPDF($federation_id);
        $file_name = $data['profile'][0]->name_of_federation;
        view()->share('res', $data);
        $pdf_doc = PDF::loadView('pdf.federationDetailsPdf', $data)->setPaper('a3', 'landscape');
        return $pdf_doc->download($file_name . '_' . $data['uin'] . '_' . pdf_date() . '.pdf');
    }
    public function mainPDF($federation_id)
    {


        $data['pre_url'] = (url()->previous());
        $user = Auth::user();

        $federation = Federation::find($federation_id);
        $data['uin'] = $federation->uin;

        $data['federation'] = $federation;
        $data['federation_ids'] = $federation->id;

        $data['u_type'] = $user->u_type;
        $data['agency_id'] = $federation->agency_id;
        // $data['quality_check']=($request->get('task_id')==NULL) ? 0 : 1;
        $data['quality_check'] = 1;
        //prd($data['quality_check']);
        $t_q_a = DB::table('task_qa_assignment as y')
            ->select('y.*')
            ->where('y.assignment_id', '=', $federation->id)
            ->where('y.assignment_type', '=', 'FD')
            ->get()->toArray();
        //prd($t_q_a);
        // $data['task_id']=$request->get('task_id') ?? ($t_q_a[0]->id) ?? NULL;
        $data['task_id'] = NULL;
        // $data['user_id']=$request->get('user_id') ?? ($t_q_a[0]->user_id) ?? NULL;
        $data['user_id'] = NULL;
        $data['qa_status'] = $t_q_a[0]->qa_status ?? NULL;
        $data['qa_remark'] = $t_q_a[0]->remark ?? NULL;
        $data['qa_readonly'] = ($data['qa_status'] == 'R' || $data['qa_status'] == 'V') ? 'readonly' : '';
        //prd($data['qa_remark']);
        $data['agency'] = DB::table('agency as a')
            ->select('a.agency_name')
            ->where('is_deleted', '=', 0)
            ->where('a.agency_id', '=', $federation->agency_id)
            ->get()->toArray();
        $query = "Select id from federation_sub_mst where federation_mst_id=$federation->id";
        $result = DB::select($query);

        $data['profile'] = DB::table('federation_profile as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['profile_bank'] = json_decode($data['profile'][0]->Federation_Bank_ac);

        $data['governance'] = DB::table('federation_governance as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        // prd($data['governance']);
        $data['governance_6'] = json_decode($data['governance'][0]->Federation_Commit_Governance_Training_object);
        $data['governance_7'] = json_decode($data['governance'][0]->Federation_SAC_Governance_Training_object);
        $data['governance_8'] = json_decode($data['governance'][0]->Federation_BOOK_Governance_Training_object);
        //prd($data['governance_7']);

        $data['inclusion'] = DB::table('federation_inclusion as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['efficiency'] = DB::table('federation_efficiency as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['credithistory'] = DB::table('federation_credithistory as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $data['repayment_ration'] = 0;
        $data['sustainability'] = DB::table('federation_sustainability as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $data['sustainability_service'] = json_decode($data['sustainability'][0]->Federation_Sustainability_Service);
        //prd($data['sustainability_service']);
        $data['risk_mitigation'] = DB::table('federation_risk_mitigation as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['analysis'] = DB::table('federation_analysis as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        //prd($data['analysis']);
        $data['observation'] = DB::table('federation_observation as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
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
    
            $data['challenges'] = DB::table('federation_challenges as a')
                ->where('is_deleted', '=', 0)
                ->where('a.federation_sub_mst_id', '=', $result[0]->id)
                ->get()->toArray();
    
            foreach ($challenge_type as $key1 => $val) {
                $data['challenges_action'][$key1]['name'] = $val;
                foreach ($data['challenges'] as $key => $val1) {
                    $temp = json_decode($val1->action);
                    if (!empty($temp)) {
                        if ($key1 == 0) {
                            $data['challenges_action'][$key1]['ch_actions'][$key] = $temp[0]->sa_action_completed != '' ? change_date_month_name_char(str_replace('/', '-', $temp[0]->sa_action_completed)) : 'N/A';
                            $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_describe_action;
                            continue;
                        }
                        // if ($key1 == 1) {
                        //     $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_responsible;
                        //     continue;
                        // }
                        // if ($key1 == 2) {
                        //     $data['challenges_action'][$key1]['action'][$key] = $temp[0]->sa_action_completed != '' ? change_date_month_name_char(str_replace('/', '-', $temp[0]->sa_action_completed)) : 'N/A';
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


        //analysis 1
        $count = 0;
        $data['show1'] = '';
        $data['analysis_1'] = '';
        if (($data['governance'][0]->last_two_election_conducted) == 'Yes')
            $count += 1;
        if (($data['governance'][0]->last_two_election_conducted_2nd) == 'Yes')
            $count += 1;
        if (($data['governance'][0]->last_two_election_conducted_3rd) == 'Yes')
            $count += 1;
        // prd($count);
        if ($count != 0) {
            $data['analysis_1'] = $count == 3 ? 4 : ($count == 2 ? 3 : ($count == 1 ? 1 : 0));

            // $x1 = ($data['analysis_1'] * 100) / 4;
            $data['show1'] = $count == 3 ? 'green' : ($count == 2 ? 'yellow' : ($count == 1 ? 'grey' : 'red'));
        } else {
            $data['analysis_1'] = 0;

            $x1 = ($data['analysis_1'] * 100) / 4;
            $data['show1'] = $x1 >= 90 ? 'green' : ($x1 >= 75 ? 'yellow' : ($x1 >= 60 ? 'grey' : 'red'));
        }


        //analysis 2
        $count1 = '';
        $data['show2'] = '';
        $data['analysis_2'] = '';
        $average = $data['analysis'][0]->average_metting_attendance;

        if ($average != '') {
            $count1 = (($average >= 90 ? 5 : ($average >= 75 ? 4 : ($average >= 60 ? 3 : 1))));
            $data['analysis_2'] = $count1;
            if ($average >= 100) {
                $data['show2'] = 'green';
            } elseif ($average >= 80 && $average <= 99) {
                $data['show2'] = 'yellow';
            } elseif ($average >= 60 && $average <= 79) {
                $data['show2'] = 'grey';
            } elseif ($average < 59) {
                $data['show2'] = 'red';
            }
            //$x2 = ((int)$data['analysis_2'] * 100) / 5;
            //$data['show2'] = $x2 >= 90 ? 'green' : ($x2 >= 75 ? 'yellow' : ($x2 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_2'] = 0;
            $data['show2'] = 'red';
        }


        //analysis 3
        $count3 = $data['analysis'][0]->federation_book_updation;

        $data['analysis_3'] = '';
        $data['show3'] = '';
        if ($count3 != '') {
            $data['analysis_3'] = $count3 == 'Fully updated' ? 5 : ($count3 == 'Partially updated' ? 3 : ($count == 'Book not updated' ? 1 : 0));
            if ($count3 == 'Fully updated') {
                $data['show3'] = 'green';
            } elseif ($count3 == 'Partially updated') {
                $data['show3'] = 'yellow';
            } elseif ($count3 == 'Books not updated') {
                $data['show3'] = 'red';
            }

            //$x3 = ($data['analysis_3'] * 100) / 5;
            //$data['show3'] = $x3 >= 90 ? 'green' : ($x3 >= 75 ? 'yellow' : ($x3 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_3'] = 0;
            $data['show3'] = 'red';
        }

        //analysis 4
        $count4 = $data['analysis'][0]->federation_annual_plan_and_budget_approval;
        $data['analysis_4'] = '';
        $data['show4'] = '';

        if ($count4 != '') {
            $data['analysis_4'] = $count4 == 'Yes' ? 3 : 0;
            if ($count4 == 'Yes') {
                $data['show4'] = 'green';
            } elseif ($count4 == 'No') {
                $data['show4'] = 'red';
            }
            //$x4 = ($data['analysis_4'] * 100) / 3;
            //$data['show4'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_4'] = 0;
            $data['show4'] = 'red';
        }


        //analysis 5

        $count5 = '';
        $data['analysis_5'] = '';
        $data['show5'] = '';
        $average_result = (int)$data['analysis'][0]->achievement_last_year_annual_plan;

        if ($average_result != '') {
            $average1 = $average_result * 20;
            $count5 = (($average1 > 60 ? 2 : ($average1 >= 50 ? 1 : 0)));

            $data['analysis_5'] = $count5;
            // $x5 = ($data['analysis_5'] * 100) / 2;
            // $data['show5'] = $x5 >= 90 ? 'green' : ($x5 >= 75 ? 'yellow' : ($x5 >= 60 ? 'grey' : 'red'));
            if ($average_result > 3) {
                $data['show5'] = 'green';
            } else if ($average_result >= 2 && $average_result <= 3) {
                $data['show5'] = 'yellow';
            } else if ($average_result == 1) {
                $data['show5'] = 'grey';
            } else if ($average_result == 0) {
                $data['show5'] = 'red';
            }
        } else {
            $data['analysis_5'] = '--';
            $data['show5'] = '';
        }

        //analysis 6 grade_federation_obtained_during_last_1_year
        $result = $data['analysis'][0]->grade_federation_obtained_during_last_1_year;
        $data['analysis_6'] = '';
        $data['show6'] = '';

        if ($result != '') {
            $data['analysis_6'] = $result == 'A' ? 3 : ($result == 'B' ? 2 : ($result == 'C' ? 1 : 0));
            $x6 = ($data['analysis_6'] * 100) / 3;
            if ($result == 'A') {
                $data['show6'] = 'green';
            }
            if ($result == 'B') {
                $data['show6'] = 'yellow';
            }
            if ($result == 'C') {
                $data['show6'] = 'grey';
            }
            if ($result == 'D') {
                $data['show6'] = 'red';
            }
            //$data['show6'] = $x6>=90 ? 'green' :($x6>=75 ? 'yellow' :($x6>=60 ? 'grey' : 'red'));
        } else {
            $data['analysis_6'] = 0;
            $data['show6'] = 'red';
        }

        //analysis 7
        $data['analysis_7'] = '';
        $data['show7'] = '';

        $nine_b = $data['profile'][0]->shg_at_time_creation;
        $ten_b  = $data['profile'][0]->total_SHGs;
        if ($nine_b > 0 || $nine_b > 0) {
            $diff = round((($nine_b - $ten_b) / $nine_b) * 100);
            //prd($diff);
            if (($ten_b >= $nine_b) || ($diff <= 5)) {
                $data['analysis_7'] = 3;
                $data['show7'] = 'green';
            } elseif ($diff >= 6 &&  $diff <= 10) {
                $data['analysis_7'] = 2;
                $data['show7'] = 'yellow';
            } elseif ($diff >= 11 && $diff <= 20) {
                $data['analysis_7'] = 1;
                $data['show7'] = 'grey';
            } else {
                $data['analysis_7'] = 0;
                $data['show7'] = 'red';
            }
        } else {
            $data['analysis_7'] = '--';
        }


        //analysis 8
        $result8 = $data['analysis'][0]->last_year_audit_completed;
        $data['analysis_8'] = '';
        $data['show8'] = '';
        // prd($result8);
        if ($result8 != '') {
            $data['analysis_8'] = $result8 == 'Yes' ? 5 : 0;
            if ($result8 == 'Yes') {
                $data['show8'] = 'green';
            } elseif ($result8 == 'No') {
                $data['show8'] = 'red';
            }
            //$x8 = ($data['analysis_8'] * 100) / 5;
            //$data['show8'] = $x8 >= 90 ? 'green' : ($x8 >= 75 ? 'yellow' : ($x8 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_8'] = 0;
            $data['show8'] = 'red';
        }

        $data['total_1to8'] = (float)$data['analysis_1'] + (float)$data['analysis_2'] + (float)$data['analysis_3'] + (float)$data['analysis_4'] + (float)$data['analysis_5'] + (float)$data['analysis_6'] + (float)$data['analysis_7'] + (float)$data['analysis_8'];
        $x1to8 = ($data['total_1to8'] * 100) / 30;
        $data['score'] = $x1to8;
        $data['show_1to8'] = $x1to8 >= 90 ? 'green' : ($x1to8 >= 75 ? 'yellow' : ($x1to8 >= 60 ? 'grey' : 'red'));
        $count9 = 0;

        //analysis 9
        $result9 = (float)$data['analysis'][0]->coverage_of_target_mobilization;
        $data['analysis_9'] = '';
        $data['show9'] = '';
        if ($result9 != 0) {
            $data['analysis_9'] = ($result9 >= 80 ? 5 : ($result9 >= 60 ? 4 : ($result9 >= 40 ? 3 : 1)));
            if ($result9 >= 80 && $result9 <= 100) {
                $data['show9'] = 'green';
            } elseif ($result9 >= 60 && $result9 <= 79) {
                $data['show9'] = 'yellow';
            } elseif ($result9 >= 40 && $result9 <= 59) {
                $data['show9'] = 'grey';
            } elseif ($result9 < 40) {
                $data['show9'] = 'red';
            }
            // $x9 = ($data['analysis_9'] * 100) / 5;
            //$data['show9'] = ($result9 >= 80 ? 'green' : ($result9 >= 60 ? 'yellow' : ($result9 >= 40 ? 'grey' : 'red')));
        } else {
            $data['analysis_9'] = 0;
            $data['show9'] = 'red';
        }


        //analysis10
        $result10 = (float)$data['analysis'][0]->per_of_poorest_families_benefiting;
        $data['analysis_10'] = '';
        $data['show10'] = '';

        if ($result10 != '') {
            $data['analysis_10'] = $result10 > 75 ? 5 : ($result10 > 60 ? 4 : ($result10 > 30 ? 3 :  0));
            //$x10 = ($data['analysis_10'] * 100) / 5;
            //$data['show10'] = $x10 >= 90 ? 'green' : ($x10 >= 75 ? 'yellow' : ($x10 >= 60 ? 'grey' : 'red'));
            if ($result10 >= 75 && $result10 <= 100) {
                $data['show10'] = 'green';
            } elseif ($result10 >= 50 && $result10 <= 74) {
                $data['show10'] = 'yellow';
            } elseif ($result10 >= 30 && $result10 <= 49) {
                $data['show10'] = 'grey';
            } elseif ($result10 < 30) {
                $data['show10'] = 'red';
            }
        } else {
            $data['analysis_10'] = 0;
            $data['show10'] = 'red';
        }
        //analysis 11
        $result11 = (float)$data['analysis'][0]->poorest_category_board_members;
        $data['analysis_11'] = '';
        $data['show11'] = '';

        if ($result11 != 0) {
            $data['analysis_11'] = ($result11 >= 60 ? 5 : ($result11 >= 40 ? 4 : ($result11 >= 25 ? 3 : 1)));
            if ($result11 > 60) {
                $data['show11'] = 'green';
            } elseif ($result11 >= 40 && $result11 <= 59) {
                $data['show11'] = 'yellow';
            } elseif ($result11 >= 25 && $result11 <= 39) {
                $data['show11'] = 'grey';
            } elseif ($result11 < 25) {
                $data['show11'] = 'red';
            }

            //$x11 = ($data['analysis_11'] * 100) / 5;
            //$data['show11'] = $x11 >= 90 ? 'green' : ($x11 >= 75 ? 'yellow' : ($x11 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_11'] = 0;
            $data['show11'] = 'red';
        }

        //total 9 to 11
        $data['total_9to11'] = (float)$data['analysis_9'] + (float)$data['analysis_10'] + (float)$data['analysis_11'];
        $x9to11 = ($data['total_9to11'] * 100) / 15;
        $data['score1'] = $x9to11;
        $data['show_9to11'] = $x9to11 >= 90 ? 'green' : ($x9to11 >= 75 ? 'yellow' : ($x9to11 >= 60 ? 'grey' : 'red'));

        //analysis 12
        $result12 = $data['analysis'][0]->time_taken_to_approve_loan;
        $data['analysis_12'] = '';
        $data['show12'] = '';

        if ($result12 != '') {
            $data['analysis_12'] = $result12 <= 5 ? 5 : ($result12 <= 10 ? 4 : ($result12 <= 15 ? 3 : 1));
            if ($result12 <= 5) {
                $data['show12'] = 'green';
            } elseif ($result12 >= 6 && $result12 <= 10) {
                $data['show12'] = 'yellow';
            } elseif ($result12 >= 11 && $result12 <= 15) {
                $data['show12'] = 'grey';
            } elseif ($result12 > 15) {
                $data['show12'] = 'red';
            }
            //$x12 = ($data['analysis_12'] * 100) / 5;
            //$data['show12'] = $x12 >= 90 ? 'green' : ($x12 >= 75 ? 'yellow' : ($x12 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_12'] = 0;
            $data['show12'] = 'red';
        }

        //analysis 13
        $count13 = '';
        $result13 = $data['analysis'][0]->cost_per_active_client;
        $data['analysis_13'] = '';
        $data['show13'] = '';
        if ($result13 != '') {
            $count13 = ($result13 < 5 ? 5 : ($result13 <= 7 ? 4 : ($result13 <= 10 ? 3 : ($result13 > 10 ? 1 : 0))));
            $data['analysis_13'] = $count13;
            if ($result13 < 5) {
                $data['show13'] = 'green';
            } elseif ($result13 >= 5 && $result13 <= 7) {
                $data['show13'] = 'yellow';
            } elseif ($result13 >= 8 && $result13 <= 10) {
                $data['show13'] = 'grey';
            } elseif ($result13 > 10) {
                $data['show13'] = 'red';
            }
            //$x13 = ($data['analysis_13'] * 100) / 5;
            //$data['show13'] = $x13 >= 90 ? 'green' : ($x13 >= 75 ? 'yellow' : ($x13 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_13'] = '--';
            $data['show13'] = '--';
        }


        //analysis 14
        $count14 = '';
        $result14 = $data['analysis'][0]->operating_expense_ratio;
        $data['analysis_14'] = '';
        $data['show14'] = '';

        if ($result14 != '') {
            $count14 = ($result14 < 5 ? 5 : ($result14 <= 10 ? 4 : ($result14 <= 15 ? 3 : ($result14 > 15 ? 1 : 0))));
            $data['analysis_14'] = $count14;
            if ($result14 <= 5) {
                $data['show14'] = 'green';
            } elseif ($result14 >= 6 && $result14 <= 10) {
                $data['show14'] = 'yellow';
            } elseif ($result14 >= 11 && $result14 <= 15) {
                $data['show14'] = 'grey';
            } elseif ($result14 > 15) {
                $data['show14'] = 'red';
            }
            //$x14 = ($data['analysis_14'] * 100) / 5;
            //$data['show14'] = $x14 >= 90 ? 'green' : ($x14 >= 75 ? 'yellow' : ($x14 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_14'] = 0;
            $data['show14'] = 'red';
        }

        //total 12 to 14
        $data['total_12to14'] = (float)$data['analysis_12'] + (float)$data['analysis_13'] + (float)$data['analysis_14'];
        $x12to14 = ($data['total_12to14'] * 100) / 15;
        $data['score2'] = $x12to14;
        $data['show_12to14'] = $x12to14 >= 90 ? 'green' : ($x12to14 >= 75 ? 'yellow' : ($x12to14 >= 60 ? 'grey' : 'red'));

        //analysis 15
        $result15 = $data['analysis'][0]->per_of_members_benefited_from_federation;
        $data['analysis_15'] = '';
        $data['show15'] = '';

        if ($result15 != '') {
            $data['analysis_15'] = $result15 > 80 ? 5 : ($result15 > 60 ? 4 : ($result15 > 50 ? 3 :  1));
            if ($result15 >= 80 && $result15 <= 100) {
                $data['show15'] = 'green';
            } elseif ($result15 >= 60 && $result15 <= 79) {
                $data['show15'] = 'yellow';
            } elseif ($result15 >= 50 && $result15 <= 59) {
                $data['show15'] = 'grey';
            } elseif ($result15 < 50) {
                $data['show15'] = 'red';
            }
            //$x15 = ($data['analysis_15'] * 100) / 5;
            //$data['show15'] = $result15 > 80 ? 'green' : ($result15 > 60 ? 'yellow' : ($result15 > 50 ? 'grey' : 'red'));
        } else {
            $data['analysis_15'] = 0;
            $data['show15'] = 'red';
        }

        //analysis 16
        $result16 = (float)(str_replace('%', '', $data['analysis'][0]->repayment_rate_of_federation_loan));
        $data['analysis_16'] = '';
        $data['show16'] = '';

        if ($result16 != 0) {
            $data['analysis_16'] = $result16 >= 95 ? 5 : ($result16 >= 80 ? 4 : ($result16 >= 70 ? 3 :  1));
            if ($result16 >= 95) {
                $data['show16'] = 'green';
            } elseif ($result16 >= 80 && $result16 <= 94) {
                $data['show16'] = 'yellow';
            } elseif ($result16 >= 70 && $result16 <= 79) {
                $data['show16'] = 'grey';
            } elseif ($result16 < 70) {
                $data['show16'] = 'red';
            }
            //$x16 = ($data['analysis_16'] * 100) / 5;
            //$data['show16'] = $x16 >= 90 ? 'green' : ($x16 >= 75 ? 'yellow' : ($x16 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_16'] = 0;
            $data['show16'] = 'red';
        }

        //analysis 17
        $result17 = (float)(str_replace('%', '', $data['analysis'][0]->repayment_of_Bank_loan_by_the_federation));
        $data['analysis_17'] = '';
        $data['show17'] = '';

        if ($result17 != 0) {
            $data['analysis_17'] = $result17 > 95 ? 5 : ($result17 >= 80 ? 4 : ($result17 > 70 ? 3 :  1));
            if ($result17 >= 95) {
                $data['show17'] = 'green';
            } elseif ($result17 >= 80 && $result17 <= 94) {
                $data['show17'] = 'yellow';
            } elseif ($result17 >= 70 && $result17 <= 79) {
                $data['show17'] = 'grey';
            } elseif ($result17 < 70) {
                $data['show17'] = 'red';
            }
            //$x17 = ($data['analysis_17'] * 100) / 5;
            //$data['show17'] = $x17 >= 90 ? 'green' : ($x17 >= 75 ? 'yellow' : ($x17 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_17'] = '--';
        }

        //analysis 18
        $result18 = (float)$data['analysis'][0]->federation_loan_PAR_90;
        $data['analysis_18'] = '';
        $data['show18'] = '';

        if ($result18 != '') {
            if ($result18 < 1) {
                $data['analysis_18'] = 5;
                $data['show18'] = 'green';
            }
            if ($result18 >= 1 && $result18 <= 5) {
                $data['analysis_18'] = 3;
                $data['show18'] = 'yellow';
            }
            if ($result18 > 5 && $result18 <= 10) {
                $data['analysis_18'] = 1;
                $data['show18'] = 'grey';
            }
            if ($result18 > 10) {
                $data['analysis_18'] = 1;
                $data['show18'] = 'red';
            }
            //$data['analysis_18'] = $result18 < 1 ? 5 : ($result18 < 5 ? 3 : ($result18 < 10 ? 1 :  0));
            // $x18 = ($data['analysis_18'] * 100) / 5;
            // $data['show18'] = $x18 >= 90 ? 'green' : ($x18 >= 75 ? 'yellow' : ($x18 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_18'] = 0;
            $data['show18'] = 'red';
        }


        //analysis 19
        $result19 = (float)$data['analysis'][0]->livelihood_purposes_of_all_loans;
        $data['analysis_19'] = '';
        $data['show19'] = '';
        if ($result19 != 0) {
            $data['analysis_19'] = ($result19 >= 90 ? 3 : ($result19 >= 75 ? 2 : ($result19 >= 60 ? 1 :  0)));
            if ($result19 >= 90) {
                $data['show19'] = 'green';
            } elseif ($result19 >= 75 && $result19 <= 89) {
                $data['show19'] = 'yellow';
            } elseif ($result19 >= 60 && $result19 <= 74) {
                $data['show19'] = 'grey';
            } elseif ($result19 < 60) {
                $data['show19'] = 'red';
            }
            //$x191 = ($data['analysis_19'] * 100) / 3;
            //$x19 = round($x191, 2);
            //$data['show19'] = $x19 >= 90 ? 'green' : ($x19 >= 75 ? 'yellow' : ($x19 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_19'] = 0;
            $data['show19'] = 'red';
        }
        //analysis 20
        $count20 = '';
        $result20 = (float)$data['analysis'][0]->rotation_of_funds;
        $data['analysis_20'] = '';
        $data['show20'] = '';
        if ($result20 != '') {
            $data['analysis_20'] = ($result20 > 0.7) ? 2 : ((($result20 >= 0.5) && ($result20 <= 0.7)) ? 1 : 0);
            if ($result20 >= 0.7) {
                $data['show20'] = 'green';
            } elseif ($result20 >= 0.5 && $result20 <= 0.69) {
                $data['show20'] = 'yellow';
            } elseif ($result20 >= 0.4 && $result20 <= 0.59) {
                $data['show20'] = 'grey';
            } elseif ($result20 < 0.4) {
                $data['show20'] = 'red';
            }
            //$x20 = ($data['analysis_20'] * 100) / 2;
            //$data['show20'] = $x20 >= 90 ? 'green' : ($x20 >= 75 ? 'yellow' : ($x20 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_20'] = 0;
            $data['show20'] = 'red';
        }


        //total 15 to 20
        $data['total_15to20'] = (float)$data['analysis_15'] + (float)$data['analysis_16'] + (float)$data['analysis_17'] + (float)$data['analysis_18'] + (float)$data['analysis_19'] + (float)$data['analysis_20'];
        $x15to20 = ($data['total_15to20'] * 100) / 25;
        $data['score3'] = $x15to20;
        $data['show_15to20'] = $x15to20 >= 90 ? 'green' : ($x15to20 >= 75 ? 'yellow' : ($x15to20 >= 60 ? 'grey' : 'red'));

        //analysis 21
        $result21 = $data['analysis'][0]->does_federation_cover_own_income;
        $data['analysis_21'] = '';
        $data['show21'] = '';
        if ($result21 != '') {
            $data['analysis_21'] = $result21 == 'Yes' ? 3 : 0;
            if ($result21 == "Yes") {
                $data['show21'] = 'green';
            } elseif ($result21 == "No") {
                $data['show21'] = 'red';
            }
            //$x21 = ($data['analysis_21'] * 100) / 3;
            //$data['show21'] = $x21 >= 90 ? 'green' : ($x21 >= 75 ? 'yellow' : ($x21 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_21'] =  0;
            $data['show21'] = 'red';
        }

        //analysis 22
        $result22 = $data['analysis'][0]->loan_security_fund_established;
        $data['analysis_22'] = '';
        $data['show22'] = '';

        if ($result22 != '') {
            $data['analysis_22'] = $result22 == 'Yes' ? 3 : 0;
            if ($result22 == "Yes") {
                $data['show22'] = 'green';
            } elseif ($result22 == "No") {
                $data['show22'] = 'red';
            }
            //$x22 = ($data['analysis_22'] * 100) / 3;
            //$data['show22'] = $x22 >= 90 ? 'green' : ($x22 >= 75 ? 'yellow' : ($x22 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_22'] =  0;
            $data['show22'] = 'red';
        }
        //total 21 to 22
        $data['total_21to22'] = (float)$data['analysis_21'] + (float)$data['analysis_22'];
        $x21to22 = ($data['total_21to22'] * 100) / 6;
        $data['score4'] = $x21to22;
        $data['show_21to22'] = $x21to22 >= 90 ? 'green' : ($x21to22 >= 75 ? 'yellow' : ($x21to22 >= 60 ? 'grey' : 'red'));

        //analysis 23
        $count23 = '';
        $result23 = (float)(str_replace('%', '', $data['analysis'][0]->members_covered_under_life_insurance));
        $data['analysis_23'] = '';
        $data['show23'] = '';
        if ($result23 != 0) {
            $count23 = ($result23 >= 90 ? 3 : ($result23 >= 75 ? 2 : ($result23 >= 60 ? 1 :  0)));
            $data['analysis_23'] = $count23;
            if ($result23 >= 90) {
                $data['show23'] = 'green';
            } elseif ($result23 >= 75 && $result23 <= 89) {
                $data['show23'] = 'yellow';
            } elseif ($result23 >= 60 && $result23 <= 74) {
                $data['show23'] = 'grey';
            } elseif ($result23 < 60) {
                $data['show23'] = 'red';
            }
            //$x23 = ($data['analysis_23'] * 100) / 3;
            //$data['show23'] = $x23 >= 90 ? 'green' : ($x23 >= 75 ? 'yellow' : ($x23 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_23'] = 0;
            $data['show23'] = 'red';
        }

        //analysis 24
        $count24 = '';
        $result24 = (float)(str_replace('%', '', $data['analysis'][0]->availed_members_covered_loan_insurance));
        $data['analysis_24'] = '';
        $data['show24'] = '';
        if ($result24 != 0) {
            $count24 = $result24 >= 90 ? 3 : ($result24 >= 75 ? 2 : ($result24 >= 60 ? 1 :  0));
            $data['analysis_24'] = $count24;
            if ($result24 >= 90) {
                $data['show24'] = 'green';
            } elseif ($result24 >= 75 && $result24 <= 89) {
                $data['show24'] = 'yellow';
            } elseif ($result24 >= 60 && $result24 <= 74) {
                $data['show24'] = 'grey';
            } elseif ($result24 < 60) {
                $data['show24'] = 'red';
            }
            //$x24 = ($data['analysis_24'] * 100) / 3;
            //$data['show24'] = $x24 >= 90 ? 'green' : ($x24 >= 75 ? 'yellow' : ($x24 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_24'] = 0;
            $data['show24'] = 'red';
        }

        //analysis 25
        $count25 = '';
        $result25 = (float)(str_replace('%', '', $data['analysis'][0]->animals_insured_purchased));
        $data['analysis_25'] = '';
        $data['show25'] = '';
        if ($result25 != 0) {
            $count25 = $result25 >= 90 ? 3 : ($result25 >= 75 ? 2 : ($result25 >= 60 ? 1 :  0));
            $data['analysis_25'] = $count25;
            if ($result25 >= 90) {
                $data['show25'] = 'green';
            } elseif ($result25 >= 75 && $result25 <= 89) {
                $data['show25'] = 'yellow';
            } elseif ($result25 >= 60 && $result25 <= 74) {
                $data['show25'] = 'grey';
            } elseif ($result25 < 60) {
                $data['show25'] = 'red';
            }
            //$x25 = ($data['analysis_25'] * 100) / 3;
            //$data['show25'] = $x25 >= 90 ? 'green' : ($x25 >= 75 ? 'yellow' : ($x25 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_25'] = 0;
            $data['show25'] = 'red';
        }
        //total 23 to 25
        $data['total_23to25'] = (float)$data['analysis_23'] + (float)$data['analysis_24'] + (float)$data['analysis_25'];
        $x23to25 = ($data['total_23to25'] * 100) / 9;
        $data['score5'] = $x23to25;
        $data['show_23to25'] = $x23to25 >= 90 ? 'green' : ($x23to25 >= 75 ? 'yellow' : ($x23to25 >= 60 ? 'grey' : 'red'));

        $data['analysis_final_total'] =  $data['total_23to25'] + $data['total_21to22'] + $data['total_15to20'] + $data['total_12to14'] + $data['total_9to11'] + $data['total_1to8'];
        $xfinal = ($data['analysis_final_total'] * 100) / 100;
        $data['show_final_total'] = $xfinal >= 90 ? 'green' : ($xfinal >= 75 ? 'yellow' : ($xfinal >= 60 ? 'grey' : 'red'));
        $data['show_final_status'] = $data['show_final_total'] == 'green' ? 'Minimal Risk' : ($data['show_final_total'] == 'yellow' ? ' Low Risk' : ($data['show_final_total'] == 'grey' ? 'Moderate Risk' : 'High Risk'));


        $file_name = $data['profile'][0]->name_of_federation;
        // view()->share('res', $data);
        // $pdf_doc = PDF::loadView('pdf.federationDetailsPdf', $data)->setPaper('a3', 'landscape');
        // return $pdf_doc->download($file_name.'_'.$federation->uin.'_'.pdf_date().'.pdf');
        return $data;
    }

    public function check_nrlm_code(Request $request){
        $nrml = $request->get('inputValue');
        $res = DB::table('federation_profile')
                ->where('clf_code', $nrml)
                ->where('is_deleted', 0)
                ->get();

                $total = $res->count();

        echo $total;

    }
}
