<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\API\FederationModel;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\FederationRating;
use App\Models\FederationChallenges;
use App\Models\TaskQaAssignment;
use App\Models\FederationProfile;
use App\Models\FederationGovernance;
use App\Models\Federation_Inclusion;
use App\Models\Federation_Efficiency;
use App\Models\Federation_CreditHistory;
use App\Models\Federation_Sustainability;
use App\Models\Federation_Risk_Mitigation;
use App\Models\Federation_Analysis;
use App\Models\Federation_Observation;
use App\Models\FederationSubMst;
use App\Models\FedUpload;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Notification;
use App\Mail\DartMail;
use Illuminate\Support\Facades\Mail;

//use App\Models\API\FederationGovernance;

class FederationController extends Controller
{

    public function __construct()
    {
        // echo url('/api/userauth');
        ini_set('max_execution_time', '0');
    }

    public function authuser($params)
    {
        //die($params);
        $mst_users = DB::table('users')
            ->where('email', $params['email'])
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        //prd($mst_users);
        if (!empty($mst_users)) {
            // prd($mst_users[0]->password);
            $hashed = Hash::make($params['password']);
            //echo($hashed);
            if (Hash::check($params['password'], $mst_users[0]->password)) {
                //die('hi');
                return 1;
            } else {
                //die('bye');
                return 0;
            }
        }
    }

