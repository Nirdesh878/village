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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnalyticsReport;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class fedReportsController extends Controller
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
        $data = [];
        $total = 0;
        $t_as = '';
        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
        if (!empty($request->get('Search'))) {
            Session::put('fed_filter_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('fed_filter_session');
        }
        if ($request->ajax()) {
            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');
            $session_data = Session::get('fed_filter_session');
            // prd($session_data);

            if (!empty($session_data['group']) && empty($session_data['federation'])) {
                $txt_search = $request->post('search')['value'];
                DB::enableQueryLog();
                if ($session_data['group'] == 'AG') {
                    $query = "SELECT
                            'FAMILY' as type,
                            v.name,
                            az.fp_member_name,
                            j.shgName,
                            b.name_of_cluster,
                            ah.name_of_federation,
                            az.fp_country AS name_of_country,
                            az.fp_state AS name_of_state,
                            az.fp_district AS name_of_district,
                            d.agency_name,
                            Y.uin,
                            az.analysis_rating,
                            az.fp_rate as rate,
                            v.dm_status,
                            v.quality_status,
                            oa.fdip_observation_highlights_a as observ_a,
                            oa.fdip_observation_highlights_b as observ_b,
                            oa.fdip_observation_highlights_c as observ_c,
                            oa.fdip_observation_highlights_d as observ_d,
                            oa.fdip_observation_highlights_e as observ_e,
                            X.locked
                        FROM
                            family_mst AS Y

                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = Y.id
                        INNER JOIN family_sub_mst AS X
                        ON
                            Y.id = X.family_mst_id
                        INNER JOIN family_profile AS az
                        ON
                            X.id = az.family_sub_mst_id
                        INNER JOIN family_observation_this_year AS oa
                        ON
                            X.id = oa.family_sub_mst_id
                        INNER JOIN shg_mst AS i
                        ON
                            i.uin = Y.shg_uin
                        INNER JOIN shg_sub_mst AS w
                        ON
                            i.id = w.shg_mst_id
                        INNER JOIN shg_profile AS j
                        ON
                            j.shg_sub_mst_id = w.id
                        LEFT JOIN cluster_mst AS a
                        ON
                            i.cluster_uin = a.uin
                        LEFT JOIN cluster_sub_mst AS v
                        ON
                            a.id = v.cluster_mst_id
                        LEFT JOIN cluster_profile AS b
                        ON
                            b.cluster_sub_mst_id = v.id
                        INNER JOIN federation_mst AS c
                        ON
                            i.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS u
                        ON
                            c.id = u.federation_mst_id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = u.id
                        INNER JOIN agency AS d
                        ON
                            Y.agency_id = d.agency_id
                        WHERE
                            Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1 ";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }

                    $query .= " UNION ALL
                            SELECT
                                'SHG' as type,
                                v.name,
                                '-' as fp_member_name,
                                az.shgName,
                                b.name_of_cluster,
                                ah.name_of_federation,
                                az.name_of_country,
                                az.name_of_state,
                                az.name_of_district,
                                d.agency_name,
                                i.uin,
                                az.analysis_rating,
                                az.rate as rate,
                                v.dm_status,
                                v.quality_status,
                                ob.shg_observation_highlights_a as observ_a,
                                ob.shg_observation_highlights_b as observ_b,
                                ob.shg_observation_highlights_c as observ_c,
                                ob.shg_observation_highlights_d as observ_d,
                                ob.shg_observation_highlights_e as observ_e,
                                k.locked
                            FROM
                                shg_mst AS i
                            INNER JOIN shg_sub_mst AS k
                            ON
                                k.shg_mst_id = i.id
                            INNER JOIN shg_profile AS az
                            ON
                                az.shg_sub_mst_id = k.id
                            INNER JOIN(
                                SELECT
                                    assignment_id,
                                    name,
                                    qa_status as dm_status,
                                    quality_status
                                FROM
                                    (
                                    SELECT
                                        assignment_id,
                                        task_a1,
                                        SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                        quality_date,
                                        user_id,
                                        quality_status
                                    FROM
                                        task_qa_assignment
                                    WHERE
                                        assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                                    GROUP BY
                                        assignment_id
                                ) a
                                INNER JOIN users AS u
                                ON
                                    a.user_id = u.id
                            ) AS v
                            ON
                                v.assignment_id = i.id
                            LEFT JOIN cluster_mst AS a
                            ON
                                i.cluster_uin = a.uin
                            LEFT JOIN cluster_sub_mst AS m
                            ON
                                m.cluster_mst_id = a.id
                            LEFT JOIN cluster_profile AS b
                            ON
                                b.cluster_sub_mst_id = m.id
                            INNER JOIN federation_mst AS c
                            ON
                                i.federation_uin = c.uin
                            INNER JOIN federation_sub_mst AS n
                            ON
                                n.federation_mst_id = c.id
                            INNER JOIN federation_profile AS ah
                            ON
                                ah.federation_sub_mst_id = n.id
                            INNER JOIN shg_observation AS ob
                            ON
                                ob.shg_sub_mst_id = k.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            WHERE
                                i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }

                    $query .= " UNION ALL
                        SELECT
                            'Cluster' as type,
                            v.name,
                            '-' as fp_member_name,
                            '-' as shgName,
                            az.name_of_cluster,
                            ah.name_of_federation,
                            az.name_of_country,
                            az.name_of_state,
                            az.name_of_district,
                            d.agency_name,
                            a.uin,
                            az.analysis_rating,
                            az.rate as rate,
                            v.dm_status,
                            v.quality_status,
                            oc.cluster_observation_highlights_a as observ_a,
                            oc.cluster_observation_highlights_b as observ_b,
                            oc.cluster_observation_highlights_c as observ_c,
                            oc.cluster_observation_highlights_d as observ_d,
                            oc.cluster_observation_highlights_e as observ_e,
                            s.locked
                        FROM
                            cluster_mst AS a
                        INNER JOIN cluster_sub_mst AS s
                        ON
                            s.cluster_mst_id = a.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'CL' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v



                        ON
                            v.assignment_id = a.id
                        INNER JOIN cluster_profile AS az
                        ON
                            az.cluster_sub_mst_id = s.id
                        INNER JOIN federation_mst AS c
                        ON
                            a.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS X
                        ON
                            X.federation_mst_id = c.id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = X.id
                        INNER JOIN cluster_observation AS oc
                        ON
                            oc.cluster_sub_mst_id = s.id
                        INNER JOIN agency AS d
                        ON
                            a.agency_id = d.agency_id
                        WHERE
                            a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }
                    $query .= " UNION ALL
                        SELECT
                            'Federation' as type,
                                v.name,
                                '-' as fp_member_name,
                                '-' as shgName,
                                '-' as name_of_cluster,
                                az.name_of_federation,
                                az.name_of_country,
                                az.name_of_state,
                                az.name_of_district,
                                d.agency_name,
                                a.uin,
                                az.analysis_rating,
                                az.rate as rate,
                                v.dm_status,
                                v.quality_status,
                                od.federationObserHighlightsA as observ_a,
                                od.federationObserHighlightsB as observ_b,
                                od.federationObserHighlightsC as observ_c,
                                od.federationObserHighlightsD as observ_d,
                                od.federationObserHighlightsE as observ_e,
                                s.locked
                            FROM
                                federation_mst AS a
                            INNER JOIN federation_sub_mst AS s
                            ON
                                s.federation_mst_id = a.id
                            INNER JOIN(
                                SELECT
                                    assignment_id,
                                    name,
                                    qa_status as dm_status,
                                    quality_status
                                FROM
                                    (
                                    SELECT
                                        assignment_id,
                                        task_a1,
                                        SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                        quality_date,
                                        user_id,
                                        quality_status
                                    FROM
                                        task_qa_assignment
                                    WHERE
                                        assignment_type = 'FD' AND task = 'A' AND qa_status = 'V'
                                    GROUP BY
                                        assignment_id
                                ) a
                                INNER JOIN users AS u
                                ON
                                    a.user_id = u.id
                            ) AS v
                            ON
                                v.assignment_id = a.id
                            LEFT JOIN federation_profile AS az
                            ON
                                az.federation_sub_mst_id = s.id
                            INNER JOIN federation_observation AS od
                            ON
                                od.federation_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                a.agency_id = d.agency_id
                            WHERE
                                a.is_deleted = 0 AND s.dm_a='V' AND s.locked = 1 ";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }
                    $federations = DB::select($query);
                    $total = count($federations);

                    $query .= " limit $limit ";
                    $query .= " offset $start";
                    // prd($query);

                    $federations = DB::select($query);
                } else {
                    if ($session_data['group'] == 'FD') {
                        $query = "SELECT
                                v.name,
                                az.name_of_federation,
                                az.name_of_country,
                                az.name_of_state,
                                az.name_of_district,
                                d.agency_name,
                                a.uin,
                                az.analysis_rating,
                                az.rate as rate,
                                v.dm_status,
                                v.quality_status,
                                od.federationObserHighlightsA as observ_a,
                                od.federationObserHighlightsB as observ_b,
                                od.federationObserHighlightsC as observ_c,
                                od.federationObserHighlightsD as observ_d,
                                od.federationObserHighlightsE as observ_e,
                                s.locked
                            FROM
                                federation_mst AS a
                            INNER JOIN federation_sub_mst AS s
                            ON
                                s.federation_mst_id = a.id
                            INNER JOIN(
                                SELECT
                                    assignment_id,
                                    name,
                                    qa_status as dm_status,
                                    quality_status
                                FROM
                                    (
                                    SELECT
                                        assignment_id,
                                        task_a1,
                                        SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                        quality_date,
                                        user_id,
                                        quality_status
                                    FROM
                                        task_qa_assignment
                                    WHERE
                                        assignment_type = 'FD' AND task = 'A' AND qa_status = 'V'
                                    GROUP BY
                                        assignment_id
                                ) a
                                INNER JOIN users AS u
                                ON
                                    a.user_id = u.id
                            ) AS v
                            ON
                                v.assignment_id = a.id
                            LEFT JOIN federation_profile AS az
                            ON
                                az.federation_sub_mst_id = s.id
                            INNER JOIN federation_observation AS od
                            ON
                                od.federation_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                a.agency_id = d.agency_id
                            WHERE
                                a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                        if (!empty($session_data['Search'])) {
                            if (!empty($session_data['state'])) {
                                if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                    $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                                }
                            }
                            if (!empty($session_data['district'])) {
                                if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                    $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                                }
                            }
                            if (!empty($session_data['country'])) {
                                if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                    $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                                }
                            }
                            if (!empty($session_data['federation'])) {
                                $text_search = $session_data['federation'];
                                $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                            }
                        }
                    }

                    if ($session_data['group'] == 'CL') {
                        $query = "SELECT
                                v.name,
                                az.name_of_cluster,
                                ah.name_of_federation,
                                az.name_of_country,
                                az.name_of_state,
                                az.name_of_district,
                                d.agency_name,
                                a.uin,
                                az.analysis_rating,
                                az.rate as rate,
                                v.dm_status,
                                v.quality_status,
                                oc.cluster_observation_highlights_a as observ_a,
                                oc.cluster_observation_highlights_b as observ_b,
                                oc.cluster_observation_highlights_c as observ_c,
                                oc.cluster_observation_highlights_d as observ_d,
                                oc.cluster_observation_highlights_e as observ_e,
                                s.locked
                            FROM
                                cluster_mst AS a
                            INNER JOIN cluster_sub_mst AS s
                            ON
                                s.cluster_mst_id = a.id
                            INNER JOIN(
                                SELECT
                                    assignment_id,
                                    name,
                                    qa_status as dm_status,
                                    quality_status
                                FROM
                                    (
                                    SELECT
                                        assignment_id,
                                        task_a1,
                                        SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                        quality_date,
                                        user_id,
                                        quality_status
                                    FROM
                                        task_qa_assignment
                                    WHERE
                                        assignment_type = 'CL' AND task = 'A' AND qa_status = 'V'
                                    GROUP BY
                                        assignment_id
                                ) a
                                INNER JOIN users AS u
                                ON
                                    a.user_id = u.id
                            ) AS v
                            ON
                                v.assignment_id = a.id
                            INNER JOIN cluster_profile AS az
                            ON
                                az.cluster_sub_mst_id = s.id
                            INNER JOIN federation_mst AS c
                            ON
                                a.federation_uin = c.uin
                            INNER JOIN federation_sub_mst AS X
                            ON
                                X.federation_mst_id = c.id
                            INNER JOIN federation_profile AS ah
                            ON
                                ah.federation_sub_mst_id = X.id
                            INNER JOIN cluster_observation AS oc
                            ON
                                oc.cluster_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                a.agency_id = d.agency_id
                            WHERE
                                a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                        if (!empty($session_data['Search'])) {
                            if (!empty($session_data['state'])) {
                                if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                    $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                                }
                            }
                            if (!empty($session_data['district'])) {
                                if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                    $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                                }
                            }
                            if (!empty($session_data['country'])) {
                                if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                    $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                                }
                            }
                            if (!empty($session_data['federation'])) {
                                $text_search = $session_data['federation'];
                                $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                            }
                        }
                    }
                    if ($session_data['group'] == 'SH') {
                        $query = "SELECT
                                v.name,
                                az.shgName,
                                b.name_of_cluster,
                                ah.name_of_federation,
                                az.name_of_country,
                                az.name_of_state,
                                az.name_of_district,
                                az.rate as rate,
                                d.agency_name,
                                i.uin,
                                az.analysis_rating,
                                v.dm_status,
                                v.quality_status,
                                ob.shg_observation_highlights_a as observ_a,
                                ob.shg_observation_highlights_b as observ_b,
                                ob.shg_observation_highlights_c as observ_c,
                                ob.shg_observation_highlights_d as observ_d,
                                ob.shg_observation_highlights_e as observ_e,
                                k.locked
                            FROM
                                shg_mst AS i
                            INNER JOIN shg_sub_mst AS k
                            ON
                                k.shg_mst_id = i.id
                            INNER JOIN shg_profile AS az
                            ON
                                az.shg_sub_mst_id = k.id
                            INNER JOIN(
                                SELECT
                                    assignment_id,
                                    name,
                                    qa_status as dm_status,
                                    quality_status
                                FROM
                                    (
                                    SELECT
                                        assignment_id,
                                        task_a1,
                                        SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                        quality_date,
                                        user_id,
                                        quality_status
                                    FROM
                                        task_qa_assignment
                                    WHERE
                                        assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                                    GROUP BY
                                        assignment_id
                                ) a
                                INNER JOIN users AS u
                                ON
                                    a.user_id = u.id
                            ) AS v
                            ON
                                v.assignment_id = i.id
                            LEFT JOIN cluster_mst AS a
                            ON
                                i.cluster_uin = a.uin
                            LEFT JOIN cluster_sub_mst AS m
                            ON
                                m.cluster_mst_id = a.id
                            LEFT JOIN cluster_profile AS b
                            ON
                                b.cluster_sub_mst_id = m.id
                            INNER JOIN federation_mst AS c
                            ON
                                i.federation_uin = c.uin
                            INNER JOIN federation_sub_mst AS n
                            ON
                                n.federation_mst_id = c.id
                            INNER JOIN federation_profile AS ah
                            ON
                                ah.federation_sub_mst_id = n.id
                            INNER JOIN shg_observation AS ob
                            ON
                                ob.shg_sub_mst_id = k.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            WHERE
                                i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                        if (!empty($session_data['Search'])) {
                            if (!empty($session_data['state'])) {
                                if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                    $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                                }
                            }
                            if (!empty($session_data['district'])) {
                                if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                    $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                                }
                            }
                            if (!empty($session_data['country'])) {
                                if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                    $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                                }
                            }
                            if (!empty($session_data['federation'])) {
                                $text_search = $session_data['federation'];
                                $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                            }
                        }
                    }
                    if ($session_data['group'] == 'FM') {
                        $query = "SELECT
                                v.name,
                                az.fp_member_name,
                                j.shgName,
                                b.name_of_cluster,
                                ah.name_of_federation,
                                az.fp_country AS name_of_country,
                                az.fp_state AS name_of_state,
                                az.fp_district AS name_of_district,
                                d.agency_name,
                                Y.uin,
                                az.analysis_rating,
                                az.fp_rate as rate,
                                v.dm_status,
                                v.quality_status,
                                oa.fdip_observation_highlights_a as observ_a,
                                oa.fdip_observation_highlights_b as observ_b,
                                oa.fdip_observation_highlights_c as observ_c,
                                oa.fdip_observation_highlights_d as observ_d,
                                oa.fdip_observation_highlights_e as observ_e,
                                X.locked
                            FROM
                                family_mst AS Y

                            INNER JOIN(
                                SELECT
                                    assignment_id,
                                    name,
                                    qa_status as dm_status,
                                    quality_status
                                FROM
                                    (
                                    SELECT
                                        assignment_id,
                                        task_a1,
                                        SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                        quality_date,
                                        user_id,
                                        quality_status
                                    FROM
                                        task_qa_assignment
                                    WHERE
                                        assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                                    GROUP BY
                                        assignment_id
                                ) a
                                INNER JOIN users AS u
                                ON
                                    a.user_id = u.id
                            ) AS v
                            ON
                                v.assignment_id = Y.id
                            INNER JOIN family_sub_mst AS X
                            ON
                                Y.id = X.family_mst_id
                            INNER JOIN family_profile AS az
                            ON
                                X.id = az.family_sub_mst_id
                            INNER JOIN family_observation_this_year AS oa
                            ON
                                X.id = oa.family_sub_mst_id
                            INNER JOIN shg_mst AS i
                            ON
                                i.uin = Y.shg_uin
                            INNER JOIN shg_sub_mst AS w
                            ON
                                i.id = w.shg_mst_id
                            INNER JOIN shg_profile AS j
                            ON
                                j.shg_sub_mst_id = w.id
                            LEFT JOIN cluster_mst AS a
                            ON
                                i.cluster_uin = a.uin
                            LEFT JOIN cluster_sub_mst AS v
                            ON
                                a.id = v.cluster_mst_id
                            LEFT JOIN cluster_profile AS b
                            ON
                                b.cluster_sub_mst_id = v.id
                            INNER JOIN federation_mst AS c
                            ON
                                i.federation_uin = c.uin
                            INNER JOIN federation_sub_mst AS u
                            ON
                                c.id = u.federation_mst_id
                            INNER JOIN federation_profile AS ah
                            ON
                                ah.federation_sub_mst_id = u.id
                            INNER JOIN agency AS d
                            ON
                                Y.agency_id = d.agency_id
                            WHERE
                                Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                        if (!empty($session_data['Search'])) {
                            if (!empty($session_data['state'])) {
                                if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                    $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                                }
                            }
                            if (!empty($session_data['district'])) {
                                if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                    $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                                }
                            }
                            if (!empty($session_data['country'])) {
                                if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                    $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                                }
                            }
                            if (!empty($session_data['federation'])) {
                                $text_search = $session_data['federation'];
                                $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                            }
                        }
                    }
                    //prd($query);
                    $federations = DB::select($query);
                    $total = count($federations);

                    $query .= " limit $limit ";
                    $query .= " offset $start";

                    $federations = DB::select($query);

                    $aaa = DB::getQueryLog();
                }
                // prd($query);
                foreach ($federations as $federation) {
                    $row = [];
                    $row[] = (++$start) . "<br>";
                    $row[] = $federation->name;
                    if ($session_data['group'] == 'AG') {
                        $row[] = $federation->agency_name;
                        $row[] = $federation->fp_member_name;
                        $row[] = $federation->shgName;
                        $row[] = $federation->name_of_cluster;
                    }

                    if ($session_data['group'] == 'CL') {
                        $row[] = $federation->name_of_cluster;
                    }
                    if ($session_data['group'] == 'FM') {
                        $row[] = $federation->fp_member_name;
                        $row[] = $federation->shgName;
                        $row[] = $federation->name_of_cluster;
                    }
                    if ($session_data['group'] == 'SH') {
                        $row[] = $federation->shgName;
                        $row[] = $federation->name_of_cluster;
                    }
                    $row[] = $federation->name_of_federation;
                    if (!empty($session_data)) {
                        if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                            $row[] = $federation->name_of_district;
                            $row[] = $federation->name_of_state;
                        } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                            $row[] = $federation->name_of_district;
                        }
                    } else {
                        $row[] = $federation->name_of_district;
                        $row[] = $federation->name_of_state;
                    }

                    //$row[] = $federation->name_of_district;
                    //$row[] = $federation->name_of_state;
                    //$row[] = $federation->name_of_country;


                        //$rate = $federation->rate;
                        $a =  $federation->observ_a;
                        $b =  $federation->observ_b;
                        $c =  $federation->observ_c;
                        $d =  $federation->observ_d;
                        $e =  $federation->observ_e;
                        $rr = '';
                        if ($a != '') {
                            $rr .= $a . ',';
                        }
                        if ($b != '') {
                            $rr .= $b . ',';
                        }
                        if ($c != '') {
                            $rr .= $c . ',';
                        }
                        if ($d != '') {
                            $rr .= $d . ',';
                        }
                        if ($e != '') {
                            $rr .= $e;
                        }

                        if ($rr == '') {
                            $row[] = '-';
                        } else {
                            $row[] = rtrim($rr, ',');
                        }


                    $row[] =  $federation->analysis_rating;

                    if ($federation->analysis_rating != '') {
                        $x1 = ((float)($federation->analysis_rating) * 100) / 100;
                        $x2 = $x1 >= 90 ? 'green' : ($x1 >= 75 ? 'yellow' : ($x1 >= 60 ? 'grey' : 'red_status'));
                        $row[] =  "<div class='status_analysis " . $x2 . "' style='margin-left: 35%;margin-bottom: 8%;margin-top: 7%;'></div>";
                    } else {
                        $row[] = '-';
                    }
                    //$row[] = $rate;
                    if ($federation->dm_status != 'P') {
                        $row[] =  $federation->dm_status == 'V' ? 'Yes' : 'No';
                        $row[] =  $federation->quality_status == 'V' ? 'Yes' : 'No';
                    } else {
                        $row[] = '-';
                        $row[] = '-';
                    }
                    $row[] = $federation->locked == 1 ? 'Yes' : 'No';
                    $row[] = '';



                    $data[] = $row;
                }
            }
            if (!empty($session_data['federation']) && !empty($session_data['group'])) {
                if ($session_data['group'] == 'FD') {
                    $query = " SELECT
                            'Federation' as type,
                            v.name,
                            '-' as fp_member_name,
                            '-' as shgName,
                            '-' as name_of_cluster,
                            az.name_of_federation,
                            az.name_of_country,
                            az.name_of_state,
                            az.name_of_district,
                            d.agency_name,
                            a.uin,
                            az.analysis_rating,
                            v.dm_status,
                            v.quality_status,
                            od.federationObserHighlightsA as observ_a,
                            od.federationObserHighlightsB as observ_b,
                            od.federationObserHighlightsC as observ_c,
                            od.federationObserHighlightsD as observ_d,
                            od.federationObserHighlightsE as observ_e,
                            s.locked
                        FROM
                            federation_mst AS a
                        INNER JOIN federation_sub_mst AS s
                        ON
                            s.federation_mst_id = a.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'FD' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = a.id
                        LEFT JOIN federation_profile AS az
                        ON
                            az.federation_sub_mst_id = s.id
                        INNER JOIN federation_observation AS od
                        ON
                            od.federation_sub_mst_id = s.id
                        INNER JOIN agency AS d
                        ON
                            a.agency_id = d.agency_id
                        WHERE
                            a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1
                        ";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( az.name_of_federation like '%" . $text_search . "%' )";
                        }
                    }
                    $query .= " UNION ALL
                        SELECT
                            'Cluster' as type,
                            v.name,
                            '-' as fp_member_name,
                            '-' as shgName,
                            az.name_of_cluster,
                            ah.name_of_federation,
                            az.name_of_country,
                            az.name_of_state,
                            az.name_of_district,
                            d.agency_name,
                            a.uin,
                            az.analysis_rating,
                            v.dm_status,
                            v.quality_status,
                            oc.cluster_observation_highlights_a as observ_a,
                            oc.cluster_observation_highlights_b as observ_b,
                            oc.cluster_observation_highlights_c as observ_c,
                            oc.cluster_observation_highlights_d as observ_d,
                            oc.cluster_observation_highlights_e as observ_e,
                            s.locked
                        FROM
                            cluster_mst AS a
                        INNER JOIN cluster_sub_mst AS s
                        ON
                            s.cluster_mst_id = a.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'CL' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = a.id
                        INNER JOIN cluster_profile AS az
                        ON
                            az.cluster_sub_mst_id = s.id
                        INNER JOIN federation_mst AS c
                        ON
                            a.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS X
                        ON
                            X.federation_mst_id = c.id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = X.id
                        INNER JOIN cluster_observation AS oc
                        ON
                            oc.cluster_sub_mst_id = s.id
                        INNER JOIN agency AS d
                        ON
                            a.agency_id = d.agency_id
                        WHERE
                            a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( ah.name_of_federation like '%" . $text_search . "%' )";
                        }
                    }

                    $query .= "UNION ALL
                        SELECT
                            'SHG' as type,
                            v.name,
                            '-' as fp_member_name,
                            az.shgName,
                            b.name_of_cluster,
                            ah.name_of_federation,
                            az.name_of_country,
                            az.name_of_state,
                            az.name_of_district,
                            d.agency_name,
                            i.uin,
                            az.analysis_rating,
                            v.dm_status,
                            v.quality_status,
                            ob.shg_observation_highlights_a as observ_a,
                            ob.shg_observation_highlights_b as observ_b,
                            ob.shg_observation_highlights_c as observ_c,
                            ob.shg_observation_highlights_d as observ_d,
                            ob.shg_observation_highlights_e as observ_e,
                            k.locked
                        FROM
                            shg_mst AS i
                        INNER JOIN shg_sub_mst AS k
                        ON
                            k.shg_mst_id = i.id
                        INNER JOIN shg_profile AS az
                        ON
                            az.shg_sub_mst_id = k.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = i.id
                        LEFT JOIN cluster_mst AS a
                        ON
                            i.cluster_uin = a.uin
                        LEFT JOIN cluster_sub_mst AS m
                        ON
                            m.cluster_mst_id = a.id
                        LEFT JOIN cluster_profile AS b
                        ON
                            b.cluster_sub_mst_id = m.id
                        INNER JOIN federation_mst AS c
                        ON
                            i.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS n
                        ON
                            n.federation_mst_id = c.id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = n.id
                        INNER JOIN shg_observation AS ob
                        ON
                            ob.shg_sub_mst_id = k.id
                        INNER JOIN agency AS d
                        ON
                            a.agency_id = d.agency_id
                        WHERE
                            i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( ah.name_of_federation like '%" . $text_search . "%' )";
                        }
                    }
                    $query .= "UNION ALL
                        SELECT
                            'FAMILY' as type,
                            v.name,
                            az.fp_member_name,
                            j.shgName,
                            b.name_of_cluster,
                            ah.name_of_federation,
                            az.fp_country AS name_of_country,
                            az.fp_state AS name_of_state,
                            az.fp_district AS name_of_district,
                            d.agency_name,
                            Y.uin,
                            az.analysis_rating,
                            v.dm_status,
                            v.quality_status,
                            oa.fdip_observation_highlights_a as observ_a,
                            oa.fdip_observation_highlights_b as observ_b,
                            oa.fdip_observation_highlights_c as observ_c,
                            oa.fdip_observation_highlights_d as observ_d,
                            oa.fdip_observation_highlights_e as observ_e,
                            X.locked
                        FROM
                            family_mst AS Y
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'FM' AND task = 'A' AND task_a1 = 'P2' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = Y.id
                        INNER JOIN family_sub_mst AS X
                        ON
                            Y.id = X.family_mst_id
                        INNER JOIN family_profile AS az
                        ON
                            X.id = az.family_sub_mst_id
                        INNER JOIN family_observation_this_year AS oa
                        ON
                            X.id = oa.family_sub_mst_id
                        INNER JOIN shg_mst AS i
                        ON
                            i.uin = Y.shg_uin
                        INNER JOIN shg_sub_mst AS w
                        ON
                            i.id = w.shg_mst_id
                        INNER JOIN shg_profile AS j
                        ON
                            j.shg_sub_mst_id = w.id
                        LEFT JOIN cluster_mst AS a
                        ON
                            i.cluster_uin = a.uin
                        LEFT JOIN cluster_sub_mst AS v
                        ON
                            a.id = v.cluster_mst_id
                        LEFT JOIN cluster_profile AS b
                        ON
                            b.cluster_sub_mst_id = v.id
                        INNER JOIN federation_mst AS c
                        ON
                            i.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS u
                        ON
                            c.id = u.federation_mst_id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = u.id
                        INNER JOIN agency AS d
                        ON
                            Y.agency_id = d.agency_id
                        WHERE
                            Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( ah.name_of_federation like '%" . $text_search . "%' )";
                        }
                    }
                }
                if ($session_data['group'] == 'CL') {
                    $query = " SELECT
                        'Cluster' as type,
                        v.name,
                        '-' as fp_member_name,
                        '-' as shgName,
                        az.name_of_cluster,
                        ah.name_of_federation,
                        az.name_of_country,
                        az.name_of_state,
                        az.name_of_district,
                        d.agency_name,
                        a.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        oc.cluster_observation_highlights_a as observ_a,
                        oc.cluster_observation_highlights_b as observ_b,
                        oc.cluster_observation_highlights_c as observ_c,
                        oc.cluster_observation_highlights_d as observ_d,
                        oc.cluster_observation_highlights_e as observ_e,
                        s.locked
                        FROM
                            cluster_mst AS a
                        INNER JOIN cluster_sub_mst AS s
                        ON
                            s.cluster_mst_id = a.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'CL' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = a.id
                        INNER JOIN cluster_profile AS az
                        ON
                            az.cluster_sub_mst_id = s.id
                        INNER JOIN federation_mst AS c
                        ON
                            a.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS X
                        ON
                            X.federation_mst_id = c.id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = X.id
                        INNER JOIN cluster_observation AS oc
                        ON
                            oc.cluster_sub_mst_id = s.id
                        INNER JOIN agency AS d
                        ON
                            a.agency_id = d.agency_id
                        WHERE
                            a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( az.name_of_cluster like '%" . $text_search . "%' )";
                        }
                    }

                    $query .= "UNION ALL
                        SELECT
                            'SHG' as type,
                            v.name,
                            '-' as fp_member_name,
                            az.shgName,
                            b.name_of_cluster,
                            ah.name_of_federation,
                            az.name_of_country,
                            az.name_of_state,
                            az.name_of_district,
                            d.agency_name,
                            i.uin,
                            az.analysis_rating,
                            v.dm_status,
                            v.quality_status,
                            ob.shg_observation_highlights_a as observ_a,
                            ob.shg_observation_highlights_b as observ_b,
                            ob.shg_observation_highlights_c as observ_c,
                            ob.shg_observation_highlights_d as observ_d,
                            ob.shg_observation_highlights_e as observ_e,
                            k.locked
                        FROM
                            shg_mst AS i
                        INNER JOIN shg_sub_mst AS k
                        ON
                            k.shg_mst_id = i.id
                        INNER JOIN shg_profile AS az
                        ON
                            az.shg_sub_mst_id = k.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = i.id
                        LEFT JOIN cluster_mst AS a
                        ON
                            i.cluster_uin = a.uin
                        LEFT JOIN cluster_sub_mst AS m
                        ON
                            m.cluster_mst_id = a.id
                        LEFT JOIN cluster_profile AS b
                        ON
                            b.cluster_sub_mst_id = m.id
                        INNER JOIN federation_mst AS c
                        ON
                            i.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS n
                        ON
                            n.federation_mst_id = c.id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = n.id
                        INNER JOIN shg_observation AS ob
                        ON
                            ob.shg_sub_mst_id = k.id
                        INNER JOIN agency AS d
                        ON
                            i.agency_id = d.agency_id
                        WHERE
                            i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( b.name_of_cluster like '%" . $text_search . "%' )";
                        }
                    }

                    $query .= " UNION ALL
                        SELECT
                            'FAMILY' as type,
                            v.name,
                            az.fp_member_name,
                            j.shgName,
                            b.name_of_cluster,
                            ah.name_of_federation,
                            az.fp_country AS name_of_country,
                            az.fp_state AS name_of_state,
                            az.fp_district AS name_of_district,
                            d.agency_name,
                            Y.uin,
                            az.analysis_rating,
                            v.dm_status,
                            v.quality_status,
                            oa.fdip_observation_highlights_a as observ_a,
                            oa.fdip_observation_highlights_b as observ_b,
                            oa.fdip_observation_highlights_c as observ_c,
                            oa.fdip_observation_highlights_d as observ_d,
                            oa.fdip_observation_highlights_e as observ_e,
                            X.locked
                        FROM
                            family_mst AS Y
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = Y.id
                        INNER JOIN family_sub_mst AS X
                        ON
                            Y.id = X.family_mst_id
                        INNER JOIN family_profile AS az
                        ON
                            X.id = az.family_sub_mst_id
                        INNER JOIN family_observation_this_year AS oa
                        ON
                            X.id = oa.family_sub_mst_id
                        INNER JOIN shg_mst AS i
                        ON
                            i.uin = Y.shg_uin
                        INNER JOIN shg_sub_mst AS w
                        ON
                            i.id = w.shg_mst_id
                        INNER JOIN shg_profile AS j
                        ON
                            j.shg_sub_mst_id = w.id
                        LEFT JOIN cluster_mst AS a
                        ON
                            i.cluster_uin = a.uin
                        LEFT JOIN cluster_sub_mst AS v
                        ON
                            a.id = v.cluster_mst_id
                        LEFT JOIN cluster_profile AS b
                        ON
                            b.cluster_sub_mst_id = v.id
                        INNER JOIN federation_mst AS c
                        ON
                            i.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS u
                        ON
                            c.id = u.federation_mst_id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = u.id
                        INNER JOIN agency AS d
                        ON
                            Y.agency_id = d.agency_id
                        WHERE
                            Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( b.name_of_cluster like '%" . $text_search . "%' )";
                        }
                    }
                }
                if ($session_data['group'] == 'SH') {
                    $query = " SELECT
                        'SHG' as type,
                        v.name,
                        '-' as fp_member_name,
                        az.shgName,
                        b.name_of_cluster,
                        ah.name_of_federation,
                        az.name_of_country,
                        az.name_of_state,
                        az.name_of_district,
                        d.agency_name,
                        i.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        ob.shg_observation_highlights_a as observ_a,
                        ob.shg_observation_highlights_b as observ_b,
                        ob.shg_observation_highlights_c as observ_c,
                        ob.shg_observation_highlights_d as observ_d,
                        ob.shg_observation_highlights_e as observ_e,
                        k.locked
                        FROM
                            shg_mst AS i
                        INNER JOIN shg_sub_mst AS k
                        ON
                            k.shg_mst_id = i.id
                        INNER JOIN shg_profile AS az
                        ON
                            az.shg_sub_mst_id = k.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = i.id
                        LEFT JOIN cluster_mst AS a
                        ON
                            i.cluster_uin = a.uin
                        LEFT JOIN cluster_sub_mst AS m
                        ON
                            m.cluster_mst_id = a.id
                        LEFT JOIN cluster_profile AS b
                        ON
                            b.cluster_sub_mst_id = m.id
                        INNER JOIN federation_mst AS c
                        ON
                            i.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS n
                        ON
                            n.federation_mst_id = c.id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = n.id
                        INNER JOIN shg_observation AS ob
                        ON
                            ob.shg_sub_mst_id = k.id
                        INNER JOIN agency AS d
                        ON
                            i.agency_id = d.agency_id
                        WHERE
                            i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( az.shgName like '%" . $text_search . "%' )";
                        }
                    }
                    $query .= " UNION ALL SELECT
                        'FAMILY' as type,
                        v.name,
                        az.fp_member_name,
                        j.shgName,
                        b.name_of_cluster,
                        ah.name_of_federation,
                        az.fp_country AS name_of_country,
                        az.fp_state AS name_of_state,
                        az.fp_district AS name_of_district,
                        d.agency_name,
                        Y.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        oa.fdip_observation_highlights_a as observ_a,
                        oa.fdip_observation_highlights_b as observ_b,
                        oa.fdip_observation_highlights_c as observ_c,
                        oa.fdip_observation_highlights_d as observ_d,
                        oa.fdip_observation_highlights_e as observ_e,
                        X.locked
                    FROM
                        family_mst AS Y
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = Y.id
                    INNER JOIN family_sub_mst AS X
                    ON
                        Y.id = X.family_mst_id
                    INNER JOIN family_profile AS az
                    ON
                        X.id = az.family_sub_mst_id
                    INNER JOIN family_observation_this_year AS oa
                    ON
                        X.id = oa.family_sub_mst_id
                    INNER JOIN shg_mst AS i
                    ON
                        i.uin = Y.shg_uin
                    INNER JOIN shg_sub_mst AS w
                    ON
                        i.id = w.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = w.id
                    LEFT JOIN cluster_mst AS a
                    ON
                        i.cluster_uin = a.uin
                    LEFT JOIN cluster_sub_mst AS v
                    ON
                        a.id = v.cluster_mst_id
                    LEFT JOIN cluster_profile AS b
                    ON
                        b.cluster_sub_mst_id = v.id
                    INNER JOIN federation_mst AS c
                    ON
                        i.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS u
                    ON
                        c.id = u.federation_mst_id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = u.id
                    INNER JOIN agency AS d
                    ON
                        Y.agency_id = d.agency_id
                    WHERE
                        Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( j.shgName like '%" . $text_search . "%' )";
                        }
                    }
                }
                if ($session_data['group'] == 'FM') {
                    $query = "SELECT
                        'FAMILY' as type,
                        v.name,
                        az.fp_member_name,
                        j.shgName,
                        b.name_of_cluster,
                        ah.name_of_federation,
                        az.fp_country AS name_of_country,
                        az.fp_state AS name_of_state,
                        az.fp_district AS name_of_district,
                        d.agency_name,
                        Y.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        oa.fdip_observation_highlights_a as observ_a,
                        oa.fdip_observation_highlights_b as observ_b,
                        oa.fdip_observation_highlights_c as observ_c,
                        oa.fdip_observation_highlights_d as observ_d,
                        oa.fdip_observation_highlights_e as observ_e,
                        X.locked
                        FROM
                            family_mst AS Y
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = Y.id
                        INNER JOIN family_sub_mst AS X
                        ON
                            Y.id = X.family_mst_id
                        INNER JOIN family_profile AS az
                        ON
                            X.id = az.family_sub_mst_id
                        INNER JOIN family_observation_this_year AS oa
                        ON
                            X.id = oa.family_sub_mst_id
                        INNER JOIN shg_mst AS i
                        ON
                            i.uin = Y.shg_uin
                        INNER JOIN shg_sub_mst AS w
                        ON
                            i.id = w.shg_mst_id
                        INNER JOIN shg_profile AS j
                        ON
                            j.shg_sub_mst_id = w.id
                        LEFT JOIN cluster_mst AS a
                        ON
                            i.cluster_uin = a.uin
                        LEFT JOIN cluster_sub_mst AS v
                        ON
                            a.id = v.cluster_mst_id
                        LEFT JOIN cluster_profile AS b
                        ON
                            b.cluster_sub_mst_id = v.id
                        INNER JOIN federation_mst AS c
                        ON
                            i.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS u
                        ON
                            c.id = u.federation_mst_id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = u.id
                        INNER JOIN agency AS d
                        ON
                            Y.agency_id = d.agency_id
                        WHERE
                            Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( az.fp_member_name like '%" . $text_search . "%' )";
                        }
                    }
                }
                if ($session_data['group'] == 'AG') {
                    $query = "SELECT
                        'FAMILY' as type,
                        v.name,
                        az.fp_member_name,
                        j.shgName,
                        b.name_of_cluster,
                        ah.name_of_federation,
                        az.fp_country AS name_of_country,
                        az.fp_state AS name_of_state,
                        az.fp_district AS name_of_district,
                        d.agency_name,
                        Y.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        oa.fdip_observation_highlights_a as observ_a,
                        oa.fdip_observation_highlights_b as observ_b,
                        oa.fdip_observation_highlights_c as observ_c,
                        oa.fdip_observation_highlights_d as observ_d,
                        oa.fdip_observation_highlights_e as observ_e,
                        X.locked
                    FROM
                        family_mst AS Y
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = Y.id
                    INNER JOIN family_sub_mst AS X
                    ON
                        Y.id = X.family_mst_id
                    INNER JOIN family_profile AS az
                    ON
                        X.id = az.family_sub_mst_id
                    INNER JOIN family_observation_this_year AS oa
                    ON
                        X.id = oa.family_sub_mst_id
                    INNER JOIN shg_mst AS i
                    ON
                        i.uin = Y.shg_uin
                    INNER JOIN shg_sub_mst AS w
                    ON
                        i.id = w.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = w.id
                    LEFT JOIN cluster_mst AS a
                    ON
                        i.cluster_uin = a.uin
                    LEFT JOIN cluster_sub_mst AS v
                    ON
                        a.id = v.cluster_mst_id
                    LEFT JOIN cluster_profile AS b
                    ON
                        b.cluster_sub_mst_id = v.id
                    INNER JOIN federation_mst AS c
                    ON
                        i.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS u
                    ON
                        c.id = u.federation_mst_id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = u.id
                    INNER JOIN agency AS d
                    ON
                        Y.agency_id = d.agency_id
                    WHERE
                        Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }

                    $query .= "UNION ALL
                    SELECT
                        'SHG' as type,
                        v.name,
                        '-' as fp_member_name,
                        az.shgName,
                        b.name_of_cluster,
                        ah.name_of_federation,
                        az.name_of_country,
                        az.name_of_state,
                        az.name_of_district,
                        d.agency_name,
                        i.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        ob.shg_observation_highlights_a as observ_a,
                        ob.shg_observation_highlights_b as observ_b,
                        ob.shg_observation_highlights_c as observ_c,
                        ob.shg_observation_highlights_d as observ_d,
                        ob.shg_observation_highlights_e as observ_e,
                        k.locked
                    FROM
                        shg_mst AS i
                    INNER JOIN shg_sub_mst AS k
                    ON
                        k.shg_mst_id = i.id
                    INNER JOIN shg_profile AS az
                    ON
                        az.shg_sub_mst_id = k.id
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = i.id
                    LEFT JOIN cluster_mst AS a
                    ON
                        i.cluster_uin = a.uin
                    LEFT JOIN cluster_sub_mst AS m
                    ON
                        m.cluster_mst_id = a.id
                    LEFT JOIN cluster_profile AS b
                    ON
                        b.cluster_sub_mst_id = m.id
                    INNER JOIN federation_mst AS c
                    ON
                        i.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS n
                    ON
                        n.federation_mst_id = c.id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = n.id
                    INNER JOIN shg_observation AS ob
                    ON
                        ob.shg_sub_mst_id = k.id
                    INNER JOIN agency AS d
                    ON
                        i.agency_id = d.agency_id
                    WHERE
                        i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }

                    $query .= " UNION ALL
                    SELECT
                        'Cluster' as type,
                        v.name,
                        '-' as fp_member_name,
                        '-' as shgName,
                        az.name_of_cluster,
                        ah.name_of_federation,
                        az.name_of_country,
                        az.name_of_state,
                        az.name_of_district,
                        d.agency_name,
                        a.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        oc.cluster_observation_highlights_a as observ_a,
                        oc.cluster_observation_highlights_b as observ_b,
                        oc.cluster_observation_highlights_c as observ_c,
                        oc.cluster_observation_highlights_d as observ_d,
                        oc.cluster_observation_highlights_e as observ_e,
                        s.locked
                    FROM
                        cluster_mst AS a
                    INNER JOIN cluster_sub_mst AS s
                    ON
                        s.cluster_mst_id = a.id
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'CL' AND task = 'A' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = a.id
                    INNER JOIN cluster_profile AS az
                    ON
                        az.cluster_sub_mst_id = s.id
                    INNER JOIN federation_mst AS c
                    ON
                        a.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS X
                    ON
                        X.federation_mst_id = c.id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = X.id
                    INNER JOIN cluster_observation AS oc
                    ON
                        oc.cluster_sub_mst_id = s.id
                    INNER JOIN agency AS d
                    ON
                        a.agency_id = d.agency_id
                    WHERE
                        a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }
                    $query .= " UNION ALL
                    SELECT
                    'Federation' as type,
                        v.name,
                        '-' as fp_member_name,
                        '-' as shgName,
                        '-' as name_of_cluster,
                        az.name_of_federation,
                        az.name_of_country,
                        az.name_of_state,
                        az.name_of_district,
                        d.agency_name,
                        a.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        od.federationObserHighlightsA as observ_a,
                        od.federationObserHighlightsB as observ_b,
                        od.federationObserHighlightsC as observ_c,
                        od.federationObserHighlightsD as observ_d,
                        od.federationObserHighlightsE as observ_e,
                        s.locked
                    FROM
                        federation_mst AS a
                    INNER JOIN federation_sub_mst AS s
                    ON
                        s.federation_mst_id = a.id
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FD' AND task = 'A' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = a.id
                    LEFT JOIN federation_profile AS az
                    ON
                        az.federation_sub_mst_id = s.id
                    INNER JOIN federation_observation AS od
                    ON
                        od.federation_sub_mst_id = s.id
                    INNER JOIN agency AS d
                    ON
                        a.agency_id = d.agency_id
                    WHERE
                        a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1
                    ";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }
                }


                $families = DB::select($query);
                $total = count($families);

                $query .= "limit $limit ";
                $query .= "offset $start";

                $families = DB::select($query);

                foreach ($families as $federation) {

                    if($session_data['group'] == "AG" && !empty($session_data['federation']))
                    {
                        $row = [];
                        $row[] = (++$start) . "<br>";
                        $row[] = $federation->type;
                        $row[] = $federation->uin;
                        $row[] = $federation->name;
                        // $row[] = $federation->agency_name;
                        $row[] = $federation->fp_member_name;
                        $row[] = $federation->shgName;
                        $row[] = $federation->name_of_cluster;
                        $row[] = $federation->name_of_federation;
                    }
                    elseif($session_data['group'] == "FM" && !empty($session_data['federation']))
                    {
                        $row = [];
                        $row[] = (++$start) . "<br>";
                        $row[] = $federation->type;
                        $row[] = $federation->uin;
                        $row[] = $federation->name;
                        $row[] = $federation->agency_name;
                        // $row[] = $federation->fp_member_name;
                        $row[] = $federation->shgName;
                        $row[] = $federation->name_of_cluster;
                        $row[] = $federation->name_of_federation;
                    }
                    elseif($session_data['group'] == "SH" && !empty($session_data['federation']))
                    {
                        $row = [];
                        $row[] = (++$start) . "<br>";
                        $row[] = $federation->type;
                        $row[] = $federation->uin;
                        $row[] = $federation->name;
                        $row[] = $federation->agency_name;
                        $row[] = $federation->fp_member_name;
                        // $row[] = $federation->shgName;
                        $row[] = $federation->name_of_cluster;
                        $row[] = $federation->name_of_federation;
                    }
                    elseif($session_data['group'] == "CL" && !empty($session_data['federation']))
                    {
                        $row = [];
                        $row[] = (++$start) . "<br>";
                        $row[] = $federation->type;
                        $row[] = $federation->uin;
                        $row[] = $federation->name;
                        $row[] = $federation->agency_name;
                        $row[] = $federation->fp_member_name;
                        $row[] = $federation->shgName;
                        // $row[] = $federation->name_of_cluster;
                        $row[] = $federation->name_of_federation;
                    }
                    elseif($session_data['group'] == "FD" && !empty($session_data['federation']))
                    {
                        $row = [];
                        $row[] = (++$start) . "<br>";
                        $row[] = $federation->type;
                        $row[] = $federation->uin;
                        $row[] = $federation->name;
                        $row[] = $federation->agency_name;
                        $row[] = $federation->fp_member_name;
                        $row[] = $federation->shgName;
                        $row[] = $federation->name_of_cluster;
                        // $row[] = $federation->name_of_federation;
                    }
                    else
                    {
                        $row = [];
                    $row[] = (++$start) . "<br>";
                    $row[] = $federation->type;
                    $row[] = $federation->uin;
                    $row[] = $federation->name;
                    $row[] = $federation->agency_name;
                    $row[] = $federation->fp_member_name;
                    $row[] = $federation->shgName;
                    $row[] = $federation->name_of_cluster;
                    $row[] = $federation->name_of_federation;
                    }
                    if (!empty($session_data)) {
                        if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                            $row[] = $federation->name_of_district;
                            $row[] = $federation->name_of_state;
                        } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                            $row[] = $federation->name_of_district;
                        }
                    } else {
                        $row[] = $federation->name_of_district;
                        $row[] = $federation->name_of_state;
                    }

                    // $row[] = $federation->name_of_district;
                    // $row[] = $federation->name_of_state;
                    //$row[] = $federation->name_of_country;

                    $a =  $federation->observ_a;
                    $b =  $federation->observ_b;
                    $c =  $federation->observ_c;
                    $d =  $federation->observ_d;
                    $e =  $federation->observ_e;
                    $rr = '';
                    if ($a != '') {
                        $rr .= $a . ',';
                    }
                    if ($b != '') {
                        $rr .= $b . ',';
                    }
                    if ($c != '') {
                        $rr .= $c . ',';
                    }
                    if ($d != '') {
                        $rr .= $d . ',';
                    }
                    if ($e != '') {
                        $rr .= $e;
                    }

                    if ($rr == '') {
                        $row[] = '-';
                    } else {
                        $row[] = rtrim($rr, ',');
                    }
                    $row[] =  $federation->analysis_rating;
                    if ($federation->analysis_rating != '') {
                        $x1 = ((float)($federation->analysis_rating) * 100) / 100;
                        $x2 = $x1 >= 90 ? 'green' : ($x1 >= 75 ? 'yellow' : ($x1 >= 60 ? 'grey' : 'red_status'));
                        $row[] =  "<div class='status_analysis " . $x2 . "' style='margin-left: 35%;margin-bottom: 8%;margin-top: 7%;'></div>";
                    } else {
                        $row[] = '-';
                    }
                    if ($federation->dm_status != 'P') {
                        $row[] =  $federation->dm_status == 'V' ? 'Yes' : 'No';
                        $row[] =  $federation->quality_status == 'V' ? 'Yes' : 'No';
                    } else {
                        $row[] = '-';
                        $row[] = '-';
                    }
                    $row[] = $federation->locked == 1 ? 'Yes' : 'No';
                    $data[] = $row;
                }
            }
            $output = array(
                "draw"            => $request->post('draw'),
                "recordsTotal"    => $total,
                "recordsFiltered" => $total,
                "data"            => $data,
            );
            echo json_encode($output);
            exit;
        }
        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        //prd($data);
        return view('fedreports.list')->with($data);
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
    public function export(Request $request)
    {
        $session_data = Session::get('fed_filter_session');
        $type = '';
        if (!empty($session_data['group'])) {
            if ($session_data['group'] == 'FD') {
                $type = "Federation";
            }
            if ($session_data['group'] == 'CL') {
                $type = "Cluster";
            }
            if ($session_data['group'] == 'SH') {
                $type = "SHG";
            }
            if ($session_data['group'] == 'FM') {
                $type = "Family";
            }
            if ($session_data['group'] == 'AG') {
                $type = "Agency";
            }

            if ($session_data['group'] == 'FM' && empty($session_data['federation'])) {
                return Excel::download(new AnalyticsReport(), 'AnalyticsReport_Family_'.pdf_date().'.xlsx');
            } elseif ($session_data['group'] == 'SH' && empty($session_data['federation'])) {
                return Excel::download(new AnalyticsReport(), 'AnalyticsReport_SHG_'.pdf_date().'.xlsx');
            } elseif ($session_data['group'] == 'CL' && empty($session_data['federation'])) {
                return Excel::download(new AnalyticsReport(), 'AnalyticsReport_Cluster_'.pdf_date().'.xlsx');
            } elseif ($session_data['group'] == 'FD' && empty($session_data['federation'])) {
                return Excel::download(new AnalyticsReport(), 'AnalyticsReport_Federation_'.pdf_date().'.xlsx');
            } elseif ($session_data['group'] == 'AG' && empty($session_data['federation'])) {
                return Excel::download(new AnalyticsReport(), 'AnalyticsReport_Agency_'.pdf_date().'.xlsx');
            } else {
                return Excel::download(new AnalyticsReport(), 'AnalyticsReport_'.$type.'_'.pdf_date().'.xlsx');
            }
        } else {
            return Excel::download(new AnalyticsReport(), 'AnalyticsReport_'.pdf_date().'.xlsx');
        }
    }
    public function exportPDF()
    {
        $session_data = Session::get('fed_filter_session');
        $res = [];
        if (!empty($session_data['group']) && empty($session_data['federation'])) {
            if ($session_data['group'] == 'AG') {
                $query = "SELECT
                        'FAMILY' as type,
                        v.name,
                        az.fp_member_name,
                        j.shgName,
                        b.name_of_cluster,
                        ah.name_of_federation,
                        az.fp_country AS name_of_country,
                        az.fp_state AS name_of_state,
                        az.fp_district AS name_of_district,
                        d.agency_name,
                        Y.uin,
                        az.analysis_rating,
                        az.fp_rate as rate,
                        v.dm_status,
                        v.quality_status,
                        oa.fdip_observation_highlights_a as observ_a,
                        oa.fdip_observation_highlights_b as observ_b,
                        oa.fdip_observation_highlights_c as observ_c,
                        oa.fdip_observation_highlights_d as observ_d,
                        oa.fdip_observation_highlights_e as observ_e,
                        X.locked
                    FROM
                        family_mst AS Y

                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = Y.id
                    INNER JOIN family_sub_mst AS X
                    ON
                        Y.id = X.family_mst_id
                    INNER JOIN family_profile AS az
                    ON
                        X.id = az.family_sub_mst_id
                    INNER JOIN family_observation_this_year AS oa
                    ON
                        X.id = oa.family_sub_mst_id
                    INNER JOIN shg_mst AS i
                    ON
                        i.uin = Y.shg_uin
                    INNER JOIN shg_sub_mst AS w
                    ON
                        i.id = w.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = w.id
                    LEFT JOIN cluster_mst AS a
                    ON
                        i.cluster_uin = a.uin
                    LEFT JOIN cluster_sub_mst AS v
                    ON
                        a.id = v.cluster_mst_id
                    LEFT JOIN cluster_profile AS b
                    ON
                        b.cluster_sub_mst_id = v.id
                    INNER JOIN federation_mst AS c
                    ON
                        i.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS u
                    ON
                        c.id = u.federation_mst_id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = u.id
                    INNER JOIN agency AS d
                    ON
                        Y.agency_id = d.agency_id
                    WHERE
                        Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1 ";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                    }
                }

                $query .= " UNION ALL
                        SELECT
                            'SHG' as type,
                            v.name,
                            '-' as fp_member_name,
                            az.shgName,
                            b.name_of_cluster,
                            ah.name_of_federation,
                            az.name_of_country,
                            az.name_of_state,
                            az.name_of_district,
                            d.agency_name,
                            i.uin,
                            az.analysis_rating,
                            az.rate as rate,
                            v.dm_status,
                            v.quality_status,
                            ob.shg_observation_highlights_a as observ_a,
                            ob.shg_observation_highlights_b as observ_b,
                            ob.shg_observation_highlights_c as observ_c,
                            ob.shg_observation_highlights_d as observ_d,
                            ob.shg_observation_highlights_e as observ_e,
                            k.locked
                        FROM
                            shg_mst AS i
                        INNER JOIN shg_sub_mst AS k
                        ON
                            k.shg_mst_id = i.id
                        INNER JOIN shg_profile AS az
                        ON
                            az.shg_sub_mst_id = k.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = i.id
                        LEFT JOIN cluster_mst AS a
                        ON
                            i.cluster_uin = a.uin
                        LEFT JOIN cluster_sub_mst AS m
                        ON
                            m.cluster_mst_id = a.id
                        LEFT JOIN cluster_profile AS b
                        ON
                            b.cluster_sub_mst_id = m.id
                        INNER JOIN federation_mst AS c
                        ON
                            i.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS n
                        ON
                            n.federation_mst_id = c.id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = n.id
                        INNER JOIN shg_observation AS ob
                        ON
                            ob.shg_sub_mst_id = k.id
                        INNER JOIN agency AS d
                        ON
                            i.agency_id = d.agency_id
                        WHERE
                            i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                    }
                }

                $query .= " UNION ALL
                    SELECT
                        'Cluster' as type,
                        v.name,
                        '-' as fp_member_name,
                        '-' as shgName,
                        az.name_of_cluster,
                        ah.name_of_federation,
                        az.name_of_country,
                        az.name_of_state,
                        az.name_of_district,
                        d.agency_name,
                        a.uin,
                        az.analysis_rating,
                        az.rate as rate,
                        v.dm_status,
                        v.quality_status,
                        oc.cluster_observation_highlights_a as observ_a,
                        oc.cluster_observation_highlights_b as observ_b,
                        oc.cluster_observation_highlights_c as observ_c,
                        oc.cluster_observation_highlights_d as observ_d,
                        oc.cluster_observation_highlights_e as observ_e,
                        s.locked
                    FROM
                        cluster_mst AS a
                    INNER JOIN cluster_sub_mst AS s
                    ON
                        s.cluster_mst_id = a.id
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'CL' AND task = 'A' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = a.id
                    INNER JOIN cluster_profile AS az
                    ON
                        az.cluster_sub_mst_id = s.id
                    INNER JOIN federation_mst AS c
                    ON
                        a.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS X
                    ON
                        X.federation_mst_id = c.id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = X.id
                    INNER JOIN cluster_observation AS oc
                    ON
                        oc.cluster_sub_mst_id = s.id
                    INNER JOIN agency AS d
                    ON
                        a.agency_id = d.agency_id
                    WHERE
                        a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                    }
                }
                $query .= " UNION ALL
                    SELECT
                        'Federation' as type,
                            v.name,
                            '-' as fp_member_name,
                            '-' as shgName,
                            '-' as name_of_cluster,
                            az.name_of_federation,
                            az.name_of_country,
                            az.name_of_state,
                            az.name_of_district,
                            d.agency_name,
                            a.uin,
                            az.analysis_rating,
                            az.rate as rate,
                            v.dm_status,
                            v.quality_status,
                            od.federationObserHighlightsA as observ_a,
                            od.federationObserHighlightsB as observ_b,
                            od.federationObserHighlightsC as observ_c,
                            od.federationObserHighlightsD as observ_d,
                            od.federationObserHighlightsE as observ_e,
                            s.locked
                        FROM
                            federation_mst AS a
                        INNER JOIN federation_sub_mst AS s
                        ON
                            s.federation_mst_id = a.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'FD' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = a.id
                        LEFT JOIN federation_profile AS az
                        ON
                            az.federation_sub_mst_id = s.id
                        INNER JOIN federation_observation AS od
                        ON
                            od.federation_sub_mst_id = s.id
                        INNER JOIN agency AS d
                        ON
                            a.agency_id = d.agency_id
                        WHERE
                            a.is_deleted = 0 AND s.dm_a='V' AND s.locked = 1 ";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                    }
                }
                $res['data']=DB::select($query);
            } else {
                if ($session_data['group'] == 'FD') {
                    $query = "SELECT
                            v.name,
                            az.name_of_federation,
                            az.name_of_country,
                            az.name_of_state,
                            az.name_of_district,
                            d.agency_name,
                            a.uin,
                            az.analysis_rating,
                            az.rate as rate,
                            v.dm_status,
                            v.quality_status,
                            od.federationObserHighlightsA as observ_a,
                            od.federationObserHighlightsB as observ_b,
                            od.federationObserHighlightsC as observ_c,
                            od.federationObserHighlightsD as observ_d,
                            od.federationObserHighlightsE as observ_e,
                            s.locked
                        FROM
                            federation_mst AS a
                        INNER JOIN federation_sub_mst AS s
                        ON
                            s.federation_mst_id = a.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'FD' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = a.id
                        LEFT JOIN federation_profile AS az
                        ON
                            az.federation_sub_mst_id = s.id
                        INNER JOIN federation_observation AS od
                        ON
                            od.federation_sub_mst_id = s.id
                        INNER JOIN agency AS d
                        ON
                            a.agency_id = d.agency_id
                        WHERE
                            a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }
                }
                if ($session_data['group'] == 'CL') {
                    $query = "SELECT
                            v.name,
                            az.name_of_cluster,
                            ah.name_of_federation,
                            az.name_of_country,
                            az.name_of_state,
                            az.name_of_district,
                            d.agency_name,
                            a.uin,
                            az.analysis_rating,
                            az.rate as rate,
                            v.dm_status,
                            v.quality_status,
                            oc.cluster_observation_highlights_a as observ_a,
                            oc.cluster_observation_highlights_b as observ_b,
                            oc.cluster_observation_highlights_c as observ_c,
                            oc.cluster_observation_highlights_d as observ_d,
                            oc.cluster_observation_highlights_e as observ_e,
                            s.locked
                        FROM
                            cluster_mst AS a
                        INNER JOIN cluster_sub_mst AS s
                        ON
                            s.cluster_mst_id = a.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'CL' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = a.id
                        INNER JOIN cluster_profile AS az
                        ON
                            az.cluster_sub_mst_id = s.id
                        INNER JOIN federation_mst AS c
                        ON
                            a.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS X
                        ON
                            X.federation_mst_id = c.id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = X.id
                        INNER JOIN cluster_observation AS oc
                        ON
                            oc.cluster_sub_mst_id = s.id
                        INNER JOIN agency AS d
                        ON
                            a.agency_id = d.agency_id
                        WHERE
                            a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }
                }
                if ($session_data['group'] == 'SH') {
                    $query = "SELECT
                            v.name,
                            az.shgName,
                            b.name_of_cluster,
                            ah.name_of_federation,
                            az.name_of_country,
                            az.name_of_state,
                            az.name_of_district,
                            az.rate as rate,
                            d.agency_name,
                            i.uin,
                            az.analysis_rating,
                            v.dm_status,
                            v.quality_status,
                            ob.shg_observation_highlights_a as observ_a,
                            ob.shg_observation_highlights_b as observ_b,
                            ob.shg_observation_highlights_c as observ_c,
                            ob.shg_observation_highlights_d as observ_d,
                            ob.shg_observation_highlights_e as observ_e,
                            k.locked
                        FROM
                            shg_mst AS i
                        INNER JOIN shg_sub_mst AS k
                        ON
                            k.shg_mst_id = i.id
                        INNER JOIN shg_profile AS az
                        ON
                            az.shg_sub_mst_id = k.id
                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = i.id
                        INNER JOIN cluster_mst AS a
                        ON
                            i.cluster_uin = a.uin
                        INNER JOIN cluster_sub_mst AS m
                        ON
                            m.cluster_mst_id = a.id
                        INNER JOIN cluster_profile AS b
                        ON
                            b.cluster_sub_mst_id = m.id
                        INNER JOIN federation_mst AS c
                        ON
                            i.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS n
                        ON
                            n.federation_mst_id = c.id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = n.id
                        INNER JOIN shg_observation AS ob
                        ON
                            ob.shg_sub_mst_id = k.id
                        INNER JOIN agency AS d
                        ON
                            a.agency_id = d.agency_id
                        WHERE
                            i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }
                }
                if ($session_data['group'] == 'FM') {
                    $query = "SELECT
                            v.name,
                            az.fp_member_name,
                            j.shgName,
                            b.name_of_cluster,
                            ah.name_of_federation,
                            az.fp_country AS name_of_country,
                            az.fp_state AS name_of_state,
                            az.fp_district AS name_of_district,
                            d.agency_name,
                            Y.uin,
                            az.analysis_rating,
                            az.fp_rate as rate,
                            v.dm_status,
                            v.quality_status,
                            oa.fdip_observation_highlights_a as observ_a,
                            oa.fdip_observation_highlights_b as observ_b,
                            oa.fdip_observation_highlights_c as observ_c,
                            oa.fdip_observation_highlights_d as observ_d,
                            oa.fdip_observation_highlights_e as observ_e,
                            X.locked
                        FROM
                            family_mst AS Y

                        INNER JOIN(
                            SELECT
                                assignment_id,
                                name,
                                qa_status as dm_status,
                                quality_status
                            FROM
                                (
                                SELECT
                                    assignment_id,
                                    task_a1,
                                    SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                    quality_date,
                                    user_id,
                                    quality_status
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                                GROUP BY
                                    assignment_id
                            ) a
                            INNER JOIN users AS u
                            ON
                                a.user_id = u.id
                        ) AS v
                        ON
                            v.assignment_id = Y.id
                        INNER JOIN family_sub_mst AS X
                        ON
                            Y.id = X.family_mst_id
                        INNER JOIN family_profile AS az
                        ON
                            X.id = az.family_sub_mst_id
                        INNER JOIN family_observation_this_year AS oa
                        ON
                            X.id = oa.family_sub_mst_id
                        INNER JOIN shg_mst AS i
                        ON
                            i.uin = Y.shg_uin
                        INNER JOIN shg_sub_mst AS w
                        ON
                            i.id = w.shg_mst_id
                        INNER JOIN shg_profile AS j
                        ON
                            j.shg_sub_mst_id = w.id
                        LEFT JOIN cluster_mst AS a
                        ON
                            i.cluster_uin = a.uin
                        LEFT JOIN cluster_sub_mst AS v
                        ON
                            a.id = v.cluster_mst_id
                        LEFT JOIN cluster_profile AS b
                        ON
                            b.cluster_sub_mst_id = v.id
                        INNER JOIN federation_mst AS c
                        ON
                            i.federation_uin = c.uin
                        INNER JOIN federation_sub_mst AS u
                        ON
                            c.id = u.federation_mst_id
                        INNER JOIN federation_profile AS ah
                        ON
                            ah.federation_sub_mst_id = u.id
                        INNER JOIN agency AS d
                        ON
                            Y.agency_id = d.agency_id
                        WHERE
                            Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                    if (!empty($session_data['Search'])) {
                        if (!empty($session_data['state'])) {
                            if ($session_data['state'] != '' && $session_data['state'] > 0) {
                                $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                            }
                        }
                        if (!empty($session_data['district'])) {
                            if ($session_data['district'] != '' && $session_data['district'] > 0) {
                                $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                            }
                        }
                        if (!empty($session_data['country'])) {
                            if ($session_data['country'] != '' && $session_data['country'] > 0) {
                                $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                            }
                        }
                        if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                        }
                    }
                }
            }
            $res['data'] = DB::select($query);
            //prd($query);
        }
        if (!empty($session_data['federation']) && !empty($session_data['group'])) {
            if ($session_data['group'] == 'FD') {
                $query = " SELECT
                        'Federation' as type,
                        v.name,
                        '-' as fp_member_name,
                        '-' as shgName,
                        '-' as name_of_cluster,
                        az.name_of_federation,
                        az.name_of_country,
                        az.name_of_state,
                        az.name_of_district,
                        d.agency_name,
                        a.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        od.federationObserHighlightsA as observ_a,
                        od.federationObserHighlightsB as observ_b,
                        od.federationObserHighlightsC as observ_c,
                        od.federationObserHighlightsD as observ_d,
                        od.federationObserHighlightsE as observ_e,
                        s.locked
                    FROM
                        federation_mst AS a
                    INNER JOIN federation_sub_mst AS s
                    ON
                        s.federation_mst_id = a.id
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FD' AND task = 'A' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = a.id
                    LEFT JOIN federation_profile AS az
                    ON
                        az.federation_sub_mst_id = s.id
                    INNER JOIN federation_observation AS od
                    ON
                        od.federation_sub_mst_id = s.id
                    INNER JOIN agency AS d
                    ON
                        a.agency_id = d.agency_id
                    WHERE
                        a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1
                    ";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( az.name_of_federation like '%" . $text_search . "%' )";
                    }
                }
                $query .= " UNION ALL
                    SELECT
                        'Cluster' as type,
                        v.name,
                        '-' as fp_member_name,
                        '-' as shgName,
                        az.name_of_cluster,
                        ah.name_of_federation,
                        az.name_of_country,
                        az.name_of_state,
                        az.name_of_district,
                        d.agency_name,
                        a.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        oc.cluster_observation_highlights_a as observ_a,
                        oc.cluster_observation_highlights_b as observ_b,
                        oc.cluster_observation_highlights_c as observ_c,
                        oc.cluster_observation_highlights_d as observ_d,
                        oc.cluster_observation_highlights_e as observ_e,
                        s.locked
                    FROM
                        cluster_mst AS a
                    INNER JOIN cluster_sub_mst AS s
                    ON
                        s.cluster_mst_id = a.id
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'CL' AND task = 'A' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = a.id
                    INNER JOIN cluster_profile AS az
                    ON
                        az.cluster_sub_mst_id = s.id
                    INNER JOIN federation_mst AS c
                    ON
                        a.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS X
                    ON
                        X.federation_mst_id = c.id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = X.id
                    INNER JOIN cluster_observation AS oc
                    ON
                        oc.cluster_sub_mst_id = s.id
                    INNER JOIN agency AS d
                    ON
                        a.agency_id = d.agency_id
                    WHERE
                        a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( ah.name_of_federation like '%" . $text_search . "%' )";
                    }
                }

                $query .= "UNION ALL
                    SELECT
                        'SHG' as type,
                        v.name,
                        '-' as fp_member_name,
                        az.shgName,
                        b.name_of_cluster,
                        ah.name_of_federation,
                        az.name_of_country,
                        az.name_of_state,
                        az.name_of_district,
                        d.agency_name,
                        i.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        ob.shg_observation_highlights_a as observ_a,
                        ob.shg_observation_highlights_b as observ_b,
                        ob.shg_observation_highlights_c as observ_c,
                        ob.shg_observation_highlights_d as observ_d,
                        ob.shg_observation_highlights_e as observ_e,
                        k.locked
                    FROM
                        shg_mst AS i
                    INNER JOIN shg_sub_mst AS k
                    ON
                        k.shg_mst_id = i.id
                    INNER JOIN shg_profile AS az
                    ON
                        az.shg_sub_mst_id = k.id
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = i.id
                    LEFT JOIN cluster_mst AS a
                    ON
                        i.cluster_uin = a.uin
                    LEFT JOIN cluster_sub_mst AS m
                    ON
                        m.cluster_mst_id = a.id
                    LEFT JOIN cluster_profile AS b
                    ON
                        b.cluster_sub_mst_id = m.id
                    INNER JOIN federation_mst AS c
                    ON
                        i.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS n
                    ON
                        n.federation_mst_id = c.id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = n.id
                    INNER JOIN shg_observation AS ob
                    ON
                        ob.shg_sub_mst_id = k.id
                    INNER JOIN agency AS d
                    ON
                        i.agency_id = d.agency_id
                    WHERE
                        i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( ah.name_of_federation like '%" . $text_search . "%' )";
                    }
                }
                $query .= "UNION ALL
                    SELECT
                        'FAMILY' as type,
                        v.name,
                        az.fp_member_name,
                        j.shgName,
                        b.name_of_cluster,
                        ah.name_of_federation,
                        az.fp_country AS name_of_country,
                        az.fp_state AS name_of_state,
                        az.fp_district AS name_of_district,
                        d.agency_name,
                        Y.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        oa.fdip_observation_highlights_a as observ_a,
                        oa.fdip_observation_highlights_b as observ_b,
                        oa.fdip_observation_highlights_c as observ_c,
                        oa.fdip_observation_highlights_d as observ_d,
                        oa.fdip_observation_highlights_e as observ_e,
                        X.locked
                    FROM
                        family_mst AS Y
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM' AND task = 'A' AND task_a1 = 'P2' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = Y.id
                    INNER JOIN family_sub_mst AS X
                    ON
                        Y.id = X.family_mst_id
                    INNER JOIN family_profile AS az
                    ON
                        X.id = az.family_sub_mst_id
                    INNER JOIN family_observation_this_year AS oa
                    ON
                        X.id = oa.family_sub_mst_id
                    INNER JOIN shg_mst AS i
                    ON
                        i.uin = Y.shg_uin
                    INNER JOIN shg_sub_mst AS w
                    ON
                        i.id = w.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = w.id
                    LEFT JOIN cluster_mst AS a
                    ON
                        i.cluster_uin = a.uin
                    LEFT JOIN cluster_sub_mst AS v
                    ON
                        a.id = v.cluster_mst_id
                    LEFT JOIN cluster_profile AS b
                    ON
                        b.cluster_sub_mst_id = v.id
                    INNER JOIN federation_mst AS c
                    ON
                        i.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS u
                    ON
                        c.id = u.federation_mst_id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = u.id
                    INNER JOIN agency AS d
                    ON
                        Y.agency_id = d.agency_id
                    WHERE
                        Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( ah.name_of_federation like '%" . $text_search . "%' )";
                    }
                }
            }
            if ($session_data['group'] == 'CL') {
                $query = " SELECT
                    'Cluster' as type,
                    v.name,
                    '-' as fp_member_name,
                    '-' as shgName,
                    az.name_of_cluster,
                    ah.name_of_federation,
                    az.name_of_country,
                    az.name_of_state,
                    az.name_of_district,
                    d.agency_name,
                    a.uin,
                    az.analysis_rating,
                    v.dm_status,
                    v.quality_status,
                    oc.cluster_observation_highlights_a as observ_a,
                    oc.cluster_observation_highlights_b as observ_b,
                    oc.cluster_observation_highlights_c as observ_c,
                    oc.cluster_observation_highlights_d as observ_d,
                    oc.cluster_observation_highlights_e as observ_e,
                    s.locked
                    FROM
                        cluster_mst AS a
                    INNER JOIN cluster_sub_mst AS s
                    ON
                        s.cluster_mst_id = a.id
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'CL' AND task = 'A' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = a.id
                    INNER JOIN cluster_profile AS az
                    ON
                        az.cluster_sub_mst_id = s.id
                    INNER JOIN federation_mst AS c
                    ON
                        a.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS X
                    ON
                        X.federation_mst_id = c.id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = X.id
                    INNER JOIN cluster_observation AS oc
                    ON
                        oc.cluster_sub_mst_id = s.id
                    INNER JOIN agency AS d
                    ON
                        a.agency_id = d.agency_id
                    WHERE
                        a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( az.name_of_cluster like '%" . $text_search . "%' )";
                    }
                }

                $query .= "UNION ALL
                    SELECT
                        'SHG' as type,
                        v.name,
                        '-' as fp_member_name,
                        az.shgName,
                        b.name_of_cluster,
                        ah.name_of_federation,
                        az.name_of_country,
                        az.name_of_state,
                        az.name_of_district,
                        d.agency_name,
                        i.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        ob.shg_observation_highlights_a as observ_a,
                        ob.shg_observation_highlights_b as observ_b,
                        ob.shg_observation_highlights_c as observ_c,
                        ob.shg_observation_highlights_d as observ_d,
                        ob.shg_observation_highlights_e as observ_e,
                        k.locked
                    FROM
                        shg_mst AS i
                    INNER JOIN shg_sub_mst AS k
                    ON
                        k.shg_mst_id = i.id
                    INNER JOIN shg_profile AS az
                    ON
                        az.shg_sub_mst_id = k.id
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = i.id
                    LEFT JOIN cluster_mst AS a
                    ON
                        i.cluster_uin = a.uin
                    LEFT JOIN cluster_sub_mst AS m
                    ON
                        m.cluster_mst_id = a.id
                    LEFT JOIN cluster_profile AS b
                    ON
                        b.cluster_sub_mst_id = m.id
                    INNER JOIN federation_mst AS c
                    ON
                        i.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS n
                    ON
                        n.federation_mst_id = c.id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = n.id
                    INNER JOIN shg_observation AS ob
                    ON
                        ob.shg_sub_mst_id = k.id
                    INNER JOIN agency AS d
                    ON
                        i.agency_id = d.agency_id
                    WHERE
                        i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( b.name_of_cluster like '%" . $text_search . "%' )";
                    }
                }

                $query .= " UNION ALL
                    SELECT
                        'FAMILY' as type,
                        v.name,
                        az.fp_member_name,
                        j.shgName,
                        b.name_of_cluster,
                        ah.name_of_federation,
                        az.fp_country AS name_of_country,
                        az.fp_state AS name_of_state,
                        az.fp_district AS name_of_district,
                        d.agency_name,
                        Y.uin,
                        az.analysis_rating,
                        v.dm_status,
                        v.quality_status,
                        oa.fdip_observation_highlights_a as observ_a,
                        oa.fdip_observation_highlights_b as observ_b,
                        oa.fdip_observation_highlights_c as observ_c,
                        oa.fdip_observation_highlights_d as observ_d,
                        oa.fdip_observation_highlights_e as observ_e,
                        X.locked
                    FROM
                        family_mst AS Y
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = Y.id
                    INNER JOIN family_sub_mst AS X
                    ON
                        Y.id = X.family_mst_id
                    INNER JOIN family_profile AS az
                    ON
                        X.id = az.family_sub_mst_id
                    INNER JOIN family_observation_this_year AS oa
                    ON
                        X.id = oa.family_sub_mst_id
                    INNER JOIN shg_mst AS i
                    ON
                        i.uin = Y.shg_uin
                    INNER JOIN shg_sub_mst AS w
                    ON
                        i.id = w.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = w.id
                    LEFT JOIN cluster_mst AS a
                    ON
                        i.cluster_uin = a.uin
                    LEFT JOIN cluster_sub_mst AS v
                    ON
                        a.id = v.cluster_mst_id
                    LEFT JOIN cluster_profile AS b
                    ON
                        b.cluster_sub_mst_id = v.id
                    INNER JOIN federation_mst AS c
                    ON
                        i.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS u
                    ON
                        c.id = u.federation_mst_id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = u.id
                    INNER JOIN agency AS d
                    ON
                        Y.agency_id = d.agency_id
                    WHERE
                        Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( b.name_of_cluster like '%" . $text_search . "%' )";
                    }
                }
            }
            if ($session_data['group'] == 'SH') {
                $query = " SELECT
                    'SHG' as type,
                    v.name,
                    '-' as fp_member_name,
                    az.shgName,
                    b.name_of_cluster,
                    ah.name_of_federation,
                    az.name_of_country,
                    az.name_of_state,
                    az.name_of_district,
                    d.agency_name,
                    i.uin,
                    az.analysis_rating,
                    v.dm_status,
                    v.quality_status,
                    ob.shg_observation_highlights_a as observ_a,
                    ob.shg_observation_highlights_b as observ_b,
                    ob.shg_observation_highlights_c as observ_c,
                    ob.shg_observation_highlights_d as observ_d,
                    ob.shg_observation_highlights_e as observ_e,
                    k.locked
                    FROM
                        shg_mst AS i
                    INNER JOIN shg_sub_mst AS k
                    ON
                        k.shg_mst_id = i.id
                    INNER JOIN shg_profile AS az
                    ON
                        az.shg_sub_mst_id = k.id
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = i.id
                    LEFT JOIN cluster_mst AS a
                    ON
                        i.cluster_uin = a.uin
                    LEFT JOIN cluster_sub_mst AS m
                    ON
                        m.cluster_mst_id = a.id
                    LEFT JOIN cluster_profile AS b
                    ON
                        b.cluster_sub_mst_id = m.id
                    INNER JOIN federation_mst AS c
                    ON
                        i.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS n
                    ON
                        n.federation_mst_id = c.id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = n.id
                    INNER JOIN shg_observation AS ob
                    ON
                        ob.shg_sub_mst_id = k.id
                    INNER JOIN agency AS d
                    ON
                        i.agency_id = d.agency_id
                    WHERE
                        i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( az.shgName like '%" . $text_search . "%' )";
                    }
                }
                $query .= " UNION ALL SELECT
                    'FAMILY' as type,
                    v.name,
                    az.fp_member_name,
                    j.shgName,
                    b.name_of_cluster,
                    ah.name_of_federation,
                    az.fp_country AS name_of_country,
                    az.fp_state AS name_of_state,
                    az.fp_district AS name_of_district,
                    d.agency_name,
                    Y.uin,
                    az.analysis_rating,
                    v.dm_status,
                    v.quality_status,
                    oa.fdip_observation_highlights_a as observ_a,
                    oa.fdip_observation_highlights_b as observ_b,
                    oa.fdip_observation_highlights_c as observ_c,
                    oa.fdip_observation_highlights_d as observ_d,
                    oa.fdip_observation_highlights_e as observ_e,
                    X.locked
                FROM
                    family_mst AS Y
                INNER JOIN(
                    SELECT
                        assignment_id,
                        name,
                        qa_status as dm_status,
                        quality_status
                    FROM
                        (
                        SELECT
                            assignment_id,
                            task_a1,
                            SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                            quality_date,
                            user_id,
                            quality_status
                        FROM
                            task_qa_assignment
                        WHERE
                            assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                        GROUP BY
                            assignment_id
                    ) a
                    INNER JOIN users AS u
                    ON
                        a.user_id = u.id
                ) AS v
                ON
                    v.assignment_id = Y.id
                INNER JOIN family_sub_mst AS X
                ON
                    Y.id = X.family_mst_id
                INNER JOIN family_profile AS az
                ON
                    X.id = az.family_sub_mst_id
                INNER JOIN family_observation_this_year AS oa
                ON
                    X.id = oa.family_sub_mst_id
                INNER JOIN shg_mst AS i
                ON
                    i.uin = Y.shg_uin
                INNER JOIN shg_sub_mst AS w
                ON
                    i.id = w.shg_mst_id
                INNER JOIN shg_profile AS j
                ON
                    j.shg_sub_mst_id = w.id
                LEFT JOIN cluster_mst AS a
                ON
                    i.cluster_uin = a.uin
                LEFT JOIN cluster_sub_mst AS v
                ON
                    a.id = v.cluster_mst_id
                LEFT JOIN cluster_profile AS b
                ON
                    b.cluster_sub_mst_id = v.id
                INNER JOIN federation_mst AS c
                ON
                    i.federation_uin = c.uin
                INNER JOIN federation_sub_mst AS u
                ON
                    c.id = u.federation_mst_id
                INNER JOIN federation_profile AS ah
                ON
                    ah.federation_sub_mst_id = u.id
                INNER JOIN agency AS d
                ON
                    Y.agency_id = d.agency_id
                WHERE
                    Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( j.shgName like '%" . $text_search . "%' )";
                    }
                }
            }
            if ($session_data['group'] == 'FM') {
                $query = "SELECT
                    'FAMILY' as type,
                    v.name,
                    az.fp_member_name,
                    j.shgName,
                    b.name_of_cluster,
                    ah.name_of_federation,
                    az.fp_country AS name_of_country,
                    az.fp_state AS name_of_state,
                    az.fp_district AS name_of_district,
                    d.agency_name,
                    Y.uin,
                    az.analysis_rating,
                    v.dm_status,
                    v.quality_status,
                    oa.fdip_observation_highlights_a as observ_a,
                    oa.fdip_observation_highlights_b as observ_b,
                    oa.fdip_observation_highlights_c as observ_c,
                    oa.fdip_observation_highlights_d as observ_d,
                    oa.fdip_observation_highlights_e as observ_e,
                    X.locked
                    FROM
                        family_mst AS Y
                    INNER JOIN(
                        SELECT
                            assignment_id,
                            name,
                            qa_status as dm_status,
                            quality_status
                        FROM
                            (
                            SELECT
                                assignment_id,
                                task_a1,
                                SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                                quality_date,
                                user_id,
                                quality_status
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                            GROUP BY
                                assignment_id
                        ) a
                        INNER JOIN users AS u
                        ON
                            a.user_id = u.id
                    ) AS v
                    ON
                        v.assignment_id = Y.id
                    INNER JOIN family_sub_mst AS X
                    ON
                        Y.id = X.family_mst_id
                    INNER JOIN family_profile AS az
                    ON
                        X.id = az.family_sub_mst_id
                    INNER JOIN family_observation_this_year AS oa
                    ON
                        X.id = oa.family_sub_mst_id
                    INNER JOIN shg_mst AS i
                    ON
                        i.uin = Y.shg_uin
                    INNER JOIN shg_sub_mst AS w
                    ON
                        i.id = w.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = w.id
                    LEFT JOIN cluster_mst AS a
                    ON
                        i.cluster_uin = a.uin
                    LEFT JOIN cluster_sub_mst AS v
                    ON
                        a.id = v.cluster_mst_id
                    LEFT JOIN cluster_profile AS b
                    ON
                        b.cluster_sub_mst_id = v.id
                    INNER JOIN federation_mst AS c
                    ON
                        i.federation_uin = c.uin
                    INNER JOIN federation_sub_mst AS u
                    ON
                        c.id = u.federation_mst_id
                    INNER JOIN federation_profile AS ah
                    ON
                        ah.federation_sub_mst_id = u.id
                    INNER JOIN agency AS d
                    ON
                        Y.agency_id = d.agency_id
                    WHERE
                        Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( az.fp_member_name like '%" . $text_search . "%' )";
                    }
                }
            }
            if ($session_data['group'] == 'AG') {
                $query = "SELECT
                    'FAMILY' as type,
                    v.name,
                    az.fp_member_name,
                    j.shgName,
                    b.name_of_cluster,
                    ah.name_of_federation,
                    az.fp_country AS name_of_country,
                    az.fp_state AS name_of_state,
                    az.fp_district AS name_of_district,
                    d.agency_name,
                    Y.uin,
                    az.analysis_rating,
                    v.dm_status,
                    v.quality_status,
                    oa.fdip_observation_highlights_a as observ_a,
                    oa.fdip_observation_highlights_b as observ_b,
                    oa.fdip_observation_highlights_c as observ_c,
                    oa.fdip_observation_highlights_d as observ_d,
                    oa.fdip_observation_highlights_e as observ_e,
                    X.locked
                FROM
                    family_mst AS Y
                INNER JOIN(
                    SELECT
                        assignment_id,
                        name,
                        qa_status as dm_status,
                        quality_status
                    FROM
                        (
                        SELECT
                            assignment_id,
                            task_a1,
                            SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                            quality_date,
                            user_id,
                            quality_status
                        FROM
                            task_qa_assignment
                        WHERE
                            assignment_type = 'FM' AND task_a1 = 'P2' AND qa_status = 'V'
                        GROUP BY
                            assignment_id
                    ) a
                    INNER JOIN users AS u
                    ON
                        a.user_id = u.id
                ) AS v
                ON
                    v.assignment_id = Y.id
                INNER JOIN family_sub_mst AS X
                ON
                    Y.id = X.family_mst_id
                INNER JOIN family_profile AS az
                ON
                    X.id = az.family_sub_mst_id
                INNER JOIN family_observation_this_year AS oa
                ON
                    X.id = oa.family_sub_mst_id
                INNER JOIN shg_mst AS i
                ON
                    i.uin = Y.shg_uin
                INNER JOIN shg_sub_mst AS w
                ON
                    i.id = w.shg_mst_id
                INNER JOIN shg_profile AS j
                ON
                    j.shg_sub_mst_id = w.id
                LEFT JOIN cluster_mst AS a
                ON
                    i.cluster_uin = a.uin
                LEFT JOIN cluster_sub_mst AS v
                ON
                    a.id = v.cluster_mst_id
                LEFT JOIN cluster_profile AS b
                ON
                    b.cluster_sub_mst_id = v.id
                INNER JOIN federation_mst AS c
                ON
                    i.federation_uin = c.uin
                INNER JOIN federation_sub_mst AS u
                ON
                    c.id = u.federation_mst_id
                INNER JOIN federation_profile AS ah
                ON
                    ah.federation_sub_mst_id = u.id
                INNER JOIN agency AS d
                ON
                    Y.agency_id = d.agency_id
                WHERE
                    Y.is_deleted = 0 AND X.dm_p2='V' AND X.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.fp_state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.fp_district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.fp_country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                    }
                }

                $query .= "UNION ALL
                SELECT
                    'SHG' as type,
                    v.name,
                    '-' as fp_member_name,
                    az.shgName,
                    b.name_of_cluster,
                    ah.name_of_federation,
                    az.name_of_country,
                    az.name_of_state,
                    az.name_of_district,
                    d.agency_name,
                    i.uin,
                    az.analysis_rating,
                    v.dm_status,
                    v.quality_status,
                    ob.shg_observation_highlights_a as observ_a,
                    ob.shg_observation_highlights_b as observ_b,
                    ob.shg_observation_highlights_c as observ_c,
                    ob.shg_observation_highlights_d as observ_d,
                    ob.shg_observation_highlights_e as observ_e,
                    k.locked
                FROM
                    shg_mst AS i
                INNER JOIN shg_sub_mst AS k
                ON
                    k.shg_mst_id = i.id
                INNER JOIN shg_profile AS az
                ON
                    az.shg_sub_mst_id = k.id
                INNER JOIN(
                    SELECT
                        assignment_id,
                        name,
                        qa_status as dm_status,
                        quality_status
                    FROM
                        (
                        SELECT
                            assignment_id,
                            task_a1,
                            SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                            quality_date,
                            user_id,
                            quality_status
                        FROM
                            task_qa_assignment
                        WHERE
                            assignment_type = 'SH' AND task = 'A' AND qa_status = 'V'
                        GROUP BY
                            assignment_id
                    ) a
                    INNER JOIN users AS u
                    ON
                        a.user_id = u.id
                ) AS v
                ON
                    v.assignment_id = i.id
                LEFT JOIN cluster_mst AS a
                ON
                    i.cluster_uin = a.uin
                LEFT JOIN cluster_sub_mst AS m
                ON
                    m.cluster_mst_id = a.id
                LEFT JOIN cluster_profile AS b
                ON
                    b.cluster_sub_mst_id = m.id
                INNER JOIN federation_mst AS c
                ON
                    i.federation_uin = c.uin
                INNER JOIN federation_sub_mst AS n
                ON
                    n.federation_mst_id = c.id
                INNER JOIN federation_profile AS ah
                ON
                    ah.federation_sub_mst_id = n.id
                INNER JOIN shg_observation AS ob
                ON
                    ob.shg_sub_mst_id = k.id
                INNER JOIN agency AS d
                ON
                    i.agency_id = d.agency_id
                WHERE
                    i.is_deleted = 0 AND k.dm_a='V' AND k.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                    }
                }

                $query .= " UNION ALL
                SELECT
                    'Cluster' as type,
                    v.name,
                    '-' as fp_member_name,
                    '-' as shgName,
                    az.name_of_cluster,
                    ah.name_of_federation,
                    az.name_of_country,
                    az.name_of_state,
                    az.name_of_district,
                    d.agency_name,
                    a.uin,
                    az.analysis_rating,
                    v.dm_status,
                    v.quality_status,
                    oc.cluster_observation_highlights_a as observ_a,
                    oc.cluster_observation_highlights_b as observ_b,
                    oc.cluster_observation_highlights_c as observ_c,
                    oc.cluster_observation_highlights_d as observ_d,
                    oc.cluster_observation_highlights_e as observ_e,
                    s.locked
                FROM
                    cluster_mst AS a
                INNER JOIN cluster_sub_mst AS s
                ON
                    s.cluster_mst_id = a.id
                INNER JOIN(
                    SELECT
                        assignment_id,
                        name,
                        qa_status as dm_status,
                        quality_status
                    FROM
                        (
                        SELECT
                            assignment_id,
                            task_a1,
                            SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                            quality_date,
                            user_id,
                            quality_status
                        FROM
                            task_qa_assignment
                        WHERE
                            assignment_type = 'CL' AND task = 'A' AND qa_status = 'V'
                        GROUP BY
                            assignment_id
                    ) a
                    INNER JOIN users AS u
                    ON
                        a.user_id = u.id
                ) AS v
                ON
                    v.assignment_id = a.id
                INNER JOIN cluster_profile AS az
                ON
                    az.cluster_sub_mst_id = s.id
                INNER JOIN federation_mst AS c
                ON
                    a.federation_uin = c.uin
                INNER JOIN federation_sub_mst AS X
                ON
                    X.federation_mst_id = c.id
                INNER JOIN federation_profile AS ah
                ON
                    ah.federation_sub_mst_id = X.id
                INNER JOIN cluster_observation AS oc
                ON
                    oc.cluster_sub_mst_id = s.id
                INNER JOIN agency AS d
                ON
                    a.agency_id = d.agency_id
                WHERE
                    a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                    }
                }
                $query .= " UNION ALL
                SELECT
                'Federation' as type,
                    v.name,
                    '-' as fp_member_name,
                    '-' as shgName,
                    '-' as name_of_cluster,
                    az.name_of_federation,
                    az.name_of_country,
                    az.name_of_state,
                    az.name_of_district,
                    d.agency_name,
                    a.uin,
                    az.analysis_rating,
                    v.dm_status,
                    v.quality_status,
                    od.federationObserHighlightsA as observ_a,
                    od.federationObserHighlightsB as observ_b,
                    od.federationObserHighlightsC as observ_c,
                    od.federationObserHighlightsD as observ_d,
                    od.federationObserHighlightsE as observ_e,
                    s.locked
                FROM
                    federation_mst AS a
                INNER JOIN federation_sub_mst AS s
                ON
                    s.federation_mst_id = a.id
                INNER JOIN(
                    SELECT
                        assignment_id,
                        name,
                        qa_status as dm_status,
                        quality_status
                    FROM
                        (
                        SELECT
                            assignment_id,
                            task_a1,
                            SUBSTRING_INDEX(GROUP_CONCAT(qa_status ORDER BY id DESC),',',1) AS qa_status,
                            quality_date,
                            user_id,
                            quality_status
                        FROM
                            task_qa_assignment
                        WHERE
                            assignment_type = 'FD' AND task = 'A' AND qa_status = 'V'
                        GROUP BY
                            assignment_id
                    ) a
                    INNER JOIN users AS u
                    ON
                        a.user_id = u.id
                ) AS v
                ON
                    v.assignment_id = a.id
                LEFT JOIN federation_profile AS az
                ON
                    az.federation_sub_mst_id = s.id
                INNER JOIN federation_observation AS od
                ON
                    od.federation_sub_mst_id = s.id
                INNER JOIN agency AS d
                ON
                    a.agency_id = d.agency_id
                WHERE
                    a.is_deleted = 0 AND s.dm_a='V' AND s.locked=1
                ";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state'])) {
                        if ($session_data['state'] != '' && $session_data['state'] > 0) {
                            $query .= " AND az.state_id = '" . $session_data['state'] . "' ";
                        }
                    }
                    if (!empty($session_data['district'])) {
                        if ($session_data['district'] != '' && $session_data['district'] > 0) {
                            $query .= " AND az.district_id = '" . $session_data['district'] . "' ";
                        }
                    }
                    if (!empty($session_data['country'])) {
                        if ($session_data['country'] != '' && $session_data['country'] > 0) {
                            $query .= " AND az.country_id = '" . $session_data['country'] . "' ";
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        $text_search = $session_data['federation'];
                        $query .= " AND ( d.agency_name like '%" . $text_search . "%' )";
                    }
                }
            }

            $res['data'] = DB::select($query);
        }

        //prd($res);
        $res['session_data'] =  $session_data;
        //return view('fedreports.export_pdf')->with($res);
        view()->share('res', $res);
        if (!empty($session_data['group'])) {
            if ($session_data['group'] == 'FM' && empty($session_data['federation'])) {
                $pdf_doc = PDF::loadView('pdf.export_pdf', $res)->setPaper('a3', 'landscape');
                return $pdf_doc->download('AnalyticsReport_Family_'.pdf_date().'.pdf');
            } elseif ($session_data['group'] == 'SH' && empty($session_data['federation'])) {
                $pdf_doc = PDF::loadView('pdf.export_pdf', $res)->setPaper('a3', 'landscape');
                return $pdf_doc->download('AnalyticsReport_SHG_'.pdf_date().'.pdf');
            } elseif ($session_data['group'] == 'CL' && empty($session_data['federation'])) {
                $pdf_doc = PDF::loadView('pdf.export_pdf', $res)->setPaper('a3', 'landscape');
                return $pdf_doc->download('AnalyticsReport_Cluster_'.pdf_date().'.pdf');
            } elseif ($session_data['group'] == 'FD' && empty($session_data['federation'])) {
                $pdf_doc = PDF::loadView('pdf.export_pdf', $res)->setPaper('a3', 'landscape');
                return $pdf_doc->download('AnalyticsReport_Federation_'.pdf_date().'.pdf');
            } elseif ($session_data['group'] == 'AG' && empty($session_data['federation'])) {
                $pdf_doc = PDF::loadView('pdf.export_pdf', $res)->setPaper('a3', 'landscape');
                return $pdf_doc->download('AnalyticsReport_Agency_'.pdf_date().'.pdf');
            } else {
                $pdf_doc = PDF::loadView('pdf.export_pdf', $res)->setPaper('a3', 'landscape');
                return $pdf_doc->download('AnalyticsReport_'.pdf_date().'.pdf');
            }
        } else {
            $pdf_doc = PDF::loadView('pdf.export_pdf', $res)->setPaper('a3', 'landscape');
            return $pdf_doc->download('AnalyticsReport_'.pdf_date().'.pdf');
        }
    }
}
