<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\API\ClusterModel;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Preanalytics;
use App\Models\TaskQaAssignment;
use App\Models\User;
use App\Models\Sync_data;
use App\Models\Sync_log_data;
use App\Models\FamilySubMst;
use App\Models\FamilyMemberInfo;
use App\Models\FamilyConcent;
use App\Models\FcsnodeMst;
use App\Models\FamilyAssets;
use App\Models\FamilyAssetsLiveStock;
use App\Models\FamilyAssetsVehicle;
use App\Models\FamilyAssetsMachinery;
use App\Models\FamilyAssetsGadgets;
use App\Models\FamilyGoals;
use App\Models\FamilyAgricultureProductionThisYear;
use App\Models\FamilyAgricultureProductionNextYear;
use App\Models\FamilySavings;
use App\Models\FamilySavingsSource;
use App\Models\FamilyLoanOutstanding;
use App\Models\FamilyIncomeThisYear;
use App\Models\FamilyIncomeNextYear;
use App\Models\FamilyExpenditureThisYear;
use App\Models\FamilyExpenditureNextYear;
use App\Models\FamilyAnalysisThisYear;
use App\Models\FamilyAnalysisNextYear;
use App\Models\FamilyChallenges;
use App\Models\FamilyObservationThisYear;
use App\Models\FamilyObservationNextYear;
use App\Models\FamilyObservationThisYearMember;
use App\Models\FamilyBusinessInvestmentPlan;
use App\Models\FamilyShgmemberCommitment;
use App\Models\FamilyFixedInvestment;
use App\Models\FamilyYearlyOperationalExpenses;
use App\Models\FamilyIncomeFromBusiness;
use App\Models\FamilyLoanRepayment;
use App\Models\FamilySavingsSourceOther;
use App\Models\FamilyRating;
use App\Models\FamilyOtherIncomeThisYear;
use App\Models\FamilyOtherIncomeNextYear;
use App\Models\FamilyGovLiveilhoodProgram;
use App\Http\Controllers\API\v1\SqlLibController;
use Illuminate\Support\Facades\Log;
use App\Models\familyLoanDisbursement;
use App\Models\FamilyUpload;
use App\Models\FamilyNextUpload;
use App\Models\Notification;
use App\Mail\DartMail;
use Illuminate\Support\Facades\Mail;

class FamilyController extends Controller
{

    public function __construct()
    {
        // echo url('/api/userauth');
        ini_set('max_execution_time', '0');
    }