    public function auth($params)
    {
        $mst_users = DB::table('users')
            //>where('email', $params['email'])
            ->where('email', $params)
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        //prd($mst_users);
        if (!empty($mst_users)) {
            return 1;
        } else {
            return 0;
        }

        return 0;
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
        if ($request->isMethod('post')) {
            try {
                $response_msg = 'failed';
                $result = DB::transaction(function ($response_msg) use ($request) {
                    if (isset($_POST['agninsID']) && $_POST['agninsID'] != '' && isset($_POST['data']) && $_POST['data'] != '' && isset($_POST['wst']) && ($_POST['wst'] == 'PR' || $_POST['wst'] == 'D')) {

                        $asgtkn        = trim($request->post('agninsID'));
                        $assign_status = trim($request->post('wst'));
                        $data          = trim($request->post('data'));
                        $sync_data     = trim($request->post('data'));

                        $args['data']     = $request->post('data');
                        $data = json_decode($args['data'], TRUE);
                        // prd($data['profileObject']['Federation_Profile_object']['name_of_federation']);
                        if (count($data) > 0) { // check array count
                            $query = "Select * from task_assignment where asgtkn='$asgtkn' AND assignment_type='FD' AND status IN('P','PR')";
                            $taskagnAre = DB::select($query);
                            //prd($taskagnAre);
                            if (!empty($taskagnAre)) {
                                $user_id = $taskagnAre[0]->user_id;
                                $query = " select parent_id from users  where id = '$user_id' ";

                                $manager_id = DB::select($query)[0]->parent_id;

                                $query = "Select * from users where id='$user_id' AND status ='A'";
                                $usersAre = DB::select($query);
                                //prd($usersAre[0]->email);
                                if (!empty($usersAre)) {
                                    //json log backup
                                    $query = "INSERT INTO sync_log_data (data,type,asgtkn,status) VALUES ('$sync_data','F','$asgtkn','$assign_status')";
                                    $sync_log_data = DB::insert($query);

                                    if ($assign_status == 'PR') {
                                        //json sync
                                        $query = "INSERT INTO sync_data (data,type,asgtkn,status) VALUES ('$sync_data','F','$asgtkn','$assign_status')";
                                        $sub_master = DB::insert($query);

                                        $email = $usersAre[0]->email;
                                        $password = $usersAre[0]->password;

                                        //=================================================================
                                        // $ch = curl_init();
                                        // curl_setopt($ch, CURLOPT_URL, $this->auth($email));
                                        // curl_setopt($ch, CURLOPT_POST, 1);
                                        // curl_setopt($ch, CURLOPT_POSTFIELDS,"email=$email&pwd=$password");
                                        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        // $server_output = curl_exec($ch);
                                        // //print_r($server_output); die;
                                        // curl_close ($ch);

                                        // $vld001 = json_decode($server_output);

                                        $query = "Select * from users where email='$email' AND status ='A'";
                                        $vld001 = DB::select($query);

                                        if (count($vld001) > 0) {
                                            //UPDATE task_assignment Table
                                            $response_msg = 'success';
                                            $query = "UPDATE task_assignment set status= 'PR' WHERE asgtkn='$asgtkn' AND status='P'";
                                            $result = DB::update($query);
                                        } else {
                                            $query = "UPDATE task_assignment set status= 'P' WHERE asgtkn='$asgtkn' AND status='PR'";
                                            $result = DB::update($query);
                                        }
                                        //====================================================================

                                    } else {

                                        $mst_id = $taskagnAre[0]->assignment_id;  // master id
                                        $task = $taskagnAre[0]->task;
                                        $task_a1 = $taskagnAre[0]->task_a1; // Analytics or Rating
                                        $status = $taskagnAre[0]->status; //
                                        $asgtkn = $taskagnAre[0]->asgtkn;  // asgtkn
                                        $user_id = $taskagnAre[0]->user_id; //
                                        $assignment_type = $taskagnAre[0]->assignment_type; //
                                        $remark = $taskagnAre[0]->remark; //

                                        if (isset($data['profileObject'])) { //die('ggg');
                                            //Task maintain
                                            $task_assignment = DB::update('update task_assignment set status = "D" where asgtkn = ?', [$asgtkn]);
                                            // Task_Qa_assignment maintain
                                            $modelQa = new TaskQaAssignment();
                                            $modelQa->asgtkn = $asgtkn;
                                            $modelQa->user_id = $user_id;
                                            $modelQa->dm_id = $manager_id;
                                            $modelQa->assignment_id = $mst_id;
                                            $modelQa->assignment_type = $assignment_type;
                                            $modelQa->verified_by = $manager_id;
                                            $modelQa->task = $task;
                                            $modelQa->remark = $remark;
                                            $modelQa->created_at = date('Y-m-d H:i:s');
                                            $modelQa->save();

                                            //notfication
                                            $user_name = User::where('id', '=', $user_id)->pluck('name')->toArray();
                                            $manager_name = User::where('id', '=', $manager_id)->pluck('name')->toArray();
                                            $query = "SELECT name_of_federation FROM federation_profile WHERE federation_sub_mst_id = $mst_id";
                                            $name = DB::select($query)[0]->name_of_federation;
                                            $message['task'] = "Federation";
                                            $message['status'] = "S";
                                            $message['manager_name'] = $user_name[0];
                                            $message['name'] = $name;
                                            $message['user_name'] = $manager_name[0];
                                            $message_save = '';
                                            $message_save = "$user_name[0].  has submitted $name(Federation) task. Please Check";
                                            $analytics     = 'P';
                                            $rating        = 'P';
                                            $cureent_status = 'N/A';

                                            // $data = $message;

                                            // Mail::to('gaurav.negi1830@gmail.com')->send(new DartMail($data));

                                            if ($task == 'A') {
                                                $analytics = 'D';
                                                $cureent_status = 'AP';
                                            }
                                            if ($task == 'R') {
                                                $rating = 'D';
                                                $analytics = 'D';
                                                $cureent_status = 'RP';
                                            }

                                            //Sub Master Log maintain
                                            $query = "select id from federation_sub_mst where federation_mst_id = $mst_id";
                                            $federation_sub_mst_data = DB::select($query);
                                            $federation_sub_mst_id = $federation_sub_mst_data[0]->id;

                                            //Sub master Active mainatain
                                            $model_SubMst = FederationSubMst::find($federation_sub_mst_data[0]->id);
                                            if ($task == 'A') {
                                                $model_SubMst->dm_a = 'P';
                                            }
                                            if ($task == 'R') {
                                                $model_SubMst->dm_r = 'P';
                                            }
                                            $model_SubMst->analytics = $analytics;
                                            $model_SubMst->rating = $rating;
                                            $model_SubMst->status_flag = 0;
                                            $model_SubMst->cureent_status = $cureent_status;
                                            $model_SubMst->updated_at = date('Y-m-d H:i:s');
                                            $model_SubMst->save();
                                            $federation_sub_mst_id = $model_SubMst->id;

                                            //PROFILE
                                            if (isset($data['profileObject']['Federation_Profile_object'])) {
                                                $FederationArray = $data['profileObject']['Federation_Profile_object'];
                                                $tablename = "federation_profile";
                                                $fldn = $this->checkColumn($tablename);
                                                $fData = $this->columnField($fldn, $FederationArray);
                                                $intChk = array(
                                                    'clusters_at_time_creation',
                                                    'shg_at_time_creation',
                                                    'members_at_time_creation',
                                                    'total_clusters',
                                                    'total_SHGs',
                                                    'total_members',
                                                    'rate'
                                                );

                                                $res = FederationProfile::where('federation_sub_mst_id', $federation_sub_mst_id)->get();
                                                // prd($fData);
                                                if (count($res) > 0) {
                                                    $id = $res[0]['id'];
                                                    $model_profile = FederationProfile::find($id);
                                                } else {

                                                    $model_profile = new FederationProfile();
                                                }

                                                //prd($model_profile);
                                                $model_profile->federation_sub_mst_id = $federation_sub_mst_id;

                                                foreach ($fData as $setKey => $setVal) {
                                                    $setValue = '';
                                                    if (in_array($setKey, $intChk)) {
                                                        $setValue = (int) $setVal;
                                                    } elseif ($setKey == 'Federation_Bank_ac') {
                                                        $removeKey = array('id' => '', 'assignID' => '');
                                                        $obj = array();
                                                        if (count($setVal) > 0) {
                                                            foreach ($setVal as $stp1) {
                                                                $obj[] = array_diff_key($stp1, $removeKey);
                                                            }
                                                        }
                                                        $setValue = json_encode($obj);
                                                    } else {
                                                        if ($setVal != '')
                                                            $setValue = addslashes($setVal);
                                                    }

                                                    if ($setValue == '') {
                                                        // unset($model_profile->$setKey);
                                                        $model_profile->$setKey = $setValue;
                                                    } else {
                                                        $model_profile->$setKey = $setValue;
                                                    }

                                                    $model_profile->save();
                                                }
                                                //prd($model_profile);

                                            }

                                            $listArr = array(
                                                "Federation_Governance_object" => "federation_governance",
                                                "Federation_Inclusion_object" => "federation_inclusion",
                                                "Federation_Efficiency_object" => "federation_efficiency",
                                                "Federation_CreditHistory_object" => "federation_credithistory",
                                                "Federation_Sustainability_object" => "federation_sustainability",
                                                "Federation_Risk_Mitigation_object" => "federation_risk_mitigation",
                                                "Federation_Analysis_object" => "federation_analysis",
                                                "Federation_Observation_object" => "federation_observation"
                                            );
                                            //OTHERS
                                            foreach ($listArr as $lkey => $lval) {
                                                //pr($lval);
                                                if (isset($data['profileObject'][$lkey])) {
                                                    $FederationArray = $data['profileObject'][$lkey];
                                                    $fldn = $this->checkColumn($lval);
                                                    $fData = $this->columnField($fldn, $FederationArray);
                                                    $modelclass = $this->getModelcls($lval);
                                                    $temp = "\\App\\Models\\$modelclass";
                                                    $model_name = new $temp();
                                                    //prd($model);
                                                    $res = $model_name::where('federation_sub_mst_id', $federation_sub_mst_id)->get();
                                                    // prd($fData);
                                                    if (count($res) > 0) {
                                                        $id = $res[0]['id'];
                                                        $model = $model_name::find($id);
                                                    } else {
                                                        $model = new $model_name();
                                                    }
                                                    //prd($model);
                                                    //echo $model = new $lkey();
                                                    $this->saveData($fData, $model, $federation_sub_mst_id);
                                                }
                                            }

                                            //CHALLENGES
                                            if (isset($data['profileObject']['Federation_Challenges_object'])) {
                                                $FederationChallenges = $data['profileObject']['Federation_Challenges_object'];
                                                $res = DB::delete('delete from federation_challenges where federation_sub_mst_id = ?', [$federation_sub_mst_id]);
                                                foreach ($FederationChallenges as $chlval) {
                                                    $model_challenges = new FederationChallenges();
                                                    $model_challenges->federation_sub_mst_id = $federation_sub_mst_id;

                                                    $challenge = '';
                                                    if (isset($chlval['challenge'])) {
                                                        $challenge = $chlval['challenge'];
                                                    }
                                                    $model_challenges->challenge = $challenge;
                                                    $remove_arr = array('id' => '', 'assignID' => '', 'challenge_id' => '');
                                                    $actVals = array();
                                                    if (isset($chlval['action'])) {
                                                        foreach ($chlval['action'] as $sval) {
                                                            $actVals[] = array_diff_key($sval, $remove_arr);
                                                        }
                                                    }
                                                    $model_challenges->action = json_encode($actVals);
                                                    $model_challenges->save();
                                                }
                                            }
                                            //image upload
                                            if (array_key_exists('Federationimage', $data['profileObject'])) {

                                                $Federationimage = $data['profileObject']['Federationimage']['Federationimage'];
                                                //  $query ="SELECT * FROM federation_upload_photos_videos WHERE federation_sub_mst_id = $federation_sub_mst_id ";
                                                //         $query = DB::select($query);
                                                //         // foreach ($query as $row)
                                                //         // {
                                                //         //     $path = public_path()."/assets/uploads/".$row->federation_sub_mst_id;
                                                //         //     unlink($path);
                                                //         // }
                                                FedUpload::where('federation_sub_mst_id', $federation_sub_mst_id)->delete();

                                                for ($i = 0; $i < count($Federationimage); $i++) {

                                                    $Federationimage_details = new FedUpload();
                                                    $Federationimage_details->federation_sub_mst_id = $federation_sub_mst_id;
                                                    $Federationimage_details->photos_videos_name = $Federationimage[$i]['image_path'];
                                                    $Federationimage_details->imagename = $Federationimage[$i]['imagename'];

                                                    $Federationimage_details->save();
                                                }
                                            }
                                            //RATING
                                            $NewAre = array();
                                            if (array_key_exists('ratingObject', $data)) { // check array key exist
                                                if (count($data['ratingObject']) > 0) {
                                                    $NewAre = $data['ratingObject'];
                                                }
                                            }
                                            //$NewAre = json_encode($newAreRat);
                                            $res = FederationRating::where('federation_sub_mst_id', $federation_sub_mst_id)->get();
                                            // prd($fData);
                                            if (count($res) > 0) {
                                                $id = $res[0]['id'];
                                                $model_rating = FederationRating::find($id);
                                            } else {

                                                $model_rating = new FederationRating();
                                            }
                                            //$model_rating = new FederationRating();
                                            $model_rating->federation_sub_mst_id = $federation_sub_mst_id;
                                            $model_rating->rating = json_encode($NewAre);
                                            //prd($model_rating->rating);
                                            $model_rating->save();
                                            if ($task == 'R') {
                                                $this->save_rating($federation_sub_mst_id);
                                            }
                                            $this->save_analysis($federation_sub_mst_id);

                                            $response_msg = 'success';
                                            $query = "UPDATE federation_mst set created_by = '$manager_id' WHERE id=$federation_sub_mst_id";
                                            DB::update($query);
                                            notification($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    return $response_msg;
                });
                if ($result != '') {
                    Log::info('Log message', array('asgtkn' => trim($request->post('agninsID')), 'assign_status' => trim($request->post('wst')), 'succes json' => $request->post('data')));
                    echo json_encode(array('status' => $result));
                }
            } catch (\Exception $e) {
                Log::info('Log message', array('context' => $e->getMessage(), 'asgtkn' => trim($request->post('agninsID')), 'assign_status' => trim($request->post('wst')), 'error json' => $request->post('data')));
                // Log::info('Log message', array('error json' => $request->post('data'));
                die($e->getMessage());
                throw new HttpException(500, $e->getMessage());
            }
        } else {
            return $this->sendError('Invalid data request.');
        }
    }
    public function checkColumn($tablename)
    {
        //pr($tablename);
        $fldn = array();

        $exAre = array('id', 'family_sub_mst_id', 'shg_sub_mst_id', 'cluster_sub_mst_id', 'federation_sub_mst_id');

        $profileColumn  = DB::select('select * from ' . $tablename . ' limit 1');

        //pr($profileColumn);
        foreach ($profileColumn as $pcl) {
            foreach ($pcl as $p => $ps) {
                if (!in_array($p, $exAre)) {
                    $fldn[$p] = $p;
                }
            }
        }

        return $fldn;
    }

    public function columnField($fldn, $FederationArray)
    {
        $fData = array();
        foreach ($fldn as $pfld) {
            if (array_key_exists($pfld, $FederationArray)) {
                if (is_array($FederationArray[$pfld])) {
                    $fData[$pfld] = $FederationArray[$pfld];
                } else {
                    $fData[$pfld] = trim($FederationArray[$pfld]);
                }
            } else {
                $fData[$pfld] = '';
            }
        }
        return $fData;
    }

    public function saveData($fData, $model, $federation_sub_mst_id)
    {

        $remove_arr = array('id' => '', 'assignID' => '', 'is_deleted' => '');
        $model->federation_sub_mst_id = $federation_sub_mst_id;
        //prd($fData);
        foreach ($fData as $setKey => $setVal) {
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

            if ($setValue == '') {
                // unset($model->$setKey);
                $model->$setKey = $setValue;
            } else {
                $model->$setKey = $setValue;
            }
            $model->save();
        }


        return true;
    }

    public function getModelcls($lval)
    {
        $mdArr = array(
            "federation_governance" => "FederationGovernance",
            "federation_inclusion" => "FederationInclusion",
            "federation_efficiency" => "FederationEfficiency",
            "federation_credithistory" => "FederationCredithistory",
            "federation_sustainability" => "FederationSustainability",
            "federation_risk_mitigation" => "FederationRiskMitigation",
            "federation_analysis" => "FederationAnalysis",
            "federation_observation" => "FederationObservation"
        );
        return $mdArr[$lval];
    }

    function save_analysis($federation_sub_mst_id)
    {
        $analysis =  fed_analysis($federation_sub_mst_id);
        $xfinal = $analysis['analysis_final_total'];
        $query = "UPDATE federation_profile set analysis_rating= '$xfinal' WHERE federation_sub_mst_id=$federation_sub_mst_id";
        $result = DB::update($query);
    }

    function save_rating($federation_sub_mst_id)
    {
        $data['rating'] = DB::table('federation_rating as a')
            ->where('is_deleted', '=', 0)
            ->where('a.federation_sub_mst_id', '=', $federation_sub_mst_id)
            ->select('a.rating')
            ->get()->toArray();
        $abc = stripslashes($data['rating'][0]->rating);
        $temp = implode(",", json_decode($abc));
        //$temp = implode(", ", json_decode($data['rating'][0]->rating));
        $query_rate = "SELECT sum(mst_point) as rate FROM `rating_mst_qam_set` where mst_id IN($temp) ";
        $result_rate = DB::select($query_rate);
        $rate = $result_rate[0]->rate;
        $query = "UPDATE federation_profile set rate= '$rate' WHERE federation_sub_mst_id=$federation_sub_mst_id";
        $result = DB::update($query);
        //prd($query);
    }
}
