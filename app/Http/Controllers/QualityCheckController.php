<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\QualityCheck;
use App\Models\Preanalytics;
use App\Models\FederationSubMst;
use App\Models\ClusterSubMst;
use App\Models\ShgSubMst;
use App\Models\FamilySubMst;
use App\Models\Federation;
use App\Models\Remarks;
use App\Models\SHGRemarks;
use App\Models\FedRemarks;
use App\Models\ClusterRemarks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\Quality_report;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Carbon\Carbon;

class QualityCheckController extends Controller
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
         $total = 0;
         $user = Auth::User();

         if (!empty($request->get('Search'))) {
             Session::put('quality_filter_session', $request->all());
         }
         if (!empty($request->get('clear'))) {
             $request->session()->forget('quality_filter_session');
         }
         $session_data = Session::get('quality_filter_session');

         $data['u_type'] = $user->u_type;
         $u_type = $data['u_type'];
         $data = [];
         $user_geo = DB::table('user_location_relation')
             ->where('user_id', $user->id)
             ->where('is_deleted', '=', 0)
             ->orderBy('country_id')
             ->get()->toArray();
        // prd($user->id);

         $query ="SELECT group_concat(users.id) AS ids FROM users where parent_id = $user->id AND  is_deleted = 0";
         if($user->u_type == 'M'){
         $query .=" AND u_type = 'F'";
         }
         elseif ($user->u_type == 'QA'){
             $query .=" AND u_type = 'M'";
         }
         $fac_list = DB::select($query);

         $list  = $fac_list[0]->ids ?? 0;


         if ($request->ajax()) {
             $status_type = $session_data['type'];
             $start = (int)$request->post('start');
             $limit = (int)$request->post('length');
             $txt_search = $request->get('search')['value'];
             // prd($txt_search);
             // DB::enableQueryLog();
             if (!empty($session_data['group']) && !empty($session_data['type'])) {
                 if ($session_data['group'] == 'ALL') {
                     if ($user->u_type == 'QA') {

                         $query = "SELECT * FROM (SELECT
                             Y.id,
                             Y.user_id,
                             Y.assignment_type,
                             Y.task,
                             Y.task_a1,
                             Y.qa_status,
                             Y.quality_status,
                             Y.manger_date,
                             Y.quality_date,
                             j.name_of_federation as name,
                             e.name as fac_name,
                             i.uin,
                             i.id AS ids,
                             Y.updated_at
                             FROM
                                 task_qa_assignment AS Y
                             INNER JOIN federation_mst AS i
                             ON
                                 i.id = Y.assignment_id
                             INNER JOIN federation_sub_mst AS s
                             ON
                                 i.id = s.federation_mst_id
                             INNER JOIN federation_profile AS j
                             ON
                                 j.federation_sub_mst_id = s.id
                             INNER JOIN agency AS d
                             ON
                                 i.agency_id = d.agency_id
                             INNER JOIN users AS e
                             ON
                                 Y.user_id = e.id
                             WHERE
                                 Y.is_deleted = 0 AND Y.assignment_type = 'FD' AND i.is_deleted=0 ";
                                 if ($txt_search != '') {

                                     $query .= " AND (j.name_of_federation like '%$txt_search%' ";
                                     $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' )";
                                 }
                                 if ($status_type == 'ALL') {
                                     $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V')  ";
                                 }
                                 if ($status_type == 'C') {
                                     $query .= " AND (Y.quality_status = 'V' || Y.quality_status = 'R' ) ";
                                 }
                                 if ($status_type == 'P') {

                                     $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'  ";
                                 }
                                 if(!empty($session_data['Search'])){
                                    if(!empty($session_data['agency'])){
                                        $agency = $session_data['agency'];
                                        $query .=" AND i.agency_id = $agency  ";
                                     }
                                     if(!empty($session_data['federation'])){
                                        $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                                     }


                                    if(!empty($session_data['dm'])){
                                        $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                                      }
                                      else{
                                        $query .= " AND  verified_by IN($list)";
                                      }
                                }

                         // prd($query);
                         $query .= "    UNION ALL
                             SELECT
                                 Y.id,
                                 Y.user_id,
                                 Y.assignment_type,
                                 Y.task,
                                 Y.task_a1,
                                 Y.qa_status,
                                 Y.quality_status,
                                 Y.manger_date,
                                 Y.quality_date,
                                 j.name_of_cluster as name,
                                 e.name as fac_name,
                                 i.uin,
                                 i.id AS ids,
                                 Y.updated_at
                             FROM
                                 task_qa_assignment AS Y
                             INNER JOIN cluster_mst AS i
                             ON
                                 i.id = Y.assignment_id
                             INNER JOIN cluster_sub_mst AS s
                             ON
                                 i.id = s.cluster_mst_id
                             INNER JOIN cluster_profile AS j
                             ON
                                 j.cluster_sub_mst_id = s.id
                             INNER JOIN agency AS d
                             ON
                                 i.agency_id = d.agency_id
                             INNER JOIN users AS e
                             ON
                                 Y.user_id = e.id
                             WHERE
                                 Y.is_deleted = 0 AND Y.assignment_type = 'CL' AND i.is_deleted=0 ";
                                 if ($txt_search != '') {

                                     $query .= " AND (j.name_of_cluster like '%$txt_search%' ";
                                     $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' )";
                                 }
                                 if ($status_type == 'ALL') {
                                     $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V') ";
                                 }
                                 if ($status_type == 'C') {
                                     $query .= " AND (Y.quality_status = 'V' || Y.quality_status = 'R' ) ";
                                 }
                                 if ($status_type == 'P') {

                                     $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P' ";
                                 }
                                 if(!empty($session_data['Search'])){
                                    if(!empty($session_data['agency'])){
                                        $agency = $session_data['agency'];
                                        $query .=" AND i.agency_id = $agency  ";
                                     }

                                     if(!empty($session_data['cluster'])){
                                        $query .=" AND i.uin = '" . $session_data['cluster'] . "' ";
                                     }


                                 if(!empty($session_data['dm'])){
                                        $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                                      }
                                      else{
                                        $query .= " AND  verified_by IN($list)";
                                      }
                                    }
                         $query .= "   UNION ALL
                             SELECT
                                 Y.id,
                                 Y.user_id,
                                 Y.assignment_type,
                                 Y.task,
                                 Y.task_a1,
                                 Y.qa_status,
                                 Y.quality_status,
                                 Y.manger_date,
                                 Y.quality_date,
                                 j.shgName as name,
                                 e.name as fac_name,
                                 i.uin,
                                 i.id AS ids,
                                 Y.updated_at
                             FROM
                                 task_qa_assignment AS Y
                             INNER JOIN shg_mst AS i
                             ON
                                 i.id = Y.assignment_id
                             INNER JOIN shg_sub_mst AS s
                             ON
                                 i.id = s.shg_mst_id
                             INNER JOIN shg_profile AS j
                             ON
                                 j.shg_sub_mst_id = s.id
                             INNER JOIN agency AS d
                             ON
                                 i.agency_id = d.agency_id
                             INNER JOIN users AS e
                             ON
                                 Y.user_id = e.id
                             WHERE
                                 Y.is_deleted = 0 AND Y.assignment_type = 'SH' AND i.is_deleted=0 ";
                                 if ($txt_search != '') {
                                     $query .= " AND (j.shgName like '%$txt_search%' ";
                                     $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' )";
                                 }
                                 if ($status_type == 'ALL') {
                                     $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V') ";
                                 }
                                 if ($status_type == 'C') {
                                     $query .= " AND (Y.quality_status = 'V' || Y.quality_status = 'R' ) ";
                                 }
                                 if ($status_type == 'P') {

                                     $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P' ";
                                 }
                                 if(!empty($session_data['Search'])){
                                    if(!empty($session_data['agency'])){
                                        $agency = $session_data['agency'];
                                        $query .=" AND i.agency_id = $agency  ";
                                     }

                                     if(!empty($session_data['shg'])){
                                        $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                                     }


                                 if(!empty($session_data['dm'])){
                                        $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                                      }
                                      else{
                                        $query .= " AND  verified_by IN($list)";

                                      }
                                    }


                         $query .= " UNION ALL
                                     SELECT
                             a.id ,
                             a.user_id,
                             a.assignment_type,
                             a.task,
                             a.task_a1,
                             a.qa_status,
                             a.quality_status,
                             a.manger_date,
                             a.quality_date,
                             b.fp_member_name as name,
                             c.name as fac_naame,
                             b.uin,
                             b.id AS ids,
                             a.updated_at ";

                         $query .= " FROM
                             (
                             (
                             SELECT
                                 id,
                                 assignment_id,
                                 user_id,
                                 task_a1,
                                 qa_status,
                                 quality_status,
                                 task,
                                 manger_date,
                                 quality_date,assignment_type,
                                 updated_at
                             FROM
                                 task_qa_assignment
                             WHERE
                                 assignment_type = 'FM' AND task_a1 = 'P2' AND is_deleted=0 ";


                         if ($status_type == 'ALL') {
                             $query .= " AND qa_status = 'V' AND (quality_status = 'P' OR quality_status = 'R' OR quality_status = 'V') ";
                         }
                         if ($status_type == 'C') {
                             $query .= "   AND (quality_status = 'R' OR quality_status = 'V') ";
                         }
                         if ($status_type == 'P') {

                             $query .= " AND qa_status = 'V' AND(quality_status = 'P' ) ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['dm'])){
                                $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                              }
                              else{
                                $query .= " AND verified_by in ($list)";
                              }
                          }

                         $query .= "ORDER BY
                         updated_at
                             DESC

                             ) a";
                         $query .= "    INNER JOIN(
                             SELECT
                             a.id,
                             a.uin,
                             c.fp_member_name,
                             f.shgName,
                             g.agency_name
                             FROM
                             family_mst a
                             INNER JOIN family_sub_mst b ON
                             a.id = b.family_mst_id
                             INNER JOIN family_profile c ON
                             b.id = c.family_sub_mst_id
                             INNER JOIN shg_mst d ON
                             a.shg_uin = d.uin
                             INNER JOIN shg_sub_mst e ON
                             d.id = e.shg_mst_id
                             INNER JOIN shg_profile f ON
                             e.id = f.shg_sub_mst_id
                             INNER JOIN agency g ON
                             a.agency_id = g.agency_id
                             WHERE
                             a.is_deleted = 0 AND b.dm_p1 = 'V' AND b.dm_p2 = 'V' ";
                         if ($txt_search != '') {

                             $query .= " AND (c.fp_member_name like '%$txt_search%' ";
                             $query .= " or SUBSTRING(a.uin, LENGTH(a.uin) - 3) LIKE '%$txt_search%' )";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['agency'])){
                                $agency = $session_data['agency'];
                                $query .=" AND a.agency_id = $agency  ";
                             }
                             if(!empty($session_data['family'])){
                                $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                             }
                          }

                         $query .= " ) b
                             ON
                             a.assignment_id = b.id
                             INNER JOIN users c ON
                             a.user_id = c.id
                             )
                             UNION ALL
                             SELECT
                             a.id ,
                             a.user_id,
                             a.assignment_type,
                             a.task,
                             a.task_a1,
                             a.qa_status,
                             a.quality_status,
                             a.manger_date,
                             a.quality_date,
                             b.fp_member_name as name,
                             c.name fac_name,
                             b.uin,
                             b.id AS ids,
                             a.updated_at
                             FROM
                             (
                             (
                             SELECT
                                 id,
                                 assignment_id,
                                 user_id,
                                 task_a1,
                                 qa_status,
                                 quality_status,
                                 task,
                                 manger_date,
                                 quality_date,
                                 assignment_type,
                                 updated_at
                             FROM
                                 task_qa_assignment
                             WHERE
                                 assignment_type = 'FM'  AND task = 'R' AND is_deleted=0 ";

                         if ($status_type == 'ALL') {
                             $query .= " AND qa_status = 'V' AND (quality_status = 'P' OR quality_status = 'R' OR quality_status = 'V') ";
                         }
                         if ($status_type == 'C') {
                             $query .= "   AND (quality_status = 'R' OR quality_status = 'V') ";
                         }
                         if ($status_type == 'P') {

                             $query .= " AND qa_status = 'V' AND(quality_status = 'P' ) ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['dm'])){
                                $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                              }
                              else{
                                $query .= " AND verified_by in ($list)";
                              }
                          }

                         $query .= "    ORDER BY
                         updated_at
                             DESC

                             ) a
                             INNER JOIN(
                             SELECT
                             a.id,
                             a.uin,
                             c.fp_member_name,
                             f.shgName,
                             g.agency_name
                             FROM
                             family_mst a
                             INNER JOIN family_sub_mst b ON
                             a.id = b.family_mst_id
                             INNER JOIN family_profile c ON
                             b.id = c.family_sub_mst_id
                             INNER JOIN shg_mst d ON
                             a.shg_uin = d.uin
                             INNER JOIN shg_sub_mst e ON
                             d.id = e.shg_mst_id
                             INNER JOIN shg_profile f ON
                             e.id = f.shg_sub_mst_id
                             INNER JOIN agency g ON
                             a.agency_id = g.agency_id
                             WHERE
                             a.is_deleted = 0";
                             if ($txt_search != '') {
                                $query .= " AND (c.fp_member_name like '%$txt_search%' ";
                                $query .= " or SUBSTRING(a.uin, LENGTH(a.uin) - 3) LIKE '%$txt_search%' )";
                            }

                     if ($status_type == 'ALL') {
                         $query .= "  AND b.dm_r = 'V'  AND (
                              (b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' ) OR(b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' )
                         )";
                     }
                     if ($status_type == 'P') {
                         $query .= " AND b.qa_r = 'P'";
                     }
                     if ($status_type == 'C') {
                         $query .= " AND b.qa_p2 = 'V' AND (b.qa_r = 'V' OR b.qa_r = 'R' )";
                     }
                     if(!empty($session_data['Search'])){
                        if(!empty($session_data['agency'])){
                            $agency = $session_data['agency'];
                            $query .=" AND a.agency_id = $agency  ";
                         }

                         if(!empty($session_data['family'])){
                            $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                         }
                      }
                     $query .= "
                    ) b
                    ON
                    a.assignment_id=b.id INNER JOIN users c on a.user_id=c.id)
                    )a ";

                        //      date_default_timezone_set("Asia/Calcutta");
                        //  prd(date('Y-m-d H:i:s'));

                     } else {
                         $query = " SELECT * FROM (SELECT
                            Y.id ,
                            Y.user_id,
                            Y.dm_id,
                            Y.assignment_type,
                            Y.task,
                            Y.task_a1,
                            Y.qa_status,
                            Y.quality_status,
                            Y.manger_date,
                            Y.quality_date,
                            j.name_of_federation as name,
                            e.name as fac_name,
                            i.uin,
                            i.id AS ids,
                            Y.updated_at
                             FROM
                                 task_qa_assignment AS Y
                             INNER JOIN federation_mst AS i
                             ON
                                 i.id = Y.assignment_id
                             INNER JOIN federation_sub_mst AS s
                             ON
                                 i.id = s.federation_mst_id
                             INNER JOIN federation_profile AS j
                             ON
                                 j.federation_sub_mst_id = s.id
                             INNER JOIN agency AS d
                             ON
                                 i.agency_id = d.agency_id
                             INNER JOIN users AS e
                             ON
                                 Y.user_id = e.id
                             WHERE
                                 Y.is_deleted = 0 AND Y.assignment_type = 'FD' AND i.is_deleted=0 ";

                         if ($txt_search != '') {
                             $query .= " AND (j.name_of_federation like '%$txt_search%' ";
                             $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' )";
                         }
                         if ($user->u_type == 'M') {
                             if ($status_type == 'P') {
                                 $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                             }
                             if ($status_type == 'C') {
                                 $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V')) ";
                             }
                             if(!empty($session_data['Search'])){
                                if(!empty($session_data['agency'])){
                                    $agency = $session_data['agency'];
                                    $query .=" AND i.agency_id = $agency  ";
                                 }
                                 if(!empty($session_data['federation'])){
                                    $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                                 }

                              }
                              if(!empty($session_data['facilitator'])){
                                $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                              }
                              else{
                                $query .= " AND Y.user_id in ($list)";
                              }

                            //  $query .= " AND Y.dm_id in ($user->id)";
                         }

                         if ($user->u_type == 'CEO' || $user->u_type == 'A') {
                             if ($status_type == 'ALL') {
                                 $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                             }

                             if ($status_type == 'P') {

                                 $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                             }
                             if ($status_type == 'C') {
                                 $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                             }
                         }

                         // prd($query);
                         $query .= " UNION ALL
                             SELECT
                                 Y.id,
                                 Y.user_id,
                                 Y.dm_id,
                                 Y.assignment_type,
                                 Y.task,
                                 Y.task_a1,
                                 Y.qa_status,
                                 Y.quality_status,
                                 Y.manger_date,
                                 Y.quality_date,
                                 j.name_of_cluster as name,
                                 e.name as fac_name,
                                 i.uin,
                                 i.id AS ids,
                                 Y.updated_at
                             FROM
                                 task_qa_assignment AS Y
                             INNER JOIN cluster_mst AS i
                             ON
                                 i.id = Y.assignment_id
                             INNER JOIN cluster_sub_mst AS s
                             ON
                                 i.id = s.cluster_mst_id
                             INNER JOIN cluster_profile AS j
                             ON
                                 j.cluster_sub_mst_id = s.id
                             INNER JOIN agency AS d
                             ON
                                 i.agency_id = d.agency_id
                             INNER JOIN users AS e
                             ON
                                 Y.user_id = e.id
                             WHERE
                                 Y.is_deleted = 0 AND Y.assignment_type = 'CL' AND i.is_deleted=0 ";

                         if ($txt_search != '') {
                             $query .= " AND (j.name_of_cluster like '%$txt_search%' ";
                             $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' )";
                         }
                         if ($user->u_type == 'M') {
                             if ($status_type == 'P') {
                                 $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                             }
                             if ($status_type == 'C') {
                                 $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                             }
                             if(!empty($session_data['Search'])){
                                if(!empty($session_data['agency'])){
                                    $agency = $session_data['agency'];
                                    $query .=" AND i.agency_id = $agency  ";
                                 }
                                 if(!empty($session_data['cluster'])){
                                    $query .=" AND i.uin = '" . $session_data['cluster'] . "' ";
                                 }

                              }
                              if(!empty($session_data['facilitator'])){
                                $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                              }
                              else{
                                $query .= " AND Y.user_id in ($list)";
                              }
                            // $query .= " AND Y.dm_id in ($user->id)";

                         }

                         if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                 $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                             }
                             if ($status_type == 'P') {
                                 $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                             }
                             if ($status_type == 'C') {
                                 $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                             }
                         }
                         // prd($query);
                         $query .= "UNION ALL
                             SELECT
                                 Y.id ,
                                 Y.user_id,
                                 Y.dm_id,
                                 Y.assignment_type,
                                 Y.task,
                                 Y.task_a1,
                                 Y.qa_status,
                                 Y.quality_status,
                                 Y.manger_date,
                                 Y.quality_date,
                                 j.shgName as name,
                                 e.name fac_name,
                                 i.uin,
                                 i.id AS ids,
                                 Y.updated_at
                             FROM
                                 task_qa_assignment AS Y
                             INNER JOIN shg_mst AS i
                             ON
                                 i.id = Y.assignment_id
                             INNER JOIN shg_sub_mst AS s
                             ON
                                 i.id = s.shg_mst_id
                             INNER JOIN shg_profile AS j
                             ON
                                 j.shg_sub_mst_id = s.id
                             INNER JOIN agency AS d
                             ON
                                 i.agency_id = d.agency_id
                             INNER JOIN users AS e
                             ON
                                 Y.user_id = e.id
                             WHERE
                                 Y.is_deleted = 0 AND Y.assignment_type = 'SH' AND i.is_deleted=0 ";

                         if ($txt_search != '') {
                             $query .= " AND (j.shgName like '%$txt_search%' ";
                             $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' )";
                         }
                         if ($user->u_type == 'M') {
                             if ($status_type == 'P') {
                                 $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                             }
                             if ($status_type == 'C') {
                                 $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                             }
                             if(!empty($session_data['Search'])){
                                if(!empty($session_data['agency'])){
                                    $agency = $session_data['agency'];
                                    $query .=" AND i.agency_id = $agency  ";
                                 }
                                 if(!empty($session_data['shg'])){
                                    $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                                 }

                              }
                              if(!empty($session_data['facilitator'])){
                                $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                              }
                              else{
                                $query .= " AND Y.user_id in ($list)";
                              }
                            //  $query .= " AND Y.dm_id in ($user->id)";

                         }

                         if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                 $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                             }
                             if ($status_type == 'P') {
                                 $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                             }
                             if ($status_type == 'C') {
                                 $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                             }
                         }

                         $query .= " UNION ALL
                                 SELECT
                                     Y.id ,
                                     Y.user_id,
                                     Y.dm_id,
                                     Y.assignment_type,
                                     Y.task,
                                     Y.task_a1,
                                     Y.qa_status,
                                     Y.quality_status,
                                     Y.manger_date,
                                     Y.quality_date,
                                     j.fp_member_name as name,
                                     e.name as fac_name,
                                     i.uin,
                                     i.id AS ids,
                                     Y.updated_at
                             FROM
                                 task_qa_assignment AS Y
                             INNER JOIN family_mst AS i
                             ON
                                 i.id = Y.assignment_id
                             INNER JOIN family_sub_mst AS s
                             ON
                                 i.id = s.family_mst_id
                             INNER JOIN family_profile AS j
                             ON
                                 j.family_sub_mst_id = s.id
                             INNER JOIN agency AS d
                             ON
                                 i.agency_id = d.agency_id
                             INNER JOIN users AS e
                             ON
                                 Y.user_id = e.id
                             WHERE
                                 Y.is_deleted = 0 AND Y.assignment_type = 'FM' AND i.is_deleted=0 ";

                         if ($txt_search != '') {
                             $query .= " AND (j.fp_member_name like '%$txt_search%' ";
                             $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' )";
                         }
                         if ($user->u_type == 'M') {
                             if ($status_type == 'P') {
                                 $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                             }
                             if ($status_type == 'C') {
                                 $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                             }
                             if(!empty($session_data['Search'])){
                                if(!empty($session_data['agency'])){
                                    $agency = $session_data['agency'];
                                    $query .=" AND i.agency_id = $agency  ";
                                 }
                                 if(!empty($session_data['family'])){
                                    $query .=" AND i.uin = '" . $session_data['family'] . "' ";
                                 }
                              }
                              if(!empty($session_data['facilitator'])){
                                $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                              }
                              else{
                                $query .= " AND Y.user_id in ($list)";
                              }
                            //  $query .= " AND Y.dm_id in ($user->id)";

                         }

                         if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                 $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                             }
                             if ($status_type == 'P') {
                                 $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                             }
                             if ($status_type == 'C') {
                                 $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                             }
                         }
                         // prd($query);
                         $query .= ")a ORDER BY a.updated_at DESC ";
                     }
                 }
                 if ($session_data['group'] == 'FM') {
                     if ($user->u_type == 'QA') {

                         $query = "
                        SELECT
                            *
                        FROM
                            (
                            SELECT
                                a.id,
                                a.user_id,
                                a.task_a1,
                                a.assignment_type,
                                a.qa_status,
                                a.quality_status,
                                a.task,
                                a.manger_date,
                                a.quality_date,
                                b.id AS ids,
                                b.uin,
                                b.fp_member_name AS name,
                                b.shgName,
                                b.agency_name,
                                c.name as fac_name,
                                a.updated_at,
                                b.family_buisness
                            FROM
                             (
                                 (
                                 SELECT
                                     id,
                                     assignment_id,
                                     assignment_type,
                                     user_id,
                                     task_a1,
                                     qa_status,
                                     quality_status,
                                     task,
                                     manger_date,
                                     quality_date,
                                     updated_at
                                 FROM
                                     task_qa_assignment
                                 WHERE
                                     assignment_type = 'FM' AND task_a1 = 'P2' AND is_deleted=0 ";
                         if ($status_type == 'ALL') {
                             $query .= " AND qa_status = 'V' AND(quality_status = 'R' OR quality_status = 'P' OR quality_status = 'V' ) ";
                         }
                         if ($status_type == 'P') {
                             $query .= " AND qa_status = 'V' AND quality_status = 'P' ";
                         }
                         if ($status_type == 'C') {
                             $query .= " AND qa_status = 'V' AND(quality_status = 'R'  OR quality_status = 'V' ) ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['dm'])){
                                $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                              }
                              else{
                                $query .= " AND verified_by in ($list)";
                              }
                          }

                         $query .= "
                                 ORDER BY
                                     id
                                 DESC
                             ) a
                         INNER JOIN(
                             SELECT
                                 a.id,
                                 a.uin,
                                 c.fp_member_name,
                                 f.shgName,
                                 g.agency_name,
                                 b.family_buisness
                             FROM
                                 family_mst a
                             INNER JOIN family_sub_mst b ON
                                 a.id = b.family_mst_id
                             INNER JOIN family_profile c ON
                                 b.id = c.family_sub_mst_id
                             INNER JOIN shg_mst d ON
                                 a.shg_uin = d.uin
                             INNER JOIN shg_sub_mst e ON
                                 d.id = e.shg_mst_id
                             INNER JOIN shg_profile f ON
                                 e.id = f.shg_sub_mst_id
                             LEFT JOIN cluster_mst AS cl ON
                                 cl.uin = a.cluster_uin
                             INNER JOIN federation_mst AS fd ON
                               fd.uin = a.federation_uin
                             INNER JOIN agency g ON
                                 a.agency_id = g.agency_id
                             WHERE
                                 a.is_deleted = 0";
                                 if ($txt_search != '') {
                                    $query .= " AND (c.fp_member_name like '%$txt_search%' ";
                                    $query .= " or SUBSTRING(a.uin, LENGTH(a.uin) - 3) LIKE '%$txt_search%' )";
                                }


                         if ($status_type == 'ALL') {
                             $query .= " AND  b.dm_p1 = 'V' AND b.dm_p2 = 'V' AND(
                                     (  b.qa_p2 = 'P' OR b.qa_p2 = 'R' OR b.qa_p2 = 'V' OR b.qa_r = 'V' OR b.qa_r = 'V'  )
                                 )
                                 ";
                         }
                         if ($status_type == 'P') {
                             $query .= " AND  b.dm_p1 = 'V' AND b.dm_p2 = 'V' AND  b.qa_p2 = 'P' ";
                         }
                         if ($status_type == 'C') {
                             $query .= " AND  b.dm_p1 = 'V' AND b.dm_p2 = 'V' AND  (b.qa_p2 = 'V' OR b.qa_p2 = 'R') ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['agency'])){
                                $agency = $session_data['agency'];
                                $query .=" AND a.agency_id = $agency  ";
                             }
                             if(!empty($session_data['federation'])){
                                $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                             }
                             if(!empty($session_data['cluster'])){
                                $query .=" AND cl.uin = '" . $session_data['cluster'] . "' ";
                             }
                             if(!empty($session_data['shg'])){
                                $query .=" AND d.uin = '" . $session_data['shg'] . "' ";
                             }
                             if(!empty($session_data['family'])){
                                $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                             }
                          }
                         $query .= "
                         ) b
                        ON
                            a.assignment_id = b.id
                        INNER JOIN users c ON
                            a.user_id = c.id
                                )
                            UNION ALL
                            SELECT
                            c.id,
                            c.user_id,
                            c.task_a1,
                            c.assignment_type,
                            c.qa_status,
                            c.quality_status,
                            c.task,
                            c.manger_date,
                            c.quality_date,
                            d.id AS ids,
                            d.uin,
                            d.fp_member_name AS NAME,
                            d.shgName,
                            d.agency_name,
                            u.name AS fac_name,
                            c.updated_at,
                            d.family_buisness
                        FROM
                            (
                                (
                                SELECT
                                    id,
                                    assignment_id,
                                    assignment_type,
                                    user_id,
                                    task_a1,
                                    qa_status,
                                    quality_status,
                                    task,
                                    manger_date,
                                    quality_date,
                                    updated_at
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'FM' AND task_a1 = 'P1' AND is_deleted = 0 ";
                                    if ($status_type == 'ALL') {
                             $query .= " AND qa_status = 'V' AND(quality_status = 'R' OR quality_status = 'P' OR quality_status = 'V' ) ";
                         }
                         if ($status_type == 'P') {
                             $query .= " AND qa_status = 'V' AND quality_status = 'P' ";
                         }
                         if ($status_type == 'C') {
                             $query .= " AND qa_status = 'V' AND(quality_status = 'R'  OR quality_status = 'V' ) ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['dm'])){
                                $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                              }
                              else{
                                $query .= " AND verified_by in ($list)";
                              }
                          }

                        $query .="        ORDER BY
                                    id
                                DESC
                            ) c
                        INNER JOIN(
                            SELECT
                                a.id,
                                a.uin,
                                c.fp_member_name,
                                f.shgName,
                                g.agency_name,
                                b.family_buisness
                            FROM
                                family_mst a
                            INNER JOIN family_sub_mst b ON
                                a.id = b.family_mst_id
                            INNER JOIN family_profile c ON
                                b.id = c.family_sub_mst_id
                            INNER JOIN shg_mst d ON
                                a.shg_uin = d.uin
                            INNER JOIN shg_sub_mst e ON
                                d.id = e.shg_mst_id
                            INNER JOIN shg_profile f ON
                                e.id = f.shg_sub_mst_id
                            LEFT JOIN cluster_mst AS cl
                            ON
                                cl.uin = a.cluster_uin
                            INNER JOIN federation_mst AS fd
                            ON
                                fd.uin = a.federation_uin
                            INNER JOIN agency g ON
                                a.agency_id = g.agency_id
                            WHERE
                                a.is_deleted = 0 AND b.dm_p1 = 'V'  AND b.qa_p1 = 'P' AND b.family_flag = 1 AND b.family_buisness = 0 ";
                        if ($txt_search != '') {
                            $query .= " AND (c.fp_member_name like '%$txt_search%' ";
                            $query .= " or SUBSTRING(a.uin, LENGTH(a.uin) - 3) LIKE '%$txt_search%' )";
                        }


                         if ($status_type == 'ALL') {
                             $query .= " AND  b.dm_p1 = 'V'  AND(
                                     (  b.qa_p1 = 'P' OR b.qa_p1 = 'R'  OR b.qa_r = 'V' OR b.qa_r = 'R'  )
                                 )
                                 ";
                         }
                         if ($status_type == 'P') {
                             $query .= " AND  b.dm_p1 = 'V'  AND  b.qa_p1 = 'P' ";
                         }
                         if ($status_type == 'C') {
                             $query .= " AND  b.dm_p1 = 'V'  AND  (b.qa_p1 = 'V' OR b.qa_p2 = 'R') ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['agency'])){
                                $agency = $session_data['agency'];
                                $query .=" AND a.agency_id = $agency  ";
                             }
                             if(!empty($session_data['federation'])){
                                $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                             }
                             if(!empty($session_data['cluster'])){
                                $query .=" AND cl.uin = '" . $session_data['cluster'] . "' ";
                             }
                             if(!empty($session_data['shg'])){
                                $query .=" AND d.uin = '" . $session_data['shg'] . "' ";
                             }
                             if(!empty($session_data['family'])){
                                $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                             }
                          }
                      $query .="  ) d
                    ON
                        c.assignment_id = d.id
                    INNER JOIN users u ON
                        c.user_id = u.id
                            )
                            UNION ALL
                        SELECT
                            a.id,
                            a.user_id,
                            a.task_a1,
                            a.assignment_type,
                            a.qa_status,
                            a.quality_status,
                            a.task,
                            a.manger_date,
                            a.quality_date,
                            b.id AS ids,
                            b.uin,
                            b.fp_member_name AS name,
                            b.shgName,
                            b.agency_name,
                            c.name as fac_name,
                            a.updated_at,
                            b.family_buisness
                        FROM
                         (
                             (
                             SELECT
                                 id,
                                 assignment_id,
                                 assignment_type,
                                 user_id,
                                 task_a1,
                                 qa_status,
                                 quality_status,
                                 task,
                                 manger_date,
                                 quality_date,
                                 updated_at
                             FROM
                                 task_qa_assignment
                             WHERE
                                 assignment_type = 'FM' AND task = 'R' AND is_deleted=0 ";


                         if ($status_type == 'ALL') {
                             $query .= "    AND qa_status = 'V'  AND(quality_status = 'R' OR quality_status = 'P' OR quality_status = 'V' ) ";
                         }
                         if ($status_type == 'P') {
                             $query .= "    AND qa_status = 'V' AND quality_status = 'P' ";
                         }
                         if ($status_type == 'C') {
                             $query .= "    AND qa_status = 'V'  AND(quality_status = 'R'  OR quality_status = 'V' ) ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['dm'])){
                                $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                              }
                              else{
                                $query .= " AND verified_by in ($list)";
                              }
                          }
                         $query .= "
                             ORDER BY
                                 id
                             DESC
                         ) a
                        INNER JOIN(
                            SELECT
                                a.id,
                                a.uin,
                                c.fp_member_name,
                                f.shgName,
                                g.agency_name,
                                b.family_buisness
                            FROM
                                family_mst a
                            INNER JOIN family_sub_mst b ON
                                a.id = b.family_mst_id
                            INNER JOIN family_profile c ON
                                b.id = c.family_sub_mst_id
                            INNER JOIN shg_mst d ON
                                a.shg_uin = d.uin
                            INNER JOIN shg_sub_mst e ON
                                d.id = e.shg_mst_id
                            INNER JOIN shg_profile f ON
                                e.id = f.shg_sub_mst_id
                            LEFT JOIN cluster_mst AS cl ON
                                 cl.uin = a.cluster_uin
                            INNER JOIN federation_mst AS fd ON
                               fd.uin = a.federation_uin
                            INNER JOIN agency g ON
                                a.agency_id = g.agency_id
                            WHERE
                                a.is_deleted = 0 ";
                                if ($txt_search != '') {
                                    $query .= " AND (c.fp_member_name like '%$txt_search%' ";
                                    $query .= " or SUBSTRING(a.uin, LENGTH(a.uin) - 3) LIKE '%$txt_search%' )";
                                }

                         if ($status_type == 'ALL') {
                             $query .= " AND b.qa_p2 = 'V'  AND (
                                  (b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' ) OR(b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' )
                             )";
                         }
                         if ($status_type == 'P') {
                             $query .= " AND b.qa_p2 = 'V'  AND b.qa_r = 'P'";
                         }
                         if ($status_type == 'C') {
                             $query .= " AND b.qa_p2 = 'V' AND (b.qa_r = 'V' OR b.qa_r = 'R' )";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['agency'])){
                                $agency = $session_data['agency'];
                                $query .=" AND a.agency_id = $agency  ";
                             }
                             if(!empty($session_data['federation'])){
                                $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                             }
                             if(!empty($session_data['cluster'])){
                                $query .=" AND cl.uin = '" . $session_data['cluster'] . "' ";
                             }
                             if(!empty($session_data['shg'])){
                                $query .=" AND d.uin = '" . $session_data['shg'] . "' ";
                             }
                             if(!empty($session_data['family'])){
                                $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                             }
                          }
                         $query .= "
                        ) b
                        ON
                        a.assignment_id=b.id INNER JOIN users c on a.user_id=c.id)
                        UNION ALL
                        SELECT
                        c.id,
                        c.user_id,
                        c.task_a1,
                        c.assignment_type,
                        c.qa_status,
                        c.quality_status,
                        c.task,
                        c.manger_date,
                        c.quality_date,
                        d.id AS ids,
                        d.uin,
                        d.fp_member_name AS NAME,
                        d.shgName,
                        d.agency_name,
                        u.name AS fac_name,
                        c.updated_at,
                        d.family_buisness
                    FROM
                        (
                            (
                            SELECT
                                id,
                                assignment_id,
                                assignment_type,
                                user_id,
                                task_a1,
                                qa_status,
                                quality_status,
                                task,
                                manger_date,
                                quality_date,
                                updated_at
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM' AND task_a1 = 'P1'   AND is_deleted = 0 AND qa_status = 'V' AND quality_status = 'P' AND verified_by IN($list)  AND assignment_id NOT IN (
                                SELECT distinct(assignment_id) FROM task_qa_assignment
                                WHERE task_a1 = 'P2' AND quality_status ='P' ORDER BY assignment_id DESC
                            )
                            ORDER BY
                                id
                            DESC
                        ) c
                    INNER JOIN(
                        SELECT
                            a.id,
                            a.uin,
                            c.fp_member_name,
                            f.shgName,
                            g.agency_name,
                            b.family_buisness
                        FROM
                            family_mst a
                        INNER JOIN family_sub_mst b ON
                            a.id = b.family_mst_id
                        INNER JOIN family_profile c ON
                            b.id = c.family_sub_mst_id
                        INNER JOIN shg_mst d ON
                            a.shg_uin = d.uin
                        INNER JOIN shg_sub_mst e ON
                            d.id = e.shg_mst_id
                        INNER JOIN shg_profile f ON
                            e.id = f.shg_sub_mst_id
                        LEFT JOIN cluster_mst AS cl
                        ON
                            cl.uin = a.cluster_uin
                        INNER JOIN federation_mst AS fd
                        ON
                            fd.uin = a.federation_uin
                        INNER JOIN agency g ON
                            a.agency_id = g.agency_id
                        WHERE
                            a.is_deleted = 0 AND b.dm_p1 = 'V' AND b.qa_p1 = 'P' AND b.family_flag = 1 AND b.family_buisness = 1 AND b.dm_p1 = 'V' AND b.qa_p1 = 'P'
                    ) d
                    ON
                        c.assignment_id = d.id
                    INNER JOIN users u ON
                        c.user_id = u.id
                        )
                        )a ";
                    //    prd($query);
                     } else {
                         $query = "SELECT
                         Y.*,
                         d.agency_name,
                         j.shgName,
                         e.name as fac_name,
                         k.uin,
                         l.fp_member_name as name,
                         k.id AS ids
                     FROM
                         task_qa_assignment AS Y
                     INNER JOIN family_mst AS k
                     ON
                         k.id = Y.assignment_id
                     INNER JOIN family_sub_mst AS z
                     ON
                         z.family_mst_id = k.id
                     INNER JOIN family_profile AS l
                     ON
                         l.family_sub_mst_id = z.id
                     INNER JOIN shg_mst AS i
                     ON
                         i.uin = k.shg_uin
                     INNER JOIN shg_sub_mst AS ii
                     ON
                         i.id = ii.shg_mst_id
                     INNER JOIN shg_profile AS j
                     ON
                         j.shg_sub_mst_id = ii.id

                    LEFT JOIN cluster_mst AS c
                     ON
                         c.uin = k.cluster_uin


                    INNER JOIN federation_mst AS fd
                     ON
                         fd.uin = k.federation_uin


                     INNER JOIN agency AS d
                     ON
                         k.agency_id = d.agency_id
                     INNER JOIN users AS e
                     ON
                         Y.user_id = e.id
                     WHERE
                         Y.is_deleted = 0 AND Y.assignment_type = 'FM' AND k.is_deleted=0 ";
                         if ($txt_search != '') {
                             $query .= " AND (l.fp_member_name like '%$txt_search%' ";
                             $query .= " or SUBSTRING(k.uin, LENGTH(k.uin) - 3) LIKE '%$txt_search%' )";
                         }
                         if ($user->u_type == 'M') {
                             if ($status_type == 'C') {
                                 $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                             }
                             if ($status_type == 'P') {
                                 $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                             }
                             if(!empty($session_data['Search'])){
                                if(!empty($session_data['agency'])){
                                    $agency = $session_data['agency'];
                                    $query .=" AND k.agency_id = $agency  ";
                                 }
                                 if(!empty($session_data['federation'])){
                                    $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                                 }
                                 if(!empty($session_data['cluster'])){
                                    $query .=" AND c.uin = '" . $session_data['cluster'] . "' ";
                                 }
                                 if(!empty($session_data['shg'])){
                                    $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                                 }
                                 if(!empty($session_data['family'])){
                                    $query .=" AND k.uin = '" . $session_data['family'] . "' ";
                                 }
                              }
                             if(!empty($session_data['facilitator'])){
                                $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                              }
                              else{
                                $query .= " AND Y.user_id in ($list)";
                              }
                            //  $query .= " AND Y.dm_id in ($user->id)";

                         }

                         if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                 $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                             }
                             if ($status_type == 'P') {
                                 $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                             }
                             if ($status_type == 'C') {
                                 $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R') AND (Y.quality_status = 'V' OR Y.quality_status = 'R')";
                             }
                         }
                         $query .= " ORDER BY
                         Y.updated_at
                     DESC ";
                     }
                 }
                 if ($session_data['group'] == 'SH') {
                     $query = "SELECT
                         Y.*,
                         d.agency_name,
                         j.shgName as name,
                         e.name as fac_name,
                         i.uin,
                         l.name_of_cluster ,
                         i.id AS ids
                     FROM
                         task_qa_assignment AS Y
                     INNER JOIN shg_mst AS i
                     ON
                         i.id = Y.assignment_id
                     INNER JOIN shg_sub_mst AS s
                     ON
                         s.shg_mst_id = i.id
                     INNER JOIN shg_profile AS j
                     ON
                         j.shg_sub_mst_id = s.id
                     LEFT JOIN cluster_mst AS k
                     ON
                         k.uin = i.cluster_uin
                     LEFT JOIN cluster_sub_mst AS m
                     ON
                         k.id = m.cluster_mst_id
                     LEFT JOIN cluster_profile AS l
                     ON
                         l.cluster_sub_mst_id = m.id
                    LEFT JOIN federation_mst AS fd
                     ON
                         fd.uin = i.federation_uin
                     LEFT JOIN federation_sub_mst AS fed
                     ON
                         fd.id = fed.federation_mst_id
                     INNER JOIN agency AS d
                     ON
                         i.agency_id = d.agency_id
                     INNER JOIN users AS e
                     ON
                         Y.user_id = e.id
                     WHERE
                         Y.is_deleted = 0 AND Y.assignment_type = 'SH' AND i.is_deleted=0 ";
                     if ($txt_search != '') {
                         $query .= " AND (j.shgName like '%$txt_search%' ";
                         $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' )";
                     }
                     if ($user->u_type == 'M') {
                         if ($status_type == 'C') {
                             $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                         }
                         if ($status_type == 'P') {
                             $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['agency'])){
                                $agency = $session_data['agency'];
                                $query .=" AND i.agency_id = $agency  ";
                             }
                             if(!empty($session_data['federation'])){
                                $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                             }
                             if(!empty($session_data['cluster'])){
                                $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                             }
                             if(!empty($session_data['shg'])){
                                $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                             }


                         if(!empty($session_data['facilitator'])){
                                $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                              }
                              else{
                                $query .= " AND Y.user_id in ($list)";
                              }
                            }
                        //  $query .= " AND Y.dm_id in ($user->id)";

                     }
                     if ($user->u_type == 'QA') {
                         if ($status_type == 'ALL') {
                             $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V' ) ";
                         }
                         if ($status_type == 'P') {
                             $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                         }
                         if ($status_type == 'C') {
                             $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'V' OR Y.quality_status = 'R')  ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['agency'])){
                                $agency = $session_data['agency'];
                                $query .=" AND i.agency_id = $agency  ";
                             }
                             if(!empty($session_data['federation'])){
                                $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                             }
                             if(!empty($session_data['cluster'])){
                                $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                             }
                             if(!empty($session_data['shg'])){
                                $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                             }


                         if(!empty($session_data['dm'])){
                                $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                              }
                              else{
                                $query .= " AND  verified_by IN($list)";

                              }
                            }

                     }
                     if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                             $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                         }
                         if ($status_type == 'P') {
                             $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                         }
                         if ($status_type == 'C') {
                             $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R') AND (Y.quality_status = 'V' OR Y.quality_status = 'R')";
                         }
                     }
                     $query .= " ORDER BY
                         Y.updated_at
                     DESC ";
                 }
                 if ($session_data['group'] == 'CL') {
                     $query = "SELECT
                     Y.*,
                     d.agency_name,
                     j.name_of_federation,
                     e.name as fac_name,
                     k.uin,
                     l.name_of_cluster as name,
                     k.id AS ids
                     FROM
                         task_qa_assignment AS Y
                     INNER JOIN cluster_mst AS k
                     ON
                         k.id = Y.assignment_id
                     INNER JOIN cluster_sub_mst AS m
                     ON
                         k.id = m.cluster_mst_id
                     INNER JOIN cluster_profile AS l
                     ON
                         l.cluster_sub_mst_id = m.id
                     INNER JOIN federation_mst AS i
                     ON
                         i.uin = k.federation_uin
                     INNER JOIN federation_sub_mst AS sb
                     ON
                         sb.federation_mst_id = i.id
                     left  JOIN federation_profile AS j
                     ON
                         j.federation_sub_mst_id = sb.federation_mst_id
                     INNER JOIN agency AS d
                     ON
                         k.agency_id = d.agency_id
                     INNER JOIN users AS e
                     ON
                         Y.user_id = e.id
                     WHERE
                         Y.is_deleted = 0 AND assignment_type = 'CL' AND k.is_deleted=0 ";

                     if ($txt_search != '') {
                         $query .= " AND (l.name_of_cluster like '%$txt_search%' ";
                         $query .= " or SUBSTRING(k.uin, LENGTH(k.uin) - 3) LIKE '%$txt_search%' )";
                     }
                     if ($user->u_type == 'M') {
                         if ($status_type == 'C') {
                             $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                         }
                         if ($status_type == 'P') {
                             $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['agency'])){
                                $agency = $session_data['agency'];
                                $query .=" AND k.agency_id = $agency  ";
                             }
                             if(!empty($session_data['federation'])){
                                $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                             }
                             if(!empty($session_data['cluster'])){
                                $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                             }


                            if(!empty($session_data['facilitator'])){
                                $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                              }
                              else{
                                $query .= " AND Y.user_id in ($list)";
                              }
                        }
                        //  $query .= " AND Y.dm_id in ($user->id)";

                     }
                     if ($user->u_type == 'QA') {
                         if ($status_type == 'ALL') {
                             $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V' ) ";
                         }
                         if ($status_type == 'P') {
                             $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'  ";
                         }
                         if ($status_type == 'C') {
                             $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'V' OR Y.quality_status = 'R')  ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['agency'])){
                                $agency = $session_data['agency'];
                                $query .=" AND k.agency_id = $agency  ";
                             }
                             if(!empty($session_data['federation'])){
                                $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                             }
                             if(!empty($session_data['cluster'])){
                                $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                             }


                         if(!empty($session_data['dm'])){
                                $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                              }
                              else{
                                $query .= " AND  verified_by IN($list)";
                              }
                            }

                     }
                     if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                             $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                         }
                         if ($status_type == 'P') {
                             $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                         }
                         if ($status_type == 'C') {
                             $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R') AND (Y.quality_status = 'V' OR Y.quality_status = 'R')";
                         }
                     }
                     $query .= " ORDER BY
                         Y.updated_at
                     DESC ";
                 }
                 if ($session_data['group'] == 'FD') {
                     $query = " SELECT
                             Y.*,
                             d.agency_name,
                             d.agency_id,
                             j.name_of_federation as name,
                             e.name as fac_name,
                             i.uin,
                             i.id AS ids
                         FROM
                             task_qa_assignment AS Y
                         INNER JOIN federation_mst AS i
                         ON
                             i.id = Y.assignment_id
                         INNER JOIN federation_sub_mst AS s
                         ON
                             i.id = s.federation_mst_id
                         INNER JOIN federation_profile AS j
                         ON
                             j.federation_sub_mst_id = s.id
                         INNER JOIN agency AS d
                         ON
                             i.agency_id = d.agency_id
                         INNER JOIN users AS e
                         ON
                             Y.user_id = e.id
                         WHERE
                             Y.is_deleted = 0 AND Y.assignment_type = 'FD' AND i.is_deleted=0 ";

                     if ($txt_search != '') {
                         $query .= " AND (j.name_of_federation like '%$txt_search%' ";
                         $query .= " or SUBSTRING(i.uin, LENGTH(i.uin) - 3) LIKE '%$txt_search%' )";
                     }
                     if ($user->u_type == 'M') {
                         if ($status_type == 'C') {
                             $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                         }
                         if ($status_type == 'P') {
                             $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                         }
                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['agency'])){
                                $agency = $session_data['agency'];
                                $query .=" AND i.agency_id = $agency  ";
                             }
                             if(!empty($session_data['federation'])){
                                $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                             }


                            if(!empty($session_data['facilitator'])){
                                $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                              }
                              else{
                                $query .= " AND Y.user_id in ($list)";
                              }
                        }
                        //  $query .= " AND Y.dm_id in ($user->id)";

                     }
                     if ($user->u_type == 'QA') {
                         if ($status_type == 'ALL') {
                             $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V' ) ";
                         }
                         if ($status_type == 'P') {
                             $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'  ";
                         }
                         if ($status_type == 'C') {
                             $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'V' OR Y.quality_status = 'R')  ";
                         }


                         if(!empty($session_data['Search'])){
                            if(!empty($session_data['agency'])){
                                $agency = $session_data['agency'];
                                $query .=" AND i.agency_id = $agency  ";
                             }
                             if(!empty($session_data['federation'])){
                                $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                             }


                            if(!empty($session_data['dm'])){
                                $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                              }
                              else{
                                $query .= " AND  verified_by IN($list)";
                              }
                        }
                        //  $query .= " AND Y.dm_id in ($user->id)";

                     }
                     if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                             $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                         }
                         if ($status_type == 'P') {
                             $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                         }
                         if ($status_type == 'C') {
                             $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                         }
                     }
                     $query .= " ORDER BY
                         Y.updated_at
                     DESC ";
                 }

                 if( $session_data['group'] == 'FM' || $session_data['group'] == 'ALL'){
                    if($user->u_type == 'QA'){
                    $query .=" ORDER BY  a.updated_at DESC ";

                    }
                 }

                 $familys = DB::select($query);
                //  prd($familys);
                 $total = count($familys);
                 $query .= " limit $limit ";
                 $query .= " offset $start";
                 $familys = DB::select($query);
                 foreach ($familys as $family) {
                     if ($family->assignment_type == 'FD') {
                         $path = 'federation';
                         $type = 'Federation';
                     }
                     if ($family->assignment_type == 'SH') {
                         $path = 'shg';
                         $type = 'SHG';
                     }
                     if ($family->assignment_type == 'CL') {
                         $path = 'cluster';
                         $type = 'Cluster';
                     }
                     if ($family->assignment_type == 'FM') {
                         $path = 'family';
                         $type = 'Family';
                     }

                     $task_val = "'" . $family->task . "'";
                     if ($user->u_type == 'QA') {
                         if ($family->quality_status == 'P' && $family->task_a1 == 'P1' && $family->family_buisness == 0) {
                             $action = '<span class="dropdown-item getdetail" rel="tooltip" style="cursor:pointer"><a href="' . route($path . '.show', [$family->ids, 'task_id' => $family->id, 'user_id' => $family->user_id, 'task_type' => $family->task_a1]) . '" ><span class="badge badge-warning">Take Action</span></a></span>';
                         }elseif ($family->quality_status == 'P' && $family->task_a1 == 'P2' && $family->family_buisness == 1) {
                            $action = '<span class="dropdown-item getdetail" rel="tooltip" style="cursor:pointer"><a href="' . route($path . '.show', [$family->ids, 'task_id' => $family->id, 'user_id' => $family->user_id, 'task_type' => $family->task_a1]) . '" ><span class="badge badge-warning">Take Action</span></a></span>';
                        }
                         elseif($family->task_a1 == 'P1' && $family->family_buisness == 1){
                            $action = '<span class="dropdown-item getdetail" rel="tooltip" style="cursor:pointer"><a href="' . route($path . '.show', [$family->ids, 'task_id' => $family->id, 'user_id' => $family->user_id, 'task_type' => $family->task_a1]) . '" ><span class="badge badge-primary">View</span></a></span>';
                         }
                         else {
                             $action =  '<span class="dropdown-item"><span class="badge badge-primary">Completed</span></span>';
                         }
                     }
                     if ($user->u_type == 'M') {
                         if ($family->qa_status == 'P' || $family->quality_status == 'R') {
                             $action = '<span class="dropdown-item getdetail" rel="tooltip" style="cursor:pointer"><a href="' . route($path . '.show', [$family->ids, 'task_id' => $family->id, 'user_id' => $family->user_id, 'task_type' => $family->task_a1]) . '" ><span class="badge badge-warning">Take Action</span></a></span>';
                         } else {
                             $action =  '<span class="dropdown-item"><span class="badge badge-primary">Completed</span></span>';
                         }
                     }

                     $status1 = '';
                     if ($family->quality_status == 'P') {
                         $status1 = '<span style="color:Red">Pending</span>';
                     }
                     if ($family->quality_status == 'R') {
                         $status1 = '<span style="color:Red">Rejected</span>';
                     }
                     if ($family->quality_status == 'V') {
                         $status1 = '<span style="color:green">Verified</span>';
                     }
                     //district manager
                     $status = '';
                     if ($family->qa_status == 'P') {
                         $status = '<span style="color:Red">Pending</span>';
                     }
                     if ($family->qa_status == 'V') {
                         $status = '<span style="color:green">Verified</span>';
                     }
                     if ($family->qa_status == 'R') {
                         $status = '<span style="color:red">Rejected</span>';
                     }
                     $part = '';

                     if ($family->assignment_type == 'FM') {
                         if ($family->task == 'A') {
                             if ($user->u_type == 'QA') {
                                 $task = '<span style="color:green">Analysis</span>';
                             } else {
                                 $part = ' - ' . $family->task_a1;
                                 $task = '<span style="color:green">Analysis</span>';
                             }
                         } elseif ($family->task == 'R') {
                             $part = '';
                             $task = '<span style="color:green">Rating</span>';
                         }
                     } else {
                         if ($family->task == 'A') {
                             $task = '<span style="color:green">Analysis</span>';
                         } elseif ($family->task == 'R') {
                             $task = '<span style="color:green">Rating</span>';
                         }
                     }
                     $row = [];
                     $row[] = ++$start;
                     $row[] = $family->uin;
                     $row[] = $family->name;
                     $row[] = $type;
                     $row[] = $family->fac_name;
                     $row[] = $task . $part;
                     $row[] = $status;
                     if ($family->qa_status == 'P') {
                         $row[] = '<span style="color:Red">---</span>';
                     } else {
                         $row[] = change_date_month_name_char($family->manger_date);
                         //$row[] = change_date_format_display($family->manger_date);
                     }

                     $row[] = $status1;
                     if ($family->quality_status == 'P') {
                         $row[] = '<span style="color:Red">---</span>';
                     } else {
                         $row[] = change_date_month_name_char($family->quality_date);
                         //$row[] = change_date_format_display($family->quality_date);
                     }
                     if ($u_type == 'M' || $u_type == 'QA') {
                         $row[] = $action;
                     }

                     $data[] = $row;
                 }
             }

             $output = array(
                 "draw"            => $request->post('draw'),
                 "recordsTotal"    => $total,
                 "recordsFiltered" => $total,
                 "data"            => $data,
             );
             // prd($output);
             echo json_encode($output);
             exit;
         }

         $query = "SELECT * from agency WHERE is_deleted = 0";
        if ($user->u_type == 'M') {

            // $query .= " AND state in ($states_id)";
            $query .= " AND agency_id in ($user->agency_id)";

        }
        $data['agency'] = DB::select($query);
         $data['u_type'] = $user->u_type;
         $data['facilitators'] = $list;
         return view('qualitycheck.list')->with($data);
     }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $user = Auth::User();
        $data['u_type'] = $user->u_type;
        $u_type = $data['u_type'];
        $user_geo = DB::table('user_location_relation')
            ->where('user_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->orderBy('country_id')
            ->get()->toArray();
        $data = [];

        $data['u_type'] = $user->u_type;
        return view('qualitycheck.add')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_family_task(Request $request)
    {
        $data = [];
        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        return view('qualitycheck.familytask')->with($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $view = 'qualitycheck.add';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            //prd($request->all());
            try {
                $result = DB::transaction(function () use ($request) {
                    $validation_arr = [
                        'task' => ['required'],
                        'assignment_id' => ['required'],
                        'user_id' => ['required'],
                        'remark' => ['required'],
                    ];

                    $validator = Validator::make($request->all(), $validation_arr);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }


                    $user = Auth::User();
                    $family_mst_count = $request->post('assignment_id');
                    //prd(count($family_mst_count));
                    for ($i = 0; $i < count($family_mst_count); $i++) {
                        $family_mst = new QualityCheck();
                        $family_mst->task = $request->post('task');
                        $family_mst->task_a1 = $request->post('task_a1');
                        $family_mst->assignment_id = $family_mst_count[$i];
                        $family_mst->asgtkn = substr(md5(mt_rand()), 0, 16);
                        $family_mst->user_id = $request->post('user_id');
                        $family_mst->remark = $request->post('remark');
                        $family_mst->created_by = $user->id;

                        $result = $family_mst->save();
                    }
                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('qualitycheck')->with(['message' => 'Task Assigned successfully.']);
                }
            } catch (\Exception $e) {
                prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        return view($view);
    }
    public function store_shg(Request $request)
    {
        //die('kkk');
        $view = 'qualitycheck.shgtask';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            //prd($request->all());
            try {
                $result = DB::transaction(function () use ($request) {
                    $validation_arr = [
                        'task' => ['required'],
                        'assignment_id' => ['required'],
                        'user_id' => ['required'],
                        'remark' => ['required'],
                    ];

                    $validator = Validator::make($request->all(), $validation_arr);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    $temp_rand = '';

                    $user = Auth::User();
                    $family_mst_count = $request->post('assignment_id');
                    //prd(count($family_mst_count));
                    for ($i = 0; $i < count($family_mst_count); $i++) {
                        $family_mst = new QualityCheck();

                        $family_mst->task = $request->post('task');
                        $family_mst->assignment_id = $family_mst_count[$i];
                        $family_mst->assignment_type = "SH";
                        $family_mst->asgtkn = substr(md5(mt_rand()), 0, 16);
                        $family_mst->user_id = $request->post('user_id');
                        $family_mst->remark = $request->post('remark');
                        $family_mst->created_by = $user->id;

                        $result = $family_mst->save();
                    }
                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('qualitycheck')->with(['message' => 'Task Assigned successfully.']);
                }
            } catch (\Exception $e) {
                prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        return view($view);
    }
    public function store_cluster(Request $request)
    {
        //die('kkk');
        $view = 'qualitycheck.clustertask';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            //prd($request->all());
            try {
                $result = DB::transaction(function () use ($request) {
                    $validation_arr = [
                        'task' => ['required'],
                        'assignment_id' => ['required'],
                        'user_id' => ['required'],
                        'remark' => ['required'],
                    ];

                    $validator = Validator::make($request->all(), $validation_arr);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    $temp_rand = '';

                    $user = Auth::User();
                    $family_mst_count = $request->post('assignment_id');
                    //prd(count($family_mst_count));
                    for ($i = 0; $i < count($family_mst_count); $i++) {
                        $family_mst = new QualityCheck();
                        $family_mst->task = $request->post('task');
                        $family_mst->assignment_id = $family_mst_count[$i];
                        $family_mst->assignment_type = "CL";
                        $family_mst->asgtkn = substr(md5(mt_rand()), 0, 16);
                        $family_mst->user_id = $request->post('user_id');
                        $family_mst->remark = $request->post('remark');
                        $family_mst->created_by = $user->id;

                        $result = $family_mst->save();
                    }
                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('qualitycheck')->with(['message' => 'Task Assigned successfully.']);
                }
            } catch (\Exception $e) {
                prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        return view($view);
    }
    public function store_federation(Request $request)
    {
        //die('kkk');
        $view = 'qualitycheck.federationtask';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            //prd($request->all());
            try {
                $result = DB::transaction(function () use ($request) {
                    $validation_arr = [
                        'task' => ['required'],
                        'assignment_id' => ['required'],
                        'user_id' => ['required'],
                        'remark' => ['required'],
                    ];

                    $validator = Validator::make($request->all(), $validation_arr);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    $temp_rand = '';

                    $user = Auth::User();
                    $family_mst_count = $request->post('assignment_id');
                    //prd(count($family_mst_count));
                    for ($i = 0; $i < count($family_mst_count); $i++) {
                        $family_mst = new QualityCheck();
                        $family_mst->task = $request->post('task');
                        $family_mst->assignment_id = $family_mst_count[$i];
                        $family_mst->assignment_type = "FD";
                        $family_mst->asgtkn = substr(md5(mt_rand()), 0, 16);
                        $family_mst->user_id = $request->post('user_id');
                        $family_mst->remark = $request->post('remark');
                        $family_mst->created_by = $user->id;

                        $result = $family_mst->save();
                    }
                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('qualitycheck')->with(['message' => 'Task Assigned successfully.']);
                }
            } catch (\Exception $e) {
                prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        return view($view);
    }
    public function shgtask(Request $request)
    {
        $data = [];
        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        return view('qualitycheck.shgtask')->with($data);
    }
    public function clustertask(Request $request)
    {
        $data = [];
        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        return view('qualitycheck.clustertask')->with($data);
    }
    public function federationtask(Request $request)
    {
        $data = [];
        $data['agency'] = DB::table('agency')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        return view('qualitycheck.federationtask')->with($data);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QualityCheck  $qualitycheck
     * @return \Illuminate\Http\Response
     */
    public function show(QualityCheck $qualitycheck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QualityCheck  $qualitycheck
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id > 0) {
            $query = "SELECT
                    Y.id,
                    Y.user_id,
                    Y.assignment_id,
                    Y.remark,
                    Y.task,
                    Y.task_a1,
                    k.id as family_id,
                    l.fp_member_name,
                    d.id as agency_id,
                    i.id as shg_id,
                    j.shgName,
                    e.name
                FROM
                    task_qa_assignment AS Y
                INNER JOIN family_mst AS k
                ON
                    k.id = Y.assignment_id
                INNER JOIN family_profile AS l
                ON
                    l.family_sub_mst_id = k.id
                INNER JOIN shg_mst AS i
                ON
                    i.uin = k.shg_uin
                INNER JOIN shg_profile AS j
                ON
                    j.shg_sub_mst_id = i.id
                INNER JOIN agency AS d
                ON
                    k.agency_id = d.agency_id
                INNER JOIN users AS e
                ON
                    Y.user_id = e.id
                WHERE
                    Y.is_deleted = 0 AND assignment_type = 'FM'";
            $data['qualitycheck'] = DB::select($query);

            $data['edit'] = 1;
            //prd($data);
            $data['agency'] = DB::table('agency')
                ->where('is_deleted', '=', 0)
                ->get()->toArray();
            return view('qualitycheck.edit')->with($data);
        } else {
            return redirect('qualitycheck');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QualityCheck  $qualitycheck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QualityCheck $qualitycheck)
    {
        $view = 'qualitycheck.edit';

        /* Check post either add or update */
        if ($request->isMethod('PATCH')) { //prd($request->all());
            try {
                $result = DB::transaction(function () use ($request, $qualitycheck) {
                    $validation_arr = [
                        'agency_id' => ['required'],
                        'task' => ['required'],
                        'task_a1' => ['required'],
                        'shg_uin' => ['required'],
                        'assignment_id' => ['required'],
                        'user_id' => ['required'],
                        'remark' => ['required'],
                    ];

                    $validator = Validator::make($request->all(), $validation_arr);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }

                    $user = Auth::User();
                    //prd($user);
                    if ($request->post('id') > 0) {
                        $family_mst = QualityCheck::find($request->post('id'));
                        $family_mst->updated_by = $user->id;
                    } else {

                        return redirect('qualitycheck')->with(['message' => 'Task id does not exist.']);
                        exit();
                    }
                    $family_mst_count = $request->post('assignment_id');

                    $result = $family_mst->save();

                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('family')->with(['message' => 'Family updated successfully.']);
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
     * @param  \App\Models\QualityCheck  $qualitycheck
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //prd($id);
        try {
            if ($id > 0) {
                $task_details = QualityCheck::find($id);
                $task_details->is_deleted = 1;
                $task_details->save();

                $data['message'] = 'Task deleted successfully';
                echo json_encode($data);
            } else {
                $data['message'] = 'Invalid Request';
                echo json_encode($data);
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
        exit;
    }


    public function change_qa_status_fed(Request $request)
    {


        $qastatus = $request->post('sts');
        //$qcstatus = $request->post('qrmk');
        $remark = urldecode($request->post('rmk'));
        // prd($remark);
        $user = Auth::User();
        $id = $request->post('id');
        $quality_id = $user->parent_id;
        $user_id = $user->id;
        try {
            if ($id > 0) {
                //prd($id);
                $task_details = QualityCheck::find($id);
                $task_details->qa_status = $qastatus;
                $task_details->quality_status = 'P';
                $task_details->remark = $remark;
                $task_details->verified_by = $user->id;
                $task_details->manger_date = date('d-m-Y');
                $task_details->updated_at = date('Y-m-d H:i:s');
                if ($qastatus == 'V') {
                    $task_details->quality_verified = $quality_id;
                }
                $task_details->save();
                $fac_id = $request->post('user_id');

                //notfication
                $assignment_id = $task_details->assignment_id;
                $asgtkn = $task_details->asgtkn;
                qa_historyData($asgtkn, $assignment_id, $task_details->assignment_type, $task_details->task, $task_details->task_a1, $qastatus, $remark, $user->id);
                $qa_status = 'Pending';
                if ($task_details->task == 'A') {
                    $cureent_status = 'AP';
                }
                if ($task_details->task == 'R') {
                    $cureent_status = 'RP';
                }

                if ($qastatus == 'V') {
                    // notification
                    $message['task'] = '';
                    $message['name'] = '';
                    if ($task_details->assignment_type == 'FD') {
                        $message['task'] = 'FEDERATION';
                        $query = "SELECT name_of_federation FROM federation_profile WHERE is_deleted = 0 AND federation_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->name_of_federation;

                        $fed_remarks = new FedRemarks();
                        $fed_remarks->fed_id = $assignment_id;
                        $fed_remarks->dm_id = $user_id;
                        $fed_remarks->dm_remarks = $remark;
                        $fed_remarks->user_id = $task_details->user_id;
                        $fed_remarks->dm_status = 'V';
                        $fed_remarks->task = $task_details->task;
                        $result= $fed_remarks->save();

                    } else if ($task_details->assignment_type == 'CL') {
                        $message['task'] = 'CLUSTER';
                        $query = "SELECT name_of_cluster FROM cluster_profile WHERE is_deleted = 0 AND cluster_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->name_of_cluster;

                        $cluster_remarks = new ClusterRemarks();
                        $cluster_remarks->cluster_id = $assignment_id;
                        $cluster_remarks->dm_id = $user_id;
                        $cluster_remarks->dm_remarks = $remark;
                        $cluster_remarks->user_id = $task_details->user_id;
                        $cluster_remarks->dm_status = 'V';
                        $cluster_remarks->task = $task_details->task;
                        $result= $cluster_remarks->save();

                    } else if ($task_details->assignment_type == 'SH') {
                        $message['task'] = 'SHG';
                        $query = "SELECT shgName FROM shg_profile WHERE is_deleted = 0 AND shg_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->shgName;

                        $shg_remarks = new SHGRemarks();
                        $shg_remarks->shg_id = $assignment_id;
                        $shg_remarks->dm_id = $user_id;
                        $shg_remarks->dm_remarks = $remark;
                        $shg_remarks->user_id = $task_details->user_id;
                        $shg_remarks->dm_status = 'V';
                        $shg_remarks->task = $task_details->task;
                        $result= $shg_remarks->save();

                    } else if ($task_details->assignment_type == 'FM') {

                        $message['task'] = 'FAMILY';
                        $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->fp_member_name;
                    }

                    $mst_id = $id;
                    $message['status'] = $qastatus;
                    $assignment_type = $task_details->assignment_type;
                    $task = '';
                    $task = $message['task'];
                    $task_a1 = '';
                    $manager_id = $user_id;
                    $asgtkn = $task_details->asgtkn;
                    $user_id = $quality_id;
                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $quality_id";
                    $message['user_name'] = DB::select($query)[0]->name;

                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $manager_id";
                    $message['manager_name'] = DB::select($query)[0]->name;
                    $mnger_name = $message['manager_name'];
                    $name = $message['name'];
                    $message_save = '';
                    $message_save = "$mnger_name has Verified the $name ($task) task . Please Check.";

                    notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);
                    $qa_status = 'Verify';
                    if ($task_details->assignment_type == 'FD') {
                        if ($task_details->task == 'A') {
                            FederationSubMst::where([['federation_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'dm_a' => 'V', 'qa_a' => 'P', 'status_flag' => 1]);
                        } else {
                            FederationSubMst::where([['federation_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'V', 'qa_r' => 'P' , 'status_flag' => 1]);
                        }
                    }
                    if ($task_details->assignment_type == 'CL') {
                        if ($task_details->task == 'A') {
                            ClusterSubMst::where([['cluster_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'dm_a' => 'V', 'qa_a' => 'P' , 'status_flag' => 1]);
                        } else {
                            ClusterSubMst::where([['cluster_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'V', 'qa_r' => 'P' , 'status_flag' => 1]);
                        }
                    }
                    if ($task_details->assignment_type == 'SH') {
                        if ($task_details->task == 'A') {
                            ShgSubMst::where([['shg_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'dm_a' => 'V', 'qa_a' => 'P' , 'status_flag' => 1]);
                        } else {
                            ShgSubMst::where([['shg_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'V', 'qa_r' => 'P' ,'status_flag' => 1]);
                        }
                    }
                    if ($task_details->assignment_type == 'FM') {
                        if ($task_details->task_a1 == 'P1' && $task_details->task == 'A') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p1' => 'P', 'dm_p1' => 'V', 'qa_p1' => 'P']);
                        }
                        if ($task_details->task_a1 == 'P2' && $task_details->task == 'A') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p2' => 'P', 'dm_p2' => 'V', 'qa_p2' => 'P']);
                        }
                        if ($task_details->task == 'R') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'V', 'qa_r' => 'P']);
                        }
                    }
                }
                if ($qastatus == 'R') {

                    $message['status'] = $qastatus;
                    $qa_status = 'Rejected';
                    $family_mst = new Preanalytics();
                    $family_mst->assignment_type = $task_details->assignment_type;
                    $family_mst->assignment_id  = $task_details->assignment_id;
                    $family_mst->task = $task_details->task;
                    $family_mst->status = 'P';
                    $family_mst->task_a1 = $task_details->task_a1;
                    //$family_mst->asgtkn = substr(md5(mt_rand()), 0, 16);
                    $family_mst->asgtkn = assignToken();
                    $family_mst->user_id = $request->post('user_id');
                    $family_mst->remark = $remark;

                    $family_mst->created_by = $user->id;

                    $result = $family_mst->save();

                    // notification
                    $task = '';
                    $name = '';
                    if ($task_details->assignment_type == 'FD') {
                        $message['task'] = 'FEDERATION';
                        $query = "SELECT name_of_federation FROM federation_profile WHERE is_deleted = 0 AND federation_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->name_of_federation;

                        // remarks
                        $Fed_remarks = new FedRemarks();
                        $Fed_remarks->user_id = $fac_id;
                        $Fed_remarks->fed_id = $assignment_id;
                        $Fed_remarks->dm_id = $user->id;
                        $Fed_remarks->dm_remarks = $remark;
                        $Fed_remarks->dm_status = 'R';
                        $Fed_remarks->task = $task_details->task;
                        $Fed_remarks->qa_flag =1;
                        $result= $Fed_remarks->save();

                    } else if ($task_details->assignment_type == 'CL') {
                        $message['task'] = 'CLUSTER';
                        $query = "SELECT name_of_cluster FROM cluster_profile WHERE is_deleted = 0 AND cluster_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->name_of_cluster;

                        // remarks
                        $cluster_remarks = new ClusterRemarks();
                        $cluster_remarks->user_id = $fac_id;
                        $cluster_remarks->cluster_id = $assignment_id;
                        $cluster_remarks->dm_id = $user->id;
                        $cluster_remarks->dm_remarks = $remark;
                        $cluster_remarks->dm_status = 'R';
                        $cluster_remarks->qa_flag =1;
                        $cluster_remarks->task = $task_details->task;
                        $result= $cluster_remarks->save();

                    } else if ($task_details->assignment_type == 'SH') {
                        $message['task'] = 'SHG';
                        $query = "SELECT shgName FROM shg_profile WHERE is_deleted = 0 AND shg_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->shgName;
                        // remarks
                        $shg_remarks = new SHGRemarks();
                        $shg_remarks->user_id = $fac_id;
                        $shg_remarks->shg_id = $assignment_id;
                        $shg_remarks->dm_id = $user->id;
                        $shg_remarks->dm_remarks = $remark;
                        $shg_remarks->dm_status = 'R';
                        $shg_remarks->qa_flag =1;
                        $shg_remarks->task = $task_details->task;
                        $result= $shg_remarks->save();

                    } else if ($task_details->assignment_type == 'FM') {
                        $message['task'] = 'FAMILY';
                        $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->fp_member_name;
                    }

                    $mst_id = $id;

                    $assignment_type = $task_details->assignment_type;

                    $task_a1 = '';
                    $manager_id = $user_id;

                    $asgtkn = $task_details->asgtkn;
                    $user_id = $fac_id;

                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $fac_id";
                    $message['user_name'] = DB::select($query)[0]->name;

                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $manager_id";
                    $message['manager_name'] = DB::select($query)[0]->name;
                    $message_save = '';


                    $name = $message['name'];
                    $task = $message['task'];
                    $mnger_name = $message['manager_name'];
                    $message_save = '';
                    $message_save = "$mnger_name has Rejected the $name ($task) task . Please Check.";


                    notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);
                    $facility_id = $request->post('user_id');
                    $parent_id = parent_id($facility_id);
                    if ($task_details->assignment_type == 'FD') {
                        if ($task_details->task == 'A') {
                            FederationSubMst::where([['federation_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'dm_a' => 'R', 'flag' => '1' , 'status_flag' => 1]);
                            Federation::where([['id', '=', $assignment_id]])->update(['created_by' => $parent_id]);
                        } else {
                            FederationSubMst::where([['federation_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'R', 'flag' => '1' , 'status_flag' => 1]);
                            Federation::where([['id', '=', $assignment_id]])->update(['created_by' => $parent_id]);

                        }
                    }
                    if ($task_details->assignment_type == 'CL') {
                        if ($task_details->task == 'A') {
                            ClusterSubMst::where([['cluster_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'dm_a' => 'R', 'flag' => '1' , 'status_flag' => 1]);
                        } else {
                            ClusterSubMst::where([['cluster_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'R', 'flag' => '1' , 'status_flag' => 1]);
                        }
                    }
                    if ($task_details->assignment_type == 'SH') {
                        if ($task_details->task == 'A') {
                            ShgSubMst::where([['shg_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'dm_a' => 'R', 'flag' => '1' , 'status_flag' => 1]);
                        } else {
                            ShgSubMst::where([['shg_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'R', 'flag' => '1' , 'status_flag' => 1]);
                        }
                    }
                    if ($task_details->assignment_type == 'FM') {
                        if ($task_details->task_a1 == 'P1' && $task_details->task == 'A') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p1' => 'P', 'dm_p1' => 'R', 'flag' => '1' , 'status_flag' => 1, 'task_status' => 1]);
                        }
                        if ($task_details->task_a1 == 'P2' && $task_details->task == 'A') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p2' => 'P', 'dm_p2' => 'R', 'flag' => '1' , 'status_flag' => 1, 'task_status' => 1]);
                        }
                        if ($task_details->task == 'R') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'R', 'flag' => '1' , 'status_flag' => 1, 'task_status' => 1]);
                        }
                    }
                }
                if ($task_details->assignment_type == 'FD') {
                    FederationSubMst::where([['federation_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['qa_status' => $qa_status]);
                }
                if ($task_details->assignment_type == 'CL') {
                    ClusterSubMst::where([['cluster_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['qa_status' => $qa_status]);
                }
                if ($task_details->assignment_type == 'SH') {
                    ShgSubMst::where([['shg_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['qa_status' => $qa_status]);
                }
                if ($task_details->assignment_type == 'FM') {
                    FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['qa_status' => $qa_status]);
                }


                $data['message'] = 'Task Updated successfully';
                $data['result'] = 1;
                echo json_encode($data);
            } else {
                $data['message'] = 'Invalid Request';
                $data['result'] = 0;
                echo json_encode($data);
            }
        } catch (\Exception $e) {
            print_r($e->postMessage());
        }
        exit;
    }

    public function change_qa_status_fm(Request $request)
    {


        $business = $request->post('business');
        $qastatus = $request->post('sts');
        $qcstatus = $request->post('qrmk');
        $remark = urldecode($request->post('rmk'));
        // prd($request->post('rmk'));
        $user = Auth::User();
        $id = $request->post('id');

        $quality_id = $user->parent_id;
        $user_id = $user->id;

        try {
            if ($id > 0) {

                // prd($id);
                $task_details = QualityCheck::find($id);
                $remark_p1 = '';
                $remark_p2 = '';
                if($task_details->task_a1 == 'P1'){
                    $remark_p1 = $remark;
                }
                elseif($task_details->task_a1 == 'P2'){
                    $remark_p2 = $remark;
                }
                // prd($task_details->task_a1);
                $query = "SELECT * FROM task_qa_assignment WHERE assignment_id = $task_details->assignment_id AND assignment_type  = 'FM' AND (manger_date = '' OR quality_status = 'R')";
                $task_qa_details = DB::select($query);

                    $tasks_count = count($task_qa_details);
                    // prd($tasks_count);

                $fac_id = $request->post('user_id');
                //notfication
                $assignment_id = $task_details->assignment_id;
                $asgtkn = $task_details->asgtkn;
                qa_historyData($asgtkn, $assignment_id, $task_details->assignment_type, $task_details->task, $task_details->task_a1, $qastatus, $remark, $user->id);
                $qa_status = 'Pending';
                if ($task_details->task == 'A') {
                    $cureent_status = 'AP';
                }
                if ($task_details->task == 'R') {
                    $cureent_status = 'RP';
                }

                if ($qastatus == 'V') {

                    // notification
                    $message['task'] = '';
                    $message['name'] = '';

                    $message['task'] = 'FAMILY';
                    $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                    $message['name'] = DB::select($query)[0]->fp_member_name;

                    $mst_id = $id;
                    $message['status'] = $qastatus;
                    $assignment_type = $task_details->assignment_type;
                    $task = '';
                    $task = $message['task'];
                    $task_a1 = '';
                    $manager_id = $user_id;
                    $asgtkn = $task_details->asgtkn;
                    $user_id = $quality_id;
                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $quality_id";
                    $message['user_name'] = DB::select($query)[0]->name;

                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $manager_id";
                    $message['manager_name'] = DB::select($query)[0]->name;
                    $mnger_name = $message['manager_name'];
                    $name = $message['name'];
                    $message_save = '';
                    $message_save = "$mnger_name has Verified the $name ($task) task . Please Check.";

                    notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);
                    $qa_status = 'Verify';

                    if ($task_details->task_a1 == 'P1' && $task_details->task == 'A') {
                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p1' => 'P', 'dm_p1' => 'V', 'qa_p1' => 'P' , 'status_flag' => 1]);

                        $family_remarks = new Remarks();
                        $family_remarks->family_id = $assignment_id;
                        $family_remarks->dm_id = $manager_id;
                        $family_remarks->dm_remarks = $remark_p1;
                        $family_remarks->user_id = $task_details->user_id;
                        $family_remarks->dm_status = 'V';
                        $family_remarks->task_type ='P1';
                        $family_remarks->task =$task_details->task;
                        $result= $family_remarks->save();

                    }
                    if ($task_details->task_a1 == 'P2' && $task_details->task == 'A') {
                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p2' => 'P', 'dm_p2' => 'V', 'qa_p2' => 'P' , 'status_flag' => 1]);
                        $family_remarks = new Remarks();
                        $family_remarks->family_id = $assignment_id;
                        $family_remarks->dm_id = $manager_id;
                        $family_remarks->dm_remarks = $remark_p2;
                        $family_remarks->user_id = $task_details->user_id;
                        $family_remarks->dm_status = 'V';
                        $family_remarks->task_type ='P2';
                        $family_remarks->task =$task_details->task;
                        $result= $family_remarks->save();
                    }
                    if ($task_details->task == 'R') {
                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'V', 'qa_r' => 'P' , 'status_flag' => 1]);
                        $family_remarks = new Remarks();
                        $family_remarks->family_id = $assignment_id;
                        $family_remarks->dm_id = $manager_id;
                        $family_remarks->dm_remarks = $remark;
                        $family_remarks->dm_status = 'V';
                        $family_remarks->task_type ='R';
                        $family_remarks->task =$task_details->task;
                        $result= $family_remarks->save();
                    }
                }
                if ($qastatus == 'R') {

                    $task_type_p1 = '';
                    $task_type_p2 = '';

                    if ($tasks_count == 2) {
                        $task_type_p1 = 'P1';
                        $task_type_p2 = 'P2';
                    }
                    if ($tasks_count == 1) {
                        if($task_qa_details[0]->task_a1 == 'P1')
                        {
                            $task_type_p1 = $task_qa_details[0]->task_a1;
                        }
                        elseif($task_qa_details[0]->task_a1 == 'P2'){
                            $task_type_p2 = $task_qa_details[0]->task_a1;
                        }
                        elseif($task_qa_details[0]->task_a1 == ''){
                            $task_type_r = 'R';
                        }

                    }


                    if (!empty($task_type_p1)) {

                        $message['status'] = $qastatus;
                        $qa_status = 'Rejected';
                        $family_mst = new Preanalytics();
                        $family_mst->assignment_type = $task_details->assignment_type;
                        $family_mst->assignment_id = $task_details->assignment_id;
                        $family_mst->task = $task_details->task;
                        $family_mst->status = 'P';
                        $family_mst->task_a1 = $task_type_p1;
                        //$family_mst->asgtkn = substr(md5(mt_rand()), 0, 16);
                        $family_mst->asgtkn = assignToken();
                        $family_mst->user_id = $request->post('user_id');
                        $family_mst->remark = $remark_p1;

                        $family_mst->created_by = $user->id;

                        $result = $family_mst->save();

                        // remarks
                        $family_remarks = new Remarks();
                        $family_remarks->user_id = $request->post('user_id');
                        $family_remarks->family_id = $assignment_id;
                        $family_remarks->dm_id = $user->id;
                        $family_remarks->dm_remarks = $remark_p1;
                        $family_remarks->dm_status = 'R';
                        $family_remarks->task_type ='P1';
                        $family_remarks->task =$task_details->task;
                        $family_remarks->qa_flag =1;
                        $result= $family_remarks->save();

                        // notification
                        $task = '';
                        $name = '';

                        $message['task'] = 'FAMILY';
                        $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->fp_member_name;

                        $mst_id = $id;

                        $assignment_type = $task_details->assignment_type;

                        $task_a1 = '';
                        $manager_id = $user_id;

                        $asgtkn = $task_details->asgtkn;
                        $user_id = $fac_id;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $fac_id";
                        $message['user_name'] = DB::select($query)[0]->name;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $manager_id";
                        $message['manager_name'] = DB::select($query)[0]->name;
                        $message_save = '';

                        $name = $message['name'];
                        $task = $message['task'];
                        $mnger_name = $message['manager_name'];
                        $message_save = '';
                        $message_save = "$mnger_name has Rejected the $name ($task) task . Please Check.";
                        notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);

                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p1' => 'P', 'dm_p1' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 0]);

                        if ($task_details->task_a1 == 'P2' && $task_details->task == 'A') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p2' => 'P', 'dm_p2' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 1]);
                        }
                        if ($task_details->task == 'R') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 1]);
                        }
                    }
                    if (!empty($task_type_p2)) {

                        $message['status'] = $qastatus;
                        $qa_status = 'Rejected';
                        $family_mst = new Preanalytics();
                        $family_mst->assignment_type = $task_details->assignment_type;
                        $family_mst->assignment_id = $task_details->assignment_id;
                        $family_mst->task = $task_details->task;
                        $family_mst->status = 'P';
                        $family_mst->task_a1 = $task_type_p2;
                        //$family_mst->asgtkn = substr(md5(mt_rand()), 0, 16);
                        $family_mst->asgtkn = assignToken();
                        $family_mst->user_id = $request->post('user_id');
                        $family_mst->remark = $remark_p2;

                        $family_mst->created_by = $user->id;

                        $result = $family_mst->save();


                         // remarks
                         $family_remarks = new Remarks();
                         $family_remarks->user_id = $request->post('user_id');
                         $family_remarks->family_id = $assignment_id;
                         $family_remarks->dm_id = $user->id;
                         $family_remarks->dm_remarks = $remark_p2;
                         $family_remarks->dm_status = 'R';
                         $family_remarks->task_type ='P2';
                         $family_remarks->qa_flag =1;
                        $family_remarks->task =$task_details->task;
                         $result= $family_remarks->save();

                        // notification
                        $task = '';
                        $name = '';

                        $message['task'] = 'FAMILY';
                        $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->fp_member_name;

                        $mst_id = $id;

                        $assignment_type = $task_details->assignment_type;

                        $task_a1 = '';
                        $manager_id = $user_id;

                        $asgtkn = $task_details->asgtkn;
                        $user_id = $fac_id;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $fac_id";
                        $message['user_name'] = DB::select($query)[0]->name;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $manager_id";
                        $message['manager_name'] = DB::select($query)[0]->name;
                        $message_save = '';

                        $name = $message['name'];
                        $task = $message['task'];
                        $mnger_name = $message['manager_name'];
                        $message_save = '';
                        $message_save = "$mnger_name has Rejected the $name ($task) task . Please Check.";
                        notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);

                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p2' => 'P', 'dm_p2' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 1]);

                        if ($task_details->task == 'R') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 1]);
                        }
                    }
                    if (!empty($task_type_r)) {

                        $message['status'] = $qastatus;
                        $qa_status = 'Rejected';
                        $family_mst = new Preanalytics();
                        $family_mst->assignment_type = $task_details->assignment_type;
                        $family_mst->assignment_id = $task_details->assignment_id;
                        $family_mst->task = $task_details->task;
                        $family_mst->status = 'P';
                        $family_mst->task_a1 = $task_type_r;
                        //$family_mst->asgtkn = substr(md5(mt_rand()), 0, 16);
                        $family_mst->asgtkn = assignToken();
                        $family_mst->user_id = $request->post('user_id');
                        $family_mst->remark = $remark;

                        $family_mst->created_by = $user->id;

                        $result = $family_mst->save();

                        // remarks
                        $family_remarks = new Remarks();
                        $family_remarks->user_id = $request->post('user_id');
                        $family_remarks->family_id = $assignment_id;
                        $family_remarks->dm_id = $user->id;
                        $family_remarks->dm_remarks = $remark;
                        $family_remarks->dm_status = 'R';
                        $family_remarks->task_type ='R';
                        $family_remarks->qa_flag =1;
                        $family_remarks->task =$task_details->task;
                        $result= $family_remarks->save();

                        // notification
                        $task = '';
                        $name = '';

                        $message['task'] = 'FAMILY';
                        $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->fp_member_name;

                        $mst_id = $id;

                        $assignment_type = $task_details->assignment_type;

                        $task_a1 = '';
                        $manager_id = $user_id;

                        $asgtkn = $task_details->asgtkn;
                        $user_id = $fac_id;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $fac_id";
                        $message['user_name'] = DB::select($query)[0]->name;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $manager_id";
                        $message['manager_name'] = DB::select($query)[0]->name;
                        $message_save = '';

                        $name = $message['name'];
                        $task = $message['task'];
                        $mnger_name = $message['manager_name'];
                        $message_save = '';
                        $message_save = "$mnger_name has Rejected the $name ($task) task . Please Check.";
                        notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);
                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 1]);
                    }
                }

                FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['qa_status' => $qa_status]);

                if ($qastatus == 'V') {
                    $task_details->qa_status = $qastatus;
                    $task_details->quality_status = 'P';
                    $task_details->remark = $remark;
                    $task_details->verified_by = $user->id;
                    $task_details->manger_date = date('d-m-Y');
                    $task_details->updated_at = date('Y-m-d H:i:s');
                    if ($qastatus == 'V') {
                        $task_details->quality_verified = $quality_id;
                    }
                    $task_details->save();
                } else {

                    foreach ($task_qa_details as $row) {

                        $task_details = QualityCheck::find($row->id);
                        $task_details->qa_status = $qastatus;
                        $task_details->quality_status = 'P';
                        if($task_details->task_a1 == 'P1'){
                            $task_details->remark = $remark_p1;
                        }
                        elseif($task_details->task_a1 == 'P2'){
                            $task_details->remark = $remark_p2;
                        }
                        else{
                            $task_details->remark = $remark;
                        }
                        $task_details->verified_by = $user->id;
                        $task_details->manger_date = date('d-m-Y');
                        $task_details->updated_at = date('Y-m-d H:i:s');
                        if ($qastatus == 'V') {
                            $task_details->quality_verified = $quality_id;
                        }

                        $task_details->save();
                    }
                }

                if($business == 1){
                    $fm_mst = new Preanalytics();
                    $task = 'A';
                    $task_a1 = 'P2';

                    $fm_mst->assignment_id = $assignment_id;
                    $fm_mst->assignment_type = "FM";
                    $fm_mst->task = $task;
                    $fm_mst->task_a1 = $task_a1;
                    $fm_mst->asgtkn = assignToken();
                    $fm_mst->user_id = $fac_id;
                    $fm_mst->remark = $remark;
                    $fm_mst->created_by = $user->id;
                    $result = $fm_mst->save();
                    FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['family_buisness' => 1]);
                }



                $data['message'] = 'Task Updated successfully';
                $data['result'] = 1;
                echo json_encode($data);
            } else {
                $data['message'] = 'Invalid Request';
                $data['result'] = 0;
                echo json_encode($data);
            }
        } catch (\Exception $e) {
            print_r($e->postMessage());
        }
        exit;
    }

    public function change_qa_status_fm_new(Request $request)
    {


        $business = $request->post('business');
        $qastatus = $request->post('sts');
        $qcstatus = $request->post('qrmk');
        $remark = urldecode($request->post('rmk'));
        // prd($request->post('rmk'));
        $user = Auth::User();
        $id = $request->post('id');

        $quality_id = $user->parent_id;
        $user_id = $user->id;

        try {
            if ($id > 0) {


                $task_details = QualityCheck::find($id);

                $remark_p1 = '';
                $remark_p2 = '';
                if($task_details->task_a1 == 'P1'){
                    $remark_p1 = $remark;
                }
                elseif($task_details->task_a1 == 'P2'){
                    $remark_p2 = $remark;
                }

                // $query = "SELECT * FROM task_qa_assignment WHERE assignment_id = $task_details->assignment_id AND assignment_type  = 'FM' AND (manger_date = '' OR quality_status = 'R')";
                // $task_qa_details = DB::select($query);

                //     $tasks_count = count($task_qa_details);
                    // prd($tasks_count);

                $fac_id = $request->post('user_id');
                //notfication
                $assignment_id = $task_details->assignment_id;
                $asgtkn = $task_details->asgtkn;
                qa_historyData($asgtkn, $assignment_id, $task_details->assignment_type, $task_details->task, $task_details->task_a1, $qastatus, $remark, $user->id);
                $qa_status = 'Pending';
                if ($task_details->task == 'A') {
                    $cureent_status = 'AP';
                }
                if ($task_details->task == 'R') {
                    $cureent_status = 'RP';
                }

                if ($qastatus == 'V') {

                    // notification
                    $message['task'] = '';
                    $message['name'] = '';

                    $message['task'] = 'FAMILY';
                    $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                    $message['name'] = DB::select($query)[0]->fp_member_name;

                    $mst_id = $id;
                    $message['status'] = $qastatus;
                    $assignment_type = $task_details->assignment_type;
                    $task = '';
                    $task = $message['task'];
                    $task_a1 = '';
                    $manager_id = $user_id;
                    $asgtkn = $task_details->asgtkn;
                    $user_id = $quality_id;
                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $quality_id";
                    $message['user_name'] = DB::select($query)[0]->name;

                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $manager_id";
                    $message['manager_name'] = DB::select($query)[0]->name;
                    $mnger_name = $message['manager_name'];
                    $name = $message['name'];
                    $message_save = '';
                    $message_save = "$mnger_name has Verified the $name ($task) task . Please Check.";

                    notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);
                    $qa_status = 'Verify';

                    if ($task_details->task_a1 == 'P1' && $task_details->task == 'A') {
                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p1' => 'P', 'dm_p1' => 'V', 'qa_p1' => 'P' , 'status_flag' => 1,'family_status' => 7]);

                        $family_remarks = new Remarks();
                        $family_remarks->family_id = $assignment_id;
                        $family_remarks->dm_id = $manager_id;
                        $family_remarks->dm_remarks = $remark_p1;
                        $family_remarks->user_id = $task_details->user_id;
                        $family_remarks->dm_status = 'V';
                        $family_remarks->task_type ='P1';
                        $family_remarks->task =$task_details->task;
                        $result= $family_remarks->save();

                    }
                    if ($task_details->task_a1 == 'P2' && $task_details->task == 'A') {
                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p2' => 'P', 'dm_p2' => 'V', 'qa_p2' => 'P' , 'status_flag' => 1,'family_status' => 5]);
                        $family_remarks = new Remarks();
                        $family_remarks->family_id = $assignment_id;
                        $family_remarks->dm_id = $manager_id;
                        $family_remarks->dm_remarks = $remark_p2;
                        $family_remarks->user_id = $task_details->user_id;
                        $family_remarks->dm_status = 'V';
                        $family_remarks->task_type ='P2';
                        $family_remarks->task =$task_details->task;
                        $result= $family_remarks->save();
                    }
                    if ($task_details->task == 'R') {
                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'V', 'qa_r' => 'P' , 'status_flag' => 1]);
                        $family_remarks = new Remarks();
                        $family_remarks->family_id = $assignment_id;
                        $family_remarks->dm_id = $manager_id;
                        $family_remarks->dm_remarks = $remark;
                        $family_remarks->dm_status = 'V';
                        $family_remarks->task_type ='R';
                        $family_remarks->task =$task_details->task;
                        $result= $family_remarks->save();
                    }
                }

                if ($qastatus == 'R') {
                    $family_status = $task_details->user_id == $request->post('user_id') ? 6 : 8;
                    $task_type_p1 = '';
                    $task_type_p2 = '';



                        if($task_details->task_a1 == 'P1')
                        {
                            $task_type_p1 = $task_details->task_a1;
                        }
                        elseif($task_details->task_a1 == 'P2'){
                            $task_type_p2 = $task_details->task_a1;
                        }
                        elseif($task_details->task_a1 == ''){
                            $task_type_r = 'R';
                        }



                    if (!empty($task_type_p1)) {


                        $message['status'] = $qastatus;
                        $qa_status = 'Rejected';
                        $family_mst = new Preanalytics();
                        $family_mst->assignment_type = $task_details->assignment_type;
                        $family_mst->assignment_id = $task_details->assignment_id;
                        $family_mst->task = $task_details->task;
                        $family_mst->status = 'P';
                        $family_mst->task_a1 = $task_type_p1;
                        //$family_mst->asgtkn = substr(md5(mt_rand()), 0, 16);
                        $family_mst->asgtkn = assignToken();
                        $family_mst->user_id = $request->post('user_id');
                        $family_mst->remark = $remark_p1;

                        $family_mst->created_by = $user->id;

                        $result = $family_mst->save();

                        // remarks
                        $family_remarks = new Remarks();
                        $family_remarks->user_id = $request->post('user_id');
                        $family_remarks->family_id = $assignment_id;
                        $family_remarks->dm_id = $user->id;
                        $family_remarks->dm_remarks = $remark_p1;
                        $family_remarks->dm_status = 'R';
                        $family_remarks->task_type ='P1';
                        $family_remarks->task =$task_details->task;
                        $family_remarks->qa_flag =1;
                        $result= $family_remarks->save();

                        // notification
                        $task = '';
                        $name = '';

                        $message['task'] = 'FAMILY';
                        $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->fp_member_name;

                        $mst_id = $id;

                        $assignment_type = $task_details->assignment_type;

                        $task_a1 = '';
                        $manager_id = $user_id;

                        $asgtkn = $task_details->asgtkn;
                        $user_id = $fac_id;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $fac_id";
                        $message['user_name'] = DB::select($query)[0]->name;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $manager_id";
                        $message['manager_name'] = DB::select($query)[0]->name;
                        $message_save = '';

                        $name = $message['name'];
                        $task = $message['task'];
                        $mnger_name = $message['manager_name'];
                        $message_save = '';
                        $message_save = "$mnger_name has Rejected the $name ($task) task . Please Check.";
                        notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);

                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p1' => 'P', 'dm_p1' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 0 ,'family_status' => $family_status]);

                        if ($task_details->task_a1 == 'P2' && $task_details->task == 'A') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p2' => 'P', 'dm_p2' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 1]);
                        }
                        if ($task_details->task == 'R') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 1]);
                        }
                    }
                    if (!empty($task_type_p2)) {

                        $message['status'] = $qastatus;
                        $qa_status = 'Rejected';
                        $family_mst = new Preanalytics();
                        $family_mst->assignment_type = $task_details->assignment_type;
                        $family_mst->assignment_id = $task_details->assignment_id;
                        $family_mst->task = $task_details->task;
                        $family_mst->status = 'P';
                        $family_mst->task_a1 = $task_type_p2;
                        //$family_mst->asgtkn = substr(md5(mt_rand()), 0, 16);
                        $family_mst->asgtkn = assignToken();
                        $family_mst->user_id = $request->post('user_id');
                        $family_mst->remark = $remark_p2;

                        $family_mst->created_by = $user->id;

                        $result = $family_mst->save();


                         // remarks
                         $family_remarks = new Remarks();
                         $family_remarks->user_id = $request->post('user_id');
                         $family_remarks->family_id = $assignment_id;
                         $family_remarks->dm_id = $user->id;
                         $family_remarks->dm_remarks = $remark_p2;
                         $family_remarks->dm_status = 'R';
                         $family_remarks->task_type ='P2';
                         $family_remarks->qa_flag =1;
                        $family_remarks->task =$task_details->task;
                         $result= $family_remarks->save();

                        // notification
                        $task = '';
                        $name = '';

                        $message['task'] = 'FAMILY';
                        $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->fp_member_name;

                        $mst_id = $id;

                        $assignment_type = $task_details->assignment_type;

                        $task_a1 = '';
                        $manager_id = $user_id;

                        $asgtkn = $task_details->asgtkn;
                        $user_id = $fac_id;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $fac_id";
                        $message['user_name'] = DB::select($query)[0]->name;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $manager_id";
                        $message['manager_name'] = DB::select($query)[0]->name;
                        $message_save = '';

                        $name = $message['name'];
                        $task = $message['task'];
                        $mnger_name = $message['manager_name'];
                        $message_save = '';
                        $message_save = "$mnger_name has Rejected the $name ($task) task . Please Check.";
                        notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);

                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p2' => 'P', 'dm_p2' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 1 ,'family_status' => $family_status]);

                        if ($task_details->task == 'R') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 1]);
                        }
                    }
                    if (!empty($task_type_r)) {

                        $message['status'] = $qastatus;
                        $qa_status = 'Rejected';
                        $family_mst = new Preanalytics();
                        $family_mst->assignment_type = $task_details->assignment_type;
                        $family_mst->assignment_id = $task_details->assignment_id;
                        $family_mst->task = $task_details->task;
                        $family_mst->status = 'P';
                        $family_mst->task_a1 = $task_type_r;
                        //$family_mst->asgtkn = substr(md5(mt_rand()), 0, 16);
                        $family_mst->asgtkn = assignToken();
                        $family_mst->user_id = $request->post('user_id');
                        $family_mst->remark = $remark;

                        $family_mst->created_by = $user->id;

                        $result = $family_mst->save();

                        // remarks
                        $family_remarks = new Remarks();
                        $family_remarks->user_id = $request->post('user_id');
                        $family_remarks->family_id = $assignment_id;
                        $family_remarks->dm_id = $user->id;
                        $family_remarks->dm_remarks = $remark;
                        $family_remarks->dm_status = 'R';
                        $family_remarks->task_type ='R';
                        $family_remarks->qa_flag =1;
                        $family_remarks->task =$task_details->task;
                        $result= $family_remarks->save();

                        // notification
                        $task = '';
                        $name = '';

                        $message['task'] = 'FAMILY';
                        $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->fp_member_name;

                        $mst_id = $id;

                        $assignment_type = $task_details->assignment_type;

                        $task_a1 = '';
                        $manager_id = $user_id;

                        $asgtkn = $task_details->asgtkn;
                        $user_id = $fac_id;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $fac_id";
                        $message['user_name'] = DB::select($query)[0]->name;

                        $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $manager_id";
                        $message['manager_name'] = DB::select($query)[0]->name;
                        $message_save = '';

                        $name = $message['name'];
                        $task = $message['task'];
                        $mnger_name = $message['manager_name'];
                        $message_save = '';
                        $message_save = "$mnger_name has Rejected the $name ($task) task . Please Check.";
                        notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);
                        FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'dm_r' => 'R', 'flag' => '1', 'task_status' => 1 , 'status_flag' => 1]);
                    }
                }

                FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['qa_status' => $qa_status]);

                if ($qastatus == 'V') {
                    $task_details->qa_status = $qastatus;
                    $task_details->quality_status = 'P';
                    $task_details->remark = $remark;
                    $task_details->verified_by = $user->id;
                    $task_details->manger_date = date('d-m-Y');
                    $task_details->updated_at = date('Y-m-d H:i:s');
                    if ($qastatus == 'V') {
                        $task_details->quality_verified = $quality_id;
                    }
                    $task_details->save();
                } else {



                        $task_details = QualityCheck::find($id);
                        $task_details->qa_status = $qastatus;
                        $task_details->quality_status = 'P';
                        if($task_details->task_a1 == 'P1'){
                            $task_details->remark = $remark_p1;
                        }
                        elseif($task_details->task_a1 == 'P2'){
                            $task_details->remark = $remark_p2;
                        }
                        else{
                            $task_details->remark = $remark;
                        }
                        $task_details->verified_by = $user->id;
                        $task_details->manger_date = date('d-m-Y');
                        $task_details->updated_at = date('Y-m-d H:i:s');
                        if ($qastatus == 'V') {
                            $task_details->quality_verified = $quality_id;
                        }

                        $task_details->save();

                }

                if($business == 1){
                    $fm_mst = new Preanalytics();
                    $task = 'A';
                    $task_a1 = 'P2';

                    $fm_mst->assignment_id = $assignment_id;
                    $fm_mst->assignment_type = "FM";
                    $fm_mst->task = $task;
                    $fm_mst->task_a1 = $task_a1;
                    $fm_mst->asgtkn = assignToken();
                    $fm_mst->user_id = $fac_id;
                    $fm_mst->remark = $remark;
                    $fm_mst->created_by = $user->id;
                    $result = $fm_mst->save();
                    FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['family_buisness' => 1,'family_status' => 4]);
                }



                $data['message'] = 'Task Updated successfully';
                $data['result'] = 1;
                echo json_encode($data);
            } else {
                $data['message'] = 'Invalid Request';
                $data['result'] = 0;
                echo json_encode($data);
            }
        } catch (\Exception $e) {
            print_r($e->postMessage());
        }
        exit;
    }

    public function change_qa_status_fed1(Request $request)
    {
        // prd($request->all());
        $qastatus = $request->post('sts');
        $remark = urldecode($request->post('rmk'));
        $user = Auth::User();
        $admin_id = $user->parent_id;

        $id = $request->post('id');
        try {
            if ($id > 0) {
                $task_details = QualityCheck::find($id);
                $task_details->quality_status = $qastatus;
                $task_details->quality_remark = $remark;
                $task_details->quality_verified = $user->id;
                $task_details->quality_date = date('d-m-Y');
                $task_details->updated_at = date('Y-m-d H:i:s');
                // prd($task_details);
                $task_details->save();


                $quality_id = $task_details->quality_verified;
                $verify_by = $task_details->verified_by;

                $assignment_id = $task_details->assignment_id;

                $asgtkn = $task_details->asgtkn;
                qa_historyData($asgtkn, $assignment_id, $task_details->assignment_type, $task_details->task, $task_details->task_a1, $qastatus, $remark, $user->id);
                if ($task_details->task == 'A') {
                    $cureent_status = 'AP';
                }
                if ($task_details->task == 'R') {
                    $cureent_status = 'RP';
                }
                if ($qastatus == 'V') {
                    // notification
                    $message['status'] = $qastatus;
                    $task = '';
                    $name = '';
                    if ($task_details->assignment_type == 'FD') {
                        $message['task'] = 'FEDERATION';
                        $query = "SELECT name_of_federation FROM federation_profile WHERE is_deleted = 0 AND federation_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->name_of_federation;
                    } else if ($task_details->assignment_type == 'CL') {
                        $message['task'] = 'CLUSTER';
                        $query = "SELECT name_of_cluster FROM cluster_profile WHERE is_deleted = 0 AND cluster_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->name_of_cluster;
                    } else if ($task_details->assignment_type == 'SH') {
                        $message['task'] = 'SHG';
                        $query = "SELECT shgName FROM shg_profile WHERE is_deleted = 0 AND shg_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->shgName;
                    } else if ($task_details->assignment_type == 'FM') {
                        $message['task'] = 'FAMILY';
                        $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->fp_member_name;
                    }

                    $mst_id = $id;

                    $assignment_type = $task_details->assignment_type;

                    $task_a1 = '';
                    $manager_id = $quality_id;

                    $asgtkn = $task_details->asgtkn;
                    $user_id = $admin_id;
                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $quality_id";
                    $message['manager_name'] = DB::select($query)[0]->name;

                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $admin_id";
                    $message['user_name'] = DB::select($query)[0]->name;
                    $quality_name = $message['manager_name'];
                    $name = $message['name'];
                    $task = $message['task'];
                    $message_save = '';
                    $message_save = "$quality_name has Verified the $name ($task) task . Please Check.";
                    notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);
                    $qa_status = 'Verify';
                    if ($task_details->assignment_type == 'FD') {
                        if ($task_details->task == 'A') {
                            FederationSubMst::where([['federation_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'qa_a' => 'V' , 'status_flag' => 1]);

                            FedRemarks::where([['fed_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'V' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'A' ,'qa_flag' => 1]);

                        } else {
                            FederationSubMst::where([['federation_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'qa_r' => 'V' ,  'status_flag' => 1]);

                            FedRemarks::where([['fed_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'V' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'R' ,'qa_flag' => 1]);
                        }
                    }
                    if ($task_details->assignment_type == 'CL') {
                        if ($task_details->task == 'A') {
                            ClusterSubMst::where([['cluster_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'qa_a' => 'V' , 'status_flag' => 1]);

                            ClusterRemarks::where([['cluster_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'V' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'A' ,'qa_flag' => 1]);
                        } else {
                            ClusterSubMst::where([['cluster_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'qa_r' => 'V' ,  'status_flag' => 1]);

                            ClusterRemarks::where([['cluster_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'V' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'R' ,'qa_flag' => 1]);
                        }
                    }
                    if ($task_details->assignment_type == 'SH') {
                        if ($task_details->task == 'A') {
                            ShgSubMst::where([['shg_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'qa_a' => 'V' , 'status_flag' => 1]);
                            SHGRemarks::where([['shg_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'V' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'A' ,'qa_flag' => 1]);
                        } else {
                            ShgSubMst::where([['shg_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'qa_r' => 'V' ,  'status_flag' => 1]);

                            SHGRemarks::where([['shg_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'V' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'R' ,'qa_flag' => 1]);
                        }
                    }
                    if ($task_details->assignment_type == 'FM') {
                        // if ($task_details->task_a1 == 'P1' && $task_details->task == 'A') {
                        //     FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p1' => 'P', 'qa_p1' => 'V']);
                        // }
                        if ($task_details->task == 'A') {
                            $family_status = $task_details->task_a1 == 'P1' ? 9 : ($task_details->task_a1 == 'P2' ? 11 : null);
                            $subquery = "SELECT id from task_qa_assignment WHERE assignment_type='FM' AND task_a1='P1' AND assignment_id=$assignment_id ORDER  BY id DESC LIMIT 1";
                            $result_subquery = DB::select($subquery);
                            $id = $result_subquery[0]->id;

                            $query = "UPDATE task_qa_assignment set quality_status= 'V',quality_remark='" . $remark . "',quality_verified='$user->id',quality_date='" . date('d-m-Y') . "' WHERE id = $id ";
                            //prd($query);
                            $result = DB::update($query);

                            Remarks::where([['family_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'V' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'A' ,'qa_flag' => 1]);

                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p2' => 'P', 'qa_p2' => 'V', 'p1' => 'P', 'qa_p1' => 'V' ,  'status_flag' => 1, 'family_status' => $family_status]);
                        }
                        if ($task_details->task == 'R') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'qa_r' => 'V' , 'status_flag' => 1]);

                            Remarks::where([['family_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'V' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'R' ,'qa_flag' => 1]);
                        }
                    }
                }

                if ($qastatus == 'R') {
                    // notification
                    $message['status'] = $qastatus;
                    $task = '';
                    $name = '';
                    if ($task_details->assignment_type == 'FD') {
                        $message['task'] = 'FEDERATION';
                        $query = "SELECT name_of_federation FROM federation_profile WHERE is_deleted = 0 AND federation_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->name_of_federation;
                    } else if ($task_details->assignment_type == 'CL') {
                        $message['task'] = 'CLUSTER';
                        $query = "SELECT name_of_cluster FROM cluster_profile WHERE is_deleted = 0 AND cluster_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->name_of_cluster;
                    } else if ($task_details->assignment_type == 'SH') {
                        $message['task'] = 'SHG';
                        $query = "SELECT shgName FROM shg_profile WHERE is_deleted = 0 AND shg_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->shgName;
                    } else if ($task_details->assignment_type == 'FM') {
                        $message['task'] = 'FAMILY';
                        $query = "SELECT fp_member_name FROM family_profile WHERE is_deleted = 0 AND family_sub_mst_id = $assignment_id";
                        $message['name'] = DB::select($query)[0]->fp_member_name;
                    }

                    $mst_id = $id;

                    $assignment_type = $task_details->assignment_type;

                    $task_a1 = '';
                    $manager_id = $quality_id;

                    $asgtkn = $task_details->asgtkn;
                    $user_id = $verify_by;
                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $quality_id";
                    $message['manager_name'] = DB::select($query)[0]->name;

                    $query = "SELECT name FROM users WHERE is_deleted = 0 AND id = $verify_by";
                    $message['user_name'] = DB::select($query)[0]->name;

                    $quality_name = $message['manager_name'];
                    $name = $message['name'];
                    $task = $message['task'];
                    $message_save = '';
                    $message_save = "$quality_name has Rejected the $name ($task) task . Please Check.";

                    notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);


                    if ($task_details->assignment_type == 'FD') {
                        if ($task_details->task == 'A') {
                            FederationSubMst::where([['federation_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'qa_a' => 'R' ,  'status_flag' => 0]);

                            FedRemarks::where([['fed_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'R' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'A' ,'qa_flag' => 1]);
                        } else {
                            FederationSubMst::where([['federation_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'qa_r' => 'R' ,  'status_flag' => 0]);

                            FedRemarks::where([['fed_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'R' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'R' ,'qa_flag' => 1]);
                        }
                    }
                    if ($task_details->assignment_type == 'CL') {
                        if ($task_details->task == 'A') {
                            ClusterSubMst::where([['cluster_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'qa_a' => 'R' ,  'status_flag' => 0]);

                            ClusterRemarks::where([['cluster_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'R' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'A' ,'qa_flag' => 1]);
                        } else {
                            ClusterSubMst::where([['cluster_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'qa_r' => 'R' ,  'status_flag' => 0]);

                            ClsuterRemarks::where([['cluster_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'R' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'R' ,'qa_flag' => 1]);
                        }
                    }
                    if ($task_details->assignment_type == 'SH') {
                        if ($task_details->task == 'A') {
                            ShgSubMst::where([['shg_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'qa_a' => 'R' ,  'status_flag' => 0]);
                            SHGRemarks::where([['shg_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'R' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'A' ,'qa_flag' => 1]);
                        } else {
                            ShgSubMst::where([['shg_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'qa_r' => 'R' ,  'status_flag' => 0]);

                            SHGRemarks::where([['shg_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'R' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'R' ,'qa_flag' => 1]);
                        }
                    }
                    if ($task_details->assignment_type == 'FM') {

                        // if ($task_details->task_a1 == 'P1' && $task_details->task == 'A') {
                        //     FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p1' => 'P', 'qa_p1' => 'R']);
                        // }

                        if ( $task_details->task == 'A') {
                            $family_status = $task_details->task_a1 == 'P1' ? 10 : ($task_details->task_a1 == 'P2' ? 12 : null);
                            $subquery = "SELECT id from task_qa_assignment WHERE assignment_type='FM' AND task_a1='P1' AND assignment_id=$assignment_id ORDER  BY id DESC LIMIT 1";
                            $result_subquery = DB::select($subquery);
                            $id = $result_subquery[0]->id;
                            $query = "UPDATE task_qa_assignment set quality_status= 'R',quality_remark='" . $remark . "',quality_verified='$user->id',quality_date='" . date('d-m-Y') . "' WHERE id = $id ";
                            //prd($query);
                            $result = DB::update($query);
                            Remarks::where([['family_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'R' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'A' ,'qa_flag' => 1]);

                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'analytics' => 'P', 'p2' => 'P', 'qa_p2' => 'R', 'p1' => 'P', 'qa_p1' => 'R' , 'status_flag' => 0,'family_status' => $family_status]);
                        }

                        if ($task_details->task == 'R') {
                            FamilySubMst::where([['family_mst_id', '=', $assignment_id], ['status', '=', 'A']])->update(['cureent_status' => $cureent_status, 'rating' => 'P', 'qa_r' => 'R' , 'status_flag' => 0]);
                            Remarks::where([['family_id', '=', $assignment_id], ['qa_flag', '=', 0]])->update(['qa_status' => 'R' , 'qa_remarks' => $remark, 'qa_id' => $user->id ,'task' => 'R' ,'qa_flag' => 1]);
                        }
                    }
                }
                $data['message'] = 'Task Updated successfully';
                $data['result'] = 1;
                echo json_encode($data);
            } else {
                $data['message'] = 'Invalid Request';
                $data['result'] = 0;
                echo json_encode($data);
            }
        } catch (\Exception $e) {
            print_r($e->postMessage());
        }
        exit;
    }
    public function get_rating_ques($mst_category_id)
    {
        $subcategory = DB::table('rating_mst_sub_category as a')
            ->select('a.mst_id', 'a.mst_subcat_name')
            ->where('a.mst_category_id', '=', $mst_category_id)
            ->where('a.is_deleted', '=', 0)
            ->where('a.mst_subcat_status', '=', 'A')
            ->get()->toArray();
        foreach ($subcategory as $key => $row) {
            $row->question = DB::table('rating_mst_ques_list as a')
                ->select('a.mst_id', 'a.mst_ques_name')
                ->where('a.mst_sub_category_id', '=', $row->mst_id)
                ->where('a.is_deleted', '=', 0)
                ->where('a.mst_ques_status', '=', 'A')
                ->get()->toArray();
        }
        foreach ($subcategory as $key => $value) {
            foreach ($value->question as $key => $row) {
                $row->ans = DB::table('rating_mst_qam_set as a')
                    ->where('a.mst_ques_id', '=', $row->mst_id)
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.mst_status', '=', 'A')
                    ->get()->toArray();
            }
        }
        return $subcategory;
    }
    public function export_pdf()
    {
        $data = [];
        $total = 0;
        $user = Auth::User();
        // // prd($user);
        //$data['u_type'] = $user->u_type;

        //$u_type='M';

        $data = [];
        $user_geo = DB::table('user_location_relation')
            ->where('user_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->orderBy('country_id')
            ->get()->toArray();


        $query ="SELECT group_concat(users.id) AS ids FROM users where parent_id = $user->id AND  is_deleted = 0";
        if($user->u_type == 'M'){
        $query .=" AND u_type = 'F'";
        }
        elseif ($user->u_type == 'QA'){
            $query .=" AND u_type = 'M'";
        }
        $fac_list = DB::select($query);

        $list  = $fac_list[0]->ids ?? 0;

        $session_data = Session::get('quality_filter_session');
        if (!empty($session_data)) {
            $status_type = $session_data['type'];
            $data['group'] = $session_data['group'];
            $data['status_t'] = $session_data['type'];
            if (!empty($session_data['group']) && !empty($session_data['type'])) {
                if ($session_data['group'] == 'ALL') {
                    if ($user->u_type == 'QA') {

                        $query = "SELECT * FROM (SELECT
                            Y.id,
                            Y.user_id,
                            Y.assignment_type,
                            Y.task,
                            Y.task_a1,
                            Y.qa_status,
                            Y.quality_status,
                            Y.manger_date,
                            Y.quality_date,
                            j.name_of_federation as name,
                            e.name as fac_name,
                            i.uin,
                            i.id AS ids,
                            Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN federation_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN federation_sub_mst AS s
                            ON
                                i.id = s.federation_mst_id
                            INNER JOIN federation_profile AS j
                            ON
                                j.federation_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'FD' AND i.is_deleted=0 ";

                                if ($status_type == 'ALL') {
                                    $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V')  ";
                                }
                                if ($status_type == 'C') {
                                    $query .= " AND (Y.quality_status = 'V' || Y.quality_status = 'R' ) ";
                                }
                                if ($status_type == 'P') {

                                    $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'  ";
                                }
                                if(!empty($session_data['Search'])){
                                   if(!empty($session_data['agency'])){
                                       $agency = $session_data['agency'];
                                       $query .=" AND i.agency_id = $agency  ";
                                    }
                                    if(!empty($session_data['federation'])){
                                       $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                                    }


                                   if(!empty($session_data['dm'])){
                                       $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                                     }
                                     else{
                                       $query .= " AND  verified_by IN($list)";
                                     }
                               }

                        // prd($query);
                        $query .= "    UNION ALL
                            SELECT
                                Y.id,
                                Y.user_id,
                                Y.assignment_type,
                                Y.task,
                                Y.task_a1,
                                Y.qa_status,
                                Y.quality_status,
                                Y.manger_date,
                                Y.quality_date,
                                j.name_of_cluster as name,
                                e.name as fac_name,
                                i.uin,
                                i.id AS ids,
                                Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN cluster_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN cluster_sub_mst AS s
                            ON
                                i.id = s.cluster_mst_id
                            INNER JOIN cluster_profile AS j
                            ON
                                j.cluster_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'CL' AND i.is_deleted=0 ";

                                if ($status_type == 'ALL') {
                                    $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V') ";
                                }
                                if ($status_type == 'C') {
                                    $query .= " AND (Y.quality_status = 'V' || Y.quality_status = 'R' ) ";
                                }
                                if ($status_type == 'P') {

                                    $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P' ";
                                }
                                if(!empty($session_data['Search'])){
                                   if(!empty($session_data['agency'])){
                                       $agency = $session_data['agency'];
                                       $query .=" AND i.agency_id = $agency  ";
                                    }

                                    if(!empty($session_data['cluster'])){
                                       $query .=" AND i.uin = '" . $session_data['cluster'] . "' ";
                                    }


                                if(!empty($session_data['dm'])){
                                       $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                                     }
                                     else{
                                       $query .= " AND  verified_by IN($list)";
                                     }
                                   }
                        $query .= "   UNION ALL
                            SELECT
                                Y.id,
                                Y.user_id,
                                Y.assignment_type,
                                Y.task,
                                Y.task_a1,
                                Y.qa_status,
                                Y.quality_status,
                                Y.manger_date,
                                Y.quality_date,
                                j.shgName as name,
                                e.name as fac_name,
                                i.uin,
                                i.id AS ids,
                                Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN shg_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN shg_sub_mst AS s
                            ON
                                i.id = s.shg_mst_id
                            INNER JOIN shg_profile AS j
                            ON
                                j.shg_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'SH' AND i.is_deleted=0 ";

                                if ($status_type == 'ALL') {
                                    $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V') ";
                                }
                                if ($status_type == 'C') {
                                    $query .= " AND (Y.quality_status = 'V' || Y.quality_status = 'R' ) ";
                                }
                                if ($status_type == 'P') {

                                    $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P' ";
                                }
                                if(!empty($session_data['Search'])){
                                   if(!empty($session_data['agency'])){
                                       $agency = $session_data['agency'];
                                       $query .=" AND i.agency_id = $agency  ";
                                    }

                                    if(!empty($session_data['shg'])){
                                       $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                                    }


                                if(!empty($session_data['dm'])){
                                       $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                                     }
                                     else{
                                       $query .= " AND  verified_by IN($list)";

                                     }
                                   }


                        $query .= " UNION ALL
                                    SELECT
                            a.id ,
                            a.user_id,
                            a.assignment_type,
                            a.task,
                            a.task_a1,
                            a.qa_status,
                            a.quality_status,
                            a.manger_date,
                            a.quality_date,
                            b.fp_member_name as name,
                            c.name as fac_naame,
                            b.uin,
                            b.id AS ids,
                            a.updated_at ";

                        $query .= " FROM
                            (
                            (
                            SELECT
                                id,
                                assignment_id,
                                user_id,
                                task_a1,
                                qa_status,
                                quality_status,
                                task,
                                manger_date,
                                quality_date,assignment_type,
                                updated_at
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM' AND task_a1 = 'P2' AND is_deleted=0 ";


                        if ($status_type == 'ALL') {
                            $query .= " AND qa_status = 'V' AND (quality_status = 'P' OR quality_status = 'R' OR quality_status = 'V') ";
                        }
                        if ($status_type == 'C') {
                            $query .= "   AND (quality_status = 'R' OR quality_status = 'V') ";
                        }
                        if ($status_type == 'P') {

                            $query .= " AND qa_status = 'V' AND(quality_status = 'P' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND verified_by in ($list)";
                             }
                         }

                        $query .= "ORDER BY
                        updated_at
                            DESC

                            ) a";
                        $query .= "    INNER JOIN(
                            SELECT
                            a.id,
                            a.uin,
                            c.fp_member_name,
                            f.shgName,
                            g.agency_name
                            FROM
                            family_mst a
                            INNER JOIN family_sub_mst b ON
                            a.id = b.family_mst_id
                            INNER JOIN family_profile c ON
                            b.id = c.family_sub_mst_id
                            INNER JOIN shg_mst d ON
                            a.shg_uin = d.uin
                            INNER JOIN shg_sub_mst e ON
                            d.id = e.shg_mst_id
                            INNER JOIN shg_profile f ON
                            e.id = f.shg_sub_mst_id
                            INNER JOIN agency g ON
                            a.agency_id = g.agency_id
                            WHERE
                            a.is_deleted = 0 AND b.dm_p1 = 'V' AND b.dm_p2 = 'V' ";

                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND a.agency_id = $agency  ";
                            }
                            if(!empty($session_data['family'])){
                               $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                            }
                         }

                        $query .= " ) b
                            ON
                            a.assignment_id = b.id
                            INNER JOIN users c ON
                            a.user_id = c.id
                            )
                            UNION ALL
                            SELECT
                            a.id ,
                            a.user_id,
                            a.assignment_type,
                            a.task,
                            a.task_a1,
                            a.qa_status,
                            a.quality_status,
                            a.manger_date,
                            a.quality_date,
                            b.fp_member_name as name,
                            c.name fac_name,
                            b.uin,
                            b.id AS ids,
                            a.updated_at
                            FROM
                            (
                            (
                            SELECT
                                id,
                                assignment_id,
                                user_id,
                                task_a1,
                                qa_status,
                                quality_status,
                                task,
                                manger_date,
                                quality_date,
                                assignment_type,
                                updated_at
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM'  AND task = 'R' AND is_deleted=0 ";

                        if ($status_type == 'ALL') {
                            $query .= " AND qa_status = 'V' AND (quality_status = 'P' OR quality_status = 'R' OR quality_status = 'V') ";
                        }
                        if ($status_type == 'C') {
                            $query .= "   AND (quality_status = 'R' OR quality_status = 'V') ";
                        }
                        if ($status_type == 'P') {

                            $query .= " AND qa_status = 'V' AND(quality_status = 'P' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND verified_by in ($list)";
                             }
                         }

                        $query .= "    ORDER BY
                        updated_at
                            DESC

                            ) a
                            INNER JOIN(
                            SELECT
                            a.id,
                            a.uin,
                            c.fp_member_name,
                            f.shgName,
                            g.agency_name
                            FROM
                            family_mst a
                            INNER JOIN family_sub_mst b ON
                            a.id = b.family_mst_id
                            INNER JOIN family_profile c ON
                            b.id = c.family_sub_mst_id
                            INNER JOIN shg_mst d ON
                            a.shg_uin = d.uin
                            INNER JOIN shg_sub_mst e ON
                            d.id = e.shg_mst_id
                            INNER JOIN shg_profile f ON
                            e.id = f.shg_sub_mst_id
                            INNER JOIN agency g ON
                            a.agency_id = g.agency_id
                            WHERE
                            a.is_deleted = 0";


                    if ($status_type == 'ALL') {
                        $query .= "  AND b.dm_r = 'V'  AND (
                             (b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' ) OR(b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' )
                        )";
                    }
                    if ($status_type == 'P') {
                        $query .= " AND b.qa_r = 'P'";
                    }
                    if ($status_type == 'C') {
                        $query .= " AND b.qa_p2 = 'V' AND (b.qa_r = 'V' OR b.qa_r = 'R' )";
                    }
                    if(!empty($session_data['Search'])){
                       if(!empty($session_data['agency'])){
                           $agency = $session_data['agency'];
                           $query .=" AND a.agency_id = $agency  ";
                        }

                        if(!empty($session_data['family'])){
                           $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                        }
                     }
                    $query .= "
                   ) b
                   ON
                   a.assignment_id=b.id INNER JOIN users c on a.user_id=c.id)
                   )a ";

                       //      date_default_timezone_set("Asia/Calcutta");
                       //  prd(date('Y-m-d H:i:s'));

                    } else {
                        $query = " SELECT * FROM (SELECT
                           Y.id ,
                           Y.user_id,
                           Y.dm_id,
                           Y.assignment_type,
                           Y.task,
                           Y.task_a1,
                           Y.qa_status,
                           Y.quality_status,
                           Y.manger_date,
                           Y.quality_date,
                           j.name_of_federation as name,
                           e.name as fac_name,
                           i.uin,
                           i.id AS ids,
                           Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN federation_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN federation_sub_mst AS s
                            ON
                                i.id = s.federation_mst_id
                            INNER JOIN federation_profile AS j
                            ON
                                j.federation_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'FD' AND i.is_deleted=0 ";


                        if ($user->u_type == 'M') {
                            if ($status_type == 'P') {
                                $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V')) ";
                            }
                            if(!empty($session_data['Search'])){
                               if(!empty($session_data['agency'])){
                                   $agency = $session_data['agency'];
                                   $query .=" AND i.agency_id = $agency  ";
                                }
                                if(!empty($session_data['federation'])){
                                   $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                                }

                             }
                             if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }

                           //  $query .= " AND Y.dm_id in ($user->id)";
                        }

                        if ($user->u_type == 'CEO' || $user->u_type == 'A') {
                            if ($status_type == 'ALL') {
                                $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                            }

                            if ($status_type == 'P') {

                                $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                            }
                        }

                        // prd($query);
                        $query .= " UNION ALL
                            SELECT
                                Y.id,
                                Y.user_id,
                                Y.dm_id,
                                Y.assignment_type,
                                Y.task,
                                Y.task_a1,
                                Y.qa_status,
                                Y.quality_status,
                                Y.manger_date,
                                Y.quality_date,
                                j.name_of_cluster as name,
                                e.name as fac_name,
                                i.uin,
                                i.id AS ids,
                                Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN cluster_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN cluster_sub_mst AS s
                            ON
                                i.id = s.cluster_mst_id
                            INNER JOIN cluster_profile AS j
                            ON
                                j.cluster_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'CL' AND i.is_deleted=0 ";


                        if ($user->u_type == 'M') {
                            if ($status_type == 'P') {
                                $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                            }
                            if(!empty($session_data['Search'])){
                               if(!empty($session_data['agency'])){
                                   $agency = $session_data['agency'];
                                   $query .=" AND i.agency_id = $agency  ";
                                }
                                if(!empty($session_data['cluster'])){
                                   $query .=" AND i.uin = '" . $session_data['cluster'] . "' ";
                                }

                             }
                             if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                           // $query .= " AND Y.dm_id in ($user->id)";

                        }

                        if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                            }
                            if ($status_type == 'P') {
                                $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                            }
                        }
                        // prd($query);
                        $query .= "UNION ALL
                            SELECT
                                Y.id ,
                                Y.user_id,
                                Y.dm_id,
                                Y.assignment_type,
                                Y.task,
                                Y.task_a1,
                                Y.qa_status,
                                Y.quality_status,
                                Y.manger_date,
                                Y.quality_date,
                                j.shgName as name,
                                e.name fac_name,
                                i.uin,
                                i.id AS ids,
                                Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN shg_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN shg_sub_mst AS s
                            ON
                                i.id = s.shg_mst_id
                            INNER JOIN shg_profile AS j
                            ON
                                j.shg_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'SH' AND i.is_deleted=0 ";


                        if ($user->u_type == 'M') {
                            if ($status_type == 'P') {
                                $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                            }
                            if(!empty($session_data['Search'])){
                               if(!empty($session_data['agency'])){
                                   $agency = $session_data['agency'];
                                   $query .=" AND i.agency_id = $agency  ";
                                }
                                if(!empty($session_data['shg'])){
                                   $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                                }

                             }
                             if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                           //  $query .= " AND Y.dm_id in ($user->id)";

                        }

                        if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                            }
                            if ($status_type == 'P') {
                                $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                            }
                        }

                        $query .= " UNION ALL
                                SELECT
                                    Y.id ,
                                    Y.user_id,
                                    Y.dm_id,
                                    Y.assignment_type,
                                    Y.task,
                                    Y.task_a1,
                                    Y.qa_status,
                                    Y.quality_status,
                                    Y.manger_date,
                                    Y.quality_date,
                                    j.fp_member_name as name,
                                    e.name as fac_name,
                                    i.uin,
                                    i.id AS ids,
                                    Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN family_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN family_sub_mst AS s
                            ON
                                i.id = s.family_mst_id
                            INNER JOIN family_profile AS j
                            ON
                                j.family_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'FM' AND i.is_deleted=0 ";


                        if ($user->u_type == 'M') {
                            if ($status_type == 'P') {
                                $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                            }
                            if(!empty($session_data['Search'])){
                               if(!empty($session_data['agency'])){
                                   $agency = $session_data['agency'];
                                   $query .=" AND i.agency_id = $agency  ";
                                }
                                if(!empty($session_data['family'])){
                                   $query .=" AND i.uin = '" . $session_data['family'] . "' ";
                                }
                             }
                             if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                           //  $query .= " AND Y.dm_id in ($user->id)";

                        }

                        if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                            }
                            if ($status_type == 'P') {
                                $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                            }
                        }
                        // prd($query);
                        $query .= ")a ORDER BY a.updated_at DESC ";
                    }
                }
                if ($session_data['group'] == 'FM') {
                    if ($user->u_type == 'QA') {

                        $query = "
                       SELECT
                           *
                       FROM
                           (
                           SELECT
                               a.id,
                               a.user_id,
                               a.task_a1,
                               a.assignment_type,
                               a.qa_status,
                               a.quality_status,
                               a.task,
                               a.manger_date,
                               a.quality_date,
                               b.id AS ids,
                               b.uin,
                               b.fp_member_name AS name,
                               b.shgName,
                               b.agency_name,
                               c.name as fac_name,
                               a.updated_at
                           FROM
                            (
                                (
                                SELECT
                                    id,
                                    assignment_id,
                                    assignment_type,
                                    user_id,
                                    task_a1,
                                    qa_status,
                                    quality_status,
                                    task,
                                    manger_date,
                                    quality_date,
                                    updated_at
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'FM' AND task_a1 = 'P2' AND is_deleted=0 ";
                        if ($status_type == 'ALL') {
                            $query .= " AND qa_status = 'V' AND(quality_status = 'R' OR quality_status = 'P' OR quality_status = 'V' ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND qa_status = 'V' AND quality_status = 'P' ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND qa_status = 'V' AND(quality_status = 'R'  OR quality_status = 'V' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND verified_by in ($list)";
                             }
                         }

                        $query .= "
                                ORDER BY
                                    id
                                DESC
                            ) a
                        INNER JOIN(
                            SELECT
                                a.id,
                                a.uin,
                                c.fp_member_name,
                                f.shgName,
                                g.agency_name
                            FROM
                                family_mst a
                            INNER JOIN family_sub_mst b ON
                                a.id = b.family_mst_id
                            INNER JOIN family_profile c ON
                                b.id = c.family_sub_mst_id
                            INNER JOIN shg_mst d ON
                                a.shg_uin = d.uin
                            INNER JOIN shg_sub_mst e ON
                                d.id = e.shg_mst_id
                            INNER JOIN shg_profile f ON
                                e.id = f.shg_sub_mst_id
                            LEFT JOIN cluster_mst AS cl ON
                                cl.uin = a.cluster_uin
                            INNER JOIN federation_mst AS fd ON
                              fd.uin = a.federation_uin
                            INNER JOIN agency g ON
                                a.agency_id = g.agency_id
                            WHERE
                                a.is_deleted = 0";



                        if ($status_type == 'ALL') {
                            $query .= " AND  b.dm_p1 = 'V' AND b.dm_p2 = 'V' AND(
                                    (  b.qa_p2 = 'P' OR b.qa_p2 = 'R' OR b.qa_p2 = 'V' OR b.qa_r = 'V' OR b.qa_r = 'V'  )
                                )
                                ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND  b.dm_p1 = 'V' AND b.dm_p2 = 'V' AND  b.qa_p2 = 'P' ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND  b.dm_p1 = 'V' AND b.dm_p2 = 'V' AND  (b.qa_p2 = 'V' OR b.qa_p2 = 'R') ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND a.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND cl.uin = '" . $session_data['cluster'] . "' ";
                            }
                            if(!empty($session_data['shg'])){
                               $query .=" AND d.uin = '" . $session_data['shg'] . "' ";
                            }
                            if(!empty($session_data['family'])){
                               $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                            }
                         }
                        $query .= "
                        ) b
                       ON
                           a.assignment_id = b.id
                       INNER JOIN users c ON
                           a.user_id = c.id
                               )
                           UNION ALL
                       SELECT
                           a.id,
                           a.user_id,
                           a.task_a1,
                           a.assignment_type,
                           a.qa_status,
                           a.quality_status,
                           a.task,
                           a.manger_date,
                           a.quality_date,
                           b.id AS ids,
                           b.uin,
                           b.fp_member_name AS name,
                           b.shgName,
                           b.agency_name,
                           c.name as fac_name,
                           a.updated_at
                       FROM
                        (
                            (
                            SELECT
                                id,
                                assignment_id,
                                assignment_type,
                                user_id,
                                task_a1,
                                qa_status,
                                quality_status,
                                task,
                                manger_date,
                                quality_date,
                                updated_at
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM' AND task = 'R' AND is_deleted=0 ";


                        if ($status_type == 'ALL') {
                            $query .= "    AND qa_status = 'V'  AND(quality_status = 'R' OR quality_status = 'P' OR quality_status = 'V' ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= "    AND qa_status = 'V' AND quality_status = 'P' ";
                        }
                        if ($status_type == 'C') {
                            $query .= "    AND qa_status = 'V'  AND(quality_status = 'R'  OR quality_status = 'V' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND verified_by in ($list)";
                             }
                         }
                        $query .= "
                            ORDER BY
                                id
                            DESC
                        ) a
                       INNER JOIN(
                           SELECT
                               a.id,
                               a.uin,
                               c.fp_member_name,
                               f.shgName,
                               g.agency_name
                           FROM
                               family_mst a
                           INNER JOIN family_sub_mst b ON
                               a.id = b.family_mst_id
                           INNER JOIN family_profile c ON
                               b.id = c.family_sub_mst_id
                           INNER JOIN shg_mst d ON
                               a.shg_uin = d.uin
                           INNER JOIN shg_sub_mst e ON
                               d.id = e.shg_mst_id
                           INNER JOIN shg_profile f ON
                               e.id = f.shg_sub_mst_id
                           LEFT JOIN cluster_mst AS cl ON
                                cl.uin = a.cluster_uin
                           INNER JOIN federation_mst AS fd ON
                              fd.uin = a.federation_uin
                           INNER JOIN agency g ON
                               a.agency_id = g.agency_id
                           WHERE
                               a.is_deleted = 0 ";


                        if ($status_type == 'ALL') {
                            $query .= " AND b.qa_p2 = 'V'  AND (
                                 (b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' ) OR(b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' )
                            )";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND b.qa_p2 = 'V'  AND b.qa_r = 'P'";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND b.qa_p2 = 'V' AND (b.qa_r = 'V' OR b.qa_r = 'R' )";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND a.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND cl.uin = '" . $session_data['cluster'] . "' ";
                            }
                            if(!empty($session_data['shg'])){
                               $query .=" AND d.uin = '" . $session_data['shg'] . "' ";
                            }
                            if(!empty($session_data['family'])){
                               $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                            }
                         }
                        $query .= "
                       ) b
                       ON
                       a.assignment_id=b.id INNER JOIN users c on a.user_id=c.id)
                       )a ";

                    } else {
                        $query = "SELECT
                        Y.*,
                        d.agency_name,
                        j.shgName,
                        e.name as fac_name,
                        k.uin,
                        l.fp_member_name as name,
                        k.id AS ids
                    FROM
                        task_qa_assignment AS Y
                    INNER JOIN family_mst AS k
                    ON
                        k.id = Y.assignment_id
                    INNER JOIN family_sub_mst AS z
                    ON
                        z.family_mst_id = k.id
                    INNER JOIN family_profile AS l
                    ON
                        l.family_sub_mst_id = z.id
                    INNER JOIN shg_mst AS i
                    ON
                        i.uin = k.shg_uin
                    INNER JOIN shg_sub_mst AS ii
                    ON
                        i.id = ii.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = ii.id

                   LEFT JOIN cluster_mst AS c
                    ON
                        c.uin = k.cluster_uin


                   INNER JOIN federation_mst AS fd
                    ON
                        fd.uin = k.federation_uin


                    INNER JOIN agency AS d
                    ON
                        k.agency_id = d.agency_id
                    INNER JOIN users AS e
                    ON
                        Y.user_id = e.id
                    WHERE
                        Y.is_deleted = 0 AND Y.assignment_type = 'FM' AND k.is_deleted=0 ";

                        if ($user->u_type == 'M') {
                            if ($status_type == 'C') {
                                $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                            }
                            if ($status_type == 'P') {
                                $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                            }
                            if(!empty($session_data['Search'])){
                               if(!empty($session_data['agency'])){
                                   $agency = $session_data['agency'];
                                   $query .=" AND k.agency_id = $agency  ";
                                }
                                if(!empty($session_data['federation'])){
                                   $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                                }
                                if(!empty($session_data['cluster'])){
                                   $query .=" AND c.uin = '" . $session_data['cluster'] . "' ";
                                }
                                if(!empty($session_data['shg'])){
                                   $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                                }
                                if(!empty($session_data['family'])){
                                   $query .=" AND k.uin = '" . $session_data['family'] . "' ";
                                }
                             }
                            if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                           //  $query .= " AND Y.dm_id in ($user->id)";

                        }

                        if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                            }
                            if ($status_type == 'P') {
                                $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R') AND (Y.quality_status = 'V' OR Y.quality_status = 'R')";
                            }
                        }
                        $query .= " ORDER BY
                        Y.updated_at
                    DESC ";
                    }
                }
                if ($session_data['group'] == 'SH') {
                    $query = "SELECT
                        Y.*,
                        d.agency_name,
                        j.shgName as name,
                        e.name as fac_name,
                        i.uin,
                        l.name_of_cluster ,
                        i.id AS ids
                    FROM
                        task_qa_assignment AS Y
                    INNER JOIN shg_mst AS i
                    ON
                        i.id = Y.assignment_id
                    INNER JOIN shg_sub_mst AS s
                    ON
                        s.shg_mst_id = i.id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = s.id
                    LEFT JOIN cluster_mst AS k
                    ON
                        k.uin = i.cluster_uin
                    LEFT JOIN cluster_sub_mst AS m
                    ON
                        k.id = m.cluster_mst_id
                    LEFT JOIN cluster_profile AS l
                    ON
                        l.cluster_sub_mst_id = m.id
                   LEFT JOIN federation_mst AS fd
                    ON
                        fd.uin = i.federation_uin
                    LEFT JOIN federation_sub_mst AS fed
                    ON
                        fd.id = fed.federation_mst_id
                    INNER JOIN agency AS d
                    ON
                        i.agency_id = d.agency_id
                    INNER JOIN users AS e
                    ON
                        Y.user_id = e.id
                    WHERE
                        Y.is_deleted = 0 AND Y.assignment_type = 'SH' AND i.is_deleted=0 ";

                    if ($user->u_type == 'M') {
                        if ($status_type == 'C') {
                            $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                        }
                        if ($status_type == 'P') {
                            $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND i.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                            }
                            if(!empty($session_data['shg'])){
                               $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                            }


                        if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                           }
                       //  $query .= " AND Y.dm_id in ($user->id)";

                    }
                    if ($user->u_type == 'QA') {
                        if ($status_type == 'ALL') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V' ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'V' OR Y.quality_status = 'R')  ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND i.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                            }
                            if(!empty($session_data['shg'])){
                               $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                            }


                        if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND  verified_by IN($list)";

                             }
                           }

                    }
                    if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                            $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R') AND (Y.quality_status = 'V' OR Y.quality_status = 'R')";
                        }
                    }
                    $query .= " ORDER BY
                        Y.updated_at
                    DESC ";
                }
                if ($session_data['group'] == 'CL') {
                    $query = "SELECT
                    Y.*,
                    d.agency_name,
                    j.name_of_federation,
                    e.name as fac_name,
                    k.uin,
                    l.name_of_cluster as name,
                    k.id AS ids
                    FROM
                        task_qa_assignment AS Y
                    INNER JOIN cluster_mst AS k
                    ON
                        k.id = Y.assignment_id
                    INNER JOIN cluster_sub_mst AS m
                    ON
                        k.id = m.cluster_mst_id
                    INNER JOIN cluster_profile AS l
                    ON
                        l.cluster_sub_mst_id = m.id
                    INNER JOIN federation_mst AS i
                    ON
                        i.uin = k.federation_uin
                    INNER JOIN federation_sub_mst AS sb
                    ON
                        sb.federation_mst_id = i.id
                    left  JOIN federation_profile AS j
                    ON
                        j.federation_sub_mst_id = sb.federation_mst_id
                    INNER JOIN agency AS d
                    ON
                        k.agency_id = d.agency_id
                    INNER JOIN users AS e
                    ON
                        Y.user_id = e.id
                    WHERE
                        Y.is_deleted = 0 AND assignment_type = 'CL' AND k.is_deleted=0 ";


                    if ($user->u_type == 'M') {
                        if ($status_type == 'C') {
                            $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                        }
                        if ($status_type == 'P') {
                            $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND k.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                            }


                           if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                       }
                       //  $query .= " AND Y.dm_id in ($user->id)";

                    }
                    if ($user->u_type == 'QA') {
                        if ($status_type == 'ALL') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V' ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'  ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'V' OR Y.quality_status = 'R')  ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND k.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                            }


                        if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND  verified_by IN($list)";
                             }
                           }

                    }
                    if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                            $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R') AND (Y.quality_status = 'V' OR Y.quality_status = 'R')";
                        }
                    }
                    $query .= " ORDER BY
                        Y.updated_at
                    DESC ";
                }
                if ($session_data['group'] == 'FD') {
                    $query = " SELECT
                            Y.*,
                            d.agency_name,
                            d.agency_id,
                            j.name_of_federation as name,
                            e.name as fac_name,
                            i.uin,
                            i.id AS ids
                        FROM
                            task_qa_assignment AS Y
                        INNER JOIN federation_mst AS i
                        ON
                            i.id = Y.assignment_id
                        INNER JOIN federation_sub_mst AS s
                        ON
                            i.id = s.federation_mst_id
                        INNER JOIN federation_profile AS j
                        ON
                            j.federation_sub_mst_id = s.id
                        INNER JOIN agency AS d
                        ON
                            i.agency_id = d.agency_id
                        INNER JOIN users AS e
                        ON
                            Y.user_id = e.id
                        WHERE
                            Y.is_deleted = 0 AND Y.assignment_type = 'FD' AND i.is_deleted=0 ";


                    if ($user->u_type == 'M') {
                        if ($status_type == 'C') {
                            $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                        }
                        if ($status_type == 'P') {
                            $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND i.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                            }


                           if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                       }
                       //  $query .= " AND Y.dm_id in ($user->id)";

                    }
                    if ($user->u_type == 'QA') {
                        if ($status_type == 'ALL') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V' ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'  ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'V' OR Y.quality_status = 'R')  ";
                        }


                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND i.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                            }


                           if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND  verified_by IN($list)";
                             }
                       }
                       //  $query .= " AND Y.dm_id in ($user->id)";

                    }
                    if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                            $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                        }
                    }
                    $query .= " ORDER BY
                        Y.updated_at
                    DESC ";
                }

                if( $session_data['group'] == 'FM' || $session_data['group'] == 'ALL'){
                   if($user->u_type == 'QA'){
                   $query .=" ORDER BY  a.updated_at DESC ";

                   }
                }
                // prd($query);
                $data['families'] = DB::select($query);
            } else {
                $data['group'] = '';
                $data['status_t'] = '';
            }
        }

        // prd($data);
        $data['user_type'] = $user->u_type;
        $heading_title = '';
        if ($user->u_type == 'M') {
            $heading_title = 'District_Manager_Report_';
        } else {
            $heading_title == 'Quality_Report_';
        }
        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.qualityCheckPdf', $data)->setPaper('a3', 'landscape');

        return $pdf_doc->download($heading_title . pdf_date() . '.pdf');
    }

    public function export(Request $request)
    {

        return Excel::download(new Quality_report(), 'Quality_' . pdf_date() . '.xlsx');
    }
}
