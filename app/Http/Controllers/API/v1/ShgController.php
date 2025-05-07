<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\API\ShgModel;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\TaskQaAssignment;
use App\Models\Preanalytics;
use App\Models\User;
use App\Models\Shg;
use App\Models\ShgProfile;
use App\Models\ShgChallenges;
use App\Models\ShgSubMst;
use App\Models\ShgAnalysis;
use App\Models\ShgCreditrecovery;
use App\Models\ShgEfficiency;
use App\Models\ShgGovernance;
use App\Models\ShgInclusion;
use App\Models\ShgSaving;
use App\Models\ShgRating;
use App\Models\ShgObservation;
use App\Models\ShgUpload;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;
use App\Mail\DartMail;
use Illuminate\Support\Facades\Mail;

class ShgController extends Controller
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
        if ($request->isMethod('post')) { //die($request->post('agninsID'));
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
                        //prd($data);
                        if (count($data) > 0) { // check array count
                            $query = "Select * from task_assignment where asgtkn='$asgtkn' AND assignment_type='SH' AND status IN('P','PR')";
                            $taskagnAre = DB::select($query);

                            if (!empty($taskagnAre)) {
                                $user_id = $taskagnAre[0]->user_id;

                                $query = " select parent_id from users  where id = '$user_id' ";
                                $manager_id = DB::select($query)[0]->parent_id;

                                $query = "Select * from users where id='$user_id' AND status ='A'";
                                $usersAre = DB::select($query);
                                if (!empty($usersAre)) {
                                    //json log backup
                                    $query = "INSERT INTO sync_log_data (data,type,asgtkn,status) VALUES ('$sync_data','S','$asgtkn','$assign_status')";
                                    $sync_log_data = DB::insert($query);

                                    if ($assign_status == 'PR') {
                                        //json sync
                                        $query = "INSERT INTO sync_data (data,type,asgtkn,status) VALUES ('$sync_data','S','$asgtkn','$assign_status')";
                                        $sub_master = DB::insert($query);
                                        //prd($sub_master);
                                        $email = $usersAre[0]->email;
                                        $password = $usersAre[0]->password;
                                        //prd($password);
                                        //=================================================================
                                        // $ch = curl_init();
                                        // curl_setopt($ch, CURLOPT_URL, url('/api/userauth'));
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
                                        $task = $taskagnAre[0]->task;   // Analytics or Rating
                                        $task_a1 = $taskagnAre[0]->task_a1;
                                        $status = $taskagnAre[0]->status; //
                                        $asgtkn = $taskagnAre[0]->asgtkn;  // asgtkn
                                        $user_id = $taskagnAre[0]->user_id; //
                                        $assignment_type = $taskagnAre[0]->assignment_type; //
                                        $remark = $taskagnAre[0]->remark; //

                                        if (array_key_exists('profileObject', $data)) {

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
                                            $modelQa->remark = $remark;
                                            $modelQa->created_at = date('Y-m-d H:i:s');
                                            $modelQa->save();

                                            // notification

                                            $user_name = User::where('id', '=', $user_id)->pluck('name')->toArray();
                                            $manager_name = User::where('id', '=', $manager_id)->pluck('name')->toArray();
                                            $query="SELECT shgName FROM shg_profile WHERE shg_sub_mst_id = $mst_id";
                                            $name = DB::select($query)[0]->shgName;
                                            $message['task'] = "SHG";
                                            $message['status'] = "S";
                                            $message['manager_name'] = $user_name[0];
                                            $message['name'] = $name;
                                            $message['user_name'] = $manager_name[0];
                                            $message_save ='';
                                            $message_save="$user_name[0] has submitted $name(SHG) task. Please Check";



                                            $analytics     = 'P';
                                            $rating        = 'P';
                                            $cureent_status = 'N/A';

                                            if ($task == 'A') {
                                                $analytics = 'D';
                                            }
                                            if ($task == 'R') {
                                                $rating = 'D';
                                                $analytics = 'D';
                                            }

                                            if($task=='A'){$analytics='D';$cureent_status= 'AP';}
                                            if($task=='R'){$rating='D';$analytics='D';$cureent_status= 'RP';}

                                            //Sub Master Log maintain
                                            /*$sub_master = DB::update('update shg_sub_mst set status = "L" where shg_mst_id = ? AND status = "A" ', [$mst_id]);*/

                                            $query = "select id from shg_sub_mst where shg_mst_id = $mst_id";
                                            $shg_sub_mst_data = DB::select($query);
                                            $sub_mst_id = $shg_sub_mst_data[0]->id;

                                            //Sub master Active mainatain
                                            $modeln = ShgSubMst::find($shg_sub_mst_data[0]->id);
                                            if ($task=='A') {
                                                $modeln->dm_a = 'P';
                                            }
                                            if ($task=='R') {
                                                $modeln->dm_r = 'P';
                                            }
                                            $modeln->analytics = $analytics;
                                            $modeln->rating = $rating;
                                            $modeln->status_flag = 0;
                                            $modeln->cureent_status = $cureent_status;
                                            $modeln->updated_at = date('Y-m-d H:i:s');
                                            $modeln->save();

                                            //PROFILE
                                            $jsonObj_tablename = array(
                                                'SHG_Profile_object' => 'shg_profile',
                                                'SHG_Governance_object' => 'shg_governance',
                                                'SHG_Inclusion_object' => 'shg_inclusion',
                                                'SHG_Efficiency_object' => 'shg_efficiency',
                                                'SHG_CreditRecovery_object' => 'shg_creditrecovery',
                                                'SHG_Saving_object' => 'shg_saving',
                                                'SHG_Analysis_object' => 'shg_analysis',
                                                'SHG_Observation_object' => 'shg_observation'
                                            );

                                            foreach ($jsonObj_tablename as $objk => $tblv) {
                                                if (array_key_exists($objk, $data['profileObject'])) {
                                                    $profileObject = $data['profileObject'][$objk];
                                                    $NewAre = $this->keyDataLibrary($tblv, $profileObject);
                                                    //prd($NewAre);
                                                    $this->tableMaintain($tblv, $NewAre, $sub_mst_id);
                                                }
                                            }

                                            //CHALLENGES
                                            if (array_key_exists('SHG_Challenges_object', $data['profileObject'])) {
                                                $ShgChallenges = $data['profileObject']['SHG_Challenges_object'];
                                                $res = DB::delete('delete from shg_challenges where shg_sub_mst_id = ?', [$sub_mst_id]);
                                                foreach ($ShgChallenges as $chlval) {
                                                    $model_challenges = new ShgChallenges();
                                                    $model_challenges->shg_sub_mst_id = $sub_mst_id;

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
                                                    //prd($model_challenges->action);
                                                    $model_challenges->save();
                                                }
                                            }
                                            //image upload
                                            if (array_key_exists('shgimage', $data['profileObject'])) {

                                                 $shgimage = $data['profileObject']['shgimage']['shgimage'];
                                                 ShgUpload::where('shg_sub_mst_id',$sub_mst_id)->delete();
                                                        //prd($familyimage);die('');
                                                        for ($i=0; $i <count($shgimage) ; $i++)
                                                        {

                                                            $shgimage_details = new ShgUpload();
                                                            $shgimage_details->shg_sub_mst_id = $sub_mst_id;
                                                            $shgimage_details->photos_videos_name = $shgimage[$i]['image_path'];
                                                            $shgimage_details->imagename = $shgimage[$i]['imagename'];

                                                            $shgimage_details->save();
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
                                            $res = ShgRating::where('shg_sub_mst_id', $sub_mst_id)->get();
                                            if (count($res) > 0) {
                                                $id = $res[0]['id'];
                                                $model_rating = ShgRating::find($id);
                                            } else {

                                                $model_rating = new ShgRating();
                                            }

                                            $model_rating->shg_sub_mst_id = $sub_mst_id;
                                            $model_rating->rating = json_encode($newAreRat);
                                            //prd($model_rating->rating);
                                            $model_rating->save();

                                            //$NewAre['rating'] = json_encode($newAreRat);
                                            //$this->tableMaintain('shg_rating',$NewAre,$sub_mst_id);
                                            if ($task=='R') {
                                                    $this->save_rating($sub_mst_id);
                                                }
                                            $this->save_analysis($sub_mst_id);
                                            $query = "UPDATE shg_mst set created_by = '$manager_id' WHERE id=$sub_mst_id";
                                            DB::update($query);
                                            $response_msg = 'success';
                                            notification($asgtkn, $mst_id, $assignment_type, $task,$task_a1,$user_id,$manager_id,$message,$message_save);

                                        }
                                    }
                                }
                            }
                        }
                    }
                    //echo json_encode(array('status'=>$response_msg));
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
    function keyDataLibrary($table, $dataObject)
    {
        $profileField = array();

        $exAre = array('id', 'family_sub_mst_id', 'shg_sub_mst_id', 'cluster_sub_mst_id', 'federation_sub_mst_id');

        $profileColumn  = DB::select('select * from ' . $table . ' limit 1');

        foreach ($profileColumn as $pcl) {
            foreach ($pcl as $p => $ps) {
                if (!in_array($p, $exAre)) {
                    $profileField[$p] = $p;
                }
            }
        }


        $profile_int_type = array(
            'members_at_creation',
            'current_members',
            'members_left',
            'members_neighborhood', 'rate'
        );

        $checkAre_type = array('SHG_Efficiency_Training_object');
        $removeKey = array('id' => '', 'assignID' => '', 'is_deleted' => '', 'country_id' => '');
        $obj = array();
        $dataAre = array();

        foreach ($profileField as $pfld) {

            if (array_key_exists($pfld, $dataObject)) {
                if (in_array($pfld, $profile_int_type)) {
                    $dataAre[$pfld] = (int) ($dataObject[$pfld]);
                } elseif (in_array($pfld, $checkAre_type)) {
                    if (count($dataObject[$pfld]) > 0) {
                        foreach ($dataObject[$pfld] as $stp1) {
                            $obj[] = array_diff_key($stp1, $removeKey);
                        }
                    }
                    $dataAre[$pfld] = json_encode($obj);
                } else {
                    $dataAre[$pfld] = trim($dataObject[$pfld]);
                }
            } else {
                $dataAre[$pfld] = '';
            }
        }

        return $dataAre;
    }

    function tableMaintain($table, $NewAre, $sub_mst_id)
    {

        $remove_arr = array('id' => '', 'assignID' => '', 'is_deleted' => '');
        $modelAre = array(
            'shg_profile' => 'ShgProfile',
            'shg_analysis' => 'ShgAnalysis',
            'shg_creditrecovery' => 'ShgCreditrecovery',
            'shg_efficiency' => 'ShgEfficiency',
            'shg_governance' => 'ShgGovernance',
            'shg_inclusion' => 'ShgInclusion',
            'shg_saving' => 'ShgSaving',
            'shg_observation' => 'ShgObservation'
        );


        // $model = new $modelAre[$table];
        // $model->shg_sub_mst_id = $sub_mst_id;
        // foreach ($NewAre as $setKey => $setVal) {
        //     $model->$setKey = $setVal;
        // }
        // $model->save();

        //  return TRUE;
        $temp = "\\App\\Models\\$modelAre[$table]";

        $model1 = new $temp();
        $res = $model1::where('shg_sub_mst_id', $sub_mst_id)->get();
        // prd($fData);
        if (count($res) > 0) {
            $id = $res[0]['id'];
            $model = $model1::find($id);
        } else {
            $model =  $model1;
        }
        // prd($model);
        $model->shg_sub_mst_id = $sub_mst_id;
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
            // prd($model);
            $model->save();
        }
        return TRUE;
    }

    function save_analysis($shg_sub_mst_id)
    {

        $analysis = shg_analysis($shg_sub_mst_id);

        $xfinal = $analysis['grd_total'];

        $query = "UPDATE shg_profile set analysis_rating= '$xfinal' WHERE shg_sub_mst_id=$shg_sub_mst_id";
        $result = DB::update($query);
    }
    function save_rating($shg_sub_mst_id)
    {
        $data['rating'] = DB::table('shg_rating as a')
                        ->where('is_deleted', '=', 0)
                        ->where('a.shg_sub_mst_id','=',$shg_sub_mst_id)
                        ->select('a.rating')
                        ->get()->toArray();
        $abc = stripslashes($data['rating'][0]->rating);
        $temp = implode(",", json_decode($abc));
        //$temp = implode(", ", json_decode($data['rating'][0]->rating));
        $query_rate = "SELECT sum(mst_point) as rate FROM `rating_mst_qam_set` where mst_id IN($temp) ";
        $result_rate = DB::select($query_rate);
        $rate = $result_rate[0]->rate;
        $query = "UPDATE shg_profile set rate= '$rate' WHERE shg_sub_mst_id=$shg_sub_mst_id";
        $result = DB::update($query);
        //prd($query);
    }
}
