<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CummulativeReportController extends Controller
{

    public $curdate = '';
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
        $model = [];
        $total = 0;
        $t_as='';
        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
        }
        if (!empty($request->get('ytsearch01'))) {
             Session::put('Cummulative_filter_session',$request->all());

        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('Cummulative_filter_session');
        }
            $session_data = Session::get('Cummulative_filter_session');

        //prd($session_data);
            $model = array();
        //-------------------

        //---------------

        $Q_country_family = '';
        $Q_agency_family = '';
        $Q_state_family = '';
        $Q_district_family = '';
        $Q_dt_rang_family = '';
        $SearchQuery_family = '';

        $Q_country_shg = '';
        $Q_state_shg = '';
        $Q_district_shg = '';
        $Q_dt_rang_shg = '';
        $SearchQuery_shg = '';
        $Q_agency_shg = '';

        $Q_country_cluster = '';
        $Q_state_cluster = '';
        $Q_district_cluster = '';
        $Q_dt_rang_cluster = '';
        $SearchQuery_cluster = '';
        $Q_agency_cluster = '';

        $Q_country_federation = '';
        $Q_state_federation = '';
        $Q_district_federation = '';
        $Q_dt_rang_federation = '';
        $SearchQuery_federation = '';
        $Q_agency_federation = '';

        $model['Q'] = array();
        $model['Q']['country']= '';
        $model['Q']['state']= '';
        $model['Q']['district']= '';
        $model['Q']['agency']= '';
        $model['Q']['dt_from']= '';
        $model['Q']['dt_to']= '';
        // prd($session_data['country']);
        if(isset($session_data['ytsearch01'])){

            if((($session_data['country'])!='') && isset($session_data['country'])){
            $model['Q']['country']= trim($session_data['country']);
            $country = trim($session_data['country']);
            $country1 =$session_data['country'];
            $Q_country_family = " AND p.fp_country_id='$country1'";
            $Q_country_shg = " AND p.country_id='$country1'";
            $Q_country_cluster = " AND p.country_id='$country1'";
            $Q_country_federation = " AND p.country_id='$country1'";
            }

            if(($session_data['state']!='') && isset($session_data['state']) ){
            $model['Q']['state']= trim($session_data['state']);
            $state = trim($session_data['state']);
            $state1 = $session_data['state'];
            $Q_state_family = " AND p.fp_state_id='$state1'";
            $Q_state_shg = " AND p.state_id='$state1'";
            $Q_state_cluster = " AND p.state_id='$state1'";
            $Q_state_federation = " AND p.state_id='$state1'";
            }

            if(trim($session_data['district'])!='' && isset($session_data['district'])){
            $model['Q']['district']= trim($session_data['district']);
            $district = trim($session_data['district']);
            $district1 = $session_data['district'];
            $Q_district_family = " AND p.fp_district_id='$district1'";
            $Q_district_shg = " AND p.district_id='$district1'";
            $Q_district_cluster = " AND p.district_id='$district1'";
            $Q_district_federation = " AND p.district_id='$district1'";
            }

            if(trim($session_data['dt_from'])!='' && trim($session_data['dt_to'])!='' && isset($session_data['dt_from']) && isset($session_data['dt_to'])){
            $model['Q']['dt_from']= trim($session_data['dt_from']);
            $model['Q']['dt_to']= trim($session_data['dt_to']);
            $date_from = trim($session_data['dt_from']);
            $date_to = trim($session_data['dt_to']);
            $dt_from = str_replace('/','-',date("Y-d-m",strtotime($date_from)));
            $dt_to = str_replace('/','-',date("Y-d-m",strtotime($date_to)));

            $Q_dt_rang_family = " AND (date(m.created_at) BETWEEN '$dt_from' AND '$dt_to')";
            $Q_dt_rang_shg = " AND (date(m.created_at) BETWEEN '$dt_from' AND '$dt_to')";
            $Q_dt_rang_cluster = " AND (date(m.created_at) BETWEEN '$dt_from' AND '$dt_to')";
            $Q_dt_rang_federation = " AND (date(m.created_at) BETWEEN '$dt_from' AND '$dt_to')";
            }

            if(trim($session_data['agency'])!='' && isset($session_data['agency'])){
            $model['Q']['agency']= trim($session_data['agency']);
            $agency = trim($session_data['agency']);
            $query = "select agency_id from agency where agency_name = '$agency' ";
            $result_agency = DB::select($query);
                if(!empty($result_agency))
                {
                    $agencyid = $result_agency[0]->agency_id;
                    $Q_agency_family = " AND m.agency_id='$agencyid'";
                    $Q_agency_shg = " AND m.agency_id='$agencyid'";
                    $Q_agency_cluster = " AND m.agency_id='$agencyid'";
                    $Q_agency_federation = " AND m.agency_id='$agencyid'";
                }
                else{
                    $agencyid = 0;
                    $Q_agency_family = " AND m.agency_id='$agencyid'";
                    $Q_agency_shg = " AND m.agency_id='$agencyid'";
                    $Q_agency_cluster = " AND m.agency_id='$agencyid'";
                    $Q_agency_federation = " AND m.agency_id='$agencyid'";
                }

            }
            // if(!empty($session_data['agency']))
            // {
            //

            // }
            //---
            $SearchQuery_family = $Q_country_family. $Q_state_family .$Q_district_family .$Q_dt_rang_family .$Q_agency_family;
            $SearchQuery_shg = $Q_country_shg. $Q_state_shg .$Q_district_shg .$Q_dt_rang_shg .$Q_agency_shg;
            $SearchQuery_cluster = $Q_country_cluster. $Q_state_cluster .$Q_district_cluster .$Q_dt_rang_cluster .$Q_agency_cluster;
            $SearchQuery_federation = $Q_country_federation. $Q_state_federation .$Q_district_federation .$Q_dt_rang_federation .$Q_agency_federation;

           }

        //FAMILY SECTION---------------------------

        $Part_1_Completed = array();
        $Part_2_Completed = array();
        $Fully_Completed = array();
        $Initiated_Analytics = array();
        $Completed_Rating = array();
        $Initiated_Rating = array();

        $familyAnalyticsRatingAre = array();

        $family_Sql = "SELECT
        count(m.id) AS Family_Total,
        IFNULL(SUM(case when (s.qa_p2='V' AND s.locked=1) then 1 ELSE 0 END),0) AS Fully_Completed,
        IFNULL(SUM(case when (p.analysis_rating>=90 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS green_analysis,
        IFNULL(SUM(case when (p.analysis_rating>=75 AND p.analysis_rating <= 89 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS yellow_analysis,
        IFNULL(SUM(case when (p.analysis_rating>=60 AND p.analysis_rating <= 74 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS grey_analysis,
        IFNULL(SUM(case when (p.analysis_rating<60 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS red_analysis
        FROM family_mst AS m
        INNER JOIN family_sub_mst AS s  ON m.id = s.family_mst_id
        INNER JOIN family_profile AS p  ON s.id = p.family_sub_mst_id
        WHERE m.is_deleted=0 and m.status='A' and s.status='A' and s.dm_p1 != '' $SearchQuery_family";
        //prd($family_Sql);
        $familt_row = DB::select($family_Sql);
        $data['Family_a'] = ($familt_row);

        $family_Sql = "SELECT
        count(m.id) AS Family_Total,
        IFNULL(SUM(case when s.qa_r='V' then 1 ELSE 0 END),0) AS Completed_Rating,
        IFNULL(SUM(case when (p.fp_rate>=90 AND s.qa_r='V') then 1 ELSE 0 END),0) AS green_rate,
        IFNULL(SUM(case when (p.fp_rate>=75 AND p.fp_rate <= 89 AND s.qa_r='V') then 1 ELSE 0 END),0) AS yellow_rate,
        IFNULL(SUM(case when (p.fp_rate>=60 AND p.fp_rate <= 74 AND s.qa_r='V') then 1 ELSE 0 END),0) AS grey_rate,
        IFNULL(SUM(case when (p.fp_rate<60  AND s.qa_r='V') then 1 ELSE 0 END),0) AS red_rate
        FROM family_mst AS m
        INNER JOIN family_sub_mst AS s  ON m.id = s.family_mst_id
        INNER JOIN family_profile AS p  ON s.id = p.family_sub_mst_id
        WHERE m.is_deleted=0 AND m.status='A' AND s.status='A' AND s.qa_p2='V' AND s.dm_r != '' $SearchQuery_family";

        $familt_row = DB::select($family_Sql);
        $data['Family_r'] = ($familt_row);

         // TOTAL

        //End Fami;y section

        //SHG SECTION---------------------------

        $Shg_Full_Rating = array();
        $Shg_Initiated_Rating = array();
        $Shg_Full_Analytics = array();
        $Shg_Initiated_Analytics = array();

        $shgAnalyticsRatingAre = array();

        $shg_Sql = "SELECT
        count(m.id) AS Shg_Total,
        IFNULL(SUM(case when (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS Shg_Full_Analytics,
        IFNULL(SUM(case when p.analysis_rating>=90 and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS green_analysis,
        IFNULL(SUM(case when (p.analysis_rating>=75 AND p.analysis_rating <= 89) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS yellow_analysis,
        IFNULL(SUM(case when(p.analysis_rating>=60 AND p.analysis_rating <= 74) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS grey_analysis,
        IFNULL(SUM(case when(p.analysis_rating<60 and (s.qa_a='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS red_analysis
        FROM shg_mst m
        INNER JOIN shg_sub_mst s ON
            m.id = s.shg_mst_id
        INNER JOIN shg_profile p ON
            s.id = p.shg_sub_mst_id
        WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.dm_a != '' $SearchQuery_shg";
        $shg_row = DB::select($shg_Sql);

        $data['Shg_a'] = ($shg_row);

        $shg_Sql = "SELECT
        count(m.id) AS Shg_Total,
        IFNULL(SUM(case when s.qa_r='V' then 1 ELSE 0 END),0) AS Shg_Full_Rating,
        IFNULL(SUM(case when p.rate>=90 and s.qa_r='V' then 1 ELSE 0 END),0) AS green_rate,
        IFNULL(SUM(case when(p.rate>=75 AND p.rate <= 89) and s.qa_r='V' then 1 ELSE 0 END),0) AS yellow_rate,
        IFNULL(SUM(case when(p.rate>=60 AND p.rate <= 74) and s.qa_r='V' then 1 ELSE 0 END),0) AS grey_rate,
        IFNULL(SUM(case when(p.rate<60 and s.qa_r='V') then 1 ELSE 0 END),0) AS red_rate
        FROM shg_mst m
        INNER JOIN shg_sub_mst s ON
            m.id = s.shg_mst_id
        INNER JOIN shg_profile p ON
            s.id = p.shg_sub_mst_id
        WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.qa_a = 'V' AND s.dm_r != '' $SearchQuery_shg";
        $shg_row = DB::select($shg_Sql);

        $data['Shg_r'] = ($shg_row);


        // end shg section
         // TOTAL
          // prd($data['Shg']) ;
        //Cluster SECTION---------------------------

        $Cluster_Full_Rating = array();
        $Cluster_Initiated_Rating = array();
        $Cluster_Full_Analytics = array();
        $Cluster_Initiated_Analytics = array();

        $clusterAnalyticsRatingAre = array();

        $cluster_Sql = "SELECT
        count(m.id) AS Cluster_Total,
        IFNULL(SUM(case when (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS Cluster_Full_Analytics,
        IFNULL(SUM(case when p.analysis_rating>=90 and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS green_analysis,
        IFNULL(SUM(case when (p.analysis_rating>=75 AND p.analysis_rating <= 89) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS yellow_analysis,
        IFNULL(SUM(case when(p.analysis_rating>=60 AND p.analysis_rating <= 74) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS grey_analysis,
        IFNULL(SUM(case when(p.analysis_rating<60 and (s.qa_a='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS red_analysis
        FROM cluster_mst m
        INNER JOIN cluster_sub_mst s ON
            m.id = s.cluster_mst_id
        INNER JOIN cluster_profile p ON
            s.id = p.cluster_sub_mst_id
        WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.dm_a != '' $SearchQuery_cluster";
        $cluster_row = DB::select($cluster_Sql);
        $data['Cluster_a'] = ($cluster_row);  // TOTAL

        $cluster_Sql = "SELECT
        count(m.id) AS Cluster_Total,
        IFNULL(SUM(case when s.qa_r='V' then 1 ELSE 0 END),0) AS Cluster_Full_Rating,
        IFNULL(SUM(case when p.rate>=90 and s.qa_r='V' then 1 ELSE 0 END),0) AS green_rate,
        IFNULL(SUM(case when(p.rate>=75 AND p.rate <= 89) and s.qa_r='V' then 1 ELSE 0 END),0) AS yellow_rate,
        IFNULL(SUM(case when(p.rate>=60 AND p.rate <= 74) and s.qa_r='V' then 1 ELSE 0 END),0) AS grey_rate,
        IFNULL(SUM(case when(p.rate<60 and s.qa_r='V') then 1 ELSE 0 END),0) AS red_rate
        FROM cluster_mst m
        INNER JOIN cluster_sub_mst s ON
            m.id = s.cluster_mst_id
        INNER JOIN cluster_profile p ON
            s.id = p.cluster_sub_mst_id
        WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.qa_a = 'V' AND s.dm_r != '' $SearchQuery_cluster";
        $cluster_row = DB::select($cluster_Sql);
        $data['Cluster_r'] = ($cluster_row);
        //end cluster

       //Federation SECTION---------------------------
                $federatin_Sql = "SELECT
                count(m.id) AS Federation_Total,
                IFNULL(SUM(case when (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS Federation_Full_Analytics,
                IFNULL(SUM(case when p.analysis_rating>=90 and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS green_analysis,
                IFNULL(SUM(case when (p.analysis_rating>=75 AND p.analysis_rating <= 89) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS yellow_analysis,
                IFNULL(SUM(case when(p.analysis_rating>=60 AND p.analysis_rating <= 74) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS grey_analysis,
                IFNULL(SUM(case when(p.analysis_rating<60) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS red_analysis
                FROM federation_mst m
                INNER JOIN federation_sub_mst s ON
                    m.id = s.federation_mst_id
                INNER JOIN federation_profile p ON
                    s.id = p.federation_sub_mst_id
                WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.dm_a != '' $SearchQuery_federation";
        $federatin_row = DB::select($federatin_Sql);
        //prd( $federatin_row);
        $data['Federation_a'] = ($federatin_row);  // TOTAL

        //Federation SECTION---------------------------
                $federatin_Sql = "SELECT
                count(m.id) AS Federation_Total,
                IFNULL(SUM(case when s.qa_r then 1 ELSE 0 END),0) AS Federation_Full_Rating,
                IFNULL(SUM(case when p.rate>=90 and s.qa_r  then 1 ELSE 0 END),0) AS green_rate,
                IFNULL(SUM(case when(p.rate>=75 AND p.rate <= 89) and s.qa_r then 1 ELSE 0 END),0) AS yellow_rate,
                IFNULL(SUM(case when(p.rate>=60 AND p.rate <= 74) and s.qa_r then 1 ELSE 0 END),0) AS grey_rate,
                IFNULL(SUM(case when(p.rate<60 and s.qa_r) then 1 ELSE 0 END),0) AS red_rate
                FROM federation_mst m
                INNER JOIN federation_sub_mst s ON
                    m.id = s.federation_mst_id
                INNER JOIN federation_profile p ON
                    s.id = p.federation_sub_mst_id
                WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.qa_a = 'V' AND s.dm_r != '' $SearchQuery_federation";
        $federatin_row = DB::select($federatin_Sql);
        //prd( $federatin_row);
        $data['Federation_r'] = ($federatin_row);  // TOTAL

        $data['countries'] = DB::table('countries')
                        ->where('is_deleted', '=', 0)
                        ->get()->toArray();
       if (!empty($session_data)) {
                if ($session_data['ytsearch01'] !='') {
                    $country_id = $session_data['country'];
                    $state_id = $session_data['state'];
                    $district_id = $session_data['district'];
                    $data['agency'] = $session_data['agency'];
                    $data['from'] = $session_data['dt_from'];
                    $data['to'] = $session_data['dt_to'];

                    $data['country_name'] ='' ;
                    $data['state_name'] ='' ;
                    $data['district_name'] = '';
                    if ($country_id !='') {
                        $query="select name from countries where id=$country_id";
                        $data['country_name'] = DB::select($query);
                    }
                    if ($state_id !='') {
                        $query="select name from states where id=$state_id";
                        $data['state_name'] = DB::select($query);
                    }
                    if ($district_id !='') {
                        $query="select name from district where id=$district_id";
                        $data['district_name'] = DB::select($query);
                    }
                }
            }
        $data['model']=$model;
       return view('CummulativeReport.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function exportPDF()
    {
        $data = [];
        $session_data = Session::get('Cummulative_filter_session');
        //prd($session_data);
        $model = array();
        //-------------------

        //---------------

        $Q_country_family = '';
        $Q_state_family = '';
        $Q_district_family = '';
        $Q_dt_rang_family = '';
        $Q_agency_family = '';
        $SearchQuery_family = '';

        $Q_country_shg = '';
        $Q_state_shg = '';
        $Q_district_shg = '';
        $Q_dt_rang_shg = '';
        $Q_agency_shg = '';
        $SearchQuery_shg = '';

        $Q_country_cluster = '';
        $Q_state_cluster = '';
        $Q_district_cluster = '';
        $Q_dt_rang_cluster = '';
        $Q_agency_cluster = '';
        $SearchQuery_cluster = '';

        $Q_country_federation = '';
        $Q_state_federation = '';
        $Q_district_federation = '';
        $Q_dt_rang_federation = '';
        $Q_agency_federation = '';
        $SearchQuery_federation = '';

        $model['Q'] = array();
        $model['Q']['country']= '';
        $model['Q']['state']= '';
        $model['Q']['district']= '';
        $model['Q']['agency']= '';
        $model['Q']['dt_from']= '';
        $model['Q']['dt_to']= '';
        // prd($session_data['country']);
        if(isset($session_data['ytsearch01'])){

            if((($session_data['country'])!='') && isset($session_data['country'])){
            $model['Q']['country']= trim($session_data['country']);
            $country = trim($session_data['country']);
            $country1 =$session_data['country'];
            $Q_country_family = " AND p.fp_country_id='$country1'";
            $Q_country_shg = " AND p.country_id='$country1'";
            $Q_country_cluster = " AND p.country_id='$country1'";
            $Q_country_federation = " AND p.country_id='$country1'";
            }

            if(($session_data['state']!='') && isset($session_data['state']) ){
            $model['Q']['state']= trim($session_data['state']);
            $state = trim($session_data['state']);
            $state1 = $session_data['state'];
            $Q_state_family = " AND p.fp_state_id='$state1'";
            $Q_state_shg = " AND p.state_id='$state1'";
            $Q_state_cluster = " AND p.state_id='$state1'";
            $Q_state_federation = " AND p.state_id='$state1'";
            }

            if(trim($session_data['district'])!='' && isset($session_data['district'])){
            $model['Q']['district']= trim($session_data['district']);
            $district = trim($session_data['district']);
            $district1 = $session_data['district'];
            $Q_district_family = " AND p.fp_district_id='$district1'";
            $Q_district_shg = " AND p.district_id='$district1'";
            $Q_district_cluster = " AND p.district_id='$district1'";
            $Q_district_federation = " AND p.district_id='$district1'";
            }

            if(trim($session_data['dt_from'])!='' && trim($session_data['dt_to'])!='' && isset($session_data['dt_from']) && isset($session_data['dt_to'])){
            $model['Q']['dt_from']= trim($session_data['dt_from']);
            $model['Q']['dt_to']= trim($session_data['dt_to']);
            $date_from = trim($session_data['dt_from']);
            $date_to = trim($session_data['dt_to']);
            $dt_from = str_replace('/','-',date("Y-d-m",strtotime($date_from)));
            $dt_to = str_replace('/','-',date("Y-d-m",strtotime($date_to)));
            $Q_dt_rang_family = " AND (date(m.created_at) BETWEEN '$dt_from' AND '$dt_to')";
            $Q_dt_rang_shg = " AND (date(m.created_at) BETWEEN '$dt_from' AND '$dt_to')";
            $Q_dt_rang_cluster = " AND (date(m.created_at) BETWEEN '$dt_from' AND '$dt_to')";
            $Q_dt_rang_federation = " AND (date(m.created_at) BETWEEN '$dt_from' AND '$dt_to')";
            }

            if(trim($session_data['agency'])!='' && isset($session_data['agency'])){
                //die('test');
                $model['Q']['agency']= trim($session_data['agency']);
                $agency = trim($session_data['agency']);
                $query = "select agency_id from agency where agency_name = '$agency' ";
                $result_agency = DB::select($query);
                if(!empty($result_agency))
                {
                    $agencyid = $result_agency[0]->agency_id;
                    $Q_agency_family = " AND m.agency_id='$agencyid'";
                    $Q_agency_shg = " AND m.agency_id='$agencyid'";
                    $Q_agency_cluster = " AND m.agency_id='$agencyid'";
                    $Q_agency_federation = " AND m.agency_id='$agencyid'";
                }
                else{
                    $agencyid = 0;
                    $Q_agency_family = " AND m.agency_id='$agencyid'";
                    $Q_agency_shg = " AND m.agency_id='$agencyid'";
                    $Q_agency_cluster = " AND m.agency_id='$agencyid'";
                    $Q_agency_federation = " AND m.agency_id='$agencyid'";
                }
            }
            //---
            $SearchQuery_family = $Q_country_family. $Q_state_family .$Q_district_family .$Q_dt_rang_family .$Q_agency_family;
            $SearchQuery_shg = $Q_country_shg. $Q_state_shg .$Q_district_shg .$Q_dt_rang_shg .$Q_agency_shg;
            $SearchQuery_cluster = $Q_country_cluster. $Q_state_cluster .$Q_district_cluster .$Q_dt_rang_cluster .$Q_agency_cluster;
            $SearchQuery_federation = $Q_country_federation. $Q_state_federation .$Q_district_federation .$Q_dt_rang_federation .$Q_agency_federation;

            // $SearchQuery_family = $Q_country_family. $Q_state_family .$Q_district_family .$Q_dt_rang_family;
            // $SearchQuery_shg = $Q_country_shg. $Q_state_shg .$Q_district_shg .$Q_dt_rang_shg;
            // $SearchQuery_cluster = $Q_country_cluster. $Q_state_cluster .$Q_district_cluster .$Q_dt_rang_cluster;
            // $SearchQuery_federation = $Q_country_federation. $Q_state_federation .$Q_district_federation .$Q_dt_rang_federation;

           }

        //FAMILY SECTION---------------------------

        $Part_1_Completed = array();
        $Part_2_Completed = array();
        $Fully_Completed = array();
        $Initiated_Analytics = array();
        $Completed_Rating = array();
        $Initiated_Rating = array();

        $familyAnalyticsRatingAre = array();

        $family_Sql = "SELECT
            count(m.id) AS Initiated_Analytics,
            IFNULL(SUM(case when (s.qa_p2='V' AND s.locked=1) then 1 ELSE 0 END),0) AS Fully_Completed,
            IFNULL(SUM(case when (p.analysis_rating>=90 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS green_analysis,
            IFNULL(SUM(case when (p.analysis_rating>=75 AND p.analysis_rating <= 89 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS yellow_analysis,
            IFNULL(SUM(case when (p.analysis_rating>=60 AND p.analysis_rating <= 74 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS grey_analysis,
            IFNULL(SUM(case when (p.analysis_rating<60 AND (s.qa_p2='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS red_analysis
            FROM family_mst AS m
            INNER JOIN family_sub_mst AS s  ON m.id = s.family_mst_id
            INNER JOIN family_profile AS p  ON s.id = p.family_sub_mst_id
            WHERE m.is_deleted=0 and m.status='A' and s.status='A' and s.dm_p1 != '' $SearchQuery_family";
        $familt_row = DB::select($family_Sql);
        $data['Family_a'] = ($familt_row);

        $family_Sql = "SELECT
            count(m.id) AS Initiated_Rating,
            IFNULL(SUM(case when s.qa_r='V' then 1 ELSE 0 END),0) AS Completed_Rating,
            IFNULL(SUM(case when (p.fp_rate>=90 AND s.qa_r='V') then 1 ELSE 0 END),0) AS green_rate,
            IFNULL(SUM(case when (p.fp_rate>=75 AND p.fp_rate <= 89 AND s.qa_r='V') then 1 ELSE 0 END),0) AS yellow_rate,
            IFNULL(SUM(case when (p.fp_rate>=60 AND p.fp_rate <= 74 AND s.qa_r='V') then 1 ELSE 0 END),0) AS grey_rate,
            IFNULL(SUM(case when (p.fp_rate<60  AND s.qa_r='V') then 1 ELSE 0 END),0) AS red_rate
            FROM family_mst AS m
            INNER JOIN family_sub_mst AS s  ON m.id = s.family_mst_id
            INNER JOIN family_profile AS p  ON s.id = p.family_sub_mst_id
            WHERE m.is_deleted=0 AND m.status='A' AND s.status='A' AND s.qa_p2='V' AND s.dm_r != '' $SearchQuery_family";
        $familt_row = DB::select($family_Sql);
        $data['Family_r'] = ($familt_row);

         // TOTAL

        //End Fami;y section

        //SHG SECTION---------------------------

        $Shg_Full_Rating = array();
        $Shg_Initiated_Rating = array();
        $Shg_Full_Analytics = array();
        $Shg_Initiated_Analytics = array();

        $shgAnalyticsRatingAre = array();

        $shg_Sql = "SELECT
            count(m.id) AS Shg_Initiated_Analytics,
            IFNULL(SUM(case when (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS Shg_Full_Analytics,
            IFNULL(SUM(case when p.analysis_rating>=90 and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS green_analysis,
            IFNULL(SUM(case when (p.analysis_rating>=75 AND p.analysis_rating <= 89) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS yellow_analysis,
            IFNULL(SUM(case when(p.analysis_rating>=60 AND p.analysis_rating <= 74) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS grey_analysis,
            IFNULL(SUM(case when(p.analysis_rating<60 and (s.qa_a='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS red_analysis
            FROM shg_mst m
            INNER JOIN shg_sub_mst s ON
                m.id = s.shg_mst_id
            INNER JOIN shg_profile p ON
                s.id = p.shg_sub_mst_id
            WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.dm_a != '' $SearchQuery_shg";
        $shg_row = DB::select($shg_Sql);
        $data['Shg_a'] = ($shg_row);

        $shg_Sql = "SELECT
            count(m.id) AS Shg_Initiated_Rating,
            IFNULL(SUM(case when s.qa_r='V' then 1 ELSE 0 END),0) AS Shg_Full_Rating,
            IFNULL(SUM(case when p.rate>=90 and s.qa_r='V' then 1 ELSE 0 END),0) AS green_rate,
            IFNULL(SUM(case when(p.rate>=75 AND p.rate <= 89) and s.qa_r='V' then 1 ELSE 0 END),0) AS yellow_rate,
            IFNULL(SUM(case when(p.rate>=60 AND p.rate <= 74) and s.qa_r='V' then 1 ELSE 0 END),0) AS grey_rate,
            IFNULL(SUM(case when(p.rate<60 and s.qa_r='V') then 1 ELSE 0 END),0) AS red_rate
            FROM shg_mst m
            INNER JOIN shg_sub_mst s ON
                m.id = s.shg_mst_id
            INNER JOIN shg_profile p ON
                s.id = p.shg_sub_mst_id
            WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.qa_a = 'V' AND s.dm_r != '' $SearchQuery_shg";
        $shg_row = DB::select($shg_Sql);
        $data['Shg_r'] = ($shg_row);


        // end shg section
         // TOTAL
          // prd($data['Shg']) ;
        //Cluster SECTION---------------------------

        $Cluster_Full_Rating = array();
        $Cluster_Initiated_Rating = array();
        $Cluster_Full_Analytics = array();
        $Cluster_Initiated_Analytics = array();

        $clusterAnalyticsRatingAre = array();

        $cluster_Sql = "SELECT
            count(m.id) AS Cluster_Initiated_Analytics,
            IFNULL(SUM(case when (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS Cluster_Full_Analytics,
            IFNULL(SUM(case when p.analysis_rating>=90 and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS green_analysis,
            IFNULL(SUM(case when (p.analysis_rating>=75 AND p.analysis_rating <= 89) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS yellow_analysis,
            IFNULL(SUM(case when(p.analysis_rating>=60 AND p.analysis_rating <= 74) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS grey_analysis,
            IFNULL(SUM(case when(p.analysis_rating<60 and (s.qa_a='V' AND s.locked=1)) then 1 ELSE 0 END),0) AS red_analysis
            FROM cluster_mst m
            INNER JOIN cluster_sub_mst s ON
                m.id = s.cluster_mst_id
            INNER JOIN cluster_profile p ON
                s.id = p.cluster_sub_mst_id
            WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.dm_a != '' $SearchQuery_cluster";
        $cluster_row = DB::select($cluster_Sql);
        $data['Cluster_a'] = ($cluster_row);  // TOTAL

        $cluster_Sql = "SELECT
            count(m.id) AS Cluster_Initiated_Rating,
            IFNULL(SUM(case when s.qa_r='V' then 1 ELSE 0 END),0) AS Cluster_Full_Rating,
            IFNULL(SUM(case when p.rate>=90 and s.qa_r='V' then 1 ELSE 0 END),0) AS green_rate,
            IFNULL(SUM(case when(p.rate>=75 AND p.rate <= 89) and s.qa_r='V' then 1 ELSE 0 END),0) AS yellow_rate,
            IFNULL(SUM(case when(p.rate>=60 AND p.rate <= 74) and s.qa_r='V' then 1 ELSE 0 END),0) AS grey_rate,
            IFNULL(SUM(case when(p.rate<60 and s.qa_r='V') then 1 ELSE 0 END),0) AS red_rate
            FROM cluster_mst m
            INNER JOIN cluster_sub_mst s ON
                m.id = s.cluster_mst_id
            INNER JOIN cluster_profile p ON
                s.id = p.cluster_sub_mst_id
            WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.qa_a = 'V' AND s.dm_r != '' $SearchQuery_cluster";
        $cluster_row = DB::select($cluster_Sql);
        $data['Cluster_r'] = ($cluster_row);
        //end cluster

       //Federation SECTION---------------------------
        $federatin_Sql = "SELECT
                count(m.id) AS Federation_Initiated_Analytics,
                IFNULL(SUM(case when (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS Federation_Full_Analytics,
                IFNULL(SUM(case when p.analysis_rating>=90 and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS green_analysis,
                IFNULL(SUM(case when (p.analysis_rating>=75 AND p.analysis_rating <= 89) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS yellow_analysis,
                IFNULL(SUM(case when (p.analysis_rating>=60 AND p.analysis_rating <= 74) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS grey_analysis,
                IFNULL(SUM(case when (p.analysis_rating<60) and (s.qa_a='V' AND s.locked=1) then 1 ELSE 0 END),0) AS red_analysis
                FROM federation_mst m
                INNER JOIN federation_sub_mst s ON
                    m.id = s.federation_mst_id
                INNER JOIN federation_profile p ON
                    s.id = p.federation_sub_mst_id
                WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.dm_a != '' $SearchQuery_federation";
        $federatin_row = DB::select($federatin_Sql);
        //prd( $federatin_row);
        $data['Federation_a'] = ($federatin_row);  // TOTAL

        //Federation SECTION---------------------------
        $federatin_Sql = "SELECT
                count(m.id) AS Federation_Initiated_Rating,
                IFNULL(SUM(case when s.qa_r then 1 ELSE 0 END),0) AS Federation_Full_Rating,
                IFNULL(SUM(case when p.rate>=90 and s.qa_r  then 1 ELSE 0 END),0) AS green_rate,
                IFNULL(SUM(case when(p.rate>=75 AND p.rate <= 89) and s.qa_r then 1 ELSE 0 END),0) AS yellow_rate,
                IFNULL(SUM(case when(p.rate>=60 AND p.rate <= 74) and s.qa_r then 1 ELSE 0 END),0) AS grey_rate,
                IFNULL(SUM(case when(p.rate<60 and s.qa_r) then 1 ELSE 0 END),0) AS red_rate
                FROM federation_mst m
                INNER JOIN federation_sub_mst s ON
                    m.id = s.federation_mst_id
                INNER JOIN federation_profile p ON
                    s.id = p.federation_sub_mst_id
                WHERE m.is_deleted=0 AND m.status='A' and s.status='A' and s.qa_a = 'V' AND s.dm_r != '' $SearchQuery_federation";
        $federatin_row = DB::select($federatin_Sql);
        $data['Federation_r'] = ($federatin_row);  // TOTAL

        $data['model']=$model;
        $data['session_data'] =  $session_data;
        //prd($data['session_data']);
        // return view('family-wealth-report_export_pdf')->with($data);
        view()->share('res', $data);
        $pdf_doc = PDF::loadView('pdf.cummulative-report-pdf', $data)->setPaper('a4', 'landscape');
        return $pdf_doc->download('Cummulative-Report-'.pdf_date().'.pdf');
        //return $pdf_doc->stream('cummulative-report.pdf');

    }
}
