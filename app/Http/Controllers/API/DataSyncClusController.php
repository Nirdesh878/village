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

class DataSyncClusController extends Controller
{

    public function __construct()
    {

    }

    public function ClusterFeed($assignedid,$mst_id,$task_a1_a2) { 
        
       //_____________________
       
       $model_set = array();
       $newAre = array(); 
       $model_Are = array();
       
       $data_an = array();
       $data_rt = array();
       
       //___________________
       
       $model =DB::table('sync_data')
            ->where('asgtkn', $assignedid)
           ->orderBy('id','DESC')
           ->limit(1)
          ->get()->toArray();
          // SyncData::model()->findAll("asgtkn='$assignedid' order by id DESC Limit 1");
       if (!empty($model)) {
        $model[0]=(array)$model[0];
       $model_data = $model[0]['data'];
       $data = json_decode($model_data, TRUE);
       
       if(array_key_exists('profileObject', $data)){
       $data_an = $data['profileObject'];
       }
       
       if(array_key_exists('ratingObject', $data)){
       $data_rt = $data['ratingObject'];
       }
        
       $model = array();
       //___________________
       
        $jsonObj_tablename = array('Cluster_Profile_object'=>'cluster_profile',
            'Cluster_Governance_object'=>'cluster_governance',
            'Cluster_Inclusion_object'=>'cluster_inclusion',
            'Cluster_Efficiency_object'=>'cluster_efficiency',
            'Cluster_CreditRecovery_object'=>'cluster_creditrecovery',
            'Cluster_Saving_object'=>'cluster_saving',
            'Cluster_Analysis_object'=>'cluster_analysis',
            'Cluster_Observation_object'=>'cluster_observation');

        $jsonObj_tablename_child = array('Cluster_Governance_object'=>array('Cluster_Subcommittee_object'),
                               'Cluster_Efficiency_object'=>array('Cluster_Commit_Efficiency_Training_object',
                               'Cluster_SAC_Efficiency_Training_object'));
        
     
     $Are = array(); 
     $mstAre = DB::table('cluster_mst')
            ->where('id', $mst_id)
            ->get()->toArray();
     //ClusterMst::model()->findAll("id=$mst_id");
     foreach($mstAre as $val1)
     {
      $val1=(array)$val1;
     $Are['uin'] = $val1['uin'];
     $SqlLib=new SqlLibController();
     $Are['agency'] = $SqlLib->AgencynameByid($val1['agency_id']);
     }
     $Are['assignID'] = $assignedid; // Assigned ID   
$parent=$SqlLib->Clusterparent($mst_id); //added*
     $Are['name_of_federation']=$parent['federation']; //added*     

            foreach($jsonObj_tablename as $objk=>$tblv)
            {
              
            if (array_key_exists($objk, $data_an)) {
            $profileObject = $data_an[$objk];   
            $NewAre = $this->keyDataLibrary($tblv,$profileObject);
            $model[$tblv]= $this->tableMaintain($NewAre);
            }
            
            if(array_key_exists($objk, $jsonObj_tablename_child))
            {
             foreach($jsonObj_tablename_child[$objk] as $val)
              {
                $removeKey = array('id' => '', 'assignID' => '');
                if(count($profileObject[$val]) > 0){
                foreach($profileObject[$val] as $chval)
                {  
                  $newAre = array();
                   foreach($chval as $chvkey => $chval1)
                   {
                    if (!array_key_exists($chvkey, $removeKey)) {
                        $newAre[$chvkey] = $chval1;
                    }   
                   }
                 $model[$tblv][$val][]= $newAre;
                }
                }else{
                $model[$tblv][$val]= array();
                }
              }
            }
          }

            $a=array_merge($Are,$model['cluster_profile']);
            $model['cluster_profile']=$a;
            //--- 

            // CHALLENGES
            $challences = array();
            if (array_key_exists('Cluster_Challenges_object',$data_an)) {
            $ClusterChallenges = $data_an['Cluster_Challenges_object'];

            foreach ($ClusterChallenges as $chlval) {
                
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
            
            $model['cluster_challenges'][] = $challences;
            
            //RATING
            $model['cluster_rating']['rating']=$data_rt;
       }

     return $model;
   }
      
    function keyDataLibrary($table,$dataObject) {
        
        $profileField = array();
        $exAre = array('id','family_sub_mst_id','shg_sub_mst_id','cluster_sub_mst_id','federation_sub_mst_id');
        
        $profileColumn =DB::table($table)
           ->limit(1)
          ->get()->toArray(); 
          //Yii::app()->db->createCommand("select * from $table limit 1")->queryAll();
         foreach ($profileColumn as $pcl) {
            foreach ($pcl as $p=>$ps) {
                if(!in_array($p, $exAre))
                {
                $profileField[$p] = $p;
                }
            }
        }
        
        
        $profile_int_type = array('no_of_of_shg_in_cluster',
                                  'shg_at_time_creation',
                                  'cluster_members_at_time_creation',
                                  'total_SHGs',
                                  'total_members','rate');
      
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
