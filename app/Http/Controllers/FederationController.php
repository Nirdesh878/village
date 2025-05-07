<?php

namespace App\Http\Controllers;
use App\Models\TaskQaAssignment;
use App\Models\TaskAssignment;
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

        if($user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
        }
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
                    s.status_flag,
                    s.recalled

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
                if ($user_geo[0]->district_id == '') {
                    $district_list = 0;
                } else {

                    $district_list = $user_geo[0]->district_id;
                }

                $state_id = $user_geo[0]->state_id;

                $query .= " AND (CASE WHEN f.created_by > 1 THEN 1 ELSE 0 END = 1 AND f.created_by = $user->id and  f.is_deleted = 0";
                if ($txt_search != '') {
                    $query .= " AND (a.name_of_federation like '%$txt_search%' ";
                    $query .= " or SUBSTRING(f.uin, LENGTH(f.uin) - 3) LIKE '%$txt_search%' ) )";
                }

                $query .= " )
                OR
                (CASE WHEN f.created_by < 2 THEN 1 ELSE 0 END = 1 AND (a.district_id IN($district_list)  or a.state_id = $state_id) and f.is_deleted = 0";
                if ($txt_search != '') {
                    $query .= " AND (a.name_of_federation like '%$txt_search%' ";
                    $query .= " or SUBSTRING(f.uin, LENGTH(f.uin) - 3) LIKE '%$txt_search%' ) )";
                }

                $query .= " )";
            }

            if ($user->u_type != 'M') {
                if ($txt_search != '') {
                    $query .= " AND (a.name_of_federation like '%$txt_search%' ";
                    $query .= " or SUBSTRING(f.uin, LENGTH(f.uin) - 3) LIKE '%$txt_search%' )";
                }
            }
            // prd($query);
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
                elseif ($federation->recalled == 1 ) {
                    $visit = 'Recalled';
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
                        if($user->delete_inex != 'D'){
                        $btns .= '<a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove"  style="padding:0px;margin:0px;opacity: 0.3;"><i class="c-white-500 ti-trash"></i></a>';
                        }


                    }
                    else{

                        $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('federation.edit', $federation->ids) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                        $btns .= '<a class="btn btn-success btn-link btn-sm" rel="tooltip" title="View" data-original-title="View" href="' . route('federation.show', $federation->ids) . '" style="padding:0px;margin-left:5px"><i class="c-white-500 ti-eye"></i></a>';
                        if($user->delete_inex != 'D'){
                        $btns .= '<a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $federation->ids . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';
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
             try {
                 $validation_arr = [
                     'agency_id' => ['required'],
                     'name_of_federation' => ['required'],
                     'date_federation_was_found' => ['required'],
                     'country' => ['required'],
                     'state' => ['required'],
                     'district' => ['required'],
                     'nrlm_code' => ['required', new NRLMCode],

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
                     $nrlm = $request->post('nrlm_code');
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
                             $federation_mst->uin = $uin;

                             $federation_mst->created_by = $user->id;

                             $result = $federation_mst->save();

                             $FederationProfile = new FederationProfile();
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
                                 'clf_code' => $nrlm[$key],

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
            // prd($query);
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
        // prd($data['sustainability_service']);
        $data['risk_mitigation'] = DB::table('federation_risk_mitigation as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

            // prd( $data['risk_mitigation']);

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
        $analysis = fed_analysis($ID);
        $xfinal = $analysis['analysis_final_total'];
        $query = "UPDATE federation_profile set analysis_rating= '$xfinal' WHERE federation_sub_mst_id=$ID";
        $result = DB::update($query);
        // prd($data['remarks']);
        return view('federation.view', compact('federation'))->with($data)->with($analysis);
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
                        $user_details->date_federation_was_found = $request->post('date_federation_was_found') ?? null;
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
                        $user_details->clf_code = $request->post('nrlm_code');
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

        // $cluster_count = $shg_count = 0;

        try {
            if ($cluster_count == 0 && $shg_count == 0) {
                if ($federation->id != '') {
                    $user_details = Federation::find($federation->id);
                    $user_details->is_deleted = 1;
                    $user_details->save();

                    TaskQaAssignment::where('assignment_id', $federation->id)->where('assignment_type', 'FD')->update(['is_deleted' => 1]);
                    TaskAssignment::where('assignment_id', $federation->id)->where('assignment_type', 'FD')->update(['is_deleted' => 1]);


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
        $model_profile->clf_code = trim($FederationProfile['clf_code']);
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
        $analysis = fed_analysis($federation_id);
        $viewData = array_merge($data, $analysis);
        view()->share('data', $viewData);
        $pdf_doc = PDF::loadView('pdf.federationcardPdf', $viewData)->setPaper('a4', 'landscape');
        return $pdf_doc->stream('Federation_Rating_Card_' . $data['uin'] . '_' . pdf_date() . '.pdf');
    }

    public function export(Request $request)
    {

        return Excel::stream(new FederationExport(), 'FederationExport_' . pdf_date() . '.xlsx');
    }

    public function federationPDF(Request $request)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $user_geo = DB::table('user_location_relation')
            ->where('user_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->orderBy('country_id')
            ->get()->toArray();
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
            // $query .= " AND (Y.created_by = $user->id OR z.fp_district IN($district_list)) ";
            if($user_geo[0]->district_id == ''){
                $district_list = 0;
            } else{

                $district_list = $user_geo[0]->district_id;
            }

            $state_id = $user_geo[0]->state_id;

            $query .= " AND (CASE WHEN f.created_by > 1 THEN 1 ELSE 0 END = 1 AND f.created_by = $user->id AND  f.is_deleted = 0 )
               OR
            (CASE WHEN f.created_by < 2 THEN 1 ELSE 0 END = 1 AND (a.district_id IN ($district_list) OR a.state_id = $state_id ) AND  f.is_deleted = 0)" ;
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
        return $pdf_doc->stream('Federation_PDF_' . pdf_date() . '.pdf');
    }


    public function federationDetailsCardPdf($federation_id)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data = $this->mainPDF($federation_id);
        // prd($data['challenges']);
        $file_name = $data['profile'][0]->name_of_federation;
        $analysis = fed_analysis($federation_id);
        $viewData = array_merge($data, $analysis);
        view()->share('res', $viewData);
        return view('pdf.FederationDetailsCradsPDF')->with($viewData);
        // $pdf_doc = PDF::loadView('pdf.federationDetailsCardPdf', $data)->setPaper('a3', 'landscape');
        // return $pdf_doc->stream($file_name . '_' . $data['uin'] . '_' . pdf_date() . '.pdf');
    }


    public function exportPDF($federation_id)
    {

        $data['pre_url'] = (url()->previous());
        $user = Auth::user();

        $data = $this->mainPDF($federation_id);
        $file_name = $data['profile'][0]->name_of_federation;
        $analysis = fed_analysis($federation_id);
        $viewData = array_merge($data, $analysis);
        view()->share('res', $viewData);

        $pdf_doc = PDF::loadView('pdf.federationDetailsPdf', $viewData)->setPaper('a3', 'landscape');
        return $pdf_doc->stream($file_name . '_' . $data['uin'] . '_' . pdf_date() . '.pdf');
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
        // prd($data['sustainability_service']);
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

            $challenge_type = array(
                'Describe Action to address the challenge',
                'Who would be responsible for action. Specify name',
                'When would action be completed (date)',
                'Is there any support from project office needed to complete action',
                'What kind of support is needed',
                // 'Was action completed by expected date (Y/N/NA)',
                // 'Has action been changed/revised during last visit (Y/N)',
                // 'Facilitator to fill which is the revised/changed action',
            );

            $data['challenges'] = DB::table('federation_challenges as a')
                ->where('is_deleted', '=', 0)
                ->where('a.federation_sub_mst_id', '=', $result[0]->id)
                ->get()->toArray();
                // prd($data['challenges']);
            foreach ($challenge_type as $key1 => $val) {
                $data['challenges_actions_new'][$key1]['name'] = $val;
                foreach ($data['challenges'] as $key => $val1) {
                    $temp = json_decode($val1->action);
                    if (!empty($temp)) {
                        if ($key1 == 0) {
                            $data['challenges_actions_new'][$key1]['ch_actions'][$key] = $temp[0]->sa_describe_action;
                            continue;
                        }
                        if ($key1 == 1) {
                            $data['challenges_actions_new'][$key1]['ch_actions'][$key] = $temp[0]->sa_responsible;
                            continue;
                        }
                        if ($key1 == 2) {
                            $data['challenges_actions_new'][$key1]['ch_actions'][$key] = $temp[0]->sa_action_completed;
                            continue;
                        }
                        if ($key1 == 3) {
                            $data['challenges_actions_new'][$key1]['ch_actions'][$key] = $temp[0]->sa_SHG_Cluster_complete;
                            continue;
                        }
                        if ($key1 == 4) {
                            $data['challenges_actions_new'][$key1]['ch_actions'][$key] = $temp[0]->sa_support_needed;
                            continue;
                        }
                        // if ($key1 == 5) {
                        //     $data['challenges_actions_new'][$key1]['ch_actions'][$key] = $temp[0]->sa_expected_date;
                        //     continue;
                        // }
                        // if ($key1 == 6) {
                        //     $data['challenges_actions_new'][$key1]['ch_actions'][$key] = $temp[0]->sa_changed_rating;
                        //     continue;
                        // }
                        // if ($key1 == 7) {
                        //     $data['challenges_actions_new'][$key1]['ch_actions'][$key] = $temp[0]->sa_facilitator;
                        //     continue;
                        // }
                    }
                }
            }




        $file_name = $data['profile'][0]->name_of_federation;
        // view()->share('res', $data);
        // $pdf_doc = PDF::loadView('pdf.federationDetailsPdf', $data)->setPaper('a3', 'landscape');
        // return $pdf_doc->stream($file_name.'_'.$federation->uin.'_'.pdf_date().'.pdf');
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

    public function getLatLongFederation(Request $request)
    {

        $data = [];
        if ($request->post('filter') == 'Search') {
            $federation = $request->input('federation_id');
            // prd($federation);
            $dateArr = array('federation' => $federation);
            Session::put('federation_session', $request->all());
        }
        if (!empty($request->post('filter') == 'clear')) {
            $request->session()->forget('federation_session');
        }


        if ($request->ajax()) {

            $session_data = Session::get('federation_session');
            //    prd($session_data);

            $query = " SELECT
            a.name_of_federation,
            a.latitude,
            a.longitude,
            a.location_name,
            a.upload_date_time,
            a.lat_long_date_time,
            b.agency_name,
            a.id
            -- c.name AS country_name,
            -- d.name AS state_name,
            -- e.name AS district_name,


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

            INNER JOIN (SELECT a.*
                FROM task_assignment AS a
                JOIN (
                    SELECT assignment_id, MAX(updated_at) AS max_updated_at
                    FROM task_assignment
                    WHERE assignment_type = 'FD' AND `status` = 'D'
                    GROUP BY assignment_id
                ) AS b ON a.assignment_id = b.assignment_id AND a.updated_at = b.max_updated_at
                ORDER BY a.updated_at DESC) as ta ON f.id = ta.assignment_id
                LEFT JOIN users as ur
                ON ur.id = ta.user_id
        WHERE
            f.is_deleted = 0  AND a.longitude != '' AND a.latitude != '' ";

            // if (!empty($session_data['Search'])) {
            if (!empty($session_data['state'])) {
                if ($session_data['state'] != '' && $session_data['state'] > 0) {
                    $query .= " AND a.state_id = '" . $session_data['state'] . "' ";
                }
            }
            if (!empty($session_data['district'])) {
                if ($session_data['district'] != '' && $session_data['district'] > 0) {
                    $query .= " AND a.district_id = '" . $session_data['district'] . "' ";
                }
            }
            if (!empty($session_data['country'])) {
                if ($session_data['country'] != '' && $session_data['country'] > 0) {
                    $query .= " AND a.country_id = '" . $session_data['country'] . "' ";
                }
            }
            if(empty($session_data['Fac_id'])){
                if (!empty($session_data['agency_id'])) {
                    $text_search = $session_data['agency_id'];
                    $query .= " AND f.agency_id ='" . $session_data['agency_id'] . "' ";
                }
            }
            if (!empty($session_data['Fac_id'])) {
                $text_search = $session_data['Fac_id'];
                $query .= " AND ta.user_id ='" . $session_data['Fac_id'] . "' ";
            }

            // if (!empty($session_data['agency_id'])) {
            //     $text_search = $session_data['agency_id'];
            //     $query .= " AND f.agency_id ='" . $session_data['agency_id'] . "' ";
            // }
            // if (!empty($session_data['federation_id'])) {
            //     $text_search = $session_data['federation_id'];
            //     $query .= " AND f.id ='" . $session_data['federation_id'] . "' ";
            // }
            // }
            // prd($query);
            $result = DB::select(DB::raw($query));
            // prd($result);
            return json_encode($result);
            // exit;
        }
        $query = "SELECT * from agency WHERE is_deleted = 0";
        $data['agency'] = DB::select($query);

        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();


        return view('federation.map')->with($data);
    }

    public function mapDatatable(Request $request)
    {

        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
        }
        $data = [];
        if ($request->ajax()) {

            $session_data = Session::get('federation_session');
            //    prd($session_data);

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
                    a.name_of_district = e.id";

            if (!empty($session_data['Fac_id'])) {
                if ($session_data['Fac_id'] != '' && $session_data['Fac_id'] > 0) {
                    $query .= " INNER JOIN (SELECT a.*
                    FROM task_assignment AS a
                    JOIN (
                        SELECT assignment_id, MAX(updated_at) AS max_updated_at
                        FROM task_assignment
                        WHERE assignment_type = 'FD' AND `status` = 'D'
                        GROUP BY assignment_id
                    ) AS b ON a.assignment_id = b.assignment_id AND a.updated_at = b.max_updated_at
                    ORDER BY a.updated_at DESC) as ta ON f.id = ta.assignment_id ";
                }
            }

            $query .= " where f.is_deleted = 0  AND a.longitude != '' AND a.latitude != '' ";


            if (!empty($session_data['state'])) {
                if ($session_data['state'] != '' && $session_data['state'] > 0) {
                    $query .= " AND a.state_id = '" . $session_data['state'] . "' ";
                }
            }
            if (!empty($session_data['district'])) {
                if ($session_data['district'] != '' && $session_data['district'] > 0) {
                    $query .= " AND a.district_id = '" . $session_data['district'] . "' ";
                }
            }
            if (!empty($session_data['country'])) {
                if ($session_data['country'] != '' && $session_data['country'] > 0) {
                    $query .= " AND a.country_id = '" . $session_data['country'] . "' ";
                }
            }
            if(empty($session_data['Fac_id'])){
                if (!empty($session_data['agency_id'])) {
                    $text_search = $session_data['agency_id'];
                    $query .= " AND f.agency_id ='" . $session_data['agency_id'] . "' ";
                }
            }
            if (!empty($session_data['Fac_id'])) {
                $text_search = $session_data['Fac_id'];
                $query .= " AND ta.user_id ='" . $session_data['Fac_id'] . "' ";
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

        return view('federation.map')->with($data);
    }
}
