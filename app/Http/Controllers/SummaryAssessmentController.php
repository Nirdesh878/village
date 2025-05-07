<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Agency;
use App\Models\Federation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FederationController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Imports\TestImport;
use Illuminate\Support\Facades\Session;
use DateTime;




class SummaryAssessmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::User();

        // prd($request->all());
        if (!empty($request->get('Search'))) {
            Session::put('summary_filter_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('summary_filter_session');
        }
        $session_data = Session::get('summary_filter_session');

        $data = [];
        $data['agency']=DB::table('agency')
            ->select('*')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
            $query = "SELECT

            s.id,
            s.uin AS uin ,
            sp.shgName AS shg_name,
            sp.shg_code AS NRLM_code,
            cp.name_of_cluster AS cluster_name,
            fedp.name_of_federation AS federation_name,
            sp.village AS village,
            se.SHG_Efficiency_Training_object


         FROM
             federation_mst AS fed
              INNER JOIN federation_profile AS fedp
              ON fed.id = fedp.federation_sub_mst_id
              INNER JOIN
             cluster_mst AS c
             ON c.federation_uin = fed.uin
             INNER JOIN cluster_profile AS cp
             ON c.id = cp.cluster_sub_mst_id
             INNER JOIN shg_mst AS s
             ON c.uin = s.cluster_uin
             INNER JOIN shg_profile AS sp
             ON s.id = sp.shg_sub_mst_id
             INNER JOIN shg_efficiency AS se
             ON se.shg_sub_mst_id = s.id
              WHERE c.is_deleted = 0 AND s.is_deleted = 0  AND fed.uin =
             'INTNCH01092023FD74106772' ";
             $shg_training = DB::select($query);
            //  prd($shg_training);
            foreach($shg_training as $key => $res){
                $temp = (json_decode(stripslashes($res->SHG_Efficiency_Training_object)));


                    $shg_training[$key]->training_data = $temp;

                // pr($temp);

            }

            $data['shg_training'] = $shg_training;
            // prd($data['shg_training']);
            // die();
            // prd($temp);


            //  for ($i = 0; $i < count($temp); $i++) {

            //         $temp[$i][$i][] = $shg_training[$i];

            // }
            $data['temp'] = $temp;
            //  prd($data['temp']);





        if(!empty($session_data)){



            //    family income and expoenditure gap

            $query = "SELECT
                    id
                FROM

             family_mst where is_deleted = 0 AND federation_uin =
             'INTNCH01092023FD74106772' ";
            $family = DB::select($query);

            // foreach($family as $res){
        //   $data['family_assessment'][] = $this->family_analysis($res->id);

        // }
        // prd($data['family_assessment']);

            $query = "SELECT
                    id
                FROM

             shg_mst where is_deleted = 0 AND federation_uin =
             'INTNCH01092023FD74106772' ";
            $shg = DB::select($query);

            foreach($shg as $res){
          $data['shg_assessment'][] = $this->shg_analysis($res->id);

        }
        // prd($data['shg_assessment']);

            // prd($family);







    //         $agency = $session_data['agency'];
    //         $federation_uin_search =  $session_data['federation_id'];
    //         $query = "SELECT agency_name as name   from agency where is_deleted = 0 and agency_id = $agency";
    //         $data['agency_name'] = DB::select($query);


    //         $query = "SELECT GROUP_CONCAT(CONCAT('''', uin, '''')) AS uin FROM federation_mst WHERE is_deleted = 0 AND";
    //         if(!empty($federation_uin_search)){
    //             $query .=" uin = '$federation_uin_search'";
    //         }
    //         else{
    //             $query .=" agency_id = $agency";
    //         }


    //         $data['federation'] = DB::select($query);
    //         $fed_uin = $data['federation'][0]->uin;

    //         $values = trim($fed_uin, "'");
    //         $valuesArray = explode("','", $values);
    //         $data['fed_count'] = count($valuesArray);
    //         // prd($count);

    //         $query = "SELECT GROUP_CONCAT(CONCAT('''', uin, '''')) AS uin from cluster_mst where is_deleted = 0 and federation_uin in($fed_uin)";
    //         $data['cluster'] = DB::select($query);
    //         $cluster_uin = $data['cluster'][0]->uin;
    //         $values = trim($cluster_uin, "'");
    //         $valuesArray = explode("','", $values);
    //         $data['cluster_count'] = count($valuesArray);


    //         $query = "SELECT GROUP_CONCAT(CONCAT('''', uin, '''')) AS uin from shg_mst where is_deleted = 0 and cluster_uin in($cluster_uin)";
    //         $data['shg'] = DB::select($query);
    //         $shg_uin = $data['shg'][0]->uin;
    //         $values = trim($shg_uin, "'");
    //         $valuesArray = explode("','", $values);
    //         $data['shg_count'] = count($valuesArray);



    //         $query = "SELECT count(*) AS count from family_mst where is_deleted = 0 and shg_uin in($shg_uin)";
    //         $data['family_count'] = DB::select($query);
    //         // $family_uin = $data['family'][0]->uin;
    //         // prd($data['family_count']);

    //         // federation risk levels

    //         $query="SELECT
    //         SUM(CASE WHEN p.analysis_rating >= 90 THEN 1 ELSE 0 END) as green,
    //         SUM(CASE WHEN p.analysis_rating >= 75 AND p.analysis_rating < 90 THEN 1 ELSE 0 END) as yellow,
    //         SUM(CASE WHEN p.analysis_rating >= 60 AND p.analysis_rating < 75 THEN 1 ELSE 0 END) as grey,
    //         SUM(CASE WHEN p.analysis_rating < 60 THEN 1 ELSE 0 END) as red
    //       FROM federation_mst as a
    //       INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //       INNER JOIN federation_profile as p ON b.federation_mst_id = p.federation_sub_mst_id
    //       WHERE a.is_deleted = 0 AND ";
    //       if(!empty($federation_uin_search)){
    //         $query .=" a.uin = '$federation_uin_search'";
    //         }
    //         else{
    //             $query .=" a.agency_id = $agency";
    //         }
    //     //    prd($query);
    //         $data['fed_rating'] = DB::select($query);

    //         $data['grrenPercentage'] = 0;
    //         $data['yellowPercentage'] = 0;
    //         $data['greyPercentage'] = 0;
    //         $data['redPercentage'] = 0;

    //         if($data['fed_rating'][0]->green > 0){
    //         $data['grrenPercentage'] = ($data['fed_rating'][0]->green / $data['fed_count']) * 100;

    //         }
    //         if($data['fed_rating'][0]->yellow > 0){
    //         $data['yellowPercentage'] = ($data['fed_rating'][0]->yellow / $data['fed_count']) * 100;

    //         }
    //         if($data['fed_rating'][0]->grey > 0){
    //         $data['greyPercentage'] = ($data['fed_rating'][0]->grey / $data['fed_count']) * 100;

    //         }
    //         if($data['fed_rating'][0]->red > 0){
    //         $data['redPercentage'] = ($data['fed_rating'][0]->red / $data['fed_count']) * 100;

    //         }

    //         // cluster risk level

    //         $query="SELECT
    //         SUM(CASE WHEN p.analysis_rating >= 90 THEN 1 ELSE 0 END) as green,
    //         SUM(CASE WHEN p.analysis_rating >= 75 AND p.analysis_rating < 90 THEN 1 ELSE 0 END) as yellow,
    //         SUM(CASE WHEN p.analysis_rating >= 60 AND p.analysis_rating < 75 THEN 1 ELSE 0 END) as grey,
    //         SUM(CASE WHEN p.analysis_rating < 60 THEN 1 ELSE 0 END) as red
    //       FROM cluster_mst as a
    //       INNER JOIN cluster_sub_mst as b ON a.id = b.cluster_mst_id
    //       INNER JOIN cluster_profile as p ON b.cluster_mst_id = p.cluster_sub_mst_id
    //       WHERE a.is_deleted = 0 AND federation_uin in ($fed_uin)";


    //         $data['cluster_rating'] = DB::select($query);

    //         $data['cluster_grrenPercentage'] = 0;
    //         $data['cluster_yellowPercentage'] = 0;
    //         $data['cluster_greyPercentage'] = 0;
    //         $data['cluster_redPercentage'] = 0;

    //         if($data['cluster_rating'][0]->green > 0){
    //         $data['cluster_grrenPercentage'] = ($data['cluster_rating'][0]->green / $data['cluster_count']) * 100;

    //         }
    //         if($data['cluster_rating'][0]->yellow > 0){
    //         $data['cluster_yellowPercentage'] = ($data['cluster_rating'][0]->yellow / $data['cluster_count']) * 100;

    //         }
    //         if($data['cluster_rating'][0]->grey > 0){
    //         $data['cluster_greyPercentage'] = ($data['cluster_rating'][0]->grey / $data['cluster_count']) * 100;
    //         }
    //         if($data['cluster_rating'][0]->red > 0){
    //         $data['cluster_redPercentage'] = ($data['cluster_rating'][0]->red / $data['cluster_count']) * 100;
    //         }

    //         // shg risk level

    //         $query="SELECT
    //         SUM(CASE WHEN p.analysis_rating >= 90 THEN 1 ELSE 0 END) as green,
    //         SUM(CASE WHEN p.analysis_rating >= 75 AND p.analysis_rating < 90 THEN 1 ELSE 0 END) as yellow,
    //         SUM(CASE WHEN p.analysis_rating >= 60 AND p.analysis_rating < 75 THEN 1 ELSE 0 END) as grey,
    //         SUM(CASE WHEN p.analysis_rating < 60 THEN 1 ELSE 0 END) as red
    //       FROM shg_mst as a
    //       INNER JOIN shg_sub_mst as b ON a.id = b.shg_mst_id
    //       INNER JOIN shg_profile as p ON b.shg_mst_id = p.shg_sub_mst_id
    //       WHERE a.is_deleted = 0 AND cluster_uin in ($cluster_uin)";

    //         $data['shg_rating'] = DB::select($query);

    //         $data['shg_grrenPercentage'] = 0;
    //         $data['shg_yellowPercentage'] = 0;
    //         $data['shg_greyPercentage'] = 0;
    //         $data['shg_redPercentage'] = 0;

    //         if($data['shg_rating'][0]->green > 0){
    //         $data['shg_grrenPercentage'] = ($data['shg_rating'][0]->green / $data['shg_count']) * 100;

    //         }
    //         if($data['shg_rating'][0]->yellow > 0){
    //         $data['shg_yellowPercentage'] = ($data['shg_rating'][0]->yellow / $data['shg_count']) * 100;

    //         }
    //         if($data['shg_rating'][0]->grey > 0){
    //         $data['shg_greyPercentage'] = ($data['shg_rating'][0]->grey / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_rating'][0]->red > 0){
    //         $data['shg_redPercentage'] = ($data['shg_rating'][0]->red / $data['shg_count']) * 100;
    //         }

    //         // family risk level

    //         $query="SELECT
    //         SUM(CASE WHEN p.analysis_rating >= 90 THEN 1 ELSE 0 END) as green,
    //         SUM(CASE WHEN p.analysis_rating >= 75 AND p.analysis_rating < 90 THEN 1 ELSE 0 END) as yellow,
    //         SUM(CASE WHEN p.analysis_rating >= 60 AND p.analysis_rating < 75 THEN 1 ELSE 0 END) as grey,
    //         SUM(CASE WHEN p.analysis_rating < 60 THEN 1 ELSE 0 END) as red
    //       FROM family_mst as a
    //       INNER JOIN family_sub_mst as b ON a.id = b.family_mst_id
    //       INNER JOIN family_profile as p ON b.family_mst_id = p.family_sub_mst_id
    //       WHERE a.is_deleted = 0 AND shg_uin in ($shg_uin)";

    //         $data['family_rating'] = DB::select($query);

    //         $data['family_grrenPercentage'] = 0;
    //         $data['family_yellowPercentage'] = 0;
    //         $data['family_greyPercentage'] = 0;
    //         $data['family_redPercentage'] = 0;
    //         // prd($data['family_count']);
    //         if($data['family_rating'][0]->green > 0){
    //         $data['family_grrenPercentage'] = ($data['family_rating'][0]->green / $data['family_count'][0]->count) * 100;

    //         }
    //         if($data['family_rating'][0]->yellow > 0){
    //         $data['family_yellowPercentage'] = ($data['family_rating'][0]->yellow / $data['family_count'][0]->count) * 100;

    //         }
    //         if($data['family_rating'][0]->grey > 0){
    //         $data['family_greyPercentage'] = ($data['family_rating'][0]->grey / $data['family_count'][0]->count) * 100;
    //         }
    //         if($data['family_rating'][0]->red > 0){
    //         $data['family_redPercentage'] = ($data['family_rating'][0]->red / $data['family_count'][0]->count) * 100;
    //         }

    //         $query = "SELECT * FROM federation_mst where is_deleted = 0 and ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" uin = '$federation_uin_search'";
    //         }
    //         else{
    //             $query .=" agency_id = $agency";
    //         }

    //         $federation = DB::select($query);

    //         foreach($federation as $res){
    //           $data['federation_assessment'][] = $this->federation_analysis($res->id);

    //         }

    //         // Governance Indicators
    //         $query="SELECT
    //         SUM(CASE WHEN p.adoption_of_rules ='Yes' THEN 1 ELSE 0 END) as adoption_of_rules_yes,
    //         SUM(CASE WHEN p.adoption_of_rules ='No' THEN 1 ELSE 0 END) as adoption_of_rules_no
    //         -- SUM(CASE WHEN p.analysis_rating >= 75 AND p.analysis_rating < 90 THEN 1 ELSE 0 END) as yellow,
    //         -- SUM(CASE WHEN p.analysis_rating >= 60 AND p.analysis_rating < 75 THEN 1 ELSE 0 END) as grey,
    //         -- SUM(CASE WHEN p.analysis_rating < 60 THEN 1 ELSE 0 END) as red
    //         FROM federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_governance as p ON b.federation_mst_id = p.federation_sub_mst_id
    //         WHERE a.is_deleted = 0 AND ";

    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['governance_indicators'] = DB::select($query);
    //         // prd($data['fed_count'][0]->count);

    //         $data['governance_indicators_yes'] = 0 ;
    //         $data['governance_indicators_no'] = 0 ;
    //         if($data['governance_indicators'][0]->adoption_of_rules_yes > 0){
    //             $data['governance_indicators_yes'] = ($data['governance_indicators'][0]->adoption_of_rules_yes / $data['fed_count']) * 100;
    //         }
    //         if($data['governance_indicators'][0]->adoption_of_rules_no > 0){
    //             $data['governance_indicators_no'] = ($data['governance_indicators'][0]->adoption_of_rules_no / $data['fed_count']) * 100;
    //         }

    //         // federation election selection

    //         $data['fed_election_count_3'] = 0;
    //         $data['fed_election_count_4'] = 0;
    //         $data['fed_election_count_0'] = 0;
    //         $data['fed_election_count_1'] = 0;


    //         foreach ($data['federation_assessment'] as $item) {
    //             switch ($item['regular_election']) {
    //                 case 4:
    //                     // green
    //                     $data['fed_election_count_4']++;
    //                     break;
    //                 case 3:
    //                     // yellow
    //                     $data['fed_election_count_3']++;
    //                     break;
    //                 case 1:
    //                     // grey
    //                     $data['fed_election_count_1']++;
    //                     break;
    //                 case 0:
    //                     // red
    //                     $data['fed_election_count_0']++;
    //                     break;

    //             }
    //         }
    //         $data['fed_election_count_4_per'] = 0;
    //         $data['fed_election_count_3_per'] = 0;
    //         $data['fed_election_count_1_per'] = 0;
    //         $data['fed_election_count_0_per'] = 0;
    //         if($data['fed_election_count_4'] > 0){
    //             $data['fed_election_count_4_per'] = ($data['fed_election_count_4'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_election_count_3'] > 0){
    //             $data['fed_election_count_3_per'] = ($data['fed_election_count_3'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_election_count_1'] > 0){
    //             $data['fed_election_count_1_per'] = ($data['fed_election_count_1'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_election_count_0'] > 0){
    //             $data['fed_election_count_0_per'] = ($data['fed_election_count_0'] / $data['fed_count']) * 100;
    //         }

    //         // federation average meetiing

    //         $data['fed_avg_meet_count_5'] = 0;
    //         $data['fed_avg_meet_count_4'] = 0;
    //         $data['fed_avg_meet_count_3'] = 0;
    //         $data['fed_avg_meet_count_1'] = 0;


    //         foreach ($data['federation_assessment'] as $item) {
    //             switch ($item['average_metting']) {
    //                 case 5:
    //                     // green
    //                     $data['fed_avg_meet_count_5']++;
    //                     break;
    //                 case 4:
    //                     // yellow
    //                     $data['fed_avg_meet_count_4']++;
    //                     break;
    //                 case 3:
    //                     // grey
    //                     $data['fed_avg_meet_count_3']++;
    //                     break;
    //                 case 1:
    //                     // red
    //                     $data['fed_avg_meet_count_1']++;
    //                     break;

    //             }
    //         }
    //         $data['fed_avg_meet_count_5_per'] = 0;
    //         $data['fed_avg_meet_count_4_per'] = 0;
    //         $data['fed_avg_meet_count_3_per'] = 0;
    //         $data['fed_avg_meet_count_1_per'] = 0;
    //         if($data['fed_avg_meet_count_5'] > 0){
    //             $data['fed_avg_meet_count_5_per'] = ($data['fed_avg_meet_count_5'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_avg_meet_count_4'] > 0){
    //             $data['fed_avg_meet_count_4_per'] = ($data['fed_avg_meet_count_4'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_avg_meet_count_3'] > 0){
    //             $data['fed_avg_meet_count_3_per'] = ($data['fed_avg_meet_count_3'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_avg_meet_count_1'] > 0){
    //             $data['fed_avg_meet_count_1_per'] = ($data['fed_avg_meet_count_1'] / $data['fed_count']) * 100;
    //         }


    //         // federation book updating

    //         $data['fed_book_count_8'] = 0;
    //         $data['fed_book_count_4'] = 0;
    //         $data['fed_book_count_2'] = 0;
    //         $data['fed_book_count_0'] = 0;


    //         foreach ($data['federation_assessment'] as $item) {
    //             switch ($item['fed_book']) {
    //                 case 8:
    //                     // green
    //                     $data['fed_book_count_8']++;
    //                     break;
    //                 case 4:
    //                     // yellow
    //                     $data['fed_book_count_4']++;
    //                     break;
    //                 case 2:
    //                     // grey
    //                     $data['fed_book_count_2']++;
    //                     break;
    //                 case 0:
    //                     // red
    //                     $data['fed_book_count_0']++;
    //                     break;

    //             }
    //         }
    //         $data['fed_book_count_8_per'] = 0;
    //         $data['fed_book_count_4_per'] = 0;
    //         $data['fed_book_count_2_per'] = 0;
    //         $data['fed_book_count_0_per'] = 0;
    //         if($data['fed_book_count_8'] > 0){
    //             $data['fed_book_count_8_per'] = ($data['fed_book_count_8'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_book_count_4'] > 0){
    //             $data['fed_book_count_4_per'] = ($data['fed_book_count_4'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_book_count_2'] > 0){
    //             $data['fed_book_count_2_per'] = ($data['fed_book_count_2'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_book_count_0'] > 0){
    //             $data['fed_book_count_0_per'] = ($data['fed_book_count_0'] / $data['fed_count']) * 100;
    //         }

    //         // federation last year audit



    //         $query="SELECT
    //         SUM(CASE WHEN p.internal_audit ='Yes' THEN 1 ELSE 0 END) as fed_internal_audit_yes,
    //         SUM(CASE WHEN p.internal_audit ='No' THEN 1 ELSE 0 END) as fed_internal_audit_no,
    //         SUM(CASE WHEN p.external_audit ='No' THEN 1 ELSE 0 END) as fed_external_audit_no,
    //         SUM(CASE WHEN p.external_audit ='Yes' THEN 1 ELSE 0 END) as fed_external_audit_yes
    //         FROM federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_governance as p ON b.federation_mst_id = p.federation_sub_mst_id
    //         WHERE a.is_deleted = 0 AND";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_audits'] = DB::select($query);

    //         $data['fed_internal_audit_yes_per'] = 0;
    //         $data['fed_external_audit_yes_per'] = 0;
    //         $data['fed_internal_audit_no_per'] = 0;
    //         $data['fed_external_audit_no_per'] = 0;

    //         if($data['fed_audits'][0]->fed_internal_audit_yes > 0){
    //             $data['fed_internal_audit_yes_per'] = ( $data['fed_audits'][0]->fed_internal_audit_yes / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_audits'][0]->fed_internal_audit_no > 0){
    //             $data['fed_internal_audit_no_per'] = ( $data['fed_audits'][0]->fed_internal_audit_no / $data['fed_count']) * 100;
    //         }

    //         if($data['fed_audits'][0]->fed_external_audit_yes > 0){
    //             $data['fed_external_audit_yes_per'] = ( $data['fed_audits'][0]->fed_external_audit_yes / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_audits'][0]->fed_external_audit_no > 0){
    //             $data['fed_external_audit_no_per'] = ( $data['fed_audits'][0]->fed_external_audit_no / $data['fed_count']) * 100;
    //         }

    //         // federation traing count
    //         $query="SELECT
    //         SUM(CASE WHEN  p.Book_Keeper_been_trained ='Yes' OR p.federation_committee_members_received = 'Yes'

	// 			 THEN 1 ELSE 0 END) as green,
	// 			 SUM(CASE WHEN  p.Book_Keeper_been_trained ='No' AND p.federation_committee_members_received = 'No'
	// 			 THEN 1 ELSE 0 END) as red
    //              FROM federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_governance as p ON b.federation_mst_id = p.federation_sub_mst_id
    //         WHERE a.is_deleted = 0 AND";

    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }

    //         $data['fed_training'] = DB::select($query);

    //         $data['fed_training_count_5_per'] = 0;
    //         $data['fed_training_count_0_per'] = 0;

    //         if($data['fed_training'][0]->green > 0){
    //             $data['fed_training_count_5_per'] = ($data['fed_training'][0]->green / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_training'][0]->red > 0){
    //             $data['fed_training_count_0_per'] = ($data['fed_training'][0]->red / $data['fed_count']) * 100;
    //         }

    //         // federation pverty mapping
    //         $query="SELECT
    //         SUM(CASE WHEN p.wealth_ranking_mapping ='Yes' THEN 1 ELSE 0 END) as wealth_ranking_mapping_yes,
    //         SUM(CASE WHEN p.wealth_ranking_mapping ='No' THEN 1 ELSE 0 END) as wealth_ranking_mapping_no

    //         FROM federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_inclusion as p ON b.federation_mst_id = p.federation_sub_mst_id
    //         WHERE a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_povert_mapping'] = DB::select($query);
    //         // prd($data['fed_count'][0]->count);

    //         $data['fed_povert_mapping_yes_per'] = 0 ;
    //         $data['fed_povert_mapping_no_per'] = 0 ;
    //         if($data['fed_povert_mapping'][0]->wealth_ranking_mapping_yes > 0){
    //             $data['fed_povert_mapping_yes_per'] = ($data['fed_povert_mapping'][0]->wealth_ranking_mapping_yes / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_povert_mapping'][0]->wealth_ranking_mapping_no > 0){
    //             $data['fed_povert_mapping_no_per'] = ($data['fed_povert_mapping'][0]->wealth_ranking_mapping_no / $data['fed_count']) * 100;
    //         }

    //         // federation Poorest in Leadership Position

    //         $data['fed_leadership_count_5'] = 0;
    //         $data['fed_leadership_count_4'] = 0;
    //         $data['fed_leadership_count_3'] = 0;
    //         $data['fed_leadership_count_1'] = 0;


    //         foreach ($data['federation_assessment'] as $item) {
    //             switch ($item['fed_leadership']) {
    //                 case 5:
    //                     // green
    //                     $data['fed_leadership_count_5']++;
    //                     break;
    //                 case 4:
    //                     // yellow
    //                     $data['fed_leadership_count_4']++;
    //                     break;
    //                 case 3:
    //                     // grey
    //                     $data['fed_leadership_count_3']++;
    //                     break;
    //                 case 1:
    //                     // red
    //                     $data['fed_leadership_count_1']++;
    //                     break;

    //             }
    //         }
    //         $data['fed_leadership_count_5_per'] = 0;
    //         $data['fed_leadership_count_4_per'] = 0;
    //         $data['fed_leadership_count_3_per'] = 0;
    //         $data['fed_leadership_count_1_per'] = 0;
    //         if($data['fed_leadership_count_5'] > 0){
    //             $data['fed_leadership_count_5_per'] = ($data['fed_leadership_count_5'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_leadership_count_4'] > 0){
    //             $data['fed_leadership_count_4_per'] = ($data['fed_leadership_count_4'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_leadership_count_3'] > 0){
    //             $data['fed_leadership_count_3_per'] = ($data['fed_leadership_count_3'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_leadership_count_1'] > 0){
    //             $data['fed_leadership_count_1_per'] = ($data['fed_leadership_count_1'] / $data['fed_count']) * 100;
    //         }


    //         // federation Poorest benefitting from all federation and external loans

    //         $data['fed_external_loan_count_5'] = 0;
    //         $data['fed_external_loan_count_4'] = 0;
    //         $data['fed_external_loan_count_3'] = 0;
    //         $data['fed_external_loan_count_0'] = 0;


    //         foreach ($data['federation_assessment'] as $item) {
    //             switch ($item['fed_external_loan']) {
    //                 case 5:
    //                     // green
    //                     $data['fed_external_loan_count_5']++;
    //                     break;
    //                 case 4:
    //                     // yellow
    //                     $data['fed_external_loan_count_4']++;
    //                     break;
    //                 case 3:
    //                     // grey
    //                     $data['fed_external_loan_count_3']++;
    //                     break;
    //                 case 0:
    //                     // red
    //                     $data['fed_external_loan_count_0']++;
    //                     break;

    //             }
    //         }
    //         $data['fed_external_loan_count_5_per'] = 0;
    //         $data['fed_external_loan_count_4_per'] = 0;
    //         $data['fed_external_loan_count_3_per'] = 0;
    //         $data['fed_external_loan_count_0_per'] = 0;
    //         if($data['fed_external_loan_count_5'] > 0){
    //             $data['fed_external_loan_count_5_per'] = ($data['fed_external_loan_count_5'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_external_loan_count_4'] > 0){
    //             $data['fed_external_loan_count_4_per'] = ($data['fed_external_loan_count_4'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_external_loan_count_3'] > 0){
    //             $data['fed_external_loan_count_3_per'] = ($data['fed_external_loan_count_3'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_external_loan_count_0'] > 0){
    //             $data['fed_external_loan_count_0_per'] = ($data['fed_external_loan_count_0'] / $data['fed_count']) * 100;
    //         }

    //          // federation Poorest benefitting from federation and loans

    //          if(!empty($federation_uin_search)){
    //             $query="SELECT SUM(a.fed_poor_poorest_loan) /SUM(a.total_fed_loans)  AS fed_loans_average ,
    //             (SUM(a.fed_poor_poorest_loan) / SUM(a.total_fed_loans) )* 100 AS fed_loans_percentage
    //             FROM (
    //                 SELECT
    //                     p.federation_poorest_category_recloan + p.federation_poor_category_recloan as fed_poor_poorest_loan,
    //                     p.federation_poorest_category_recloan + p.federation_poor_category_recloan + p.federation_medium_recloan + p.federation_rich_recloan as total_fed_loans,
    //                     a.id
    //                 FROM federation_mst as a
    //                 INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //                 INNER JOIN federation_inclusion as p ON b.federation_mst_id = p.federation_sub_mst_id
    //                 WHERE a.is_deleted = 0 AND a.uin = '$federation_uin_search'
    //             ) AS a";
    //          }else{
    //             $query="SELECT SUM(a.fed_poor_poorest_loan) /SUM(a.total_fed_loans)  AS fed_loans_average ,
    //             (SUM(a.fed_poor_poorest_loan) / SUM(a.total_fed_loans) )* 100 AS fed_loans_percentage
    //             FROM (
    //                 SELECT
    //                     p.federation_poorest_category_recloan + p.federation_poor_category_recloan as fed_poor_poorest_loan,
    //                     p.federation_poorest_category_recloan + p.federation_poor_category_recloan + p.federation_medium_recloan + p.federation_rich_recloan as total_fed_loans,
    //                     a.id
    //                 FROM federation_mst as a
    //                 INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //                 INNER JOIN federation_inclusion as p ON b.federation_mst_id = p.federation_sub_mst_id
    //                 WHERE a.is_deleted = 0 AND a.agency_id = $agency
    //             ) AS a";
    //          }

    //          $data['fed_poor_poorest_loans'] = DB::select($query);
    //         //  prd($query);




    //         // federation Time taken to approve loan

    //         $data['fed_taken_loan_count_5'] = 0;
    //         $data['fed_taken_loan_count_4'] = 0;
    //         $data['fed_taken_loan_count_3'] = 0;
    //         $data['fed_taken_loan_count_1'] = 0;


    //         foreach ($data['federation_assessment'] as $item) {
    //             switch ($item['fed_taken_loan']) {
    //                 case 5:
    //                     // green
    //                     $data['fed_taken_loan_count_5']++;
    //                     break;
    //                 case 4:
    //                     // yellow
    //                     $data['fed_taken_loan_count_4']++;
    //                     break;
    //                 case 3:
    //                     // grey
    //                     $data['fed_taken_loan_count_3']++;
    //                     break;
    //                 case 1:
    //                     // red
    //                     $data['fed_taken_loan_count_1']++;
    //                     break;

    //             }
    //         }
    //         $data['fed_taken_loan_count_5_per'] = 0;
    //         $data['fed_taken_loan_count_4_per'] = 0;
    //         $data['fed_taken_loan_count_3_per'] = 0;
    //         $data['fed_taken_loan_count_1_per'] = 0;
    //         if($data['fed_taken_loan_count_5'] > 0){
    //             $data['fed_taken_loan_count_5_per'] = ($data['fed_taken_loan_count_5'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_taken_loan_count_4'] > 0){
    //             $data['fed_taken_loan_count_4_per'] = ($data['fed_taken_loan_count_4'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_taken_loan_count_3'] > 0){
    //             $data['fed_taken_loan_count_3_per'] = ($data['fed_taken_loan_count_3'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_taken_loan_count_1'] > 0){
    //             $data['fed_taken_loan_count_1_per'] = ($data['fed_taken_loan_count_1'] / $data['fed_count']) * 100;
    //         }


    //         // federation Cost Income Ratio

    //         $data['fed_cost_income_ratio_count_5'] = 0;
    //         $data['fed_cost_income_ratio_count_4'] = 0;
    //         $data['fed_cost_income_ratio_count_3'] = 0;
    //         $data['fed_cost_income_ratio_count_1'] = 0;


    //         foreach ($data['federation_assessment'] as $item) {
    //             switch ($item['fed_cost_income_ratio']) {
    //                 case 5:
    //                     // green
    //                     $data['fed_cost_income_ratio_count_5']++;
    //                     break;
    //                 case 4:
    //                     // yellow
    //                     $data['fed_cost_income_ratio_count_4']++;
    //                     break;
    //                 case 3:
    //                     // grey
    //                     $data['fed_cost_income_ratio_count_3']++;
    //                     break;
    //                 case 1:
    //                     // red
    //                     $data['fed_cost_income_ratio_count_1']++;
    //                     break;

    //             }
    //         }
    //         $data['fed_cost_income_ratio_count_5_per'] = 0;
    //         $data['fed_cost_income_ratio_count_4_per'] = 0;
    //         $data['fed_cost_income_ratio_count_3_per'] = 0;
    //         $data['fed_cost_income_ratio_count_1_per'] = 0;
    //         if($data['fed_cost_income_ratio_count_5'] > 0){
    //             $data['fed_cost_income_ratio_count_5_per'] = ($data['fed_cost_income_ratio_count_5'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_cost_income_ratio_count_4'] > 0){
    //             $data['fed_cost_income_ratio_count_4_per'] = ($data['fed_cost_income_ratio_count_4'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_cost_income_ratio_count_3'] > 0){
    //             $data['fed_cost_income_ratio_count_3_per'] = ($data['fed_cost_income_ratio_count_3'] / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_cost_income_ratio_count_1'] > 0){
    //             $data['fed_cost_income_ratio_count_1_per'] = ($data['fed_cost_income_ratio_count_1'] / $data['fed_count']) * 100;
    //         }

    //         // fed active borrowers last 3 years
    //         $query="SELECT
    //         a.id,
    //         AVG(p.active_borrower_year1+p.active_borrower_year2+p.active_borrower_year3) AS fed_borrowers_last_3,
    //         AVG(p.active_borrower_year1+p.active_borrower_year2+p.active_borrower_year3) / sum(r.total_general_assembly_members) * 100 AS fed_borrowers_last_3_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_efficiency as p ON b.federation_mst_id = p.federation_sub_mst_id
    //         INNER JOIN federation_risk_mitigation as r ON b.federation_mst_id = r.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_active_borrowers_last_3_year'] =DB::select($query);


    //     //  fed  No of days from loan approval to cash in hand

    //     $query="SELECT
    //     SUM(CASE WHEN p.time_taken_to_give_money_from_approval >0 AND  p.time_taken_to_give_money_from_approval<=2 THEN 1 ELSE 0 END) as green,
    //     SUM(CASE WHEN p.time_taken_to_give_money_from_approval >2 AND  p.time_taken_to_give_money_from_approval<=3 THEN 1 ELSE 0 END) as yellow,
    //     SUM(CASE WHEN p.time_taken_to_give_money_from_approval >3 AND  p.time_taken_to_give_money_from_approval<=5 THEN 1 ELSE 0 END) as grey,
    //     SUM(CASE WHEN p.time_taken_to_give_money_from_approval >5 THEN 1 ELSE 0 END) as red

    //     FROM federation_mst as a
    //     INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //     INNER JOIN federation_efficiency as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE a.is_deleted = 0 AND ";
    //     if(!empty($federation_uin_search)){
    //         $query .=" a.uin = '$federation_uin_search'";
    //         }
    //         else{
    //             $query .=" a.agency_id = $agency";
    //         }
    //     $data['fed_cash_in_hand'] = DB::select($query);
    //         // prd($data['fed_cash_in_hand']);

    //         $data['fed_cash_in_hand_green_per'] = 0;
    //         $data['fed_cash_in_hand_yellow_per'] = 0;
    //         $data['fed_cash_in_hand_grey_per'] = 0;
    //         $data['fed_cash_in_hand_red_per'] = 0;
    //         if($data['fed_cash_in_hand'][0]->green > 0){
    //             $data['fed_cash_in_hand_green_per'] = ($data['fed_cash_in_hand'][0]->green / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_cash_in_hand'][0]->yellow > 0){
    //             $data['fed_cash_in_hand_yellow_per'] = ($data['fed_cash_in_hand'][0]->yellow / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_cash_in_hand'][0]->grey > 0){
    //             $data['fed_cash_in_hand_grey_per'] = ($data['fed_cash_in_hand'][0]->grey / $data['fed_count']) * 100;
    //         }
    //         if($data['fed_cash_in_hand'][0]->red > 0){
    //             $data['fed_cash_in_hand_red_per'] = ($data['fed_cash_in_hand'][0]->red / $data['fed_count']) * 100;
    //         }
    //         // internal loan amont during last 3 year

    //         $query ="SELECT
    //         a.id,
    //         SUM(p.cumulative_amount_federation_loan) AS all_federation_loan,
    //         SUM(p.cumulative_amount) AS total_cumulative_amount
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_credithistory as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $fed_loans_amounts = DB::select($query);

    //         $data['fed_loan_avg'] = $fed_loans_amounts[0]->all_federation_loan /$data['fed_count'];
    //         $data['fed_loan_per'] = ($fed_loans_amounts[0]->all_federation_loan / $fed_loans_amounts[0]->total_cumulative_amount )*100;
    //         // pr($fed_loans_amounts);
    //         // external loan amount last 3 year

    //         $query ="SELECT
    //         a.id,
    //         SUM(p.cumulative_amount_bank_loan + p.cumulative_amount_vi_loan + p.cumulative_amount_other_loan) AS all_external_loan,
    //         SUM(p.cumulative_amount) AS total_cumulative_amount
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_credithistory as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $external_loans_amounts = DB::select($query);

    //         // prd($external_loans_amounts);

    //         $data['external_loan_avg'] = $external_loans_amounts[0]->all_external_loan /$data['fed_count'];
    //         $data['external_loan_per'] = ($external_loans_amounts[0]->all_external_loan / $external_loans_amounts[0]->total_cumulative_amount )*100;

    //         $query="SELECT
    //         AVG(p.no_of_loans_approved_within_15_days) AS fed_loan_approve_avg,
    //         AVG(p.no_of_loans_approved_within_15_days) / SUM(p.no_of_loans_approved_within_15_days) * 100 AS fed_loan_approve_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_credithistory as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_loan_approve'] = DB::select($query);

    //         // fed repayment ratio
    //         $query="SELECT
    //         AVG(p.repayment_rate_federation_loans) AS fed_loan_internal_repay_avg,
    //         AVG(p.repayment_rate_federation_loans) / SUM(p.repayment_rate_federation_loans) * 100 AS fed_loan_internal_repay_per,
    //         AVG(p.repayment_rate_bank_loans+p.repayment_rate_vi_loans+p.repayment_rate_other_loans) AS fed_loan_external_repay_avg,
    //         AVG(p.repayment_rate_bank_loans+p.repayment_rate_vi_loans+p.repayment_rate_other_loans)/ SUM(p.repayment_rate_bank_loans+p.repayment_rate_vi_loans+p.repayment_rate_other_loans) * 100 AS
    //          fed_loan_external_repay_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_credithistory as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_repayment_ratio']= DB::select($query);

    //         // fed_loan_default
    //         $query="SELECT
    //         AVG(p.default_federation_no_of_loans+p.default_bank_no_of_loans+p.default_vi_no_of_loans+p.default_other_no_of_loans) AS fed_loan_default_avg,
    //         AVG(p.default_federation_no_of_loans+p.default_bank_no_of_loans+p.default_vi_no_of_loans+p.default_other_no_of_loans)/
    //          SUM(p.default_federation_no_of_loans+p.default_bank_no_of_loans+p.default_vi_no_of_loans+p.default_other_no_of_loans) * 100 AS
    //          fed_loan_default_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_credithistory as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_loan_default']=DB::select($query);

    //         // fed loan par 30 to 90 days

    //         $query="SELECT
    //         AVG(p.overdue_More_than_1_months_Federation+p.overdue_More_than_1_months_Bank+p.overdue_More_than_1_months_VI+p.overdue_More_than_1_months_other)
    //          AS fed_loan_par_30_avg,
    //         AVG(p.overdue_More_than_1_months_Federation+p.overdue_More_than_1_months_Bank+p.overdue_More_than_1_months_VI+p.overdue_More_than_1_months_other)/
    //          SUM(p.overdue_More_than_1_months_Federation+p.overdue_More_than_1_months_Bank+p.overdue_More_than_1_months_VI+p.overdue_More_than_1_months_other) * 100 AS
    //          fed_loan_par_30_per,
    //          AVG(p.overdue_More_than_2_months_Federation+p.overdue_More_than_2_months_Bank+p.overdue_More_than_2_months_VI+p.overdue_More_than_2_months_other)
    //          AS fed_loan_par_60_avg,
    //         AVG(p.overdue_More_than_2_months_Federation+p.overdue_More_than_2_months_Bank+p.overdue_More_than_2_months_VI+p.overdue_More_than_2_months_other)/
    //          SUM(p.overdue_More_than_2_months_Federation+p.overdue_More_than_2_months_Bank+p.overdue_More_than_2_months_VI+p.overdue_More_than_2_months_other) * 100 AS
    //          fed_loan_par_60_per,
    //          AVG(p.overdue_More_than_3_months_Federation+p.overdue_More_than_3_months_Bank+p.overdue_More_than_3_months_VI+p.overdue_More_than_3_months_other)
    //          AS fed_loan_par_90_avg,
    //         AVG(p.overdue_More_than_3_months_Federation+p.overdue_More_than_3_months_Bank+p.overdue_More_than_3_months_VI+p.overdue_More_than_3_months_other)/
    //          SUM(p.overdue_More_than_3_months_Federation+p.overdue_More_than_3_months_Bank+p.overdue_More_than_3_months_VI+p.overdue_More_than_3_months_other) * 100 AS
    //          fed_loan_par_90_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_credithistory as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //     $data['fed_loan_par'] = DB::select($query);


    //     // fed loan tracking

    //     $query ="SELECT
    //     SUM(CASE WHEN p.does_Federation_loan_tracking_system = 'Yes' THEN 1 ELSE 0 END) AS fed_loan_track,
    //     SUM(CASE WHEN p.does_Federation_loan_tracking_system = 'Yes' THEN 1 ELSE 0 END) / COUNT(a.id) * 100 AS fed_loan_track_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_credithistory as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_loan_track'] = DB::select($query);
    //         // prd($query);
    //         // fed productive
    //         $query ="SELECT
    //         AVG(p.productive)  AS fed_productive_avg,
    //         SUM(p.productive)/SUM(p.productive+p.consumption+p.debt_swapping+p.education+p.health+p.Other)*100 AS fed_productive_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_credithistory as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_productive'] = DB::select($query);

    //         // fed no of taking loan last 3 year

    //         $query="SELECT
    //         AVG(p.members_have_taken_more_than_one_loan)  AS fed_loan_taking_member,
    //         SUM(p.members_have_taken_more_than_one_loan)/SUM(
    //         e.federation_poorest_category_hhs
    //         +e.federation_poor_category_hhs
    //         +e.federation_medium_hhs
    //         +e.federation_rich_hhs)*100 AS fed_loan_taking_member_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_credithistory as p ON b.federation_mst_id = p.federation_sub_mst_id
    //         INNER JOIN federation_inclusion as e ON b.federation_mst_id = e.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }

    //         $data['fed_loan_taking'] = DB::select($query);


    //         // fed covering cost

    //         $query="SELECT
    //         SUM(CASE WHEN p.federation_covering_operational_cost = 'Yes' THEN 1 ELSE 0 END) AS fed_covering_cost,
    //         SUM(CASE WHEN p.federation_covering_operational_cost = 'Yes' THEN 1 ELSE 0 END) / COUNT(a.id) * 100 AS fed_covering_cost_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_sustainability as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_covering_cost']= DB::select($query);
    //         // prd($data['fed_covering_cost']);

    //         // fed loan secirity fund

    //         $query="SELECT
    //         SUM(CASE WHEN p.have_loan_security_fund = 'Yes' THEN 1 ELSE 0 END) AS fed_loan_security,
    //         SUM(CASE WHEN p.have_loan_security_fund = 'Yes' THEN 1 ELSE 0 END) / COUNT(a.id) * 100 AS fed_loan_security_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_sustainability as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_loan_security']= DB::select($query);

    //         // fed life insurance coverd

    //         $query="SELECT
    //         a.id,
    //         AVG(p.members_covered_under_life_insurance) AS fed_members_coverd,
    //         SUM(p.members_covered_under_life_insurance) / sum(p.total_general_assembly_members) * 100 AS fed_members_coverd_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_risk_mitigation as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_life_ins_coverd']=DB::select($query);

    //         // fed life insurance coverd borrower
    //         $query="SELECT
    //         a.id,
    //         AVG(p.par_availed_members_covered_under_loan_insurance) AS fed_members_life_coverd,
    //         AVG(p.par_availed_members_covered_under_loan_insurance) / sum(p.availed_members_covered_under_loan_insurance) * 100 AS fed_members_life_coverd_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_risk_mitigation as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_life_ins_coverd_borrower'] = DB::select($query);

    //         // fed assets coverd
    //         $query="SELECT
    //         a.id,
    //         AVG(p.animal_purchased_during_last_one_year) AS fed_assest_coverd,
    //         AVG(p.animal_purchased_during_last_one_year) / sum(p.animal_insured_last_one_year) * 100 AS fed_assest_coverd_per
    //     FROM
    //         federation_mst as a
    //         INNER JOIN federation_sub_mst as b ON a.id = b.federation_mst_id
    //         INNER JOIN federation_risk_mitigation as p ON b.federation_mst_id = p.federation_sub_mst_id
    //     WHERE
    //         a.is_deleted = 0 AND ";
    //         if(!empty($federation_uin_search)){
    //             $query .=" a.uin = '$federation_uin_search'";
    //             }
    //             else{
    //                 $query .=" a.agency_id = $agency";
    //             }
    //         $data['fed_assets_coverd'] = DB::select($query);


    //         // SHG assessment start

    //         $query = "SELECT id  from shg_mst where is_deleted = 0 and cluster_uin in($cluster_uin)";
    //         $shg_id = DB::select($query);

    //         foreach($shg_id as $res){
    //             $data['shg_assessment'][] = $this->shg_analysis($res->id);

    //           }

    //         // shg Governance Indicators
    //         $query="SELECT
    //         SUM(CASE WHEN p.adoption_rules ='Yes' THEN 1 ELSE 0 END) as adoption_of_rules,
    //         SUM(CASE WHEN p.adoption_rules ='No' THEN 1 ELSE 0 END) as adoption_of_rules_no,
    //         sum(CASE WHEN p.adoption_rules ='Yes' THEN 1 ELSE 0 END)/count(a.id) * 100 as adoption_of_rules_per,
    //         sum(CASE WHEN p.adoption_rules ='No' THEN 1 ELSE 0 END)/count(a.id) * 100 as adoption_of_rules_no_per
    //         FROM shg_mst as a
    //         INNER JOIN shg_sub_mst as b ON a.id = b.shg_mst_id
    //         INNER JOIN shg_governance as p ON b.shg_mst_id = p.shg_sub_mst_id
    //         WHERE a.is_deleted = 0 AND a.cluster_uin in ($cluster_uin)";
    //         $data['shg_adoption_of_rules'] = DB::select($query);

    //         // shg updating books

    //         $ana['green'] = 0;
    //         $ana['yellow'] = 0;
    //         $ana['grey'] = 0;
    //         $ana['red'] = 0;


    //         foreach ($data['shg_assessment'] as $item) {
    //             switch ($item['analysis_data']['Average_participation_of']) {
    //                 case 10:
    //                     // green
    //                     $ana['green']++;
    //                     break;
    //                 case 8:
    //                     // yellow
    //                     $ana['yellow']++;
    //                     break;
    //                 case 6:
    //                     // grey
    //                     $ana['grey']++;
    //                     break;
    //                 case 2:
    //                     // red
    //                     $ana['red']++;
    //                     break;

    //             }
    //         }
    //         $ana['green_per'] = 0;
    //         $ana['yellow_per'] = 0;
    //         $ana['grey_per'] = 0;
    //         $ana['red_per'] = 0;
    //         if($ana['green'] > 0){
    //             $ana['green_per'] = round($ana['green'] / $data['shg_count'] * 100,2);
    //         }
    //         if($ana['yellow'] > 0){
    //             $ana['yellow_per'] = round($ana['yellow'] / $data['shg_count'] * 100,2);
    //         }
    //         if($ana['grey'] > 0){
    //             $ana['grey_per'] = round($ana['grey'] / $data['shg_count'] * 100,2);
    //         }
    //         if($ana['red'] > 0){
    //             $ana['red_per'] = round($ana['red'] / $data['shg_count'] * 100,2);
    //         }
    //         // prd($ana);




    //         // shg updating books

    //         $data['shg_book_updating_10'] = 0;
    //         $data['shg_book_updating_7'] = 0;
    //         $data['shg_book_updating_5'] = 0;
    //         $data['shg_book_updating_0'] = 0;


    //         foreach ($data['shg_assessment'] as $item) {
    //             switch ($item['analysis_data']['shg_book_updation']) {
    //                 case 10:
    //                     // green
    //                     $data['shg_book_updating_10']++;
    //                     break;
    //                 case 7:
    //                     // yellow
    //                     $data['shg_book_updating_7']++;
    //                     break;
    //                 case 5:
    //                     // grey
    //                     $data['shg_book_updating_5']++;
    //                     break;
    //                 case 0:
    //                     // red
    //                     $data['shg_book_updating_0']++;
    //                     break;

    //             }
    //         }
    //         $data['shg_book_updating_10_per'] = 0;
    //         $data['shg_book_updating_7_per'] = 0;
    //         $data['shg_book_updating_5_per'] = 0;
    //         $data['shg_book_updating_0_per'] = 0;
    //         if($data['shg_book_updating_10'] > 0){
    //             $data['shg_book_updating_10_per'] = ($data['shg_book_updating_10'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_book_updating_7'] > 0){
    //             $data['shg_book_updating_7_per'] = ($data['shg_book_updating_7'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_book_updating_5'] > 0){
    //             $data['shg_book_updating_5_per'] = ($data['shg_book_updating_5'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_book_updating_0'] > 0){
    //             $data['shg_book_updating_0_per'] = ($data['shg_book_updating_0'] / $data['shg_count']) * 100;
    //         }

    //         // shg internal or external audit yes/no


    //         $query="SELECT
    //         SUM(CASE WHEN p.internal_audit ='Yes' THEN 1 ELSE 0 END) as internal_audit,
    //         sum(CASE WHEN p.internal_audit ='Yes' THEN 1 ELSE 0 END)/count(a.id) * 100 as internal_audit_per,
    //         SUM(CASE WHEN p.internal_audit ='No' THEN 1 ELSE 0 END) as internal_audit_no,
    //         sum(CASE WHEN p.internal_audit ='No' THEN 1 ELSE 0 END)/count(a.id) * 100 as internal_audit_no_per,
    //         SUM(CASE WHEN p.external_audit ='Yes' THEN 1 ELSE 0 END) as external_audit,
    //         sum(CASE WHEN p.external_audit ='Yes' THEN 1 ELSE 0 END)/count(a.id) * 100 as external_audit_per,
    //         SUM(CASE WHEN p.external_audit ='No' THEN 1 ELSE 0 END) as external_audit_no,
    //         sum(CASE WHEN p.external_audit ='No' THEN 1 ELSE 0 END)/count(a.id) * 100 as external_audit_no_per
    //         FROM shg_mst as a
    //         INNER JOIN shg_sub_mst as b ON a.id = b.shg_mst_id
    //         INNER JOIN shg_governance as p ON b.shg_mst_id = p.shg_sub_mst_id
    //         WHERE a.is_deleted = 0 AND a.cluster_uin in ($cluster_uin)";
    //         $data['shg_audits'] = DB::select($query);

    //         // shg election Indicators
    //         $query="SELECT
    //         COUNT(CASE WHEN a.yes = 1 THEN 1 END) as count_yes,
    //         COUNT(CASE WHEN a.yes = 0 THEN 1 END) as count_no,
    //         COUNT(CASE WHEN a.yes = 1 THEN 1 END)/COUNT(a.yes) * 100 AS count_yes_per,
    //         COUNT(CASE WHEN a.yes = 0 THEN 1 END)/COUNT(a.yes) * 100 AS count_no_per
    //     FROM
    //         (SELECT
    //             CASE
    //                 WHEN STR_TO_DATE(p.last_election_date, '%d/%b/%Y') >= DATE(CONCAT(YEAR(CURDATE()) - 3, '-01-01')) THEN 1
    //                 ELSE 0
    //             END AS yes
    //         FROM
    //             shg_mst as a
    //             INNER JOIN shg_sub_mst as b ON a.id = b.shg_mst_id
    //             INNER JOIN shg_governance as p ON b.shg_mst_id = p.shg_sub_mst_id
    //         WHERE
    //             a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)) a";
    //         $data['shg_election'] = DB::select($query);

    //         // shg meeting attendance



    //         $data['shg_meeting_attendance_10'] = 0;
    //         $data['shg_meeting_attendance_8'] = 0;
    //         $data['shg_meeting_attendance_6'] = 0;
    //         $data['shg_meeting_attendance_2'] = 0;


    //         foreach ($data['shg_assessment'] as $item) {
    //             switch ($item['analysis_data']['Average_participation_of']) {
    //                 case 10:
    //                     // green
    //                     $data['shg_meeting_attendance_10']++;
    //                     break;
    //                 case 8:
    //                     // yellow
    //                     $data['shg_meeting_attendance_8']++;
    //                     break;
    //                 case 6:
    //                     // grey
    //                     $data['shg_meeting_attendance_6']++;
    //                     break;
    //                 case 2:
    //                     // red
    //                     $data['shg_meeting_attendance_2']++;
    //                     break;

    //             }
    //         }
    //         $data['shg_meeting_attendance_10_per'] = 0;
    //         $data['shg_meeting_attendance_8_per'] = 0;
    //         $data['shg_meeting_attendance_6_per'] = 0;
    //         $data['shg_meeting_attendance_2_per'] = 0;
    //         if($data['shg_meeting_attendance_10'] > 0){
    //             $data['shg_meeting_attendance_10_per'] = ($data['shg_meeting_attendance_10'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_meeting_attendance_8'] > 0){
    //             $data['shg_meeting_attendance_8_per'] = ($data['shg_meeting_attendance_8'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_meeting_attendance_6'] > 0){
    //             $data['shg_meeting_attendance_6_per'] = ($data['shg_meeting_attendance_6'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_meeting_attendance_2'] > 0){
    //             $data['shg_meeting_attendance_2_per'] = ($data['shg_meeting_attendance_2'] / $data['shg_count']) * 100;
    //         }


    //         // shg election Indicators
    //         $query="SELECT
    //         AVG(p.no_of_meeting_conducted) AS no_of_meeting_conducte,
    //         AVG(p.no_of_meeting_conducted)/SUM(p.no_of_meeting_conducted) * 100 AS no_of_meeting_conducte_per
    //         FROM
    //             shg_mst as a
    //             INNER JOIN shg_sub_mst as b ON a.id = b.shg_mst_id
    //             INNER JOIN shg_governance as p ON b.shg_mst_id = p.shg_sub_mst_id
    //         WHERE
    //             a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";
    //         $data['regularity_meeting'] = DB::select($query);

    //         // shg povert mapping

    //         $query="SELECT
    //         SUM(CASE WHEN p.wealth_ranking ='Yes' THEN 1 ELSE 0 END) as shg_wealth_ranking_yes,
    //         SUM(CASE WHEN p.wealth_ranking ='No' THEN 1 ELSE 0 END) as shg_wealth_ranking_no,
    //         SUM(CASE WHEN p.wealth_ranking ='Yes' THEN 1 ELSE 0 END)/count(a.id)*100 as shg_wealth_ranking_yes_per,
    //         SUM(CASE WHEN p.wealth_ranking ='No' THEN 1 ELSE 0 END)/count(a.id)*100 as shg_wealth_ranking_no_per
    //         FROM shg_mst as a
    //         INNER JOIN shg_sub_mst as b ON a.id = b.shg_mst_id
    //         INNER JOIN shg_inclusion as p ON b.shg_mst_id = p.shg_sub_mst_id
    //         WHERE a.is_deleted = 0  AND  a.cluster_uin IN ($cluster_uin)";

    //         $data['shg_povert_mapping'] = DB::select($query);


    //         // shg Number of poor/vulnerable and poor families in leadership position

    //         $data['shg_no_of_leadership_poor_5'] = 0;
    //         $data['shg_no_of_leadership_poor_4'] = 0;
    //         $data['shg_no_of_leadership_poor_2'] = 0;
    //         $data['shg_no_of_leadership_poor_0'] = 0;


    //         foreach ($data['shg_assessment'] as $item) {
    //             switch ($item['analysis_data']['no_of_leadership_poor']) {
    //                 case 5:
    //                     // green
    //                     $data['shg_no_of_leadership_poor_5']++;
    //                     break;
    //                 case 4:
    //                     // yellow
    //                     $data['shg_no_of_leadership_poor_4']++;
    //                     break;
    //                 case 2:
    //                     // grey
    //                     $data['shg_no_of_leadership_poor_2']++;
    //                     break;
    //                 case 0:
    //                     // red
    //                     $data['shg_no_of_leadership_poor_0']++;
    //                     break;

    //             }
    //         }
    //         $data['shg_no_of_leadership_poor_5_per'] = 0;
    //         $data['shg_no_of_leadership_poor_4_per'] = 0;
    //         $data['shg_no_of_leadership_poor_2_per'] = 0;
    //         $data['shg_no_of_leadership_poor_0_per'] = 0;
    //         if($data['shg_no_of_leadership_poor_5'] > 0){
    //             $data['shg_no_of_leadership_poor_5_per'] = ($data['shg_no_of_leadership_poor_5'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_no_of_leadership_poor_4'] > 0){
    //             $data['shg_no_of_leadership_poor_4_per'] = ($data['shg_no_of_leadership_poor_4'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_no_of_leadership_poor_2'] > 0){
    //             $data['shg_no_of_leadership_poor_2_per'] = ($data['shg_no_of_leadership_poor_2'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_no_of_leadership_poor_0'] > 0){
    //             $data['shg_no_of_leadership_poor_0_per'] = ($data['shg_no_of_leadership_poor_0'] / $data['shg_count']) * 100;
    //         }

    //         // shg Poorest/poor benefitting from External loans
    //         $data['shg_external_loan_4'] = 0;
    //         $data['shg_external_loan_3'] = 0;
    //         $data['shg_external_loan_2'] = 0;
    //         $data['shg_external_loan_1'] = 0;


    //         foreach ($data['shg_assessment'] as $item) {
    //             switch ($item['analysis_data']['shg_percent_of_poorest_other']) {
    //                 case 4:
    //                     // green
    //                     $data['shg_external_loan_4']++;
    //                     break;
    //                 case 3:
    //                     // yellow
    //                     $data['shg_external_loan_3']++;
    //                     break;
    //                 case 2:
    //                     // grey
    //                     $data['shg_external_loan_2']++;
    //                     break;
    //                 case 1:
    //                     // red
    //                     $data['shg_external_loan_1']++;
    //                     break;

    //             }
    //         }
    //         $data['shg_external_loan_4_per'] = 0;
    //         $data['shg_external_loan_3_per'] = 0;
    //         $data['shg_external_loan_2_per'] = 0;
    //         $data['shg_external_loan_1_per'] = 0;
    //         if($data['shg_external_loan_4'] > 0){
    //             $data['shg_external_loan_4_per'] = ($data['shg_external_loan_4'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_external_loan_3'] > 0){
    //             $data['shg_external_loan_3_per'] = ($data['shg_external_loan_3'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_external_loan_2'] > 0){
    //             $data['shg_external_loan_2_per'] = ($data['shg_external_loan_2'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_external_loan_1'] > 0){
    //             $data['shg_external_loan_1_per'] = ($data['shg_external_loan_1'] / $data['shg_count']) * 100;
    //         }

    //         // shg Poorest/poor benefitting from Internal loans
    //         $data['shg_internal_loan_4'] = 0;
    //         $data['shg_internal_loan_3'] = 0;
    //         $data['shg_internal_loan_2'] = 0;
    //         $data['shg_internal_loan_1'] = 0;


    //         foreach ($data['shg_assessment'] as $item) {
    //             switch ($item['analysis_data']['shg_percent_of_poorest_internal']) {
    //                 case 4:
    //                     // green
    //                     $data['shg_internal_loan_4']++;
    //                     break;
    //                 case 3:
    //                     // yellow
    //                     $data['shg_internal_loan_3']++;
    //                     break;
    //                 case 2:
    //                     // grey
    //                     $data['shg_internal_loan_2']++;
    //                     break;
    //                 case 1:
    //                     // red
    //                     $data['shg_internal_loan_1']++;
    //                     break;

    //             }
    //         }
    //         $data['shg_internal_loan_4_per'] = 0;
    //         $data['shg_internal_loan_3_per'] = 0;
    //         $data['shg_internal_loan_2_per'] = 0;
    //         $data['shg_internal_loan_1_per'] = 0;
    //         if($data['shg_internal_loan_4'] > 0){
    //             $data['shg_internal_loan_4_per'] = ($data['shg_internal_loan_4'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_internal_loan_3'] > 0){
    //             $data['shg_internal_loan_3_per'] = ($data['shg_internal_loan_3'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_internal_loan_2'] > 0){
    //             $data['shg_internal_loan_2_per'] = ($data['shg_internal_loan_2'] / $data['shg_count']) * 100;
    //         }
    //         if($data['shg_internal_loan_1'] > 0){
    //             $data['shg_internal_loan_1_per'] = ($data['shg_internal_loan_1'] / $data['shg_count']) * 100;
    //         }

    //         // shg time taken to aprrove loan

    //         $query="SELECT
    //     SUM(CASE WHEN p.no_of_days_approve_loan >0 AND  p.no_of_days_approve_loan<=2 THEN 1 ELSE 0 END) as green,
    //     SUM(CASE WHEN p.no_of_days_approve_loan >2 AND  p.no_of_days_approve_loan<=3 THEN 1 ELSE 0 END) as yellow,
    //     SUM(CASE WHEN p.no_of_days_approve_loan >3 AND  p.no_of_days_approve_loan<=5 THEN 1 ELSE 0 END) as grey,
    //     SUM(CASE WHEN p.no_of_days_approve_loan >5 THEN 1 ELSE 0 END) as red,
    //     SUM(CASE WHEN p.no_of_days_approve_loan >0 AND  p.no_of_days_approve_loan<=2 THEN 1 ELSE 0 END)/count(a.id)*100 as green_per,
    //     SUM(CASE WHEN p.no_of_days_approve_loan >2 AND  p.no_of_days_approve_loan<=3 THEN 1 ELSE 0 END)/count(a.id)*100 as yellow_per,
    //     SUM(CASE WHEN p.no_of_days_approve_loan >3 AND  p.no_of_days_approve_loan<=5 THEN 1 ELSE 0 END)/count(a.id)*100 as grey_per,
    //     SUM(CASE WHEN p.no_of_days_approve_loan >5 THEN 1 ELSE 0 END)/count(a.id)*100 as red_per
    //     FROM shg_mst as a
    //     INNER JOIN shg_sub_mst as b ON a.id = b.shg_mst_id
    //     INNER JOIN shg_efficiency as p ON b.shg_mst_id = p.shg_sub_mst_id
    //     WHERE a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";

    //     $data['shg_time_taken_approve'] = DB::select($query);

    //     // shg cash in hand

    //     $query="SELECT
    //     SUM(CASE WHEN p.no_of_days_cash_in_hand >0 AND  p.no_of_days_cash_in_hand<=2 THEN 1 ELSE 0 END) as green,
    //     SUM(CASE WHEN p.no_of_days_cash_in_hand >2 AND  p.no_of_days_cash_in_hand<=3 THEN 1 ELSE 0 END) as yellow,
    //     SUM(CASE WHEN p.no_of_days_cash_in_hand >3 AND  p.no_of_days_cash_in_hand<=5 THEN 1 ELSE 0 END) as grey,
    //     SUM(CASE WHEN p.no_of_days_cash_in_hand >5 THEN 1 ELSE 0 END) as red,
    //     SUM(CASE WHEN p.no_of_days_cash_in_hand >0 AND  p.no_of_days_cash_in_hand<=2 THEN 1 ELSE 0 END)/count(a.id)*100 as green_per,
    //     SUM(CASE WHEN p.no_of_days_cash_in_hand >2 AND  p.no_of_days_cash_in_hand<=3 THEN 1 ELSE 0 END)/count(a.id)*100 as yellow_per,
    //     SUM(CASE WHEN p.no_of_days_cash_in_hand >3 AND  p.no_of_days_cash_in_hand<=5 THEN 1 ELSE 0 END)/count(a.id)*100 as grey_per,
    //     SUM(CASE WHEN p.no_of_days_cash_in_hand >5 THEN 1 ELSE 0 END)/count(a.id)*100 as red_per
    //     FROM shg_mst as a
    //     INNER JOIN shg_sub_mst as b ON a.id = b.shg_mst_id
    //     INNER JOIN shg_efficiency as p ON b.shg_mst_id = p.shg_sub_mst_id
    //     WHERE a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";

    //     $data['shg_cash_in_hand'] = DB::select($query);


    //     // shg no of member HHs benefitted from all Loans during last 3 years

    //     $query="SELECT
    //     AVG(p.no_of_internal_poorest_recloan+p.no_of_internal_poor_recloan+p.no_of_internal_medium_recloan+p.no_of_internal_rich_recloan
	//  +p.no_of_external_poorest_recloan+p.no_of_external_poor_recloan+p.no_of_external_medium_recloan+p.no_of_external_rich_recloan
	//  +p.no_of_bank_external_poorest_recloan+p.no_of_bank_external_poor_recloan+p.no_of_bank_external_medium_recloan+p.no_of_bank_external_rich_recloan
	//  +p.no_of_other_external_poorest_recloan+p.no_of_other_external_poor_recloan+p.no_of_other_external_medium_recloan+p.no_of_other_external_rich_recloan
	//  +p.no_of_vi_poorest_recloan+p.no_of_vi_poor_recloan+p.no_of_vi_medium_recloan+p.no_of_vi_rich_recloan) AS no_of_avg_loan,
    // AVG(p.no_of_internal_poorest_recloan+p.no_of_internal_poor_recloan+p.no_of_internal_medium_recloan+p.no_of_internal_rich_recloan
	//  +p.no_of_external_poorest_recloan+p.no_of_external_poor_recloan+p.no_of_external_medium_recloan+p.no_of_external_rich_recloan
	//  +p.no_of_bank_external_poorest_recloan+p.no_of_bank_external_poor_recloan+p.no_of_bank_external_medium_recloan+p.no_of_bank_external_rich_recloan
	//  +p.no_of_other_external_poorest_recloan+p.no_of_other_external_poor_recloan+p.no_of_other_external_medium_recloan+p.no_of_other_external_rich_recloan
	//  +p.no_of_vi_poorest_recloan+p.no_of_vi_poor_recloan+p.no_of_vi_medium_recloan+p.no_of_vi_rich_recloan)/SUM(p.no_of_internal_poorest_recloan+p.no_of_internal_poor_recloan+p.no_of_internal_medium_recloan+p.no_of_internal_rich_recloan
	//  +p.no_of_external_poorest_recloan+p.no_of_external_poor_recloan+p.no_of_external_medium_recloan+p.no_of_external_rich_recloan
	//  +p.no_of_bank_external_poorest_recloan+p.no_of_bank_external_poor_recloan+p.no_of_bank_external_medium_recloan+p.no_of_bank_external_rich_recloan
	//  +p.no_of_other_external_poorest_recloan+p.no_of_other_external_poor_recloan+p.no_of_other_external_medium_recloan+p.no_of_other_external_rich_recloan
	//  +p.no_of_vi_poorest_recloan+p.no_of_vi_poor_recloan+p.no_of_vi_medium_recloan+p.no_of_vi_rich_recloan) * 100 AS no_of_avg_loan_per
    //     FROM shg_mst as a
    //     INNER JOIN shg_sub_mst as b ON a.id = b.shg_mst_id
    //     INNER JOIN shg_creditrecovery as p ON b.shg_mst_id = p.shg_sub_mst_id
    //     WHERE a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";

    //     $data['shg_loan_3_year'] = DB::select($query);

    //     // shg No of Loans and Amounts disbursed During last 3 years

    //     $query = "SELECT
    //                 AVG(p.no_of_internal_poorest + p.no_of_external_poorest + p.no_of_vi_poorest + p.no_of_bank_external_poorest + p.no_of_other_external_poorest +
    //                     p.no_of_internal_poor + p.no_of_external_poor + p.no_of_vi_poor + p.no_of_bank_external_poor + p.no_of_other_external_poor +
    //                     p.no_of_internal_medium + p.no_of_external_medium + p.no_of_vi_medium + p.no_of_other_external_medium + p.no_of_bank_external_medium +
    //                     p.no_of_internal_rich + p.no_of_external_rich + p.no_of_vi_rich + p.no_of_other_external_rich + p.no_of_bank_external_rich) AS no_of_disbursed_loan_avg,

    //                 AVG(p.no_of_internal_poorest_amount + p.no_of_external_poorest_amount + p.no_of_vi_poorest_amount + p.no_of_bank_external_poorest_amount + p.no_of_other_external_poorest_amount +
    //                     p.no_of_internal_poor_amount +
    //                     p.no_of_external_poor_amount +
    //                     p.no_of_vi_poor_amount +
    //                     p.no_of_bank_external_poor_amount +
    //                     p.no_of_other_external_poor_amount +
    //                     p.no_of_internal_medium_amount +
    //                     p.no_of_external_medium_amount +
    //                     p.no_of_vi_medium_amount +
    //                     p.no_of_other_external_medium_amount +
    //                     p.no_of_bank_external_medium_amount +
    //                     p.no_of_internal_rich_amount +
    //                     p.no_of_external_rich_amount +
    //                     p.no_of_vi_rich_amount +
    //                     p.no_of_other_external_rich_amount +
    //                     p.no_of_bank_external_rich_amount) AS no_of_disbursed_loan_amount,

    //                 AVG(p.no_of_internal_poorest_amount + p.no_of_external_poorest_amount + p.no_of_vi_poorest_amount + p.no_of_bank_external_poorest_amount + p.no_of_other_external_poorest_amount +
    //                     p.no_of_internal_poor_amount +
    //                     p.no_of_external_poor_amount +
    //                     p.no_of_vi_poor_amount +
    //                     p.no_of_bank_external_poor_amount +
    //                     p.no_of_other_external_poor_amount +
    //                     p.no_of_internal_medium_amount +
    //                     p.no_of_external_medium_amount +
    //                     p.no_of_vi_medium_amount +
    //                     p.no_of_other_external_medium_amount +
    //                     p.no_of_bank_external_medium_amount +
    //                     p.no_of_internal_rich_amount +
    //                     p.no_of_external_rich_amount +
    //                     p.no_of_vi_rich_amount +
    //                     p.no_of_other_external_rich_amount +
    //                     p.no_of_bank_external_rich_amount) / SUM(p.no_of_internal_poorest_amount + p.no_of_external_poorest_amount + p.no_of_vi_poorest_amount + p.no_of_bank_external_poorest_amount + p.no_of_other_external_poorest_amount +
    //                     p.no_of_internal_poor_amount +
    //                     p.no_of_external_poor_amount +
    //                     p.no_of_vi_poor_amount +
    //                     p.no_of_bank_external_poor_amount +
    //                     p.no_of_other_external_poor_amount +
    //                     p.no_of_internal_medium_amount +
    //                     p.no_of_external_medium_amount +
    //                     p.no_of_vi_medium_amount +
    //                     p.no_of_other_external_medium_amount +
    //                     p.no_of_bank_external_medium_amount +
    //                     p.no_of_internal_rich_amount +
    //                     p.no_of_external_rich_amount +
    //                     p.no_of_vi_rich_amount +
    //                     p.no_of_other_external_rich_amount +
    //                     p.no_of_bank_external_rich_amount) * 100 AS no_of_avg_loan_amount_per
    //         FROM shg_mst AS a
    //         INNER JOIN shg_sub_mst AS b ON a.id = b.shg_mst_id
    //         INNER JOIN shg_creditrecovery AS p ON b.shg_mst_id = p.shg_sub_mst_id
    //         WHERE a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";

    //         $data['shg_loan_disbursd_3_year'] = DB::select($query);

    //     // shg No of Loans default

    //     $query = "SELECT
    //         AVG(p.default_internal_loan + p.default_cluster_loan + p.default_federation_loan + p.default_bank_loan + p.default_vi_loan + p.default_other_loan)
    //     AS loan_default_avg,
    //     AVG(p.default_internal_loan + p.default_cluster_loan + p.default_federation_loan + p.default_bank_loan + p.default_vi_loan + p.default_other_loan)/
    //     SUM(p.default_internal_loan + p.default_cluster_loan + p.default_federation_loan + p.default_bank_loan + p.default_vi_loan + p.default_other_loan)*100
    //             AS loan_default_avg_per
    //     FROM shg_mst AS a
    //     INNER JOIN shg_sub_mst AS b ON a.id = b.shg_mst_id
    //     INNER JOIN shg_creditrecovery AS p ON b.shg_mst_id = p.shg_sub_mst_id
    //     WHERE a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";

    //     $data['shg_loan_default'] = DB::select($query);

    //         // shg par internal or external

    //         $query = "SELECT
    //         AVG(p.creditHistory_PAR_status_Internal)
    //         AS par_internal_avg,
    //         AVG(p.creditHistory_PAR_status_Internal)/SUM(p.creditHistory_PAR_status_Internal) * 100
    //         AS par_internal_avg_per,
    //         AVG(p.creditHistory_PAR_status_External)
    //         AS par_external_avg,
    //         AVG(p.creditHistory_PAR_status_External)/SUM(p.creditHistory_PAR_status_External) * 100
    //         AS par_external_avg_per
    //     FROM shg_mst AS a
    //     INNER JOIN shg_sub_mst AS b ON a.id = b.shg_mst_id
    //     INNER JOIN shg_creditrecovery AS p ON b.shg_mst_id = p.shg_sub_mst_id
    //     WHERE a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";

    //     $data['shg_par'] = DB::select($query);

    //     // shg productive



    //         $query = "SELECT
    //         AVG(p.purposes_productive + p.purposes_productive_federation + p.purposes_productive_vi)
    //         AS productive_avg,
    //         SUM(p.purposes_productive + p.purposes_productive_federation + p.purposes_productive_vi)/SUM(p.purposes_productive + p.purposes_productive_federation + p.purposes_productive_vi + p.purposes_consumption + p.purposes_consumption_federation + p.purposes_consumption_vi + p.purposes_debt_swapping + p.purposes_debt_swapping_federation + p.purposes_debt_swapping_vi + p.purposes_other + p.purposes_other_federation + p.purposes_other_vi) * 100
    //         AS productive_avg_per

    //     FROM shg_mst AS a
    //     INNER JOIN shg_sub_mst AS b ON a.id = b.shg_mst_id
    //     INNER JOIN shg_creditrecovery AS p ON b.shg_mst_id = p.shg_sub_mst_id
    //     WHERE a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";

    //     $data['shg_productive'] = DB::select($query);


    //     // shg no of Members taken more than 1 loan during last 3 years
    //     $query = "SELECT
    //     AVG(p.no_of_member_loan_more)
    //     AS member_loan,
    //     AVG(p.no_of_member_loan_more)/SUM(p.no_of_member_loan_more) * 100
    //     AS member_loan_per

    //     FROM shg_mst AS a
    //     INNER JOIN shg_sub_mst AS b ON a.id = b.shg_mst_id
    //     INNER JOIN shg_creditrecovery AS p ON b.shg_mst_id = p.shg_sub_mst_id
    //     WHERE a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";

    //     $data['shg_member'] = DB::select($query);

    //     // shg Regularity of Normal/Compulsory Savings (all members saving per month)
    //     $query = "SELECT
    //     AVG(p.compulsory_saving_amount+p.shg_voluntary_saving_amount_per_month) AS shg_saving,
    //     AVG(p.compulsory_saving_amount+p.shg_voluntary_saving_amount_per_month)/SUM(p.compulsory_saving_amount+p.shg_voluntary_saving_amount_per_month) * 100 AS shg_saving_per
    //     FROM shg_mst AS a
    //     INNER JOIN shg_sub_mst AS b ON a.id = b.shg_mst_id
    //     INNER JOIN shg_saving AS p ON b.shg_mst_id = p.shg_sub_mst_id
    //     WHERE a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";

    //     $data['shg_saviung'] = DB::select($query);

    //     // Normal/compulsory savings trend
    //     $query = "SELECT
    //     AVG(p.savingsMobilization_Last_year_per_member+p.savingsMobilization_Previous_year_per_member+p.savingsMobilization_Current_year_per_member+p.savingsMobilization_voluntary_saving) AS shg_saving_trend,
    //     AVG(p.savingsMobilization_Last_year_per_member+p.savingsMobilization_Previous_year_per_member+p.savingsMobilization_Current_year_per_member+p.savingsMobilization_voluntary_saving)/SUM(p.savingsMobilization_Last_year_per_member+p.savingsMobilization_Previous_year_per_member+p.savingsMobilization_Current_year_per_member+p.savingsMobilization_voluntary_saving) * 100 AS shg_saving_trend_per
    //     FROM shg_mst AS a
    //     INNER JOIN shg_sub_mst AS b ON a.id = b.shg_mst_id
    //     INNER JOIN shg_saving AS p ON b.shg_mst_id = p.shg_sub_mst_id
    //     WHERE a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";

    //     $data['shg_saving_trend'] = DB::select($query);

    //     // Normal/compulsory savings trend
    //     $query = "SELECT
    //     SUM(CASE WHEN p.voluntary_saving ='Yes' THEN 1 ELSE 0 END) as voluntary_saving,
    //     SUM(CASE WHEN p.voluntary_saving ='Yes' THEN 1 ELSE 0 END)/count(a.id)*100 as voluntary_saving_per
    //     FROM shg_mst AS a
    //     INNER JOIN shg_sub_mst AS b ON a.id = b.shg_mst_id
    //     INNER JOIN shg_saving AS p ON b.shg_mst_id = p.shg_sub_mst_id
    //     WHERE a.is_deleted = 0 AND a.cluster_uin IN ($cluster_uin)";

    //     $data['shg_voluntary_saving'] = DB::select($query);
    //     // prd($data['shg_voluntary_saving']);



    //     // family part start

    //     $query = "SELECT GROUP_CONCAT(id) AS id from family_mst where is_deleted = 0 and shg_uin in($shg_uin)";
    //     $family_ids = DB::select($query)[0]->id;


    //         // family age

    //     $query = "SELECT
    //     SUM(CASE WHEN p.fp_age <=30 THEN 1 ELSE 0 END) AS age_30_year,
    //     SUM(CASE WHEN p.fp_age >30 AND p.fp_age <=40  THEN 1 ELSE 0 END) AS age_31_to_40_year,
    //     SUM(CASE WHEN p.fp_age >40 AND p.fp_age <=50  THEN 1 ELSE 0 END) AS age_41_to_50_year,
    //     SUM(CASE WHEN p.fp_age >50 AND p.fp_age <=60  THEN 1 ELSE 0 END) AS age_51_to_60_year,
    //     SUM(CASE WHEN p.fp_age >60 AND p.fp_age <=65  THEN 1 ELSE 0 END) AS age_61_to_65_year,
    //     SUM(CASE WHEN p.fp_age >65  THEN 1 ELSE 0 END) AS age_above_65_year,
    //     SUM(CASE WHEN p.fp_age <=30 THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS age_30_year_per,
    //     SUM(CASE WHEN p.fp_age >30 AND p.fp_age <=40  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS age_31_to_40_year_per,
    //     SUM(CASE WHEN p.fp_age >40 AND p.fp_age <=50  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS age_41_to_50_year_per,
    //     SUM(CASE WHEN p.fp_age >50 AND p.fp_age <=60  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS age_51_to_60_year_per,
    //     SUM(CASE WHEN p.fp_age >60 AND p.fp_age <=65  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS age_61_to_65_year_per,
    //     SUM(CASE WHEN p.fp_age >65  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS age_above_65_year_per,
    //     AVG(CASE WHEN p.fp_age <=30 THEN 1 ELSE 0 END) AS age_30_year_avg,
    //     AVG(CASE WHEN p.fp_age >30 AND p.fp_age <=40  THEN 1 ELSE 0 END) AS age_31_to_40_year_avg,
    //     AVG(CASE WHEN p.fp_age >40 AND p.fp_age <=50  THEN 1 ELSE 0 END) AS age_41_to_50_year_avg,
    //     AVG(CASE WHEN p.fp_age >50 AND p.fp_age <=60  THEN 1 ELSE 0 END) AS age_51_to_60_year_avg,
    //     AVG(CASE WHEN p.fp_age >60 AND p.fp_age <=65  THEN 1 ELSE 0 END) AS age_61_to_65_year_avg,
    //     AVG(CASE WHEN p.fp_age >65  THEN 1 ELSE 0 END) AS age_above_65_year_avg
    //     FROM family_mst AS a
    //     INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //     INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //     WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";

    //     $data['family_ages'] = DB::select($query);
    //     // pr($query);
    //     // prd($data['family_ages']);

    //          // family castes

    //          $query = "SELECT
    //             SUM(CASE WHEN p.fp_caste ='OBC' THEN 1 ELSE 0 END) AS OBC,
    //             SUM(CASE WHEN p.fp_caste ='SC'  THEN 1 ELSE 0 END) AS SC,
    //             SUM(CASE WHEN p.fp_caste ='ST'  THEN 1 ELSE 0 END) AS ST,
    //             SUM(CASE WHEN p.fp_caste ='GC'  THEN 1 ELSE 0 END) AS GC,
    //             SUM(CASE WHEN p.fp_caste ='OTHER'  THEN 1 ELSE 0 END) AS OTHER,
    //             SUM(CASE WHEN p.fp_caste ='OBC' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS OBC_per,
    //             SUM(CASE WHEN p.fp_caste ='SC'  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS SC_per,
    //             SUM(CASE WHEN p.fp_caste ='ST'  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS ST_per,
    //             SUM(CASE WHEN p.fp_caste ='GC'  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS GC_per,
    //             SUM(CASE WHEN p.fp_caste ='OTHER'  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS OTHER_per
    //          FROM family_mst AS a
    //          INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //          INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //          WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";

    //          $data['family_casts'] = DB::select($query);

    //          // family Wealth Ranking

    //          $query = "SELECT
    //             SUM(CASE WHEN p.fp_wealth_rank ='very poor' OR p.fp_wealth_rank ='destitute' THEN 1 ELSE 0 END) AS very_poor,
    //             SUM(CASE WHEN p.fp_wealth_rank ='poor' THEN 1 ELSE 0 END) AS poor,
    //             SUM(CASE WHEN p.fp_wealth_rank ='medium poor' THEN 1 ELSE 0 END) AS medium_poor,
    //             SUM(CASE WHEN p.fp_wealth_rank ='rich' THEN 1 ELSE 0 END) AS rich,
    //             SUM(CASE WHEN p.fp_wealth_rank ='very poor' OR p.fp_wealth_rank ='destitute' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS very_poor_per,
    //             SUM(CASE WHEN p.fp_wealth_rank ='poor' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS poor_per,
    //             SUM(CASE WHEN p.fp_wealth_rank ='medium poor' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS medium_poor_per,
    //             SUM(CASE WHEN p.fp_wealth_rank ='rich' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS rich_per
    //             FROM family_mst AS a
    //             INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //             INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //             WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";

    //          $data['family_wealth_ranking'] = DB::select($query);

    //         //  family Quality of Life Aspects

    //         $query = "SELECT
    //             SUM(CASE WHEN p.aNutritionMortality ='Yes' THEN 1 ELSE 0 END) AS family_daily_meel,
    //             SUM(CASE WHEN p.bNutritionMortality ='Yes' THEN 1 ELSE 0 END) AS malnourishment,
    //             SUM(CASE WHEN p.sHealthIssues ='Yes' THEN 1 ELSE 0 END) AS helath_issue,
    //             SUM(CASE WHEN p.sanitation ='Have a toilet exclusive for their use within the house' THEN 1 ELSE 0 END) AS sanitation,
    //             SUM(CASE WHEN p.sDrinkingWater ='Within the house' THEN 1 ELSE 0 END) AS sDrinkingWater,
    //             SUM(CASE WHEN p.sElectricity ='Yes' THEN 1 ELSE 0 END) AS Electricity,
    //             SUM(CASE WHEN p.sCookingFuel ='Gas connection' THEN 1 ELSE 0 END) AS CookingFuel,
    //             SUM(CASE WHEN d.fa_Pacca_Kaccha_house ='Pacca' THEN 1 ELSE 0 END) AS pacca,
    //             SUM(CASE WHEN d.fa_Pacca_Kaccha_house ='Kachha' THEN 1 ELSE 0 END) AS Kachha,
    //             SUM(CASE WHEN d.fa_Pacca_Kaccha_house ='Tiled' THEN 1 ELSE 0 END) AS Tiled,

    //             SUM(CASE WHEN p.aNutritionMortality ='Yes' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS family_daily_meel_per,
    //             SUM(CASE WHEN p.bNutritionMortality ='Yes' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS malnourishment_per,
    //             SUM(CASE WHEN p.sHealthIssues ='Yes' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS helath_issue_per,
    //             SUM(CASE WHEN p.sanitation ='Have a toilet exclusive for their use within the house' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS sanitation_per,
    //             SUM(CASE WHEN p.sDrinkingWater ='Within the house' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS sDrinkingWater_per,
    //             SUM(CASE WHEN p.sElectricity ='Yes' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS Electricity_per,
    //             SUM(CASE WHEN p.sCookingFuel ='Gas connection' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS CookingFuel_per,
    //             SUM(CASE WHEN d.fa_Pacca_Kaccha_house ='Pacca' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS pacca_per,
    //             SUM(CASE WHEN d.fa_Pacca_Kaccha_house ='Kachha' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS Kachha_per,
    //             SUM(CASE WHEN d.fa_Pacca_Kaccha_house ='Tiled' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS Tiled_per
    //             FROM family_mst AS a
    //             INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //             INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //             INNER JOIN family_assets AS d ON b.family_mst_id = d.family_sub_mst_id
    //             WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";

    //          $data['family_quality_aspects'] = DB::select($query);

    //          //  family educated

    //         $query = "SELECT
    //         SUM(CASE WHEN p.family_member_not_educated ='Yes' THEN 1 ELSE 0 END) AS family_educated,
    //         SUM(CASE WHEN p.family_member_not_educated ='Yes' THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS family_educated_per
    //         FROM family_mst AS a
    //         INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //         INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //         WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";

    //         $data['family_educated'] = DB::select($query);

    //         // prd($data['family_educated']);

    //         //  family gadgets

    //         $query = "SELECT
    //         SUM(CASE WHEN p.refrigerator =1 THEN 1 ELSE 0 END) AS refrigerator,
    //         SUM(CASE WHEN p.fa_airconditioners =1 THEN 1 ELSE 0 END) AS fa_airconditioners,
    //         SUM(CASE WHEN p.fa_smartphone =1 THEN 1 ELSE 0 END) AS fa_smartphone,
    //         SUM(CASE WHEN p.fa_tvcolor =1 THEN 1 ELSE 0 END) AS fa_tvcolor,

    //         SUM(CASE WHEN p.refrigerator =1 THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS refrigerator_per,
    //         SUM(CASE WHEN p.fa_airconditioners =1 THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS fa_airconditioners_per,
    //         SUM(CASE WHEN p.fa_smartphone =1 THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS fa_smartphone_per,
    //         SUM(CASE WHEN p.fa_tvcolor =1 THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS fa_tvcolor_per
    //         FROM family_mst AS a
    //         INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //         INNER JOIN family_assets_gadgets AS p ON b.family_mst_id = p.family_sub_mst_id
    //         WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";

    //         $data['family_gadgets'] = DB::select($query);

    //         // prd($data['family_gadgets']);

    //          //  family transportation

    //          $query = "SELECT

    //             SUM(CASE WHEN p.vehicle_Types = 'motorcycle' THEN p.no_of_vehicle ELSE 0 END) no_of_bike,
    //             SUM(CASE WHEN p.vehicle_Types = 'bicycles' THEN p.no_of_vehicle ELSE 0 END) no_of_cycles,
    //             SUM(CASE WHEN p.vehicle_Types = 'car' THEN p.no_of_vehicle ELSE 0 END) no_of_car,

    //             SUM(CASE WHEN p.vehicle_Types = 'motorcycle' THEN p.no_of_vehicle ELSE 0 END)/COUNT(a.id)*100 no_of_bike_per,
    //             SUM(CASE WHEN p.vehicle_Types = 'bicycles' THEN p.no_of_vehicle ELSE 0 END)/COUNT(a.id)*100 no_of_cycles_per,
    //             SUM(CASE WHEN p.vehicle_Types = 'car' THEN p.no_of_vehicle ELSE 0 END)/COUNT(a.id)*100 no_of_car_per

    //          FROM family_mst AS a
    //          INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //          INNER JOIN family_assets_vehicle AS p ON b.family_mst_id = p.family_sub_mst_id
    //          WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";

    //          $data['family_vehicle'] = DB::select($query);

    //         //  family total land

    //         $query = "SELECT
    //         SUM( p.fa_total_land_owned) total_land,
    //         SUM( p.fa_total_land_owned)/COUNT(a.id)*100 total_land_per,
    //         AVG( p.fa_land_not_owned) sharecroping,
    //         SUM( p.fa_land_not_owned)/COUNT(a.id)*100 sharecroping_per
    //         FROM family_mst AS a
    //         INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //         INNER JOIN family_assets AS p ON b.family_mst_id = p.family_sub_mst_id
    //         WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";

    //         $data['family_land'] = DB::select($query);

    //         //  family livestock

    //         $query = "SELECT

    //         SUM(CASE WHEN p.animal_Types = 'Cow' THEN p.no_of_animals ELSE 0 END) no_of_cow,
    //         SUM(CASE WHEN p.animal_Types = 'Buffalo' THEN p.no_of_animals ELSE 0 END) no_of_buffalo,
    //         SUM(CASE WHEN p.animal_Types = 'Goat' THEN p.no_of_animals ELSE 0 END) no_of_goat,

    //         SUM(CASE WHEN p.animal_Types = 'Cow' THEN p.no_of_animals ELSE 0 END)/COUNT(a.id)*100 no_of_cow_per,
    //         SUM(CASE WHEN p.animal_Types = 'Buffalo' THEN p.no_of_animals ELSE 0 END)/COUNT(a.id)*100 no_of_buffalo_per,
    //         SUM(CASE WHEN p.animal_Types = 'Goat' THEN p.no_of_animals ELSE 0 END)/COUNT(a.id)*100 no_of_goat_per

    //         FROM family_mst AS a
    //         INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //         INNER JOIN family_assets_live_stock AS p ON b.family_mst_id = p.family_sub_mst_id
    //         WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";

    //         $data['family_live_stock'] = DB::select($query);

    //         //  family machinery

    //         $query = "SELECT

    //         SUM( p.no_of_machinery) total_machinery,
    //         SUM( p.no_of_machinery)/COUNT(a.id)*100 total_machinery_per

    //         FROM family_mst AS a
    //         INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //         INNER JOIN family_assets_machinery AS p ON b.family_mst_id = p.family_sub_mst_id
    //         WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";

    //         $data['family_machinery'] = DB::select($query);

    //         //  family Jewelry

    //         $query = "SELECT

    //         SUM( CASE WHEN p.fa_jewelry_yes_no = 'Yes' THEN 1 ELSE 0 END ) total_family_jewlry,
    //         SUM( CASE WHEN p.fa_jewelry_yes_no = 'Yes' THEN 1 ELSE 0 END )/COUNT(a.id)*100 total_family_jewlry_per

    //         FROM family_mst AS a
    //         INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //         INNER JOIN family_assets AS p ON b.family_mst_id = p.family_sub_mst_id
    //         WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";

    //         $data['family_jewelry'] = DB::select($query);


    //         //  family Jewelry

    //         $query = "SELECT

    //         SUM(CASE WHEN p.e_total_amount <=100000 THEN 1 ELSE 0 END) AS income_1,
    //         SUM(CASE WHEN p.e_total_amount >100000 AND p.e_total_amount <=200000  THEN 1 ELSE 0 END) AS income_1_to_2,
    //         SUM(CASE WHEN p.e_total_amount >200000 AND p.e_total_amount <=300000  THEN 1 ELSE 0 END) AS income_2_to_3,
    //         SUM(CASE WHEN p.e_total_amount >300000 AND p.e_total_amount <=400000  THEN 1 ELSE 0 END) AS income_3_to_4,
    //         SUM(CASE WHEN p.e_total_amount >400000 THEN 1 ELSE 0 END) AS income_4,

    //         SUM(CASE WHEN p.e_total_amount <=100000 THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS income_1_per,
    //         SUM(CASE WHEN p.e_total_amount >100000 AND p.e_total_amount <=200000  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS income_1_to_2_per,
    //         SUM(CASE WHEN p.e_total_amount >200000 AND p.e_total_amount <=300000  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS income_2_to_3_per,
    //         SUM(CASE WHEN p.e_total_amount >300000 AND p.e_total_amount <=400000  THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS income_3_to_4_per,
    //         SUM(CASE WHEN p.e_total_amount >400000 THEN 1 ELSE 0 END)/COUNT(a.id)*100 AS income_4_per
    //         FROM family_mst AS a
    //         INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //         INNER JOIN family_income_this_year AS p ON b.family_mst_id = p.family_sub_mst_id
    //         WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";
    //         $data['family_income'] = DB::select($query);


    //         //  Sources of Family Income

    //         $query = "SELECT

    //             SUM(p.agriculture+p.livestock+p.horticulture) AS total_income_aggriculture,
    //             SUM(CASE WHEN p.agriculture >0 OR p.livestock >0 OR p.horticulture >0  THEN 1 ELSE 0 END) AS no_of_hh_aggriculture,
    //             AVG(p.agriculture+p.livestock+p.horticulture)/AVG(p.e_total_amount)*100 AS avg_income_aggriculture_per,

    //             SUM(p.fixed_income_amount) AS total_fixed_income_amount,
    //             SUM(CASE WHEN p.fixed_income_amount >0  THEN 1 ELSE 0 END) AS no_of_hh_fixed_income,
    //             AVG(p.fixed_income_amount)/AVG(p.e_total_amount)*100 AS avg_fixed_income_per,

    //             SUM(p.casual_income_amount) AS total_casual_income_amount,
    //             SUM(CASE WHEN p.casual_income_amount >0  THEN 1 ELSE 0 END) AS no_of_hh_casual_income,
    //             AVG(p.casual_income_amount)/AVG(p.e_total_amount)*100 AS avg_casual_income_per,

    //             SUM(p.trade_income_amount) AS total_trade_income_amount,
    //             SUM(CASE WHEN p.trade_income_amount >0  THEN 1 ELSE 0 END) AS no_of_hh_trade_income,
    //             AVG(p.trade_income_amount)/AVG(p.e_total_amount)*100 AS avg_trade_income_per,

    //             SUM(p.pension_income_monthly) AS total_pension_income_amount,
    //             SUM(CASE WHEN p.pension_income_monthly >0  THEN 1 ELSE 0 END) AS no_of_hh_pension_income,
    //             AVG(p.pension_income_monthly)/AVG(p.e_total_amount)*100 AS avg_pension_income_per,

    //             SUM(p.other_income) AS total_other_income_amount,
    //             SUM(CASE WHEN p.other_income >0  THEN 1 ELSE 0 END) AS no_of_hh_other_income,
    //             AVG(p.other_income)/AVG(p.e_total_amount)*100 AS avg_other_income_per,

    //             AVG(p.e_total_amount) AS total_avg_income_amount,
    //             SUM(CASE WHEN p.e_total_amount >0  THEN 1 ELSE 0 END) AS no_of_hh_total_avg_income,
    //             AVG(p.e_total_amount)/AVG(p.e_total_amount)*100 AS total_avg_income_amount_per

    //         FROM family_mst AS a
    //         INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //         INNER JOIN family_income_this_year AS p ON b.family_mst_id = p.family_sub_mst_id
    //         WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";
    //         $data['family_income_saurce'] = DB::select($query);

    //         //  Average annual HH income by Poverty Category

    //         $query = "SELECT

    //             sum(CASE WHEN p.fp_wealth_rank ='very poor' OR  p.fp_wealth_rank ='destitute'  THEN d.e_total_amount ELSE 0 END)/SUM(case when  p.fp_wealth_rank ='very poor' THEN 1 ELSE 0 END) AS annual_income_avg_very_poor,
    //             SUM(case when  p.fp_wealth_rank ='very poor' THEN 1 ELSE 0 END) AS no_of_hh_annual_income_avg_very_poor,
    //             AVG(CASE WHEN p.fp_wealth_rank ='very poor' OR  p.fp_wealth_rank ='destitute'  THEN d.e_total_amount ELSE 0 END)/
    //             AVG(d.e_total_amount )*100 AS annual_income_avg_very_poor_per,

    //             SUM(CASE WHEN p.fp_wealth_rank ='poor' THEN d.e_total_amount ELSE 0 END)/SUM(case when  p.fp_wealth_rank ='poor' THEN 1 ELSE 0 END) AS annual_income_avg_poor,
    //             SUM(case when  p.fp_wealth_rank ='poor' THEN 1 ELSE 0 END) AS no_of_hh_annual_income_avg_poor,
    //             AVG(CASE WHEN p.fp_wealth_rank ='poor' THEN d.e_total_amount ELSE 0 END)/
    //             AVG(d.e_total_amount )*100 AS annual_income_avg_poor_per,

    //             SUM(CASE WHEN p.fp_wealth_rank ='medium poor' THEN d.e_total_amount ELSE 0 END)/SUM(case when  p.fp_wealth_rank ='medium poor' THEN 1 ELSE 0 END) AS annual_income_avg_medium_poor,
    //             SUM(case when  p.fp_wealth_rank ='medium poor' THEN 1 ELSE 0 END) AS no_of_hh_annual_income_avg_medium_poor,
    //             AVG(CASE WHEN p.fp_wealth_rank ='medium poor' THEN d.e_total_amount ELSE 0 END)/
    //             AVG(d.e_total_amount )*100 AS annual_income_avg__medium_poor_per,

    //             SUM(CASE WHEN p.fp_wealth_rank ='rich' THEN d.e_total_amount ELSE 0 END)/SUM(case when  p.fp_wealth_rank ='rich' THEN 1 ELSE 0 END) AS annual_income_avg_rich_poor,
    //             SUM(case when  p.fp_wealth_rank ='rich' THEN 1 ELSE 0 END) AS no_of_hh_annual_income_avg_rich_poor,
    //             AVG(CASE WHEN p.fp_wealth_rank ='rich' THEN d.e_total_amount ELSE 0 END)/
    //             AVG(d.e_total_amount )*100 AS annual_income_avg__rich_poor_per,


    //             AVG(d.e_total_amount) AS annual_income_overall,
    //             SUM(case when  d.e_total_amount >0 THEN 1 ELSE 0 END) AS no_of_hh_annual_income_overall,
    //             AVG(d.e_total_amount)/
    //             AVG(d.e_total_amount )*100 AS annual_income_avg__overall_per


    //             FROM family_mst AS a
    //             INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //             INNER JOIN family_profile AS p ON b.family_mst_id =p.family_sub_mst_id
    //             INNER JOIN family_income_this_year AS d ON p.family_sub_mst_id = d.family_sub_mst_id
    //             WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";
    //             $data['family_average_annual_income'] = DB::select($query);

    //         // prd($data['family_average_annual_income']);

    //         // Family Expenditure Pattern

    //         $query="SELECT
    //             SUM(CASE WHEN e.e_cat = 'Normal Expenditure' THEN e.e_total_amount ELSE 0 END) AS total_amount_normal_expenditure ,
    //             SUM(CASE WHEN e.e_cat = 'Social Expenditure' THEN e.e_total_amount ELSE 0 END) AS total_amount_social_expenditure ,
    //             SUM(CASE WHEN e.e_cat = 'Wasteful Expenditure' THEN e.e_total_amount ELSE 0 END) AS total_amount_wasteful_expenditure ,
    //             SUM(CASE WHEN e.e_cat = 'Production/Business Expenses' THEN e.e_total_amount ELSE 0 END) AS total_amount_production_expenditure
    //             FROM family_mst AS a
    //             INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //             INNER JOIN family_profile AS p ON b.family_mst_id =p.family_sub_mst_id
    //             INNER JOIN family_expenditure_this_year AS e ON p.family_sub_mst_id = e.family_sub_mst_id
    //             WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";
    //             $data['family_expenditure_pattren'] = DB::select($query);




    //             // family saving total
    //             $query = "SELECT
    //                     COALESCE(SUM(a.sum), 0) AS saving_total
    //                 FROM
    //                     (
    //                     SELECT
    //                         a.s_last_saved_amt AS SUM
    //                     FROM
    //                         family_savings_source AS a
    //                     WHERE
    //                         a.family_sub_mst_id IN ($family_ids)
    //                     UNION ALL
    //                 SELECT
    //                     b.last_saved_amt AS SUM
    //                 FROM
    //                     family_savings_source_other AS b
    //                 WHERE
    //                     b.family_sub_mst_id IN ($family_ids)
    //                 ) a";

    //             $data['saving_total'] = DB::select($query);


    //             // Family loan  amounts

    //                 $query="SELECT
    //                 SUM(e.current_year_interest) AS loan_total_amount
    //                 FROM family_mst AS a
    //                 INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                 INNER JOIN family_loan_outstanding AS e ON b.family_mst_id = e.family_sub_mst_id
    //                 WHERE a.is_deleted = 0 AND a.id IN ($family_ids)";
    //                 $data['family_loan_amount'] = DB::select($query);


    //                 // family no of hh expenditure patren

    //                 $query="SELECT
    //                 COUNT(CASE WHEN a.e_cat = 'Normal Expenditure' THEN 1 ELSE NULL END) AS count_of_normal,
    //                 COUNT(CASE WHEN a.e_cat = 'Social Expenditure' THEN 1 ELSE NULL END) AS count_of_Social,
    //                 COUNT(CASE WHEN a.e_cat = 'Wasteful Expenditure' THEN 1 ELSE NULL END) AS count_of_Wasteful,
    //                 COUNT(CASE WHEN a.e_cat = 'Production/Business Expenses' THEN 1 ELSE NULL END) AS count_of_Production


    //                 FROM
    //                (SELECT
    //                    a.id,
    //                    e.e_cat

    //                FROM
    //                    family_mst AS a
    //                    INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                    INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //                    INNER JOIN family_expenditure_this_year AS e ON p.family_sub_mst_id = e.family_sub_mst_id
    //                WHERE
    //                    a.is_deleted = 0
    //                    AND a.id  IN ($family_ids)
    //                GROUP BY
    //                    a.id, e.e_cat) a";
    //             $data['family_expenditure_pattren_no'] = DB::select($query);

    //             // prd($data['family_expenditure_pattren_no']);

    //             // family saving hh

    //             $query="SELECT
    //             SUM(CASE WHEN a.s_contribute_regular = 'Yes' THEN 1 ELSE 0 END) AS count_of_saving_hh
    //             FROM
    //            (SELECT
    //                a.id,
    //                e.s_contribute_regular

    //            FROM
    //                family_mst AS a
    //                INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //                INNER JOIN family_savings_source AS e ON p.family_sub_mst_id = e.family_sub_mst_id
    //            WHERE
    //                a.is_deleted = 0
    //                AND a.id IN ($family_ids)
    //            GROUP BY
    //                a.id, e.s_contribute_regular) a ";

    //                $data['family_saving_hh']=DB::select($query);
    //             //    prd($data['family_saving_hh']);

    //               // family saving hh

    //             $query="SELECT
    //             COUNT(a.id) AS count_of_loan_hh
    //             FROM
    //            (SELECT
    //                a.id
    //            FROM
    //                family_mst AS a
    //                INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //                INNER JOIN family_loan_outstanding AS e ON p.family_sub_mst_id = e.family_sub_mst_id
    //            WHERE
    //                a.is_deleted = 0 AND a.id IN ($family_ids)
    //            GROUP BY
    //                a.id) a ";

    //                $data['family_loan_hh']=DB::select($query);

    //             //    family income and expoenditure gap

    //             $query = "SELECT
    //             f.id,
    //             f.uin AS UIN,
    //             fp.fp_member_name AS Family_Name,
    //             fp.fp_wealth_rank AS Wealth_Rank,
    //             sp.shgName AS SHG_Nmae,
    //             cp.name_of_cluster AS Cluster_Name,
    //             fedp.name_of_federation AS Fedeartion_Name,
    //             fp.analysis_rating AS Rating_score
    //          FROM
    //              federation_mst AS fed
    //               INNER JOIN federation_profile AS fedp
    //               ON fed.id = fedp.federation_sub_mst_id
    //               INNER JOIN
    //              cluster_mst AS c
    //              ON c.federation_uin = fed.uin
    //              INNER JOIN cluster_profile AS cp
    //              ON c.id = cp.cluster_sub_mst_id
    //              INNER JOIN shg_mst AS s
    //              ON c.uin = s.cluster_uin
    //              INNER JOIN shg_profile AS sp
    //              ON s.id = sp.shg_sub_mst_id
    //              INNER JOIN family_mst AS f
    //              ON f.shg_uin = s.uin
    //              INNER JOIN family_profile AS fp ON f.id = fp.family_sub_mst_id

    //               WHERE c.is_deleted = 0 AND s.is_deleted = 0 AND f.is_deleted = 0 AND fed.uin =
    //              'INTNCH01092023FD74106772' ORDER  BY f.id";
    //             $family = DB::select($query);

    //             prd($family);




    //         foreach($family as $res){
    //           $data['family_assessment'][] = $this->family_analysis($res->id);

    //         }


    //         $data['family_income_ratio_10'] = 0;
    //         $data['family_income_ratio_7'] = 0;
    //         $data['family_income_ratio_5'] = 0;
    //         $data['family_income_ratio_1'] = 0;


    //         foreach ($data['family_assessment'] as $item) {
    //             switch ($item['analysis_2_cy']) {
    //                 case 10:
    //                     // green
    //                     $data['family_income_ratio_10']++;
    //                     break;
    //                 case 7:
    //                     // yellow
    //                     $data['family_income_ratio_7']++;
    //                     break;
    //                 case 5:
    //                     // grey
    //                     $data['family_income_ratio_5']++;
    //                     break;
    //                 case 1:
    //                     // red
    //                     $data['family_income_ratio_1']++;
    //                     break;

    //             }
    //         }
    //         // prd($data['family_count']);
    //         $data['family_income_ratio_10_per'] = 0;
    //         $data['family_income_ratio_7_per'] = 0;
    //         $data['family_income_ratio_5_per'] = 0;
    //         $data['family_income_ratio_1_per'] = 0;
    //         if($data['family_income_ratio_10'] > 0){
    //             $data['family_income_ratio_10_per'] = ($data['family_income_ratio_10'] / $data['family_count'][0]->count) * 100;
    //         }
    //         if($data['family_income_ratio_7'] > 0){
    //             $data['family_income_ratio_7_per'] = ($data['family_income_ratio_7'] / $data['family_count'][0]->count) * 100;
    //         }
    //         if($data['family_income_ratio_5'] > 0){
    //             $data['family_income_ratio_5_per'] = ($data['family_income_ratio_5'] / $data['family_count'][0]->count) * 100;
    //         }
    //         if($data['family_income_ratio_1'] > 0){
    //             $data['family_income_ratio_1_per'] = ($data['family_income_ratio_1'] / $data['family_count'][0]->count) * 100;
    //         }

    //         // family saving by wealth rank

    //         $query="SELECT

    //             SUM(CASE WHEN (p.fp_wealth_rank = 'very poor' OR p.fp_wealth_rank = 'destitute') AND e.s_contribute_regular = 'Yes' THEN  1  ELSE 0 END) AS saving_count_very_poor,
    //             SUM(CASE WHEN p.fp_wealth_rank = 'poor' AND e.s_contribute_regular = 'Yes'  THEN  1 ELSE 0 END) AS saving_count_poor,
    //             SUM(CASE WHEN p.fp_wealth_rank = 'medium poor' AND e.s_contribute_regular = 'Yes'  THEN  1 ELSE 0 END) AS saving_count_medium_poor,
    //             SUM(CASE WHEN p.fp_wealth_rank = 'rich' AND e.s_contribute_regular = 'Yes'  THEN  1 ELSE 0 END) AS saving_count_rich,

    //             SUM(CASE WHEN (p.fp_wealth_rank = 'very poor' OR p.fp_wealth_rank = 'destitute') AND e.s_contribute_regular = 'Yes' THEN  1  ELSE 0 END)/COUNT(a.id)*100 AS saving_count_very_poor_per,
    //             SUM(CASE WHEN p.fp_wealth_rank = 'poor' AND e.s_contribute_regular = 'Yes'  THEN  1 ELSE 0 END)/COUNT(a.id)*100 AS saving_count_poor_per,
    //             SUM(CASE WHEN p.fp_wealth_rank = 'medium poor' AND e.s_contribute_regular = 'Yes'  THEN  1 ELSE 0 END)/COUNT(a.id)*100 AS saving_count_medium_poor_per,
    //             SUM(CASE WHEN p.fp_wealth_rank = 'rich' AND e.s_contribute_regular = 'Yes'  THEN  1 ELSE 0 END)/COUNT(a.id)*100 AS saving_count_rich_per

    //             FROM
    //                 family_mst AS a
    //                 INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                 INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //                 INNER JOIN family_savings_source AS e ON p.family_sub_mst_id = e.family_sub_mst_id
    //             WHERE
    //                 a.is_deleted = 0
    //                 AND a.id IN ($family_ids) ";
    //                 $data['family_savings_by_wealth_rank']= DB::select($query);
    //                 // prd($data['family_savings_by_wealth_rank']);

    //                 // family saving %

    //                 $query="SELECT


    //                 SUM(CASE WHEN  e.s_type = 'Compulsory' AND e.s_contribute_regular = 'Yes' THEN 1 ELSE 0 END ) as compalsory_count,
    //                 SUM(CASE WHEN  e.s_type = 'Voluntary' AND e.s_contribute_regular = 'Yes' THEN 1 ELSE 0 END ) as voluntary_count,
    //                  SUM(CASE WHEN  e.s_type = 'Compulsory' AND e.s_contribute_regular = 'Yes' THEN 1 ELSE 0 END )/COUNT(a.id)*100 as compalsory_count_per,
    //                 SUM(CASE WHEN  e.s_type = 'Voluntary' AND e.s_contribute_regular = 'Yes' THEN 1 ELSE 0 END )/COUNT(a.id)*100 as voluntary_count_per

    //                FROM
    //                    family_mst AS a
    //                    INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                    INNER JOIN family_savings_source AS e ON b.family_mst_id = e.family_sub_mst_id
    //                WHERE
    //                    a.is_deleted = 0
    //                    AND a.id  IN ($family_ids)";
    //                    $data['family_savings'] = DB::select($query);
    //                 //    prd($data['family_savings']);

    //                 // family other saving

    //                 $query="SELECT

    //                 SUM(a.no_of_hh_other) AS no_of_hh_other,
    //                 SUM(a.no_of_hh_other)  / COUNT(a.id) * 100 no_of_hh_other_per
    //                 FROM (
    //                 SELECT
    //                   a.id,
    //                  CASE WHEN (e.other_loan != '' ) THEN  1  ELSE 0 END AS no_of_hh_other

    //                 FROM
    //                     family_mst AS a
    //                     INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                     INNER JOIN family_savings_source_other AS e ON b.family_mst_id = e.family_sub_mst_id
    //                 WHERE
    //                     a.is_deleted = 0
    //                     AND a.id IN ($family_ids) GROUP BY a.id ) a ";

    //                     $data['family_saving_other'] = DB::select($query);

    //                     // prd($data['family_saving_other']);

    //                     // family loan number by wealth rank

    //                     $query="SELECT

    //                    SUM(CASE WHEN (p.fp_wealth_rank = 'very poor' OR p.fp_wealth_rank = 'destitute') AND e.lo_principle_amount !='' THEN  1  ELSE 0 END ) AS very_poor_no_of_hh,
    //                    SUM(CASE WHEN p.fp_wealth_rank = 'poor' AND e.lo_principle_amount !=''  THEN  1  ELSE 0 END ) AS poor_no_of_hh,
    //                    SUM(CASE WHEN p.fp_wealth_rank = 'medium poor' AND e.lo_principle_amount !=''  THEN  1  ELSE 0 END ) AS medium_poor_no_of_hh,
    //                    SUM(CASE WHEN p.fp_wealth_rank = 'rich' AND e.lo_principle_amount !='' THEN  1  ELSE 0 END ) AS rich_no_of_hh,
    //                    SUM(CASE WHEN (p.fp_wealth_rank = 'very poor' OR p.fp_wealth_rank = 'destitute') AND e.lo_principle_amount !='' THEN  1  ELSE 0 END )/SUM(CASE WHEN e.lo_principle_amount !=''  THEN  1  ELSE 0 END )*100 AS very_poor_no_of_hh_per,
    //                     SUM(CASE WHEN p.fp_wealth_rank = 'poor' AND e.lo_principle_amount !=''  THEN  1  ELSE 0 END ) /SUM(CASE WHEN e.lo_principle_amount !=''  THEN  1  ELSE 0 END )*100 AS poor_no_of_hh_per,
    //                     SUM(CASE WHEN p.fp_wealth_rank = 'medium poor' AND e.lo_principle_amount !=''  THEN  1  ELSE 0 END )/SUM(CASE WHEN e.lo_principle_amount !=''  THEN  1  ELSE 0 END )*100 AS medium_poor_no_of_hh_per,
    //                     SUM(CASE WHEN p.fp_wealth_rank = 'rich' AND e.lo_principle_amount !='' THEN  1  ELSE 0 END )/SUM(CASE WHEN e.lo_principle_amount !=''  THEN  1  ELSE 0 END )*100 AS rich_no_of_hh_per,

    //                     SUM(CASE WHEN p.fp_wealth_rank = 'very poor' OR p.fp_wealth_rank = 'destitute' THEN  e.lo_principle_amount  ELSE 0 END ) AS very_poor_loan_amount,
    //                     SUM(CASE WHEN p.fp_wealth_rank = 'poor'  THEN  e.lo_principle_amount  ELSE 0 END ) AS very_poor_amount,
    //                     SUM(CASE WHEN p.fp_wealth_rank = 'medium poor'  THEN  e.lo_principle_amount  ELSE 0 END ) AS medium_poor_loan_amount,
    //                     SUM(CASE WHEN p.fp_wealth_rank = 'rich'  THEN  e.lo_principle_amount  ELSE 0 END ) AS rich_loan_amount


    //                         FROM
    //                             family_mst AS a
    //                             INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                             INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //                             INNER JOIN family_loan_outstanding AS e ON p.family_sub_mst_id = e.family_sub_mst_id
    //                     WHERE
    //                         a.is_deleted = 0
    //                         AND a.id  IN ($family_ids)";
    //                         $data['family_loan_hh_average'] = DB::select($query);

    //                         // prd($data['family_loan_hh']);


    //                         // family loan no

    //                         $query="SELECT
    //                         SUM(a.shg_loan_no) AS shg_loan_no,
    //                         SUM(a.federation_loan_no) AS federation_loan_no,
    //                         SUM(a.cluster_loan_no) AS cluster_loan_no,
    //                         SUM(a.bank_loan_no) AS bank_loan_no,
    //                         SUM(a.money_loan_no) AS money_loan_no,
    //                         SUM(a.other_loan_no) AS other_loan_no,
    //                         SUM(a.vi_loan_no) AS vi_loan_no


    //                     FROM (
    //                     SELECT

    //                      a.id,
    //                      e.lo_type,
    //                      CASE WHEN e.lo_type = 'SHG Loan' THEN  1  ELSE 0 END  AS shg_loan_no,
    //                      CASE WHEN e.lo_type = 'Federation Loan' THEN  1  ELSE 0 END  AS federation_loan_no,
    //                      CASE WHEN e.lo_type = 'Cluster Loan' THEN  1  ELSE 0 END  AS cluster_loan_no,
    //                      CASE WHEN e.lo_type = 'Bank Loan' THEN  1  ELSE 0 END  AS bank_loan_no,
    //                      CASE WHEN e.lo_type = 'Money Lenders Loan' THEN  1  ELSE 0 END  AS money_loan_no,
    //                      CASE WHEN e.lo_type = 'Other Private Loan' THEN  1  ELSE 0 END  AS other_loan_no,
    //                       CASE WHEN e.lo_type = 'VI Loan' THEN  1  ELSE 0 END  AS vi_loan_no

    //                     FROM
    //                         family_mst AS a
    //                         INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                         INNER JOIN family_loan_outstanding AS e ON b.family_mst_id = e.family_sub_mst_id
    //                     WHERE
    //                         a.is_deleted = 0
    //                         AND a.id IN ($family_ids)   GROUP BY a.id,e.lo_type ) a";
    //                         $family_loans_no = DB::select($query);

    //                         $shg_loan_no = $family_loans_no[0]->shg_loan_no ;
    //                         $federation_loan_no = $family_loans_no[0]->federation_loan_no ;
    //                         $cluster_loan_no = $family_loans_no[0]->cluster_loan_no ;
    //                         $bank_loan_no = $family_loans_no[0]->bank_loan_no ;
    //                         $money_loan_no = $family_loans_no[0]->money_loan_no ;
    //                         $other_loan_no = $family_loans_no[0]->other_loan_no ;
    //                         $vi_loan_no = $family_loans_no[0]->vi_loan_no ;
    //                         $query="SELECT

    //                         sum(CASE WHEN e.lo_type = 'SHG Loan' THEN  e.lo_principle_amount  ELSE 0 END)/ $shg_loan_no  AS shg_loan_amount_avg,
    //                         sum(CASE WHEN e.lo_type = 'Federation Loan' THEN  e.lo_principle_amount  ELSE 0 END )/$federation_loan_no AS federation_loan_amount_avg,
    //                         sum(CASE WHEN e.lo_type = 'Cluster Loan' THEN  e.lo_principle_amount  ELSE 0 END)/$cluster_loan_no  AS cluster_loan_amount_avg,
    //                         sum(CASE WHEN e.lo_type = 'Bank Loan' THEN  e.lo_principle_amount  ELSE 0 END)/ $bank_loan_no  AS bank_loan_amount_avg,
    //                         sum(CASE WHEN e.lo_type = 'Money Lenders Loan' THEN  e.lo_principle_amount  ELSE 0 END)/$money_loan_no  AS money_loan_amount_avg,
    //                         sum(CASE WHEN e.lo_type = 'Other Private Loan' THEN  e.lo_principle_amount  ELSE 0 END)/$other_loan_no  AS other_loan_amount_avg,
    //                         sum(CASE WHEN e.lo_type = 'VI Loan' THEN  e.lo_principle_amount  ELSE 0 END)/$vi_loan_no  AS vi_loan_amount_avg,

    //                         sum(CASE WHEN e.lo_type = 'SHG Loan' THEN  e.lo_interest_rate  ELSE 0 END)/ $shg_loan_no  AS shg_loan_interest,
    //                         sum(CASE WHEN e.lo_type = 'Federation Loan' THEN  e.lo_interest_rate  ELSE 0 END )/$federation_loan_no AS federation_loan_interest,
    //                         sum(CASE WHEN e.lo_type = 'Cluster Loan' THEN  e.lo_interest_rate  ELSE 0 END)/$cluster_loan_no  AS cluster_loan_interest,
    //                         sum(CASE WHEN e.lo_type = 'Bank Loan' THEN  e.lo_interest_rate  ELSE 0 END)/ $bank_loan_no  AS bank_loan_interest,
    //                         sum(CASE WHEN e.lo_type = 'Money Lenders Loan' THEN  e.lo_interest_rate  ELSE 0 END)/$money_loan_no  AS money_loan_interest,
    //                         sum(CASE WHEN e.lo_type = 'Other Private Loan' THEN  e.lo_interest_rate  ELSE 0 END)/$other_loan_no  AS other_loan_interest,
    //                         sum(CASE WHEN e.lo_type = 'VI Loan' THEN  e.lo_interest_rate  ELSE 0 END)/$vi_loan_no  AS vi_loan_interest

    //                        FROM
    //                            family_mst AS a
    //                            INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                            INNER JOIN family_loan_outstanding AS e ON b.family_mst_id = e.family_sub_mst_id
    //                        WHERE
    //                            a.is_deleted = 0
    //                            AND a.id IN ($family_ids)";

    //                            $data['family_laon_avg']=DB::select($query);

    //                         //    prd($data['family_laon_avg']);



    //                         // family loan purpose

    //                         $query ="SELECT
    //                         a.id,
    //                            p.fp_member_name AS name ,
    //                            a.uin AS uin ,
    //                            e.lo_purpose AS purpose,
    //                            e.lo_principle_amount AS amount

    //                         FROM
    //                             family_mst AS a
    //                             INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                             INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //                             INNER JOIN family_loan_outstanding AS e ON b.family_mst_id = e.family_sub_mst_id
    //                         WHERE
    //                             a.is_deleted = 0 AND e.lo_principle_amount > 0
    //                             AND a.id IN ($family_ids) ";

    //                             $data['family_loan_purpose'] = DB::select($query);

    //                             // family loan number

    //                             $query="SELECT sum(a.COUNT) AS count FROM  (SELECT
    //                             family_sub_mst_id,
    //                             case when lo_principle_amount >0 then 1 ELSE 0 END AS COUNT

    //                             FROM family_loan_outstanding WHERE lo_principle_amount >0 AND family_sub_mst_id IN


    //                             ($family_ids) GROUP BY family_sub_mst_id ) a";
    //                             $family_loan_count = DB::select($query)[0]->count;

    //                             // family number of loan

    //                             $query="SELECT
    //                             SUM(case when a.count = 1 then 1 ELSE 0 END ) AS one_loan,
    //                             SUM(case when a.count = 2 then 1 ELSE 0 END ) AS two_loan,
    //                             SUM(case when a.count = 3 then 1 ELSE 0 END ) AS three_loan,
    //                             SUM(case when a.count >= 4 then 1 ELSE 0 END ) AS four_loan,

    //                             SUM(case when a.count = 1 then 1 ELSE 0 END )/$family_loan_count*100 AS one_loan_per,
    //                             SUM(case when a.count = 2 then 1 ELSE 0 END )/$family_loan_count*100 AS two_loan_per,
    //                             SUM(case when a.count = 3 then 1 ELSE 0 END )/$family_loan_count*100 AS three_loan_per,
    //                             SUM(case when a.count >= 4 then 1 ELSE 0 END )/$family_loan_count*100 AS four_loan_per
    //                        FROM (
    //                        SELECT
    //                        a.id,
    //                        SUM(case when e.lo_principle_amount > 0 then 1 ELSE NULL END) AS count

    //                        FROM
    //                            family_mst AS a
    //                            INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                            INNER JOIN family_loan_outstanding AS e ON b.family_mst_id = e.family_sub_mst_id
    //                             WHERE family_sub_mst_id IN ($family_ids) GROUP BY a.id ) a";

    //                             $data['family_loan_number'] = DB::select($query);

    //                             // prd($data['family_loan_number']);

    //                              // family number of loan

    //                              $query="SELECT
    //                                 SUM(case when a.count >= 5000 AND a.count <= 50000  then 1 ELSE 0 END ) AS loan_5k_50k,
    //                                 SUM(case when a.count > 50000 AND a.count <= 100000  then 1 ELSE 0 END ) AS loan_50k_1l,
    //                                 SUM(case when a.count > 100000 AND a.count <= 200000  then 1 ELSE 0 END ) AS loan_1l_2l,
    //                                 SUM(case when a.count > 200000 AND a.count <= 300000  then 1 ELSE 0 END ) AS loan_2l_3l,
    //                                 SUM(case when a.count > 300000 AND a.count <= 400000  then 1 ELSE 0 END ) AS loan_3l_4l,
    //                                 SUM(case when a.count > 400000 AND a.count <= 500000  then 1 ELSE 0 END ) AS loan_4l_5l,
    //                                 SUM(case when a.count > 500000 then 1 ELSE 0 END ) AS loan_greter_5l,

    //                                 SUM(case when a.count >= 5000 AND a.count <= 50000  then 1 ELSE 0 END )/$family_loan_count*100 AS loan_5k_50k_per,
    //                                 SUM(case when a.count > 50000 AND a.count <= 100000  then 1 ELSE 0 END )/$family_loan_count*100 AS loan_50k_1l_per,
    //                                 SUM(case when a.count > 100000 AND a.count <= 200000  then 1 ELSE 0 END )/$family_loan_count*100 AS loan_1l_2l_per,
    //                                 SUM(case when a.count > 200000 AND a.count <= 300000  then 1 ELSE 0 END )/$family_loan_count*100 AS loan_2l_3l_per,
    //                                 SUM(case when a.count > 300000 AND a.count <= 400000  then 1 ELSE 0 END )/$family_loan_count*100 AS loan_3l_4l_per,
    //                                 SUM(case when a.count > 400000 AND a.count <= 500000  then 1 ELSE 0 END )/$family_loan_count*100 AS loan_4l_5l_per,
    //                                 SUM(case when a.count > 500000 then 1 ELSE 0 END )/$family_loan_count*100 AS loan_greter_5l_per
    //                             FROM (
    //                             SELECT
    //                             a.id,
    //                             SUM(case when e.lo_principle_amount > 0 then e.lo_principle_amount ELSE NULL END) AS count

    //                         FROM
    //                             family_mst AS a
    //                             INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                             INNER JOIN family_loan_outstanding AS e ON b.family_mst_id = e.family_sub_mst_id
    //                              WHERE family_sub_mst_id IN ($family_ids) GROUP BY a.id ) a";

    //                              $data['family_loan_amoiunt'] = DB::select($query);


    //                             //  family jwelery loan count
    //                             $query="SELECT
    //                             COUNT(family_sub_mst_id)  AS count

    //                          FROM
    //                              family_mst AS a
    //                              INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                              INNER JOIN family_assets AS e ON b.family_mst_id = e.family_sub_mst_id
    //                          WHERE
    //                              a.is_deleted = 0 AND e.jewelry_pawned_take_loan_yesno = 'yes' and family_sub_mst_id IN


    //                             ($family_ids) ";
    //                             $family_jewelry_loan_count = DB::select($query)[0]->count;

    //                              $query="SELECT
    //                                 SUM(case when e.jewelry_pawned_loan_amount >= 5000 AND e.jewelry_pawned_loan_amount <= 50000  then 1 ELSE 0 END ) AS pawn_amount_5k_50k,
    //                                 SUM(case when e.jewelry_pawned_loan_amount > 50000 AND e.jewelry_pawned_loan_amount <= 100000  then 1 ELSE 0 END ) AS pawn_amount_50k_1l,
    //                                 SUM(case when e.jewelry_pawned_loan_amount > 100000 AND e.jewelry_pawned_loan_amount <= 200000  then 1 ELSE 0 END ) AS pawn_amount_1l_2l,
    //                                 SUM(case when e.jewelry_pawned_loan_amount > 200000 AND e.jewelry_pawned_loan_amount <= 400000  then 1 ELSE 0 END ) AS pawn_amount_2l_4l,
    //                                 SUM(case when e.jewelry_pawned_loan_amount > 400000 then 1 ELSE 0 END ) AS pawn_amount_greter_4l,

    //                                 SUM(case when e.jewelry_pawned_loan_amount >= 5000 AND e.jewelry_pawned_loan_amount <= 50000  then 1 ELSE 0 END )/$family_jewelry_loan_count*100 AS pawn_amount_5k_50k_per,
    //                                 SUM(case when e.jewelry_pawned_loan_amount > 50000 AND e.jewelry_pawned_loan_amount <= 100000  then 1 ELSE 0 END )/$family_jewelry_loan_count*100 AS pawn_amount_50k_1l_per,
    //                                 SUM(case when e.jewelry_pawned_loan_amount > 100000 AND e.jewelry_pawned_loan_amount <= 200000  then 1 ELSE 0 END )/$family_jewelry_loan_count*100 AS pawn_amount_1l_2l_per,
    //                                 SUM(case when e.jewelry_pawned_loan_amount > 200000 AND e.jewelry_pawned_loan_amount <= 400000  then 1 ELSE 0 END )/$family_jewelry_loan_count*100 AS pawn_amount_2l_4l_per,
    //                                 SUM(case when e.jewelry_pawned_loan_amount > 400000 then 1 ELSE 0 END )/$family_jewelry_loan_count*100 AS pawn_amount_greter_4l_per
    //                                 FROM
    //                                     family_mst AS a
    //                                     INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                                     INNER JOIN family_assets AS e ON b.family_mst_id = e.family_sub_mst_id
    //                                     WHERE family_sub_mst_id IN ($family_ids)";

    //                                     $data['family_pawned_loan_amount'] = DB::select($query);

    //                                     // prd($data['family_pawned_loan_amount']);

    //                                     // family pawned amoung lost
    //                                     $query="SELECT
    //                             COUNT(family_sub_mst_id)  AS lost_amount,
    //                             count(family_sub_mst_id)/$family_jewelry_loan_count*100 as lost_amount_per

    //                          FROM
    //                              family_mst AS a
    //                              INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                              INNER JOIN family_assets AS e ON b.family_mst_id = e.family_sub_mst_id
    //                          WHERE
    //                              a.is_deleted = 0 AND e.jewelry_pawned_lost_yesno = 'Yes' and family_sub_mst_id IN


    //                             ($family_ids) ";
    //                             $data['family_loan_lost_count'] = DB::select($query);

    //                             // family lost amount type

    //                             $query="SELECT
    //                             COUNT(family_sub_mst_id)  AS lost_amount_type,
    //                             count(family_sub_mst_id)/$family_jewelry_loan_count*100 as lost_amount_type_per

    //                          FROM
    //                              family_mst AS a
    //                              INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                              INNER JOIN family_assets AS e ON b.family_mst_id = e.family_sub_mst_id
    //                          WHERE
    //                              a.is_deleted = 0 AND e.jewelry_pawned_lander_lost_type != 'Bank' and family_sub_mst_id IN


    //                             ($family_ids) ";
    //                             $data['family_loan_lost_type'] = DB::select($query);


    //                             // family have buisness plan

    //                             $query="SELECT count(date_of_business_plan) as count FROM family_business_investment_plan WHERE family_sub_mst_id IN ($family_ids) AND date_of_business_plan !='' ";
    //                             $family_plan_count = DB::select($query)[0]->count;


    //                             $query="SELECT

    //                             SUM(case when p.analysis_rating >= 90 AND e.date_of_business_plan !='' then 1 ELSE 0 END ) green_buisness_plan,
    //                             SUM(case when (p.analysis_rating >= 75 AND p.analysis_rating < 90)  AND e.date_of_business_plan !='' then 1 ELSE 0 END ) yellow_buisness_plan,
    //                             SUM(case when (p.analysis_rating >= 60 AND p.analysis_rating < 75) AND e.date_of_business_plan !='' then 1 ELSE 0 END ) grey_buisness_plan,
    //                             SUM(case when (p.analysis_rating < 60  AND e.date_of_business_plan ) AND e.date_of_business_plan !='' then 1 ELSE 0 END ) red_buisness_plan,

    //                             SUM(case when p.analysis_rating >= 90 AND e.date_of_business_plan !='' then 1 ELSE 0 END )/$family_plan_count*100 green_buisness_plan_per,
    //                             SUM(case when (p.analysis_rating >= 75 AND p.analysis_rating < 90)  AND e.date_of_business_plan !='' then 1 ELSE 0 END )/$family_plan_count*100 yellow_buisness_plan_per,
    //                             SUM(case when (p.analysis_rating >= 60 AND p.analysis_rating < 75) AND e.date_of_business_plan !='' then 1 ELSE 0 END )/$family_plan_count*100 grey_buisness_plan_per,
    //                             SUM(case when (p.analysis_rating < 60  AND e.date_of_business_plan ) AND e.date_of_business_plan !='' then 1 ELSE 0 END )/$family_plan_count*100 red_buisness_plan_per
    //                         FROM
    //                             family_mst AS a
    //                             INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                             INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //                             INNER JOIN family_business_investment_plan AS e ON b.family_mst_id = e.family_sub_mst_id
    //                         WHERE
    //                             a.is_deleted = 0
    //                             AND a.id IN ($family_ids)";
    //                             $data['family_business_plan_count'] = DB::select($query);


    //                             // family loan requirment

    //                             $query="SELECT sum(r.principal) as count
    //                             FROM
    //                                 family_mst AS a
    //                                 INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                                 INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //                                 INNER JOIN family_business_investment_plan AS e ON b.family_mst_id = e.family_sub_mst_id
    //                                 INNER JOIN family_loan_repayment AS r ON b.family_mst_id = r.family_sub_mst_id
    //                                 WHERE
    //                             a.is_deleted = 0
    //                             AND  e.date_of_business_plan !='' and  a.id IN ($family_ids) ";
    //                             $family_plan_count = DB::select($query)[0]->count;


    //                             $query="SELECT

    //                             SUM(case when p.analysis_rating >= 90 AND e.date_of_business_plan !='' then r.principal ELSE 0 END ) green_buisness_plan_amount,
    //                             SUM(case when (p.analysis_rating >= 75 AND p.analysis_rating < 90)  AND e.date_of_business_plan !='' then r.principal ELSE 0 END ) yellow_buisness_plan_amount,
    //                             SUM(case when (p.analysis_rating >= 60 AND p.analysis_rating < 75) AND e.date_of_business_plan !='' then r.principal ELSE 0 END ) grey_buisness_plan_amount,
    //                             SUM(case when (p.analysis_rating < 60  AND e.date_of_business_plan ) AND e.date_of_business_plan !='' then r.principal ELSE 0 END ) red_buisness_plan_amount,

    //                             SUM(case when p.analysis_rating >= 90 AND e.date_of_business_plan !='' then r.principal ELSE 0 END )/$family_plan_count*100 green_buisness_plan_amount_per,
    //                             SUM(case when (p.analysis_rating >= 75 AND p.analysis_rating < 90)  AND e.date_of_business_plan !='' then r.principal ELSE 0 END )/$family_plan_count*100 yellow_buisness_plan_amount_per,
    //                             SUM(case when (p.analysis_rating >= 60 AND p.analysis_rating < 75) AND e.date_of_business_plan !='' then r.principal ELSE 0 END )/$family_plan_count*100 grey_buisness_plan_amount_per,
    //                             SUM(case when (p.analysis_rating < 60  AND e.date_of_business_plan ) AND e.date_of_business_plan !='' then r.principal ELSE 0 END )/$family_plan_count*100 red_buisness_plan_amount_per
    //                         FROM
    //                             family_mst AS a
    //                             INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                             INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //                             INNER JOIN family_business_investment_plan AS e ON b.family_mst_id = e.family_sub_mst_id
    //                             INNER JOIN family_loan_repayment AS r ON b.family_mst_id = r.family_sub_mst_id
    //                         WHERE
    //                             a.is_deleted = 0
    //                             AND a.id IN ($family_ids)";
    //                             $data['family_business_plan_amount'] = DB::select($query);

    //                             // prd($data['family_business_plan_amount']);


    //                             // family Purpose for Business Plans/Credit requirement

    //                             $query="SELECT
    //                             p.fp_member_name as name,
    //                             a.uin as uin ,
    //                             e.type_of_business as purpose,
    //                             r.principal as amount
    //                             FROM
    //                                 family_mst AS a
    //                                 INNER JOIN family_sub_mst AS b ON a.id = b.family_mst_id
    //                                 INNER JOIN family_profile AS p ON b.family_mst_id = p.family_sub_mst_id
    //                                 INNER JOIN family_business_investment_plan AS e ON b.family_mst_id = e.family_sub_mst_id
    //                                 INNER JOIN family_loan_repayment AS r ON b.family_mst_id = r.family_sub_mst_id

    //                              WHERE a.id  IN ($family_ids) AND e.date_of_business_plan !=''";
    //                              $data['family_business_purpose'] = DB::select($query);




























































        }

        return view('summary.view')->with($data);
    }


    function federation_analysis($fed_id){
            $profile = DB::table('federation_profile as a')
                    ->where('is_deleted', '=', 0)
                    ->where('a.federation_sub_mst_id', '=', $fed_id)
                    ->get()->toArray();

            $governance = DB::table('federation_governance as a')
                    ->where('is_deleted', '=', 0)
                    ->where('a.federation_sub_mst_id', '=', $fed_id)
                    ->get()->toArray();
            $analysis = DB::table('federation_analysis as a')
                    ->where('is_deleted', '=', 0)
                    ->where('a.federation_sub_mst_id', '=', $fed_id)
                    ->get()->toArray();
            $query ="SELECT federation_sub_mst_id as id FROM federation_analysis where federation_sub_mst_id = $fed_id";
            $data['id'] = DB::select($query)[0]->id;

            $query ="SELECT name_of_federation as name FROM federation_profile where federation_sub_mst_id = $fed_id";
            $data['fed_name'] = DB::select($query)[0]->name;


            //analysis 1
            $count = 0;
            $show1 = '';
            $analysis_1 = '';
            if(!empty($governance)){
                if (($governance[0]->last_two_election_conducted) == 'Yes') {
                    $count += 1;
                }

                if (($governance[0]->last_two_election_conducted_2nd) == 'Yes') {
                    $count += 1;
                }

                if (($governance[0]->last_two_election_conducted_3rd) == 'Yes') {
                    $count += 1;
                }
            }


            if ($count != 0) {
                $analysis_1 = $count == 3 ? 4 : ($count == 2 ? 3 : ($count == 1 ? 1 : 0));

                // $show1 = $count == 3 ? 'green' : ($count == 2 ? 'yellow' : ($count == 1 ? 'grey' : 'red'));
            } else {
                $analysis_1 = 0;
                $x1 = ($analysis_1 * 100) / 4;
                // $show1 = $x1 >= 90 ? 'green' : ($x1 >= 75 ? 'yellow' : ($x1 >= 60 ? 'grey' : 'red'));
            }
            $data['regular_election'] = $analysis_1;

            //analysis 2
            $count1 = '';
            $show2 = '';
            $analysis_2 = '';
            $average = $analysis[0]->average_metting_attendance;

            if ($average != '') {
                $count1 = (($average >= 90 ? 5 : ($average >= 75 ? 4 : ($average >= 60 ? 3 : 1))));
                $analysis_2 = $count1;
                if ($average >= 100) {
                    $show2 = 'green';
                } elseif ($average >= 80 && $average <= 99) {
                    $show2 = 'yellow';
                } elseif ($average >= 60 && $average <= 79) {
                    $show2 = 'grey';
                } elseif ($average < 59) {
                    $show2 = 'red';
                }
            } else {
                $analysis_2 = 0;
                $show2 = 'red';
            }
            $data['average_metting'] = $analysis_2;

            //analysis 3
            $count3 = $analysis[0]->federation_book_updation;

            $analysis_3 = '';
            $show3 = '';
            if ($count3 != '') {
                $analysis_3 = $count3 == 'Fully updated' ? 8 : ($count3 == 'Partially updated' ? 4 : ($count == 'Cash book only updated' ? 2 : 0));
                if ($count3 == 'Fully updated') {
                    $show3 = 'green';
                } elseif ($count3 == 'Partially updated') {
                    $show3 = 'yellow';
                }elseif ($count3 == 'Cash book only updated') {
                    $show3 = 'grey';
                }
                elseif ($count3 == 'Books not updated') {
                    $show3 = 'red';
                }
            } else {
                $analysis_3 = 0;
                $show3 = 'red';
            }
            $data['fed_book'] = $analysis_3;

            //analysis 4
            $count4 = $analysis[0]->federation_annual_plan_and_budget_approval;
            $analysis_4 = '';
            $show4 = '';

            if ($count4 != '') {
                $analysis_4 = $count4 == 'Yes' ? 3 : 0;
                if ($count4 == 'Yes') {
                    $show4 = 'green';
                } elseif ($count4 == 'No') {
                    $show4 = 'red';
                }
            } else {
                $analysis_4 = 0;
                $show4 = 'red';
            }

            //analysis 5

            $count5 = '';
            $analysis_5 = '';
            $show5 = '';
            $average_result = (int) $analysis[0]->achievement_last_year_annual_plan;

            if ($average_result != '') {
                $average1 = $average_result * 20;
                $count5 = (($average1 > 60 ? 2 : ($average1 >= 50 ? 1 : 0)));

                $analysis_5 = $count5;

                if ($average_result > 3) {
                    $show5 = 'green';
                } else if ($average_result >= 2 && $average_result <= 3) {
                    $show5 = 'yellow';
                } else if ($average_result == 1) {
                    $show5 = 'grey';
                } else if ($average_result == 0) {
                    $show5 = 'red';
                }
            } else {
                $analysis_5 = '--';
                $show5 = '';
            }

            //analysis 6
            $result = $analysis[0]->grade_federation_obtained_during_last_1_year;
            $analysis_6 = '';
            $show6 = '';

            // if ($result != '') {
            //     $analysis_6 = $result == 'A' ? 3 : ($result == 'B' ? 2 : ($result == 'C' ? 1 : 0));
            //     $x6 = ($analysis_6 * 100) / 3;
            //     if ($result == 'A') {
            //         $show6 = 'green';
            //     }
            //     if ($result == 'B') {
            //         $show6 = 'yellow';
            //     }
            //     if ($result == 'C') {
            //         $show6 = 'grey';
            //     }
            //     if ($result == 'D') {
            //         $show6 = 'red';
            //     }
            // } else {
            //     $analysis_6 = 0;
            //     $show6 = 'red';
            // }

            //analysis 7
            $analysis_7 = '';
            $show7 = '';

            $nine_b = $profile[0]->shg_at_time_creation;
            $ten_b = $profile[0]->total_SHGs;

            if ($nine_b != 0 || $nine_b > 0) {
                $diff = round((($nine_b - $ten_b) / $nine_b) * 100);
                if (($ten_b >= $nine_b) || ($diff <= 5)) {
                    $analysis_7 = 3;
                    $show7 = 'green';
                } elseif ($diff >= 6 && $diff <= 10) {
                    $analysis_7 = 2;
                    $show7 = 'yellow';
                } elseif ($diff >= 11 && $diff <= 20) {
                    $analysis_7 = 1;
                    $show7 = 'grey';
                } else {
                    $analysis_7 = 0;
                    $show7 = 'red';
                }
            } else {
                $analysis_7 = '--';
            }

            //analysis 8
            $result8 = $analysis[0]->last_year_audit_completed;
            $analysis_8 = '';
            $show8 = '';
            if ($result8 != '') {
                $analysis_8 = $result8 == 'Yes' ? 5 : 0;
                if ($result8 == 'Yes') {
                    $show8 = 'green';
                } elseif ($result8 == 'No') {
                    $show8 = 'red';
                }
            } else {
                $analysis_8 = 0;
                $show8 = 'red';
            }
            $data['fed_audit'] = $analysis_8;

            $total_1to8 = (float) $analysis_1 + (float) $analysis_2 + (float) $analysis_3 + (float) $analysis_4 + (float) $analysis_5 + (float) $analysis_7 + (float) $analysis_8;
            $x1to8 = ($total_1to8 * 100) / 30;
            // $data['score'] = $x1to8;
            $data['score'] = $x1to8 >= 90 ? 'green' : ($x1to8 >= 75 ? 'yellow' : ($x1to8 >= 60 ? 'grey' : 'red'));
            $count9 = 0;

            //analysis 9
            $result9 = (float) $analysis[0]->coverage_of_target_mobilization;
            $analysis_9 = '';
            $show9 = '';
            if ($result9 != 0) {
                $analysis_9 = ($result9 >= 80 ? 5 : ($result9 >= 60 ? 4 : ($result9 >= 40 ? 3 : 1)));
                if ($result9 >= 80 && $result9 <= 100) {
                    $show9 = 'green';
                } elseif ($result9 >= 60 && $result9 <= 79) {
                    $show9 = 'yellow';
                } elseif ($result9 >= 40 && $result9 <= 59) {
                    $show9 = 'grey';
                } elseif ($result9 < 40) {
                    $show9 = 'red';
                }
            } else {
                $analysis_9 = 0;
                $show9 = 'red';
            }

            //analysis10
            $result10 = (float) $analysis[0]->per_of_poorest_families_benefiting;
            $analysis_10 = '';
            $show10 = '';

            if ($result10 != '') {
                $analysis_10 = $result10 > 75 ? 5 : ($result10 > 60 ? 4 : ($result10 > 30 ? 3 : 0));

                if ($result10 >= 75 && $result10 <= 100) {
                    $show10 = 'green';
                } elseif ($result10 >= 50 && $result10 <= 74) {
                    $show10 = 'yellow';
                } elseif ($result10 >= 30 && $result10 <= 49) {
                    $show10 = 'grey';
                } elseif ($result10 < 30) {
                    $show10 = 'red';
                }
            } else {
                $analysis_10 = 0;
                $show10 = 'red';
            }
            $data['fed_external_loan'] = $analysis_10;
            //analysis 11
            $result11 = (float) $analysis[0]->poorest_category_board_members;
            $analysis_11 = '';
            $show11 = '';

            if ($result11 != 0) {
                $analysis_11 = ($result11 >= 60 ? 5 : ($result11 >= 40 ? 4 : ($result11 >= 25 ? 3 : 1)));
                if ($result11 > 60) {
                    $show11 = 'green';
                } elseif ($result11 >= 40 && $result11 <= 59) {
                    $show11 = 'yellow';
                } elseif ($result11 >= 25 && $result11 <= 39) {
                    $show11 = 'grey';
                } elseif ($result11 < 25) {
                    $show11 = 'red';
                }
            } else {
                $analysis_11 = 0;
                $show11 = 'red';
            }
            $data['fed_leadership'] = $analysis_11;

            //total 9 to 11
            $total_9to11 = (float) $analysis_9 + (float) $analysis_10 + (float) $analysis_11;
            $x9to11 = ($total_9to11 * 100) / 15;
            // $data['score1'] = $x9to11;
            $data['score1'] = $x9to11 >= 90 ? 'green' : ($x9to11 >= 75 ? 'yellow' : ($x9to11 >= 60 ? 'grey' : 'red'));

            //analysis 12
            $result12 = $analysis[0]->time_taken_to_approve_loan;
            $analysis_12 = '';
            $show12 = '';

            if ($result12 != '') {
                $analysis_12 = $result12 <= 5 ? 5 : ($result12 <= 10 ? 4 : ($result12 <= 15 ? 3 : 1));
                if ($result12 <= 5) {
                    $show12 = 'green';
                } elseif ($result12 >= 6 && $result12 <= 10) {
                    $show12 = 'yellow';
                } elseif ($result12 >= 11 && $result12 <= 15) {
                    $show12 = 'grey';
                } elseif ($result12 > 15) {
                    $show12 = 'red';
                }
            } else {
                $analysis_12 = 0;
                $show12 = 'red';
            }
            $data['fed_taken_loan'] = $analysis_12;

            //analysis 13
            $count13 = '';
            $result13 = $analysis[0]->cost_per_active_client;
            $analysis_13 = '';
            $show13 = '';
            if ($result13 != '') {
                $count13 = ($result13 <= 2 ? 5 : ($result13 <= 3 ? 4 : ($result13 <= 5 ? 3 : 1)));
                $analysis_13 = $count13;
                if ($count13 == 5) {
                    $show13 = 'green';
                } elseif ($count13 == 4 ) {
                    $show13 = 'yellow';
                } elseif ($count13 == 3) {
                    $show13 = 'grey';
                } elseif ($count13 == 1) {
                    $show13 = 'red';
                }
            } else {
                $analysis_13 = '--';
                $show13 = '--';
            }

            //analysis 14
            $count14 = '';
            $result14 = $analysis[0]->operating_expense_ratio;
            $analysis_14 = '';
            $show14 = '';

            if ($result14 != '') {
                $count14 = ($result14 < 5 ? 5 : ($result14 <= 10 ? 4 : ($result14 <= 15 ? 3 : ($result14 > 15 ? 1 : 0))));
                $analysis_14 = $count14;
                if ($result14 <= 5) {
                    $show14 = 'green';
                } elseif ($result14 >= 6 && $result14 <= 10) {
                    $show14 = 'yellow';
                } elseif ($result14 >= 11 && $result14 <= 15) {
                    $show14 = 'grey';
                } elseif ($result14 > 15) {
                    $show14 = 'red';
                }
            } else {
                $analysis_14 = 0;
                $show14 = 'red';
            }
            $data['fed_cost_income_ratio'] = $analysis_14;

            //total 12 to 14
            $total_12to14 = (float) $analysis_12 + (float) $analysis_13 + (float) $analysis_14;
            $x12to14 = ($total_12to14 * 100) / 15;
            // $data['score2'] = $x12to14;
            $data['score2'] = $x12to14 >= 90 ? 'green' : ($x12to14 >= 75 ? 'yellow' : ($x12to14 >= 60 ? 'grey' : 'red'));

            $federation_profile = DB::table('federation_profile as a')
                    ->where('is_deleted', '=', 0)
                    ->where('a.federation_sub_mst_id', '=', $fed_id)
                    ->get()->toArray();


            $fed_formed = $federation_profile[0]->date_federation_was_found;
            $pattern = '/^\d{2}\/\d{2}\/\d{4}$/';


            if (preg_match($pattern, $fed_formed)) {
                $originalDate = DateTime::createFromFormat('d/m/Y', $fed_formed);

                $formattedDate = $originalDate->format('d/M/Y');
            }
            else{
                $formattedDate = $fed_formed;
            }

            $currentnewDate = new DateTime();
            $currentDate = strftime('%d/%b/%Y', $currentnewDate->getTimestamp());
            $date1 = DateTime::createFromFormat('d/M/Y', $formattedDate);
            $date2 = DateTime::createFromFormat('d/M/Y', $currentDate);

            // Calculate the difference
            $interval = $date1->diff($date2);
            // Get the difference in years, months, and days
            $years = $interval->y;
            // prd($years);
            //analysis 15
            $result15 = $analysis[0]->per_of_members_benefited_from_federation;
            $analysis_15 = '';
            $show15 = '';

            if ($result15 != '') {
                $analysis_15 = $result15 > 80 ? 5 : ($result15 > 60 ? 4 : ($result15 > 50 ? 3 : 1));
                if ($result15 >= 80 && $result15 <= 100) {
                    $show15 = 'green';
                } elseif ($result15 >= 60 && $result15 <= 79) {
                    $show15 = 'yellow';
                } elseif ($result15 >= 50 && $result15 <= 59) {
                    $show15 = 'grey';
                } elseif ($result15 < 50) {
                    $show15 = 'red';
                }
            } else {
                $analysis_15 =  (($years < 3 ? 5 : ($years <=5 ? 3 : ($years >5 ? 0 : 0))));
                if ($years < 3) {
                    $show15 = 'green';
                } elseif ($years >=3 && $years <= 5) {
                    $show15 = 'yellow';
                } elseif ($years >5 ) {
                    $show15 = 'red';
                }
            }

            //analysis 16
            $result16 = (float) (str_replace('%', '', $analysis[0]->repayment_rate_of_federation_loan));
            $analysis_16 = '';
            $show16 = '';

            if ($result16 != 0) {
                $analysis_16 = $result16 >= 95 ? 10 : ($result16 >= 80 ? 8 : ($result16 >= 70 ? 6 : 2));
                if ($result16 >= 95) {
                    $show16 = 'green';
                } elseif ($result16 >= 80 && $result16 <= 94) {
                    $show16 = 'yellow';
                } elseif ($result16 >= 70 && $result16 <= 79) {
                    $show16 = 'grey';
                } elseif ($result16 < 70) {
                    $show16 = 'red';
                }
            } else {
                $analysis_16 = 0;
                $show16 = 'red';
            }

            //analysis 17
            $result17 = (float) (str_replace('%', '', $analysis[0]->repayment_of_Bank_loan_by_the_federation));
            $analysis_17 = '';
            $show17 = '';

            if ($result17 != 0) {
                $analysis_17 = $result17 > 95 ? 5 : ($result17 >= 80 ? 4 : ($result17 > 70 ? 3 : 1));
                if ($result17 >= 95) {
                    $show17 = 'green';
                } elseif ($result17 >= 80 && $result17 <= 94) {
                    $show17 = 'yellow';
                } elseif ($result17 >= 70 && $result17 <= 79) {
                    $show17 = 'grey';
                } elseif ($result17 < 70) {
                    $show17 = 'red';
                }
            } else {
                $analysis_17 = '--';
            }

            //analysis 18
            $result18 = (float) $analysis[0]->federation_loan_PAR_90;
            $analysis_18 = '';
            $show18 = '';

            if ($result18 != '') {
                if ($result18 < 1) {
                    $analysis_18 = 5;
                    $show18 = 'green';
                }
                if ($result18 >= 1 && $result18 <= 5) {
                    $analysis_18 = 3;
                    $show18 = 'yellow';
                }
                if ($result18 > 5 && $result18 <= 10) {
                    $analysis_18 = 1;
                    $show18 = 'grey';
                }
                if ($result18 > 10) {
                    $analysis_18 = 1;
                    $show18 = 'red';
                }
            } else {
                $analysis_18 = 0;
                $show18 = 'red';
            }

            //analysis 19
            $result19 = (float) $analysis[0]->livelihood_purposes_of_all_loans;
            $analysis_19 = '';
            $show19 = '';
            if ($result19 != 0) {
                $analysis_19 = ($result19 >= 90 ? 3 : ($result19 >= 75 ? 2 : ($result19 >= 60 ? 1 : 0)));
                if ($result19 >= 90) {
                    $show19 = 'green';
                } elseif ($result19 >= 75 && $result19 <= 89) {
                    $show19 = 'yellow';
                } elseif ($result19 >= 60 && $result19 <= 74) {
                    $show19 = 'grey';
                } elseif ($result19 < 60) {
                    $show19 = 'red';
                }
            } else {
                $analysis_19 = 0;
                $show19 = 'red';
            }
            //analysis 20
            $count20 = '';
            // prd($analysis);
            $result20 = (float) $analysis[0]->rotation_of_funds;
        $analysis_20 = '';
            $show20 = '';
            if ($result20 != '') {
                $analysis_20 = ($result20 > 0.7) ? 2 : ((($result20 >= 0.5) && ($result20 <= 0.7)) ? 1 : 0);
                if ($result20 >= 0.7) {
                    $show20 = 'green';
                } elseif ($result20 >= 0.5 && $result20 <= 0.69) {
                    $show20 = 'yellow';
                } elseif ($result20 >= 0.4 && $result20 <= 0.59) {
                    $show20 = 'grey';
                } elseif ($result20 < 0.4) {
                    $show20 = 'red';
                }
            } else {
                $analysis_20 = 0;
                $show20 = 'red';
            }

            //total 15 to 20
            $total_15to20 = (float) $analysis_15 + (float) $analysis_16  + (float) $analysis_18 + (float) $analysis_19 + (float) $analysis_20;
            $x15to20 = ($total_15to20 * 100) / 25;
            // $data['score3'] = $x15to20;
            $data['score3'] = $x15to20 >= 90 ? 'green' : ($x15to20 >= 75 ? 'yellow' : ($x15to20 >= 60 ? 'grey' : 'red'));

            //analysis 21
            $result21 = $analysis[0]->does_federation_cover_own_income;
            $analysis_21 = '';
            $show21 = '';
            if ($result21 != '') {
                $analysis_21 = $result21 == 'Yes' ? 3 : 0;
                if ($result21 == "Yes") {
                    $show21 = 'green';
                } elseif ($result21 == "No") {
                    $show21 = 'red';
                }
            } else {
                $analysis_21 = 0;
                $show21 = 'red';
            }

            //analysis 22
            $result22 = $analysis[0]->loan_security_fund_established;
            $analysis_22 = '';
            $show22 = '';

            if ($result22 != '') {
                $analysis_22 = $result22 == 'Yes' ? 3 : 0;
                if ($result22 == "Yes") {
                    $show22 = 'green';
                } elseif ($result22 == "No") {
                    $show22 = 'red';
                }
            } else {
                $analysis_22 = 0;
                $show22 = 'red';
            }
            //total 21 to 22
            $total_21to22 = (float) $analysis_21 + (float) $analysis_22;
            $x21to22 = ($total_21to22 * 100) / 6;
            // $data['score4'] = $x21to22;
            $data['score4'] = $x21to22 >= 90 ? 'green' : ($x21to22 >= 75 ? 'yellow' : ($x21to22 >= 60 ? 'grey' : 'red'));

            //analysis 23
            $count23 = '';
            $result23 = (float) (str_replace('%', '', $analysis[0]->members_covered_under_life_insurance));
            $analysis_23 = '';
            $show23 = '';
            if ($result23 != 0) {
                $count23 = ($result23 >= 90 ? 3 : ($result23 >= 75 ? 2 : ($result23 >= 60 ? 1 : 0)));
                $analysis_23 = $count23;
                if ($result23 >= 90) {
                    $show23 = 'green';
                } elseif ($result23 >= 75 && $result23 <= 89) {
                    $show23 = 'yellow';
                } elseif ($result23 >= 60 && $result23 <= 74) {
                    $show23 = 'grey';
                } elseif ($result23 < 60) {
                    $show23 = 'red';
                }
            } else {
                $analysis_23 = 0;
                $show23 = 'red';
            }

            //analysis 24
            $count24 = '';
            $result24 = (float) (str_replace('%', '', $analysis[0]->availed_members_covered_loan_insurance));
            $analysis_24 = '';
            $show24 = '';
            if ($result24 != 0) {
                $count24 = $result24 >= 90 ? 3 : ($result24 >= 75 ? 2 : ($result24 >= 60 ? 1 : 0));
                $analysis_24 = $count24;
                if ($result24 >= 90) {
                    $show24 = 'green';
                } elseif ($result24 >= 75 && $result24 <= 89) {
                    $show24 = 'yellow';
                } elseif ($result24 >= 60 && $result24 <= 74) {
                    $show24 = 'grey';
                } elseif ($result24 < 60) {
                    $show24 = 'red';
                }
            } else {
                $analysis_24 = 0;
                $show24 = 'red';
            }

            //analysis 25
            $count25 = '';
            $result25 = (float) (str_replace('%', '', $analysis[0]->animals_insured_purchased));
            $analysis_25 = '';
            $show25 = '';
            if ($result25 != 0) {
                $count25 = $result25 >= 90 ? 3 : ($result25 >= 75 ? 2 : ($result25 >= 60 ? 1 : 0));
                $analysis_25 = $count25;
                if ($result25 >= 90) {
                    $show25 = 'green';
                } elseif ($result25 >= 75 && $result25 <= 89) {
                    $show25 = 'yellow';
                } elseif ($result25 >= 60 && $result25 <= 74) {
                    $show25 = 'grey';
                } elseif ($result25 < 60) {
                    $show25 = 'red';
                }
            } else {
                $analysis_25 = 0;
                $show25 = 'red';
            }
            //total 23 to 25
            $total_23to25 = (float) $analysis_23 + (float) $analysis_24 + (float) $analysis_25;
            $x23to25 = ($total_23to25 * 100) / 9;
            // $data['score5'] = $x23to25;
            $data['score5'] = $x23to25 >= 90 ? 'green' : ($x23to25 >= 75 ? 'yellow' : ($x23to25 >= 60 ? 'grey' : 'red'));

            // $data['analysis_final_total'] = $total_23to25 + $data['total_21to22'] + $data['total_15to20'] + $data['total_12to14'] + $data['total_9to11'] + $data['total_1to8'];
            // $xfinal = ($data['analysis_final_total'] * 100) / 100;
            // $data['show_final_total'] = $xfinal >= 90 ? 'green' : ($xfinal >= 75 ? 'yellow' : ($xfinal >= 60 ? 'grey' : 'red'));
            // $data['show_final_status'] = $data['show_final_total'] == 'green' ? 'Minimal Risk' : ($data['show_final_total'] == 'yellow' ? ' Low Risk' : ($data['show_final_total'] == 'grey' ? 'Moderate Risk' : 'High Risk'));


            return $data;
    }

    function  shg_analysis($shg_id)
    {
         $query=       "SELECT
        s.id,
        s.uin AS UIN,
        sp.shgName AS SHG_name,
        cp.name_of_cluster AS cluster,
        fedp.name_of_federation AS fedeartion,
        sp.analysis_rating AS Rating

        FROM
            federation_mst AS fed
            INNER JOIN federation_profile AS fedp
            ON fed.id = fedp.federation_sub_mst_id
            INNER JOIN
            cluster_mst AS c
            ON c.federation_uin = fed.uin
            INNER JOIN cluster_profile AS cp
            ON c.id = cp.cluster_sub_mst_id
            INNER JOIN shg_mst AS s
            ON c.uin = s.cluster_uin
            INNER JOIN shg_profile AS sp
            ON s.id = sp.shg_sub_mst_id


            WHERE c.is_deleted = 0 AND s.is_deleted = 0  and s.id = $shg_id
             ORDER  BY s.id";
            $data['shg_info'] = DB::select($query)[0];

        $query ="SELECT shgName as name FROM shg_profile where shg_sub_mst_id = $shg_id";
        $data['shg_name'] = DB::select($query)[0]->name;

        $data['analysis'] = DB::table('shg_analysis as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $shg_id)
            ->get()->toArray();

        $data['inclusion'] = DB::table('shg_inclusion as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $shg_id)
            ->get()->toArray();

        // analysis 1
        $x2 = $data['analysis'][0]->shg_average_participation;
        $data['analysis_data']['Average_participation_of'] = '';
        $data['analysis_data']['color1'] = '';

        if ($x2 != '') {
            $data['analysis_data']['Average_participation_of'] = ($x2 >= 90 ? 10 : ($x2 >= 75 ? 8 : ($x2 >= 60 ? 6 : 2)));
            $x4 = ($data['analysis_data']['Average_participation_of'] * 100) / 10;
            $data['analysis_data']['color1'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
        } else {
            $data['analysis_data']['Average_participation_of'] = 0;
            $data['analysis_data']['color1'] = 'red';
        }
        //  analysis 2
        $count3 = $data['analysis'][0]->shg_book_updation;
        $data['analysis_data']['shg_book_updation'] = '';
        $data['analysis_data']['color2'] = '';

        if ($count3 != '') {
            $data['analysis_data']['shg_book_updation'] = ($count3 == 'Fully updated' ? 10 : ($count3 == 'Mostly updated' ? 7 : ($count3 == 'Partially updated' ? 5 : ($count3 == 'Unsatisfactory recording' ? 2 : ($count3 == 'Book not updated' ? 0 : 0)))));

            if ($count3 == 'Fully updated') {
                $data['analysis_data']['color2'] = "green";
            } elseif ($count3 == 'Partially updated') {
                $data['analysis_data']['color2'] = "yellow";
            } elseif ($count3 == 'Books not updated') {
                $data['analysis_data']['color2'] = "red";
            }
        } else {
            $data['analysis_data']['shg_book_updation'] = 0;
            $data['analysis_data']['color2'] = 'red';
        }

        // analysis 3
        $count4 = $data['analysis'][0]->shg_grading_status;
        $data['analysis_data']['shg_grading_status'] = '';
        $data['analysis_data']['color4'] = '';

        if ($count4 != '') {

            $data['analysis_data']['shg_grading_status'] = ($count4 == 'A' ? 1 : ($count4 == 'B' ? 1 : ($count4 == 'C' ? 0 : 0)));
            if ($count4 == 'A') {
                $data['analysis_data']['color4'] = 'green';
            } elseif ($count4 == 'B') {
                $data['analysis_data']['color4'] = 'yellow';
            } elseif ($count4 == 'C') {
                $data['analysis_data']['color4'] = 'grey';
            } else {
                $data['analysis_data']['color4'] = 'red';
            }
        } else {
            $data['analysis_data']['shg_grading_status'] = 0;
            $data['analysis_data']['color4'] = 'red';
        }

        // analysis 4
        $x2 = (str_replace('%', '', $data['analysis'][0]->shg_percent_of_poorest_internal));
        $data['analysis_data']['shg_percent_of_poorest_internal'] = '';
        $data['analysis_data']['color6'] = '';

        if ($x2 != 0) {
            $data['analysis_data']['shg_percent_of_poorest_internal'] = (($x2 >= 80 ? 4 : ($x2 >= 60 ? 3 : ($x2 >= 40 ? 2 : 1))));
            if ($x2 >= 80) {
                $data['analysis_data']['color6'] = 'green';
            } elseif ($x2 >= 60 && $x2 <= 79) {
                $data['analysis_data']['color6'] = 'yellow';
            } elseif ($x2 >= 40 && $x2 <= 59) {
                $data['analysis_data']['color6'] = 'grey';
            } elseif ($x2 < 40) {
                $data['analysis_data']['color6'] = 'red';
            }
        } else {
            $data['analysis_data']['shg_percent_of_poorest_internal'] = 'N/A';
            $data['analysis_data']['color6'] = 'red';
        }

        // analysis 5
        $data['analysis_data']['shg_percent_of_poorest_other'] = '';
        $data['analysis_data']['color16'] = '';
        $x2 = $data['analysis'][0]->shg_percent_of_poorest_other;

        if ($x2 != 0) {
            $data['analysis_data']['shg_percent_of_poorest_other'] = (($x2 >= 80 ? 4 : ($x2 >= 60 ? 3 : ($x2 >= 40 ? 2 : 1))));
            if ($x2 >= 80) {
                $data['analysis_data']['color16'] = 'green';
            } elseif ($x2 >= 60 && $x2 <= 79) {
                $data['analysis_data']['color16'] = 'yellow';
            } elseif ($x2 >= 40 && $x2 <= 59) {
                $data['analysis_data']['color16'] = 'grey';
            } elseif ($x2 < 40) {
                $data['analysis_data']['color16'] = 'red';
            }
        } else {
            $data['analysis_data']['shg_percent_of_poorest_other'] = 'N/A';
            $data['analysis_data']['color16'] = 'red';
        }

        // analysis 6
        $x2 = $data['inclusion'][0]->no_of_leadership_poor;
        $data['analysis_data']['no_of_leadership_poor'] = '';
        $data['analysis_data']['color66'] = '';

        if ($x2 != '') {
            if ($x2 >= 3) {
                $data['analysis_data']['no_of_leadership_poor'] = 5;
                $data['analysis_data']['color66'] = 'green';
            } elseif ($x2 == 2) {
                $data['analysis_data']['no_of_leadership_poor'] = 4;
                $data['analysis_data']['color66'] = 'yellow';
            } elseif ($x2 == 1) {
                $data['analysis_data']['no_of_leadership_poor'] = 2;
                $data['analysis_data']['color66'] = 'grey';
            } elseif ($x2 == 0) {
                $data['analysis_data']['no_of_leadership_poor'] = 0;
                $data['analysis_data']['color66'] = 'red';
            }
        } else {
            $data['analysis_data']['no_of_leadership_poor'] = 0;
            $data['analysis_data']['color66'] = 'red';
        }

        // analysis 7
        $count5 = $data['analysis'][0]->shg_operational_cost;

        $data['analysis_data']['shg_operational_cost'] = '';
        $data['analysis_data']['color8'] = '';
        if ($count5 != '') {
            $data['analysis_data']['shg_operational_cost'] = ($count5 == 'Yes' ? 5 : 0);
            if ($count5 == 'Yes') {
                $data['analysis_data']['color8'] = 'green';
            } elseif ($count5 == 'No') {
                $data['analysis_data']['color8'] = 'red';
            } else {
                $data['analysis_data']['color8'] = 'grey';
            }
        } else {
            $data['analysis_data']['shg_operational_cost'] = '--';
            $data['analysis_data']['color8'] = '';
        }

        // analysis 8
        $count6 = $data['analysis'][0]->shg_time_taken_loan_disburse;

        $data['analysis_data']['shg_time_taken_loan_disburse'] = '';
        $data['analysis_data']['color3'] = '';
        if ($count6 != '') {
            $data['analysis_data']['shg_time_taken_loan_disburse'] = (($count6 == 1 ? 5 : ($count6 == 2 ? 4 : ($count6 == 3 ? 3 : 1))));
            if ($count6 <= 1) {
                $data['analysis_data']['color3'] = 'green';
            } elseif ($count6 > 1 && $count6 <= 2) {
                $data['analysis_data']['color3'] = 'yellow';
            } elseif ($count6 > 2 && $count6 <= 3) {
                $data['analysis_data']['color3'] = 'grey';
            } elseif ($count6 > 3) {
                $data['analysis_data']['color3'] = 'red';
            }
        } else {
            $data['analysis_data']['shg_time_taken_loan_disburse'] = 0;
            $data['analysis_data']['color3'] = 'red';
        }

        // analysis 9

        $shg_profile = DB::table('shg_profile as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $shg_id)
            ->get()->toArray();


        $shg_formed = $shg_profile[0]->formed;
        $pattern = '/^\d{2}\/\d{2}\/\d{4}$/';


        if (preg_match($pattern, $shg_formed)) {
            $originalDate = DateTime::createFromFormat('d/m/Y', $shg_formed);

            $formattedDate = $originalDate->format('d/M/Y');
        } else {
            $formattedDate = $shg_formed;
        }

        $currentnewDate = new DateTime();
        $currentDate = strftime('%d/%b/%Y', $currentnewDate->getTimestamp());
        $date1 = DateTime::createFromFormat('d/M/Y', $formattedDate);
        $date2 = DateTime::createFromFormat('d/M/Y', $currentDate);

        // Calculate the difference
        $interval = $date1->diff($date2);
        // Get the difference in years, months, and days
        $years = $interval->y;



        $x2 = (str_replace('%', '', $data['analysis'][0]->shg_repayment_internal));
        $data['analysis_data']['shg_repayment_internal'] = '';
        $data['analysis_data']['color5'] = '';
        if ($x2 != '') {
            $data['analysis_data']['shg_repayment_internal'] = (($x2 >= 95 ? 10 : ($x2 >= 85 ? 7 : ($x2 >= 75 ? 5 : 3))));
            if ($x2 >= 95) {
                $data['analysis_data']['color5'] = 'green';
            } elseif ($x2 >= 85 && $x2 <= 94) {
                $data['analysis_data']['color5'] = 'yellow';
            } elseif ($x2 >= 75 && $x2 <= 84) {
                $data['analysis_data']['color5'] = 'grey';
            } elseif ($x2 < 75) {
                $data['analysis_data']['color5'] = 'red';
            }
        } else {
            $data['analysis_data']['shg_repayment_internal'] = (($years <= 1 ? 10 : ($years <= 2 ? 5 : ($years >= 3 ? 0 : 0))));
            if ($years <= 1) {
                $data['analysis_data']['color5'] = 'green';
            } elseif ($years > 1 && $years <= 2) {
                $data['analysis_data']['color5'] = 'yellow';
            } elseif ($years >= 3) {
                $data['analysis_data']['color5'] = 'red';
            }
        }

        // analysis 10
        $x2 = (str_replace('%', '', $data['analysis'][0]->shg_repayment_other));

        $data['analysis_data']['shg_repayment_other'] = '';
        $data['analysis_data']['color7'] = '';
        if ($x2 != '') {
            $data['analysis_data']['shg_repayment_other'] = (($x2 >= 95 ? 10 : ($x2 >= 85 ? 7 : ($x2 >= 75 ? 5 : 3))));
            if ($x2 >= 95) {
                $data['analysis_data']['color7'] = 'green';
            } elseif ($x2 >= 85 && $x2 <= 94) {
                $data['analysis_data']['color7'] = 'yellow';
            } elseif ($x2 >= 75 && $x2 <= 84) {
                $data['analysis_data']['color7'] = 'grey';
            } elseif ($x2 < 75) {
                $data['analysis_data']['color7'] = 'red';
            }
        } else {
            $data['analysis_data']['shg_repayment_other'] = (($years <= 2 ? 10 : ($years >= 2 ? 5 : ($years >= 3 ? 0 : 0))));
            if ($years <= 2) {
                $data['analysis_data']['color7'] = 'green';
            } elseif ($years > 2 && $years < 3) {
                $data['analysis_data']['color7'] = 'yellow';
            } elseif ($years >= 3) {
                $data['analysis_data']['color7'] = 'red';
            }
        }


        // analysis 11
        $count9 = $data['analysis'][0]->shg_PAR_status_internal_loan;
        $data['analysis_data']['shg_PAR_status_internal_loan'] = '';
        $data['analysis_data']['color9'] = '';
        if ($count9 != '') {
            $data['analysis_data']['shg_PAR_status_internal_loan'] = (($count9 < 1 ? 6 : ($count9 < 5 ? 4 : ($count9 < 10 ? 3 : 1))));
            if ($count9 == 0) {
                $data['analysis_data']['color9'] = 'green';
            } elseif ($count9 >= 1 && $count9 <= 5) {
                $data['analysis_data']['color9'] = 'yellow';
            } elseif ($count9 >= 6 && $count9 <= 10) {
                $data['analysis_data']['color9'] = 'grey';
            } elseif ($count9 > 10) {
                $data['analysis_data']['color9'] = 'red';
            }
        } else {
            $data['analysis_data']['shg_PAR_status_internal_loan'] = (($years <= 1 ? 6 : ($years <= 2 ? 3 : ($years > 3 ? 0 : 0))));
            if ($years <= 1) {
                $data['analysis_data']['color9'] = 'green';
            } elseif ($years > 1 && $years <= 2) {
                $data['analysis_data']['color9'] = 'yellow';
            } elseif ($years >= 3) {
                $data['analysis_data']['color9'] = 'red';
            }
        }

        // analysis 12
        $count19 = $data['analysis'][0]->shg_PAR_status_other_loan;
        $data['analysis_data']['shg_PAR_status_other_loan'] = '';
        $data['analysis_data']['color19'] = '';
        if ($count19 != '') {
            $data['analysis_data']['shg_PAR_status_other_loan'] = (($count19 < 1 ? 6 : ($count19 < 5 ? 4 : ($count19 < 10 ? 3 : 1))));
            if ($count19 == 0) {
                $data['analysis_data']['color19'] = 'green';
            } elseif ($count19 >= 1 && $count19 <= 5) {
                $data['analysis_data']['color19'] = 'yellow';
            } elseif ($count19 >= 6 && $count19 <= 10) {
                $data['analysis_data']['color19'] = 'grey';
            } elseif ($count19 > 10) {
                $data['analysis_data']['color19'] = 'red';
            }
        } else {
            $data['analysis_data']['shg_PAR_status_other_loan'] = (($years < 2 ? 6 : ($years >= 2 ? 3 : ($years >= 3 ? 0 : 0))));
            if ($years < 2) {
                $data['analysis_data']['color19'] = 'green';
            } elseif ($years > 2 && $years <= 3) {
                $data['analysis_data']['color19'] = 'yellow';
            } elseif ($years > 3) {
                $data['analysis_data']['color19'] = 'red';
            }
        }

        // analysis 13

        $count15 = $data['analysis'][0]->shg_compulsory_savings;

        $data['analysis_data']['shg_compulsory_savings'] = '';
        $data['analysis_data']['color18'] = '';
        if ($count15 > 0) {
            $data['analysis_data']['shg_compulsory_savings'] = 5;
            $data['analysis_data']['color18'] = 'green';
        } else {
            $data['analysis_data']['shg_compulsory_savings'] = 0;
            $data['analysis_data']['color18'] = 'red';
        }

        // analysis 14
        $count51 = $data['analysis'][0]->shg_voluntary_savings;

        $data['analysis_data']['shg_voluntary_savings'] = '';
        $data['analysis_data']['color81'] = '';
        if ($count51 > 0) {
            $data['analysis_data']['shg_voluntary_savings'] = 5;
            $data['analysis_data']['color81'] = 'green';
        } else {
            $data['analysis_data']['shg_voluntary_savings'] = 0;
            $data['analysis_data']['color81'] = 'red';
        }

        // analysis 15
        $x2 = (str_replace('%', '', $data['analysis'][0]->shg_regularity_savings));
        $data['analysis_data']['shg_regularity_savings'] = '';
        $data['analysis_data']['color11'] = '';
        if ($x2 != '') {
            $data['analysis_data']['shg_regularity_savings'] = (($x2 >= 90 ? 10 : ($x2 >= 80 ? 7 : ($x2 >= 70 ? 5 : ($x2 >= 60 ? 3 : ($x2 >= 50 ? 1 : 0))))));
            if ($x2 >= 90) {
                $data['analysis_data']['color11'] = 'green';
            } elseif ($x2 >= 80 && $x2 <= 89) {
                $data['analysis_data']['color11'] = 'yellow';
            } elseif ($x2 >= 70 && $x2 <= 79) {
                $data['analysis_data']['color11'] = 'grey';
            } elseif ($x2 < 70) {
                $data['analysis_data']['color11'] = 'red';
            }
        } else {
            $data['analysis_data']['shg_regularity_savings'] = 0;
            $data['analysis_data']['color11'] = 'red';
        }

        //total analysis
        $data['total_1'] = (float) $data['analysis_data']['Average_participation_of'] + (float) $data['analysis_data']['shg_book_updation'] + (float) $data['analysis_data']['shg_grading_status'];
        $x = ($data['total_1'] * 100) / 25;
        $data['score'] = $x;
        $data['show1'] = $x >= 90 ? 'green' : ($x >= 75 ? 'yellow' : ($x >= 60 ? 'grey' : 'red'));

        $data['total_2'] = (float) $data['analysis_data']['shg_percent_of_poorest_internal'] + (float) $data['analysis_data']['shg_percent_of_poorest_other'] + (float) $data['analysis_data']['no_of_leadership_poor'];
        $x = ($data['total_2'] * 100) / 15;
        $data['score1'] = $x;
        $data['show2'] = $x >= 90 ? 'green' : ($x >= 75 ? 'yellow' : ($x >= 60 ? 'grey' : 'red'));

        $data['total_3'] = (float) $data['analysis_data']['shg_operational_cost'] + (float) $data['analysis_data']['shg_time_taken_loan_disburse'];
        $x = ($data['total_3'] * 100) / 10;
        $data['score2'] = $x;
        $data['show3'] = $x >= 90 ? 'green' : ($x >= 75 ? 'yellow' : ($x >= 60 ? 'grey' : 'red'));

        $data['total_4'] = (float) $data['analysis_data']['shg_repayment_internal'] + (float) $data['analysis_data']['shg_repayment_other'] + (float) $data['analysis_data']['shg_PAR_status_internal_loan'] + (float) $data['analysis_data']['shg_PAR_status_other_loan'];
        $x = ($data['total_4'] * 100) / 30;
        $data['score3'] = $x;
        $data['show4'] = $x >= 90 ? 'green' : ($x >= 75 ? 'yellow' : ($x >= 60 ? 'grey' : 'red'));

        $data['total_5'] = (float) $data['analysis_data']['shg_compulsory_savings'] + (float) $data['analysis_data']['shg_voluntary_savings'] + (float) $data['analysis_data']['shg_regularity_savings'];
        $x = ($data['total_5'] * 100) / 20;
        $data['score4'] = $x;
        $data['show5'] = $x >= 90 ? 'green' : ($x >= 75 ? 'yellow' : ($x >= 60 ? 'grey' : 'red'));

        $data['grd_total'] = $data['total_5'] + $data['total_4'] + $data['total_3'] + $data['total_2'] + $data['total_1'];
        $x = ($data['grd_total'] * 100) / 100;
        $data['total_show'] = $x >= 90 ? 'green' : ($x >= 75 ? 'yellow' : ($x >= 60 ? 'grey' : 'red'));
        $data['show_final_status'] = $data['total_show'] == 'green' ? 'Minimal Risk' : ($data['total_show'] == 'yellow' ? ' Low Risk' : ($data['total_show'] == 'grey' ? 'Moderate Risk' : 'High Risk'));

        return $data;
    }

//     function family_analysis($family_id)
// {

//     $data['analysis_this_year'] = DB::table('family_analysis_this_year as a')
//         ->where('is_deleted', '=', 0)
//         ->where('a.family_sub_mst_id', '=', $family_id)
//         ->get()->toArray();

//     $data['analysis_next_year'] = DB::table('family_analysis_next_year as a')
//         ->where('is_deleted', '=', 0)
//         ->where('a.family_sub_mst_id', '=', $family_id)
//         ->get()->toArray();

//     // $query = "SELECT
//     //         COALESCE(SUM(a.sum),
//     //         0) AS expenditure_this_total
//     //     FROM
//     //         (
//     //         SELECT
//     //             a.s_type AS TYPE,
//     //             a.s_last_saved_amt AS SUM
//     //         FROM
//     //             family_savings_source AS a
//     //         WHERE
//     //             a.family_sub_mst_id = $family_id
//     //         UNION ALL
//     //     SELECT
//     //         b.other_loan AS TYPE,
//     //         b.last_saved_amt AS SUM
//     //     FROM
//     //         family_savings_source_other AS b
//     //     WHERE
//     //         b.family_sub_mst_id = $family_id
//     //     UNION ALL
//     //     SELECT
//     //         c.e_cat AS TYPE,
//     //         c.e_total_amount AS SUM
//     //     FROM
//     //         family_expenditure_this_year c
//     //     WHERE
//     //         c.family_sub_mst_id = $family_id
//     //     UNION ALL
//     //     SELECT
//     //         d.lo_type AS TYPE,
//     //         d.current_year_interest AS SUM
//     //     FROM
//     //         family_loan_outstanding d
//     //     WHERE
//     //         d.family_sub_mst_id = $family_id
//     //     ) a";
//     // $data['total_expenditure_this'] = DB::select($query);

//     // $query = "SELECT
//     // COALESCE(e_total_amount, 0) AS income
//     // FROM
//     //     family_income_this_year
//     // WHERE
//     //     family_sub_mst_id = $family_id";
//     // $data['total_income_this'] = DB::select($query);



//     // $total_expenditure = $data['total_expenditure_this'][0]->expenditure_this_total;
//     // $total_income_this =  $data['total_income_this'][0]->income;

//     // //analysis 1 current year
//     // $count1_cy = '';
//     // $data['show1_cy'] = 'red';
//     // $data['analysis_1_cy'] = 0;
//     // // $ana_this = $data['analysis_this_year'][0]->a_i_e_gap;
//     // if ($total_income_this > 0 || $total_expenditure > 0) {
//     //     if ($total_income_this > $total_expenditure) {
//     //         $data['analysis_1_cy'] = 5;
//     //         $data['show1_cy'] = 'green';
//     //     } elseif ($total_income_this == $total_expenditure) {
//     //         $data['analysis_1_cy'] = 3;
//     //         $data['show1_cy'] = 'yellow';
//     //     } elseif ($total_income_this < $total_expenditure) {
//     //         $data['analysis_1_cy'] = 0;
//     //         $data['show1_cy'] = 'red';
//     //     }
//     // }



//     // $query = "SELECT
//     //     COALESCE(SUM(a.sum),
//     //     0) AS expenditure_next_total
//     // FROM
//     //     (

//     // SELECT
//     //     c.e_cat AS TYPE,
//     //     c.e_total_amount AS SUM
//     // FROM
//     //     family_expenditure_next_year c
//     // WHERE
//     //     c.family_sub_mst_id = $family_id
//     // UNION ALL
//     // SELECT
//     //     d.lo_type AS TYPE,
//     //     d.lo_next_year AS SUM
//     // FROM
//     //     family_loan_outstanding d
//     // WHERE
//     //     d.family_sub_mst_id = $family_id
//     // ) a";
//     // $data['total_expenditure_next'] = DB::select($query);

//     // $query = "SELECT
//     // COALESCE(e_total_amount, 0) AS income
//     // FROM
//     //     family_income_this_year
//     // WHERE
//     //     family_sub_mst_id = $family_id";
//     // $data['total_income_next'] = DB::select($query);
//     // $total_expenditure_next = 0;
//     // if ($data['total_expenditure_next'][0]->expenditure_next_total != '') {
//     //     $total_expenditure_next = $data['total_expenditure_next'][0]->expenditure_next_total;
//     // }
//     // $total_income_next = 0;
//     // if ($data['total_income_next'][0]->income != '') {
//     //     $total_income_next =  $data['total_income_next'][0]->income;
//     // }

//     // //analysis 1 next year
//     // $count1_cy = '';
//     // $data['show1_ny'] = 'red';
//     // $data['analysis_1_ny'] = 0;
//     // // $ana_ny = $data['analysis_next_year'][0]->a_i_e_gap;
//     // if ($total_income_next > 0 || $total_expenditure_next > 0) {
//     //     if ($total_income_next > $total_expenditure_next) {
//     //         $data['analysis_1_ny'] = 5;
//     //         $data['show1_ny'] = 'green';
//     //     } elseif ($total_income_next == $total_expenditure_next) {
//     //         $data['analysis_1_ny'] = 3;
//     //         $data['show1_ny'] = 'yellow';
//     //     } elseif ($total_income_next < $total_expenditure_next) {
//     //         $data['analysis_1_ny'] = 0;
//     //         $data['show1_ny'] = 'red';
//     //     }
//     // }


//     //analysis 2 current year
//     $count2_cy = '';
//     $data['show2_cy'] = 'red';
//     $data['analysis_2_cy'] = 0;
//     $average_2_cy = (float) $data['analysis_this_year'][0]->a_i_e_ratio;

//     if ($average_2_cy != 0) {
//         $count2_cy = (($average_2_cy <= 80 ? 10 : ($average_2_cy <= 90 ? 7 : ($average_2_cy <= 100 ? 5 : 1))));
//         $data['analysis_2_cy'] = $count2_cy;
//         $data['show2_cy'] = $average_2_cy <= 80 ? 'green' : ($average_2_cy <= 90 ? 'yellow' : ($average_2_cy <= 100 ? 'grey' : 'red'));
//     }

//     // //analysis 2 next year
//     // $count2_ny = '';
//     // $data['show2_ny'] = 'red';
//     // $data['analysis_2_ny'] = 0;
//     // $average_2_ny = (float) $data['analysis_next_year'][0]->a_i_e_ratio;
//     // if ($average_2_ny != 0) {
//     //     $count2_ny = (($average_2_ny <= 80 ? 10 : ($average_2_ny <= 90 ? 7 : ($average_2_ny <= 100 ? 5 : 1))));
//     //     $data['analysis_2_ny'] = $count2_ny;
//     //     $data['show2_ny'] = $average_2_ny <= 80 ? 'green' : ($average_2_ny <= 90 ? 'yellow' : ($average_2_ny <= 100 ? 'grey' : 'red'));
//     // }

//     // //analysis 3 current year
//     // $count3_cy = '';
//     // $data['show3_cy'] = 'red';
//     // $data['analysis_3_cy'] = 0;
//     // $query = "SELECT * FROM family_savings_source where family_sub_mst_id=$family_id and s_type = 'Compulsory' ";
//     // $compulsory = DB::select($query);
//     // // if (!empty($compulsory)) {
//     // //     $save_per_month = $compulsory[0]->s_saving_per_month;
//     // //     $expected_amt = $save_per_month * 12;
//     // //     $s_last_saved_amt = $compulsory[0]->s_last_saved_amt;
//     // //     $average_3_cy = (($s_last_saved_amt / $expected_amt) * 100);
//     // //     $data['analysis_3_cy'] = $average_3_cy > 99 ? 10 : ($average_3_cy >= 85 ? 8 : ($average_3_cy >= 75 ? 6 : 2));
//     // //     $data['show3_cy'] = $average_3_cy > 99 ? 'green' : ($average_3_cy >= 85 ? 'yellow' : ($average_3_cy >= 75 ? 'grey' : 'red'));
//     // // }





//     // //analysis 34current year
//     // $count4_cy = '';
//     // $data['show4_cy'] = 'red';
//     // $data['analysis_4_cy'] = 0;
//     // $quer4 = "SELECT s_contribute_regular FROM family_savings_source where family_sub_mst_id=$family_id and s_type = 'Voluntary' ";
//     // $average_4_cy = DB::select($quer4);

//     // if (!empty($average_4_cy)) {
//     //     if ($average_4_cy[0]->s_contribute_regular == 'Yes') {
//     //         $data['analysis_4_cy'] = 2;
//     //         $data['show4_cy'] = 'green';
//     //     } else {
//     //         $data['analysis_4_cy'] = 0;
//     //         $data['show4_cy'] = 'red';
//     //     }
//     // }

//     // //analysis 35current year
//     // $count_other = '';
//     // $data['show_other'] = 'red';
//     // $data['analysis_other'] = 0;
//     // $query = "SELECT other_amount FROM family_savings_source_other where family_sub_mst_id=$family_id  ";
//     // $average_other = DB::select($query);

//     // if (!empty($average_other)) {
//     //     $count_other = $average_other[0]->other_amount != '' ? 5 : 0;
//     //     if ($average_other[0]->other_amount != '') {
//     //         $data['analysis_other'] = 2;
//     //         $data['show_other'] = 'green';
//     //     } else {
//     //         $data['analysis_other'] = 0;
//     //         $data['show_other'] = 'red';
//     //     }
//     // }

//     // $query = "SELECT
//     //         COALESCE(SUM(a.sum), 0) AS saving_total
//     //     FROM
//     //         (
//     //         SELECT
//     //             a.s_last_saved_amt AS SUM
//     //         FROM
//     //             family_savings_source AS a
//     //         WHERE
//     //             a.family_sub_mst_id = $family_id
//     //         UNION ALL
//     //     SELECT
//     //         b.last_saved_amt AS SUM
//     //     FROM
//     //         family_savings_source_other AS b
//     //     WHERE
//     //         b.family_sub_mst_id = $family_id
//     //     ) a";

//     // $data['saving_total'] = DB::select($query);

//     // //analysis 5 current year

//     // $saving_total = $data['saving_total'][0]->saving_total;


//     // $count5_cy = '';
//     // $data['show5_cy'] = 'red';
//     // $data['analysis_5_cy'] = 0;
//     // $average_5_cy = '';
//     // if ($saving_total > 0 && $total_income_this > 0) {
//     //     $average_5_cy = (float) (($saving_total / $total_income_this) * 100);
//     // }


//     // if ($average_5_cy != '') {
//     //     $data['analysis_5_cy'] = (($average_5_cy >= 10 ? 8 : ($average_5_cy >= 5 ? 7 : ($average_5_cy >= 2 ? 5 : 2))));

//     //     $data['show5_cy'] = (($average_5_cy >= 10 ? 'green' : ($average_5_cy >= 5 ? 'yellow' : ($average_5_cy >= 2 ? 'grey' : 'red'))));
//     // }

//     // // pr($saving_total);
//     // // prd($total_income_next);
//     // //analysis 5 next year
//     // $count5_ny = '';
//     // $data['show5_ny'] = 'red';
//     // $data['analysis_5_ny'] = 0;
//     // $average_5_ny = '';
//     // if ($saving_total > 0 && $total_income_next > 0) {
//     //     $average_5_ny = (float) (($saving_total / $total_income_next) * 100);
//     // }
//     // if ($average_5_ny != '') {
//     //     $data['analysis_5_ny'] = (($average_5_ny >= 10 ? 8 : ($average_5_ny >= 5 ? 7 : ($average_5_ny >= 2 ? 5 : 2))));

//     //     $data['show5_ny'] = (($average_5_ny >= 10 ? 'green' : ($average_5_ny >= 5 ? 'yellow' : ($average_5_ny >= 2 ? 'grey' : 'red'))));
//     // }


//     // //analysis 6 current year
//     // $data['savings'] = DB::table('family_savings as a')
//     //     ->where('is_deleted', '=', 0)
//     //     ->where('a.family_sub_mst_id', '=', $family_id)
//     //     ->get()->toArray();
//     // $count6_cy = '';
//     // $data['show6_cy'] = 'red';
//     // $data['analysis_6_cy'] = 0;
//     // $average_6_cy = $data['savings'][0]->s_passbook_physically;
//     // if ($average_6_cy != '') {
//     //     if ($average_6_cy == 1) {
//     //         $data['analysis_6_cy'] = 1;
//     //         $data['show6_cy'] = 'green';
//     //     } else {
//     //         $data['analysis_6_cy'] = 0;
//     //         $data['show6_cy'] = 'red';
//     //     }
//     // }

//     // //analysis 7 current year
//     // $count7_cy = '';
//     // $data['show7_cy'] = 'red';
//     // $data['analysis_7_cy'] = 0;
//     // $average_7_cy = $data['analysis_this_year'][0]->a_alr_i_ratio;

//     // if ($average_7_cy != '') {
//     //     $count7_cy = (($average_7_cy <= 25 ? 10 : ($average_7_cy <= 35 ? 7 : ($average_7_cy <= 50 ? 5 : ($average_7_cy > 50 ? 2 : 0)))));

//     //     $data['analysis_7_cy'] = $count7_cy;
//     //     if ($average_7_cy <= 25) {
//     //         $data['show7_cy'] = 'green';
//     //     } else if ($average_7_cy >= 26 && $average_7_cy <= 35) {
//     //         $data['show7_cy'] = 'yellow';
//     //     } else if ($average_7_cy >= 36 && $average_7_cy <= 50) {
//     //         $data['show7_cy'] = 'grey';
//     //     } else if ($average_7_cy > 50) {
//     //         $data['show7_cy'] = 'red';
//     //     }
//     // }

//     // //analysis 7 next year
//     // $count7_ny = '';
//     // $data['show7_ny'] = 'red';
//     // $data['analysis_7_ny'] = 0;
//     // $average_7_ny = $data['analysis_next_year'][0]->a_alr_i_ratio;
//     // if ($average_7_ny != '') {
//     //     $count7_ny = (($average_7_ny <= 25 ? 10 : ($average_7_ny <= 35 ? 7 : ($average_7_ny <= 50 ? 5 : ($average_7_ny > 50 ? 2 : 0)))));
//     //     $data['analysis_7_ny'] = $count7_ny;
//     //     if ($average_7_ny <= 30) {
//     //         $data['show7_ny'] = 'green';
//     //     } else if ($average_7_ny >= 31 && $average_7_ny <= 40) {
//     //         $data['show7_ny'] = 'yellow';
//     //     } else if ($average_7_ny >= 41 && $average_7_ny <= 50) {
//     //         $data['show7_ny'] = 'grey';
//     //     } else if ($average_7_ny > 50) {
//     //         $data['show7_ny'] = 'red';
//     //     }
//     // }

//     // //analysis 8 current year
//     // $count8_cy = '';
//     // $data['show8_cy'] = 'red';
//     // $data['analysis_8_cy'] = 0;
//     // $average_8_cy = (float) $data['analysis_this_year'][0]->a_debit_ratio;
//     // // pr($average_8_cy);
//     // if ($average_8_cy != '') {
//     //     $count8_cy = (($average_8_cy >= 1.25 ? 10 : ($average_8_cy >= 1.00 ? 7 : ($average_8_cy >= 0.5 ? 3 : 0))));
//     //     $data['analysis_8_cy'] = $count8_cy;

//     //     if ($average_8_cy >= 1.25) {
//     //         $data['show8_cy'] = 'green';
//     //     } else if ($average_8_cy >= 1 && $average_8_cy < 1.25) {
//     //         $data['show8_cy'] = 'yellow';
//     //     } else if ($average_8_cy >= 0.5 && $average_8_cy <= 0.99) {
//     //         $data['show8_cy'] = 'grey';
//     //     } else if ($average_8_cy < 0.5) {
//     //         $data['show8_cy'] = 'red';
//     //     }
//     // }

//     // //analysis 8 next year
//     // $count8_ny = '';
//     // $data['show8_ny'] = 'red';
//     // $data['analysis_8_ny'] = 0;
//     // $average_8_ny = (float) $data['analysis_next_year'][0]->a_debit_ratio;
//     // // prd($average_8_ny);
//     // if ($average_8_ny != '') {
//     //     $count8_ny = (($average_8_ny >= 1.25 ? 10 : ($average_8_ny >= 1.00 ? 7 : ($average_8_ny >= 0.5 ? 3 : 0))));

//     //     $data['analysis_8_ny'] = $count8_ny;

//     //     if ($average_8_ny >= 1.25) {
//     //         $data['show8_ny'] = 'green';
//     //     } else if ($average_8_ny >= 1 && $average_8_ny <= 1.24) {
//     //         $data['show8_ny'] = 'yellow';
//     //     } else if ($average_8_ny >= 0.5 && $average_8_ny <= 0.99) {
//     //         $data['show8_ny'] = 'grey';
//     //     } else if ($average_8_ny < 0.5) {
//     //         $data['show8_ny'] = 'red';
//     //     }
//     // }

//     // //analysis 9 current year
//     // $data['loan_outstanding'] = DB::table('family_loan_outstanding as a')
//     //     ->where('is_deleted', '=', 0)
//     //     ->where('a.family_sub_mst_id', '=', $family_id)
//     //     ->get()->toArray();
//     // $count9_cy = '';
//     // $data['show9_cy'] = 'red';
//     // $data['analysis_9_cy'] = 0;
//     // $sum_overdue_cy = 0;
//     // $sum_emi_cy = 0;
//     // foreach ($data['loan_outstanding'] as $row) {

//     //     if ($row->lo_type == 'SHG Loan' && $row->overdue != '') {

//     //         $sum_overdue_cy = $sum_overdue_cy + $row->overdue;
//     //         $sum_emi_cy = $sum_emi_cy + $row->monthly_emi;
//     //     }
//     //     if ($row->lo_type == '' && $row->overdue == '') {
//     //         $sum_overdue_cy = '';
//     //         $sum_emi_cy = '';
//     //     }
//     // }

//     // if ($sum_overdue_cy != '' || $sum_emi_cy != '') {
//     //     if ($sum_emi_cy > 0) {
//     //         $average_9_cy = round(($sum_overdue_cy / $sum_emi_cy), 2);

//     //         $count9_cy = (($average_9_cy < 1 ? 5 : ($average_9_cy < 2 ? 3 : ($average_9_cy <= 4 ? 1 : 0))));

//     //         $data['show9_cy'] = (($count9_cy == 5 ? 'green' : ($count9_cy == 3 ? 'yellow' : ($count9_cy == 1 ? 'grey' : 'red'))));
//     //         $data['analysis_9_cy'] = $count9_cy;
//     //     } else {
//     //         $data['analysis_9_cy'] = 5;
//     //         $data['show9_cy'] = 'green';
//     //     }
//     // } else {
//     //     $data['analysis_9_cy'] = 5;
//     //     $data['show9_cy'] = 'green';
//     // }

//     // $query = "SELECT fp_wealth_rank FROM family_profile where family_sub_mst_id = $family_id";
//     // $wealth_rank = DB::select($query)[0]->fp_wealth_rank;

//     // //analysis 10 current year
//     // $count10_cy = '';
//     // $data['show10_cy'] = 'red';
//     // $data['analysis_10_cy'] = 0;
//     // if (!empty($wealth_rank)) {
//     //     $data['analysis_10_cy'] = 10;
//     // }

//     // $sum_emi_money = 0;
//     // $sum_overdue_money = 0;
//     // $num = 0;
//     // $no_of_days = 0;

//     // if (!empty($data['loan_outstanding'])) {



//     //     foreach ($data['loan_outstanding'] as $row) {
//     //         if ($row->lo_type == 'SHG Loan') {

//     //             $num = $num + 1;
//     //             $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
//     //             $sum_emi_money = $sum_emi_money + $row->monthly_emi;
//     //             $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
//     //         }

//     //         if ($row->lo_type == 'Money Lenders Loan') {
//     //             $num = $num + 1;
//     //             $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
//     //             $sum_emi_money = $sum_emi_money + $row->monthly_emi;
//     //             $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
//     //         }
//     //         if ($row->lo_type == 'Bank Loan') {
//     //             $num = $num + 1;
//     //             $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
//     //             $sum_emi_money = $sum_emi_money + $row->monthly_emi;
//     //             $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
//     //         }
//     //         if ($row->lo_type == 'Federation Loan') {
//     //             $num = $num + 1;
//     //             $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
//     //             $sum_emi_money = $sum_emi_money + $row->monthly_emi;
//     //             $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
//     //         }
//     //         if ($row->lo_type == 'Cluster Loan') {
//     //             $num = $num + 1;
//     //             $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
//     //             $sum_emi_money = $sum_emi_money + $row->monthly_emi;
//     //             $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
//     //         }
//     //         if ($row->lo_type == 'Other Private Loan') {
//     //             $num = $num + 1;
//     //             $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
//     //             $sum_emi_money = $sum_emi_money + $row->monthly_emi;
//     //             $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
//     //         }
//     //     }
//     //     if (!empty($no_of_days)) {
//     //         $average_10_cy = $no_of_days * 30;
//     //         $data['analysis_10_cy'] = (($average_10_cy <= 30 ? 20 : ($average_10_cy <= 60 ? 12 : ($average_10_cy <= 120 ? 6 : 2))));
//     //         $data['show10_cy'] = (($average_10_cy <= 30 ? 'green' : ($average_10_cy <= 60 ? 'yellow' : ($average_10_cy <= 120 ? 'grey' : 'red'))));
//     //     }
//     // }







//     // //analysis 11 current year
//     // $count11_cy = '';
//     // $data['show11_cy'] = 'red';
//     // $data['analysis_11_cy'] = 0;
//     // $average_11_cy = $data['analysis_this_year'][0]->family_indebtedness;

//     // if ($average_11_cy != '') {
//     //     $count11_cy = (($average_11_cy < 20 ? 10 : ($average_11_cy <= 40 ? 7 : ($average_11_cy <= 50 ? 3 : 0))));
//     //     $data['analysis_11_cy'] = $count11_cy;
//     //     if ($average_11_cy < 20) {
//     //         $data['show11_cy'] = 'green';
//     //     } else if ($average_11_cy >= 20 && $average_11_cy <= 40) {
//     //         $data['show11_cy'] = 'yellow';
//     //     } else if ($average_11_cy >= 41 && $average_11_cy <= 50) {
//     //         $data['show11_cy'] = 'grey';
//     //     } else if ($average_11_cy > 50) {
//     //         $data['show11_cy'] = 'red';
//     //     }
//     // }

//     // //analysis 12 current year
//     // $data['shgmember_commitment'] = DB::table('family_shgmember_commitment as a')
//     //     ->where('is_deleted', '=', 0)
//     //     ->where('a.family_sub_mst_id', '=', $family_id)
//     //     ->get()->toArray();
//     // $count12_ny = '';
//     // $data['show12_ny'] = 'red';
//     // $data['analysis_12_ny'] = 0;
//     // $average_12_ny = $data['shgmember_commitment'][0]->yo_meeting_yes_no;

//     // if ($average_12_ny != '') {
//     //     $count12_ny = ($average_12_ny == 'Yes' ? 10 : 0);
//     //     $data['analysis_12_ny'] = $count12_ny;
//     //     $x12_ny = ($data['analysis_12_ny'] * 100) / 10;
//     //     $data['show12_ny'] = $x12_ny >= 90 ? 'green' : ($x12_ny >= 75 ? 'yellow' : ($x12_ny >= 60 ? 'grey' : 'red'));
//     // }

//     // //analysis 13 next year
//     // $count13_ny = '';
//     // $data['show13_ny'] = 'red';
//     // $data['analysis_13_ny'] = 0;
//     // $average_13_ny = $data['shgmember_commitment'][0]->yo_member_aware_categories;
//     // // prd( $average_13_ny);
//     // if ($average_13_ny != '') {
//     //     $count13_ny = $average_13_ny == "Strong" ? 2 : ($average_13_ny == "Average" ? 1 : ($average_13_ny == "Weak" ? 0 : 0));
//     //     $data['analysis_13_ny'] = $count13_ny;
//     //     $x13_ny = ((int) $data['analysis_13_ny'] * 100) / 2;
//     //     $data['show13_ny'] = $x13_ny >= 90 ? 'green' : ($x13_ny >= 75 ? 'yellow' : ($x13_ny >= 60 ? 'grey' : 'red'));
//     // }

//     // //total 4th
//     // $data['total_ny4'] = (float) $data['analysis_12_ny'] + (float) $data['analysis_13_ny'];
//     // $x2_ny = ((int) $data['total_ny4'] * 100) / 12;
//     // $data['score3'] = $x2_ny;
//     // $data['show_ny4'] = $x2_ny >= 90 ? 'green' : ($x2_ny >= 75 ? 'yellow' : ($x2_ny >= 60 ? 'grey' : 'red'));

//     // $data['total_cy1'] = (float) $data['analysis_1_cy'] + (float) $data['analysis_2_cy'];
//     // $data['score'] = ((int) $data['total_cy1'] * 100) / 15;

//     // $data['total_cy2'] = (int)$data['analysis_3_cy'] + (int)$data['analysis_4_cy'] + (int)$data['analysis_other'] + (int)$data['analysis_5_cy'] + (int)$data['analysis_6_cy'];
//     // $data['score1'] = ((int) $data['total_cy2'] * 100) / 23;

//     // $data['total_cy3'] = (int)$data['analysis_7_cy'] + (int)$data['analysis_8_cy']  + (int)$data['analysis_10_cy'] + (int)$data['analysis_11_cy'];
//     // $data['score2'] = ((int) $data['total_cy3'] * 100) / 50;

//     // $data['total_cy4'] = (int) $data['analysis_12_ny'] + (float) $data['analysis_13_ny'];
//     // $data['score3'] = ((int) $data['total_cy4'] * 100) / 12;

//     // $data['grand_total_cy'] =
//     //     (float) $data['analysis_1_cy']
//     //     + (float) $data['analysis_2_cy']
//     //     + (int) $data['analysis_3_cy']
//     //     + (int) $data['analysis_4_cy']
//     //     + (int) $data['analysis_other']
//     //     + (int) $data['analysis_5_cy']
//     //     + (int) $data['analysis_6_cy']
//     //     + (int) $data['analysis_7_cy']
//     //     + (int) $data['analysis_8_cy']
//     //     + (int) $data['analysis_10_cy']
//     //     + (int) $data['analysis_11_cy']
//     //     + (int) $data['analysis_12_ny']
//     //     + (float) $data['analysis_13_ny'];

//     // $data['grand_total_ny'] =
//     //     (float) $data['analysis_1_ny']
//     //     + (float) $data['analysis_2_ny']
//     //     + (int) $data['analysis_5_ny']
//     //     + (int)$data['analysis_7_ny']
//     //     + (int)$data['analysis_8_ny']
//     //     + (int)$data['analysis_12_ny'];

//     // $total_grd = ($data['grand_total_cy'] * 100) / 100;

//     // $data['grdcolor'] = $total_grd >= 90 ? 'green' : ($total_grd >= 75 ? 'yellow' : ($total_grd >= 60 ? 'grey' : 'red'));

//     // // $data['show_final_status'] = $grdcolor == 'green' ? 'Minimal Risk' : ($grdcolor == 'yellow' ? ' Low Risk' : ($grdcolor == 'grey' ? 'Moderate Risk' : 'High Risk'));

//     // $data['show_final_status'] = $data['grdcolor'] == 'green' ? 'Minimal Risk' : ($data['grdcolor'] == 'yellow' ? ' Low Risk' : ($data['grdcolor'] == 'grey' ? 'Moderate Risk' : 'High Risk'));

//     return $data;
// }

function family_analysis($family_id)
{

    $query = "SELECT
            f.id,
            f.uin AS UIN,
            fp.fp_member_name AS Family_Name,
            fp.fp_wealth_rank AS Wealth_Rank,
            sp.shgName AS SHG_Nmae,
            cp.name_of_cluster AS Cluster_Name,
            fedp.name_of_federation AS Fedeartion_Name,
            fp.analysis_rating AS Rating_score
         FROM
             federation_mst AS fed
              INNER JOIN federation_profile AS fedp
              ON fed.id = fedp.federation_sub_mst_id
              INNER JOIN
             cluster_mst AS c
             ON c.federation_uin = fed.uin
             INNER JOIN cluster_profile AS cp
             ON c.id = cp.cluster_sub_mst_id
             INNER JOIN shg_mst AS s
             ON c.uin = s.cluster_uin
             INNER JOIN shg_profile AS sp
             ON s.id = sp.shg_sub_mst_id
             INNER JOIN family_mst AS f
             ON f.shg_uin = s.uin
             INNER JOIN family_profile AS fp ON f.id = fp.family_sub_mst_id

              WHERE c.is_deleted = 0 AND s.is_deleted = 0 AND f.is_deleted = 0 AND f.id = $family_id
              ORDER  BY f.id";
            $data['family_info'] = DB::select($query)[0];
    $data['analysis_this_year'] = DB::table('family_analysis_this_year as a')
        ->where('is_deleted', '=', 0)
        ->where('a.family_sub_mst_id', '=', $family_id)
        ->get()->toArray();

    $data['analysis_next_year'] = DB::table('family_analysis_next_year as a')
        ->where('is_deleted', '=', 0)
        ->where('a.family_sub_mst_id', '=', $family_id)
        ->get()->toArray();

    $query = "SELECT
            COALESCE(SUM(a.sum),
            0) AS expenditure_this_total
        FROM
            (
            SELECT
                a.s_type AS TYPE,
                a.s_last_saved_amt AS SUM
            FROM
                family_savings_source AS a
            WHERE
                a.family_sub_mst_id = $family_id
            UNION ALL
        SELECT
            b.other_loan AS TYPE,
            b.last_saved_amt AS SUM
        FROM
            family_savings_source_other AS b
        WHERE
            b.family_sub_mst_id = $family_id
        UNION ALL
        SELECT
            c.e_cat AS TYPE,
            c.e_total_amount AS SUM
        FROM
            family_expenditure_this_year c
        WHERE
            c.family_sub_mst_id = $family_id
        UNION ALL
        SELECT
            d.lo_type AS TYPE,
            d.current_year_interest AS SUM
        FROM
            family_loan_outstanding d
        WHERE
            d.family_sub_mst_id = $family_id
        ) a";
    $data['total_expenditure_this'] = DB::select($query);

    $query = "SELECT
    COALESCE(e_total_amount, 0) AS income
    FROM
        family_income_this_year
    WHERE
        family_sub_mst_id = $family_id";
    $data['total_income_this'] = DB::select($query);



    $total_expenditure = $data['total_expenditure_this'][0]->expenditure_this_total;
    $total_income_this =  $data['total_income_this'][0]->income;

    //analysis 1 current year
    $count1_cy = '';
    $data['show1_cy'] = 'red';
    $data['analysis_1_cy'] = 0;
    // $ana_this = $data['analysis_this_year'][0]->a_i_e_gap;
    if ($total_income_this > 0 || $total_expenditure > 0) {
        if ($total_income_this > $total_expenditure) {
            $data['analysis_1_cy'] = 5;
            $data['show1_cy'] = 'green';
        } elseif ($total_income_this == $total_expenditure) {
            $data['analysis_1_cy'] = 3;
            $data['show1_cy'] = 'yellow';
        } elseif ($total_income_this < $total_expenditure) {
            $data['analysis_1_cy'] = 0;
            $data['show1_cy'] = 'red';
        }
    }



    $query = "SELECT
        COALESCE(SUM(a.sum),
        0) AS expenditure_next_total
    FROM
        (

    SELECT
        c.e_cat AS TYPE,
        c.e_total_amount AS SUM
    FROM
        family_expenditure_next_year c
    WHERE
        c.family_sub_mst_id = $family_id
    UNION ALL
    SELECT
        d.lo_type AS TYPE,
        d.lo_next_year AS SUM
    FROM
        family_loan_outstanding d
    WHERE
        d.family_sub_mst_id = $family_id
    ) a";
    $data['total_expenditure_next'] = DB::select($query);

    $query = "SELECT
    COALESCE(e_total_amount, 0) AS income
    FROM
        family_income_this_year
    WHERE
        family_sub_mst_id = $family_id";
    $data['total_income_next'] = DB::select($query);
    $total_expenditure_next = 0;
    if ($data['total_expenditure_next'][0]->expenditure_next_total != '') {
        $total_expenditure_next = $data['total_expenditure_next'][0]->expenditure_next_total;
    }
    $total_income_next = 0;
    if ($data['total_income_next'][0]->income != '') {
        $total_income_next =  $data['total_income_next'][0]->income;
    }

    //analysis 1 next year
    $count1_cy = '';
    $data['show1_ny'] = 'red';
    $data['analysis_1_ny'] = 0;
    // $ana_ny = $data['analysis_next_year'][0]->a_i_e_gap;
    if ($total_income_next > 0 || $total_expenditure_next > 0) {
        if ($total_income_next > $total_expenditure_next) {
            $data['analysis_1_ny'] = 5;
            $data['show1_ny'] = 'green';
        } elseif ($total_income_next == $total_expenditure_next) {
            $data['analysis_1_ny'] = 3;
            $data['show1_ny'] = 'yellow';
        } elseif ($total_income_next < $total_expenditure_next) {
            $data['analysis_1_ny'] = 0;
            $data['show1_ny'] = 'red';
        }
    }


    //analysis 2 current year
    $count2_cy = '';
    $data['show2_cy'] = 'red';
    $data['analysis_2_cy'] = 0;
    $average_2_cy = (float) $data['analysis_this_year'][0]->a_i_e_ratio;

    if ($average_2_cy != 0) {
        $count2_cy = (($average_2_cy <= 80 ? 10 : ($average_2_cy <= 90 ? 7 : ($average_2_cy <= 100 ? 5 : 1))));
        $data['analysis_2_cy'] = $count2_cy;
        $data['show2_cy'] = $average_2_cy <= 80 ? 'green' : ($average_2_cy <= 90 ? 'yellow' : ($average_2_cy <= 100 ? 'grey' : 'red'));
    }

    //analysis 2 next year
    $count2_ny = '';
    $data['show2_ny'] = 'red';
    $data['analysis_2_ny'] = 0;
    $average_2_ny = (float) $data['analysis_next_year'][0]->a_i_e_ratio;
    if ($average_2_ny != 0) {
        $count2_ny = (($average_2_ny <= 80 ? 10 : ($average_2_ny <= 90 ? 7 : ($average_2_ny <= 100 ? 5 : 1))));
        $data['analysis_2_ny'] = $count2_ny;
        $data['show2_ny'] = $average_2_ny <= 80 ? 'green' : ($average_2_ny <= 90 ? 'yellow' : ($average_2_ny <= 100 ? 'grey' : 'red'));
    }

    //analysis 3 current year
    $count3_cy = '';
    $data['show3_cy'] = 'red';
    $data['analysis_3_cy'] = 0;
    $query = "SELECT * FROM family_savings_source where family_sub_mst_id=$family_id and s_type = 'Compulsory' ";
    $compulsory = DB::select($query);
    if (!empty($compulsory)) {
        $save_per_month = $compulsory[0]->s_saving_per_month;
        $expected_amt = $save_per_month * 12;
        $s_last_saved_amt = $compulsory[0]->s_last_saved_amt;
        $average_3_cy = (($s_last_saved_amt / $expected_amt) * 100);
        $data['analysis_3_cy'] = $average_3_cy > 99 ? 10 : ($average_3_cy >= 85 ? 8 : ($average_3_cy >= 75 ? 6 : 2));
        $data['show3_cy'] = $average_3_cy > 99 ? 'green' : ($average_3_cy >= 85 ? 'yellow' : ($average_3_cy >= 75 ? 'grey' : 'red'));
    }





    //analysis 34current year
    $count4_cy = '';
    $data['show4_cy'] = 'red';
    $data['analysis_4_cy'] = 0;
    $quer4 = "SELECT s_contribute_regular FROM family_savings_source where family_sub_mst_id=$family_id and s_type = 'Voluntary' ";
    $average_4_cy = DB::select($quer4);

    if (!empty($average_4_cy)) {
        if ($average_4_cy[0]->s_contribute_regular == 'Yes') {
            $data['analysis_4_cy'] = 2;
            $data['show4_cy'] = 'green';
        } else {
            $data['analysis_4_cy'] = 0;
            $data['show4_cy'] = 'red';
        }
    }

    //analysis 35current year
    $count_other = '';
    $data['show_other'] = 'red';
    $data['analysis_other'] = 0;
    $query = "SELECT other_amount FROM family_savings_source_other where family_sub_mst_id=$family_id  ";
    $average_other = DB::select($query);

    if (!empty($average_other)) {
        $count_other = $average_other[0]->other_amount != '' ? 5 : 0;
        if ($average_other[0]->other_amount != '') {
            $data['analysis_other'] = 2;
            $data['show_other'] = 'green';
        } else {
            $data['analysis_other'] = 0;
            $data['show_other'] = 'red';
        }
    }

    $query = "SELECT
            COALESCE(SUM(a.sum), 0) AS saving_total
        FROM
            (
            SELECT
                a.s_last_saved_amt AS SUM
            FROM
                family_savings_source AS a
            WHERE
                a.family_sub_mst_id = $family_id
            UNION ALL
        SELECT
            b.last_saved_amt AS SUM
        FROM
            family_savings_source_other AS b
        WHERE
            b.family_sub_mst_id = $family_id
        ) a";

    $data['saving_total'] = DB::select($query);

    //analysis 5 current year

    $saving_total = $data['saving_total'][0]->saving_total;


    $count5_cy = '';
    $data['show5_cy'] = 'red';
    $data['analysis_5_cy'] = 0;
    $average_5_cy = '';
    if ($saving_total > 0 && $total_income_this > 0) {
        $average_5_cy = (float) (($saving_total / $total_income_this) * 100);
    }


    if ($average_5_cy != '') {
        $data['analysis_5_cy'] = (($average_5_cy >= 10 ? 8 : ($average_5_cy >= 5 ? 7 : ($average_5_cy >= 2 ? 5 : 2))));

        $data['show5_cy'] = (($average_5_cy >= 10 ? 'green' : ($average_5_cy >= 5 ? 'yellow' : ($average_5_cy >= 2 ? 'grey' : 'red'))));
    }

    // pr($saving_total);
    // prd($total_income_next);
    //analysis 5 next year
    $count5_ny = '';
    $data['show5_ny'] = 'red';
    $data['analysis_5_ny'] = 0;
    $average_5_ny = '';
    if ($saving_total > 0 && $total_income_next > 0) {
        $average_5_ny = (float) (($saving_total / $total_income_next) * 100);
    }
    if ($average_5_ny != '') {
        $data['analysis_5_ny'] = (($average_5_ny >= 10 ? 8 : ($average_5_ny >= 5 ? 7 : ($average_5_ny >= 2 ? 5 : 2))));

        $data['show5_ny'] = (($average_5_ny >= 10 ? 'green' : ($average_5_ny >= 5 ? 'yellow' : ($average_5_ny >= 2 ? 'grey' : 'red'))));
    }


    //analysis 6 current year
    $data['savings'] = DB::table('family_savings as a')
        ->where('is_deleted', '=', 0)
        ->where('a.family_sub_mst_id', '=', $family_id)
        ->get()->toArray();
    $count6_cy = '';
    $data['show6_cy'] = 'red';
    $data['analysis_6_cy'] = 0;
    $average_6_cy = $data['savings'][0]->s_passbook_physically;
    if ($average_6_cy != '') {
        if ($average_6_cy == 1) {
            $data['analysis_6_cy'] = 1;
            $data['show6_cy'] = 'green';
        } else {
            $data['analysis_6_cy'] = 0;
            $data['show6_cy'] = 'red';
        }
    }

    //analysis 7 current year
    $count7_cy = '';
    $data['show7_cy'] = 'red';
    $data['analysis_7_cy'] = 0;
    $average_7_cy = $data['analysis_this_year'][0]->a_alr_i_ratio;

    if ($average_7_cy != '') {
        $count7_cy = (($average_7_cy <= 25 ? 10 : ($average_7_cy <= 35 ? 7 : ($average_7_cy <= 50 ? 5 : ($average_7_cy > 50 ? 2 : 0)))));

        $data['analysis_7_cy'] = $count7_cy;
        if ($average_7_cy <= 25) {
            $data['show7_cy'] = 'green';
        } else if ($average_7_cy >= 26 && $average_7_cy <= 35) {
            $data['show7_cy'] = 'yellow';
        } else if ($average_7_cy >= 36 && $average_7_cy <= 50) {
            $data['show7_cy'] = 'grey';
        } else if ($average_7_cy > 50) {
            $data['show7_cy'] = 'red';
        }
    }

    //analysis 7 next year
    $count7_ny = '';
    $data['show7_ny'] = 'red';
    $data['analysis_7_ny'] = 0;
    $average_7_ny = $data['analysis_next_year'][0]->a_alr_i_ratio;
    if ($average_7_ny != '') {
        $count7_ny = (($average_7_ny <= 25 ? 10 : ($average_7_ny <= 35 ? 7 : ($average_7_ny <= 50 ? 5 : ($average_7_ny > 50 ? 2 : 0)))));
        $data['analysis_7_ny'] = $count7_ny;
        if ($average_7_ny <= 30) {
            $data['show7_ny'] = 'green';
        } else if ($average_7_ny >= 31 && $average_7_ny <= 40) {
            $data['show7_ny'] = 'yellow';
        } else if ($average_7_ny >= 41 && $average_7_ny <= 50) {
            $data['show7_ny'] = 'grey';
        } else if ($average_7_ny > 50) {
            $data['show7_ny'] = 'red';
        }
    }

    //analysis 8 current year
    $count8_cy = '';
    $data['show8_cy'] = 'red';
    $data['analysis_8_cy'] = 0;
    $average_8_cy = (float) $data['analysis_this_year'][0]->a_debit_ratio;
    // pr($average_8_cy);
    if ($average_8_cy != '') {
        $count8_cy = (($average_8_cy >= 1.25 ? 10 : ($average_8_cy >= 1.00 ? 7 : ($average_8_cy >= 0.5 ? 3 : 0))));
        $data['analysis_8_cy'] = $count8_cy;

        if ($average_8_cy >= 1.25) {
            $data['show8_cy'] = 'green';
        } else if ($average_8_cy >= 1 && $average_8_cy < 1.25) {
            $data['show8_cy'] = 'yellow';
        } else if ($average_8_cy >= 0.5 && $average_8_cy <= 0.99) {
            $data['show8_cy'] = 'grey';
        } else if ($average_8_cy < 0.5) {
            $data['show8_cy'] = 'red';
        }
    }

    //analysis 8 next year
    $count8_ny = '';
    $data['show8_ny'] = 'red';
    $data['analysis_8_ny'] = 0;
    $average_8_ny = (float) $data['analysis_next_year'][0]->a_debit_ratio;
    // prd($average_8_ny);
    if ($average_8_ny != '') {
        $count8_ny = (($average_8_ny >= 1.25 ? 10 : ($average_8_ny >= 1.00 ? 7 : ($average_8_ny >= 0.5 ? 3 : 0))));

        $data['analysis_8_ny'] = $count8_ny;

        if ($average_8_ny >= 1.25) {
            $data['show8_ny'] = 'green';
        } else if ($average_8_ny >= 1 && $average_8_ny <= 1.24) {
            $data['show8_ny'] = 'yellow';
        } else if ($average_8_ny >= 0.5 && $average_8_ny <= 0.99) {
            $data['show8_ny'] = 'grey';
        } else if ($average_8_ny < 0.5) {
            $data['show8_ny'] = 'red';
        }
    }

    //analysis 9 current year
    $data['loan_outstanding'] = DB::table('family_loan_outstanding as a')
        ->where('is_deleted', '=', 0)
        ->where('a.family_sub_mst_id', '=', $family_id)
        ->get()->toArray();
    $count9_cy = '';
    $data['show9_cy'] = 'red';
    $data['analysis_9_cy'] = 0;
    $sum_overdue_cy = 0;
    $sum_emi_cy = 0;
    foreach ($data['loan_outstanding'] as $row) {

        if ($row->lo_type == 'SHG Loan' && $row->overdue != '') {

            $sum_overdue_cy = $sum_overdue_cy + $row->overdue;
            $sum_emi_cy = $sum_emi_cy + $row->monthly_emi;
        }
        if ($row->lo_type == '' && $row->overdue == '') {
            $sum_overdue_cy = '';
            $sum_emi_cy = '';
        }
    }

    if ($sum_overdue_cy != '' || $sum_emi_cy != '') {
        if ($sum_emi_cy > 0) {
            $average_9_cy = round(($sum_overdue_cy / $sum_emi_cy), 2);

            $count9_cy = (($average_9_cy < 1 ? 5 : ($average_9_cy < 2 ? 3 : ($average_9_cy <= 4 ? 1 : 0))));

            $data['show9_cy'] = (($count9_cy == 5 ? 'green' : ($count9_cy == 3 ? 'yellow' : ($count9_cy == 1 ? 'grey' : 'red'))));
            $data['analysis_9_cy'] = $count9_cy;
        } else {
            $data['analysis_9_cy'] = 5;
            $data['show9_cy'] = 'green';
        }
    } else {
        $data['analysis_9_cy'] = 5;
        $data['show9_cy'] = 'green';
    }

    $query = "SELECT fp_wealth_rank FROM family_profile where family_sub_mst_id = $family_id";
    $wealth_rank = DB::select($query)[0]->fp_wealth_rank;

    //analysis 10 current year
    $count10_cy = '';
    $data['show10_cy'] = 'red';
    $data['analysis_10_cy'] = 0;
    if (!empty($wealth_rank)) {
        $data['analysis_10_cy'] = 10;
    }

    $sum_emi_money = 0;
    $sum_overdue_money = 0;
    $num = 0;
    $no_of_days = 0;

    if (!empty($data['loan_outstanding'])) {



        foreach ($data['loan_outstanding'] as $row) {
            if ($row->lo_type == 'SHG Loan') {

                $num = $num + 1;
                $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
            }

            if ($row->lo_type == 'Money Lenders Loan') {
                $num = $num + 1;
                $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
            }
            if ($row->lo_type == 'Bank Loan') {
                $num = $num + 1;
                $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
            }
            if ($row->lo_type == 'Federation Loan') {
                $num = $num + 1;
                $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
            }
            if ($row->lo_type == 'Cluster Loan') {
                $num = $num + 1;
                $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
            }
            if ($row->lo_type == 'Other Private Loan') {
                $num = $num + 1;
                $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
            }
        }
        if (!empty($no_of_days)) {
            $average_10_cy = $no_of_days * 30;
            $data['analysis_10_cy'] = (($average_10_cy <= 30 ? 20 : ($average_10_cy <= 60 ? 12 : ($average_10_cy <= 120 ? 6 : 2))));
            $data['show10_cy'] = (($average_10_cy <= 30 ? 'green' : ($average_10_cy <= 60 ? 'yellow' : ($average_10_cy <= 120 ? 'grey' : 'red'))));
        }
    }







    //analysis 11 current year
    $count11_cy = '';
    $data['show11_cy'] = 'red';
    $data['analysis_11_cy'] = 0;
    $average_11_cy = $data['analysis_this_year'][0]->family_indebtedness;

    if ($average_11_cy != '') {
        $count11_cy = (($average_11_cy < 20 ? 10 : ($average_11_cy <= 40 ? 7 : ($average_11_cy <= 50 ? 3 : 0))));
        $data['analysis_11_cy'] = $count11_cy;
        if ($average_11_cy < 20) {
            $data['show11_cy'] = 'green';
        } else if ($average_11_cy >= 20 && $average_11_cy <= 40) {
            $data['show11_cy'] = 'yellow';
        } else if ($average_11_cy >= 41 && $average_11_cy <= 50) {
            $data['show11_cy'] = 'grey';
        } else if ($average_11_cy > 50) {
            $data['show11_cy'] = 'red';
        }
    }

    //analysis 12 current year
    $data['shgmember_commitment'] = DB::table('family_shgmember_commitment as a')
        ->where('is_deleted', '=', 0)
        ->where('a.family_sub_mst_id', '=', $family_id)
        ->get()->toArray();
    $count12_ny = '';
    $data['show12_ny'] = 'red';
    $data['analysis_12_ny'] = 0;
    $average_12_ny = $data['shgmember_commitment'][0]->yo_meeting_yes_no;

    if ($average_12_ny != '') {
        $count12_ny = ($average_12_ny == 'Yes' ? 10 : 0);
        $data['analysis_12_ny'] = $count12_ny;
        $x12_ny = ($data['analysis_12_ny'] * 100) / 10;
        $data['show12_ny'] = $x12_ny >= 90 ? 'green' : ($x12_ny >= 75 ? 'yellow' : ($x12_ny >= 60 ? 'grey' : 'red'));
    }

    //analysis 13 next year
    $count13_ny = '';
    $data['show13_ny'] = 'red';
    $data['analysis_13_ny'] = 0;
    $average_13_ny = $data['shgmember_commitment'][0]->yo_member_aware_categories;
    // prd( $average_13_ny);
    if ($average_13_ny != '') {
        $count13_ny = $average_13_ny == "Strong" ? 2 : ($average_13_ny == "Average" ? 1 : ($average_13_ny == "Weak" ? 0 : 0));
        $data['analysis_13_ny'] = $count13_ny;
        $x13_ny = ((int) $data['analysis_13_ny'] * 100) / 2;
        $data['show13_ny'] = $x13_ny >= 90 ? 'green' : ($x13_ny >= 75 ? 'yellow' : ($x13_ny >= 60 ? 'grey' : 'red'));
    }

    //total 4th
    $data['total_ny4'] = (float) $data['analysis_12_ny'] + (float) $data['analysis_13_ny'];
    $x2_ny = ((int) $data['total_ny4'] * 100) / 12;
    $data['score3'] = $x2_ny;
    $data['show_ny4'] = $x2_ny >= 90 ? 'green' : ($x2_ny >= 75 ? 'yellow' : ($x2_ny >= 60 ? 'grey' : 'red'));

    $data['total_cy1'] = (float) $data['analysis_1_cy'] + (float) $data['analysis_2_cy'];
    $data['score'] = ((int) $data['total_cy1'] * 100) / 15;

    $data['total_cy2'] = (int)$data['analysis_3_cy'] + (int)$data['analysis_4_cy'] + (int)$data['analysis_other'] + (int)$data['analysis_5_cy'] + (int)$data['analysis_6_cy'];
    $data['score1'] = ((int) $data['total_cy2'] * 100) / 23;

    $data['total_cy3'] = (int)$data['analysis_7_cy'] + (int)$data['analysis_8_cy']  + (int)$data['analysis_10_cy'] + (int)$data['analysis_11_cy'];
    $data['score2'] = ((int) $data['total_cy3'] * 100) / 50;

    $data['total_cy4'] = (int) $data['analysis_12_ny'] + (float) $data['analysis_13_ny'];
    $data['score3'] = ((int) $data['total_cy4'] * 100) / 12;

    $data['grand_total_cy'] =
        (float) $data['analysis_1_cy']
        + (float) $data['analysis_2_cy']
        + (int) $data['analysis_3_cy']
        + (int) $data['analysis_4_cy']
        + (int) $data['analysis_other']
        + (int) $data['analysis_5_cy']
        + (int) $data['analysis_6_cy']
        + (int) $data['analysis_7_cy']
        + (int) $data['analysis_8_cy']
        + (int) $data['analysis_10_cy']
        + (int) $data['analysis_11_cy']
        + (int) $data['analysis_12_ny']
        + (float) $data['analysis_13_ny'];

    $data['grand_total_ny'] =
        (float) $data['analysis_1_ny']
        + (float) $data['analysis_2_ny']
        + (int) $data['analysis_5_ny']
        + (int)$data['analysis_7_ny']
        + (int)$data['analysis_8_ny']
        + (int)$data['analysis_12_ny'];

    $total_grd = ($data['grand_total_cy'] * 100) / 100;

    $data['grdcolor'] = $total_grd >= 90 ? 'green' : ($total_grd >= 75 ? 'yellow' : ($total_grd >= 60 ? 'grey' : 'red'));

    // $data['show_final_status'] = $grdcolor == 'green' ? 'Minimal Risk' : ($grdcolor == 'yellow' ? ' Low Risk' : ($grdcolor == 'grey' ? 'Moderate Risk' : 'High Risk'));

    $data['show_final_status'] = $data['grdcolor'] == 'green' ? 'Minimal Risk' : ($data['grdcolor'] == 'yellow' ? ' Low Risk' : ($data['grdcolor'] == 'grey' ? 'Moderate Risk' : 'High Risk'));

    return $data;
}

}


