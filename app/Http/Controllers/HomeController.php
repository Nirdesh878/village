<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ClusterProfile;
use App\Models\ShgProfile;
use App\Models\FederationProfile;
use App\Models\FamilyProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $limit = 5;
    public function __construct()
    {
        $this->middleware('auth');
        $user_geo = Session::get('user_details');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //echo date('d m Y h:i');

        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
        $data = [];
        $data['u_type'] = $user->u_type;
        $user_type = $data['u_type'];
        $user_geo = DB::table('user_location_relation')
            ->where('user_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->orderBy('country_id')
            ->get()->toArray();

        //prd($user_geo);



        $query = DB::table('federation_mst as f')
            ->join('federation_sub_mst as s', 's.federation_mst_id', '=', 'f.id')
            ->join('federation_profile as a', 'a.federation_sub_mst_id', '=', 's.id')
            ->select('a.*', 'f.uin', 'f.id as federation_mst_id', 'f.status','f.created_at as created', 's.status as fed_status', 's.analytics', 's.rating','s.dm_a','s.qa_a','s.dm_r','s.qa_r','s.updated_at','s.locked','s.flag')
            ->where('f.is_deleted', '=', 0)
            ->where('a.is_deleted', '=', 0)
            ->orderBy('s.updated_at', 'desc')
            ->orderBy('f.id', 'desc')
            ->limit($this->limit);



        $data['federations'] = $query->get()->toArray();


        $query = DB::table('cluster_mst as f')
            ->join('cluster_sub_mst as s', 's.cluster_mst_id', '=', 'f.id')
            ->join('cluster_profile as a', 'a.cluster_sub_mst_id', '=', 's.id')
            ->select('a.*', 'f.uin', 'f.id as cluster_mst_id', 'f.status','f.created_at as created', 's.status as clust_status', 's.analytics', 's.rating','s.dm_a','s.qa_a','s.dm_r','s.qa_r','s.updated_at','s.locked','s.flag')
            ->where('f.is_deleted', '=', 0)
            ->where('a.is_deleted', '=', 0)
            ->orderBy('s.updated_at', 'desc')
            ->orderBy('f.id', 'desc')
            ->limit($this->limit);
        $data['clusters'] = $query->get()->toArray();

        $query = DB::table('family_mst as f')
            ->join('family_sub_mst as s', 's.family_mst_id', '=', 'f.id')
            ->join('family_profile as a', 'a.family_sub_mst_id', '=', 's.id')
            ->select('a.*', 'f.uin', 'f.id as family_mst_id', 'f.status','f.created_at as created', 's.analytics', 's.rating','s.dm_p1','s.dm_p2','s.qa_p1','s.qa_p2','s.qa_r','s.dm_r','s.locked','s.updated_at','s.flag')
            ->where('f.is_deleted', '=', 0)
            ->where('a.is_deleted', '=', 0)
            ->orderBy('s.updated_at', 'desc')
            ->orderBy('f.id', 'desc')
            ->limit($this->limit);
        $data['families'] = $query->get()->toArray();

        $query = DB::table('shg_mst as f')
            ->join('shg_sub_mst as s', 's.shg_mst_id', '=', 'f.id')
            ->join('shg_profile as a', 'a.shg_sub_mst_id', '=', 's.id')
            ->select('a.*', 'f.uin', 'f.id as shg_mst_id', 'f.status','f.created_at as created', 's.analytics', 's.rating','s.dm_a','s.qa_a','s.dm_r','s.qa_r','s.updated_at','s.locked','s.flag')
            ->where('f.is_deleted', '=', 0)
            ->where('a.is_deleted', '=', 0)
            ->orderBy('s.updated_at', 'desc')
            ->orderBy('f.id', 'desc')
            ->limit($this->limit);
        $data['shgs'] = $query->get()->toArray();

        //------------------------------ shg --------------------------
        // shg Total
        $query1 = "SELECT * FROM shg_mst
        inner join shg_sub_mst
        on
         shg_sub_mst.shg_mst_id=shg_mst.id
         INNER JOIN shg_profile AS j
                ON
                    j.shg_sub_mst_id = shg_sub_mst.id
            where shg_mst.status='A' and shg_mst.is_deleted='0' and shg_sub_mst.dm_a != '' ";

            // prd($query1 );
        $Shg_Total = DB::select($query1);
        $model['Shg_Total'] = count($Shg_Total);

        //visit complete
        $query2 = "SELECT
                    COUNT(*) AS total
                FROM
                    shg_mst a
                INNER JOIN shg_sub_mst b ON
                    a.id = b.shg_mst_id
                    INNER JOIN shg_profile AS j
                ON
                    j.shg_sub_mst_id = b.id
                WHERE
                    a.is_deleted = 0 AND (b.dm_a = 'P' or b.dm_a = 'V' or b.dm_a = 'R')";

                    // prd($query2);
        $Shg_visit = DB::select($query2);
        if (!empty($Shg_visit)) {
            $model['Shg_visit'] = $Shg_visit[0]->total;
        } else {
            $model['Shg_visit'] = 0;
        }

        //Analytics Complete
        $query3 = "SELECT
                        COUNT(*) as verify
                    FROM
                        shg_mst a
                    INNER JOIN shg_sub_mst b ON
                        a.id = b.shg_mst_id
                        INNER JOIN shg_profile AS j
                ON
                    j.shg_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND b.dm_a = 'V'";

                        //prd($query3);
        $Shg_Full_Analytics = DB::select($query3);
        if (!empty($Shg_Full_Analytics)) {
            $model['Shg_Full_Analytics'] = $Shg_Full_Analytics[0]->verify;
        } else {
            $model['Shg_Full_Analytics'] = 0;
        }


        //Verified/Locked
        $query4 = "SELECT
                    COUNT(*) as locked
                FROM
                        shg_mst a
                    INNER JOIN shg_sub_mst b ON
                        a.id = b.shg_mst_id
                    WHERE
                        a.is_deleted = 0 AND b.dm_a = 'V' AND b.qa_a = 'V' AND b.locked=1";
        $verified_shg = DB::select($query4);

        if (!empty($verified_shg)) {
            $model['Shg_verified'] = $verified_shg[0]->locked;
        } else {
            $model['Shg_verified'] = 0;
        }

        //prd($query);
        // $query4 = "SELECT
        //                 COUNT(*) as verify
        //             FROM
        //                 shg_mst a
        //             INNER JOIN shg_sub_mst b ON
        //                 a.id = b.shg_mst_id
        //                 INNER JOIN shg_profile AS j
        //              ON
        //             j.shg_sub_mst_id = b.id
        //             WHERE
        //                 a.is_deleted = 0 AND b.qa_a = 'V'";
        //                 //prd($query4);
        // $Shg_verified = DB::select($query4);
        // if (!empty($Shg_verified)) {
        //     $model['Shg_verified'] = $Shg_verified[0]->verify;
        // } else {
        //     $model['Shg_verified'] = 0;
        // }

        // Full Rating
        $query5 = "SELECT
                        COUNT(*) as verify
                    FROM
                        shg_mst a
                    INNER JOIN shg_sub_mst b ON
                        a.id = b.shg_mst_id
                        INNER JOIN shg_profile AS j
                ON
                    j.shg_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND b.qa_a = 'V' ";

                        // prd($query5);
        $Shg_Full_Rating = DB::select($query5);
        if (!empty($Shg_Full_Rating)) {
            $model['Shg_Full_Rating'] = $Shg_Full_Rating[0]->verify;
        } else {
            $model['Shg_Full_Rating'] = 0;
        }


        //------------------------------ cluster --------------------------
        // cluster Total
        $query7 = "SELECT * FROM cluster_mst
        inner join cluster_sub_mst
        on
        cluster_sub_mst.cluster_mst_id=cluster_mst.id
        INNER JOIN cluster_profile AS j
                ON
                    j.cluster_sub_mst_id = cluster_sub_mst.id
        where cluster_mst.status='A' and cluster_mst.is_deleted=0 and cluster_sub_mst.dm_a != '' ";



        $Cluster_Total = DB::select($query7);
        $model['Cluster_Total'] = count($Cluster_Total);

        // Full Rating
        $query8 = "SELECT
                        COUNT(*) as verify
                    FROM
                        cluster_mst a
                    INNER JOIN cluster_sub_mst b ON
                        a.id = b.cluster_mst_id
                        INNER JOIN cluster_profile AS j
                ON
                    j.cluster_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND b.qa_a = 'V' ";

        $Cluster_Full_Rating = DB::select($query8);
        if (!empty($Cluster_Full_Rating)) {
            $model['Cluster_Full_Rating'] = $Cluster_Full_Rating[0]->verify;
        } else {
            $model['Cluster_Full_Rating'] = 0;
        }

        //visit complete
        $query9 = "SELECT
                        COUNT(*) as total
                    FROM
                        cluster_mst a
                    INNER JOIN cluster_sub_mst b ON
                        a.id = b.cluster_mst_id
                        INNER JOIN cluster_profile AS j
                ON
                    j.cluster_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND (b.dm_a = 'P' or b.dm_a = 'V' or b.dm_a = 'R') ";

        $Cluster_Visit = DB::select($query9);
        if (!empty($Cluster_Visit)) {
            $model['Cluster_Visit'] = $Cluster_Visit[0]->total;
        } else {
            $model['Cluster_Visit'] = 0;
        }

        //Analytics Complete
        $query10 = "SELECT
                        COUNT(*) as verify
                    FROM
                        cluster_mst a
                    INNER JOIN cluster_sub_mst b ON
                        a.id = b.cluster_mst_id
                        INNER JOIN cluster_profile AS j
                ON
                    j.cluster_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND b.dm_a = 'V' ";

        //prd($query10);
        $Cluster_Full_Analytics = DB::select($query10);
        if (!empty($Cluster_Full_Analytics)) {
            $model['Cluster_Full_Analytics'] = $Cluster_Full_Analytics[0]->verify;
        } else {
            $model['Cluster_Full_Analytics'] = 0;
        }

        //Verified/Locked
        $query11 = "SELECT
                    count(*) as locked
                FROM
                        cluster_mst a
                    INNER JOIN cluster_sub_mst b ON
                        a.id = b.cluster_mst_id
                    INNER JOIN cluster_profile AS j
                    ON
                    j.cluster_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND b.dm_a = 'V' AND b.qa_a = 'V' AND b.locked=1";

        $verified_clus = DB::select($query11);
        //prd($verified);
        if (!empty($verified_clus)) {
            $model['Cluster_verified'] = $verified_clus[0]->locked;
        } else {
            $model['Cluster_verified'] = 0;
        }
        //prd($model['Cluster_verified']);
        // $query11 = "SELECT
        //                 COUNT(*) as verify
        //             FROM
        //                 cluster_mst a
        //             INNER JOIN cluster_sub_mst b ON
        //                 a.id = b.cluster_mst_id
        //                 INNER JOIN cluster_profile AS j
        //         ON
        //             j.cluster_sub_mst_id = b.id
        //             WHERE
        //                 a.is_deleted = 0 AND b.qa_r = 'V'";

        // //prd($query11);
        // $Cluster_verified = DB::select($query11);
        // if (!empty($Cluster_Full_Analytics)) {
        //     $model['Cluster_verified'] = $Cluster_verified[0]->verify;
        // } else {
        //     $model['Cluster_verified'] = 0;
        // }

        //------------------------------ federation --------------------------
        // federation Total
        $query13 = "SELECT
                        *
                    FROM
                        federation_mst
                    INNER JOIN federation_sub_mst
                    ON federation_sub_mst.federation_mst_id = federation_mst.id
                    INNER JOIN federation_profile AS j
                ON
                    j.federation_sub_mst_id = federation_sub_mst.id
                    WHERE
                        federation_mst.status = 'A' AND federation_mst.is_deleted = 0 and federation_sub_mst.dm_a != '' ";


        //prd($query13);

        $Federation_Total = DB::select($query13);
        $model['Federation_Total'] = count($Federation_Total);

        // Full Rating
        $query14 = "SELECT
                        COUNT(*) as verify
                    FROM
                        federation_mst a
                    INNER JOIN federation_sub_mst b ON
                        a.id = b.federation_mst_id
                        INNER JOIN federation_profile AS j
                ON
                    j.federation_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND b.dm_a = 'V' AND b.qa_a = 'V' ";

        //prd($query14);
        $Federation_Full_Rating = DB::select($query14);
        if (!empty($Federation_Full_Rating)) {
            $model['Federation_Full_Rating'] = $Federation_Full_Rating[0]->verify;
        } else {
            $model['Federation_Full_Rating'] = 0;
        }

        //visit complete
        $query15 = "SELECT
                    COUNT(*) AS total
                FROM
                    federation_mst a
                INNER JOIN federation_sub_mst b ON
                    a.id = b.federation_mst_id
                    INNER JOIN federation_profile AS j
                ON
                    j.federation_sub_mst_id = b.id
                WHERE
                    a.is_deleted = 0 AND (b.dm_a = 'P' or b.dm_a = 'V' or b.dm_a = 'R') ";

        //prd($query15);
        $Federation_Visit = DB::select($query15);
        if (!empty($Federation_Visit)) {
            $model['Federation_Visit'] = $Federation_Visit[0]->total;
        } else {
            $model['Federation_Visit'] = 0;
        }

        //Analytics Complete
        $query16 = "SELECT
                        COUNT(*) as verify
                    FROM
                        federation_mst a
                    INNER JOIN federation_sub_mst b ON
                        a.id = b.federation_mst_id
                        INNER JOIN federation_profile AS j
                ON
                    j.federation_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND b.dm_a = 'V' ";

        //prd($query16);

        $Federation_Full_Analytics = DB::select($query16);
        if (!empty($Federation_Full_Analytics)) {
            $model['Federation_Full_Analytics'] = $Federation_Full_Analytics[0]->verify;
        } else {
            $model['Federation_Full_Analytics'] = 0;
        }

        //Verified/Locked
        $query17 = "SELECT
                    count(*) as locked
                FROM
                    federation_mst a
                    INNER JOIN federation_sub_mst b ON
                        a.id = b.federation_mst_id
                    INNER JOIN federation_profile j ON
                    j.federation_sub_mst_id = b.id
                    WHERE
                        a.is_deleted = 0 AND b.dm_a = 'V' AND b.qa_a = 'V' AND b.locked=1";

        $verified_fed = DB::select($query17);
        if (!empty($verified_fed)) {

            $model['Federation_verified'] = $verified_fed[0]->locked;
        } else {
            $model['Federation_verified'] = 0;
        }
        // $query17 = "SELECT
        //                 COUNT(*) as verify
        //             FROM
        //                 federation_mst a
        //             INNER JOIN federation_sub_mst b ON
        //                 a.id = b.federation_mst_id
        //                 INNER JOIN federation_profile j
        //             ON
        //             j.federation_sub_mst_id = b.id
        //             WHERE
        //                 a.is_deleted = 0 AND b.dm_a = 'V' AND b.qa_a = 'V' ";

        // // prd($query17);
        // $Federation_verified = DB::select($query17);
        // if (!empty($Federation_verified)) {
        //     $model['Federation_verified'] = $Federation_verified[0]->verify;

        // } else {
        //     $model['Federation_verified'] = 0;
        // }

        //------------------------------ family --------------------------

        //Family Total

        $query19 = "SELECT * FROM family_mst
        inner join family_sub_mst
        on
         family_sub_mst.family_mst_id=family_mst.id
         INNER JOIN family_profile j
         ON
         family_sub_mst_id=family_mst.id
         where family_mst.status='A' and family_sub_mst.is_deleted=0 and family_mst.is_deleted=0 and family_sub_mst.dm_p1 != '' ";

        //prd($query19);
        $Family_Total = DB::select($query19);
        $model['Family_Total'] = count($Family_Total);

        // Part 1 Completed
        $query20 = "SELECT
                    count(*) as total
                FROM
                    family_mst a
                INNER JOIN
                    family_sub_mst b
                ON
                    a.id=b.family_mst_id
                    INNER JOIN family_profile j
                ON
                   family_sub_mst_id=b.id
                WHERE
                    a.is_deleted = 0 AND (b.dm_p1 = 'P' or b.dm_p1 = 'V' or b.dm_p1 = 'R') ";

                    //prd($query20);
        $Part_1_Completed = DB::select($query20);

        if (!empty($Part_1_Completed)) {
            $model['Part_1_Completed'] = $Part_1_Completed[0]->total;
        } else {
            $model['Part_1_Completed'] = 0;
        }

        // Part 2 Completed
        $query21 = "SELECT
                    count(*) as total
                FROM
                    family_mst a
                INNER JOIN
                    family_sub_mst b
                ON
                    a.id=b.family_mst_id
                    INNER JOIN family_profile j
                ON
                   family_sub_mst_id=b.id
                WHERE
                    a.is_deleted = 0 AND (b.dm_p2 = 'P' or b.dm_p2 = 'V' or b.dm_p2 = 'R') ";
        $Part_2_Completed = DB::select($query21);

        //prd($query21);

        if (!empty($Part_2_Completed)) {
            $model['Part_2_Completed'] = $Part_2_Completed[0]->total;
        } else {
            $model['Part_2_Completed'] = 0;
        }
        // Analytics Completed
        $query22 = "SELECT
                    count(*) as total
                FROM
                    family_mst a
                INNER JOIN
                    family_sub_mst b
                ON
                    a.id=b.family_mst_id
                INNER JOIN
                    family_profile j
                on
                   j.family_sub_mst_id = b.id
                WHERE
                    a.is_deleted = 0 AND dm_p1 = 'V' AND dm_p2 = 'V' ";

                    //prd($query22);
        $Fully_Completed = DB::select($query22);

        if (!empty($Fully_Completed)) {
            $model['Fully_Completed'] = $Fully_Completed[0]->total;
        } else {
            $model['Fully_Completed'] = 0;
        }


        // Verified/Locked
        $query23 = "SELECT
                    count(*) as locked
                FROM
                    family_mst a
                INNER JOIN family_sub_mst b ON
                    a.id = b.family_mst_id
                INNER JOIN family_profile j ON
                    family_sub_mst_id = b.id
                WHERE
                    a.is_deleted = 0 AND b.qa_p1 = 'V' AND b.qa_p2 = 'V' AND b.locked=1";

        $verified = DB::select($query23);
        if (!empty($verified)) {

            $model['verified'] = $verified[0]->locked;
        } else {
            $model['verified'] = 0;
        }

        // Completed Rating/Initial Rating
        $query24 = "SELECT
                    count(*) as total
                FROM
                    family_mst a
                INNER JOIN
                    family_sub_mst b
                ON
                    a.id=b.family_mst_id
                INNER JOIN
                   family_profile j
                ON
                  family_sub_mst_id = b.id
                WHERE
                    a.is_deleted = 0 AND qa_p1 = 'V' AND qa_p2 = 'V' ";


        $Completed_Rating = DB::select($query24);
        if (!empty($Completed_Rating)) {
            $model['Completed_Rating'] = $Completed_Rating[0]->total;
        } else {
            $model['Completed_Rating'] = 0;
        }

        //loan Approved
        $query25 = "SELECT COUNT(*) as total
        FROM family_mst a
        INNER JOIN family_sub_mst b
         ON
         a.id=b.family_mst_id
        INNER JOIN family_loan_approvel c
          ON
        b.id=c.family_sub_mst_id
        INNER JOIN family_profile j
         ON
         b.id= j.family_sub_mst_id

          WHERE a.is_deleted=0 AND b.qa_p2 = 'V' AND c.get_verified = 'Verified' AND manager_id != 0 ";
        $loan_approved = DB::select($query25);

        //prd($query25);
        $model['loan_approved'] = $loan_approved[0]->total;

        //loan Disbursed
        $query26 = "SELECT COUNT(*) as total
        FROM family_mst a
        INNER JOIN family_sub_mst b
         ON a.id=b.family_mst_id
        INNER JOIN family_loan_disbursement c
         on b.id=c.family_sub_mst_id
        INNER JOIN family_profile j
         ON
         b.id= j.family_sub_mst_id
        WHERE a.is_deleted=0 AND b.qa_p2 = 'V' AND c.get_loan = 'Yes' AND quality_id != 0 ";

        //prd($query26);
        $loan_disbursed = DB::select($query26);
        $model['loan_disbursed'] = $loan_disbursed[0]->total;
        //prd($model);
        $data['model'] = $model;

        //Federation Analytics/Rating
        $query27 ="SELECT
                    COUNT(CASE WHEN c.analysis_rating >= 90 THEN 1 END ) AS Minimal_Risk,
                    COUNT(CASE WHEN(c.analysis_rating >= 75 AND c.analysis_rating <= 89 ) THEN 1 END ) AS Low_Risk,
                    COUNT(CASE WHEN(c.analysis_rating >= 60 AND c.analysis_rating <= 74 ) THEN 1 END ) AS Moderate_Risk,
                    COUNT(CASE WHEN(c.analysis_rating < 60 AND c.analysis_rating != '' ) THEN 1 END) AS High_Risk
                FROM
                    federation_mst a
                INNER JOIN federation_sub_mst b ON
                    a.id = b.federation_mst_id
                INNER JOIN federation_profile c ON
                    b.id = c.federation_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_a = 'V' and b.locked=1";

        $data['fed_ana_rating']= DB::select($query27);
        //prd($data['fed_ana_rating']);
        $query28 = "SELECT
                    COUNT(CASE WHEN c.rate>= 90 THEN 1 END ) AS Minimal_Risk,
                    COUNT(CASE WHEN(c.rate>= 75 AND c.rate<= 89 ) THEN 1 END ) AS Low_Risk,
                    COUNT(CASE WHEN(c.rate>= 60 AND c.rate<= 74 ) THEN 1 END ) AS Moderate_Risk,
                    COUNT(CASE WHEN(c.rate< 60 AND c.rate!= '' ) THEN 1 END) AS High_Risk
                FROM
                    federation_mst a
                INNER JOIN federation_sub_mst b ON
                    a.id = b.federation_mst_id
                INNER JOIN federation_profile c ON
                    b.id = c.federation_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_r = 'V' ";

                    // prd($query28);

        $data['fed_rate_bars']=DB::select($query28);
        //prd($data['fed_rate_bars'] );
        //Cluster Analytics/Rating
         $query29= "SELECT
                    COUNT(CASE WHEN c.analysis_rating >= 90 THEN 1 END ) AS Minimal_Risk,
                    COUNT(CASE WHEN(c.analysis_rating >= 75 AND c.analysis_rating <= 89 ) THEN 1 END ) AS Low_Risk,
                    COUNT(CASE WHEN(c.analysis_rating >= 60 AND c.analysis_rating <= 74 ) THEN 1 END ) AS Moderate_Risk,
                    COUNT(CASE WHEN(c.analysis_rating < 60 AND c.analysis_rating != '' ) THEN 1 END) AS High_Risk
                FROM
                    cluster_mst a
                INNER JOIN cluster_sub_mst b ON
                    a.id = b.cluster_mst_id
                INNER JOIN cluster_profile c ON
                    b.id = c.cluster_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_a = 'V' and b.locked=1";

        $data['clus_ana_rating']=DB::select($query29);
                    //prd($data['clus_ana_rating']);
         $query30= "SELECT
                    COUNT(CASE WHEN c.rate>= 90 THEN 1 END ) AS Minimal_Risk,
                    COUNT(CASE WHEN(c.rate>= 75 AND c.rate<= 89 ) THEN 1 END ) AS Low_Risk,
                    COUNT(CASE WHEN(c.rate>= 60 AND c.rate<= 74 ) THEN 1 END ) AS Moderate_Risk,
                    COUNT(CASE WHEN(c.rate< 60 AND c.rate!= '' ) THEN 1 END) AS High_Risk
                FROM
                    cluster_mst a
                INNER JOIN cluster_sub_mst b ON
                    a.id = b.cluster_mst_id
                INNER JOIN cluster_profile c ON
                    b.id = c.cluster_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_r = 'V' ";

                    $data['clus_rate_bars']=DB::select($query30);
                    //prd($data['clus_rate_bars']);

        //SHg Analytics/Rating
         $query31= "SELECT
                    COUNT(CASE WHEN c.analysis_rating >= 90 THEN 1 END ) AS Minimal_Risk,
                    COUNT(CASE WHEN(c.analysis_rating >= 75 AND c.analysis_rating <= 89 ) THEN 1 END ) AS Low_Risk,
                    COUNT(CASE WHEN(c.analysis_rating >= 60 AND c.analysis_rating <= 74 ) THEN 1 END ) AS Moderate_Risk,
                    COUNT(CASE WHEN(c.analysis_rating < 60 AND c.analysis_rating != '' ) THEN 1 END) AS High_Risk
                FROM
                    shg_mst a
                INNER JOIN shg_sub_mst b ON
                    a.id = b.shg_mst_id
                INNER JOIN shg_profile c ON
                    b.id = c.shg_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_a = 'V' and b.locked=1";

                    $data['shg_ana_rating']=DB::select($query31);

        $query32="SELECT
                    COUNT(CASE WHEN c.rate>= 90 THEN 1 END ) AS Minimal_Risk,
                    COUNT(CASE WHEN(c.rate>= 75 AND c.rate<= 89 ) THEN 1 END ) AS Low_Risk,
                    COUNT(CASE WHEN(c.rate>= 60 AND c.rate<= 74 ) THEN 1 END ) AS Moderate_Risk,
                    COUNT(CASE WHEN(c.rate< 60 AND c.rate!= '' ) THEN 1 END) AS High_Risk
                FROM
                    shg_mst a
                INNER JOIN shg_sub_mst b ON
                    a.id = b.shg_mst_id
                INNER JOIN shg_profile c ON
                    b.id = c.shg_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_r = 'V' ";

                    $data['shg_rate_bars'] = DB::select($query32);

                    //prd( $data['shg_rate_bars']);

        //Family Analytics/Rating
       $query33= "SELECT
                    COUNT(CASE WHEN c.analysis_rating >= 90 THEN 1 END ) AS Minimal_Risk,
                    COUNT(CASE WHEN(c.analysis_rating >= 75 AND c.analysis_rating <= 89 ) THEN 1 END ) AS Low_Risk,
                    COUNT(CASE WHEN(c.analysis_rating >= 60 AND c.analysis_rating <= 74 ) THEN 1 END ) AS Moderate_Risk,
                    COUNT(CASE WHEN(c.analysis_rating < 60 AND c.analysis_rating != '' ) THEN 1 END) AS High_Risk
                FROM
                    family_mst a
                INNER JOIN family_sub_mst b ON
                    a.id = b.family_mst_id
                INNER JOIN family_profile c ON
                    b.id = c.family_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND (b.qa_p1 = 'V' AND b.qa_p2 = 'V' AND b.locked=1)";

                    $data['family_ana_rating'] = DB::select($query33);


        $query34="SELECT
                    COUNT(CASE WHEN c.fp_rate>= 90 THEN 1 END ) AS Minimal_Risk,
                    COUNT(CASE WHEN(c.fp_rate>= 75 AND c.fp_rate<= 89 ) THEN 1 END ) AS Low_Risk,
                    COUNT(CASE WHEN(c.fp_rate>= 60 AND c.fp_rate<= 74 ) THEN 1 END ) AS Moderate_Risk,
                    COUNT(CASE WHEN(c.fp_rate< 60 AND c.fp_rate!= '' ) THEN 1 END) AS High_Risk
                FROM
                    family_mst a
                INNER JOIN family_sub_mst b ON
                    a.id = b.family_mst_id
                INNER JOIN family_profile c ON
                    b.id = c.family_sub_mst_id
                WHERE
                    a.is_deleted = 0 AND b.qa_r = 'V' ";

        $data['family_rate_bars'] = DB::select($query34);
        //prd($data['family_rate_bars']);

        // Family Wealth rank 4 queries:

        //Very Poor
       $query35= "SELECT
                        COUNT(t.fp_wealth_rank) as total,
                        COUNT(CASE WHEN t.analysis_rating >= 90 THEN 1 END ) AS Rich,
                        COUNT(CASE WHEN(t.analysis_rating >= 75 AND t.analysis_rating <= 89 ) THEN 1 END ) AS MPoor,
                        COUNT(CASE WHEN(t.analysis_rating >= 60 AND t.analysis_rating <= 74 ) THEN 1 END ) AS Poor,
                        COUNT(CASE WHEN(t.analysis_rating < 60 AND t.analysis_rating != '' ) THEN 1 END) AS VPoor
                    FROM
                        family_mst AS Y
                    INNER JOIN family_sub_mst AS X
                    ON
                        Y.id = X.family_mst_id
                    INNER JOIN family_profile AS t
                    ON
                        X.id = t.family_sub_mst_id
                    WHERE
                        Y.is_deleted = 0 AND X.qa_p1='V' AND X.qa_p2='V' AND X.locked=1 AND t.fp_wealth_rank != '' and (t.fp_wealth_rank = 'very poor' OR t.fp_wealth_rank = 'destitute')";
        $data['fw_vpoor'] = DB::select($query35);


        //POOR
        $query36="SELECT
                        COUNT(t.fp_wealth_rank) as total,
                        COUNT(CASE WHEN t.analysis_rating >= 90 THEN 1 END ) AS Rich,
                        COUNT(CASE WHEN(t.analysis_rating >= 75 AND t.analysis_rating <= 89 ) THEN 1 END ) AS MPoor,
                        COUNT(CASE WHEN(t.analysis_rating >= 60 AND t.analysis_rating <= 74 ) THEN 1 END ) AS Poor,
                        COUNT(CASE WHEN(t.analysis_rating < 60 AND t.analysis_rating != '' ) THEN 1 END) AS VPoor
                    FROM
                        family_mst AS Y
                    INNER JOIN family_sub_mst AS X
                    ON
                        Y.id = X.family_mst_id
                    INNER JOIN family_profile AS t
                    ON
                        X.id = t.family_sub_mst_id
                    WHERE
                        Y.is_deleted = 0 AND X.qa_p1='V' AND X.qa_p2='V' AND X.locked=1 AND t.fp_wealth_rank != '' and (t.fp_wealth_rank = 'poor')";
        $data['fw_poor'] = DB::select($query36);
        //Medium Poor
        $query37="SELECT
                        COUNT(t.fp_wealth_rank) as total,
                        COUNT(CASE WHEN t.analysis_rating >= 90 THEN 1 END ) AS Rich,
                        COUNT(CASE WHEN(t.analysis_rating >= 75 AND t.analysis_rating <= 89 ) THEN 1 END ) AS MPoor,
                        COUNT(CASE WHEN(t.analysis_rating >= 60 AND t.analysis_rating <= 74 ) THEN 1 END ) AS Poor,
                        COUNT(CASE WHEN(t.analysis_rating < 60 AND t.analysis_rating != '' ) THEN 1 END) AS VPoor
                    FROM
                        family_mst AS Y
                    INNER JOIN family_sub_mst AS X
                    ON
                        Y.id = X.family_mst_id
                    INNER JOIN family_profile AS t
                    ON
                        X.id = t.family_sub_mst_id
                    WHERE
                        Y.is_deleted = 0 AND X.qa_p1='V' AND X.qa_p2='V' AND X.locked=1 AND t.fp_wealth_rank != '' and (t.fp_wealth_rank = 'medium poor')";
        $data['fw_mpoor'] = DB::select($query37);
        //Rich
        $query38="SELECT
                        COUNT(t.fp_wealth_rank) as total,
                        COUNT(CASE WHEN t.analysis_rating >= 90 THEN 1 END ) AS Rich,
                        COUNT(CASE WHEN(t.analysis_rating >= 75 AND t.analysis_rating <= 89 ) THEN 1 END ) AS MPoor,
                        COUNT(CASE WHEN(t.analysis_rating >= 60 AND t.analysis_rating <= 74 ) THEN 1 END ) AS Poor,
                        COUNT(CASE WHEN(t.analysis_rating < 60 AND t.analysis_rating != '' ) THEN 1 END) AS VPoor
                    FROM
                        family_mst AS Y
                    INNER JOIN family_sub_mst AS X
                    ON
                        Y.id = X.family_mst_id
                    INNER JOIN family_profile AS t
                    ON
                        X.id = t.family_sub_mst_id
                    WHERE
                        Y.is_deleted = 0 AND X.qa_p1='V' AND X.qa_p2='V' AND X.locked=1 AND t.fp_wealth_rank != '' and (t.fp_wealth_rank = 'rich')";
        $data['fw_rich'] = DB::select($query38);

        //family credit
        $query40="SELECT
                        IFNULL(SUM(c.principal),0) AS total_loan,
                        IFNULL(SUM(d.loan_amount),0) AS qualified_loan,
                        (IFNULL(SUM(c.principal),0) - IFNULL(SUM(d.loan_amount),0) ) AS non_qualified_loan
                    FROM
                        family_mst a
                    INNER JOIN family_sub_mst b ON
                        a.id = b.family_mst_id
                    INNER JOIN family_loan_repayment c ON
                        b.id = c.family_sub_mst_id
                    INNER JOIN family_loan_disbursement d ON
                        b.id = d.family_sub_mst_id
                    INNER JOIN family_profile  t
                    ON
                        b.id = t.family_sub_mst_id
                    WHERE
                        a.is_deleted = 0  AND b.qa_p1='V' AND b.qa_p2='V' AND b.locked=1 AND t.analysis_rating >= 75 ";
        $data['family_pie'] = DB::select($query40);

        $query41="SELECT
                        IFNULL(SUM(c.principal),0) AS total_loan
                    FROM
                        family_mst a
                    INNER JOIN family_sub_mst b ON
                        a.id = b.family_mst_id
                    INNER JOIN family_loan_repayment c ON
                        b.id = c.family_sub_mst_id
                    INNER JOIN family_loan_disbursement d ON
                        b.id = d.family_sub_mst_id
                    INNER JOIN family_profile  t
                    ON
                        b.id = t.family_sub_mst_id
                    WHERE
                        a.is_deleted = 0 AND b.qa_p1='V' AND b.qa_p2='V' AND b.locked=1 ";
        $data['family_pie_total'] = DB::select($query41);
        return view('home')->with($data);
    }
}
