<?php

namespace App\Http\Controllers;

use App\Exports\SHGExport;
use App\Http\Controllers\API\SqlLibController;
use App\Http\Controllers\Controller;
use App\Models\FcsnodeMst;
use App\Models\Shg;
use App\Models\ShgAnalysis;
use App\Models\ShgChallenges;
use App\Models\ShgCreditrecovery;
use App\Models\ShgEfficiency;
use App\Models\ShgGovernance;
use App\Models\ShgInclusion;
use App\Models\ShgObservation;
use App\Models\ShgProfile;
use App\Models\ShgRating;
use App\Models\ShgSaving;
use App\Models\ShgSubMst;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use \stdClass;
use App\Rules\ShgNRLMCode;
use Illuminate\Support\Facades\Session;
use App\Models\TaskQaAssignment;
use App\Models\TaskAssignment;



class ShgController extends Controller
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

        if($user->u_type == 'QA'){
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
                    j.*,
                    d.agency_name,
                    e.name AS country_name,
                    f.name AS state_name,
                    g.name AS district_name,
                    i.uin,
                    i.id AS ids,
                    i.created_at as created,
                    i.status,
                    i.federation_uin,
                    i.cluster_uin,
                    i.srlm_code,
                    h.name_of_federation,
                    b.name_of_cluster,
                    k.status AS shg_status,
                    k.analytics,
                    k.rating,
                    k.dm_a,
                    k.qa_a,
                    k.dm_r,
                    k.qa_r,
                    k.updated_at,
                    k.flag,
                    k.locked,
                    k.status_flag,
                    k.recalled
                FROM
                    shg_mst AS i
                INNER JOIN shg_sub_mst AS k
                ON
                    k.shg_mst_id = i.id
                INNER JOIN shg_profile AS j
                ON
                    j.shg_sub_mst_id = k.id
                LEFT JOIN cluster_mst AS a
                ON
                    i.cluster_uin = a.uin
                LEFT JOIN cluster_sub_mst AS m
                ON
                    m.cluster_mst_id = a.id
                LEFT JOIN cluster_profile AS b
                ON
                    b.cluster_sub_mst_id = m.id
                INNER JOIN federation_mst AS c
                ON
                    i.federation_uin = c.uin
                INNER JOIN federation_sub_mst AS n
                ON
                    n.federation_mst_id = c.id
                INNER JOIN federation_profile AS h
                ON
                    h.federation_sub_mst_id = n.id
                INNER JOIN agency AS d
                ON
                    i.agency_id = d.agency_id
                LEFT JOIN countries AS e
                ON
                    j.name_of_country = e.id
                LEFT JOIN states AS f
                ON
                    j.name_of_state = f.id
                LEFT JOIN district AS g
                ON
                    j.name_of_district = g.id
                WHERE
                    i.is_deleted = 0";
            if ($user->u_type == 'M') {
                // $query .= " AND i.created_by = $user->id ";

                if ($user_geo[0]->district_id == '') {
                    $district_list = 0;
                } else {

                    $district_list = $user_geo[0]->district_id;
                }

                $state_id = $user_geo[0]->state_id;

                $query .= " AND (CASE WHEN i.created_by > 1 THEN 1 ELSE 0 END = 1 AND i.created_by = $user->id AND  i.is_deleted = 0 ";
                if ($txt_search != '') {
                    $query .= " AND (j.shgName like '%$txt_search%' ";
                    $query .= " or b.name_of_cluster like '%$txt_search%' ";
                    $query .= " or h.name_of_federation like '%$txt_search%' ";
                    $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' ) )";
                }

                $query .= ")
                OR
                (CASE WHEN i.created_by < 2 THEN 1 ELSE 0 END = 1 AND (j.district_id IN($district_list)OR j.state_id = $state_id   ) AND  i.is_deleted = 0 ";
                if ($txt_search != '') {
                    $query .= " AND (j.shgName like '%$txt_search%' ";
                    $query .= " or b.name_of_cluster like '%$txt_search%' ";
                    $query .= " or h.name_of_federation like '%$txt_search%' ";
                    $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' )";
                }
                $query .= " )";
            }

            if ($user->u_type != 'M') {
                if ($txt_search != '') {
                    $query .= " AND (j.shgName like '%$txt_search%' ";
                    $query .= " or b.name_of_cluster like '%$txt_search%' ";
                    $query .= " or h.name_of_federation like '%$txt_search%' ";
                    $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' )";
                }
            }
            $shgs = DB::select($query);
            $total = count($shgs);
            $query .= " ORDER BY
                    k.updated_at
                DESC,i.id DESC
                LIMIT $limit OFFSET $start";
            $shgs = DB::select($query);
            // prd($shgs);
            foreach ($shgs as $shg) {
                $visit = 'Created';
                if ($shg->dm_a == 'V' && $shg->qa_a == 'V' && $shg->locked == 1) {
                    $visit = 'Locked';
                } elseif ($shg->dm_a == 'V' && $shg->qa_a == 'V') {
                    $visit = 'Initial Rating';
                } elseif ($shg->dm_a == 'V' && $shg->qa_a == 'P') {
                    $visit = 'Analytics Complete';
                } elseif ($shg->dm_a == 'P') {
                    $visit = 'Visit Complete';
                } elseif ($shg->dm_a == 'N' && ($shg->flag == 0 )) {
                    $visit = 'Visit Pending';
                } elseif ($shg->dm_a == 'R' && $shg->flag == 1) {
                    $visit = 'Visit Reassigned';
                }
                elseif ($shg->recalled == 1 ) {
                    $visit = 'Recalled';
                }

                $row = [];
                $row[] = ++$start;
                $row[] = $shg->uin;
                $row[] = $shg->shgName;
                $row[] = ($shg->name_of_cluster != '' or $shg->name_of_cluster == 'NULL') ? $shg->name_of_cluster : '-';
                $row[] = $shg->name_of_federation;
                $row[] = $visit;
                $row[] = change_date_month_name_char($shg->created);
                $row[] = change_date_month_name_char($shg->updated_at);
                $row[] = $shg->locked == 1 ? 'Yes' : 'No';
                $row[] = $shg->status == 'A' ? '<span class="status-active">Active</span>' : '<span class="status-inactive">InActive</span>';

                $btns = '';

                if ($user->u_type != 'M') {
                    $btns .= '<a class="btagencyn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('shg.edit', $shg->ids) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                    $btns .= '<a class="btn btn-success btn-link btn-sm" rel="tooltip" title="View" data-original-title="View" href="' . route('shg.show', $shg->ids) . '" style="padding:0px;margin-left:5px"><i class="c-white-500 ti-eye"></i></a>';
                    $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $shg->ids . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';
                } else if ($user->u_type == 'M') {
                    if ($shg->status_flag == 1) {
                        $btns .= '<a class="btagencyn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit"  style="padding:0px;margin:0px;opacity: 0.3;"><i class="c-white-500 ti-pencil"></i></a>';
                    $btns .= '<a class="btn btn-success btn-link btn-sm" rel="tooltip" title="View" data-original-title="View"  style="padding:0px;margin-left:5px;opacity: 0.3;"><i class="c-white-500 ti-eye"></i></a>';
                    if($user->delete_inex != 'D'){
                    $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove"  title="Delete User"  style="padding:0px;margin:0px;opacity: 0.3;"><i class="c-white-500 ti-trash"></i></a>';
                    }
                    }
                    else{
                        $btns .= '<a class="btagencyn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('shg.edit', $shg->ids) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                    $btns .= '<a class="btn btn-success btn-link btn-sm" rel="tooltip" title="View" data-original-title="View" href="' . route('shg.show', $shg->ids) . '" style="padding:0px;margin-left:5px"><i class="c-white-500 ti-eye"></i></a>';
                    if($user->delete_inex != 'D'){
                    $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $shg->ids . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';
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
        return view('shg.list')->with($data);
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
        return view('shg.add')->with($data);
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
                     'village' => ['required'],
                     'country' => ['required'],
                     'state' => ['required'],
                     'shgName' => ['required'],
                     'formed' => ['required'],
                     'nrlm_code' => ['required', new ShgNRLMCode],


                 ];

                 $validator = Validator::make($request->all(), $validation_arr);
                 if ($validator->fails()) {
                     return redirect()->back()->withErrors($validator)->withInput();
                 }
                 $result = DB::transaction(function () use ($request) {
                     $temp_rand = '';

                     $user = Auth::User();
                     $shgName = $request->post('shgName');
                     $village = $request->post('village');
                     $formed = $request->post('formed');
                     $nrlm = $request->post('nrlm_code');


                     if (count($shgName) > 0) {
                         foreach ($shgName as $key => $value) {
                             $shg_mst = new Shg();

                             $temp_rand = $request->post('agency_id');

                             //uin
                             $country_code = getCountryCodeByID($request->post('country'));
                             $state_code = strtoupper(getStateCodeByID($request->post('state')));
                             $district_code = strtoupper(substr(getName('district', 'name', $request->post('district')), 0, 2));
                             $uin = checkAndGenerateUIN($country_code, $state_code, $district_code, 'shg_mst', 'SH');
                             //prd($uin);
                             $shg_mst->uin = $uin;
                             $shg_mst->srlm_code = $request->post('srlm_code');
                             $shg_mst->agency_id = $temp_rand;
                             $shg_mst->status = 'A';
                             $shg_mst->federation_uin = $request->post('federation_id');
                             $shg_mst->cluster_uin = $request->post('cluster_uin');
                             $shg_mst->tkn = substr(md5(mt_rand()), 0, 16);

                             $shg_mst->created_by = $user->id;
                             $cluster_uin = $request->post('cluster_uin');
                             $federation_uin = $request->post('federation_uin');

                             $result = $shg_mst->save();
                             $pid = 0; // define

                             $data_query = "SELECT * FROM fcsnode_mst WHERE uin IN('" . $request->post('cluster_uin') . "','" . $request->post('federation_id') . "')";
                             $data = DB::select($data_query);
                             if (!empty($data)) {
                                 foreach ($data as $data2) {
                                     $data2 = (array) $data2;
                                     if ($data2['uin'] == $cluster_uin) {
                                         $shg_mst->cluster_uin = $data2['uin'];
                                         $pid = $data2['id'];
                                     }

                                     if ($data2['uin'] == $federation_uin) {
                                         $shg_mst->federation_uin = $data2['uin'];
                                     }
                                 }
                             }
                             $ShgMstProfile = array(
                                 'shg_sub_mst_id' => $shg_mst->id,
                                 'shgName' => $value,
                                 'name_of_country' => getName('countries', 'name', $request->post('country')),
                                 'name_of_state' => getName('states', 'name', $request->post('state')),
                                 'name_of_district' => getName('district', 'name', $request->post('district')),
                                 'country_id' => $request->post('country'),
                                 'state_id' => $request->post('state'),
                                 'district_id' => $request->post('district'),
                                 'formed' => $formed[$key],

                                 'village' => $village[$key],
                                 'shg_code' => $nrlm[$key],

                                 'created_by' => $user->id,
                                 'created_at' => date('Y-m-d H:i:s'),
                             );
                             $result = $this->Submaster($shg_mst->id, $pid, $uin, $temp_rand, $ShgMstProfile);
                         }
                         if ($result) {
                             return true;
                         }
                     }
                 });
                 if ($result) {
                     return redirect('shg')->with(['message' => 'SHG saved successfully.']);
                 }
             } catch (\Exception $e) {
                 prd($e->getMessage());
                 return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
             }
         }
         $data['agency'] = DB::table('agency')
             ->where('is_deleted', '=', 0)
             ->get()->toArray();

         return view('shg.list')->with($data);
     }
    public function shg_table(Request $request)
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
            z.shgName,
            X.id,
            z.created_at,
            Y.uin
                FROM
                    shg_mst AS Y
                INNER JOIN shg_sub_mst AS X
                ON
                    Y.id = X.shg_mst_id
                INNER JOIN shg_profile AS z
                ON
                    X.id = z.shg_sub_mst_id

                WHERE
                    Y.is_deleted = 0 ";
            if ($user->u_type == 'M') {
                $query .= " AND Y.created_by = $user->id";
            }

            $shgs = DB::select($query);
            $total = count($shgs);
            $query .= " ORDER BY
                    z.created_at
                DESC
                LIMIT $limit OFFSET $start";
            $shgs = DB::select($query);
            foreach ($shgs as $shg) {
                $row = [];
                $row[] = ++$start;

                $row[] = $shg->shgName;
                $row[] = $shg->uin;

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

        return view('shg.add')->with($data);
    }
    public function shg_table_two(Request $request)
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
            $cluster_id = $request->post('cluster_id');

            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');

            $query = " SELECT
            z.shgName,
            X.id,
            Y.uin
                FROM
                    shg_mst AS Y
                INNER JOIN shg_sub_mst AS X
                ON
                    Y.id = X.shg_mst_id
                INNER JOIN shg_profile AS z
                ON
                    X.id = z.shg_sub_mst_id

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
                if (!empty($cluster_id)) {
                    $query .= " AND Y.cluster_uin = '" . $cluster_id . "' ";
                }
            }
            prd($query);
            $shgs = DB::select($query);
            $total = count($shgs);

            foreach ($shgs as $shg) {
                $row = [];
                $row['sn'] = ++$start;
                $row['shg_name'] = $shg->shgName;
                $row['uin'] = $shg->uin;

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

        return view('family.add')->with($data);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shg  $shg
     * @return \Illuminate\Http\Response
     */
    public function show(Shg $shg, Request $request)
    {

        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data['u_type'] = $user->u_type;
        $data['shg_ids'] = $shg->id;
        $data['agency_id'] = $shg->agency_id;
        $data['dm_id'] = $user->id;
        $data['quality_check'] = ($request->get('task_id') == null) ? 0 : 1;
        $t_q_a = DB::table('task_qa_assignment as y')
            ->select('y.*')
            ->where('y.assignment_id', '=', $shg->id)
            ->where('y.assignment_type', '=', 'SH')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()->toArray();
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
            ->where('a.agency_id', '=', $shg->agency_id)
            ->get()->toArray();
        $query = "Select id,qa_status from shg_sub_mst where shg_mst_id=$shg->id";
        $result = DB::select($query);
        $data['manager_status'] = $result[0]->qa_status;
        $data['profile'] = DB::table('shg_profile as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $query_1 = "Select b.name_of_cluster from cluster_mst a inner join cluster_sub_mst c on a.id=c.cluster_mst_id inner join cluster_profile b on c.id=b.cluster_sub_mst_id where a.is_deleted=0 and a.uin='$shg->cluster_uin' ";
        $data['clusterprofile'] = DB::select($query_1);

        $query_2 = "Select b.name_of_federation from federation_mst a inner join federation_sub_mst c on a.id=c.federation_mst_id inner join federation_profile b on c.id=b.federation_sub_mst_id where a.is_deleted=0 and a.uin='$shg->federation_uin' ";
        $data['fed_profile'] = DB::select($query_2);

        $query_3 = "Select agency_name from agency where is_deleted=0 and agency_id='$shg->agency_id' ";
        $data['agency_profile'] = DB::select($query_3);

        $data['photos'] = DB::table('shg_upload_photos_videos as a')
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $data['governance'] = DB::table('shg_governance as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['inclusion'] = DB::table('shg_inclusion as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['efficiency'] = DB::table('shg_efficiency as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $temp = (stripslashes($data['efficiency'][0]->SHG_Efficiency_Training_object));
        $data['efficiency_details'] = json_decode($temp);

        $data['creditrecovery'] = DB::table('shg_creditrecovery as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['analysis'] = DB::table('shg_analysis as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['saving'] = DB::table('shg_saving as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['observation'] = DB::table('shg_observation as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();



        $challenge_type = array(
            'Describe Action to address the challenge',
            'Who would be responsible for action. Specify name',
            'When would action be completed (date)',
            'Is there any support from project office needed to complete action',
            'What kind of support is needed',
            'Was action completed by expected date (Y/N/NA)',
            'Has action been changed/revised during last visit (Y/N)',
            'Facilitator to fill which is the revised/changed action',
        );

        $data['challenges'] = DB::table('shg_challenges as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
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
        $ID = $result[0]->id;
        $query = "SELECT
                a.*,
                b.name ,
                c.shgName
                FROM
                    `shg_remarks` AS a
                LEFT JOIN users AS b
                ON
                    a.user_id = b.id
                LEFT JOIN shg_profile AS c
                ON
                    a.shg_id = c.shg_sub_mst_id
                WHERE
                    a.shg_id = $ID
                    ORDER BY a.updated_at DESC
                    ";
        $data['remarks'] = DB::select($query);

        $analysis = shg_analysis($ID);


        $xfinal = $analysis['grd_total'];
        // prd($xfinal);
        $query = "UPDATE shg_profile set analysis_rating = '$xfinal' WHERE shg_sub_mst_id=$ID";
        $result = DB::update($query);




        return view('shg.view', compact('shg'))->with($data)->with($analysis);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shg  $shg
     * @return \Illuminate\Http\Response
     */
    public function edit(Shg $shg)
    {
        $data['shg_profile'] = DB::table('shg_profile as p')
            ->select('p.*', 'k.id', 'p.id as profile_id')
            ->join('shg_sub_mst as k', 'p.shg_sub_mst_id', '=', 'k.id')
            ->join('shg_mst as l', 'k.shg_mst_id', '=', 'l.id')
            ->where('l.is_deleted', '=', 0)
            ->where('l.id', '=', $shg->id)
            ->get()->toArray();
        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        $data['edit'] = 1;
        //prd($data);
        return view('shg.edit', compact('shg'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shg  $shg
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shg $shg)
    {
        $view = 'shg.edit';

        /* Check post either add or update */
        if ($request->isMethod('PATCH')) {
            try {
                $validation_arr = [
                    'agency_id' => ['required'],
                    'federation_id' => ['required'],
                    'village' => ['required'],
                    'country' => ['required'],
                    'state' => ['required'],
                    'shgName' => ['required'],
                    'status' => ['required'],
                    'formed' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $result = DB::transaction(function () use ($request, $shg) {
                    $user = Auth::User();
                    if ($request->post('id') > 0) {
                        $shg_mst = Shg::find($request->post('id'));
                        $shg_mst->updated_by = $user->id;
                    } else {
                        return redirect('shg')->with(['message' => 'SHG id does not exist.']);
                        exit();
                    }
                    $shg_mst->srlm_code = $request->post('srlm_code');
                    $shg_mst->status = $request->post('status');
                    $shg_mst->federation_uin = $request->post('federation_id');
                    $shg_mst->cluster_uin = $request->post('cluster_uin');
                    $shg_mst->created_by = $user->id;

                    $qry = "SELECT id FROM shg_sub_mst WHERE status='A' AND shg_mst_id=" . $request->post('id') . "";
                    $data = DB::select($qry);
                    $shg_sub_mst_id = $data[0]->id;
                    $qry = "SELECT * FROM shg_profile WHERE shg_sub_mst_id=$shg_sub_mst_id";
                    $shg_profile_data = DB::select($qry);

                    $shg_profile = $shg_profile_data[0];
                    $SqlLib = new SqlLibController();
                    $agency = $SqlLib->Agency();

                    $uin1 = $shg_mst->agency_id;
                    $nuincd = $shg_mst->uin;
                    $cluster_uin = $request->post('cluster_uin');
                    $federation_uin = $request->post('federation_id');
                    $pid = 0; // define

                    $qry = "SELECT * FROM fcsnode_mst WHERE uin IN('$cluster_uin','$federation_uin')";
                    $data = DB::select($qry);
                    if (!empty($data)) {
                        foreach ($data as $data2) {
                            $data2 = (array) $data2;
                            if ($data2['uin'] == $cluster_uin) {
                                $shg_mst->cluster_uin = $data2['uin'];
                                $pid = $data2['id'];
                            }

                            if ($data2['uin'] == $federation_uin) {
                                $shg_mst->federation_uin = $data2['uin'];
                            }
                        }
                    }
                    $result = $shg_mst->save();
                    FcsnodeMst::where([['uin', '=', $nuincd]])->update(['pid' => $pid]);
                    if ($shg_mst->id > 0) {
                        $profile_id = $request->post('profile_id');
                        $user_details = ShgProfile::find($profile_id);
                        $user_details->shgName = $request->post('shgName');
                        $user_details->country_id = $request->post('country');
                        $user_details->state_id = $request->post('state');
                        $user_details->district_id = $request->post('district');
                        $user_details->name_of_country = getName('countries', 'name', $request->post('country'));
                        $user_details->name_of_state = getName('states', 'name', $request->post('state'));
                        $user_details->name_of_district = getName('district', 'name', $request->post('district'));
                        $user_details->formed = $request->post('formed');
                        $user_details->village = $request->post('village');
                        $user_details->web_email = ($request->post('email'));
                        $user_details->web_mobile = ($request->post('mobile'));
                        $user_details->members_at_creation = $request->post('members_at_creation');
                        $user_details->current_members = $request->post('current_members');
                        $user_details->members_left = $request->post('members_left');
                        $user_details->members_neighborhood = $request->post('members_neighborhood');
                        $user_details->president = $request->post('president');
                        $user_details->secretary = $request->post('secretary');
                        $user_details->treasure = $request->post('treasure');
                        $user_details->book_keeper_name = $request->post('book_keeper_name');
                        $user_details->book_keeper_date = change_date_format($request->post('book_keeper_date'));
                        $user_details->bank_date = change_date_format($request->post('bank_date'));
                        $user_details->bank_name = $request->post('bank_name');
                        $user_details->bank_branch = $request->post('bank_branch');
                        $user_details->bank_ac_no = $request->post('bank_ac_no');

                        $user_details->updated_by = $user->id;
                        $user_details->updated_at = date('Y-m-d H:i:s');
                        $result = $user_details->save();
                    }

                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('shg')->with(['message' => 'SHG updated successfully.']);
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
     * @param  \App\Models\Shg  $shg
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shg $shg)
    {
        $query = "SELECT count(*) as count FROM family_mst WHERE shg_uin = '$shg->uin' AND is_deleted = 0";
        $family_count = DB::select($query)[0]->count;
        try {
            if ($family_count == 0) {
                if ($shg->id != '') {
                    $user_details = Shg::find($shg->id);
                    $user_details->is_deleted = 1;
                    $user_details->save();

                    TaskQaAssignment::where('assignment_id', $shg->id)->where('assignment_type', 'SH')->update(['is_deleted' => 1]);
                    TaskAssignment::where('assignment_id', $shg->id)->where('assignment_type', 'SH')->update(['is_deleted' => 1]);

                    $data['message'] = 'SHG Deleted Successfully';
                    echo json_encode($data);
                } else {
                    $data['message'] = 'Invalid Request';
                    echo json_encode($data);
                }
            } else {
                $data['message'] = "Total number of Family created under this SHG are $family_count . Please delete these Family first.";
                echo json_encode($data);
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }
    public function submaster($shg_mst_id, $pid, $nuincd, $agency_id, $ShgProfile)
    {

        //Manage relation of eaech
        $modelnw = new FcsnodeMst();
        $modelnw->pid = $pid;
        $modelnw->uin = $nuincd;
        $modelnw->type = 'S';
        $modelnw->agency_id = $agency_id;
        $modelnw->tkn = substr(md5(mt_rand()), 0, 16);
        $modelnw->created_at = date('Y-m-d H:i:s');
        $modelnw->save();

        $modeln = new ShgSubMst();
        $modeln->shg_mst_id = $shg_mst_id;
        $modeln->created_at = date('Y-m-d H:i:s');
        $modeln->save();
        $shg_sub_mst_id = $modeln->id;

        $model_profile = new ShgProfile();
        $model_profile->shg_sub_mst_id = $shg_sub_mst_id;
        $model_profile->shgName = (trim($ShgProfile['shgName']));
        $model_profile->name_of_district = (trim($ShgProfile['name_of_district']));
        $model_profile->name_of_state = (trim($ShgProfile['name_of_state']));
        $model_profile->name_of_country = (trim($ShgProfile['name_of_country']));
        $model_profile->district_id = (trim($ShgProfile['district_id']));
        $model_profile->state_id = (trim($ShgProfile['state_id']));
        $model_profile->country_id = (trim($ShgProfile['country_id']));
        $model_profile->formed = change_date_monthName(trim($ShgProfile['formed']));
        $model_profile->village = (trim($ShgProfile['village']));
        $model_profile->shg_code = (trim($ShgProfile['shg_code']));


        $model_profile->created_at = (trim($ShgProfile['created_at']));
        $model_profile->created_by = (trim($ShgProfile['created_by']));
        $model_profile->save();

        $model_analysis = new ShgAnalysis();
        $model_analysis->shg_sub_mst_id = $shg_sub_mst_id;
        $modeln->created_at = date('Y-m-d H:i:s');
        $model_analysis->save();

        $model_challenges = new ShgChallenges();
        $model_challenges->shg_sub_mst_id = $shg_sub_mst_id;
        $modeln->created_at = date('Y-m-d H:i:s');
        $model_challenges->save();

        $model_creditrecovery = new ShgCreditrecovery();
        $model_creditrecovery->shg_sub_mst_id = $shg_sub_mst_id;
        $modeln->created_at = date('Y-m-d H:i:s');
        $model_creditrecovery->save();

        $model_efficiency = new ShgEfficiency();
        $model_efficiency->shg_sub_mst_id = $shg_sub_mst_id;
        $modeln->created_at = date('Y-m-d H:i:s');
        $model_efficiency->save();

        $model_governance = new ShgGovernance();
        $model_governance->shg_sub_mst_id = $shg_sub_mst_id;
        $modeln->created_at = date('Y-m-d H:i:s');
        $model_governance->save();

        $model_inclusion = new ShgInclusion();
        $model_inclusion->shg_sub_mst_id = $shg_sub_mst_id;
        $modeln->created_at = date('Y-m-d H:i:s');
        $model_inclusion->save();

        $model_saving = new ShgSaving();
        $model_saving->shg_sub_mst_id = $shg_sub_mst_id;
        $modeln->created_at = date('Y-m-d H:i:s');
        $model_saving->save();

        $model_rating = new ShgRating();
        $model_rating->shg_sub_mst_id = $shg_sub_mst_id;
        $model_rating->rating = json_encode(array());
        $modeln->created_at = date('Y-m-d H:i:s');
        $model_rating->save();

        $model_observation = new ShgObservation();
        $model_observation->shg_sub_mst_id = $shg_sub_mst_id;
        $modeln->created_at = date('Y-m-d H:i:s');
        $model_observation->save();

        return true;
    }

    public function export(Request $request)
    {
        return Excel::stream(new SHGExport(), 'SHGExport_' . pdf_date() . '.xlsx');
    }

    public function shgPDF(Request $request)
    {
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
                j.*,
                d.agency_name,
                e.name AS country_name,
                f.name AS state_name,
                g.name AS district_name,
                i.uin,
                i.id AS ids,
                i.status,
                i.federation_uin,
                i.cluster_uin,
                i.srlm_code,
                h.name_of_federation,
                b.name_of_cluster,
                k.status AS shg_status,
                k.analytics,
                k.rating,
                k.dm_a,
                k.qa_a,
                k.dm_r,
                k.qa_r,
                k.flag,
                k.updated_at AS updated,
                k.locked
            FROM
                shg_mst AS i
            INNER JOIN shg_sub_mst AS k
            ON
                k.shg_mst_id = i.id
            INNER JOIN shg_profile AS j
            ON
                j.shg_sub_mst_id = k.id
            LEFT JOIN cluster_mst AS a
            ON
                i.cluster_uin = a.uin
            LEFT JOIN cluster_sub_mst AS m
            ON
                m.cluster_mst_id = a.id
            LEFT JOIN cluster_profile AS b
            ON
                b.cluster_sub_mst_id = m.id
            INNER JOIN federation_mst AS c
            ON
                i.federation_uin = c.uin
            INNER JOIN federation_sub_mst AS n
            ON
                n.federation_mst_id = c.id
            INNER JOIN federation_profile AS h
            ON
                h.federation_sub_mst_id = n.id
            INNER JOIN agency AS d
            ON
                i.agency_id = d.agency_id
            LEFT JOIN countries AS e
            ON
                j.country_id = e.id
            LEFT JOIN states AS f
            ON
                j.state_id = f.id
            LEFT JOIN district AS g
            ON
                j.district_id = g.id
            WHERE
                i.is_deleted = 0 ";
           if ($user->u_type == 'M') {
            // $query .= " AND (Y.created_by = $user->id OR z.fp_district IN($district_list)) ";
            if($user_geo[0]->district_id == ''){
                $district_list = 0;
            } else{

                $district_list = $user_geo[0]->district_id;
            }

            $state_id = $user_geo[0]->state_id;

            $query .= " AND (CASE WHEN i.created_by > 1 THEN 1 ELSE 0 END = 1 AND i.created_by = $user->id AND  i.is_deleted = 0 )
               OR
            (CASE WHEN i.created_by < 2 THEN 1 ELSE 0 END = 1 AND (j.district_id IN ($district_list) OR j.state_id = $state_id ) AND  i.is_deleted = 0)" ;
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
                        assignment_type = 'SH'
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
        $pdf_doc = PDF::loadView('pdf.shgPdf', $data)->setPaper('a3', 'landscape');
        return $pdf_doc->stream('SHG_PDF_' . pdf_date() . '.pdf');
    }

    public function mainPDF($shg_ids)
    {
        $data['pre_url'] = (url()->previous());

        $shg = Shg::find($shg_ids);
        $data['shg'] = $shg;
        $user = Auth::user();
        $data['u_type'] = $user->u_type;
        $data['agency_id'] = $shg->agency_id;
        $data['uin'] = $shg->uin;
        $data['quality_check'] = 1;
        $t_q_a = DB::table('task_qa_assignment as y')
            ->select('y.*')
            ->where('y.assignment_id', '=', $shg->id)
            ->where('y.assignment_type', '=', 'SH')
            ->get()->toArray();

        $data['task_id'] = 0;
        $data['user_id'] = 0;
        $data['qa_status'] = $t_q_a[0]->qa_status ?? null;
        $data['qa_remark'] = $t_q_a[0]->remark ?? null;
        $data['qa_readonly'] = ($data['qa_status'] == 'R' || $data['qa_status'] == 'V') ? 'readonly' : '';
        $data['agency'] = DB::table('agency as a')
            ->select('a.agency_name')
            ->where('is_deleted', '=', 0)
            ->where('a.agency_id', '=', $shg->agency_id)
            ->get()->toArray();
        $query = "Select id from shg_sub_mst where shg_mst_id=$shg->id";
        $result = DB::select($query);

        $data['profile'] = DB::table('shg_profile as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $query_1 = "Select b.name_of_cluster from cluster_mst a inner join cluster_sub_mst c on a.id=c.cluster_mst_id inner join cluster_profile b on c.id=b.cluster_sub_mst_id where a.is_deleted=0 and a.uin='$shg->cluster_uin' ";
        $data['clusterprofile'] = DB::select($query_1);

        $query_2 = "Select b.name_of_federation from federation_mst a inner join federation_sub_mst c on a.id=c.federation_mst_id inner join federation_profile b on c.id=b.federation_sub_mst_id where a.is_deleted=0 and a.uin='$shg->federation_uin' ";
        $data['fed_profile'] = DB::select($query_2);

        $query_3 = "Select agency_name from agency where is_deleted=0 and agency_id='$shg->agency_id' ";
        $data['agency_profile'] = DB::select($query_3);

        $data['governance'] = DB::table('shg_governance as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['inclusion'] = DB::table('shg_inclusion as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['efficiency'] = DB::table('shg_efficiency as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        $temp = (stripslashes($data['efficiency'][0]->SHG_Efficiency_Training_object));
        $data['efficiency_details'] = json_decode($temp);

        $data['creditrecovery'] = DB::table('shg_creditrecovery as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['analysis'] = DB::table('shg_analysis as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['saving'] = DB::table('shg_saving as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();

        $data['observation'] = DB::table('shg_observation as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
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

        $data['challenges'] = DB::table('shg_challenges as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
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

        $data['challenges'] = DB::table('shg_challenges as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $result[0]->id)
            ->get()->toArray();
        foreach ($challenge_type as $key1 => $val) {
            $data['challenges_actions'][$key1]['name'] = $val;
            foreach ($data['challenges'] as $key => $val1) {
                $temp = json_decode($val1->action);
                if (!empty($temp)) {
                    if ($key1 == 0) {
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
                    if ($key1 == 6) {
                        $data['challenges_actions'][$key1]['action'][$key] = $temp[0]->sa_changed_rating;
                        continue;
                    }
                    if ($key1 == 7) {
                        $data['challenges_actions'][$key1]['action'][$key] = $temp[0]->sa_facilitator;
                        continue;
                    }
                }
            }
        }

        $file_name = $data['profile'][0]->shgName;
        return $data;
    }
    public function exportPDF($shg_ids)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data['u_type'] = $user->u_type;
        $data = $this->mainPDF($shg_ids);
        $analysis = shg_analysis($shg_ids);
        $viewData = array_merge($data, $analysis);

        $file_name = $data['profile'][0]->shgName;
        view()->share('res', $viewData);
        $pdf_doc = PDF::loadView('pdf.shg_details_pdf', $viewData)->setPaper('a3', 'landscape');
        return $pdf_doc->stream($file_name . '_' . $data['uin'] . '_' . pdf_date() . '.pdf');
    }

    public function exportshgPDF($shg_ids)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data['u_type'] = $user->u_type;
        $data = $this->mainPDF($shg_ids);
        $analysis = shg_analysis($shg_ids);
        $viewData = array_merge($data, $analysis);
        $file_name = $data['profile'][0]->shgName;
        return view('pdf.TestSHGPdf')->with($viewData);
        // return view('pdf.testPDF')->with($data)->with($analysis);
        // view()->share('res', $data);
        // $pdf_doc = PDF::loadView('pdf.shgDetailscardPdf', $data)->setPaper('a3', 'landscape');
        // return $pdf_doc->stream($file_name . '_' . $data['uin'] . '_' . pdf_date() . '.pdf');
    }

    public function export_shgcardPDF($shg_ids)
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data['u_type'] = $user->u_type;
        $data = $data = $this->mainPDF($shg_ids);
        $analysis = shg_analysis($shg_ids);
        $viewData = array_merge($data, $analysis);
        // prd($data['profile']);
        view()->share('data', $viewData);
        $pdf_doc = PDF::loadView('pdf.shgcardPdf', $viewData)->setPaper('a4', 'landscape');
        return $pdf_doc->stream('Shg_Rating_Card_' . $data['uin'] . '_' . pdf_date() . '.pdf');
    }

    public function check_nrlm_code(Request $request){
        $nrml = $request->get('inputValue');

            $res = DB::table('shg_profile')
            ->where('shg_code', $nrml)
            ->where('is_deleted', 0)
            ->get();

        $total = $res->count();

        echo $total;

    }


    public function getLatLongSHG(Request $request)
    {

        $data = [];
        if ($request->post('filter') == 'Search') {
            $federation = $request->input('federation');
            // prd($federation);
            $dateArr = array('federation' => $federation);
            Session::put('shg_session', $request->all());
            // prd($request->all());
        }
        if (!empty($request->post('filter') == 'clear')) {
            $request->session()->forget('shg_session');
        }


        if ($request->ajax()) {

            $session_data = Session::get('shg_session');
            // prd($session_data);

            $query = " SELECT
            j.shgName,
            j.latitude,
            j.longitude,
            j.location_name,
            j.lat_long_date_time,
            d.agency_name,
            j.id
        FROM
            shg_mst AS i
        INNER JOIN shg_sub_mst AS k
        ON
            k.shg_mst_id = i.id
        INNER JOIN shg_profile AS j
        ON
            j.shg_sub_mst_id = k.id
        LEFT JOIN cluster_mst AS a
        ON
            i.cluster_uin = a.uin
        LEFT JOIN cluster_sub_mst AS m
        ON
            m.cluster_mst_id = a.id
        LEFT JOIN cluster_profile AS b
        ON
            b.cluster_sub_mst_id = m.id
        INNER JOIN federation_mst AS c
        ON
            i.federation_uin = c.uin
        INNER JOIN federation_sub_mst AS n
        ON
            n.federation_mst_id = c.id
        INNER JOIN federation_profile AS h
        ON
            h.federation_sub_mst_id = n.id
        INNER JOIN agency AS d
        ON
            i.agency_id = d.agency_id
        LEFT JOIN countries AS e
        ON
            j.name_of_country = e.id
        LEFT JOIN states AS f
        ON
            j.name_of_state = f.id
        LEFT JOIN district AS g
        ON
            j.name_of_district = g.id

            INNER JOIN (SELECT a.*
                FROM task_assignment AS a
                JOIN (
                    SELECT assignment_id, MAX(updated_at) AS max_updated_at
                    FROM task_assignment
                    WHERE assignment_type = 'SH' AND `status` = 'D'
                    GROUP BY assignment_id
                ) AS b ON a.assignment_id = b.assignment_id AND a.updated_at = b.max_updated_at
                ORDER BY a.updated_at DESC) as ta ON i.id = ta.assignment_id
                LEFT JOIN users as ur
                ON ur.id = ta.user_id

        WHERE
            i.is_deleted = 0 AND j.longitude != '' AND j.latitude != '' ";

            if (!empty($session_data['state'])) {
                if ($session_data['state'] != '' && $session_data['state'] > 0) {
                    $query .= " AND j.state_id = '" . $session_data['state'] . "' ";
                }
            }
            if (!empty($session_data['district'])) {
                if ($session_data['district'] != '' && $session_data['district'] > 0) {
                    $query .= " AND j.district_id = '" . $session_data['district'] . "' ";
                }
            }
            if (!empty($session_data['country'])) {
                if ($session_data['country'] != '' && $session_data['country'] > 0) {
                    $query .= " AND j.country_id = '" . $session_data['country'] . "' ";
                }
            }
            if(empty($session_data['Fac_id'])){
                if (!empty($session_data['agency_id'])) {
                    $text_search = $session_data['agency_id'];
                    $query .= " AND i.agency_id ='" . $session_data['agency_id'] . "' ";
                }
            }
            if (!empty($session_data['Fac_id'])) {
                $text_search = $session_data['Fac_id'];
                $query .= " AND ta.user_id ='" . $session_data['Fac_id'] . "' ";
            }
            // if (!empty($session_data['agency_id'])) {
            //     $text_search = $session_data['agency_id'];
            //     $query .= " AND i.agency_id ='" . $session_data['agency_id'] . "' ";
            // }
            // if (!empty($session_data['shg_id'])) {
            //     $text_search = $session_data['shg_id'];
            //     $query .= " AND i.id ='" . $session_data['shg_id'] . "' ";
            // }
            // if (!empty($session_data['federation_id'])) {
            //     $text_search = $session_data['federation_id'];
            //     $query .= " AND i.id ='" . $session_data['federation_id'] . "' ";
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

        return view('shg.map')->with($data);
    }


    public function mapDatatableSHG(Request $request)
    {

        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
        }
        $data = [];

        if ($request->ajax()) {
            $session_data = Session::get('shg_session');

            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');
            $txt_search = $request->post('search')['value'];

            $query = " SELECT
                    j.*,
                    d.agency_name,
                    e.name AS country_name,
                    f.name AS state_name,
                    g.name AS district_name,
                    i.uin,
                    i.id AS ids,
                    i.created_at as created,
                    i.status,
                    i.federation_uin,
                    i.cluster_uin,
                    i.srlm_code,
                    h.name_of_federation,
                    b.name_of_cluster,
                    k.status AS shg_status,
                    k.analytics,
                    k.rating,
                    k.dm_a,
                    k.qa_a,
                    k.dm_r,
                    k.qa_r,
                    k.updated_at,
                    k.flag,
                    k.locked,
                    k.status_flag
                FROM
                    shg_mst AS i
                INNER JOIN shg_sub_mst AS k
                ON
                    k.shg_mst_id = i.id
                INNER JOIN shg_profile AS j
                ON
                    j.shg_sub_mst_id = k.id
                LEFT JOIN cluster_mst AS a
                ON
                    i.cluster_uin = a.uin
                LEFT JOIN cluster_sub_mst AS m
                ON
                    m.cluster_mst_id = a.id
                LEFT JOIN cluster_profile AS b
                ON
                    b.cluster_sub_mst_id = m.id
                INNER JOIN federation_mst AS c
                ON
                    i.federation_uin = c.uin
                INNER JOIN federation_sub_mst AS n
                ON
                    n.federation_mst_id = c.id
                INNER JOIN federation_profile AS h
                ON
                    h.federation_sub_mst_id = n.id
                INNER JOIN agency AS d
                ON
                    i.agency_id = d.agency_id
                LEFT JOIN countries AS e
                ON
                    j.name_of_country = e.id
                LEFT JOIN states AS f
                ON
                    j.name_of_state = f.id
                LEFT JOIN district AS g
                ON
                    j.name_of_district = g.id";

            if (!empty($session_data['Fac_id'])) {
                if ($session_data['Fac_id'] != '' && $session_data['Fac_id'] > 0) {
                    $query .= " INNER JOIN (SELECT a.*
                    FROM task_assignment AS a
                    JOIN (
                        SELECT assignment_id, MAX(updated_at) AS max_updated_at
                        FROM task_assignment
                        WHERE assignment_type = 'SH' AND `status` = 'D'
                        GROUP BY assignment_id
                    ) AS b ON a.assignment_id = b.assignment_id AND a.updated_at = b.max_updated_at
                    ORDER BY a.updated_at DESC) as ta ON i.id = ta.assignment_id ";
                }
            }
            $query .= " where i.is_deleted = 0  AND j.longitude != '' AND j.latitude != '' ";


            if (!empty($session_data['state'])) {
                if ($session_data['state'] != '' && $session_data['state'] > 0) {
                    $query .= " AND j.state_id = '" . $session_data['state'] . "' ";
                }
            }
            if (!empty($session_data['district'])) {
                if ($session_data['district'] != '' && $session_data['district'] > 0) {
                    $query .= " AND j.district_id = '" . $session_data['district'] . "' ";
                }
            }
            if (!empty($session_data['country'])) {
                if ($session_data['country'] != '' && $session_data['country'] > 0) {
                    $query .= " AND j.country_id = '" . $session_data['country'] . "' ";
                }
            }
            if(empty($session_data['Fac_id'])){
                if (!empty($session_data['agency_id'])) {
                    $text_search = $session_data['agency_id'];
                    $query .= " AND Y.agency_id ='" . $session_data['agency_id'] . "' ";
                }
            }
            if (!empty($session_data['Fac_id'])) {
                $text_search = $session_data['Fac_id'];
                $query .= " AND ta.user_id ='" . $session_data['Fac_id'] . "' ";
            }

            if ($txt_search != '') {
                $query .= " AND (j.shgName like '%$txt_search%' ";
                $query .= " or b.name_of_cluster like '%$txt_search%' ";
                $query .= " or h.name_of_federation like '%$txt_search%' ";
                $query .= " or i.uin like '%$txt_search%' )";
            }
            $shgs = DB::select($query);
            $total = count($shgs);
            $query .= " ORDER BY
                    k.updated_at
                DESC,i.id DESC
                LIMIT $limit OFFSET $start";
            $shgs = DB::select($query);
            foreach ($shgs as $shg) {
                $visit = 'Created';
                if ($shg->dm_a == 'V' && $shg->qa_a == 'V' && $shg->locked == 1) {
                    $visit = 'Locked';
                } elseif ($shg->dm_a == 'V' && $shg->qa_a == 'V') {
                    $visit = 'Initial Rating';
                } elseif ($shg->dm_a == 'V' && $shg->qa_a == 'P') {
                    $visit = 'Analytics Complete';
                } elseif ($shg->dm_a == 'P') {
                    $visit = 'Visit Complete';
                } elseif ($shg->dm_a == 'N' && $shg->flag == 0) {
                    $visit = 'Visit Pending';
                } elseif ($shg->dm_a == 'R' && $shg->flag == 1) {
                    $visit = 'Visit Reassigned';
                }

                $row = [];
                $row[] = ++$start;
                $row[] = $shg->uin;
                $row[] = $shg->shgName;
                $row[] = ($shg->name_of_cluster != '' or $shg->name_of_cluster == 'NULL') ? $shg->name_of_cluster : '-';
                $row[] = $shg->name_of_federation;
                $row[] = $visit;
                $row[] = change_date_month_name_char($shg->created);
                $row[] = change_date_month_name_char($shg->updated_at);
                $row[] = $shg->locked == 1 ? 'Yes' : 'No';


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

        return view('shg.map')->with($data);
    }

}
