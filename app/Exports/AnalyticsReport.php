<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class AnalyticsReport implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
{
    public $curdate = '';
    public $counter = 1;
    public function __construct()
    {
        $this->curdate = Carbon::now()->format('d-m-Y');
    }
    public function collection()
    {
        $user = Auth::user();
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
                $res= DB::select($query);
                
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

                $res= DB::select($query);
                
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
                $res= DB::select($query);
                
            }
            //  prd($res);
            return collect($res);
        
    }
    
    public function map($res): array
    {
        
        $session_data = Session::get('fed_filter_session');
        $result_mid = [];
        if ($session_data['group'] == 'FM' && empty($session_data['federation'])) {
            $a =  $res->observ_a;
            $b =  $res->observ_b;
            $c =  $res->observ_c;
            $d =  $res->observ_d;
            $e =  $res->observ_e;
            $rr = '';
            if ($a != '') {
                $rr .=$a .',';
            }
            if ($b != '') {
                $rr .= $b . ',';
            }
            if ($c != '') {
                $rr .=$c .',';
            }
            if ($d != '') {
                $rr .= $d . ',';
            }
            if ($e != '') {
                $rr .= $e ;
            }

            if ($rr == '') {
                $row = '-';
            } else {
                $row = rtrim($rr, ',');
            }
            $result = [
                $this->counter++, 
                $res->name,
                $res->fp_member_name,
                $res->shgName,
                $res->name_of_cluster,
                $res->name_of_federation
                ];

            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                    $result_mid[] = $res->name_of_state;
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                }
            } else {
                $result_mid[] = $res->name_of_district;
                $result_mid[] = $res->name_of_state;
                $result_mid[] = $res->name_of_country;
            }

            $result_end = [$row,
            $res->analysis_rating,
                $res->dm_status == 'V' ? 'Yes' : 'No',
                $res->quality_status == 'V' ? 'Yes' : 'No',
                $res->locked == 1 ? 'Yes' : 'No'];
            $result_head = array_merge($result, $result_mid, $result_end);

            return [
                $result_head
            ];
        } elseif ($session_data['group'] == 'FD' && empty($session_data['federation'])) {
            $a =  $res->observ_a;
            $b =  $res->observ_b;
            $c =  $res->observ_c;
            $d =  $res->observ_d;
            $e =  $res->observ_e;
            $rr = '';
            if ($a != '') {
                $rr .=$a .',';
            }
            if ($b != '') {
                $rr .= $b . ',';
            }
            if ($c != '') {
                $rr .=$c .',';
            }
            if ($d != '') {
                $rr .= $d . ',';
            }
            if ($e != '') {
                $rr .= $e ;
            }

            if ($rr == '') {
                $row = '-';
            } else {
                $row = rtrim($rr, ',');
            }
            $result = [
                $this->counter++, 
                $res->name,
                $res->name_of_federation
                ];
            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                    $result_mid[] = $res->name_of_state;
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                }
            } else {
                $result_mid[] = $res->name_of_district;
                $result_mid[] = $res->name_of_state;
                $result_mid[] = $res->name_of_country;
            }
            $result_end = [$row,
                $res->analysis_rating,
                $res->dm_status == 'V' ? 'Yes' : 'No',
                $res->quality_status == 'V' ? 'Yes' : 'No',
                $res->locked == 1 ? 'Yes' : 'No'];

            $result_head = array_merge($result, $result_mid, $result_end);

            return [
                $result_head
            ];
        } elseif ($session_data['group'] == 'CL' && empty($session_data['federation'])) {
            $a =  $res->observ_a;
            $b =  $res->observ_b;
            $c =  $res->observ_c;
            $d =  $res->observ_d;
            $e =  $res->observ_e;
            $rr = '';
            if ($a != '') {
                $rr .=$a .',';
            }
            if ($b != '') {
                $rr .= $b . ',';
            }
            if ($c != '') {
                $rr .=$c .',';
            }
            if ($d != '') {
                $rr .= $d . ',';
            }
            if ($e != '') {
                $rr .= $e ;
            }

            if ($rr == '') {
                $row = '-';
            } else {
                $row = rtrim($rr, ',');
            }
            $result = [
                $this->counter++, 
                $res->name,
                $res->name_of_cluster,
                $res->name_of_federation
               ];
            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                    $result_mid[] = $res->name_of_state;
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                }
            } else {
                $result_mid[] = $res->name_of_district;
                $result_mid[] = $res->name_of_state;
                $result_mid[] = $res->name_of_country;
            }
            $result_end = [$row,
                $res->analysis_rating,
                $res->dm_status == 'V' ? 'Yes' : 'No',
                $res->quality_status == 'V' ? 'Yes' : 'No',
                $res->locked == 1 ? 'Yes' : 'No'];

            $result_head = array_merge($result, $result_mid, $result_end);

            return [
                $result_head
            ];
        } elseif ($session_data['group'] == 'SH' && empty($session_data['federation'])) {
            $a =  $res->observ_a;
            $b =  $res->observ_b;
            $c =  $res->observ_c;
            $d =  $res->observ_d;
            $e =  $res->observ_e;
            $rr = '';
            if ($a != '') {
                $rr .=$a .',';
            }
            if ($b != '') {
                $rr .= $b . ',';
            }
            if ($c != '') {
                $rr .=$c .',';
            }
            if ($d != '') {
                $rr .= $d . ',';
            }
            if ($e != '') {
                $rr .= $e ;
            }

            if ($rr == '') {
                $row = '-';
            } else {
                $row = rtrim($rr, ',');
            }

            $result = [ $this->counter++, 
                $res->name,
                $res->shgName,
                $res->name_of_cluster,
                $res->name_of_federation
                ];
            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                    $result_mid[] = $res->name_of_state;
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                }
            } else {
                $result_mid[] = $res->name_of_district;
                $result_mid[] = $res->name_of_state;
                $result_mid[] = $res->name_of_country;
            }
            $result_end = [$row,
                $res->analysis_rating,
                $res->dm_status == 'V' ? 'Yes' : 'No',
                $res->quality_status == 'V' ? 'Yes' : 'No',
                $res->locked == 1 ? 'Yes' : 'No'];
            $result_head = array_merge($result, $result_mid, $result_end);

            return [
                $result_head
            ];
        } elseif ($session_data['group'] == 'AG' && empty($session_data['federation'])) {
            $a =  $res->observ_a;
            $b =  $res->observ_b;
            $c =  $res->observ_c;
            $d =  $res->observ_d;
            $e =  $res->observ_e;
            $rr = '';
            if ($a != '') {
                $rr .=$a .',';
            }
            if ($b != '') {
                $rr .= $b . ',';
            }
            if ($c != '') {
                $rr .=$c .',';
            }
            if ($d != '') {
                $rr .= $d . ',';
            }
            if ($e != '') {
                $rr .= $e ;
            }

            if ($rr == '') {
                $row = '-';
            } else {
                $row = rtrim($rr, ',');
            }
            $result = [$this->counter++, 
                $res->name,
                $res->fp_member_name,
                $res->shgName,
                $res->name_of_cluster,
                $res->name_of_federation,
                $res->agency_name];
            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                    $result_mid[] = $res->name_of_state;
                    
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                }
                
            } else {
                $result_mid[] = $res->name_of_district;
                $result_mid[] = $res->name_of_state;
                $result_mid[] = $res->name_of_country;
            }
            $result_end = [$row,
                $res->analysis_rating,
                $res->dm_status == 'V' ? 'Yes' : 'No',
                $res->quality_status == 'V' ? 'Yes' : 'No',
                $res->locked == 1 ? 'Yes' : 'No',];
            $result_head = array_merge($result, $result_mid, $result_end);

            return [
                $result_head
            ];
        }
        elseif ($session_data['group'] == 'AG' && !empty($session_data['federation'])) {
            $a =  $res->observ_a;
            $b =  $res->observ_b;
            $c =  $res->observ_c;
            $d =  $res->observ_d;
            $e =  $res->observ_e;
            $rr = '';
            if ($a != '') {
                $rr .=$a .',';
            }
            if ($b != '') {
                $rr .= $b . ',';
            }
            if ($c != '') {
                $rr .=$c .',';
            }
            if ($d != '') {
                $rr .= $d . ',';
            }
            if ($e != '') {
                $rr .= $e ;
            }

            if ($rr == '') {
                $row = '-';
            } else {
                $row = rtrim($rr, ',');
            }
            $result = [$this->counter++, 
                $res->name,
                $res->fp_member_name,
                $res->shgName,
                $res->name_of_cluster,
                $res->name_of_federation
                ];
            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                    $result_mid[] = $res->name_of_state;
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                }
                
            } else {
                $result_mid[] = $res->name_of_district;
                $result_mid[] = $res->name_of_state;
                $result_mid[] = $res->name_of_country;
            }
            $result_end = [$row,
                $res->analysis_rating,
                $res->dm_status == 'V' ? 'Yes' : 'No',
                $res->quality_status == 'V' ? 'Yes' : 'No',
                $res->locked == 1 ? 'Yes' : 'No',];
            $result_head = array_merge($result, $result_mid, $result_end);

            return [
                $result_head
            ];
        } 
        elseif ($session_data['group'] == 'FM' && !empty($session_data['federation'])) {
            $a =  $res->observ_a;
            $b =  $res->observ_b;
            $c =  $res->observ_c;
            $d =  $res->observ_d;
            $e =  $res->observ_e;
            $rr = '';
            if ($a != '') {
                $rr .=$a .',';
            }
            if ($b != '') {
                $rr .= $b . ',';
            }
            if ($c != '') {
                $rr .=$c .',';
            }
            if ($d != '') {
                $rr .= $d . ',';
            }
            if ($e != '') {
                $rr .= $e ;
            }

            if ($rr == '') {
                $row = '-';
            } else {
                $row = rtrim($rr, ',');
            }
            $result = [$this->counter++, 
                $res->name,
                $res->uin,
                $res->shgName,
                $res->name_of_cluster,
                $res->name_of_federation
                ];
            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                    $result_mid[] = $res->name_of_state;
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                }
            } else {
                $result_mid[] = $res->name_of_district;
                $result_mid[] = $res->name_of_state;
                $result_mid[] = $res->name_of_country;
            }
            $result_end = [$row,
                $res->analysis_rating,
                $res->dm_status == 'V' ? 'Yes' : 'No',
                $res->quality_status == 'V' ? 'Yes' : 'No',
                $res->locked == 1 ? 'Yes' : 'No'];
            $result_head = array_merge($result, $result_mid, $result_end);

            return [
                $result_head
            ];
        }
        elseif ($session_data['group'] == 'SH' && !empty($session_data['federation'])) {
            $a =  $res->observ_a;
            $b =  $res->observ_b;
            $c =  $res->observ_c;
            $d =  $res->observ_d;
            $e =  $res->observ_e;
            $rr = '';
            if ($a != '') {
                $rr .=$a .',';
            }
            if ($b != '') {
                $rr .= $b . ',';
            }
            if ($c != '') {
                $rr .=$c .',';
            }
            if ($d != '') {
                $rr .= $d . ',';
            }
            if ($e != '') {
                $rr .= $e ;
            }

            if ($rr == '') {
                $row = '-';
            } else {
                $row = rtrim($rr, ',');
            }
            $result = [$this->counter++, 
                $res->name,
                $res->uin,
                $res->fp_member_name,
                $res->name_of_cluster,
                $res->name_of_federation
                ];
            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                    $result_mid[] = $res->name_of_state;
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                }
            } else {
                $result_mid[] = $res->name_of_district;
                $result_mid[] = $res->name_of_state;
                $result_mid[] = $res->name_of_country;
            }
            $result_end = [$row,
                $res->analysis_rating,
                $res->dm_status == 'V' ? 'Yes' : 'No',
                $res->quality_status == 'V' ? 'Yes' : 'No',
                $res->locked == 1 ? 'Yes' : 'No'];
            $result_head = array_merge($result, $result_mid, $result_end);

            return [
                $result_head
            ];
        }
        elseif ($session_data['group'] == 'CL' && !empty($session_data['federation'])) {
            $a =  $res->observ_a;
            $b =  $res->observ_b;
            $c =  $res->observ_c;
            $d =  $res->observ_d;
            $e =  $res->observ_e;
            $rr = '';
            if ($a != '') {
                $rr .=$a .',';
            }
            if ($b != '') {
                $rr .= $b . ',';
            }
            if ($c != '') {
                $rr .=$c .',';
            }
            if ($d != '') {
                $rr .= $d . ',';
            }
            if ($e != '') {
                $rr .= $e ;
            }

            if ($rr == '') {
                $row = '-';
            } else {
                $row = rtrim($rr, ',');
            }
            $result = [
                $this->counter++, 
                $res->name,
                $res->uin,
                $res->fp_member_name,
                $res->shgName,
                $res->name_of_federation
                ];
            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                    $result_mid[] = $res->name_of_state;
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                }
            } else {
                $result_mid[] = $res->name_of_district;
                $result_mid[] = $res->name_of_state;
                $result_mid[] = $res->name_of_country;
            }
            $result_end = [$row,
                $res->analysis_rating,
                $res->dm_status == 'V' ? 'Yes' : 'No',
                $res->quality_status == 'V' ? 'Yes' : 'No',
                $res->locked == 1 ? 'Yes' : 'No'];
            $result_head = array_merge($result, $result_mid, $result_end);

            return [
                $result_head
            ];
        }
        elseif ($session_data['group'] == 'FD' && !empty($session_data['federation'])) {
            $a =  $res->observ_a;
            $b =  $res->observ_b;
            $c =  $res->observ_c;
            $d =  $res->observ_d;
            $e =  $res->observ_e;
            $rr = '';
            if ($a != '') {
                $rr .=$a .',';
            }
            if ($b != '') {
                $rr .= $b . ',';
            }
            if ($c != '') {
                $rr .=$c .',';
            }
            if ($d != '') {
                $rr .= $d . ',';
            }
            if ($e != '') {
                $rr .= $e ;
            }

            if ($rr == '') {
                $row = '-';
            } else {
                $row = rtrim($rr, ',');
            }
            $result = [$this->counter++, 
                $res->name,
               $res->uin,
               $res->fp_member_name,
               $res->shgName,
               $res->name_of_cluster
               ];
            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                    $result_mid[] = $res->name_of_state;
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                }
            } else {
                $result_mid[] = $res->name_of_district;
                $result_mid[] = $res->name_of_state;
                $result_mid[] = $res->name_of_country;
            }
            $result_end = [$row,
                $res->analysis_rating,
                $res->dm_status == 'V' ? 'Yes' : 'No',
                $res->quality_status == 'V' ? 'Yes' : 'No',
                $res->locked == 1 ? 'Yes' : 'No'];
            $result_head = array_merge($result, $result_mid, $result_end);

            return [
                $result_head
            ];
        }
        else {
            $a =  $res->observ_a;
            $b =  $res->observ_b;
            $c =  $res->observ_c;
            $d =  $res->observ_d;
            $e =  $res->observ_e;
            $rr = '';
            if ($a != '') {
                $rr .=$a .',';
            }
            if ($b != '') {
                $rr .= $b . ',';
            }
            if ($c != '') {
                $rr .=$c .',';
            }
            if ($d != '') {
                $rr .= $d . ',';
            }
            if ($e != '') {
                $rr .= $e ;
            }

            if ($rr == '') {
                $row = '-';
            } else {
                $row = rtrim($rr, ',');
            }
            $result = [$this->counter++, 
                $res->type,
                $res->uin,
                $res->name,
                $res->fp_member_name,
                $res->shgName,
                $res->name_of_cluster,
                $res->name_of_federation,
                $res->agency_name];
            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                    $result_mid[] = $res->name_of_state;
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $result_mid[] = $res->name_of_district;
                }
            } else {
                $result_mid[] = $res->name_of_district;
                $result_mid[] = $res->name_of_state;
                $result_mid[] = $res->name_of_country;
            }
            $result_end = [$row,
                $res->analysis_rating,
                $res->dm_status == 'V' ? 'Yes' : 'No',
                $res->quality_status == 'V' ? 'Yes' : 'No',
                $res->locked == 1 ? 'Yes' : 'No'];
            $result_head = array_merge($result, $result_mid, $result_end);

            return [
                $result_head
            ];
        }
        
    }

    public function columnFormats(): array
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:A5')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'color' => ['argb' => '#CCCCCC']
                    ]
                ]);

                $event->sheet->getStyle('A7:T7')->applyFromArray([
                    'font' => ['bold' => true]
                ]);
            },
        ];
    }

    public function headings(): array
    {
        $session_data = Session::get('fed_filter_session');
        //prd($session_data);
        $group = '';
        $headerMerge = "";
        if (!empty($session_data['group'])) {
            if ($session_data['group'] == 'FD') {
                $group = "Federation";
            }
            if ($session_data['group'] == 'CL') {
                $group = "Cluster";
            }
            if ($session_data['group'] == 'SH') {
                $group = "SHG";
            }
            if ($session_data['group'] == 'FM') {
                $group = "Family";
            }
            if ($session_data['group'] == 'AG') {
                $group = "Agency";
            }

            $mainheader = [];
            if (!empty($session_data)) {
                if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])) {
                    $mainheader[] = 'District';
                    $mainheader[] = 'State';
                } elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district'])) {
                    $mainheader[] = 'District';
                }
            } else {
                $mainheader[] = 'District';
                $mainheader[] = 'State';
                $mainheader[] = 'Country';
            }
            $mainheader1 = ['Observations by field faciliators','Initial Rating Score', 'Verfieid By District Manager', 'Verfieid By DART/ViV staff','Locked'];

           

            $mainheader = array_merge($mainheader, $mainheader1);

            


            if ($session_data['group'] == 'FM' && empty($session_data['federation'])) {
                $main_head = ['S.No','Analytics/Initial Rating done by','SHG Member Name', 'SHG Name', 'Cluster Name','Federation Name'];
                $head = array_merge($main_head, $mainheader);
                return [
                ['Group Type', ($group != '' ? $group : "-")],
                ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
                ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
                ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
                ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
                [],
                $head
            ];
            } elseif ($session_data['group'] == 'SH' && empty($session_data['federation'])) {
                $main_head = ['S.No','Analytics/Initial Rating done by', 'SHG Name','Cluster Name','Federation Name'];
                $head = array_merge($main_head, $mainheader);
                return [
                ['Group Type', ($group != '' ? $group : "-")],
                ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
                ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
                ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
                ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
                [],
                $head

            ];
            } elseif ($session_data['group'] == 'CL' && empty($session_data['federation'])) {
                $main_head = ['S.No','Analytics/Initial Rating done by','Cluster Name','Federation Name'];
                $head = array_merge($main_head, $mainheader);
                return [
                ['Group Type', ($group != '' ? $group : "-")],
                ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
                ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
                ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
                ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
                [],
                $head
            ];
            } elseif ($session_data['group'] == 'FD' && empty($session_data['federation'])) {
                $main_head = ['S.No','Analytics/Initial Rating done by','Federation Name'];
                $head = array_merge($main_head, $mainheader);
                return [
                ['Group Type', ($group != '' ? $group : "-")],
                ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
                ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
                ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
                ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
                [],
                $head
            ];
            } elseif ($session_data['group'] == 'AG' && empty($session_data['federation'])) {
                $main_head = ['S.No','Analytics/Initial Rating done by','SHG Member Name', 'SHG Name', 'Cluster Name','Federation Name','Agency'];
                $head = array_merge($main_head, $mainheader);
                return [
                ['Group Type', ($group != '' ? $group : "-")],
                ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
                ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
                ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
                ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
                [],
                $head

            ];
            } elseif ($session_data['group'] == 'AG' && !empty($session_data['federation'])) {
                $main_head = ['S.No','Analytics/Initial Rating done by', 'SHG Member Name', 'SHG Name', 'Cluster Name','Federation Name'];
                $head = array_merge($main_head, $mainheader);
            return [
            ['Group Type', ($group != '' ? $group : "-")],
            ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
            ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
            ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
            ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
            [],
                $head

            ];
            } elseif ($session_data['group'] == 'FM' && !empty($session_data['federation'])) {
                $main_head = ['S.No','Analytics/Initial Rating done by', 'Family-UIN','SHG Name', 'Cluster Name','Federation Name'];
                $head = array_merge($main_head, $mainheader);
            return [
            ['Group Type', ($group != '' ? $group : "-")],
            ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
            ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
            ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
            ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
            [],
            $head

            ];
            } elseif ($session_data['group'] == 'SH' && !empty($session_data['federation'])) {
                $main_head = ['S.No','Analytics/Initial Rating done by','SHG-UIN','SHG Member Name' ,  'Cluster Name','Federation Name'];
                $head = array_merge($main_head, $mainheader);
            return [
            ['Group Type', ($group != '' ? $group : "-")],
            ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
            ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
            ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
            ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
            [],
                $head

            ];
            } elseif ($session_data['group'] == 'CL' && !empty($session_data['federation'])) {
                $main_head = ['S.No','Analytics/Initial Rating done by', 'Cluster-UIN','SHG Member Name','SHG Name','Federation Name'];
                $head = array_merge($main_head, $mainheader);
            return [
            ['Group Type', ($group != '' ? $group : "-")],
            ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
            ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
            ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
            ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
            [],
                $head];
        } elseif ($session_data['group'] == 'FD' && !empty($session_data['federation'])) {
            $main_head = ['S.No','Analytics/Initial Rating done by','Federation-UIN','SHG Member Name','SHG Name', 'Cluster Name'];
                $head = array_merge($main_head, $mainheader);
            return [
            ['Group Type', ($group != '' ? $group : "-")],
            ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
            ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
            ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
            ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
            [],
                $head

            ];
            } else {
                $main_head = ['S.No','Group Type','UIN','Analytics/Initial Rating done by', 'SHG Member Name', 'SHG Name', 'Cluster Name','Federation Name','Agency'];
                $head = array_merge($main_head, $mainheader);
                return [
                ['Group Type', ($group != '' ? $group : "-")],
                ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
                ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
                ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
                ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
                [],
                $head
            ];
            }
        } else {
            return [
                ['Group Type', ("-")],
                ['Country', ("-")],
                ['State', ("-")],
                ['District', ("-")],
                ['Name', ("-")],
                [],
                ['S.No','Group Type','UIN','Analytics/Initial Rating done by', 'SHG Member Name', 'SHG Name', 'Cluster Name','Federation Name', 'Agency','District', 'State', 'Country','Observations by field faciliators','Agency','Score', 'Verfieid By District Manager', 'Verfieid By DART/ViV staff','Locked']
            ];
        }
    }

    public function title(): string
    {
        $session_data = Session::get('fed_filter_session');
        if (!empty($session_data['group'])) {
            if ($session_data['group'] == 'FM') {
                return 'AnalyticsReport_Family_'.pdf_date().' ';
            } elseif ($session_data['group'] == 'SH') {
                return 'AnalyticsReport_SHG_'.pdf_date().' ';
            } elseif ($session_data['group'] == 'CL') {
                return 'AnalyticsReport_Cluster_'.pdf_date().' ';
            } elseif ($session_data['group'] == 'FD') {
                return 'AnalyticsReport_Federation_'.pdf_date().' ';
            } elseif ($session_data['group'] == 'AG') {
                return 'AnalyticsReport_Agency_'.pdf_date().' ';
            } else {
                return 'AnalyticsReport_'.pdf_date().' ';
            }
        } else {
            return 'AnalyticsReport_'.pdf_date().' ';
        }
        //return 'AnalyticsReport_'.$this->curdate.' ';
    }
}
