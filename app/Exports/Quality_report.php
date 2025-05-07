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


class Quality_report implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
{
    public $curdate = '';
    public $counter = 1;
    public function __construct()
    {

        $this->curdate = Carbon::now()->format('d-m-Y');

    }


    public function collection()
    {

        $user = Auth::User();

        $data['u_type'] = $user->u_type;
        $u_type = $data['u_type'];
        //$u_type='M';
        $data = [];
        $user_geo = DB::table('user_location_relation')
            ->where('user_id', $user->id)
            ->where('is_deleted', '=', 0)
            ->orderBy('country_id')
            ->get()->toArray();


        $query ="SELECT group_concat(users.id) AS ids FROM users where parent_id = $user->id AND  is_deleted = 0";
        if($user->u_type == 'M'){
        $query .=" AND u_type = 'F'";
        }
        elseif ($user->u_type == 'QA'){
            $query .=" AND u_type = 'M'";
        }
        $fac_list = DB::select($query);

        $list  = $fac_list[0]->ids ?? 0;

        $session_data = Session::get('quality_filter_session');
            $session_data = Session::get('quality_filter_session');
            if (!empty($session_data['group']) && !empty($session_data['type'])) {
                $status_type = $session_data['type'];
                if ($session_data['group'] == 'ALL') {
                    if ($user->u_type == 'QA') {

                        $query = "SELECT * FROM (SELECT
                            Y.id,
                            Y.user_id,
                            Y.assignment_type,
                            Y.task,
                            Y.task_a1,
                            Y.qa_status,
                            Y.quality_status,
                            Y.manger_date,
                            Y.quality_date,
                            j.name_of_federation as name,
                            e.name as fac_name,
                            i.uin,
                            i.id AS ids,
                            Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN federation_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN federation_sub_mst AS s
                            ON
                                i.id = s.federation_mst_id
                            INNER JOIN federation_profile AS j
                            ON
                                j.federation_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'FD' AND i.is_deleted=0 ";

                                if ($status_type == 'ALL') {
                                    $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V')  ";
                                }
                                if ($status_type == 'C') {
                                    $query .= " AND (Y.quality_status = 'V' || Y.quality_status = 'R' ) ";
                                }
                                if ($status_type == 'P') {

                                    $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'  ";
                                }
                                if(!empty($session_data['Search'])){
                                   if(!empty($session_data['agency'])){
                                       $agency = $session_data['agency'];
                                       $query .=" AND i.agency_id = $agency  ";
                                    }
                                    if(!empty($session_data['federation'])){
                                       $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                                    }


                                   if(!empty($session_data['dm'])){
                                       $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                                     }
                                     else{
                                       $query .= " AND  verified_by IN($list)";
                                     }
                               }

                        // prd($query);
                        $query .= "    UNION ALL
                            SELECT
                                Y.id,
                                Y.user_id,
                                Y.assignment_type,
                                Y.task,
                                Y.task_a1,
                                Y.qa_status,
                                Y.quality_status,
                                Y.manger_date,
                                Y.quality_date,
                                j.name_of_cluster as name,
                                e.name as fac_name,
                                i.uin,
                                i.id AS ids,
                                Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN cluster_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN cluster_sub_mst AS s
                            ON
                                i.id = s.cluster_mst_id
                            INNER JOIN cluster_profile AS j
                            ON
                                j.cluster_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'CL' AND i.is_deleted=0 ";

                                if ($status_type == 'ALL') {
                                    $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V') ";
                                }
                                if ($status_type == 'C') {
                                    $query .= " AND (Y.quality_status = 'V' || Y.quality_status = 'R' ) ";
                                }
                                if ($status_type == 'P') {

                                    $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P' ";
                                }
                                if(!empty($session_data['Search'])){
                                   if(!empty($session_data['agency'])){
                                       $agency = $session_data['agency'];
                                       $query .=" AND i.agency_id = $agency  ";
                                    }

                                    if(!empty($session_data['cluster'])){
                                       $query .=" AND i.uin = '" . $session_data['cluster'] . "' ";
                                    }


                                if(!empty($session_data['dm'])){
                                       $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                                     }
                                     else{
                                       $query .= " AND  verified_by IN($list)";
                                     }
                                   }
                        $query .= "   UNION ALL
                            SELECT
                                Y.id,
                                Y.user_id,
                                Y.assignment_type,
                                Y.task,
                                Y.task_a1,
                                Y.qa_status,
                                Y.quality_status,
                                Y.manger_date,
                                Y.quality_date,
                                j.shgName as name,
                                e.name as fac_name,
                                i.uin,
                                i.id AS ids,
                                Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN shg_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN shg_sub_mst AS s
                            ON
                                i.id = s.shg_mst_id
                            INNER JOIN shg_profile AS j
                            ON
                                j.shg_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'SH' AND i.is_deleted=0 ";

                                if ($status_type == 'ALL') {
                                    $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V') ";
                                }
                                if ($status_type == 'C') {
                                    $query .= " AND (Y.quality_status = 'V' || Y.quality_status = 'R' ) ";
                                }
                                if ($status_type == 'P') {

                                    $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P' ";
                                }
                                if(!empty($session_data['Search'])){
                                   if(!empty($session_data['agency'])){
                                       $agency = $session_data['agency'];
                                       $query .=" AND i.agency_id = $agency  ";
                                    }

                                    if(!empty($session_data['shg'])){
                                       $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                                    }


                                if(!empty($session_data['dm'])){
                                       $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                                     }
                                     else{
                                       $query .= " AND  verified_by IN($list)";

                                     }
                                   }


                        $query .= " UNION ALL
                                    SELECT
                            a.id ,
                            a.user_id,
                            a.assignment_type,
                            a.task,
                            a.task_a1,
                            a.qa_status,
                            a.quality_status,
                            a.manger_date,
                            a.quality_date,
                            b.fp_member_name as name,
                            c.name as fac_naame,
                            b.uin,
                            b.id AS ids,
                            a.updated_at ";

                        $query .= " FROM
                            (
                            (
                            SELECT
                                id,
                                assignment_id,
                                user_id,
                                task_a1,
                                qa_status,
                                quality_status,
                                task,
                                manger_date,
                                quality_date,assignment_type,
                                updated_at
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM' AND task_a1 = 'P2' AND is_deleted=0 ";


                        if ($status_type == 'ALL') {
                            $query .= " AND qa_status = 'V' AND (quality_status = 'P' OR quality_status = 'R' OR quality_status = 'V') ";
                        }
                        if ($status_type == 'C') {
                            $query .= "   AND (quality_status = 'R' OR quality_status = 'V') ";
                        }
                        if ($status_type == 'P') {

                            $query .= " AND qa_status = 'V' AND(quality_status = 'P' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND verified_by in ($list)";
                             }
                         }

                        $query .= "ORDER BY
                        updated_at
                            DESC

                            ) a";
                        $query .= "    INNER JOIN(
                            SELECT
                            a.id,
                            a.uin,
                            c.fp_member_name,
                            f.shgName,
                            g.agency_name
                            FROM
                            family_mst a
                            INNER JOIN family_sub_mst b ON
                            a.id = b.family_mst_id
                            INNER JOIN family_profile c ON
                            b.id = c.family_sub_mst_id
                            INNER JOIN shg_mst d ON
                            a.shg_uin = d.uin
                            INNER JOIN shg_sub_mst e ON
                            d.id = e.shg_mst_id
                            INNER JOIN shg_profile f ON
                            e.id = f.shg_sub_mst_id
                            INNER JOIN agency g ON
                            a.agency_id = g.agency_id
                            WHERE
                            a.is_deleted = 0 AND b.dm_p1 = 'V' AND b.dm_p2 = 'V' ";

                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND a.agency_id = $agency  ";
                            }
                            if(!empty($session_data['family'])){
                               $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                            }
                         }

                        $query .= " ) b
                            ON
                            a.assignment_id = b.id
                            INNER JOIN users c ON
                            a.user_id = c.id
                            )
                            UNION ALL
                            SELECT
                            a.id ,
                            a.user_id,
                            a.assignment_type,
                            a.task,
                            a.task_a1,
                            a.qa_status,
                            a.quality_status,
                            a.manger_date,
                            a.quality_date,
                            b.fp_member_name as name,
                            c.name fac_name,
                            b.uin,
                            b.id AS ids,
                            a.updated_at
                            FROM
                            (
                            (
                            SELECT
                                id,
                                assignment_id,
                                user_id,
                                task_a1,
                                qa_status,
                                quality_status,
                                task,
                                manger_date,
                                quality_date,
                                assignment_type,
                                updated_at
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM'  AND task = 'R' AND is_deleted=0 ";

                        if ($status_type == 'ALL') {
                            $query .= " AND qa_status = 'V' AND (quality_status = 'P' OR quality_status = 'R' OR quality_status = 'V') ";
                        }
                        if ($status_type == 'C') {
                            $query .= "   AND (quality_status = 'R' OR quality_status = 'V') ";
                        }
                        if ($status_type == 'P') {

                            $query .= " AND qa_status = 'V' AND(quality_status = 'P' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND verified_by in ($list)";
                             }
                         }

                        $query .= "    ORDER BY
                        updated_at
                            DESC

                            ) a
                            INNER JOIN(
                            SELECT
                            a.id,
                            a.uin,
                            c.fp_member_name,
                            f.shgName,
                            g.agency_name
                            FROM
                            family_mst a
                            INNER JOIN family_sub_mst b ON
                            a.id = b.family_mst_id
                            INNER JOIN family_profile c ON
                            b.id = c.family_sub_mst_id
                            INNER JOIN shg_mst d ON
                            a.shg_uin = d.uin
                            INNER JOIN shg_sub_mst e ON
                            d.id = e.shg_mst_id
                            INNER JOIN shg_profile f ON
                            e.id = f.shg_sub_mst_id
                            INNER JOIN agency g ON
                            a.agency_id = g.agency_id
                            WHERE
                            a.is_deleted = 0";


                    if ($status_type == 'ALL') {
                        $query .= "  AND b.dm_r = 'V'  AND (
                             (b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' ) OR(b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' )
                        )";
                    }
                    if ($status_type == 'P') {
                        $query .= " AND b.qa_r = 'P'";
                    }
                    if ($status_type == 'C') {
                        $query .= " AND b.qa_p2 = 'V' AND (b.qa_r = 'V' OR b.qa_r = 'R' )";
                    }
                    if(!empty($session_data['Search'])){
                       if(!empty($session_data['agency'])){
                           $agency = $session_data['agency'];
                           $query .=" AND a.agency_id = $agency  ";
                        }

                        if(!empty($session_data['family'])){
                           $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                        }
                     }
                    $query .= "
                   ) b
                   ON
                   a.assignment_id=b.id INNER JOIN users c on a.user_id=c.id)
                   )a ";

                       //      date_default_timezone_set("Asia/Calcutta");
                       //  prd(date('Y-m-d H:i:s'));

                    } else {
                        $query = " SELECT * FROM (SELECT
                           Y.id ,
                           Y.user_id,
                           Y.dm_id,
                           Y.assignment_type,
                           Y.task,
                           Y.task_a1,
                           Y.qa_status,
                           Y.quality_status,
                           Y.manger_date,
                           Y.quality_date,
                           j.name_of_federation as name,
                           e.name as fac_name,
                           i.uin,
                           i.id AS ids,
                           Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN federation_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN federation_sub_mst AS s
                            ON
                                i.id = s.federation_mst_id
                            INNER JOIN federation_profile AS j
                            ON
                                j.federation_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'FD' AND i.is_deleted=0 ";


                        if ($user->u_type == 'M') {
                            if ($status_type == 'P') {
                                $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V')) ";
                            }
                            if(!empty($session_data['Search'])){
                               if(!empty($session_data['agency'])){
                                   $agency = $session_data['agency'];
                                   $query .=" AND i.agency_id = $agency  ";
                                }
                                if(!empty($session_data['federation'])){
                                   $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                                }

                             }
                             if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }

                           //  $query .= " AND Y.dm_id in ($user->id)";
                        }

                        if ($user->u_type == 'CEO' || $user->u_type == 'A') {
                            if ($status_type == 'ALL') {
                                $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                            }

                            if ($status_type == 'P') {

                                $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                            }
                        }

                        // prd($query);
                        $query .= " UNION ALL
                            SELECT
                                Y.id,
                                Y.user_id,
                                Y.dm_id,
                                Y.assignment_type,
                                Y.task,
                                Y.task_a1,
                                Y.qa_status,
                                Y.quality_status,
                                Y.manger_date,
                                Y.quality_date,
                                j.name_of_cluster as name,
                                e.name as fac_name,
                                i.uin,
                                i.id AS ids,
                                Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN cluster_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN cluster_sub_mst AS s
                            ON
                                i.id = s.cluster_mst_id
                            INNER JOIN cluster_profile AS j
                            ON
                                j.cluster_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'CL' AND i.is_deleted=0 ";


                        if ($user->u_type == 'M') {
                            if ($status_type == 'P') {
                                $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                            }
                            if(!empty($session_data['Search'])){
                               if(!empty($session_data['agency'])){
                                   $agency = $session_data['agency'];
                                   $query .=" AND i.agency_id = $agency  ";
                                }
                                if(!empty($session_data['cluster'])){
                                   $query .=" AND i.uin = '" . $session_data['cluster'] . "' ";
                                }

                             }
                             if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                           // $query .= " AND Y.dm_id in ($user->id)";

                        }

                        if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                            }
                            if ($status_type == 'P') {
                                $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                            }
                        }
                        // prd($query);
                        $query .= "UNION ALL
                            SELECT
                                Y.id ,
                                Y.user_id,
                                Y.dm_id,
                                Y.assignment_type,
                                Y.task,
                                Y.task_a1,
                                Y.qa_status,
                                Y.quality_status,
                                Y.manger_date,
                                Y.quality_date,
                                j.shgName as name,
                                e.name fac_name,
                                i.uin,
                                i.id AS ids,
                                Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN shg_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN shg_sub_mst AS s
                            ON
                                i.id = s.shg_mst_id
                            INNER JOIN shg_profile AS j
                            ON
                                j.shg_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'SH' AND i.is_deleted=0 ";


                        if ($user->u_type == 'M') {
                            if ($status_type == 'P') {
                                $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                            }
                            if(!empty($session_data['Search'])){
                               if(!empty($session_data['agency'])){
                                   $agency = $session_data['agency'];
                                   $query .=" AND i.agency_id = $agency  ";
                                }
                                if(!empty($session_data['shg'])){
                                   $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                                }

                             }
                             if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                           //  $query .= " AND Y.dm_id in ($user->id)";

                        }

                        if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                            }
                            if ($status_type == 'P') {
                                $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                            }
                        }

                        $query .= " UNION ALL
                                SELECT
                                    Y.id ,
                                    Y.user_id,
                                    Y.dm_id,
                                    Y.assignment_type,
                                    Y.task,
                                    Y.task_a1,
                                    Y.qa_status,
                                    Y.quality_status,
                                    Y.manger_date,
                                    Y.quality_date,
                                    j.fp_member_name as name,
                                    e.name as fac_name,
                                    i.uin,
                                    i.id AS ids,
                                    Y.updated_at
                            FROM
                                task_qa_assignment AS Y
                            INNER JOIN family_mst AS i
                            ON
                                i.id = Y.assignment_id
                            INNER JOIN family_sub_mst AS s
                            ON
                                i.id = s.family_mst_id
                            INNER JOIN family_profile AS j
                            ON
                                j.family_sub_mst_id = s.id
                            INNER JOIN agency AS d
                            ON
                                i.agency_id = d.agency_id
                            INNER JOIN users AS e
                            ON
                                Y.user_id = e.id
                            WHERE
                                Y.is_deleted = 0 AND Y.assignment_type = 'FM' AND i.is_deleted=0 ";


                        if ($user->u_type == 'M') {
                            if ($status_type == 'P') {
                                $query .= " AND (Y.qa_status = 'P' OR (Y.quality_status = 'R' AND Y.qa_status = 'V'))";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                            }
                            if(!empty($session_data['Search'])){
                               if(!empty($session_data['agency'])){
                                   $agency = $session_data['agency'];
                                   $query .=" AND i.agency_id = $agency  ";
                                }
                                if(!empty($session_data['family'])){
                                   $query .=" AND i.uin = '" . $session_data['family'] . "' ";
                                }
                             }
                             if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                           //  $query .= " AND Y.dm_id in ($user->id)";

                        }

                        if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                            }
                            if ($status_type == 'P') {
                                $query .= " AND Y.qa_status = 'P' AND Y.quality_status = 'P' ";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                            }
                        }
                        // prd($query);
                        $query .= ")a ORDER BY a.updated_at DESC ";
                    }
                }
                if ($session_data['group'] == 'FM') {
                    if ($user->u_type == 'QA') {

                        $query = "
                       SELECT
                           *
                       FROM
                           (
                           SELECT
                               a.id,
                               a.user_id,
                               a.task_a1,
                               a.assignment_type,
                               a.qa_status,
                               a.quality_status,
                               a.task,
                               a.manger_date,
                               a.quality_date,
                               b.id AS ids,
                               b.uin,
                               b.fp_member_name AS name,
                               b.shgName,
                               b.agency_name,
                               c.name as fac_name,
                               a.updated_at
                           FROM
                            (
                                (
                                SELECT
                                    id,
                                    assignment_id,
                                    assignment_type,
                                    user_id,
                                    task_a1,
                                    qa_status,
                                    quality_status,
                                    task,
                                    manger_date,
                                    quality_date,
                                    updated_at
                                FROM
                                    task_qa_assignment
                                WHERE
                                    assignment_type = 'FM' AND task_a1 = 'P2' AND is_deleted=0 ";
                        if ($status_type == 'ALL') {
                            $query .= " AND qa_status = 'V' AND(quality_status = 'R' OR quality_status = 'P' OR quality_status = 'V' ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND qa_status = 'V' AND quality_status = 'P' ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND qa_status = 'V' AND(quality_status = 'R'  OR quality_status = 'V' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND verified_by in ($list)";
                             }
                         }

                        $query .= "
                                ORDER BY
                                    id
                                DESC
                            ) a
                        INNER JOIN(
                            SELECT
                                a.id,
                                a.uin,
                                c.fp_member_name,
                                f.shgName,
                                g.agency_name
                            FROM
                                family_mst a
                            INNER JOIN family_sub_mst b ON
                                a.id = b.family_mst_id
                            INNER JOIN family_profile c ON
                                b.id = c.family_sub_mst_id
                            INNER JOIN shg_mst d ON
                                a.shg_uin = d.uin
                            INNER JOIN shg_sub_mst e ON
                                d.id = e.shg_mst_id
                            INNER JOIN shg_profile f ON
                                e.id = f.shg_sub_mst_id
                            LEFT JOIN cluster_mst AS cl ON
                                cl.uin = a.cluster_uin
                            INNER JOIN federation_mst AS fd ON
                              fd.uin = a.federation_uin
                            INNER JOIN agency g ON
                                a.agency_id = g.agency_id
                            WHERE
                                a.is_deleted = 0";



                        if ($status_type == 'ALL') {
                            $query .= " AND  b.dm_p1 = 'V' AND b.dm_p2 = 'V' AND(
                                    (  b.qa_p2 = 'P' OR b.qa_p2 = 'R' OR b.qa_p2 = 'V' OR b.qa_r = 'V' OR b.qa_r = 'V'  )
                                )
                                ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND  b.dm_p1 = 'V' AND b.dm_p2 = 'V' AND  b.qa_p2 = 'P' ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND  b.dm_p1 = 'V' AND b.dm_p2 = 'V' AND  (b.qa_p2 = 'V' OR b.qa_p2 = 'R') ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND a.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND cl.uin = '" . $session_data['cluster'] . "' ";
                            }
                            if(!empty($session_data['shg'])){
                               $query .=" AND d.uin = '" . $session_data['shg'] . "' ";
                            }
                            if(!empty($session_data['family'])){
                               $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                            }
                         }
                        $query .= "
                        ) b
                       ON
                           a.assignment_id = b.id
                       INNER JOIN users c ON
                           a.user_id = c.id
                               )
                           UNION ALL
                       SELECT
                           a.id,
                           a.user_id,
                           a.task_a1,
                           a.assignment_type,
                           a.qa_status,
                           a.quality_status,
                           a.task,
                           a.manger_date,
                           a.quality_date,
                           b.id AS ids,
                           b.uin,
                           b.fp_member_name AS name,
                           b.shgName,
                           b.agency_name,
                           c.name as fac_name,
                           a.updated_at
                       FROM
                        (
                            (
                            SELECT
                                id,
                                assignment_id,
                                assignment_type,
                                user_id,
                                task_a1,
                                qa_status,
                                quality_status,
                                task,
                                manger_date,
                                quality_date,
                                updated_at
                            FROM
                                task_qa_assignment
                            WHERE
                                assignment_type = 'FM' AND task = 'R' AND is_deleted=0 ";


                        if ($status_type == 'ALL') {
                            $query .= "    AND qa_status = 'V'  AND(quality_status = 'R' OR quality_status = 'P' OR quality_status = 'V' ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= "    AND qa_status = 'V' AND quality_status = 'P' ";
                        }
                        if ($status_type == 'C') {
                            $query .= "    AND qa_status = 'V'  AND(quality_status = 'R'  OR quality_status = 'V' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND verified_by in ($list)";
                             }
                         }
                        $query .= "
                            ORDER BY
                                id
                            DESC
                        ) a
                       INNER JOIN(
                           SELECT
                               a.id,
                               a.uin,
                               c.fp_member_name,
                               f.shgName,
                               g.agency_name
                           FROM
                               family_mst a
                           INNER JOIN family_sub_mst b ON
                               a.id = b.family_mst_id
                           INNER JOIN family_profile c ON
                               b.id = c.family_sub_mst_id
                           INNER JOIN shg_mst d ON
                               a.shg_uin = d.uin
                           INNER JOIN shg_sub_mst e ON
                               d.id = e.shg_mst_id
                           INNER JOIN shg_profile f ON
                               e.id = f.shg_sub_mst_id
                           LEFT JOIN cluster_mst AS cl ON
                                cl.uin = a.cluster_uin
                           INNER JOIN federation_mst AS fd ON
                              fd.uin = a.federation_uin
                           INNER JOIN agency g ON
                               a.agency_id = g.agency_id
                           WHERE
                               a.is_deleted = 0 ";


                        if ($status_type == 'ALL') {
                            $query .= " AND b.qa_p2 = 'V'  AND (
                                 (b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' ) OR(b.qa_r = 'R' AND b.qa_r = 'V' AND b.qa_r = 'P' )
                            )";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND b.qa_p2 = 'V'  AND b.qa_r = 'P'";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND b.qa_p2 = 'V' AND (b.qa_r = 'V' OR b.qa_r = 'R' )";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND a.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND cl.uin = '" . $session_data['cluster'] . "' ";
                            }
                            if(!empty($session_data['shg'])){
                               $query .=" AND d.uin = '" . $session_data['shg'] . "' ";
                            }
                            if(!empty($session_data['family'])){
                               $query .=" AND a.uin = '" . $session_data['family'] . "' ";
                            }
                         }
                        $query .= "
                       ) b
                       ON
                       a.assignment_id=b.id INNER JOIN users c on a.user_id=c.id)
                       )a ";

                    } else {
                        $query = "SELECT
                        Y.*,
                        d.agency_name,
                        j.shgName,
                        e.name as fac_name,
                        k.uin,
                        l.fp_member_name as name,
                        k.id AS ids
                    FROM
                        task_qa_assignment AS Y
                    INNER JOIN family_mst AS k
                    ON
                        k.id = Y.assignment_id
                    INNER JOIN family_sub_mst AS z
                    ON
                        z.family_mst_id = k.id
                    INNER JOIN family_profile AS l
                    ON
                        l.family_sub_mst_id = z.id
                    INNER JOIN shg_mst AS i
                    ON
                        i.uin = k.shg_uin
                    INNER JOIN shg_sub_mst AS ii
                    ON
                        i.id = ii.shg_mst_id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = ii.id

                   LEFT JOIN cluster_mst AS c
                    ON
                        c.uin = k.cluster_uin


                   INNER JOIN federation_mst AS fd
                    ON
                        fd.uin = k.federation_uin


                    INNER JOIN agency AS d
                    ON
                        k.agency_id = d.agency_id
                    INNER JOIN users AS e
                    ON
                        Y.user_id = e.id
                    WHERE
                        Y.is_deleted = 0 AND Y.assignment_type = 'FM' AND k.is_deleted=0 ";

                        if ($user->u_type == 'M') {
                            if ($status_type == 'C') {
                                $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                            }
                            if ($status_type == 'P') {
                                $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                            }
                            if(!empty($session_data['Search'])){
                               if(!empty($session_data['agency'])){
                                   $agency = $session_data['agency'];
                                   $query .=" AND k.agency_id = $agency  ";
                                }
                                if(!empty($session_data['federation'])){
                                   $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                                }
                                if(!empty($session_data['cluster'])){
                                   $query .=" AND c.uin = '" . $session_data['cluster'] . "' ";
                                }
                                if(!empty($session_data['shg'])){
                                   $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                                }
                                if(!empty($session_data['family'])){
                                   $query .=" AND k.uin = '" . $session_data['family'] . "' ";
                                }
                             }
                            if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                           //  $query .= " AND Y.dm_id in ($user->id)";

                        }

                        if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                                $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                            }
                            if ($status_type == 'P') {
                                $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                            }
                            if ($status_type == 'C') {
                                $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R') AND (Y.quality_status = 'V' OR Y.quality_status = 'R')";
                            }
                        }
                        $query .= " ORDER BY
                        Y.updated_at
                    DESC ";
                    }
                }
                if ($session_data['group'] == 'SH') {
                    $query = "SELECT
                        Y.*,
                        d.agency_name,
                        j.shgName as name,
                        e.name as fac_name,
                        i.uin,
                        l.name_of_cluster ,
                        i.id AS ids
                    FROM
                        task_qa_assignment AS Y
                    INNER JOIN shg_mst AS i
                    ON
                        i.id = Y.assignment_id
                    INNER JOIN shg_sub_mst AS s
                    ON
                        s.shg_mst_id = i.id
                    INNER JOIN shg_profile AS j
                    ON
                        j.shg_sub_mst_id = s.id
                    LEFT JOIN cluster_mst AS k
                    ON
                        k.uin = i.cluster_uin
                    LEFT JOIN cluster_sub_mst AS m
                    ON
                        k.id = m.cluster_mst_id
                    LEFT JOIN cluster_profile AS l
                    ON
                        l.cluster_sub_mst_id = m.id
                   LEFT JOIN federation_mst AS fd
                    ON
                        fd.uin = i.federation_uin
                    LEFT JOIN federation_sub_mst AS fed
                    ON
                        fd.id = fed.federation_mst_id
                    INNER JOIN agency AS d
                    ON
                        i.agency_id = d.agency_id
                    INNER JOIN users AS e
                    ON
                        Y.user_id = e.id
                    WHERE
                        Y.is_deleted = 0 AND Y.assignment_type = 'SH' AND i.is_deleted=0 ";

                    if ($user->u_type == 'M') {
                        if ($status_type == 'C') {
                            $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                        }
                        if ($status_type == 'P') {
                            $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND i.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                            }
                            if(!empty($session_data['shg'])){
                               $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                            }


                        if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                           }
                       //  $query .= " AND Y.dm_id in ($user->id)";

                    }
                    if ($user->u_type == 'QA') {
                        if ($status_type == 'ALL') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V' ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'V' OR Y.quality_status = 'R')  ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND i.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND fd.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                            }
                            if(!empty($session_data['shg'])){
                               $query .=" AND i.uin = '" . $session_data['shg'] . "' ";
                            }


                        if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND  verified_by IN($list)";

                             }
                           }

                    }
                    if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                            $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R') AND (Y.quality_status = 'V' OR Y.quality_status = 'R')";
                        }
                    }
                    $query .= " ORDER BY
                        Y.updated_at
                    DESC ";
                }
                if ($session_data['group'] == 'CL') {
                    $query = "SELECT
                    Y.*,
                    d.agency_name,
                    j.name_of_federation,
                    e.name as fac_name,
                    k.uin,
                    l.name_of_cluster as name,
                    k.id AS ids
                    FROM
                        task_qa_assignment AS Y
                    INNER JOIN cluster_mst AS k
                    ON
                        k.id = Y.assignment_id
                    INNER JOIN cluster_sub_mst AS m
                    ON
                        k.id = m.cluster_mst_id
                    INNER JOIN cluster_profile AS l
                    ON
                        l.cluster_sub_mst_id = m.id
                    INNER JOIN federation_mst AS i
                    ON
                        i.uin = k.federation_uin
                    INNER JOIN federation_sub_mst AS sb
                    ON
                        sb.federation_mst_id = i.id
                    left  JOIN federation_profile AS j
                    ON
                        j.federation_sub_mst_id = sb.federation_mst_id
                    INNER JOIN agency AS d
                    ON
                        k.agency_id = d.agency_id
                    INNER JOIN users AS e
                    ON
                        Y.user_id = e.id
                    WHERE
                        Y.is_deleted = 0 AND assignment_type = 'CL' AND k.is_deleted=0 ";


                    if ($user->u_type == 'M') {
                        if ($status_type == 'C') {
                            $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                        }
                        if ($status_type == 'P') {
                            $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND k.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                            }


                           if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                       }
                       //  $query .= " AND Y.dm_id in ($user->id)";

                    }
                    if ($user->u_type == 'QA') {
                        if ($status_type == 'ALL') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V' ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'  ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'V' OR Y.quality_status = 'R')  ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND k.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                            }
                            if(!empty($session_data['cluster'])){
                               $query .=" AND k.uin = '" . $session_data['cluster'] . "' ";
                            }


                        if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND  verified_by IN($list)";
                             }
                           }

                    }
                    if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                            $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R') AND (Y.quality_status = 'V' OR Y.quality_status = 'R')";
                        }
                    }
                    $query .= " ORDER BY
                        Y.updated_at
                    DESC ";
                }
                if ($session_data['group'] == 'FD') {
                    $query = " SELECT
                            Y.*,
                            d.agency_name,
                            d.agency_id,
                            j.name_of_federation as name,
                            e.name as fac_name,
                            i.uin,
                            i.id AS ids
                        FROM
                            task_qa_assignment AS Y
                        INNER JOIN federation_mst AS i
                        ON
                            i.id = Y.assignment_id
                        INNER JOIN federation_sub_mst AS s
                        ON
                            i.id = s.federation_mst_id
                        INNER JOIN federation_profile AS j
                        ON
                            j.federation_sub_mst_id = s.id
                        INNER JOIN agency AS d
                        ON
                            i.agency_id = d.agency_id
                        INNER JOIN users AS e
                        ON
                            Y.user_id = e.id
                        WHERE
                            Y.is_deleted = 0 AND Y.assignment_type = 'FD' AND i.is_deleted=0 ";


                    if ($user->u_type == 'M') {
                        if ($status_type == 'C') {
                            $query .= " AND ((Y.qa_status = 'R' AND Y.quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'P' ) OR (Y.qa_status = 'R' AND Y.quality_status = 'R') OR (Y.qa_status = 'V' AND Y.quality_status = 'V'))   ";
                        }
                        if ($status_type == 'P') {
                            $query .= "  AND (Y.qa_status = 'P' OR Y.quality_status = 'R' ) ";
                        }
                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND i.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                            }


                           if(!empty($session_data['facilitator'])){
                               $query .= " AND Y.user_id = '" . $session_data['facilitator'] . "'";
                             }
                             else{
                               $query .= " AND Y.user_id in ($list)";
                             }
                       }
                       //  $query .= " AND Y.dm_id in ($user->id)";

                    }
                    if ($user->u_type == 'QA') {
                        if ($status_type == 'ALL') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'P' OR Y.quality_status = 'R' OR Y.quality_status = 'V' ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'  ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND Y.qa_status = 'V' AND (Y.quality_status = 'V' OR Y.quality_status = 'R')  ";
                        }


                        if(!empty($session_data['Search'])){
                           if(!empty($session_data['agency'])){
                               $agency = $session_data['agency'];
                               $query .=" AND i.agency_id = $agency  ";
                            }
                            if(!empty($session_data['federation'])){
                               $query .=" AND i.uin = '" . $session_data['federation'] . "' ";
                            }


                           if(!empty($session_data['dm'])){
                               $query .= " AND verified_by = '" . $session_data['dm'] . "'";
                             }
                             else{
                               $query .= " AND  verified_by IN($list)";
                             }
                       }
                       //  $query .= " AND Y.dm_id in ($user->id)";

                    }
                    if ($user->u_type == 'CEO' || $user->u_type == 'A') { {
                            $query .= " AND ((Y.qa_status = 'P' OR quality_status = 'P') OR (Y.qa_status = 'V' AND Y.quality_status = 'V') OR (Y.qa_status = 'R' AND Y.quality_status = 'R') ) ";
                        }
                        if ($status_type == 'P') {
                            $query .= " AND Y.qa_status = 'V' AND Y.quality_status = 'P'   ";
                        }
                        if ($status_type == 'C') {
                            $query .= " AND (Y.qa_status = 'V' OR Y.qa_status = 'R' OR Y.quality_status = 'V' OR Y.quality_status = 'R')";
                        }
                    }
                    $query .= " ORDER BY
                        Y.updated_at
                    DESC ";
                }

                if( $session_data['group'] == 'FM' || $session_data['group'] == 'ALL'){
                   if($user->u_type == 'QA'){
                   $query .=" ORDER BY  a.updated_at DESC ";

                   }
                }
                $families = DB::select($query);

            }
            else{
                $families ='';
            }
                return collect($families);


    }

    public function map($res): array
    {
        $user = Auth::User();
        if ($res !='') {
            if ($res->qa_status == 'P') {
                $qa_status = 'Pending';
            }
            if ($res->qa_status == 'V') {
                $qa_status = 'Verified';
            }
            if ($res->qa_status == 'R') {
                $qa_status = 'Rejected';
            }

            if ($res->quality_status == 'P') {
                $quality_status = 'Pending';
            }
            if ($res->quality_status == 'V') {
                $quality_status = 'Verified';
            }
            if ($res->quality_status == 'R') {
                $quality_status = 'Rejected';
            }

            if ($res->task == 'A') {
                $task = 'Analysis';
            } else {
                $task = 'Rating';
            }

            if ($res->assignment_type == 'FD') {
                $type = 'Federation';
            }
            if ($res->assignment_type == 'SH') {
                $type = 'SHG';
            }
            if ($res->assignment_type == 'CL') {
                $type = 'Cluster';
            }
            if ($res->assignment_type == 'FM') {
                $type = 'Family';
            }
            $part = '';
            if ($res->assignment_type == 'FM'  && $user->u_type !='QA') {
                if ($res->task == 'A') {
                    $part = ' - ' . $res->task_a1;
                }
            } else {
                $part = '';
            }
            $manager_date = change_date_month_name_char($res->manger_date);
            $quality_date = change_date_month_name_char($res->quality_date);
            return [

            $this->counter++,
            $res->uin,
            $res->name,
            $type,
            $res->fac_name,
            $task.$part,
            $qa_status,
            $manager_date,
            $quality_status,
            $quality_date,

        ];
        }
        else{
            return [
            ];
        }





    }


    public function columnFormats(): array
    {
        return [

        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:A2')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'color' => ['argb' => '#CCCCCC' ]
                    ]
                ]);

                $event->sheet->getStyle('A4:K4')->applyFromArray([
                    'font' => ['bold' => true]
                ]);

            },
        ];
    }

    public function headings(): array
    {
        $group = '';

        $session_data = Session::get('quality_filter_session');

        $group_type = '';
        $type = '';
        if (!empty($session_data)) {
            if ($session_data['group'] == 'FM') {
                $group_type = 'Family';
            }
            if ($session_data['group'] == 'FD') {
                $group_type = 'Federation';
            }
            if ($session_data['group'] == 'CL') {
                $group_type = 'Cluster';
            }
            if ($session_data['group'] == 'SH') {
                $group_type = 'SHG';
            }
            if ($session_data['group'] == 'ALL') {
                $group_type = 'ALL';
            }

            if ($session_data['type'] == 'P') {
                $type = 'Pending';
            }
            if ($session_data['type'] == 'C') {
                $type = 'Complete';
            }
            if ($session_data['type'] == 'ALL') {
                $type = 'ALL';
            }
            // if (!empty($session_data['agency']) ) {
            //     $agency = $session_data['agency'];
            // }else{
            //     $agency = '';
            // }
            // if (!empty($session_data['federation']) ) {
            //     $federation = $session_data['federation'];
            // }else{
            //     $federation = '';
            // }
            // if (!empty($session_data['cluster']) ) {
            //     $cluster = $session_data['cluster'];
            // }else{
            //     $cluster = '';
            // }
            // if (!empty($session_data['shg']) ) {
            //     $shg = $session_data['shg'];
            // }else{
            //     $shg = '';
            // }
            // if (!empty($session_data['family']) ) {
            //     $family = $session_data['family'];
            // }else{
            //     $family = '';
            // }
            // if (!empty($session_data['facilitator']) ) {
            //     $facilitator = $session_data['facilitator'];
            // }else{
            //     $facilitator = '';
            // }
        }
            return [
                ['Group Type',$group_type],
                ['Status',$type],


                [],
                ['S.No','UIN','Name','Type',' Facilitator','Task','Manager Status','Manager Update','Quality Status','Quality Update']
            ];


    }

    public function title(): string
    {
        return 'Quality_report'.pdf_date().' ';
    }
}
