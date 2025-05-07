<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CommonController extends Controller
{
    public function get_state(Request $request)
    {
        $option_list = '<option value="" selected>--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('country') != '') {
                $country = $request->get('country');

                //DB::enableQueryLog();
                $state_list = DB::table('states as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.country_id', '=', $country)
                    ->select('a.id', 'a.name')
                    ->orderBy('a.name')
                    ->get()->toArray();

                if (!empty($state_list)) {
                    foreach ($state_list as $state) {
                        $option_list .= '<option value="'. $state->id .'">'. $state->name.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_shg_village(Request $request)
    {
        $option_list = '';
        if (request()->ajax()) {
            if ($request->get('shg_uin') != '') {
                $shg_uin = $request->get('shg_uin');

                $query="SELECT a.id from shg_mst a where a.uin = '$shg_uin'";
                $shg_id = DB::select($query);
                $id = $shg_id[0]->id;
                // pr($id);
                $shg_village = DB::table('shg_profile as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.shg_sub_mst_id', '=', $id)
                    ->select('a.village')
                    ->get()->toArray();
                if (!empty($shg_village)) {
                    $shg_v = $shg_village[0]->village;
                }
            }
        }
        echo $shg_v;
        exit;
    }
    public function get_district(Request $request)
    {
        $option_list = '<option value="" selected>--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('state') != '') {
                $state = $request->get('state');

                //DB::enableQueryLog();
                $district_list = DB::table('district as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.state_id', '=', $state)
                    ->select('a.id', 'a.name')
                    ->orderBy('a.name')
                    ->get()->toArray();

                if (!empty($district_list)) {
                    foreach ($district_list as $district) {
                        $option_list .= '<option value="'. $district->id .'">'. $district->name.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_district_user(Request $request)
    {
        $option_list = '';
        if (request()->ajax()) {
            if ($request->get('state') != '') {
                $state = $request->get('state');

                //DB::enableQueryLog();
                $district_list = DB::table('district as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.state_id', '=', $state)
                    ->select('a.id', 'a.name')
                    ->orderBy('a.name')
                    ->get()->toArray();

                if (!empty($district_list)) {
                    foreach ($district_list as $district) {
                        $option_list .= '<option value="'. $district->id .'">'. $district->name.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_phone_code(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('country') != '') {
                $country = $request->get('country');

                //DB::enableQueryLog();
                $countries = DB::table('countries as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.id', '=', $country)
                    ->select('a.id', 'a.phonecode')
                    ->get()->toArray();
                // prd($countries);
                $phone_code='';
                if (!empty($countries)) {
                    $phone_code ='+'. $countries[0]->phonecode;
                }
            }
        }
        echo $phone_code;
        exit;
    }
    public function get_federation_list(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');

                //DB::enableQueryLog();
                $federation_list = DB::table('federation_mst as a')
                     ->join('federation_sub_mst as s', 's.federation_mst_id', '=', 'a.id')
                     ->join('federation_profile as b', 'b.federation_sub_mst_id', '=', 's.id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.agency_id', '=', $agency_id)
                    ->select('a.uin', 'b.name_of_federation')
                    ->orderBy('b.name_of_federation')
                    ->get()->toArray();

                if (!empty($federation_list)) {
                    foreach ($federation_list as $federation) {
                        $option_list .= '<option value="'. $federation->uin .'">'. $federation->name_of_federation.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_cluster_list(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('federation_id') != '') {
                $federation_id = $request->get('federation_id');
                //DB::enableQueryLog();
                $cluster_list = DB::table('cluster_mst as a')
                    ->join('cluster_sub_mst as c', 'a.id', '=', 'c.cluster_mst_id')
                    ->join('cluster_profile as b', 'c.id', '=', 'b.cluster_sub_mst_id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.federation_uin', '=', $federation_id)
                    ->select('a.uin', 'b.name_of_cluster')
                    ->orderBy('b.name_of_cluster')
                    ->get()->toArray();

                if (!empty($cluster_list)) {
                    foreach ($cluster_list as $cluster) {
                        $option_list .= '<option value="'. $cluster->uin .'">'. $cluster->name_of_cluster.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_shg_list(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('cluster_id') != '') {
                $cluster_id = $request->get('cluster_id');
                //DB::enableQueryLog();
                $cluster_list = DB::table('shg_mst as a')
                    ->join('shg_sub_mst as c', 'a.id', '=', 'c.shg_mst_id')
                    ->join('shg_profile as b', 'c.id', '=', 'b.shg_sub_mst_id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.cluster_uin', '=', $cluster_id)
                    ->select('a.uin', 'b.shgName')
                    ->orderBy('b.shgName')
                    ->get()->toArray();

                if (!empty($cluster_list)) {
                    foreach ($cluster_list as $cluster) {
                        $option_list .= '<option value="'. $cluster->uin .'">'. $cluster->shgName.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_family_lists(Request $request)
    {
        // prd("kkk");
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('shg_id') != '') {
                $shg_id = $request->get('shg_id');
                //DB::enableQueryLog();
                $family_list = DB::table('family_mst as a')
                    ->join('family_sub_mst as c', 'a.id', '=', 'c.family_mst_id')
                    ->join('family_profile as b', 'c.id', '=', 'b.family_sub_mst_id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.shg_uin', '=', $shg_id)
                    ->select('a.id','a.uin', 'b.fp_member_name')
                    ->orderBy('b.fp_member_name')
                    ->get()->toArray();
                // prd($family_list);
                if (!empty($family_list)) {
                    foreach ($family_list as $family) {
                        $option_list .= '<option value="'. $family->uin .'">'. $family->fp_member_name.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_shg_list2(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('federation_id') != '') {
                $federation_id = $request->get('federation_id');
                //prd($federation_id );
                //DB::enableQueryLog();
                $federation_list = DB::table('shg_mst as a')
                    ->join('shg_sub_mst as c', 'a.id', '=', 'c.shg_mst_id')
                    ->join('shg_profile as b', 'c.id', '=', 'b.shg_sub_mst_id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.federation_uin', '=', $federation_id)
                    ->select('a.uin', 'b.shgName')
                    ->orderBy('b.shgName')
                    ->get()->toArray();

                if (!empty($federation_list)) {
                    foreach ($federation_list as $federation) {
                        $option_list .= '<option value="'. $federation->uin .'">'. $federation->shgName.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_partner_list(Request $request)
    {

        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('role') != '') {
                $u_type = $request->get('role');
                $agency_id = $request->get('agency_id');
                // prd($agency_id);
                DB::enableQuerylog();
                if($u_type == 'M'){
                    // $user_list = DB::table('users as a')
                    // ->where('a.is_deleted', '=', 0)
                    // ->where('a.u_type', '=', $u_type)
                    // ->where('a.agency_id', '=', $agency_id)
                    // // ->where(DB::raw('FIND_IN_SET(?, a.agency_id)'),  $agency_id)
                    // ->select('a.id', 'a.name', 'a.uin')
                    // ->orderBy('a.name')
                    // ->get()->toArray();
                    $query = "SELECT id,name,uin FROM users
                    WHERE FIND_IN_SET($agency_id, agency_id) >  0 AND u_type = 'M' AND is_deleted = 0 order by name";
                    $user_list = DB::select($query);


                }
                else{
                    $user_list = DB::table('users as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.u_type', '=', $u_type)
                    ->select('a.id', 'a.name', 'a.uin')
                    ->orderBy('a.name')
                    ->get()->toArray();
                }


                if (!empty($user_list)) {
                    foreach ($user_list as $user) {
                        $option_list .= '<option value="' . $user->id . '">' . $user->name . ' (' . $user->uin . ')' . '</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_shg_list_task(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');
                //prd($agency_id);
                //DB::enableQueryLog();
                //$agency_uin=getAgencyuin($agency_id);
                //prd($agency_uin);
                $cluster_list = DB::table('shg_mst as a')
                    ->join('shg_sub_mst as c', 'a.id', '=', 'c.shg_mst_id')
                    ->join('shg_profile as b', 'c.id', '=', 'b.shg_sub_mst_id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.agency_id', '=', $agency_id)
                    ->select('a.uin', 'a.id', 'b.shgName')
                    ->orderBy('b.shgName')
                    ->get()->toArray();
                //prd($cluster_list);
                if (!empty($cluster_list)) {
                    foreach ($cluster_list as $cluster) {
                        $option_list .= '<option value="'. $cluster->id .'">'. $cluster->shgName.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_family_list_task(Request $request)
    {
        $option_list = '';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');
                $id = $request->get('id');
                $agency_uin=getAgencyuin($agency_id);
                $agency = $agency_uin[0]->agency_id;
                // $query = "SELECT
                //             a.id,
                //             b.fp_member_name
                //         FROM
                //             family_mst a
                //         INNER JOIN family_profile b ON
                //             a.id = b.family_sub_mst_id
                //         WHERE
                //             a.is_deleted = 0 AND a.agency_id=$agency AND a.id NOT IN(
                //             SELECT
                //                 c.assignment_id
                //             FROM
                //                 task_assignment c
                //             WHERE
                //                 c.is_deleted = 0 AND  c.assignment_type = 'FM' and a.id != $id
                //         )";

                $query = "SELECT
                        a.id,
                        b.fp_member_name
                    FROM
                        family_mst a
                    INNER JOIN family_profile b ON
                        a.id = b.family_sub_mst_id
                    WHERE
                        a.is_deleted = 0 AND a.agency_id=$agency ";

                $cluster_list = DB::select($query);

                if (!empty($cluster_list)) {
                    foreach ($cluster_list as $cluster) {
                        $option_list .= '<option value="'. $cluster->id .'">'. $cluster->fp_member_name.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_facilitator_list(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('z_id');
                //$agency_uin=getAgencyuin($agency_id);
                //DB::enableQueryLog();
                $facilitator_list = DB::table('users as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.u_type', '=', 'F')
                    ->where('a.agency_id', '=', $agency_id)
                    ->select('a.id', 'a.name')
                    ->orderBy('a.name')
                    ->get()->toArray();

                if (!empty($facilitator_list)) {
                    foreach ($facilitator_list as $facilitator) {
                        $option_list .= '<option value="'. $facilitator->id .'">'. $facilitator->name.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_facilitator_list_task(Request $request)
    {

        $user = Auth::user();
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
                if ($request->get('dm_id') != '') {
                    $dm_id = $request->get('dm_id');
                    $agency_id = $request->get('agency_id');
                    // $u_type = $request->get('user_type');
                    // prd($agency_id);
                    // $agency_uin=getAgencyuin($agency_id);
                    // DB::enableQueryLog();
                if($user->u_type == 'M'){

                    $facilitator_list = DB::table('users as a')
                    ->select('a.id', 'a.name')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.u_type', '=', 'F')
                    ->where('a.parent_id', '=', $dm_id);
                    // if(!empty($agency_id)){
                    //     // $facilitator_list->where('a.agency_id', '=', $agency_id);
                    //     $facilitator_list->whereRaw('FIND_IN_SET(?, a.agency_id)', [$agency_id]);
                    // }
                    $facilitator_list = $facilitator_list->orderBy('a.name')
                    ->get()->toArray();
                    // prd($facilitator_list);
                 }
                 elseif($user->u_type == 'QA'){

                    $facilitator_list = DB::table('users as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.u_type', '=', 'M')
                    ->where('a.parent_id', '=', $dm_id)
                    ->whereRaw('FIND_IN_SET(?, a.agency_id)', [$agency_id])
                    // ->where('a.agency_id', '=' , $agency_id)
                    ->select('a.id', 'a.name')
                    ->orderBy('a.name')
                    ->get()->toArray();
                 }



                }

            if (!empty($facilitator_list)) {
                foreach ($facilitator_list as $facilitator) {
                    $option_list .= '<option value="'. $facilitator->id .'">'. $facilitator->name.'</option>';
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_cluster_list_task(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');
                //DB::enableQueryLog();
                $facilitator_list = DB::table('cluster_mst as a')
                    ->join('cluster_sub_mst as c', 'a.id', '=', 'c.cluster_mst_id')
                    ->join('cluster_profile as b', 'c.id', '=', 'b.cluster_sub_mst_id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.agency_id', '=', $agency_id)
                    ->select('a.uin', 'a.id', 'b.name_of_cluster')
                    ->orderBy('b.name_of_cluster')
                    ->get()->toArray();

                if (!empty($facilitator_list)) {
                    foreach ($facilitator_list as $facilitator) {
                        $option_list .= '<option value="'. $facilitator->id .'">'. $facilitator->name_of_cluster.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_shg_list_task_shg(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');
                //DB::enableQueryLog();
                // $query = "SELECT
                //             a.id,
                //             b.shgName
                //         FROM
                //             shg_mst a
                //         INNER JOIN shg_sub_mst s ON
                //             a.id = s.shg_mst_id
                //         INNER JOIN shg_profile b ON
                //             s.id = b.shg_sub_mst_id
                //         WHERE
                //             a.is_deleted = 0 AND a.agency_id=$agency_id AND a.id NOT IN(
                //             SELECT
                //                 c.assignment_id
                //             FROM
                //                 task_assignment c
                //             WHERE
                //                 c.is_deleted = 0 AND c.assignment_type = 'SH' AND c.status = 'D'
                //         )";
                // $cluster_list = DB::select($query);

                $query = "SELECT
                            a.id,
                            b.shgName
                        FROM
                            shg_mst a
                        INNER JOIN shg_sub_mst s ON
                            a.id = s.shg_mst_id
                        INNER JOIN shg_profile b ON
                            s.id = b.shg_sub_mst_id
                        WHERE
                            a.is_deleted = 0 AND a.agency_id=$agency_id AND ((s.cureent_status = 'N/A' and s.qa_status='Pending') or s.qa_status='Rejected')";
                $cluster_list = DB::select($query);

                if (!empty($cluster_list)) {
                    foreach ($cluster_list as $cluster) {
                        $option_list .= '<option value="'. $cluster->id .'">'. $cluster->shgName.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_subcategory(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('mst_category_id') != '') {
                $mst_category_id = $request->get('mst_category_id');
                //DB::enableQueryLog();
                $scategory_list = DB::table('rating_mst_sub_category as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.mst_category_id', '=', $mst_category_id)
                    ->select('a.mst_id', 'a.mst_subcat_name')
                    ->orderBy('a.mst_subcat_name')
                    ->get()->toArray();

                if (!empty($scategory_list)) {
                    foreach ($scategory_list as $scategory) {
                        $option_list .= '<option value="'. $scategory->mst_id .'">'. $scategory->mst_subcat_name.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_questions(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('mst_sub_category_id') != '') {
                $mst_category_id = $request->get('mst_category_id');
                $mst_sub_category_id = $request->get('mst_sub_category_id');
                //DB::enableQueryLog();
                $question_list = DB::table('rating_mst_ques_list as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.mst_category_id', '=', $mst_category_id)
                    ->where('a.mst_sub_category_id', '=', $mst_sub_category_id)
                    ->select('a.mst_id', 'a.mst_ques_name')
                    ->orderBy('a.mst_ques_name')
                    ->get()->toArray();

                if (!empty($question_list)) {
                    foreach ($question_list as $question) {
                        $option_list .= '<option value="'. $question->mst_id .'">'. $question->mst_ques_name.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_federation_list_task(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');
                //DB::enableQueryLog();
                $cluster_list = DB::table('federation_mst as a')
                    ->join('federation_sub_mst as s', 's.federation_mst_id', '=', 'a.id')
                    ->join('federation_profile as b', 'b.federation_sub_mst_id', '=', 's.id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.agency_id', '=', $agency_id)
                    ->select('a.id', 'a.uin', 'b.name_of_federation')
                    ->orderBy('b.name_of_federation')
                    ->get()->toArray();

                if (!empty($cluster_list)) {
                    foreach ($cluster_list as $cluster) {
                        $option_list .= '<option value="'. $cluster->id .'">'. $cluster->name_of_federation.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_cluster_list_task_cluster(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');
                //DB::enableQueryLog();
                // $query = "SELECT
                //             a.id,
                //             a.uin,
                //             b.name_of_cluster
                //         FROM
                //             cluster_mst a
                //         INNER JOIN cluster_sub_mst c ON
                //             a.id = c.cluster_mst_id
                //         INNER JOIN cluster_profile b ON
                //             c.id = b.cluster_sub_mst_id
                //         WHERE
                //             a.is_deleted = 0 AND a.agency_id=$agency_id AND a.id NOT IN(
                //             SELECT
                //                 c.assignment_id
                //             FROM
                //                 task_assignment c
                //             WHERE
                //                 c.is_deleted = 0 AND c.assignment_type = 'CL' AND c.status = 'D'
                //         )";
                // $facilitator_list = DB::select($query);

                $query = "SELECT
                            a.id,
                            a.uin,
                            b.name_of_cluster
                        FROM
                            cluster_mst a
                        INNER JOIN cluster_sub_mst c ON
                            a.id = c.cluster_mst_id
                        INNER JOIN cluster_profile b ON
                            c.id = b.cluster_sub_mst_id
                        WHERE
                            a.is_deleted = 0 AND a.agency_id=$agency_id AND ((c.cureent_status = 'N/A' and c.qa_status='Pending') or c.qa_status='Rejected')";
                $facilitator_list = DB::select($query);

                if (!empty($facilitator_list)) {
                    foreach ($facilitator_list as $facilitator) {
                        $option_list .= '<option value="'. $facilitator->id .'">'. $facilitator->name_of_cluster.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    // public function get_federation_list_task_federation(Request $request)
    // {
    //     $group = $request->get('gtype');
    //     $table = $group .'_mst';
    //     $tasktype = $request->get('task_fd');
    //     $agency_id = $request->get('agency_id');

    //     $list = [];
    //     if (request()->ajax()) {
    //         $option_list = '<option value="">--Select--</option>';

    //         if ($agency_id != '' && $tasktype != '') {
    //             if($group == 'family')
    //             {
    //                 $field = 'fp_member_name';
    //                 $query = " SELECT
    //                     a.id,
    //                     c.$field
    //                 FROM
    //                     ".$group ."_mst a
    //                 INNER JOIN ".$group."_sub_mst b ON
    //                     a.id = b.".$group."_mst_id
    //                 INNER JOIN ".$group."_profile c ON
    //                     b.id = c.".$group."_sub_mst_id
    //                 WHERE
    //                     a.is_deleted = 0 AND a.agency_id = '".$agency_id."' ";
    //                 if($tasktype == 'P1')
    //                 {
    //                     $query .= "  AND (b.dm_p1 = '')  ";
    //                 }
    //                 if($tasktype == 'P2')
    //                 {
    //                     $query .= "  AND ((b.dm_p1='P' OR b.dm_p1='V' ) And (b.dm_p2 = '' OR b.qa_p2='R'))";
    //                     //$query .= "  AND (b.dm_p1 !='P OR (b.dm_p1 ='V' and b.dm_p2 = '') OR (b.qa_p2='R'))  ";
    //                 }
    //                 if($tasktype == 'R')
    //                 {
    //                     $query .= "  AND b.qa_p1='V' AND b.qa_p2 = 'V' AND( b.dm_r = '' OR b.qa_r='R') AND b.locked = 1 ";
    //                 }
    //                 $list = DB::select($query);
    //             }
    //             else{

    //                 $field = "name_of_".$group;
    //                 if($group == 'shg')
    //                 {
    //                     $field = 'shgName';
    //                 }
    //                 $query = " SELECT
    //                     a.id,
    //                     c.$field
    //                 FROM
    //                     ".$group ."_mst a
    //                 INNER JOIN ".$group."_sub_mst b ON
    //                     a.id = b.".$group."_mst_id
    //                 INNER JOIN ".$group."_profile c ON
    //                     b.id = c.".$group."_sub_mst_id
    //                 WHERE
    //                     a.is_deleted = 0 AND a.agency_id = '".$agency_id."' ";
    //                 if($tasktype == 'A')
    //                 {
    //                     $query .= "  AND (b.dm_a = '' OR b.qa_a='R')  ";
    //                 }
    //                 if($tasktype == 'R')
    //                 {
    //                     $query .= "  AND b.qa_a = 'V' AND(b.dm_r = '' OR b.qa_r='R')  AND b.locked = 1 ";
    //                 }
    //                 $list = DB::select($query);
    //             }

    //             $task = count($list);
    //             $total_task = getCount($table);
    //             if (!empty($list)) {
    //                 foreach($list as $listtype)
    //                 {
    //                     $option_list .= '<option value="'. $listtype->id .'">'. $listtype->$field.'</option>';
    //                 }
    //             }
    //         }
    //     }
    //     $arr['option_list']=$option_list;
    //     //$arr['list'] = "( $task out of $total_task )";
    //     return Response::json($arr);
    //     exit;
    // }
    // public function get_federation_list_task_federation(Request $request)
    // {
    //     $group = $request->get('gtype');
    //     $table = $group .'_mst';
    //     $tasktype = $request->get('task_fd');
    //     $agency_id = $request->get('agency_id');

    //     $list = [];
    //     if (request()->ajax()) {
    //         $option_list = '';

    //         if ($agency_id != '' && $tasktype != '') {
    //             if ($group == 'family') {
    //                 $field = 'fp_member_name';
    //                 $query = " SELECT
    //                     a.id,
    //                     c.$field,
    //                     j.shgName,
    //                     a.uin
    //                 FROM
    //                     ".$group ."_mst a
    //                 INNER JOIN ".$group."_sub_mst b ON
    //                     a.id = b.".$group."_mst_id
    //                 INNER JOIN ".$group."_profile c ON
    //                     b.id = c.".$group."_sub_mst_id
    //                 INNER JOIN shg_mst AS i
    //                 ON
    //                     i.uin = a.shg_uin
    //                 INNER JOIN shg_sub_mst AS w
    //                 ON
    //                     i.id = w.shg_mst_id
    //                 INNER JOIN shg_profile AS j
    //                 ON
    //                     j.shg_sub_mst_id = w.id
    //                 WHERE
    //                     a.is_deleted = 0 AND a.agency_id = '".$agency_id."' ";
    //                 if ($tasktype == 'P1') {
    //                     $query .= "  AND (b.dm_p1 = '')  ";
    //                 }
    //                 if ($tasktype == 'P2') {
    //                     $query .= "  AND ((b.dm_p1='P' OR b.dm_p1='V' ) And (b.dm_p2 = '' OR b.qa_p2='R'))";
    //                     //$query .= "  AND (b.dm_p1 !='P OR (b.dm_p1 ='V' and b.dm_p2 = '') OR (b.qa_p2='R'))  ";
    //                 }
    //                 if ($tasktype == 'R') {
    //                     $query .= "  AND b.qa_p1='V' AND b.qa_p2 = 'V' AND( b.dm_r = '' OR b.qa_r='R') AND b.locked = 1 ";
    //                 }
    //                 $list = DB::select($query);
    //             } else {
    //                 $field = "name_of_".$group;
    //                 if ($group == 'shg') {
    //                     $field = 'shgName';
    //                 }
    //                 $query = " SELECT
    //                     a.id,
    //                     c.$field,
    //                     a.uin
    //                 FROM
    //                     ".$group ."_mst a
    //                 INNER JOIN ".$group."_sub_mst b ON
    //                     a.id = b.".$group."_mst_id
    //                 INNER JOIN ".$group."_profile c ON
    //                     b.id = c.".$group."_sub_mst_id
    //                 WHERE
    //                     a.is_deleted = 0 AND a.agency_id = '".$agency_id."' ";
    //                 if ($tasktype == 'A') {
    //                     $query .= "  AND (b.dm_a = '' OR b.qa_a='R')  ";
    //                 }
    //                 if ($tasktype == 'R') {
    //                     $query .= "  AND b.qa_a = 'V' AND(b.dm_r = '' OR b.qa_r='R')  AND b.locked = 1 ";
    //                 }
    //                 $list = DB::select($query);
    //             }
    //             // prd($list);
    //             $task = count($list);
    //             $total_task = getCount($table);
    //             if (!empty($list)) {
    //                 if ($group == 'family') {
    //                     foreach ($list as $listtype) {
    //                         $option_list .= '<option value="'. $listtype->id .'">'. $listtype->$field.' ('.$listtype->shgName.'-'.substr($listtype->uin, 14).')'.'</option>';
    //                     }
    //                 } else {
    //                     foreach ($list as $listtype) {
    //                         $option_list .= '<option value="'. $listtype->id .'">'. $listtype->$field.'('.substr($listtype->uin, 14).')'.'</option>';
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     $arr['option_list']=$option_list;
    //     //$arr['list'] = "( $task out of $total_task )";
    //     return Response::json($arr);
    //     exit;
    // }
    public function get_federation_list_task_federation(Request $request)
    {
        $group = $request->get('gtype');
        $table = $group .'_mst';
        $tasktype = $request->get('task_fd');
        $agency_id = $request->get('agency_id');

        $list = [];
        if (request()->ajax()) {
            $option_list = '';

            if ($agency_id != '' && $tasktype != '') {
                if ($group == 'family') {
                    $field = 'fp_member_name';
                    if($tasktype == 'P2')
                    {
                        $query = " SELECT
                        a.id,
                        c.$field,
                        j.shgName,
                        a.uin
                    FROM
                        ".$group ."_mst a
                    INNER JOIN ".$group."_sub_mst b ON
                        a.id = b.".$group."_mst_id
                    INNER JOIN ".$group."_profile c ON
                        b.id = c.".$group."_sub_mst_id
                    INNER JOIN shg_mst AS i
                    ON
                        i.uin = a.shg_uin
                    INNER JOIN shg_sub_mst AS w
                    ON
                        i.id = w.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = w.id
                    WHERE
                        a.is_deleted = 0 AND a.agency_id = '".$agency_id."' AND (b.dm_p2 = '' OR b.qa_p2='R')";

                        $list = DB::select($query);
                    }
                    else{
                        $query = " SELECT
                        a.id,
                        c.$field,
                        j.shgName,
                        a.uin
                    FROM
                        ".$group ."_mst a
                    INNER JOIN ".$group."_sub_mst b ON
                        a.id = b.".$group."_mst_id
                    INNER JOIN ".$group."_profile c ON
                        b.id = c.".$group."_sub_mst_id
                    INNER JOIN shg_mst AS i
                    ON
                        i.uin = a.shg_uin
                    INNER JOIN shg_sub_mst AS w
                    ON
                        i.id = w.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = w.id
                    WHERE
                        a.is_deleted = 0 AND a.agency_id = '".$agency_id."' ";
                    if ($tasktype == 'P1') {
                        $query .= "  AND (b.dm_p1 = '')  ";
                    }
                    // if ($tasktype == 'P2') {
                    //     $query .= "  AND (b.dm_p2 = '' OR b.qa_p2='R'))";
                    // }
                    if ($tasktype == 'R') {
                        $query .= "  AND b.qa_p1='V' AND b.qa_p2 = 'V' AND( b.dm_r = '' OR b.qa_r='R') AND b.locked = 1 ";
                    }
                    $list = DB::select($query);
                    }



                    // prd($list);
                } else {
                    $field = "name_of_".$group;
                    if ($group == 'shg') {
                        $field = 'shgName';
                    }
                    $query = " SELECT
                        a.id,
                        c.$field,
                        a.uin
                    FROM
                        ".$group ."_mst a
                    INNER JOIN ".$group."_sub_mst b ON
                        a.id = b.".$group."_mst_id
                    INNER JOIN ".$group."_profile c ON
                        b.id = c.".$group."_sub_mst_id
                    WHERE
                        a.is_deleted = 0 AND a.agency_id = '".$agency_id."' ";
                    if ($tasktype == 'A') {
                        $query .= "  AND (b.dm_a = '' OR b.qa_a='R')  ";
                    }
                    if ($tasktype == 'R') {
                        $query .= "  AND b.qa_a = 'V' AND(b.dm_r = '' OR b.qa_r='R')  AND b.locked = 1 ";
                    }
                    $list = DB::select($query);
                }
                $task = count($list);
                $total_task = getCount($table);
                if (!empty($list)) {
                    if ($group == 'family') {
                        foreach ($list as $listtype) {
                            $option_list .= '<option value="'. $listtype->id .'">'. $listtype->$field.' ('.$listtype->shgName.'-'.substr($listtype->uin, 14).')'.'</option>';
                        }
                    } else {
                        foreach ($list as $listtype) {
                            $option_list .= '<option value="'. $listtype->id .'">'. $listtype->$field.'('.substr($listtype->uin, 14).')'.'</option>';
                        }
                    }
                }
            }
        }
        $arr['option_list']=$option_list;
        return Response::json($arr);
        exit;
    }
    public function get_family_list_task_new(Request $request)
    {
        $option_list = '';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');

                $agency =$agency_id;
                //DB::enableQueryLog();
                // $query = "SELECT
                //             a.id,
                //             b.fp_member_name
                //         FROM
                //             family_mst a
                //         INNER JOIN family_sub_mst s ON
                //             a.id = s.family_mst_id
                //         INNER JOIN family_profile b ON
                //             s.id = b.family_sub_mst_id
                //         WHERE
                //             a.is_deleted = 0 AND a.agency_id=$agency AND a.id NOT IN(
                //             SELECT
                //                 c.assignment_id
                //             FROM
                //                 task_assignment c
                //             WHERE
                //                 c.is_deleted = 0 AND  c.assignment_type = 'FM' AND c.status = 'D'
                //         )";
                // $cluster_list = DB::select($query);

                $query = "SELECT
                            a.id,
                            b.fp_member_name
                        FROM
                            family_mst a
                        INNER JOIN family_sub_mst s ON
                            a.id = s.family_mst_id
                        INNER JOIN family_profile b ON
                            s.id = b.family_sub_mst_id
                        WHERE
                            a.is_deleted = 0 AND a.agency_id=$agency AND ((s.cureent_status = 'N/A' and s.qa_status='Pending') or s.qa_status='Rejected')";
                $cluster_list = DB::select($query);

                if (!empty($cluster_list)) {
                    foreach ($cluster_list as $cluster) {
                        $option_list .= '<option value="'. $cluster->id .'">'. $cluster->fp_member_name.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_profile_data(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('qa_task_id') != '') {
                $qa_task_id = $request->get('qa_task_id');
                //DB::enableQueryLog();
                $federation_data = DB::table('task_qa_assignment as y')
                    ->join('federation_mst as i', 'i.id', '=', 'y.assignment_id')
                    ->join('federation_sub_mst as s', 'i.id', '=', 's.federation_mst_id')
                    ->join('federation_profile as j', 'j.federation_sub_mst_id', '=', 's.id')
                    ->join('federation_rating as r', 'r.federation_sub_mst_id', '=', 's.id')
                    ->join('agency as d', 'i.agency_id', '=', 'd.agency_id')
                    ->join('users as e', 'y.user_id', '=', 'e.id')
                    ->select('y.*', 'd.agency_name', 'j.*', 'e.name', 'i.uin', 'r.rating')
                    ->where('y.is_deleted', '=', 0)
                    ->where('y.assignment_type', '=', 'FD')
                    ->where('y.id', '=', $qa_task_id)
                    ->get()->toArray();
            }
        }
        if (!empty($federation_data)) {
            return Response::json($federation_data);
        }
        return Response::json([]);
    }
    public function get_federation_demography(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('federation_id') != '') {
                $federation_id = $request->get('federation_id');
                //DB::enableQueryLog();
                $federation_list = DB::table('federation_mst as a')
                    ->join('federation_sub_mst as s', 's.federation_mst_id', '=', 'a.id')
                    ->join('federation_profile as b', 'b.federation_sub_mst_id', '=', 's.id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.uin', '=', $federation_id)
                    ->select('b.name_of_district', 'b.name_of_state', 'b.name_of_country', 'b.state_id', 'b.district_id', 'b.country_id')
                    ->get()->toArray();
                if (!empty($federation_list)) {
                    $res['country_option']="<option value='".$federation_list[0]->country_id."'>".$federation_list[0]->name_of_country."</option>";
                    $res['state_option']="<option value='".$federation_list[0]->state_id."'>".$federation_list[0]->name_of_state."</option>";
                    $res['district_option']="<option value='".$federation_list[0]->district_id."'>".$federation_list[0]->name_of_district."</option>";
                    return Response::json($res);
                }
            }
        }
        return Response::json([]);
    }

    public function get_facilitator_suggestion(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('query')) {
                $query = $request->get('query');
                $country= $request->get('country');
                $state = $request->get('state');
                $district = $request->get('district');
                //prd($query);
                $res =DB::table('users as a')->join('agency as b', 'a.agency_id', '=', 'b.agency_id')
                    ->where('a.name', 'like', '%'.$query.'%')
                    ->where('a.is_deleted', '=', 0)->where('b.is_deleted', '=', 0)->select('a.id', 'a.name');
                if ($country>0) {
                    $res->where('b.country', '=', $country);
                }
                if ($state>0) {
                    $res->where('b.state', '=', $state);
                }
                if ($district>0) {
                    $res->where('b.district', '=', $district);
                }
                $data =$res->get()->toArray();
                $output ='<ul class="dropdown-menu" style="display:block;">';
                if (count($data) > 0) {
                    foreach ($data as $row) {
                        $output .='<li><a href="javascript:;" class="record" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->name.'</a></li>';
                    }
                } else {
                    $output .='<li><a href="javascript:;" class="norecord" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
                }


                $output .='</ul>';
                echo $output;
            }
        }
    }
    public function mapping_expense(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $expense_id = $request->get('myVal');
                $query = "Select * from family_yearly_operational_expenses where is_deleted=0 and id in($expense_id) ";
                $data['yearly_operational_expenses'] = DB::select($query);

                $html = '<table class="table mytable">
                            <thead class="back-color">
                                <tr colspan="6">
                                    <th>Buisness Name</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Yearly/Monthly</th>
                                    <th>No of Year/Month</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>';
                $sum =0;
                $sum1=0;
                $sum2=0;
                foreach ($data['yearly_operational_expenses'] as $data) {
                    $sum += (float)$data->quantity;
                    $sum1 += (float)$data->per_kg;
                    $sum2 += (float)$data->totalamount;
                    $html .= '<tr>';
                    $html .= '<td>'.$data->name_of_business.'</td>';
                    $html .= '<td>'.$data->name_of_item.'</td>';
                    $html .= '<td>'.$data->quantity.'</td>';
                    $html .= '<td>'.$data->per_kg.'</td>';
                    $html .= '<td>'.$data->month_year.'</td>';
                    $html .= '<td>'.$data->no_month_year.'</td>';
                    $html .= '<td>'.$data->totalamount.'</td>';
                    $html .= '</tr>';
                }
                $html .= '<tr class="total">';
                $html .= '<td colspan="2">Total</td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan="3">'.$sum2.'</td>';
                $html .= '</tr>';
                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }
    public function mapping_income(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $Income_id = $request->get('myVal');
                $query = "Select * from family_income_from_business where is_deleted=0 and id in($Income_id) ";
                $data['yearly_operational_expenses'] = DB::select($query);

                $html = '<table class="table mytable">
                            <thead class="back-color">
                                <tr colspan="6">
                                    <th>Item</th>
                                    <th>Unit Type</th>
                                    <th>Quantity</th>
                                     <th>Price</th>
                                    <th>Yearly/Monthly/Season/Daily</th>
                                    <th>No of Year/Month/Season/Daily</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>';
                $sum =0;
                $sum1=0;
                $sum2=0;
                foreach ($data['yearly_operational_expenses'] as $data) {
                    $sum += (float)$data->quantity;
                    $sum1 += (float)$data->income;
                    $sum2 += (float)$data->totalamount;
                    $html .= '<tr>';
                    $html .= '<td>'.$data->name_of_item.'</td>';
                    $html .= '<td>'.$data->unit_type.'</td>';
                    $html .= '<td>'.$data->quantity.'</td>';
                    $html .= '<td>'.$data->income.'</td>';
                    $html .= '<td>'.$data->month_year.'</td>';
                    $html .= '<td>'.$data->no_month_year.'</td>';
                    $html .= '<td>'.$data->totalamount.'</td>';
                    $html .= '</tr>';
                }
                $html .= '<tr class="total">';
                $html .= '<td colspan="2">Total</td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan="3">'.$sum2.'</td>';
                $html .= '</tr>';
                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }

    public function get_agency_demography(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');
                DB::enableQueryLog();
                $federation_list = DB::table('agency as a')
                    ->join('countries as s', 's.id', '=', 'a.country')
                    ->join('states as b', 'b.id', '=', 'a.state')
                    ->leftjoin('district as c', 'c.id', '=', 'a.district')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.agency_id', '=', $agency_id)
                    ->select('c.name as name_of_district', 'b.name as name_of_state', 's.name as name_of_country', 'b.id as state_id', 'c.id as district_id', 's.id as country_id')
                    ->get()->toArray();
                $aa=DB::getQueryLog();
                $state_id = $federation_list[0]->state_id;
                //prd( $state_id);
                if (!empty($federation_list)) {
                    $res['country_option']="<option value='".$federation_list[0]->country_id."'>".$federation_list[0]->name_of_country."</option>";
                    $res['state_option']="<option value='".$federation_list[0]->state_id."'>".$federation_list[0]->name_of_state."</option>";

                    // $res['district_option']="<option value='".$federation_list[0]->district_id."'>".$federation_list[0]->name_of_district."</option>";


                    $district_list = DB::table('district as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.state_id', '=', $state_id)
                    ->select('a.id', 'a.name')
                    ->orderBy('a.name')
                    ->get()->toArray();

                    $res['district_option'] = '<option value="" selected>--Select--</option>';
                    foreach ($district_list as $district) {
                        // prd($district_list);
                        $select = '';
                        if (!empty($federation_list[0]->district_id)) {
                            if ($federation_list[0]->district_id == $district->id) {
                                $select='Selected';
                            }
                        } else {
                            $select='';
                        }
                        $res['district_option'].= '<option value="'. $district->id .'" '.$select.' >'. $district->name.'</option>';
                    }


                    return Response::json($res);
                }
            }
        }
        return Response::json([]);
    }

    public function get_partner_demography(Request $request)
    {
        $option_list = '<option value="" selected>--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('partners_id') != '') {
                $partners_id = $request->get('partners_id');
                // prd($partners_id);
                DB::enableQueryLog();
                $country_list = DB::table('partners as a')
                    ->join('countries as s', 's.id', '=', 'a.country_id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.id', '=', $partners_id)
                    ->select('s.name as name_of_country', 's.id as country_id')
                    ->get()->toArray();

                $aa=DB::getQueryLog();
                // prd($country_list);
                //prd($aa);
                if (!empty($country_list)) {
                    $res['country_option']="<option value='".$country_list[0]->country_id."'>".$country_list[0]->name_of_country."</option>";

                    return Response::json($res);
                }
            }
        }
        return Response::json([]);
    }
    public function mapping_agriculture(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $agriculture_id = $request->get('myVal');
                //prd($agriculture_id);
                $query = "Select * from family_agriculture_production_this_year where is_deleted=0 and id in($agriculture_id) ";
                $data['agriculture_production_this_year'] = DB::select($query);


                $html = '<table class="table mytable">
                            <thead class="back-color">
                                <tr colspan="6">
                                <th>Production Type</th>
                                <th>Crop</th>
                                <th>No of Months</th>
                                <th>No of Days</th>
                                <th>Production Sub Type</th>
                                <th>Production Quantity</th>
                                <th>Production Per Year</th>
                                <th>No of Season</th>
                                <th>Consumption</th>
                                <th>Sold in Year</th>
                                <th>Price Per Unit</th>
                                <th>This Year</th>
                                </tr>
                            </thead>
                            <tbody>';
                $sum =0;
                $sum1=0;
                foreach ($data['agriculture_production_this_year'] as $data) {
                    $sum += (float)$data->price_per_unit;
                    $sum1 += (float)$data->total_sale_value;
                    $html .= '<tr>';
                    $html .= '<td>'.$data->production_type.'</td>';
                    $html .= '<td>'.$data->crop.'</td>';
                    $html .= '<td>'.$data->no_of_months.'</td>';
                    $html .= '<td>'.$data->no_of_days.'</td>';
                    $html .= '<td>'.$data->production_sub_type.'</td>';
                    $html .= '<td>'.$data->production_quantity_type.'</td>';
                    $html .= '<td>'.$data->production_per_year.'</td>';
                    $html .= '<td>'.$data->no_of_season.'</td>';
                    $html .= '<td>'.$data->consumption.'</td>';
                    $html .= '<td>'.$data->sold_in_year.'</td>';
                    $html .= '<td>'.$data->price_per_unit.'</td>';
                    $html .= '<td>'.$data->total_sale_value.'</td>';
                    $html .= '</tr>';
                }
                $html .= '<tr class="total">';
                $html .= '<td colspan="10">Total</td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan="">'.$sum1.'</td>';
                $html .= '</tr>';
                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }
    public function mapping_agriculture_next(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $agriculture__next_id = $request->get('myVal');
                //prd($agriculture_id);
                $query = "Select * from family_agriculture_production_next_year where is_deleted=0 and id in($agriculture__next_id) group by id";
                $data['agriculture_production_next_year'] = DB::select($query);


                $html = '<table class="table mytable">
                            <thead class="back-color">
                                <tr colspan="6">
                                <th>Production Type</th>
                                <th>Crop</th>
                                <th>No of Months</th>
                                <th>No of Days</th>
                                <th>Production Sub Type</th>
                                <th>Production Quantity</th>
                                <th>Production Per Year</th>
                                <th>No of Season</th>
                                <th>Consumption</th>
                                <th>Sold in Year</th>
                                <th>Price Per Unit</th>
                                <th>next Year</th>
                                </tr>
                            </thead>
                            <tbody>';
                $sum =0;
                $sum1=0;
                foreach ($data['agriculture_production_next_year'] as $data) {
                    $sum += (float)$data->price_per_unit;
                    $sum1 += (float)$data->total_sale_value;
                    $html .= '<tr>';
                    $html .= '<td>'.$data->production_type.'</td>';
                    $html .= '<td>'.$data->crop.'</td>';
                    $html .= '<td>'.$data->no_of_months.'</td>';
                    $html .= '<td>'.$data->no_of_days.'</td>';
                    $html .= '<td>'.$data->production_sub_type.'</td>';
                    $html .= '<td>'.$data->production_quantity_type.'</td>';
                    $html .= '<td>'.$data->production_per_year.'</td>';
                    $html .= '<td>'.$data->no_of_season.'</td>';
                    $html .= '<td>'.$data->consumption.'</td>';
                    $html .= '<td>'.$data->sold_in_year.'</td>';
                    $html .= '<td>'.$data->price_per_unit.'</td>';
                    $html .= '<td>'.$data->total_sale_value.'</td>';
                    $html .= '</tr>';
                }
                $html .= '<tr class="total">';
                $html .= '<td colspan="10">Total</td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan="">'.$sum1.'</td>';
                $html .= '</tr>';
                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }
    public function expenditure_next(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $expenditure_next_id = $request->get('myVal');
                //prd($agriculture_id);
                $query = "Select * from family_expenditure_next_year where is_deleted=0 and id in($expenditure_next_id) group by id order by e_type";
                $data['expenditure_next_year'] = DB::select($query);


                $html = '<table class="table mytable">
                            <thead class="back-color">
                            <th>Category </th>
                            <th>Type</th>
                            <th>Sub Type</th>
                            <th>Spend Type</th>
                            <th>Season</th>
                            <th>Unit Price</th>
                            <th>Amount Next Year</th>
                                </tr>
                            </thead>
                            <tbody>';
                $sum =0;
                $sum1=0;
                foreach ($data['expenditure_next_year'] as $data) {
                    $e_sub_type = '';
                    if($data->e_sub_type !='Other'){
                        $e_sub_type = $data->e_sub_type;
                    }

                    $sum += (float)$data->e_amount;
                    $sum1 += (float)$data->e_total_amount;
                    $html .= '<tr>';
                    $html .= '<td>'.$data->e_cat.'</td>';
                    $html .= '<td>'.$data->e_type.'</td>';
                    $html .= '<td>'.$e_sub_type.'</td>';
                    $html .= '<td>'.$data->e_spend_type.'</td>';
                    $html .= '<td>'.$data->e_season.'</td>';
                    $html .= '<td>'.$data->e_amount.'</td>';
                    $html .= '<td>'.$data->e_total_amount.'</td>';
                    $html .= '</tr>';
                }
                $html .= '<tr class="total">';
                $html .= '<td colspan="5">Total</td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan="">'.$sum1.'</td>';
                $html .= '</tr>';
                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }
    public function expenditure_this(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $expenditure_this_id = $request->get('myVal');
                //prd($agriculture_id);
                $query = "Select * from family_expenditure_this_year where is_deleted=0 and id in($expenditure_this_id) group by id order by e_type";
                $data['expenditure_this_year'] = DB::select($query);


                $html = '<table class="table mytable">
                            <thead class="back-color">
                            <th>Category </th>
                            <th>Type</th>
                            <th>Sub Type</th>
                            <th>Spend Type</th>
                            <th>Season</th>
                            <th>Unit Price</th>
                            <th>Amount This Year</th>
                                </tr>
                            </thead>
                            <tbody>';
                $sum =0;
                $sum1=0;
                foreach ($data['expenditure_this_year'] as $data) {
                    $e_sub_type = '';
                    if($data->e_sub_type !='Other'){
                        $e_sub_type = $data->e_sub_type;
                    }
                    $sum += (float)$data->e_amount;
                    $sum1 += (float)$data->e_total_amount;
                    $html .= '<tr>';
                    $html .= '<td>'.$data->e_cat.'</td>';
                    $html .= '<td>'.$data->e_type.'</td>';
                    $html .= '<td>'.$e_sub_type.'</td>';
                    $html .= '<td>'.$data->e_spend_type.'</td>';
                    $html .= '<td>'.$data->e_season.'</td>';
                    $html .= '<td>'.$data->e_amount.'</td>';
                    $html .= '<td>'.$data->e_total_amount.'</td>';
                    $html .= '</tr>';
                }
                $html .= '<tr class="total">';
                $html .= '<td colspan="5">Total</td>';
                $html .= '<td colspan=""></td>';
                $html .= '<td colspan="">'.$sum1.'</td>';
                $html .= '</tr>';
                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }
    public function loan_expenditure_this(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $loan_expenditure_this_id = $request->get('myVal');
                //prd($agriculture_id);
                $query = "Select * from family_loan_outstanding where is_deleted=0 and family_sub_mst_id in($loan_expenditure_this_id)";
                $data['family_loan_outstanding'] = DB::select($query);


                $html = '<table class="table mytable">
                            <thead class="back-color">
                            <th>Category </th>
                            <th>Principle Amount</th>
                            <th>Purpose</th>
                            <th>Intrest TYpe</th>
                            <th>Anual rate intrest</th>
                            <th>Loan Tenure</th>
                            <th>Repayment start date</th>
                            <th>Last repayment date</th>
                            <th>Data collection date</th>
                            <th>No of EMIs paid during last 12 months</th>
                            <th>Total amount paid during last 12 months</th>

                            </thead>
                            <tbody>';
                $sum=0;
                foreach ($data['family_loan_outstanding'] as $data) {
                    $sum= $sum+(float)$data->current_year_interest;
                    $html .= '<tr>';
                    $html .= '<td>'.$data->lo_type.'</td>';
                    $html .= '<td>'.$data->lo_principle_amount.'</td>';
                    $html .= '<td>'.$data->lo_purpose.'</td>';
                    $html .= '<td>'.$data->lo_interest_type.'</td>';
                    $html .= '<td>'.$data->lo_interest_rate.'</td>';
                    $html .= '<td>'.$data->lo_no_of_tenure.'</td>';
                    $html .= '<td>'.$data->lo_start_date.'</td>';
                    $html .= '<td>'.$data->lo_last_Repayment_to_paid.'</td>';
                    $html .= '<td>'.$data->lo_data_collection_date.'</td>';
                    $html .= '<td>'.$data->current_year_principal.'</td>';
                    $html .= '<td>'.$data->current_year_interest.'</td>';
                    // $html .= '<td>'.$data->total_paid_principal.'</td>';
                    // $html .= '<td>'.$data->total_paid_interest.'</td>';
                    // $html .= '<td>'.$data->overdue.'</td>';
                    // $html .= '<td>'.$data->lo_next_year.'</td>';
                    $html .= '</tr>';
                }
                $html .= '<tr class="total">';
                $html .= '<td colspan="10">Total</td>';
                $html .= '<td colspan="5">'.$sum.'</td>';
                $html .= '</tr>';
                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }
    public function loan_expenditure_next(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $loan_expenditure_this_id = $request->get('myVal');
                //prd($agriculture_id);
                $query = "Select * from family_loan_outstanding where is_deleted=0 and family_sub_mst_id in($loan_expenditure_this_id)";
                $data['family_loan_outstanding'] = DB::select($query);


                $html = '<table class="table mytable">
                            <thead class="back-color">
                            <th>Category </th>
                            <th>Principle Amount</th>
                            <th>Purpose</th>
                            <th>Intrest TYpe</th>
                            <th>Anual rate intrest</th>
                            <th>Loan Tenure</th>
                            <th>Repayment start date</th>
                            <th>Last repayment date</th>
                            <th>Data collection date</th>
                            <th>No of EMIs paid during last 12 months</th>
                            <th>Total amount paid during last 12 months</th>
                            <th>No of cumulative EMIs repaid</th>
                            <th>Cumulative amount paid</th>
                            <th>Overdue amount</th>
                            <th>Next year loan repayment commitment</th>
                                </tr>
                            </thead>
                            <tbody>';
                $sum=0;
                $sum1=0;
                foreach ($data['family_loan_outstanding'] as $data) {
                    $sum= $sum+(float)$data->current_year_interest;
                    $sum1= $sum1+(float)$data->lo_next_year;
                    $html .= '<tr>';
                    $html .= '<td>'.$data->lo_type.'</td>';
                    $html .= '<td>'.$data->lo_principle_amount.'</td>';
                    $html .= '<td>'.$data->lo_purpose.'</td>';
                    $html .= '<td>'.$data->lo_interest_type.'</td>';
                    $html .= '<td>'.$data->lo_interest_rate.'</td>';
                    $html .= '<td>'.$data->lo_no_of_tenure.'</td>';
                    $html .= '<td>'.$data->lo_start_date.'</td>';
                    $html .= '<td>'.$data->lo_last_Repayment_to_paid.'</td>';
                    $html .= '<td>'.$data->lo_data_collection_date.'</td>';
                    $html .= '<td>'.$data->current_year_principal.'</td>';
                    $html .= '<td>'.$data->current_year_interest.'</td>';
                    $html .= '<td>'.$data->total_paid_principal.'</td>';
                    $html .= '<td>'.$data->total_paid_interest.'</td>';
                    $html .= '<td>'.$data->overdue.'</td>';
                    $html .= '<td>'.$data->lo_next_year.'</td>';
                    $html .= '</tr>';
                }
                $html .= '<tr class="total">';
                $html .= '<td colspan="10">Total</td>';
                $html .= '<td>'.$sum.'</td>';
                $html .= '<td></td><td></td><td></td>';
                $html .= '<td>'.$sum1.'</td>';
                $html .= '</tr>';
                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }
    public function get_agency_suggestion(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('query')) {
                $query = $request->get('query');
                $country= $request->get('country');
                $state = $request->get('state');
                $district = $request->get('district');
                //prd($query);
                $res =DB::table('agency')
                    ->where('agency_name', 'like', '%'.$query.'%')
                    ->where('is_deleted', '=', 0);
                if ($country>0) {
                    $res->where('country', '=', $country);
                }
                if ($state>0) {
                    $res->where('state', '=', $state);
                }
                if ($district>0) {
                    $res->where('district', '=', $district);
                }
                $data =$res->get()->toArray();
                $output ='<ul class="dropdown-menu" style="display:block;">';
                if (count($data) > 0) {
                    foreach ($data as $row) {
                        $output .='<li><a href="javascript:;" class="record" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->agency_name.'</a></li>';
                    }
                } else {
                    $output .='<li><a href="javascript:;" class="norecord" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
                }
                $output .='</ul>';
                echo $output;
            }
        }
    }
    public function requested_loan_first(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $requested_loan_first_id = $request->get('myVal');
                //prd($requested_loan_first_id);
                $query = "Select c.* from family_mst a inner join family_sub_mst b on a.id=b.family_mst_id inner join family_loan_repayment c on b.id=c.family_sub_mst_id where a.is_deleted=0 and (b.dm_p2='V' or b.qa_p2='V') and c.family_sub_mst_id in($requested_loan_first_id)";
                $data['family_loan_repayment'] = DB::select($query);
                $loan_repayment = $data['family_loan_repayment'];
                //prd($loan_repayment);
                $query = "Select c.* from family_mst a inner join family_sub_mst b on a.id=b.family_mst_id inner join family_loan_disbursement c on b.id=c.family_sub_mst_id where a.is_deleted=0 and (b.dm_p2='V' or b.qa_p2='V') and c.family_sub_mst_id in($requested_loan_first_id)";
                $data['family_loan_disbursement'] = DB::select($query);
                $loan_disbursement = $data['family_loan_disbursement'];
                $query = "Select name from users where id = ".$loan_disbursement[0]->quality_id." ";
                $quality = DB::select($query);
                $quality_name = '';
                if (!empty($quality)) {
                    $quality_name = $quality[0]->name;
                }

                $query = "Select c.* from family_mst a inner join family_sub_mst b on a.id=b.family_mst_id inner join family_loan_approvel c on b.id=c.family_sub_mst_id where a.is_deleted=0 and (b.dm_p2='V' or b.qa_p2='V') and c.family_sub_mst_id in($requested_loan_first_id)";
                $data['family_loan_approvel'] = DB::select($query);
                $loan_approvel = $data['family_loan_approvel'];
                //prd($loan_approvel[0]->manager_id);
                $query = "Select name from users where id = ".$loan_approvel[0]->manager_id." ";
                $manager = DB::select($query);
                $manager_name = '';
                if (!empty($manager)) {
                    $manager_name = $manager[0]->name;
                }

                $query = "Select c.* from family_mst a inner join family_sub_mst b on a.id=b.family_mst_id inner join family_business_investment_plan c on b.id=c.family_sub_mst_id where a.is_deleted=0 and (b.dm_p2='V' or b.qa_p2='V') and c.family_sub_mst_id in($requested_loan_first_id)";
                $data['family_business_investment_plan'] = DB::select($query);
                $business_investment_plan = $data['family_business_investment_plan'];
                //prd($business_investment_plan);
                $loan_mode = $loan_repayment[0]->tenure_mode == 1 ? 'Yearly' : 'Monthly';
                if ($loan_repayment[0]->tenure_mode == 1) {
                    $loan_tenure = 12 * $loan_repayment[0]->loan_tenure;
                } else {
                    $loan_tenure = $loan_repayment[0]->loan_tenure;
                }

                if ($loan_repayment[0]->tenure_mode == 1) {
                    $loan_duration = $loan_repayment[0]->loan_tenure . 'Year';
                } else {
                    $loan_duration = $loan_repayment[0]->loan_tenure .'Month';
                }

                $loan_approvel_date = ($loan_approvel[0]->date !='') ? date("M d y", strtotime($loan_approvel[0]->date)) : '-';
                $loan_disbursement_date = ($loan_disbursement[0]->disbursement_date !='') ? date("M d y", strtotime(str_replace('/', '-', $loan_disbursement[0]->disbursement_date))) : '-';
                //prd($loan_disbursement_date);

                $html = '<div class="family-box mt-3">
                             <div class="card-box">
                             <table class="table table-bordered  mytable">';

                $html .= '<tr>';
                $html .= '<th width="50%">Requested loan amount</th>';
                $html .= '<td>₹' . $loan_repayment[0]->principal . '</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Purpose</th>';
                $html .= '<td>' . $business_investment_plan[0]->type_of_business . '</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>	Repayment mode (monthly/seasonally)</th>';
                $html .= '<td>' . $loan_mode . '</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Loan duration</th>';
                $html .= '<td>' . $loan_duration. '</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Number installments</th>';
                $html .= '<td>' . $loan_tenure . '</td>';
                $html .= '</tr>';


                $html .= '  </table></div></div>';



                $html  .= '<div class="family-box mt-3">
                <div class="modal-header">
                <h4 class="modal-title">Updates/Changes to 1st loan- verfication stage
                </h4>
                 </div>
                <div class="card-box">
                <table class="table table-bordered  mytable">';

                $html .= '<tr>';
                $html .= '<th width="50%">Manager</th>';
                $html .= '<td>'.$manager_name.'</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th width="50%">Approved Date</th>';
                $html .= '<td>'.change_date_month_name_char(str_replace('/', '-', $loan_approvel_date)). '</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<th width="50%">Updated Loan Amount</th>';
                $html .= '<td>₹'.$loan_approvel[0]->uloan_amount.'</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Updated Purpose</th>';
                $html .= '<td>'.$loan_approvel[0]->uloan_purpose.'</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Updated Repayment mode</th>';
                $html .= '<td>'.$loan_approvel[0]->urepayment_mode.'</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Updated Loan duration</th>';
                $html .= '<td>'.$loan_approvel[0]->uloan_duration.'</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Updated No. installments</th>';
                $html .= '<td>'.$loan_approvel[0]->uloan_installments.'</td>';
                $html .= '</tr>';


                $html .= '  </table></div></div>';
                $html  .= '<div class="family-box mt-3">
                <div class="modal-header">
                <h4 class="modal-title">AFTER DISBURSEMENT (to be filled at the backend after updated credit plan)
                </h4>
                 </div>
                <div class="card-box">
                <table class="table table-bordered  mytable">';

                if (!empty($loan_disbursement[0]->get_loan)) {
                    $html .= '<tr>';
                    $html .= '<th width="50%">Did they get a loan? (Y/N)</th>';
                    $html .= '<td>' . $loan_disbursement[0]->get_loan . '</td>';
                    $html .= '</tr>';
                    $html .= '<tr>';
                    $html .= '<th width="50%">ViV Staff</th>';
                    $html .= '<td>' . $quality_name . '</td>';
                    $html .= '</tr>';
                    $html .= '  </table></div></div>';


                    if ($loan_disbursement[0]->loan_duration == 0) {
                        $loan_disbursement[0]->loan_duration = '';
                    }
                    // prd($loan_disbursement[0]->repayment_mode);
                    if ($loan_disbursement[0]->get_loan == "Yes") {
                        $html  .= '<div class="family-box mt-3">
                        <div class="modal-header">
                        <h4 class="modal-title">Final changes in loan no. 1 (approved by Name of Lending Insitution/Partner)
                        </h4>
                        </div>
                        <div class="card-box">
                        <table class="table table-bordered  mytable">';
                        $html .= '<tr>';
                        $html .= '<th>Disbursement date</th>';
                        $html .= '<td>' . change_date_month_name_char(str_replace('/', '-', $loan_disbursement_date)). '</td>';
                        $html .= '</tr>';

                        $html .= '<tr>';
                        $html .= '<th>Final loan amount after disbursement</th>';
                        $html .= '<td>₹' . $loan_disbursement[0]->loan_amount . '</td>';
                        $html .= '</tr>';



                        $html .= '<tr>';
                        $html .= '<th width="50%">If change in loan purpose</th>';
                        $html .= '<td>' . $loan_disbursement[0]->loan_purpose . '</td>';
                        $html .= '</tr>';

                        $html .= '<tr>';
                        $html .= '<th>If change in repayment mode</th>';
                        $html .= '<td>' . $loan_disbursement[0]->repayment_mode . '</td>';
                        $html .= '</tr>';

                        $html .= '<tr>';
                        $html .= '<th>if change in loan duration</th>';
                        $html .= '<td>' . $loan_disbursement[0]->loan_duration . '</td>';
                        $html .= '</tr>';

                        $html .= '<tr>';
                        $html .= '<th>if change in no. installments</th>';
                        $html .= '<td>' . $loan_disbursement[0]->no_installments . '</td>';
                        $html .= '</tr>';

                        $html .= '  </table></div></div>';
                    }
                }

                return $html;
            }
        }
        return false;
    }
    public function requested_loan_second(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $html = '<div class="family-box mt-3">
                             <div class="card-box">
                             <table class="table table-bordered  mytable">';

                $html .= '<tr>';
                $html .= '<th width="50%">Requested loan amount</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Purpose</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>	Repayment mode (monthly/seasonally)</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Loan duration</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Number installments</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';


                $html .= '  </table></div></div>';

                $html  .= '<div class="family-box mt-3">
                <div class="modal-header">
                <h4 class="modal-title">Updates/Changes to 2st loan- Verfication stage
                </h4>
                 </div>
                <div class="card-box">
                <table class="table table-bordered  mytable">';

                $html .= '<tr>';
                $html .= '<th width="50%">Updated Loan Amount</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Updated Purpose</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Updated Repayment mode</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Updated Loan duration</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Updated no. installments</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';


                $html .= '  </table></div></div>';
                $html  .= '<div class="family-box mt-3">
                <div class="modal-header">
                <h4 class="modal-title">AFTER DISBURSEMENT (to be filled at the backend afterUpdated Credit Plan)
                </h4>
                 </div>
                <div class="card-box">
                <table class="table table-bordered  mytable">';

                $html .= '<tr>';
                $html .= '<th width="50%">Did they get a loan? (Y/N)</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>If Y, enter disbursement date</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>Final loan amount after disbursement</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '  </table></div></div>';

                $html  .= '<div class="family-box mt-3">
                <div class="modal-header">
                <h4 class="modal-title">Final changes in loan no. 2 (approved by Name of Lending Insitution/Partner)
                </h4>
                 </div>
                <div class="card-box">
                <table class="table table-bordered  mytable">';

                $html .= '<tr>';
                $html .= '<th width="50%">If change in loan purpose</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>If change in repayment mode</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>if change in loan duration</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<th>if change in no. installments</th>';
                $html .= '<td>---</td>';
                $html .= '</tr>';

                $html .= '  </table></div></div>';


                return $html;
            }
        }
        return false;
    }
    public function get_fed_suggestion(Request $request)
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
                    $res =DB::table('federation_profile')
                    ->where('name_of_federation', 'like', '%'.$query.'%')
                    ->where('is_deleted', '=', 0);
                    if ($country>0) {
                        $res->where('country_id', '=', $country);
                    }
                    if ($state>0) {
                        $res->where('state_id', '=', $state);
                    }
                    if ($district>0) {
                        $res->where('district_id', '=', $district);
                    }
                    $data =$res->get()->toArray();
                    $output ='<ul class="dropdown-menu" style="display:block;">';
                    if (count($data) > 0) {
                        foreach ($data as $row) {
                            $output .='<li><a href="javascript:;" class="record" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->name_of_federation.'</a></li>';
                        }
                    } else {
                        $output .='<li><a href="javascript:;" class="norecord" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
                    }


                    $output .='</ul>';
                    echo $output;
                }

                if ($group == "CL") {
                    //prd($group);
                    $res =DB::table('cluster_profile')
                        ->where('name_of_cluster', 'like', '%'.$query.'%')
                        ->where('is_deleted', '=', 0);
                    if ($country>0) {
                        $res->where('country_id', '=', $country);
                    }
                    if ($state>0) {
                        $res->where('state_id', '=', $state);
                    }
                    if ($district>0) {
                        $res->where('district_id', '=', $district);
                    }
                    $data =$res->get()->toArray();
                    $output ='<ul class="dropdown-menu" style="display:block;">';
                    if (count($data) > 0) {
                        foreach ($data as $row) {
                            $output .='<li><a href="javascript:;" class="record" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->name_of_cluster.'</a></li>';
                        }
                    } else {
                        $output .='<li><a href="javascript:;" class="norecord" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
                    }


                    $output .='</ul>';
                    echo $output;
                }
                if ($group == "SH") {
                    //prd($group);
                    $res =DB::table('shg_profile')
                            ->where('shgName', 'like', '%'.$query.'%')
                            ->where('is_deleted', '=', 0);
                    if ($country>0) {
                        $res->where('country_id', '=', $country);
                    }
                    if ($state>0) {
                        $res->where('state_id', '=', $state);
                    }
                    if ($district>0) {
                        $res->where('district_id', '=', $district);
                    }
                    $data =$res->get()->toArray();
                    $output ='<ul class="dropdown-menu" style="display:block;">';
                    if (count($data) > 0) {
                        foreach ($data as $row) {
                            $output .='<li><a href="javascript:;" class="record" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->shgName.'</a></li>';
                        }
                    } else {
                        $output .='<li><a href="javascript:;" class="norecord" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
                    }


                    $output .='</ul>';
                    echo $output;
                }
                if ($group == "FM") {
                    //prd($group);
                    $res =DB::table('family_profile')
                                ->where('fp_member_name', 'like', '%'.$query.'%')
                                ->where('is_deleted', '=', 0);
                    if ($country>0) {
                        $res->where('fp_country_id', '=', $country);
                    }
                    if ($state>0) {
                        $res->where('fp_state_id', '=', $state);
                    }
                    if ($district>0) {
                        $res->where('fp_district_id', '=', $district);
                    }
                    $data =$res->get()->toArray();
                    $output ='<ul class="dropdown-menu" style="display:block;">';
                    if (count($data) > 0) {
                        foreach ($data as $row) {
                            $output .='<li><a href="javascript:;" class="record" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->fp_member_name.'</a></li>';
                        }
                    } else {
                        $output .='<li><a href="javascript:;" class="norecord" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
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
                            $output .='<li><a href="javascript:;" class="record" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">'.$row->agency_name.'</a></li>';
                        }
                    } else {
                        $output .='<li><a href="javascript:;" class="norecord" style="width:100%;display:block;padding:3px 5px;max-height: 100px;overflow: auto;">No record found.</a></li>';
                    }


                    $output .='</ul>';
                    echo $output;
                }
            }
        }
    }

    public function get_agency_list(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('user_id') != '') {
                $user_id = $request->get('user_id');
                //DB::enableQueryLog();
                $user = DB::table('users as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.u_type', '=', 'F')
                    ->where('a.id', '=', $user_id)
                    ->select('a.agency_id')
                    ->get()->toArray();
                $agency_id = $user[0]->agency_id;
                $query = "SELECT agency_id,agency_name as name FROM agency where is_deleted=0 and agency_id IN ($agency_id)";
                $agency_list = DB::select($query);

                if (!empty($agency_list)) {
                    foreach ($agency_list as $agency) {
                        $option_list .= '<option value="'. $agency->agency_id .'">'. $agency->name.'</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_block_list(Request $request)
    {
        //$option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('fed_uin') != '') {
                $fed_uin = $request->get('fed_uin');

                //DB::enableQueryLog();
                $federation_uin = DB::table('federation_mst as a')
                     ->join('federation_sub_mst as s', 's.federation_mst_id', '=', 'a.id')
                     ->join('federation_profile as b', 'b.federation_sub_mst_id', '=', 's.id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.uin', '=', $fed_uin)
                    ->select('b.block')
                    ->orderBy('b.name_of_federation')
                    ->get()->toArray();
            }
        }
        echo $federation_uin[0]->block;
        exit;
    }
    public function get_notification_read(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('notification_id') != '') {
                $id = $request->get('notification_id');
                //prd($module_guid_dd);
                $query = "UPDATE `notification` SET is_read = 1 where id = '".$id."'";
                $data = DB::select(DB::raw($query));
                return 'success';
            }
        }
        return false;
    }
    public function get_allnotification_read()
    {
        $userid = Auth::user()->id;

        if (request()->ajax()) {
            if ($userid != '') {
                $query = "UPDATE `notification` SET is_read = 1 where notification_to = '".$userid."'";
                $data = DB::select(DB::raw($query));
                return 'success';
            }
        }
        return false;
    }
    function logout_details()
    {
        // $user = Auth::user();
        // date_default_timezone_set("Asia/Kolkata");
        // $action=0;
        // $user_id=$user->id;
        // $u_type=$user->u_type;
        // $time=date('H:i a');
        // $user_ip=request()->ip();
        // logindetails($user_id,$action,$u_type,$user_ip,$time);
    }
    public function mapping_other_income(Request $request)
    {
        // prd($request->get('val'));
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $income_id = $request->get('myVal');
                $table = "";
                if($request->get('val') ==  1)
                {
                     $table = "family_other_income_this_year";
                }
                else{
                    $table = "family_other_income_next_year";
                }
                $query = "Select * from $table where is_deleted=0 and id in($income_id)  order by id";
                $income = DB::select($query);


                $html = '<table class="table mytable">
                            <thead class="back-color">
                            <tr>
                            <th>Type</th>
                            <th>Member Name</th>
                            <th>Income Type</th>
                            <th>Days/Years</th>
                            <th>Unit Price</th>
                            <th>Total Income Amount</th>
                            </tr>
                            </thead>
                            <tbody>';
                $sum =0;
                $sum1=0;
                foreach ($income as $data) {
                    $type = '';
                     if($data->flag == 1)
                     {
                        $type = "Fixed Income";
                     }
                     elseif ($data->flag == 2) {
                        $type = "Casual Income";
                     }
                     elseif ($data->flag == 3) {
                        $type = "Trade Income";
                     }
                     elseif ($data->flag == 4) {
                        $type = "Pension Income";
                     }
                     elseif ($data->flag == 5) {
                        $type = "Other Income";
                     }
                     $sum += $data->income;
                     $sum1 += $data->total_income;

                    $html .= '<tr>';
                    $html .= '<td>'.$type.'</td>';
                    $html .= '<td>'.$data->members_name.'</td>';
                    $html .= '<td>'.$data->income_type.'</td>';
                    $html .= '<td>'.$data->income_month.'</td>';
                    $html .= '<td>'.$data->income.'</td>';
                    $html .= '<td>'.$data->total_income.'</td>';
                    $html .= '</tr>';
                }
                $html .= '<tr class="total">';
                $html .= '<td colspan="4"></td>';
                $html .= '<td></td>';
                $html .= '<td>'.$sum1.'</td>';
                $html .= '</tr>';
                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }
    public function get_family_list(Request $request)
    {

        $group = $request->get('gtype');
        $table = $group . '_mst';
        $tasktype = $request->get('task_fd');
        $agency_id = $request->get('agency_id');

        $list = [];
        if (request()->ajax()) {
            $option_list = '';

            if ($agency_id != '' && $tasktype != '') {
                if ($group == 'family') {
                    $field = 'fp_member_name';
                        $query = " SELECT
                        a.id,
                        c.$field,
                        j.shgName,
                        a.uin
                    FROM
                        " . $group . "_mst a
                    INNER JOIN " . $group . "_sub_mst b ON
                        a.id = b." . $group . "_mst_id
                    INNER JOIN " . $group . "_profile c ON
                        b.id = c." . $group . "_sub_mst_id
                    INNER JOIN shg_mst AS i
                    ON
                        i.uin = a.shg_uin
                    INNER JOIN shg_sub_mst AS w
                    ON
                        i.id = w.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = w.id
                    WHERE
                        a.is_deleted = 0 AND a.agency_id = '" . $agency_id . "' ";
                        if ($tasktype == 'A') {
                            $query .= "  AND b.dm_p1 = '' AND b.dm_p2 = ''  ";
                        }
                        // if ($tasktype == 'P2') {
                        //     $query .= "  AND (b.dm_p2 = '' OR b.qa_p2='R'))";
                        // }
                        if ($tasktype == 'R') {
                            $query .= "  AND b.qa_p1='V' AND b.qa_p2 = 'V' AND( b.dm_r = '' OR b.qa_r='R') AND b.locked = 1 ";
                        }
                        $list = DB::select($query);


                    // prd($list);
                } else {
                    $field = "name_of_" . $group;
                    if ($group == 'shg') {
                        $field = 'shgName';
                    }
                    $query = " SELECT
                        a.id,
                        c.$field,
                        a.uin
                    FROM
                        " . $group . "_mst a
                    INNER JOIN " . $group . "_sub_mst b ON
                        a.id = b." . $group . "_mst_id
                    INNER JOIN " . $group . "_profile c ON
                        b.id = c." . $group . "_sub_mst_id
                    WHERE
                        a.is_deleted = 0 AND a.agency_id = '" . $agency_id . "' ";
                    if ($tasktype == 'A') {
                        // $query .= "  AND (b.dm_a = '' OR b.qa_a='R')  ";
                        $query .= "  AND b.dm_a = '' ";

                    }
                    if ($tasktype == 'R') {
                        $query .= "  AND b.qa_a = 'V' AND(b.dm_r = '' OR b.qa_r='R')  AND b.locked = 1 ";
                    }
                    $list = DB::select($query);
                }
                $task = count($list);
                $total_task = getCount($table);
                if (!empty($list)) {
                    if ($group == 'family') {
                        foreach ($list as $listtype) {
                            $option_list .= '<option value="' . $listtype->id . '">' . $listtype->$field . ' (' . $listtype->shgName . '-' . substr($listtype->uin, 14) . ')' . '</option>';
                        }
                    } else {
                        foreach ($list as $listtype) {
                            $option_list .= '<option value="' . $listtype->id . '">' . $listtype->$field . '(' . substr($listtype->uin, 14) . ')' . '</option>';
                        }
                    }
                }
            }
        }
        $arr['option_list'] = $option_list;
        return Response::json($arr);
        exit;
    }

    public function get_family_list_id(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');
                // prd($agency_id);

                $family_list = DB::table('family_mst as a')
                    ->join('family_sub_mst as s', 's.family_mst_id', '=', 'a.id')
                    ->join('family_profile as b', 'b.family_sub_mst_id', '=', 's.id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.agency_id', '=', $agency_id)
                    ->select('a.id', 'b.fp_member_name')
                    ->orderBy('b.fp_member_name')
                    ->get()->toArray();
                    // prd($family_list);

                if (!empty($family_list)) {
                    foreach ($family_list as $family) {
                        $option_list .= '<option value="' . $family->id . '">' . $family->fp_member_name . '</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }

    public function get_fac_list_id(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');
                // prd($agency_id);

                $fac_list = DB::table('users as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.agency_id', '=', $agency_id)
                    ->where('a.u_type', '=', 'F')
                    ->select('a.id', 'a.name')
                    ->orderBy('a.id')
                    ->get()->toArray();
                    // prd($fac_list);

                if (!empty($fac_list)) {
                    foreach ($fac_list as $fac) {
                        $option_list .= '<option value="' . $fac->id . '">' . $fac->name . '</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_shg_list_id(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');
                // prd($agency_id);

                $shg_list = DB::table('shg_mst as a')
                    ->join('shg_sub_mst as s', 's.shg_mst_id', '=', 'a.id')
                    ->join('shg_profile as b', 'b.shg_sub_mst_id', '=', 's.id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.agency_id', '=', $agency_id)
                    ->select('a.id', 'b.shgName')
                    ->orderBy('b.shgName')
                    ->get()->toArray();
                    // prd($family_list);

                if (!empty($shg_list)) {
                    foreach ($shg_list as $shg) {
                        $option_list .= '<option value="' . $shg->id . '">' . $shg->shgName . '</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }
    public function get_cluster_list_id(Request $request)
    {
        $option_list = '<option value="">--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('agency_id') != '') {
                $agency_id = $request->get('agency_id');
                // prd($agency_id);

                $cluster_list = DB::table('cluster_mst as a')
                    ->join('cluster_sub_mst as s', 's.cluster_mst_id', '=', 'a.id')
                    ->join('cluster_profile as b', 'b.cluster_sub_mst_id', '=', 's.id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.agency_id', '=', $agency_id)
                    ->select('a.id', 'b.name_of_cluster')
                    ->orderBy('b.name_of_cluster')
                    ->get()->toArray();
                    // prd($family_list);

                if (!empty($cluster_list)) {
                    foreach ($cluster_list as $cluster) {
                        $option_list .= '<option value="' . $cluster->id . '">' . $cluster->name_of_cluster . '</option>';
                    }
                }
            }
        }
        echo $option_list;
        exit;
    }

    public function get_remarks(Request $request)
    {
        // pr($request->all());
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $id = $request->get('myVal');
                $type = $request->get('type');

                $query = "SELECT
                            a.*,
                            b.name ,
                            b.parent_id,
                            c.fp_member_name
                        FROM
                            `family_remarks` AS a
                        LEFT JOIN users AS b
                        ON
                            a.user_id = b.id
                        LEFT JOIN family_profile AS c
                        ON
                            a.family_id = c.family_sub_mst_id
                        WHERE
                            a.id = $id   ";
                $remarks = DB::select($query);
                // prd($remarks);
                $m_name = '';
                $manager_name = '';
                $managers_remarks = '';
                $status = '';
                if($type == 'QA'){
                    $parent_id = $remarks[0]->qa_id;
                    $manager_name = 'Quality Manager';
                    $managers_remarks = $remarks[0]->qa_remarks;
                    $child_name = 'District Manager';
                    $status = $remarks[0]->qa_status;
                }
                else{
                    $parent_id = $remarks[0]->dm_id;
                    $manager_name = 'District Manager';
                    $managers_remarks = $remarks[0]->dm_remarks;
                    $child_name = 'Facilitator';
                    $status = $remarks[0]->dm_status;


                }

                if(!empty($remarks)){
                    $query ="SELECT * FROM users WHERE id = $parent_id";
                    $res = DB::select($query);
                    if(!empty($res)){
                       $m_name = $res[0]->name;
                    }
                }

                if($status == 'V'){
                    $status = 'Verified';
                }
                else if($status == 'R') {
                    $status = 'Rejected';
                }
                else{
                    $status = 'Pending';
                }



                $html = '<table class="table mytable">
                            <thead class="back-color">
                            <tr>';
                $html .= '<td>' . $manager_name . '</td>';

                $html .=    '<th>Facilitator </th>
                            <td>Family Name</td>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>';

                    $html .= '<tr>';
                    $html .= '<td>' . $m_name . '</td>';
                    $html .= '<td>' . $remarks[0]->name . '</td>';
                    $html .= '<td>' . $remarks[0]->fp_member_name . '</td>';
                    $html .= '<td>' . $remarks[0]->task_type . '</td>';
                    $html .= '<td>' . $status . '</td>';
                    $html .= '<td>' . change_date_month_name_char(str_replace('/','-',$remarks[0]->updated_at)) . '</td>';
                    $html .= '</tr>';
                    $html .='<thead class="back-color">
                                <tr>
                                   <th colspan="6" style="text-align:center;">Remark</th>
                                </tr>
                             </thead>';
                    $html .='<tr><td colspan="6">' . $managers_remarks . '</td></tr>';

                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }

    public function get_shg_remarks(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $id = $request->get('myVal');
                $type = $request->get('type');

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
                            a.id = $id   ";
                $remarks = DB::select($query);

                $m_name = '';
                $manager_name = '';
                $managers_remarks = '';
                $status = '';
                if($type == 'QA'){
                    $parent_id = $remarks[0]->qa_id;
                    $manager_name = 'Quality Manager';
                    $managers_remarks = $remarks[0]->qa_remarks;
                    $child_name = 'District Manager';
                    $status = $remarks[0]->qa_status;
                }
                else{
                    $parent_id = $remarks[0]->dm_id;
                    $manager_name = 'District Manager';
                    $managers_remarks = $remarks[0]->dm_remarks;
                    $child_name = 'Facilitator';
                    $status = $remarks[0]->dm_status;


                }

                if(!empty($remarks)){
                    $query ="SELECT * FROM users WHERE id = $parent_id";
                    $name = DB::select($query);
                    if(!empty($name)){
                       $m_name = $name[0]->name;
                    }
                    else{
                        $m_name = '';
                    }
                }

                if($status == 'V'){
                    $status = 'Verified';
                }
                else if($status == 'R') {
                    $status = 'Rejected';
                }
                else{
                    $status = 'Pending';
                }



                $html = '<table class="table mytable">
                            <thead class="back-color">
                            <tr>';
                $html .= '<td>' . $manager_name . '</td>';

                $html .=    '<th>Facilitator </th>
                            <td>SHG Name</td>
                            <th>Status</th>
                            <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>';

                    $html .= '<tr>';
                    $html .= '<td>' . $m_name . '</td>';
                    $html .= '<td>' . $remarks[0]->name . '</td>';
                    $html .= '<td>' . $remarks[0]->shgName . '</td>';
                    $html .= '<td>' . $status . '</td>';
                    $html .= '<td>' . change_date_month_name_char(str_replace('/','-',$remarks[0]->updated_at)) . '</td>';
                    $html .= '</tr>';
                    $html .='<thead class="back-color">
                                <tr>
                                   <th colspan="6" style="text-align:center;">Remark</th>
                                </tr>
                             </thead>';
                    $html .='<tr><td colspan="6">' . $managers_remarks . '</td></tr>';

                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }

    public function get_fed_remarks(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $id = $request->get('myVal');
                $type = $request->get('type');

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
                            a.id = $id   ";
                $remarks = DB::select($query);
                // prd($remarks);
                $m_name = '';
                $manager_name = '';
                $managers_remarks = '';
                $status = '';
                if($type == 'QA'){
                    $parent_id = $remarks[0]->qa_id;
                    $manager_name = 'Quality Manager';
                    $managers_remarks = $remarks[0]->qa_remarks;
                    $child_name = 'District Manager';
                    $status = $remarks[0]->qa_status;
                }
                else{
                    $parent_id = $remarks[0]->dm_id;
                    $manager_name = 'District Manager';
                    $managers_remarks = $remarks[0]->dm_remarks;
                    $child_name = 'Facilitator';
                    $status = $remarks[0]->dm_status;


                }

                if(!empty($remarks)){
                    $query ="SELECT * FROM users WHERE id = $parent_id";
                    $name = DB::select($query);
                    // prd($name);
                    if(!empty($name)){
                       $m_name = $name[0]->name;
                    }
                    else{
                        $m_name = '';
                    }
                }

                if($status == 'V'){
                    $status = 'Verified';
                }
                else if($status == 'R') {
                    $status = 'Rejected';
                }
                else{
                    $status = 'Pending';
                }



                $html = '<table class="table mytable">
                            <thead class="back-color">
                            <tr>';
                $html .= '<td>' . $manager_name . '</td>';

                $html .=    '<th>Facilitator </th>
                            <td>Federation Name</td>
                            <th>Status</th>
                            <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>';

                    $html .= '<tr>';
                    $html .= '<td>' . $m_name . '</td>';
                    $html .= '<td>' . $remarks[0]->name . '</td>';
                    $html .= '<td>' . $remarks[0]->name_of_federation . '</td>';
                    $html .= '<td>' . $status . '</td>';
                    $html .= '<td>' . change_date_month_name_char(str_replace('/','-',$remarks[0]->updated_at)) . '</td>';
                    $html .= '</tr>';
                    $html .='<thead class="back-color">
                                <tr>
                                   <th colspan="6" style="text-align:center;">Remark</th>
                                </tr>
                             </thead>';
                    $html .='<tr><td colspan="6">' . $managers_remarks . '</td></tr>';

                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }

    public function get_cluster_remarks(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('myVal') != '') {
                $id = $request->get('myVal');
                $type = $request->get('type');

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
                            a.id = $id   ";
                $remarks = DB::select($query);
                // prd($remarks);
                $m_name = '';
                $manager_name = '';
                $managers_remarks = '';
                $status = '';
                if($type == 'QA'){
                    $parent_id = $remarks[0]->qa_id;
                    $manager_name = 'Quality Manager';
                    $managers_remarks = $remarks[0]->qa_remarks;
                    $child_name = 'District Manager';
                    $status = $remarks[0]->qa_status;
                }
                else{
                    $parent_id = $remarks[0]->dm_id;
                    $manager_name = 'District Manager';
                    $managers_remarks = $remarks[0]->dm_remarks;
                    $child_name = 'Facilitator';
                    $status = $remarks[0]->dm_status;


                }

                if(!empty($remarks)){
                    $query ="SELECT * FROM users WHERE id = $parent_id";
                    $name = DB::select($query);

                    if(!empty($name)){
                       $m_name = $name[0]->name;
                    }
                    else{
                        $m_name = '';
                    }
                }

                if($status == 'V'){
                    $status = 'Verified';
                }
                else if($status == 'R') {
                    $status = 'Rejected';
                }
                else{
                    $status = 'Pending';
                }



                $html = '<table class="table mytable">
                            <thead class="back-color">
                            <tr>';
                $html .= '<td>' . $manager_name . '</td>';

                $html .=    '<th>Facilitator </th>
                            <td>Cluster Name</td>
                            <th>Status</th>
                            <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>';

                    $html .= '<tr>';
                    $html .= '<td>' . $m_name . '</td>';
                    $html .= '<td>' . $remarks[0]->name . '</td>';
                    $html .= '<td>' . $remarks[0]->name_of_cluster . '</td>';
                    $html .= '<td>' . $status . '</td>';
                    $html .= '<td>' . change_date_month_name_char(str_replace('/','-',$remarks[0]->updated_at)) . '</td>';
                    $html .= '</tr>';
                    $html .='<thead class="back-color">
                                <tr>
                                   <th colspan="6" style="text-align:center;">Remark</th>
                                </tr>
                             </thead>';
                    $html .='<tr><td colspan="6">' . $managers_remarks . '</td></tr>';

                $html .= '  </tbody>
                        </table>';

                return $html;
            }
        }
        return false;
    }

    public function get_mst_module(Request $request)
    {
        $option_list = '<option value="" selected>--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('lang_id') != '') {
                $lang_id = $request->get('lang_id');
                // DB::enableQueryLog();
                $module_list = DB::table('mst_module as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.language_id', '=', $lang_id)
                    ->select('a.module_name', 'a.module_id')
                    ->get()->toArray();



                if (!empty($module_list)) {
                    foreach ($module_list as $res) {
                        $option_list .= "<option value='" . $res->module_id . "'>" . $res->module_name . "</option>";
                    }

                }
            }
        }
        echo $option_list;
        exit;
    }

    public function get_mst_section(Request $request)
    {
        $option_list = '<option value="" selected>--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('module_id') != '') {
                $module_id = $request->get('module_id');
                $lang_id = $request->get('lang_id');
                // DB::enableQueryLog();
                $module_list = DB::table('mst_section as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.language_id', '=', $lang_id)
                    ->where('a.module_id', '=', $module_id)
                    ->select('a.section_name', 'a.section_id')
                    ->get()->toArray();



                if (!empty($module_list)) {
                    foreach ($module_list as $res) {
                        $option_list .= "<option value='" . $res->section_id . "'>" . $res->section_name . "</option>";
                    }

                }
            }
        }
        echo $option_list;
        exit;
    }

    public function get_mst_sub_section(Request $request)
    {
        $option_list = '<option value="" selected>--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('module_id') != '') {
                $module_id = $request->get('module_id');
                $lang_id = $request->get('lang_id');
                $section_id = $request->get('section_id');
                // DB::enableQueryLog();
                $module_list = DB::table('mst_sub_section as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.language_id', '=', $lang_id)
                    ->where('a.module_id', '=', $module_id)
                    ->where('a.section_id', '=', $section_id)
                    ->select('a.sub_section_name', 'a.sub_section_id')
                    ->get()->toArray();
                if (!empty($module_list)) {
                    foreach ($module_list as $res) {
                        $option_list .= "<option value='" . $res->sub_section_id . "'>" . $res->sub_section_name . "</option>";
                    }

                }
            }
        }
        echo $option_list;
        exit;
    }

    public function get_mst_app_label(Request $request)
    {
        $option_list = '<option value="" selected>--Select--</option>';
        if (request()->ajax()) {
            if ($request->get('module_id') != '') {
                $module_id = $request->get('module_id');
                $lang_id = $request->get('lang_id');
                $section_id = $request->get('section_id');
                $sub_section_id = $request->get('sub_section_id');
                // DB::enableQueryLog();
                // prd($lang_id);
                if($lang_id == 1){
                    $module_list = DB::table('mst_app_label as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.language_id', '=', $lang_id)
                    ->where('a.module_id', '=', $module_id)
                    ->where('a.section_id', '=', $section_id)
                    ->where('a.sub_section_id', '=', $sub_section_id)
                    ->select('a.app_label_text', 'a.app_label_id')
                    ->get()->toArray();

                }
                else{
                    $module_list = DB::table('mst_app_label_language as a')
                    ->leftjoin('mst_app_label as b', 'a.app_label_id', '=', 'b.app_label_id')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.language_id', '=', $lang_id)
                    ->where('b.module_id', '=', $module_id)
                    ->where('b.section_id', '=', $section_id)
                    ->select('a.app_label_text', 'a.app_label_id')
                    ->get()->toArray();
                }




                if (!empty($module_list)) {
                    foreach ($module_list as $res) {
                        $option_list .= "<option value='" . $res->app_label_id . "'>" . $res->app_label_text . "</option>";
                    }

                }
            }
        }
        echo $option_list;
        exit;
    }
}
