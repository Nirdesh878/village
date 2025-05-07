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

class DataSyncController extends Controller
{

    public function __construct()
    {

    }

    public function FamilyFeed($assignedid,$mst_id,$task_a1_a2) {
        //die('hello');
       $newAre = array();
       $model_Are = array();
        $model = DB::table('sync_data')
            ->where('asgtkn', $assignedid)
           ->orderBy('id','DESC')
           ->limit(1)
            ->get()->toArray();
        //prd($model);
       if (!empty($model)) {
       //$model_data = $model[0]['data'];
       $model_data = $model[0]->data;
       //prd($model_data);
       $data = json_decode($model_data, TRUE);
       $model_set = array();

       $Are= array();
        $mstAre  =DB::table('family_mst')
            ->where('id', $mst_id)
           ->get()->toArray();
           $mstAre[0]=(array)$mstAre;
          //prd($mstAre[0][0]->uin);
       //$Are['uin'] = $mstAre[0]['uin'];
       $Are['uin'] = $mstAre[0][0]->uin;
       //prd($Are['uin']);
       $Are['fp_uin'] = $mstAre[0][0]->uin;
       $SqlLib=new SqlLibController();
       $Are['agency'] = $SqlLib->AgencynameByid($mstAre[0][0]->agency_id);
       $parent=$SqlLib->Familyparent($mst_id);
       $Are['fp_shg_name']=$parent['shg'];
       $Are['fp_cluster_name']=$parent['cluster'];
       $Are['fp_federation']=$parent['federation'];
       $Are['assignID'] = $assignedid; // Assigned ID
       $Are['part'] = $task_a1_a2; // part1, part2


    $singleRows= array('Family_Profile_object' => 'family_profile',
                      'Family_Assets_object' => 'family_assets',
                      'Savings_object' => 'family_savings',
                      'Business_Investment_Plan_object' => 'family_business_investment_plan',
                      'Observation_next_year_object' => 'family_observation_next_year',
                      'ShgMember_commitment_object' => 'family_shgmember_commitment',
                      'Income_this_year_object' => 'family_income_this_year',
                      'Observation_this_year_object' => 'family_observation_this_year',
                      'Income_next_year_object' => 'family_income_next_year');

                    $modelAre = array(); // for multiple rows

                    if(array_key_exists('first_part_Object',$data['profileObject']))
                    {
                    //CHALLENGES
                    if (array_key_exists('Challenges_object',$data['profileObject']['first_part_Object']))
                    {
                    $familyChallenges = $data['profileObject']['first_part_Object']['Challenges_object'];

                    $remove_arr = array('id' => '', 'fp_id' => '', 'challenge_id' => '');
                    $family_challenges = array();

                    if(count($familyChallenges) > 0)
                    {

                    foreach ($familyChallenges as $chlval) {
                        $model_challenges = array();
                        $challenge='';
                        if (isset($chlval['challenge'])) {
                          $challenge = $chlval['challenge'];
                        }
                        $model_challenges[] = $challenge;
                        $actVals = array();
                        if (isset($chlval['action'])) {
                            foreach ($chlval['action'] as $sval) {
                               $actVals[] = array_diff_key($sval, $remove_arr);
                            }
                        }
                        $model_challenges['action']=$actVals;
                        $family_challenges[]=$model_challenges;
                      }
                      $model_set['family_challenges'][]=$family_challenges;
                    }else{
                       $model_set['family_challenges']=array();
                    }
                    }
                    //END Chalenges

                    //observation_member_object
                    if (array_key_exists('Observation_this_year_object',$data['profileObject']['first_part_Object']))
                    {
                    $tb1='family_observation_this_year_member';
                    if (array_key_exists('observation_member_object',$data['profileObject']['first_part_Object']['Observation_this_year_object']))
                    {
                    $observation_member = $data['profileObject']['first_part_Object']['Observation_this_year_object']['observation_member_object'];
                    if(count($observation_member) > 0)
                    {
                    $NewAre = $this->keyDataLibrary($tb1,$observation_member);
                    $model_set[$tb1][] = $this->tableMaintain($tb1,$NewAre);
                    }else{
                    $model_set[$tb1] = array();
                    }
                    }
                    }
                    //END

                    //family_analysis_this_year
                    if (array_key_exists('Analysis_object',$data['profileObject']['first_part_Object']))
                    {
                    $tb1='family_analysis_this_year';
                    if (array_key_exists('this_year',$data['profileObject']['first_part_Object']['Analysis_object']))
                    {
                    $this_year = $data['profileObject']['first_part_Object']['Analysis_object']['this_year'];

                    if(count($this_year) > 0)
                    {
                    $NewAre = $this->keyDataLibrary($tb1,$this_year);
                    $model_set[$tb1][] = $this->tableMaintain($tb1,$NewAre);
                    }else{
                     $model_set[$tb1][] = array();
                    }
                    }else{
                    $model_set[$tb1][]=array();
                    }
                    }
                    //END

                    //family_analysis_next_year
                    if (array_key_exists('Analysis_object',$data['profileObject']['first_part_Object']))
                    {
                    $tb1='family_analysis_next_year';
                    if (array_key_exists('next_year',$data['profileObject']['first_part_Object']['Analysis_object']))
                    {
                    $next_year = $data['profileObject']['first_part_Object']['Analysis_object']['next_year'];

                    if(count($next_year) > 0)
                    {
                    $NewAre = $this->keyDataLibrary($tb1,$next_year);
                    $model_set[$tb1][] = $this->tableMaintain($tb1,$NewAre);
                    }else{
                    $model_set[$tb1][]=array();
                    }
                    }else{
                    $model_set[$tb1][]=array();
                    }
                    }
                    //END

                    //Single rows data
                    foreach ($singleRows as $objk=>$tblv) {
                    if(array_key_exists($objk, $data['profileObject']['first_part_Object'])) {
                    $profileObject = $data['profileObject']['first_part_Object'][$objk];
                    if(count($profileObject) > 0)
                    {
                    $NewAre = $this->keyDataLibrary($tblv,$profileObject);
                    $model_set[$tblv][] = $this->tableMaintain($tblv,$NewAre);
                    }else{
                    $model_set[$tblv] = array();
                    }
                    }
                    }

                     //___________
                     //Multiple rows _____
                     //Family_Assets
                     if(array_key_exists('Family_Assets_object',$data['profileObject']['first_part_Object']))
                     {
                     $Family_Assets_object= $data['profileObject']['first_part_Object']['Family_Assets_object'];
                     $FamAsAre = array('live_stock','vehicle_types','machinery_types','gadgets_types');
                     foreach($FamAsAre as $fasv)
                     {
                     if(array_key_exists($fasv, $Family_Assets_object))
                     {

                     if($fasv=='gadgets_types')
                      {
                       $modelAre[$fasv][]= $Family_Assets_object[$fasv];
                      }else{
                       $modelAre[$fasv]= $Family_Assets_object[$fasv];
                      }
                     }
                     }
                     }

                     //Savings_object
                     if(array_key_exists('Savings_object',$data['profileObject']['first_part_Object']))
                     {
                     $Family_Savings_object= $data['profileObject']['first_part_Object']['Savings_object'];
                     if(array_key_exists('savings', $Family_Savings_object))
                     {
                     $modelAre['savings']= $Family_Savings_object['savings'];
                     }
                     }

                     //Savings_object_other
                     if(array_key_exists('Savings_object',$data['profileObject']['first_part_Object']))
                     {
                     $Family_Savings_object= $data['profileObject']['first_part_Object']['Savings_object'];
                     if(array_key_exists('other_savings', $Family_Savings_object))
                     {
                     $modelAre['other_savings']= $Family_Savings_object['other_savings'];
                     }else{
                     $modelAre['other_savings']= array();
                     }
                     }

                     $famlyAres= array(
                     'Family_Goals_object',
                     'Agriculture_production_this_year',
                     'Loan_Outstanding_object',
                     'Expenditure_this_year_object');

                     foreach($famlyAres as $fasAr)
                     {
                     if(array_key_exists($fasAr,$data['profileObject']['first_part_Object']))
                     {
                     $modelAre[$fasAr]= $data['profileObject']['first_part_Object'][$fasAr];
                     }
                     }
                     }


                    if(array_key_exists('second_part_Object',$data['profileObject']))
                    {
                    //Single rows data
                    foreach ($singleRows as $objk=>$tblv) {

                    if(array_key_exists($objk, $data['profileObject']['second_part_Object'])) {
                    $profileObject = $data['profileObject']['second_part_Object'][$objk];
                    if(count($profileObject) > 0)
                    {
                    $NewAre = $this->keyDataLibrary($tblv,$profileObject);
                    $model_set[$tblv][] = $this->tableMaintain($tblv,$NewAre);
                    }else{
                    $model_set[$tblv] = array();
                    }
                    }
                    }

                    //____________

                     $famlyAres2= array(
                     'Agriculture_production_next_year',
                     'Expenditure_next_year_object');

                     foreach($famlyAres2 as $fasAr)
                     {
                     if(array_key_exists($fasAr, $data['profileObject']['second_part_Object']))
                     {
                     $modelAre[$fasAr]= $data['profileObject']['second_part_Object'][$fasAr];
                     }
                     }

                     //Multiple rows _____
                     //Business_Investment_Plan_object
                     if(array_key_exists('Business_Investment_Plan_object',$data['profileObject']['second_part_Object']))
                     {
                     $Business_Investment_Plan= $data['profileObject']['second_part_Object']['Business_Investment_Plan_object'];
                     $BusAsAre = array('fixed_investment','yearly_operational_expenses','income_from_business','loan_repayment');
                     foreach($BusAsAre as $bussv)
                     {
                     if(array_key_exists($bussv, $Business_Investment_Plan))
                     {
                     if($bussv=='loan_repayment')
                      {
                      $modelAre[$bussv][]= $Business_Investment_Plan[$bussv];
                      }else{
                      $modelAre[$bussv]= $Business_Investment_Plan[$bussv];
                      }
                      }
                     }
                     }
                    }

                     //_________

                   $objNameAre= array('live_stock' => 'family_assets_live_stock',
                                'vehicle_types' => 'family_assets_vehicle',
                                'machinery_types' => 'family_assets_machinery',
                                'gadgets_types' => 'family_assets_gadgets',
                                'savings' => 'family_savings_source',
                                'other_savings' => 'family_savings_source_other',
                                'Family_Goals_object' => 'family_goals',
                                'fixed_investment' =>'family_fixed_investment',
                                'yearly_operational_expenses' =>'family_yearly_operational_expenses',
                                'income_from_business' =>'family_income_from_business',
                                'loan_repayment' =>'family_loan_repayment',
                                'Agriculture_production_this_year' => 'family_agriculture_production_this_year',
                                'Loan_Outstanding_object' => 'family_loan_outstanding',
                                'Expenditure_this_year_object' => 'family_expenditure_this_year',
                                'Agriculture_production_next_year' => 'family_agriculture_production_next_year',
                                'Expenditure_next_year_object' => 'family_expenditure_next_year');

                    //Multiple rows data
                     foreach ($objNameAre as $objk1=>$tblv1) {
                     if(array_key_exists($objk1, $modelAre)) {

                     $profileObjectAre = $modelAre[$objk1];

                     if(count($profileObjectAre) > 0)
                     {
                     foreach($profileObjectAre as $profileObject)
                     {
                     $NewAre = $this->keyDataLibrary($tblv1,$profileObject);
                     $model_set[$tblv1][] = $this->tableMaintain($tblv1,$NewAre);
                     }
                     }else{
                     $model_set[$tblv1] = array();
                     }
                     }
                     }


                    //RATING
                    $NewAre= array();
                    $newAreRat=array();
                    if (array_key_exists('ratingObject', $data)){ // check array key exist
                    if(count($data['ratingObject']) > 0)
                    {
                    $newAreRat = $data['ratingObject'];
                    }
                    }
                    $NewAre['rating']= $newAreRat;
                    $model_set['family_rating'][] = $NewAre;



                  $Data_set_part1 = array();

                  $Data_set_part1['family_profile']= array_merge($Are,$model_set['family_profile'][0]);
                  $Data_set_part1['family_income_this_year']= $model_set['family_income_this_year'][0];
                  $Data_set_part1['family_observation_this_year']= $model_set['family_observation_this_year'][0];
                  $Data_set_part1['family_observation_this_year']['family_observation_this_year_member'] = $model_set['family_observation_this_year_member'];
                  $Data_set_part1['family_savings']= $model_set['family_savings'][0];

                  if(array_key_exists('family_savings_source', $model_set))
                  {
                  $Data_set_part1['family_savings']['family_savings_source']= $model_set['family_savings_source'];
                  }else{
                  $Data_set_part1['family_savings']['family_savings_source']=array();
                  }

                  $Data_set_part1['family_savings']['family_savings_source_other']= $model_set['family_savings_source_other'];
                  $Data_set_part1['family_assets']= $model_set['family_assets'][0];
                  $Data_set_part1['family_assets']['family_assets_gadgets']= $model_set['family_assets_gadgets'];
                  $Data_set_part1['family_assets']['family_assets_live_stock']= $model_set['family_assets_live_stock'];
                  $Data_set_part1['family_assets']['family_assets_vehicle']= $model_set['family_assets_vehicle'];
                  $Data_set_part1['family_assets']['family_assets_machinery']= $model_set['family_assets_machinery'];
                  $Data_set_part1['family_rating']= $model_set['family_rating'][0];
                  $Data_set_part1['family_goals']= $model_set['family_goals'];
                  $Data_set_part1['family_agriculture_production_this_year']= $model_set['family_agriculture_production_this_year'];
                  $Data_set_part1['family_loan_outstanding']= $model_set['family_loan_outstanding'];
                  $Data_set_part1['family_expenditure_this_year']= $model_set['family_expenditure_this_year'];


                  $tmp= array();
                  $tmp['family_analysis_this_year']= $model_set['family_analysis_this_year'][0];
                  $tmp['family_analysis_next_year']= $model_set['family_analysis_next_year'][0];
                  $Data_set_part1['family_analysis_object'] = $tmp;
                  $Data_set_part1['family_challenges']= $model_set['family_challenges'];


                  $Data_set_part2 = array();
                  $Data_set_part2['family_shgmember_commitment']= $model_set['family_shgmember_commitment'][0];
                  $Data_set_part2['family_observation_next_year']= $model_set['family_observation_next_year'][0];
                  $Data_set_part2['family_income_next_year']= $model_set['family_income_next_year'][0];
                  $Data_set_part2['family_business_investment_plan']= $model_set['family_business_investment_plan'][0];
                  $Data_set_part2['family_business_investment_plan']['family_fixed_investment']= $model_set['family_fixed_investment'];
                  $Data_set_part2['family_business_investment_plan']['family_yearly_operational_expenses']= $model_set['family_yearly_operational_expenses'];
                  $Data_set_part2['family_business_investment_plan']['family_income_from_business']= $model_set['family_income_from_business'];
                  $Data_set_part2['family_business_investment_plan']['family_loan_repayment']= $model_set['family_loan_repayment'];

                  $Data_set_part2['family_agriculture_production_next_year']= $model_set['family_agriculture_production_next_year'];
                  $Data_set_part2['family_expenditure_next_year']= $model_set['family_expenditure_next_year'];

                  $model_Are['first_part'] = $Data_set_part1;
                  $model_Are['second_part']= $Data_set_part2;

                  }
                  return $model_Are;
         }