    public function authuser($params)
    {

        $mst_users = DB::table('users')
            ->where('email', $params['email'])
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        if (!empty($mst_users)) {

            $hashed = Hash::make($params['password']);

            if (Hash::check($params['password'], $mst_users[0]->password)) {

                return 1;
            } else {

                return 0;
            }
        }
    }

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response['data'], 200);
    }

    public function sendError($error, $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        return response()->json($response['message'], $code);
    }

    public function index(Request $request)
    {


        // prd($request->all());
        if ($request->isMethod('post')) {

            try {

                $response_msg = 'failed';
                $result = DB::transaction(function ($response_msg) use ($request) {
                    if (isset($_POST['agninsID']) && $_POST['agninsID'] != '' && isset($_POST['data']) && $_POST['data'] != '' && isset($_POST['wst']) && ($_POST['wst'] == 'PR' || $_POST['wst'] == 'D')) {

                        $asgtkn        = trim($_POST['agninsID']);
                        $assign_status = trim($_POST['wst']); // D/PR
                        $data          = trim($_POST['data']); // Json Formate
                        $sync_data     = trim($_POST['data']); // Json Formate for store in sync_data table

                        $data = json_decode($data, TRUE);
                        // prd($data);
                        if (is_array($data)){
                            if (count($data) > 0) {
                                if (array_key_exists('concent_form_object', $data)) { // check array key exist
                                    $concent_form_object = $data['concent_form_object'];
                                    if (array_key_exists('signature_of_facilitatorPic', $data['concent_form_object'])) {
                                        $data['concent_form_object']['signature_of_facilitatorPic'] = json_encode($data['concent_form_object']['signature_of_facilitatorPic'], true);
                                    }
                                    if (array_key_exists('signature_of_participantPic', $data['concent_form_object'])) {
                                        $data['concent_form_object']['signature_of_participantPic'] = json_encode($data['concent_form_object']['signature_of_participantPic'], true);
                                    }
                                }


                                //--------
                                $sync_data = json_encode($data); // Json Formate for store in sync_data table
                                //=====================================================
                                $query_1 = "SELECT assignment_id FROM task_assignment WHERE asgtkn = '$asgtkn' AND assignment_type ='FM';";
                                $concent_id = DB::select($query_1);
                                $query = "Select * from task_assignment where asgtkn='$asgtkn' AND assignment_type='FM' AND status IN('P','PR')";
                                $taskagnAre = DB::select($query);

                                if (!empty($taskagnAre)) {
                                    $user_id = $taskagnAre[0]->user_id;

                                    $query = " select parent_id from users  where id = '$user_id' ";
                                    $manager_id = DB::select($query)[0]->parent_id;

                                    $query = "Select * from users where id='$user_id' AND status ='A'";
                                    $usersAre = DB::select($query);

                                    if (!empty($usersAre)) {
                                        $sync_log_data = new Sync_log_data();
                                        $sync_log_data->data = $sync_data;
                                        $sync_log_data->type = 'S';
                                        $sync_log_data->asgtkn = $asgtkn;
                                        $sync_log_data->status = $assign_status;
                                        $sync_log_data->save();

                                        if ($assign_status == 'PR') {
                                            $sub_master = new Sync_data();
                                            $sub_master->data = $sync_data;
                                            $sub_master->type = 'S';
                                            $sub_master->asgtkn = $asgtkn;
                                            $sub_master->status = $assign_status;
                                            $sub_master->save();
                                            //json sync

                                            $email = $usersAre[0]->email;
                                            $password = $usersAre[0]->password;

                                            //=================================================================
                                            // $ch = curl_init();
                                            // curl_setopt($ch, CURLOPT_URL, url('/api/userauth'));
                                            // curl_setopt($ch, CURLOPT_POST, 1);
                                            // curl_setopt($ch, CURLOPT_POSTFIELDS,"email=$email&pwd=$password");
                                            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            // $server_output = curl_exec($ch);
                                            // curl_close ($ch);

                                            // $vld001 = json_decode($server_output);
                                            $query = "Select * from users where email='$email' AND status ='A'";
                                            $vld001 = DB::select($query);
                                            if (count($vld001) > 0) {
                                                $response_msg = 'success';
                                                //UPDATE task_assignment Table
                                                $query = "UPDATE task_assignment set status= 'PR' WHERE asgtkn='$asgtkn' AND status='P'";
                                                $result = DB::update($query);
                                            } else {
                                                $query = "UPDATE task_assignment set status= 'P' WHERE asgtkn='$asgtkn' AND status='PR'";
                                                $result = DB::update($query);
                                            }
                                            //====================================================================
                                        } else {

                                            $mst_id = $taskagnAre[0]->assignment_id;  // master id
                                            $task = $taskagnAre[0]->task;   // Analytics or Rating
                                            $task_a1 = $taskagnAre[0]->task_a1;   // Analytics part
                                            $status = $taskagnAre[0]->status; //
                                            $asgtkn = $taskagnAre[0]->asgtkn;  // asgtkn
                                            $user_id = $taskagnAre[0]->user_id; //
                                            $assignment_type = $taskagnAre[0]->assignment_type; //
                                            $remark = $taskagnAre[0]->remark; //

                                            if (array_key_exists('profileObject', $data)) { // check array key exist
                                                //Task maintain

                                                $task_assignment = DB::update('update task_assignment set status = "D" where asgtkn = ?', [$asgtkn]);


                                                //Task_Qa_assignment maintain

                                                $modelQa = new TaskQaAssignment();

                                                $modelQa->asgtkn = $asgtkn;
                                                $modelQa->user_id = $user_id;
                                                $modelQa->dm_id = $manager_id;
                                                $modelQa->assignment_id = $mst_id;
                                                $modelQa->assignment_type = $assignment_type;
                                                $modelQa->verified_by = $manager_id;
                                                $modelQa->task = $task;
                                                $modelQa->task_a1 = $task_a1 ?? 'N/A';
                                                $modelQa->remark = $remark;
                                                $modelQa->created_at = date('Y-m-d H:i:s');
                                                $modelQa->save();

                                                //notfication
                                                $user_name = User::where('id', '=', $user_id)->pluck('name')->toArray();
                                                $manager_name = User::where('id', '=', $manager_id)->pluck('name')->toArray();
                                                $query = "SELECT fp_member_name FROM family_profile WHERE family_sub_mst_id = $mst_id";
                                                $name = DB::select($query)[0]->fp_member_name;
                                                $message['task'] = "Family";
                                                $message['status'] = "S";
                                                $message['manager_name'] = $user_name[0];
                                                $message['name'] = $name;
                                                $message['user_name'] = $manager_name[0];
                                                $message_save = '';
                                                $message_save = "$user_name[0] has submitted $name(Family) task. Please Check.";


                                                $analytics_st = 'D';
                                                $fp_status = 'D';
                                                $sp_status = 'D';
                                                $cureent_status = 'N/A';

                                                if ($task == 'A' && $task_a1 == 'P1') {
                                                    $analytics_st = 'P';
                                                    $sp_status = 'P';
                                                }

                                                $analytics_st = 'P';
                                                $rating_st = 'P';
                                                $fp_status = 'P';
                                                $sp_status = 'P';
                                                $cureent_status = 'N/A';
                                                if ($task == 'A' && $task_a1 == 'P1') {
                                                    $analytics_st = 'D';
                                                    $fp_status = 'D';
                                                    $cureent_status = 'AP';
                                                }
                                                if ($task == 'A' && $task_a1 == 'P2') {
                                                    $analytics_st = 'D';
                                                    $sp_status = 'D';
                                                    $cureent_status = 'AP';
                                                }
                                                if ($task == 'R') {
                                                    $analytics_st = 'D';
                                                    $rating_st = 'D';
                                                    $cureent_status = 'RP';
                                                }

                                                //Sub Master Log maintain

                                                /* $sub_master = DB::update('update family_sub_mst set status = "L" where family_mst_id = ? AND status = "A" ', [$mst_id]);*/
                                                // prd($mst_id);
                                                $query = "select id from family_sub_mst where family_mst_id = $mst_id";
                                                $family_sub_mst_data = DB::select($query);

                                                $sub_mst_id = $family_sub_mst_data[0]->id;

                                                //Sub master Active mainatain
                                                $modeln = FamilySubMst::find($family_sub_mst_data[0]->id);
                                                $modeln->family_mst_id = $mst_id;
                                                $modeln->status = 'A';
                                                if ($task == 'A' && $task_a1 == 'P1') {
                                                    $modeln->dm_p1 = 'P';
                                                }
                                                if ($task == 'A' && $task_a1 == 'P2') {
                                                    $modeln->dm_p2 = 'P';
                                                }
                                                if ($task == 'R') {
                                                    $modeln->dm_r = 'P';
                                                }
                                                $modeln->p1 = $fp_status;
                                                $modeln->p2 = $sp_status;
                                                $modeln->analytics = $analytics_st;
                                                $modeln->rating = $rating_st;
                                                $modeln->status_flag = 0;
                                                $modeln->cureent_status = $cureent_status;
                                                $modeln->updated_at = date('Y-m-d H:i:s');
                                                $modeln->save();

                                                $singleRows = array(
                                                    'Family_Profile_object' => 'family_profile',
                                                    'Family_Assets_object' => 'family_assets',
                                                    'Savings_object' => 'family_savings',
                                                    'Business_Investment_Plan_object' => 'family_business_investment_plan',
                                                    'Observation_next_year_object' => 'family_observation_next_year',
                                                    'ShgMember_commitment_object' => 'family_shgmember_commitment',
                                                    'Income_this_year_object' => 'family_income_this_year',
                                                    'Observation_this_year_object' => 'family_observation_this_year',
                                                    'Income_next_year_object' => 'family_income_next_year'
                                                );

                                                $modelAre = array(); // for multiple rows

                                                if (array_key_exists('first_part_Object', $data['profileObject'])) {

                                                    //CHALLENGES
                                                    if (array_key_exists('Challenges_object', $data['profileObject']['first_part_Object'])) {
                                                        $familyChallenges = $data['profileObject']['first_part_Object']['Challenges_object'];
                                                        $res = DB::delete('delete from family_challenges where family_sub_mst_id = ?', [$sub_mst_id]);
                                                        $remove_arr = array('id' => '', 'fp_id' => '', 'challenge_id' => '');
                                                        foreach ($familyChallenges as $chlval) {
                                                            $model_challenges = new FamilyChallenges();
                                                            $model_challenges->family_sub_mst_id = $sub_mst_id;

                                                            $challenge = '';
                                                            if (isset($chlval['challenge'])) {
                                                                $challenge = $chlval['challenge'];
                                                            }
                                                            $model_challenges->challenges = $challenge;
                                                            $actVals = array();
                                                            if (isset($chlval['action'])) {
                                                                foreach ($chlval['action'] as $sval) {
                                                                    $actVals[] = array_diff_key($sval, $remove_arr);
                                                                }
                                                            }
                                                            $model_challenges->ch_actions = json_encode($actVals);
                                                            $model_challenges->save();
                                                        }
                                                    }
                                                    //END Chalenges

                                                    //image upload
                                                    if (array_key_exists('familyimage', $data['profileObject']['first_part_Object'])) {
                                                        $familyimage = $data['profileObject']['first_part_Object']['familyimage'];

                                                        FamilyUpload::where('family_sub_mst_id', $sub_mst_id)->delete();
                                                        for ($i = 0; $i < count($familyimage); $i++) {

                                                            $familyimage_details = new FamilyUpload();
                                                            $familyimage_details->family_sub_mst_id = $sub_mst_id;
                                                            $familyimage_details->photos_videos_name = $familyimage[$i]['image_path'];
                                                            $familyimage_details->imagename = $familyimage[$i]['imagename'];

                                                            $familyimage_details->save();
                                                        }
                                                    }

                                                    if (array_key_exists('family_other_income_this_year', $data['profileObject']['first_part_Object'])) {
                                                        $family_other_income = $data['profileObject']['first_part_Object']['family_other_income_this_year'];

                                                        FamilyOtherIncomeThisYear::where('family_sub_mst_id', $sub_mst_id)->delete();
                                                        for ($i = 0; $i < count($family_other_income); $i++) {
                                                            $family_other_income_details = new FamilyOtherIncomeThisYear();
                                                            $family_other_income_details->family_sub_mst_id = $sub_mst_id;
                                                            $family_other_income_details->member_id = $family_other_income[$i]['member_id'];
                                                            $family_other_income_details->members_name = $family_other_income[$i]['members_name'];
                                                            $family_other_income_details->income_type = $family_other_income[$i]['income_type'];
                                                            $family_other_income_details->income_month = $family_other_income[$i]['income_month'];
                                                            $family_other_income_details->income = $family_other_income[$i]['income'];
                                                            $family_other_income_details->total_income = $family_other_income[$i]['total_income'];
                                                            $family_other_income_details->flag = $family_other_income[$i]['flag'];
                                                            if (isset($family_other_income[$i]['income_guid'])) {
                                                                $family_other_income_details->income_guid = $family_other_income[$i]['income_guid'];
                                                            }


                                                            $family_other_income_details->save();
                                                        }
                                                    }

                                                    // family gov program
                                                    if (array_key_exists('family_gov_liveilhood_program', $data['profileObject']['first_part_Object'])) {
                                                        $family_gov_liveilhood = $data['profileObject']['first_part_Object']['family_gov_liveilhood_program'];

                                                        FamilyGovLiveilhoodProgram::where('family_sub_mst_id', $sub_mst_id)->delete();
                                                        for ($i = 0; $i < count($family_gov_liveilhood); $i++) {
                                                            $family_gov_liveilhooddetails = new FamilyGovLiveilhoodProgram();
                                                            $family_gov_liveilhooddetails->family_sub_mst_id = $sub_mst_id;
                                                            $family_gov_liveilhooddetails->program_name = $family_gov_liveilhood[$i]['program_name'];
                                                            $family_gov_liveilhooddetails->recived_benefit = $family_gov_liveilhood[$i]['recived_benefit'];
                                                            $family_gov_liveilhooddetails->benefit_1 = $family_gov_liveilhood[$i]['benefit_1'];
                                                            $family_gov_liveilhooddetails->benefit_2 = $family_gov_liveilhood[$i]['benefit_2'];
                                                            $family_gov_liveilhooddetails->benefit_3 = $family_gov_liveilhood[$i]['benefit_3'];
                                                            $family_gov_liveilhooddetails->save();
                                                        }
                                                    }

                                                    // family members info
                                                    if (array_key_exists('Family_Info_object', $data['profileObject']['first_part_Object'])) {
                                                        $family_members_info = $data['profileObject']['first_part_Object']['Family_Info_object'];

                                                        FamilyMemberInfo::where('family_sub_mst_id', $sub_mst_id)->delete();
                                                        for ($i = 0; $i < count($family_members_info); $i++) {
                                                            $family_members_info_details = new FamilyMemberInfo();
                                                            $family_members_info_details->family_sub_mst_id = $sub_mst_id;
                                                            $family_members_info_details->MemberGuid = $family_members_info[$i]['MemberGuid'];
                                                            $family_members_info_details->name = $family_members_info[$i]['name'];
                                                            $family_members_info_details->dob = $family_members_info[$i]['dob'];
                                                            $family_members_info_details->age = $family_members_info[$i]['age'];
                                                            $family_members_info_details->gender = $family_members_info[$i]['gender'];
                                                            $family_members_info_details->relation = $family_members_info[$i]['relation'];
                                                            $family_members_info_details->education = $family_members_info[$i]['education'];
                                                            $family_members_info_details->currentStatus = $family_members_info[$i]['currentStatus'];
                                                            $family_members_info_details->maritalStatus  = $family_members_info[$i]['maritalStatus'];
                                                            $family_members_info_details->employed  = $family_members_info[$i]['employed'];
                                                            $family_members_info_details->differentlyAbled = $family_members_info[$i]['differentlyAbled'];
                                                            $family_members_info_details->pension  = $family_members_info[$i]['pension'];
                                                            $family_members_info_details->malnutritions  = $family_members_info[$i]['malnutritions'];
                                                            $family_members_info_details->undernourished  = $family_members_info[$i]['undernourished'];
                                                            $family_members_info_details->vulnerable   = $family_members_info[$i]['vulnerable'];
                                                            $family_members_info_details->earning_description   = $family_members_info[$i]['earning_description'];
                                                            $family_members_info_details->save();
                                                        }
                                                    }

                                                    //observation_member_object
                                                    if (array_key_exists('Observation_this_year_object', $data['profileObject']['first_part_Object'])) {
                                                        if (array_key_exists('observation_member_object', $data['profileObject']['first_part_Object']['Observation_this_year_object'])) {
                                                            $observation_member = $data['profileObject']['first_part_Object']['Observation_this_year_object']['observation_member_object'];
                                                            $NewAre = $this->keyDataLibrary('family_observation_this_year_member', $observation_member);
                                                            $this->tableMaintain('family_observation_this_year_member', $NewAre, $sub_mst_id);
                                                        }
                                                    }
                                                    //END

                                                    //family_analysis_this_year
                                                    if (array_key_exists('Analysis_object', $data['profileObject']['first_part_Object'])) {
                                                        $tb1 = 'family_analysis_this_year';
                                                        if (array_key_exists('this_year', $data['profileObject']['first_part_Object']['Analysis_object'])) {
                                                            $this_year = $data['profileObject']['first_part_Object']['Analysis_object']['this_year'];
                                                            $NewAre = $this->keyDataLibrary($tb1, $this_year);
                                                            $this->tableMaintain($tb1, $NewAre, $sub_mst_id);
                                                        }
                                                    }
                                                    //END

                                                    //family_analysis_next_year
                                                    if (array_key_exists('Analysis_object', $data['profileObject']['first_part_Object'])) {
                                                        $tb1 = 'family_analysis_next_year';
                                                        if (array_key_exists('next_year', $data['profileObject']['first_part_Object']['Analysis_object'])) {
                                                            $next_year = $data['profileObject']['first_part_Object']['Analysis_object']['next_year'];
                                                            $NewAre = $this->keyDataLibrary($tb1, $next_year);
                                                            $this->tableMaintain($tb1, $NewAre, $sub_mst_id);
                                                        }
                                                    }
                                                    //END

                                                    //Single rows data
                                                    foreach ($singleRows as $objk => $tblv) {
                                                        if (array_key_exists($objk, $data['profileObject']['first_part_Object'])) {
                                                            $profileObject = $data['profileObject']['first_part_Object'][$objk];
                                                            $NewAre = $this->keyDataLibrary($tblv, $profileObject);
                                                            //prd($NewAre);
                                                            $this->tableMaintain($tblv, $NewAre, $sub_mst_id);
                                                        }
                                                    }
                                                    // foreach ($singleRows as $objk => $tblv) {
                                                    //     if (array_key_exists($objk, $data['profileObject']['first_part_Object'])) {
                                                    //         if($objk == 'Observation_this_year_object'){
                                                    //         $profileObject = $this->cleanSpecialCharacters($data['profileObject']['first_part_Object'][$objk]);

                                                    //         }else{
                                                    //         $profileObject = $data['profileObject']['first_part_Object'][$objk];

                                                    //         }


                                                    //         $NewAre = $this->keyDataLibrary($tblv, $profileObject);
                                                    //         //prd($NewAre);
                                                    //         $this->tableMaintain($tblv, $NewAre, $sub_mst_id);
                                                    //     }
                                                    // }
                                                    //___________

                                                    //Multiple rows _____
                                                    //Family_Assets
                                                    if (array_key_exists('Family_Assets_object', $data['profileObject']['first_part_Object'])) {
                                                        $Family_Assets_object = $data['profileObject']['first_part_Object']['Family_Assets_object'];
                                                        $FamAsAre = array('live_stock', 'vehicle_types', 'machinery_types', 'gadgets_types');
                                                        foreach ($FamAsAre as $fasv) {
                                                            if (array_key_exists($fasv, $Family_Assets_object)) {
                                                                if ($fasv == 'gadgets_types') {
                                                                    $modelAre[$fasv][] = $Family_Assets_object[$fasv];
                                                                } else {
                                                                    $modelAre[$fasv] = $Family_Assets_object[$fasv];
                                                                }
                                                            }
                                                        }
                                                    }

                                                    //Savings_object
                                                    if (array_key_exists('Savings_object', $data['profileObject']['first_part_Object'])) {
                                                        $Family_Savings_object = $data['profileObject']['first_part_Object']['Savings_object'];
                                                        if (array_key_exists('savings', $Family_Savings_object)) {
                                                            $modelAre['savings'] = $Family_Savings_object['savings'];
                                                        }
                                                    }


                                                    //Savings_object_other
                                                    if (array_key_exists('Savings_object', $data['profileObject']['first_part_Object'])) {
                                                        $Family_Savings_object = $data['profileObject']['first_part_Object']['Savings_object'];
                                                        if (array_key_exists('other_savings', $Family_Savings_object)) {
                                                            $modelAre['other_savings'] = $Family_Savings_object['other_savings'];
                                                        }
                                                    }

                                                    $famlyAres = array(
                                                        'Family_Goals_object',
                                                        'Agriculture_production_this_year',
                                                        'Loan_Outstanding_object',
                                                        'Expenditure_this_year_object'
                                                    );

                                                    foreach ($famlyAres as $fasAr) {
                                                        if (array_key_exists($fasAr, $data['profileObject']['first_part_Object'])) {
                                                            $modelAre[$fasAr] = $data['profileObject']['first_part_Object'][$fasAr];
                                                        }
                                                    }
                                                }

                                                if (array_key_exists('second_part_Object', $data['profileObject'])) {
                                                    //Single rows data
                                                    foreach ($singleRows as $objk => $tblv) {
                                                        if (array_key_exists($objk, $data['profileObject']['second_part_Object'])) {
                                                            $profileObject = $data['profileObject']['second_part_Object'][$objk];
                                                            $NewAre = $this->keyDataLibrary($tblv, $profileObject);
                                                            $this->tableMaintain($tblv, $NewAre, $sub_mst_id);
                                                        }
                                                    }
                                                    // foreach ($singleRows as $objk => $tblv) {
                                                    //     if (array_key_exists($objk, $data['profileObject']['second_part_Object'])) {
                                                    //         if($objk == 'Observation_next_year_object'){
                                                    //             $profileObject = $this->cleanSpecialCharacters($data['profileObject']['second_part_Object'][$objk]);

                                                    //             }else{
                                                    //             $profileObject = $data['profileObject']['second_part_Object'][$objk];

                                                    //             }
                                                    //         // $profileObject = $data['profileObject']['second_part_Object'][$objk];
                                                    //         $NewAre = $this->keyDataLibrary($tblv, $profileObject);
                                                    //         $this->tableMaintain($tblv, $NewAre, $sub_mst_id);
                                                    //     }
                                                    // }
                                                    //____________

                                                    $famlyAres2 = array(
                                                        'Agriculture_production_next_year',
                                                        'Expenditure_next_year_object'
                                                    );

                                                    foreach ($famlyAres2 as $fasAr) {
                                                        if (array_key_exists($fasAr, $data['profileObject']['second_part_Object'])) {
                                                            $modelAre[$fasAr] = $data['profileObject']['second_part_Object'][$fasAr];
                                                        }
                                                    }

                                                    //Multiple rows _____
                                                    //Business_Investment_Plan_object
                                                    if (array_key_exists('Business_Investment_Plan_object', $data['profileObject']['second_part_Object'])) {
                                                        $Business_Investment_Plan = $data['profileObject']['second_part_Object']['Business_Investment_Plan_object'];
                                                        $BusAsAre = array('fixed_investment', 'yearly_operational_expenses', 'income_from_business', 'loan_repayment');
                                                        foreach ($BusAsAre as $bussv) {
                                                            if (array_key_exists($bussv, $Business_Investment_Plan)) {
                                                                if ($bussv == 'loan_repayment') {
                                                                    $modelAre[$bussv][] = $Business_Investment_Plan[$bussv];
                                                                } else {
                                                                    $modelAre[$bussv] = $Business_Investment_Plan[$bussv];
                                                                }
                                                            }
                                                        }
                                                    }
                                                    //image upload
                                                    if (array_key_exists('familyimage_nextyear', $data['profileObject']['second_part_Object'])) {
                                                        $familyimage = $data['profileObject']['second_part_Object']['familyimage_nextyear'];

                                                        FamilyNextUpload::where('family_sub_mst_id', $sub_mst_id)->delete();
                                                        for ($i = 0; $i < count($familyimage); $i++) {

                                                            $familyimage_details = new FamilyNextUpload();
                                                            $familyimage_details->family_sub_mst_id = $sub_mst_id;
                                                            $familyimage_details->photos_videos_name = $familyimage[$i]['image_path'];
                                                            $familyimage_details->imagename = $familyimage[$i]['imagename'];

                                                            $familyimage_details->save();
                                                        }
                                                    }

                                                    if (array_key_exists('family_other_income_next_year', $data['profileObject']['second_part_Object'])) {
                                                        $family_other_income = $data['profileObject']['second_part_Object']['family_other_income_next_year'];

                                                        FamilyOtherIncomeNextYear::where('family_sub_mst_id', $sub_mst_id)->delete();
                                                        for ($i = 0; $i < count($family_other_income); $i++) {
                                                            $family_other_income_details = new FamilyOtherIncomeNextYear();
                                                            $family_other_income_details->family_sub_mst_id = $sub_mst_id;
                                                            $family_other_income_details->member_id = $family_other_income[$i]['member_id'];
                                                            $family_other_income_details->members_name = $family_other_income[$i]['members_name'];
                                                            $family_other_income_details->income_type = $family_other_income[$i]['income_type'];
                                                            $family_other_income_details->income_month = $family_other_income[$i]['income_month'];
                                                            $family_other_income_details->income = $family_other_income[$i]['income'];
                                                            $family_other_income_details->total_income = $family_other_income[$i]['total_income'];
                                                            $family_other_income_details->flag = $family_other_income[$i]['flag'];
                                                            // $family_other_income_details->income_guid = $family_other_income[$i]['income_guid'];
                                                            if (isset($family_other_income[$i]['income_guid'])) {
                                                                $family_other_income_details->income_guid = $family_other_income[$i]['income_guid'];
                                                            }



                                                            $family_other_income_details->save();
                                                        }
                                                    }
                                                }
                                                //_________
                                                $objNameAre = array(
                                                    'live_stock' => 'family_assets_live_stock',
                                                    'vehicle_types' => 'family_assets_vehicle',
                                                    'machinery_types' => 'family_assets_machinery',
                                                    'gadgets_types' => 'family_assets_gadgets',
                                                    'savings' => 'family_savings_source',
                                                    'other_savings' => 'family_savings_source_other',
                                                    'Family_Goals_object' => 'family_goals',
                                                    'fixed_investment' => 'family_fixed_investment',
                                                    'yearly_operational_expenses' => 'family_yearly_operational_expenses',
                                                    'income_from_business' => 'family_income_from_business',
                                                    'loan_repayment' => 'family_loan_repayment',
                                                    'Agriculture_production_this_year' => 'family_agriculture_production_this_year',
                                                    'Loan_Outstanding_object' => 'family_loan_outstanding',
                                                    'Expenditure_this_year_object' => 'family_expenditure_this_year',
                                                    'Agriculture_production_next_year' => 'family_agriculture_production_next_year',
                                                    'Expenditure_next_year_object' => 'family_expenditure_next_year'
                                                );

                                                //Multiple rows data
                                                foreach ($objNameAre as $objk1 => $tblv1) {
                                                    $res = DB::delete('delete from ' . $tblv1 . ' where family_sub_mst_id = ?', [$sub_mst_id]);
                                                    if (array_key_exists($objk1, $modelAre)) {
                                                        $profileObjectAre = $modelAre[$objk1];
                                                        foreach ($profileObjectAre as $profileObject) {
                                                            $NewAre = $this->keyDataLibrary($tblv1, $profileObject);
                                                            $this->tableMaintain($tblv1, $NewAre, $sub_mst_id, 1);
                                                        }
                                                    }
                                                }

                                                //Concent Form
                                                // if (array_key_exists('concent_form_object', $data)) { // check array key exist
                                                //     $concent_form_object = $data['concent_form_object'];
                                                //     $NewAre = $this->keyDataLibrary('family_concent', $concent_form_object);
                                                //     $this->tableMaintain('family_concent', $NewAre, $sub_mst_id);
                                                // }
                                                if (count($concent_id) == 1) {
                                                    if (array_key_exists('concent_form_object', $data)) { // check array key exist
                                                        $concent_form_object = $data['concent_form_object'];
                                                        $NewAre = $this->keyDataLibrary('family_concent', $concent_form_object);
                                                        $this->tableMaintain('family_concent', $NewAre, $sub_mst_id);
                                                    }
                                                }

                                                //RATING
                                                $NewAre = array();
                                                $newAreRat = array();
                                                if (array_key_exists('ratingObject', $data)) { // check array key exist
                                                    if (count($data['ratingObject']) > 0) {
                                                        $newAreRat = $data['ratingObject'];
                                                    }
                                                }
                                                $NewAre['rating'] = json_encode($newAreRat);
                                                $this->tableMaintain('family_rating', $NewAre, $sub_mst_id);

                                                if ($task == 'R') {
                                                    $this->save_rating($sub_mst_id);
                                                }

                                                $this->save_analysis($sub_mst_id);

                                                $response_msg = 'success';
                                                $query = "UPDATE family_mst set created_by = '$manager_id' WHERE id=$sub_mst_id";
                                                DB::update($query);
                                                notification($asgtkn, $mst_id, $assignment_type, $task,$task_a1,$user_id,$manager_id,$message,$message_save);

                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    return $response_msg;
                });
                // echo json_encode(array('status'=>$response_msg));
                if ($result != '') {
                    ini_set('memory_limit', '4000M');
                    ini_set('max_execution_time', '0');

                    // dd($result);
                    // prd("hello");
                    Log::info('Log message', array('asgtkn' => trim($request->post('agninsID')), 'assign_status' => trim($request->post('wst')), 'succes json' => $request->post('data')));
                    echo json_encode(array('status' => $result));
                }
            } catch (\Exception $e) {
                // prd("kjkj");
                Log::info('Log message', array('context' => $e->getMessage(), 'asgtkn' => trim($request->post('agninsID')), 'assign_status' => trim($request->post('wst')), 'error json' => $request->post('data')));
                die($e->getMessage());
                throw new HttpException(500, $e->getMessage());
            }
        } else {
            // die($e->getMessage());
            return $this->sendError('Invalid data request.');

        }
    }

    function cleanSpecialCharacters($input) {
        if (is_string($input)) {
            $decodedStr = json_decode(sprintf('"%s"', $input));
            $cleanedStr = preg_replace('/[^\p{L}\s]/u', '', $decodedStr);
            return $cleanedStr;
        } elseif (is_array($input)) {
            // prd($input);
            foreach ($input as $key => $value) {
                // $decodedStr = json_encode( $value);

                $input[$key] = $this->cleanSpecialCharacters($value); // Recursive cleaning for nested structures
            }

            return $input;
        } else {
            // If it's neither a string nor an array, return the input as-is or handle as needed
            return $input;
        }
    }

    function keyDataLibrary($table, $dataObject)
    {
        $profileField = array();

        $exAre = array('id', 'family_sub_mst_id', 'shg_sub_mst_id', 'cluster_sub_mst_id', 'federation_sub_mst_id');
        // $query = "select * from $table limit 1";
        // $profileColumn = DB::select($query);
        $profileColumn  = DB::select('select * from ' . $table . ' limit 1');
        foreach ($profileColumn as $pcl) {
            foreach ($pcl as $p => $ps) {
                if (!in_array($p, $exAre)) {
                    $profileField[$p] = $p;
                }
            }
        }

        $profile_int_type = array(
            'fp_age',
            'fp_family_mambers_no',
            'fp_children_no',
            'fp_children_no_in_primary_school',
            'fp_children_no_in_secondary_higher',
            'fp_children_no_in_college',
            'non_school_children_no',
            'fp_question_inlaws',
            'fp_family_mamber_over_60year',
            'fp_family_mamber_medication',
            'fp_earning_an_income',
            'fp_mamber_no_earn_fixed_income',
            'fp_mamber_no_earn_seasonal_income',
            'fp_mamber_no_earn_daily_income',
            'fp_pension_member',
            'fp_rate'
        );

        $dataAre = array();
        foreach ($profileField as $pfld) {

            if (array_key_exists($pfld, $dataObject)) {
                if (in_array($pfld, $profile_int_type)) {
                    $dataAre[$pfld] = (int) ($dataObject[$pfld]);
                } else {
                    $dataAre[$pfld] = trim($dataObject[$pfld]);
                }
            } else {
                $dataAre[$pfld] = '';
            }
        }

        return $dataAre;
    }

    function tableMaintain($table, $NewAre, $sub_mst_id, $multiple = 0)
    {

        $remove_arr = array('id' => '', 'assignID' => '', 'is_deleted' => '');
        $modelAre = array(
            'family_profile' => 'FamilyProfile',
            'family_assets' => 'FamilyAssets',
            'family_savings' => 'FamilySavings',
            'family_business_investment_plan' => 'FamilyBusinessInvestmentPlan',
            'family_observation_next_year' => 'FamilyObservationNextYear',
            'family_shgmember_commitment' => 'FamilyShgmemberCommitment',
            'family_income_this_year' => 'FamilyIncomeThisYear',
            'family_observation_this_year' => 'FamilyObservationThisYear',
            'family_income_next_year' => 'FamilyIncomeNextYear',
            'family_concent' => 'FamilyConcent',
            'family_rating' => 'FamilyRating',
            'family_observation_this_year_member' => 'FamilyObservationThisYearMember',
            'family_assets_live_stock' => 'FamilyAssetsLiveStock',
            'family_assets_vehicle' => 'FamilyAssetsVehicle',
            'family_assets_machinery' => 'FamilyAssetsMachinery',
            'family_assets_gadgets' => 'FamilyAssetsGadgets',
            'family_savings_source' => 'FamilySavingsSource',
            'family_savings_source_other' => 'FamilySavingsSourceOther',
            'family_goals' => 'FamilyGoals',
            'family_fixed_investment' => 'FamilyFixedInvestment',
            'family_yearly_operational_expenses' => 'FamilyYearlyOperationalExpenses',
            'family_income_from_business' => 'FamilyIncomeFromBusiness',
            'family_loan_repayment' => 'FamilyLoanRepayment',
            'family_agriculture_production_this_year' => 'FamilyAgricultureProductionThisYear',
            'family_loan_outstanding' => 'FamilyLoanOutstanding',
            'family_expenditure_this_year' => 'FamilyExpenditureThisYear',
            'family_agriculture_production_next_year' => 'FamilyAgricultureProductionNextYear',
            'family_expenditure_next_year' => 'FamilyExpenditureNextYear',
            'family_analysis_this_year' => 'FamilyAnalysisThisYear',
            'family_analysis_next_year' => 'FamilyAnalysisNextYear'
        );

        $temp = "\\App\\Models\\$modelAre[$table]";

        $model1 = new $temp();

        if ($multiple) {
            $model =  $model1;
        } else {
            $res = $model1::where('family_sub_mst_id', $sub_mst_id)->get();
            if (count($res) > 0) {
                $id = $res[0]['id'];
                $model = $model1::find($id);
            } else {
                $model =  $model1;
            }
        }

        $model->family_sub_mst_id = $sub_mst_id;
        foreach ($NewAre as $setKey => $setVal) {
            $setValue = '';

            if (is_array($setVal)) {
                $setVals = array();
                foreach ($setVal as $sval) {
                    $setVals[] = array_diff_key($sval, $remove_arr);
                }
                $setValue = json_encode($setVals);
            } else {
                if ($setVal != '')
                    $setValue = addslashes($setVal);
            }
            // if ($setValue == '') {
            //     $model->$setKey = $setValue;
            // }
            if ($setValue == '') {
                // unset($model->$setKey);
                $model->$setKey = $setValue;
            } else {
                $model->$setKey = $setValue;
            }
            $model->save();
        }
        //    $model = new $modelAre[$table];
        //    $model->family_sub_mst_id = $sub_mst_id;
        //    foreach ($NewAre as $setKey => $setVal) {
        //       $model->$setKey = $setVal;
        //    }
        //    $model->save();

        return TRUE;
    }

    public function save_analysis($family_sub_mst_id)
    {


        $analysis =  analysis($family_sub_mst_id);
        $grd_total_cy = $analysis['grand_total_cy'];
        $query = "UPDATE family_profile set analysis_rating= '$grd_total_cy' WHERE family_sub_mst_id=$family_sub_mst_id";
        $result = DB::update($query);
    }
    function save_rating($family_sub_mst_id)
    {
        $data['rating'] = DB::table('family_rating as a')
            ->where('is_deleted', '=', 0)
            ->where('a.family_sub_mst_id', '=', $family_sub_mst_id)
            ->select('a.rating')
            ->get()->toArray();
        $abc = stripslashes($data['rating'][0]->rating);
        $temp = implode(",", json_decode($abc));
        //prd($temp);
        $query_rate = "SELECT sum(mst_point) as rate FROM `rating_mst_qam_set` where mst_id IN($temp) ";
        $result_rate = DB::select($query_rate);
        $rate = $result_rate[0]->rate;
        $query = "UPDATE family_profile set fp_rate= '$rate' WHERE family_sub_mst_id=$family_sub_mst_id";
        $result = DB::update($query);
        //prd($query);
    }
}
