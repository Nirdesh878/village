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
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Controllers\API\v1\SqlLibController;

class DataSyncfedController extends Controller
{

    public function __construct()
    {

    }

    public function FederationFeed($assignedid,$mst_id,$task_a1_a2) {

       $model_set = array();
       $newAre = array();
       $model_Are = array();

       $data_an = array();
       $data_rt = array();

       //___________________
       $model = DB::table('sync_data')
            ->where('asgtkn', $assignedid)
           ->orderBy('id','DESC')
           ->limit(1)
          ->get()->toArray();
       //$model = SyncData::model()->findAll("asgtkn='$assignedid' order by id DESC Limit 1");
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

       $listArr = array("Federation_Profile_object"=>'federation_profile',
                        "Federation_Governance_object" => "federation_governance",
                        "Federation_Inclusion_object" => "federation_inclusion",
                        "Federation_Efficiency_object" => "federation_efficiency",
                        "Federation_CreditHistory_object" => "federation_credithistory",
                        "Federation_Sustainability_object" => "federation_sustainability",
                        "Federation_Risk_Mitigation_object" => "federation_risk_mitigation",
                        "Federation_Analysis_object" => "federation_analysis",
                        "Federation_Observation_object" => "federation_observation");

        $jsonObj_tablename_child = array('Federation_Governance_object'=>array('Federation_Commit_Governance_Training_object',
                                         'Federation_SAC_Governance_Training_object','Federation_BOOK_Governance_Training_object'),
                                         'Federation_Profile_object'=>array('Federation_Bank_ac'),
                                         'Federation_Sustainability_object'=>array('Federation_Sustainability_Service'),
                                         );

     $Are = array();
     $mstAre=DB::table('federation_mst')
            ->where('id', $mst_id)
          ->get()->toArray();
    // $mstAre = FederationMst::model()->findAll("id=$mst_id");
     foreach($mstAre as $val1)
     {
      $val1=(array)$val1;
     $Are['uin'] = $val1['uin'];
     $SqlLib=new SqlLibController();
     $Are['agency'] = $SqlLib->AgencynameByid($val1['agency_id']);
     }
     $Are['assignID'] = $assignedid; // Assigned ID


       foreach($listArr as $objk=>$tblv)
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

           $a=array_merge($Are,$model['federation_profile']);
           $model['federation_profile']=$a;
          //----

                //CHALLENGES
                $challences = array();
                if (isset($data_an['Federation_Challenges_object'])) {
                    $FederationChallenges = $data_an['Federation_Challenges_object'];

                    foreach ($FederationChallenges as $chlval) {
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

                $model['federation_challenges'][] = $challences;

                //RATING
                $model['federation_rating']['rating']=$data_rt;
               }


               return $model;
        }



    function keyDataLibrary($table,$dataObject) {

        $profileField = array();
        $exAre = array('id','family_sub_mst_id','shg_sub_mst_id','cluster_sub_mst_id','federation_sub_mst_id');

        $profileColumn = DB::table($table)
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

         $profile_int_type = array('clusters_at_time_creation',
                        'shg_at_time_creation',
                        'members_at_time_creation',
                        'total_clusters',
                        'total_SHGs',
                        'total_members','rate');

        $dataAre = array();

         foreach ($profileField as $pfld) {

            if (array_key_exists($pfld, $dataObject)) {
                if (in_array($pfld, $profile_int_type)) {
                    $dataAre[$pfld] = (int) ($dataObject[$pfld]);
                 }else{
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
