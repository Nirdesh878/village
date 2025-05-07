<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Controllers\API\SqlLibController;

class DataSyncshgController extends Controller
{

    public function __construct()
    {

    }
    public function ShgFeed($assignedid,$mst_id,$task_a1_a2) { 
        
       //_____________________
       
       $model_set = array();
       $newAre = array(); 
       $model_Are = array();
       
       $data_an = array();
       $data_rt = array();
       $model = array();
       //___________________
       
       $model = DB::table('sync_data')
            ->where('asgtkn', $assignedid)
           ->orderBy('id','DESC')
           ->limit(1)
          ->get()->toArray();
       //SyncData::model()->findAll("asgtkn='$assignedid' order by id DESC Limit 1");
       if (!empty($model)) {
        $model=(array)$model;
       $model_data = $model[0]->data;
       $data = json_decode($model_data, TRUE);
       
       if(array_key_exists('profileObject', $data)){
       $data_an = $data['profileObject'];
       }
       
       if(array_key_exists('ratingObject', $data)){
       $data_rt = $data['ratingObject'];
       }
        $model = array();
       //___________________
       
       $jsonObj_tablename = array('SHG_Profile_object'=>'shg_profile',
                        'SHG_Governance_object'=>'shg_governance',
                        'SHG_Inclusion_object'=>'shg_inclusion',
                        'SHG_Efficiency_object'=>'shg_efficiency',
                        'SHG_CreditRecovery_object'=>'shg_creditrecovery',
                        'SHG_Saving_object'=>'shg_saving',
                        'SHG_Analysis_object'=>'shg_analysis',
                        'SHG_Observation_object'=>'shg_observation');
      
     $Are = array(); 
     
     $mstAre =DB::table('shg_mst')
            ->where('id', $mst_id)
           ->get()->toArray();
     // ShgMst::model()->findAll("id=$mst_id");
     foreach($mstAre as $val1)
     {
      $val1=(array)$val1;
     $Are['uin'] = $val1['uin'];
     $SqlLib=new SqlLibController();
     $Are['agency'] = $SqlLib->AgencynameByid($val1['agency_id']);
     }
     $Are['assignID'] = $assignedid; // Assigned ID   

     $parent=$SqlLib->Shgparent($mst_id); //added*
     $Are['clusterName']=$parent['cluster']; //added*
     $Are['federationName']=$parent['federation']; //added*
    
     foreach($jsonObj_tablename as $objk=>$tblv)
     {
     
     if (array_key_exists($objk, $data_an)) {
                    $profileObject = $data_an[$objk];
                    $NewAre = $this->keyDataLibrary($tblv, $profileObject);
                    $model[$tblv]=$this->tableMaintain($NewAre);
                }
            }
  
      
      
      $a=array_merge($Are,$model['shg_profile']);
      $model['shg_profile']=$a;
      //--- 
      $removeKey = array('id','assignID');
      $Ef_Training_object=array();
      
      if (array_key_exists('SHG_Efficiency_Training_object', $data_an['SHG_Efficiency_object'])) {
                    $Efficiency_Training = $data_an['SHG_Efficiency_object']['SHG_Efficiency_Training_object'];
                    
                    foreach ($Efficiency_Training as $vn) {
                        $newAre = array();
                foreach ($vn as $kn => $vnn) {
                    if (!in_array($kn, $removeKey)) {
                        $newAre[$kn] = $vnn;
                    }
                }
              $Ef_Training_object[]= $newAre;
            }
        }
             
       $model['shg_efficiency']['SHG_Efficiency_Training_object']=$Ef_Training_object;
       //--
       $model['shg_rating']['rating']=$data_rt;
       //--
       
        //CHALLENGES
        $challences= array();
        if (array_key_exists('SHG_Challenges_object',$data_an)) {
        $ShgChallenges = $data_an['SHG_Challenges_object'];

        foreach ($ShgChallenges as $chlval) {
           
            $challenge='';
            if (isset($chlval['challenge'])) {
              $challenge = $chlval['challenge'];  
            } 

            $remove_arr = array('id' => '', 'assignID' => '', 'challenge_id' => '');

            $actVals = array();
            if (isset($chlval['action'])) {
                foreach ($chlval['action'] as $sval) {
                   $actVals[] = array_diff_key($sval, $remove_arr);
                }
            }
            
           $challences['challenge']= $challenge;
           $challences['action']= $actVals;
          }
        }
       
       $model['shg_challenges'][] = $challences;
       }  
     return $model;
     
    }
   
    function keyDataLibrary($table,$dataObject) {
        
        $profileField = array();
        
        $exAre = array('id','family_sub_mst_id','shg_sub_mst_id','cluster_sub_mst_id','federation_sub_mst_id');
        
        $profileColumn = DB::table($table)
            ->limit(1)
            ->get()->toArray();
       // Yii::app()->db->createCommand("select * from $table limit 1")->queryAll();
         foreach ($profileColumn as $pcl) {
            foreach ($pcl as $p=>$ps) {
                if(!in_array($p, $exAre))
                {
                $profileField[$p] = $p;
                }
            }
        }
        
        $profile_int_type = array('members_at_creation',
                                  'current_members',
                                  'members_left',
                                  'members_neighborhood','rate');
        $dataAre = array();
        
         foreach ($profileField as $pfld) {

            if (array_key_exists($pfld, $dataObject)) {
                if (in_array($pfld, $profile_int_type)) {
                    $dataAre[$pfld] = (int) ($dataObject[$pfld]);
                } else {
                    $dataAre[$pfld] = $dataObject[$pfld];
                }
            } else {
                $dataAre[$pfld] = '';
            }
         }   
        
        return $dataAre;
     }
     
     
     function tableMaintain($NewAre) {
         $model = array();
         foreach ($NewAre as $setKey => $setVal) {
            $model[$setKey] = $setVal;
         }
         return $model;
     }
     
     
}