     public function keyDataLibrary($table,$dataObject) {
         //prd($table);
        $profileField = array();

        $exAre = array('id','family_sub_mst_id','shg_sub_mst_id','cluster_sub_mst_id','federation_sub_mst_id');
        //die('lll');
        //$profileColumn = Yii::app()->db->createCommand("select * from $table limit 1")->queryAll();
        $profileColumn = DB::select('select * from '.$table.' limit 1');
        //prd($profileColumn);
         foreach ($profileColumn as $pcl) {
            foreach ($pcl as $p=>$ps) {
                if(!in_array($p, $exAre))
                {
                $profileField[$p] = $p;
                }
            }
        }


      $profile_int_type = array('fp_age',
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
                                'fp_family_migrated',
                                'fp_family_reason_of_migration',
                                'fp_rate');

         $dataAre = array();
         foreach ($profileField as $pfld) {
            if (array_key_exists($pfld, $dataObject)) {
                if (in_array($pfld, $profile_int_type)) {
                    $dataAre[$pfld] = (int) ($dataObject[$pfld]);
                }else{
                    $dataAre[$pfld] = trim($dataObject[$pfld]);
                }
            } else {
                $dataAre[$pfld] = '';
            }
         }
        return $dataAre;
     }

function tableMaintain($table,$NewAre) {

         //Exclude Deleted field
         $exclude = array('other_loan','other_amount','other_interest');
         $model = array();

           switch ($table) {
     case 'family_savings':
         foreach ($NewAre as $setKey => $setVal) {
            if(!in_array($setKey, $exclude))
            {
            $model[$setKey] = $setVal;
            }
          }
         break;
    default:
         foreach ($NewAre as $setKey => $setVal) {
            $model[$setKey] = $setVal;
          }
     }
    return $model;
  }
}
