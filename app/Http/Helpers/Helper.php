<?php

use App\Models\HistoryModel;
use App\Models\Notification;
use App\Models\Logindetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Mail as MA;
use App\Mail\DartMail;
use App\Mail\DartOtp;
use Illuminate\Support\Facades\Http;


function can($controller = NULL, $action = NULL)
{
    if (($controller == '') || ($action == ''))
        return 0;
    $user = Auth::user();
    $result = DB::table('user_role_permissions')
        ->select('*')

        ->where('role_id', $user->role_id)
        ->where('controller', '=', $controller)
        ->where('action', '=', $action)
        ->get()->toArray();
    if (empty($result))
        return 0;
    return 1;
}

function getUserById($userId = NULL)
{
    $result = DB::table('users')
        ->where('id', '=', $userId)
        ->where('is_deleted', '=', 0)
        ->get()->toArray();
    return $result;
}

function getAgencyuin($agencyid = NULL)
{
    $result = DB::table('agency')
        ->select('agency_id')
        ->where('id', '=', $agencyid)
        ->where('is_deleted', '=', 0)
        ->get()->toArray();
    //prd($result);
    return $result;
}

function has_access()
{
    $route = Route::currentRouteAction();

    list($controller, $action) = explode('@', $route);
    $controller = strtolower(preg_replace('/.*\\\/', '', $controller));
    $action = strtolower($action);
    $user = Auth::user();
    // prd("kk");
    // $partner_id = (isset($user->partner_id) && ($user->partner_id > 0)) ? $user->partner_id : '0';

    $result = DB::table('user_role_permissions as a')
        ->leftJoin('users as b', 'a.role_type', 'b.u_type')
        ->select(DB::raw('count(*) as total'))
        ->where('b.id', $user->id)
        ->where('a.controller', $controller)
        // ->where('a.partner_id', $partner_id)
        ->where('a.role_type', $user->u_type);
    if ($action != 'store') {
        $result->where('a.action', $action);
    }

    $data = $result->get()->toArray();
    // prd($data);
    if (!empty($data)) {

        return $data[0]->total;
    }
    return 0;
}

/*function to get topmost role of user*/
function get_user_role($user_id = NULL)
{
    if (!($user_id > 0))
        $user = Auth::user();
    $result = DB::table('user_roles as a')
        ->select('a.role_id as toprole')
        ->groupBy('a.user_id')
        ->where('a.user_id', '=', $user->id)
        ->where('a.is_deleted', '=', 0)
        ->get()->toArray();
    if (!empty($result))
        return $result[0]->toprole;
}

function get_roles($login = 0)
{
    $roles = DB::table('mst_roles as a')
        ->where('a.is_deleted', '=', 0);
    if ($login) {
        $roles->where('a.role_id', '>', 1);
    }

    return $roles->get()->toArray();
}

function change_date_format($date)
{
    if ($date != '')
        return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    return NULL;
}

function change_date_format_with_time($date)
{
    if ($date != '')
        return Carbon::createFromFormat('d/m/Y H:i:s', $date)->format('Y-m-d H:i:s');
    return NULL;
}

function change_date_format_display($date)
{
    if ($date != '')
        return date('d/m/Y', strtotime($date));
    return '';
}

function change_date_format_display_hy($date)
{
    if ($date != '')
        return date('d-m-Y', strtotime($date));
    return '';
}

function change_date_format_display_with_time($date)
{
    if ($date != '')
        return date('d/m/Y H:i:s', strtotime($date));
    return '';
}



function get($table = NULL, $column = NULL, $where = [])
{
    list($key, $value) = $where;
    $res = DB::table($table)
        ->select($column)
        ->where($key, '=', $value)
        ->limit(1)
        ->get()->toArray();
    if (!empty($res)) {
        return $res[0]->$column;
    }
}

function getCount($table = NULL)
{
    $res = DB::table($table)
        ->select("*")
        ->where('is_deleted', '=', 0)
        ->where('status', '=', 'A')
        ->limit(1)
        ->count();
    // prd($res);
    return $res;
}


function encypt($filename = '')
{
    if ($filename != '') {
        $file = pathinfo($filename, PATHINFO_FILENAME);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return md5($file . date('ymdhis')) . '.' . $ext;
    }
    return '';
}

function pr($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function prd($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}

function get_current_url()
{
    //return $url = \Request::fullUrl();
    return url()->current();
}

function get_previous_url()
{
    //return $url = \Request::fullUrl();
    $previous_url = url()->previous();
    $url = strtok($previous_url, '?');
    return $url;
}


function export_excel($filename, $header, $data)
{
    $header = [];
    $file_ending = "xls";
    $schema_insert = "";
    /*******header info for browser*******/
    //    header('Content-Type: text/html; charset =utf-8');
    header("Content-Type: application/xls;charset=UTF-8");
    header("Content-Disposition: attachment; filename=$filename.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    $sep = "\t"; //tabbed character
    //start of printing column names as names of MySQL fields
    if (!empty($header)) {
        foreach ($header as $header => $row) {
            echo $header . "\t";
        }
    }
    print("\r\n");
    //end of printing column names
    //start loop to get data
    if (count($data) > 0) {
        foreach ($data as $header => $ut_details) {
            $schema_insert = '';
            foreach ($ut_details as $row) {
                /*if(!isset($ut_details[$j]))
                    $schema_insert .= "NULL".$sep;*/
                //elseif ($row[$j] != "")
                $schema_insert .= $row . $sep;
                /*else
                    $schema_insert .= "".$sep;*/
            }
            $schema_insert = str_replace($sep . "$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert) . "\r\n");
        }
    }
    exit();
}

function curRequestPost($url, $params = [])
{
    $str_json = json_encode($params);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $str_json,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Cookie: jsessionid=66ab8f3e-c866-417c-95e2-a822017b42fd'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function randomNumber($table, $column)
{

    $rand = mt_rand(100000000, 999999999);
    $query = "select * from " . $table . " where " . $column . " = " . $rand . "";
    $result = DB::select($query);
    //prd($query);
    if (count($result) > 0) {
        randomNumber($table, $column);
    } else {
        return $rand;
    }
}

function getName($table = NULL, $column = NULL, $where = NULL)
{

    $res = DB::table($table)
        ->select($column)
        ->where('id', '=',  $where)
        ->get()->toArray();
    if (!empty($res)) {
        return $res[0]->$column;
    }
}
function change_date_monthName($orgDate)
{
    if ($orgDate != '') {
        $date = str_replace('/', '-', $orgDate);
        $newDate = date("d/M/Y", strtotime($date));
        return $newDate;
    }

    return NULL;
}
function change_monthName_to_date($orgDate)
{
    if ($orgDate != '') {
        $date = str_replace('/', '-', $orgDate);
        $newDate = date("d/m/Y", strtotime($date));
        return $newDate;
    }

    return NULL;
}

function getCountryByID($id)
{
    if ($id != '') {
        $res = DB::table('countries')
            ->select('id', 'name')
            ->where('id', '=',  $id)
            ->where('is_deleted', '=',  0)
            ->get()->toArray();
        if (!empty($res)) {
            return $res[0]->name;
        }
    }
}

function getStateName($country_id, $state_id)
{
    if ($country_id != '' && $state_id != '') {
        $res = DB::table('states')
            ->select('id', 'name')
            ->where('country_id', '=',  $country_id)
            ->where('id', '=',  $state_id)
            ->where('is_deleted', '=',  0)
            ->get()->toArray();
        if (!empty($res)) {
            return $res[0]->name;
        }
    }
}

function getDistrictName($state_id, $district_id)
{
    if ($district_id != '' && $state_id != '') {
        $res = DB::table('district')
            ->select('id', 'name')
            ->where('state_id', '=',  $state_id)
            ->where('id', '=',  $district_id)
            ->where('is_deleted', '=',  0)
            ->get()->toArray();
        if (!empty($res)) {
            return $res[0]->name;
        }
    }
}

function getCountryCodeByID($id)
{
    if ($id != '') {
        $res = DB::table('countries')
            ->select('sortname')
            ->where('id', '=',  $id)
            ->where('is_deleted', '=',  0)
            ->get()->toArray();
        if (!empty($res)) {
            return $res[0]->sortname;
        }
    }
}

function getStateCodeByID($id)
{
    if ($id != '') {
        $res = DB::table('states')
            ->select('abbr')
            ->where('id', '=',  $id)
            ->where('is_deleted', '=',  0)
            ->get()->toArray();
        if (!empty($res)) {
            return $res[0]->abbr;
        }
    }
}

function getUIN($table = NULL, $column = NULL)
{
    $query = "SELECT $column FROM $table ORDER BY ID DESC LIMIT 1";
    $res = DB::select($query);

    if (!empty($res)) {
        return $res[0]->$column;
    }
}
function checkAndGenerateUIN($country_code, $state_code, $district_code, $table, $type)
{
    $country_code = $country_code;
    $state_code = $state_code;
    $district_code = $district_code;
    $table = $table;
    $type = $type;
    $todaydate = date('dmY');

    if ($table = 'federation_mst') {
        $l_uin = rand(1111111, 2222221);
    }
    if ($table = 'cluster_mst') {
        $l_uin = rand(2222222, 3333332);
    }
    if ($table = 'shg_mst') {
        $l_uin = rand(3333333, 4444443);
    }
    if ($table = 'family_mst') {
        $l_uin = rand(44444444, 99999999);
    }

    $uin = $country_code . $state_code . $district_code . $todaydate . $type . $l_uin;

    $query = "SELECT uin FROM $table where uin = '.$uin.' ";
    $result = DB::select($query);
    if (count($result) > 0) {
        checkAndGenerateUIN($country_code, $state_code, $district_code, $table, $type);
    } else {
        return $uin;
    }
}

function qa_historyData($asgtkn, $assignment_id, $assignment_type, $task, $task_a1, $qastatus, $remark)
{
    $user = Auth::user();
    $historyData = new HistoryModel;
    $historyData->created_by = $user->id;
    $historyData->asgtkn = $asgtkn;
    $historyData->assignment_id = $assignment_id;
    $historyData->assignment_type = $assignment_type;
    $historyData->task = $task;
    $historyData->task_a1 = $task_a1;
    $historyData->status = $qastatus;
    $historyData->remark = $remark;
    $historyData->save();
}


function nice_number($n)
{


    $n = (0 + str_replace(",", "", $n));

    if (!is_numeric($n)) return false;

    $format = round($n / 1000000, 2) . 'M';


    // now filter it;
    // if ($n > 1000000000000) return round(($n/1000000000000), 2).' trillion';
    // elseif ($n > 1000000000) return round(($n/1000000000), 2).' billion';
    // elseif ($n > 1000000) return round(($n/1000000), 2).' million';
    // elseif ($n > 1000) return round(($n/1000), 2).' thousand';

    return $format;
}

function generated_date()
{
    $abc = date("F jS Y");
    $ddd = ',';
    $def = trim(substr_replace($abc, $ddd, -5, 0));
    return $def;
}

function change_date_month_name_char($date)
{
    //prd($date);
    if ($date != '') {
        $abc = date("M jS Y", strtotime($date));
        $ddd = ',';
        $def = substr_replace($abc, $ddd, -5, 0);
        return $def;
    } else {
        return '---';
    }
}
function pdf_date()
{
    $abc = date("M jS Y");
    $ddd = ',';
    $def = trim(substr_replace($abc, $ddd, -5, 0));
    return $def;
}

function assignToken()
{
    $rand = substr(md5(mt_rand()), 0, 20);
    $asgtkn = $rand;
    $query = "select * from task_assignment where asgtkn = '" . $rand . "' ";
    $result = DB::select($query);
    //prd($query);
    if (count($result) > 0) {
        assignToken();
    } else {
        return $asgtkn;
    }
}
function notification($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save)
{

    $fnotification = new Notification();
    $fnotification->asgtkn = $asgtkn;
    $fnotification->assignment_id = $mst_id;
    $fnotification->assignment_type = $assignment_type;
    $fnotification->task = $task;
    $fnotification->task_a1 = $task_a1;
    $fnotification->notification_to = $manager_id;
    $fnotification->notification_from = $user_id;
    $fnotification->message = $message_save;
    $fnotification->notification_date = date('Y-m-d H:i:s');
    $fnotification->created_by = $user_id;
    $fnotification->created_at = date('Y-m-d H:i:s');
    //prd($fnotification);
    DB::enableQueryLog();
    $fnotification->save();
    $query = DB::getQueryLog();

    $query = " select email,mobile from users  where id = '$manager_id' ";
    $result = DB::select($query);
    $email = $result[0]->email;
    // $mobile = $result[0]->mobile;

    // $email = "gaurav.negi1830@gmail.com";
    $data = $message;
    // Mail::to($email)->send(new DartMail($data));
    // Mail::to($email)->send(new DartMail($data));
}
function notification_mng($asgtkn, $mst_id, $assignment_type, $task, $task_a1, $user_id, $manager_id, $message, $message_save)
{

    $fnotification = new Notification();
    $fnotification->asgtkn = $asgtkn;
    $fnotification->assignment_id = $mst_id;
    $fnotification->assignment_type = $assignment_type;
    $fnotification->task = $task;
    $fnotification->task_a1 = $task_a1;
    $fnotification->notification_to = $user_id;
    $fnotification->notification_from = $manager_id;
    $fnotification->message = $message_save;
    $fnotification->notification_date = date('Y-m-d H:i:s');
    $fnotification->created_by = $user_id;
    $fnotification->created_at = date('Y-m-d H:i:s');
    //prd($fnotification);
    DB::enableQueryLog();
    $fnotification->save();
    $query = DB::getQueryLog();

    $query = " select email,mobile from users  where id = '$user_id' ";
    $result = DB::select($query);
    $email = $result[0]->email;
    // $mobile = $result[0]->mobile;
    // $email = "gaurav.negi1830@gmail.com";
    $data = $message;
    // Mail::to($email)->send(new DartMail($data));
    // Mail::to($email)->send(new DartMail($data));
}
function notification_count()
{
    $userid = Auth::user()->id;
    $user = Auth::user();
    $u_type = $user->u_type;
    if ($u_type != 'CEO' && $u_type != 'A') {
        $countNotification = Notification::where('notification_to', $userid)
            ->where('is_read', '0')
            ->where('is_deleted', '0')
            ->count();
        return $countNotification;
    } else {
        $countNotification = Notification::where('is_read', '0')

            ->where('is_deleted', '0')
            ->count();
        return $countNotification;
    }
}
function getnotificationList()
{
    $userid = Auth::user()->id;
    $user = Auth::user();
    $u_type = $user->u_type;
    if ($u_type != 'CEO' && $u_type != 'A') {
        $notificationList = Notification::where('notification_to', $userid)
            ->where('is_deleted', '0')
            ->where('is_read', '0')
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
        return $notificationList;
    } else {
        $notificationList = Notification::where('is_read', '0')
            ->where('is_deleted', '0')
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
        return $notificationList;
    }
}

function checkna($data)
{

    if ($data != '') {

        return $data;
    } else {
        return 'N/A';
    }
}
function checkZero($data)
{
    if ($data != '') {

        return $data;
    } else {
        return 0;
    }
}

function Checkper($data)
{
    $data = number_format((float)$data, 2, '.', '');
    return $data;
}
function pan($data)
{
    $data = substr_replace($data, str_repeat("X", 7), 1, 7);
    return $data;
}

function aadhar($data)
{
    $data = substr_replace($data, str_repeat("X", 9), 0, 9);
    return $data;
}
function account($data)
{
    if (strlen($data) > 4) {
        $lastFourDigits = substr($data, -4);
        $maskedAccountNumber = str_repeat('X', strlen($data) - 4) . $lastFourDigits;

        return $maskedAccountNumber;
    } else {
        return $data;
    }
}
function logindetails($user_id, $action, $u_type, $user_ip, $time)
{
    $login_details = new Logindetail();
    $login_details->user_id = $user_id;
    $login_details->user_ip = $user_ip;
    $login_details->action = $action;
    $login_details->time = $time;
    $login_details->u_type = $u_type;

    $login_details->save();
}
function change_date_new($date)
{
    if ($date != '') {
        $date1 = str_replace('/', '-', $date);
        $datenew = date("M jS, Y ", strtotime($date1));
        return $datenew;
    } else {
        return 'N/A';
    }
}
function send_otp($email, $data)
{

    // prd($data);
    $email = "gaurav.negi1830@gmail.com";
    Mail::to($email)->send(new DartOtp($data));
}
function parent_id($facility_id)
{
    $query = "SELECT parent_id FROM users where id = $facility_id and is_deleted = 0";
    $data = DB::select($query);
    $result = $data[0]->parent_id;
    return $result;
}
function language($id)
{
    $query = "SELECT language_name FROM mst_language where language_id = $id and is_deleted = 0";
    $data = DB::select($query);
    $result = $data[0]->language_name;
    return $result;
}

function analysis($family_id)
{

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
        if ($s_last_saved_amt > 0 && $expected_amt > 0) {
            $average_3_cy = (($s_last_saved_amt / $expected_amt) * 100);
        } else {
            $average_3_cy = 0;
        }
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
        // prd($data['loan_outstanding']);


        foreach ($data['loan_outstanding'] as $row) {
            if ($row->lo_type == 'SHG Loan') {

                $num = $num + 1;
                $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                if ($row->overdue > 0 || $row->monthly_emi > 0) {
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
                } else {
                }
                if ($row->lo_type == 'Federation Loan') {
                    $num = $num + 1;
                    $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                    $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                    $no_of_days = '';
                }
                if ($row->lo_type == 'Cluster Loan') {
                    $num = $num + 1;
                    $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                    $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                }
            }
            if ($row->lo_type == 'Other Private Loan') {
                $num = $num + 1;
                $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                if ($row->overdue > 0 || $row->monthly_emi > 0) {
                    $no_of_days =    $no_of_days + ($row->overdue / $row->monthly_emi);
                } else {
                    $no_of_days = '';
                }
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

function shg_analysis($shg_id)
{
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
    // prd($x2);
    if ($x2 != '') {
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
        $data['analysis_data']['shg_percent_of_poorest_internal'] = 0;
        $data['analysis_data']['color6'] = 'red';
    }

    // analysis 5
    $data['analysis_data']['shg_percent_of_poorest_other'] = '';
    $data['analysis_data']['color16'] = '';
    $x2 = $data['analysis'][0]->shg_percent_of_poorest_other;

    if ($x2 != '') {
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
        $data['analysis_data']['shg_repayment_internal'] = (($x2 >= 95 ? 12 : ($x2 >= 85 ? 10 : ($x2 >= 75 ? 7 : 5))));
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
        $data['analysis_data']['shg_repayment_internal'] = (($years <= 1 ? 12 : ($years <= 2 ? 6 : ($years >= 3 ? 0 : 0))));
        $data['analysis_data']['color5'] = 'black';
        // if ($years <= 1) {
        //     $data['analysis_data']['color5'] = 'green';
        // } elseif ($years > 1 && $years <= 2) {
        //     $data['analysis_data']['color5'] = 'yellow';
        // } elseif ($years >= 3) {
        //     $data['analysis_data']['color5'] = 'red';
        // }
    }

    // analysis 10
    $x2 = (str_replace('%', '', $data['analysis'][0]->shg_repayment_other));

    $data['analysis_data']['shg_repayment_other'] = '';
    $data['analysis_data']['color7'] = '';
    if ($x2 != '') {
        $data['analysis_data']['shg_repayment_other'] = (($x2 >= 95 ? 12 : ($x2 >= 85 ? 10 : ($x2 >= 75 ? 7 : 5))));
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
        $data['analysis_data']['shg_repayment_other'] = (($years <= 2 ? 12 : ($years >= 2 ? 6 : ($years >= 3 ? 0 : 0))));
        $data['analysis_data']['color7'] = 'black';
        // if ($years <= 2) {
        //     $data['analysis_data']['color7'] = 'green';
        // } elseif ($years > 2 && $years < 3) {
        //     $data['analysis_data']['color7'] = 'yellow';
        // } elseif ($years >= 3) {
        //     $data['analysis_data']['color7'] = 'red';
        // }
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
        $data['analysis_data']['color9'] = 'black';
        // if ($years <= 1) {
        //     $data['analysis_data']['color9'] = 'green';
        // } elseif ($years > 1 && $years <= 2) {
        //     $data['analysis_data']['color9'] = 'yellow';
        // } elseif ($years >= 3) {
        //     $data['analysis_data']['color9'] = 'red';
        // }
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
        $data['analysis_data']['color19'] = 'black';
        // if ($years < 2) {
        //     $data['analysis_data']['color19'] = 'green';
        // } elseif ($years > 2 && $years <= 3) {
        //     $data['analysis_data']['color19'] = 'yellow';
        // } elseif ($years > 3) {
        //     $data['analysis_data']['color19'] = 'red';
        // }
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

function fed_analysis($fed_id)
{
    $data['profile'] = DB::table('federation_profile as a')
        ->where('is_deleted', '=', 0)
        ->where('a.federation_sub_mst_id', '=', $fed_id)
        ->get()->toArray();

    $data['governance'] = DB::table('federation_governance as a')
        ->where('is_deleted', '=', 0)
        ->where('a.federation_sub_mst_id', '=', $fed_id)
        ->get()->toArray();
    $data['analysis'] = DB::table('federation_analysis as a')
        ->where('is_deleted', '=', 0)
        ->where('a.federation_sub_mst_id', '=', $fed_id)
        ->get()->toArray();

    $data['efficiency'] = DB::table('federation_efficiency as a')
        ->where('is_deleted', '=', 0)
        ->where('a.federation_sub_mst_id', '=', $fed_id)
        ->get()->toArray();

    //analysis 1
    $count = 0;
    $data['show1'] = '';
    $data['analysis_1'] = '';
    if (!empty($data['governance'])) {
        if (($data['governance'][0]->last_two_election_conducted) == 'Yes') {
            $count += 1;
        }

        if (($data['governance'][0]->last_two_election_conducted_2nd) == 'Yes') {
            $count += 1;
        }

        if (($data['governance'][0]->last_two_election_conducted_3rd) == 'Yes') {
            $count += 1;
        }
    }


    if ($count != 0) {
        $data['analysis_1'] = $count == 3 ? 4 : ($count == 2 ? 3 : ($count == 1 ? 1 : 0));

        $data['show1'] = $count == 3 ? 'green' : ($count == 2 ? 'yellow' : ($count == 1 ? 'grey' : 'red'));
    } else {
        $data['analysis_1'] = 0;

        $x1 = ($data['analysis_1'] * 100) / 4;
        $data['show1'] = $x1 >= 90 ? 'green' : ($x1 >= 75 ? 'yellow' : ($x1 >= 60 ? 'grey' : 'red'));
    }

    //analysis 2
    $count1 = '';
    $data['show2'] = '';
    $data['analysis_2'] = '';
    $average = $data['analysis'][0]->average_metting_attendance;

    if ($average != '') {
        $count1 = (($average >= 90 ? 5 : ($average >= 75 ? 4 : ($average >= 60 ? 3 : 1))));
        $data['analysis_2'] = $count1;
        if ($average >= 100) {
            $data['show2'] = 'green';
        } elseif ($average >= 80 && $average <= 99) {
            $data['show2'] = 'yellow';
        } elseif ($average >= 60 && $average <= 79) {
            $data['show2'] = 'grey';
        } elseif ($average < 59) {
            $data['show2'] = 'red';
        }
    } else {
        $data['analysis_2'] = 0;
        $data['show2'] = 'red';
    }

    //analysis 3
    $count3 = $data['analysis'][0]->federation_book_updation;

    $data['analysis_3'] = '';
    $data['show3'] = '';
    if ($count3 != '') {
        $data['analysis_3'] = $count3 == 'Fully updated' ? 8 : ($count3 == 'Partially updated' ? 4 : ($count == 'Cash book only updated' ? 2 : 0));
        if ($count3 == 'Fully updated') {
            $data['show3'] = 'green';
        } elseif ($count3 == 'Partially updated') {
            $data['show3'] = 'yellow';
        } elseif ($count3 == 'Cash book only updated') {
            $data['show3'] = 'grey';
        } elseif ($count3 == 'Books not updated') {
            $data['show3'] = 'red';
        }
    } else {
        $data['analysis_3'] = 0;
        $data['show3'] = 'red';
    }

    //analysis 4
    $count4 = $data['analysis'][0]->federation_annual_plan_and_budget_approval;
    $data['analysis_4'] = '';
    $data['show4'] = '';

    if ($count4 != '') {
        $data['analysis_4'] = $count4 == 'Yes' ? 3 : 0;
        if ($count4 == 'Yes') {
            $data['show4'] = 'green';
        } elseif ($count4 == 'No') {
            $data['show4'] = 'red';
        }
    } else {
        $data['analysis_4'] = 0;
        $data['show4'] = 'red';
    }

    //analysis 5

    $count5 = '';
    $data['analysis_5'] = '';
    $data['show5'] = '';
    $average_result = (int) $data['analysis'][0]->achievement_last_year_annual_plan;

    if ($average_result != '') {
        $average1 = $average_result * 20;
        $count5 = (($average1 > 60 ? 2 : ($average1 >= 50 ? 1 : 0)));

        $data['analysis_5'] = $count5;

        if ($average_result > 3) {
            $data['show5'] = 'green';
        } else if ($average_result >= 2 && $average_result <= 3) {
            $data['show5'] = 'yellow';
        } else if ($average_result == 1) {
            $data['show5'] = 'grey';
        } else if ($average_result == 0) {
            $data['show5'] = 'red';
        }
    } else {
        $data['analysis_5'] = '--';
        $data['show5'] = '';
    }

    //analysis 6
    $result = $data['analysis'][0]->grade_federation_obtained_during_last_1_year;
    $data['analysis_6'] = '';
    $data['show6'] = '';

    // if ($result != '') {
    //     $data['analysis_6'] = $result == 'A' ? 3 : ($result == 'B' ? 2 : ($result == 'C' ? 1 : 0));
    //     $x6 = ($data['analysis_6'] * 100) / 3;
    //     if ($result == 'A') {
    //         $data['show6'] = 'green';
    //     }
    //     if ($result == 'B') {
    //         $data['show6'] = 'yellow';
    //     }
    //     if ($result == 'C') {
    //         $data['show6'] = 'grey';
    //     }
    //     if ($result == 'D') {
    //         $data['show6'] = 'red';
    //     }
    // } else {
    //     $data['analysis_6'] = 0;
    //     $data['show6'] = 'red';
    // }

    //analysis 7
    $data['analysis_7'] = '';
    $data['show7'] = '';

    $nine_b = $data['profile'][0]->shg_at_time_creation;
    $ten_b = $data['profile'][0]->total_SHGs;

    if ($nine_b != 0 || $nine_b > 0) {
        $diff = round((($nine_b - $ten_b) / $nine_b) * 100);
        if (($ten_b >= $nine_b) || ($diff <= 5)) {
            $data['analysis_7'] = 3;
            $data['show7'] = 'green';
        } elseif ($diff >= 6 && $diff <= 10) {
            $data['analysis_7'] = 2;
            $data['show7'] = 'yellow';
        } elseif ($diff >= 11 && $diff <= 20) {
            $data['analysis_7'] = 1;
            $data['show7'] = 'grey';
        } else {
            $data['analysis_7'] = 0;
            $data['show7'] = 'red';
        }
    } else {
        $data['analysis_7'] = '--';
    }



    //analysis 8


    $data['analysis_8'] = '';
    $data['show8'] = '';
    if ($data['governance'][0]->external_audit == 'Yes') {
        $result8 = $data['governance'][0]->issues_highlighted_resolved;
        if ($result8 == 'all') {
            $data['analysis_8'] = 5;
            $data['show8'] = 'green';
        } elseif ($result8 == 'mostly') {
            $data['analysis_8'] = 4;
            $data['show8'] = 'yellow';
        } elseif ($result8 == 'partially') {
            $data['analysis_8'] = 3;
            $data['show8'] = 'grey';
        } elseif ($result8 == 'none') {
            $data['analysis_8'] = 2;
            $data['show8'] = 'red';
        }
    } else {
        $data['analysis_8'] = 0;
        $data['show8'] = 'red';
    }

    $data['total_1to8'] = (float) $data['analysis_1'] + (float) $data['analysis_2'] + (float) $data['analysis_3'] + (float) $data['analysis_4'] + (float) $data['analysis_5'] + (float) $data['analysis_7'] + (float) $data['analysis_8'];
    $x1to8 = ($data['total_1to8'] * 100) / 30;
    $data['score'] = $x1to8;
    $data['show_1to8'] = $x1to8 >= 90 ? 'green' : ($x1to8 >= 75 ? 'yellow' : ($x1to8 >= 60 ? 'grey' : 'red'));
    $count9 = 0;

    //analysis 9
    $result9 = (float) $data['analysis'][0]->coverage_of_target_mobilization;
    $data['analysis_9'] = '';
    $data['show9'] = '';
    if ($result9 != 0) {
        $data['analysis_9'] = ($result9 >= 80 ? 5 : ($result9 >= 60 ? 4 : ($result9 >= 40 ? 3 : 1)));
        if ($result9 >= 80 && $result9 <= 100) {
            $data['show9'] = 'green';
        } elseif ($result9 >= 60 && $result9 <= 79) {
            $data['show9'] = 'yellow';
        } elseif ($result9 >= 40 && $result9 <= 59) {
            $data['show9'] = 'grey';
        } elseif ($result9 < 40) {
            $data['show9'] = 'red';
        }
    } else {
        $data['analysis_9'] = 0;
        $data['show9'] = 'red';
    }

    //analysis10
    $result10 = (float) $data['analysis'][0]->per_of_poorest_families_benefiting;
    $data['analysis_10'] = '';
    $data['show10'] = '';

    if ($result10 != '') {
        $data['analysis_10'] = $result10 > 75 ? 5 : ($result10 > 60 ? 4 : ($result10 > 30 ? 3 : 0));

        if ($result10 >= 75 && $result10 <= 100) {
            $data['show10'] = 'green';
        } elseif ($result10 >= 50 && $result10 <= 74) {
            $data['show10'] = 'yellow';
        } elseif ($result10 >= 30 && $result10 <= 49) {
            $data['show10'] = 'grey';
        } elseif ($result10 < 30) {
            $data['show10'] = 'red';
        }
    } else {
        $data['analysis_10'] = 0;
        $data['show10'] = 'red';
    }
    //analysis 11
    $result11 = (float) $data['analysis'][0]->poorest_category_board_members;
    $data['analysis_11'] = '';
    $data['show11'] = '';

    if ($result11 != 0) {
        $data['analysis_11'] = ($result11 >= 60 ? 5 : ($result11 >= 40 ? 4 : ($result11 >= 25 ? 3 : 1)));
        if ($result11 > 60) {
            $data['show11'] = 'green';
        } elseif ($result11 >= 40 && $result11 <= 59) {
            $data['show11'] = 'yellow';
        } elseif ($result11 >= 25 && $result11 <= 39) {
            $data['show11'] = 'grey';
        } elseif ($result11 < 25) {
            $data['show11'] = 'red';
        }
    } else {
        $data['analysis_11'] = 0;
        $data['show11'] = 'red';
    }

    //total 9 to 11
    $data['total_9to11'] = (float) $data['analysis_9'] + (float) $data['analysis_10'] + (float) $data['analysis_11'];
    $x9to11 = ($data['total_9to11'] * 100) / 15;
    $data['score1'] = $x9to11;
    $data['show_9to11'] = $x9to11 >= 90 ? 'green' : ($x9to11 >= 75 ? 'yellow' : ($x9to11 >= 60 ? 'grey' : 'red'));

    //analysis 12
    $result12 = $data['analysis'][0]->time_taken_to_approve_loan;
    $data['analysis_12'] = '';
    $data['show12'] = '';

    if ($result12 != '') {
        $data['analysis_12'] = $result12 <= 5 ? 4 : ($result12 <= 10 ? 3 : ($result12 <= 15 ? 2 : 1));
        if ($result12 <= 5) {
            $data['show12'] = 'green';
        } elseif ($result12 >= 6 && $result12 <= 10) {
            $data['show12'] = 'yellow';
        } elseif ($result12 >= 11 && $result12 <= 15) {
            $data['show12'] = 'grey';
        } elseif ($result12 > 15) {
            $data['show12'] = 'red';
        }
    } else {
        $data['analysis_12'] = 0;
        $data['show12'] = 'red';
    }
    // analysis 26
    $result26 = $data['efficiency'][0]->time_taken_to_give_money_from_approval;
    $data['analysis_26'] = '';
    $data['show26'] = '';
    if ($result26 != '') {
        $data['analysis_26'] = ($result26 <= 3 ? 3 : ($result26 <= 5 ? 2 : ($result26 <= 7 ? 1 : 0)));
        if ($data['analysis_26'] == 3) {
            $data['show26'] = 'green';
        } elseif ($data['analysis_26'] == 2) {
            $data['show26'] = 'yellow';
        } elseif ($data['analysis_26'] == 1) {
            $data['show26'] = 'grey';
        } elseif ($data['analysis_26'] == 0) {
            $data['show26'] = 'red';
        }
    }
    //analysis 13
    $count13 = '';
    $result13 = $data['analysis'][0]->cost_per_active_client;
    $data['analysis_13'] = '';
    $data['show13'] = '';
    if ($result13 != '') {
        $count13 = ($result13 <= 2 ? 3 : ($result13 <= 3 ? 2 : ($result13 <= 5 ? 1 : 0)));

        $data['analysis_13'] = $count13;
        if ($count13 == 3) {
            $data['show13'] = 'green';
        } elseif ($count13 == 2) {
            $data['show13'] = 'yellow';
        } elseif ($count13 == 1) {
            $data['show13'] = 'grey';
        } elseif ($count13 == 0) {
            $data['show13'] = 'red';
        }
    } else {
        $data['analysis_13'] = '--';
        $data['show13'] = '--';
    }

    //analysis 14
    $count14 = '';
    $result14 = $data['analysis'][0]->operating_expense_ratio;
    $data['analysis_14'] = '';
    $data['show14'] = '';

    if ($result14 != '') {
        $count14 = ($result14 < 5 ? 5 : ($result14 <= 10 ? 4 : ($result14 <= 15 ? 3 : ($result14 > 15 ? 1 : 0))));
        $data['analysis_14'] = $count14;
        if ($result14 <= 5) {
            $data['show14'] = 'green';
        } elseif ($result14 >= 6 && $result14 <= 10) {
            $data['show14'] = 'yellow';
        } elseif ($result14 >= 11 && $result14 <= 15) {
            $data['show14'] = 'grey';
        } elseif ($result14 > 15) {
            $data['show14'] = 'red';
        }
    } else {
        $data['analysis_14'] = 0;
        $data['show14'] = 'red';
    }

    //total 12 to 14
    $data['total_12to14'] = (float) $data['analysis_12'] + (float) $data['analysis_13'] + (float) $data['analysis_14'] + (float) $data['analysis_26'];
    $x12to14 = ($data['total_12to14'] * 100) / 15;
    $data['score2'] = $x12to14;
    $data['show_12to14'] = $x12to14 >= 90 ? 'green' : ($x12to14 >= 75 ? 'yellow' : ($x12to14 >= 60 ? 'grey' : 'red'));

    $federation_profile = DB::table('federation_profile as a')
        ->where('is_deleted', '=', 0)
        ->where('a.federation_sub_mst_id', '=', $fed_id)
        ->get()->toArray();


    $fed_formed = $federation_profile[0]->date_federation_was_found;
    $pattern = '/^\d{2}\/\d{2}\/\d{4}$/';


    if (preg_match($pattern, $fed_formed)) {
        $originalDate = DateTime::createFromFormat('d/m/Y', $fed_formed);

        $formattedDate = $originalDate->format('d/M/Y');
    } else {
        $formattedDate = $fed_formed;
    }

    $currentnewDate = new DateTime();
    $currentDate = strftime('%d/%b/%Y', $currentnewDate->getTimestamp());
    $date1 = DateTime::createFromFormat('d/M/Y', $formattedDate);
    $date2 = DateTime::createFromFormat('d/M/Y', $currentDate);
    // prd("jhj");
    // Calculate the difference

    $interval = $date1->diff($date2);
    // Get the difference in years, months, and days
    $years = $interval->y;
    // prd($years);
    //analysis 15
    $result15 = $data['analysis'][0]->per_of_members_benefited_from_federation;
    $data['analysis_15'] = '';
    $data['show15'] = '';

    if ($result15 != '') {
        $data['analysis_15'] = $result15 > 80 ? 5 : ($result15 > 60 ? 4 : ($result15 > 50 ? 3 : 1));
        if ($result15 >= 80 && $result15 <= 100) {
            $data['show15'] = 'green';
        } elseif ($result15 >= 60 && $result15 <= 79) {
            $data['show15'] = 'yellow';
        } elseif ($result15 >= 50 && $result15 <= 59) {
            $data['show15'] = 'grey';
        } elseif ($result15 < 50) {
            $data['show15'] = 'red';
        }
    } else {
        $data['analysis_15'] =  (($years < 3 ? 5 : ($years <= 5 ? 3 : ($years > 5 ? 0 : 0))));
        if ($years < 3) {
            $data['show15'] = 'green';
        } elseif ($years >= 3 && $years <= 5) {
            $data['show15'] = 'yellow';
        } elseif ($years > 5) {
            $data['show15'] = 'red';
        }
    }

    //analysis 16
    $result16 = (float) (str_replace('%', '', $data['analysis'][0]->repayment_rate_of_federation_loan));
    $data['analysis_16'] = '';
    $data['show16'] = '';

    if ($result16 != 0) {
        $data['analysis_16'] = $result16 >= 95 ? 10 : ($result16 >= 80 ? 8 : ($result16 >= 70 ? 6 : 2));
        if ($result16 >= 95) {
            $data['show16'] = 'green';
        } elseif ($result16 >= 80 && $result16 <= 94) {
            $data['show16'] = 'yellow';
        } elseif ($result16 >= 70 && $result16 <= 79) {
            $data['show16'] = 'grey';
        } elseif ($result16 < 70) {
            $data['show16'] = 'red';
        }
    } else {
        $data['analysis_16'] = 0;
        $data['show16'] = 'red';
    }

    //analysis 17
    $result17 = (float) (str_replace('%', '', $data['analysis'][0]->repayment_of_Bank_loan_by_the_federation));
    $data['analysis_17'] = '';
    $data['show17'] = '';

    if ($result17 != 0) {
        $data['analysis_17'] = $result17 > 95 ? 5 : ($result17 >= 80 ? 4 : ($result17 > 70 ? 3 : 1));
        if ($result17 >= 95) {
            $data['show17'] = 'green';
        } elseif ($result17 >= 80 && $result17 <= 94) {
            $data['show17'] = 'yellow';
        } elseif ($result17 >= 70 && $result17 <= 79) {
            $data['show17'] = 'grey';
        } elseif ($result17 < 70) {
            $data['show17'] = 'red';
        }
    } else {
        $data['analysis_17'] = '--';
    }

    //analysis 18
    $result18 = (float) $data['analysis'][0]->federation_loan_PAR_90;
    $data['analysis_18'] = '';
    $data['show18'] = '';

    if ($result18 != '') {
        if ($result18 < 1) {
            $data['analysis_18'] = 5;
            $data['show18'] = 'green';
        }
        if ($result18 >= 1 && $result18 <= 5) {
            $data['analysis_18'] = 3;
            $data['show18'] = 'yellow';
        }
        if ($result18 > 5 && $result18 <= 10) {
            $data['analysis_18'] = 1;
            $data['show18'] = 'grey';
        }
        if ($result18 > 10) {
            $data['analysis_18'] = 0;
            $data['show18'] = 'red';
        }
    } else {
        $data['analysis_18'] = 0;
        $data['show18'] = 'red';
    }

    //analysis 19
    $result19 = (float) $data['analysis'][0]->livelihood_purposes_of_all_loans;
    $data['analysis_19'] = '';
    $data['show19'] = '';
    if ($result19 != 0) {
        $data['analysis_19'] = ($result19 >= 90 ? 3 : ($result19 >= 75 ? 2 : ($result19 >= 60 ? 1 : 0)));
        if ($result19 >= 90) {
            $data['show19'] = 'green';
        } elseif ($result19 >= 75 && $result19 <= 89) {
            $data['show19'] = 'yellow';
        } elseif ($result19 >= 60 && $result19 <= 74) {
            $data['show19'] = 'grey';
        } elseif ($result19 < 60) {
            $data['show19'] = 'red';
        }
    } else {
        $data['analysis_19'] = 0;
        $data['show19'] = 'red';
    }
    //analysis 20
    $count20 = '';
    $result20 = (float) $data['analysis'][0]->rotation_of_funds;
    $data['analysis_20'] = '';
    $data['show20'] = '';
    if ($result20 != '') {
        $data['analysis_20'] = ($result20 > 0.7) ? 2 : ((($result20 >= 0.5) && ($result20 <= 0.7)) ? 1 : 0);
        if ($result20 >= 0.7) {
            $data['show20'] = 'green';
        } elseif ($result20 >= 0.5 && $result20 <= 0.69) {
            $data['show20'] = 'yellow';
        } elseif ($result20 >= 0.4 && $result20 <= 0.59) {
            $data['show20'] = 'grey';
        } elseif ($result20 < 0.4) {
            $data['show20'] = 'red';
        }
    } else {
        $data['analysis_20'] = 0;
        $data['show20'] = 'red';
    }

    //total 15 to 20
    $data['total_15to20'] = (float) $data['analysis_15'] + (float) $data['analysis_16']  + (float) $data['analysis_18'] + (float) $data['analysis_19'] + (float) $data['analysis_20'];
    $x15to20 = ($data['total_15to20'] * 100) / 25;
    $data['score3'] = $x15to20;
    $data['show_15to20'] = $x15to20 >= 90 ? 'green' : ($x15to20 >= 75 ? 'yellow' : ($x15to20 >= 60 ? 'grey' : 'red'));

    //analysis 21
    $result21 = $data['analysis'][0]->does_federation_cover_own_income;
    $data['analysis_21'] = '';
    $data['show21'] = '';
    if ($result21 != '') {
        $data['analysis_21'] = $result21 == 'Yes' ? 3 : 0;
        if ($result21 == "Yes") {
            $data['show21'] = 'green';
        } elseif ($result21 == "No") {
            $data['show21'] = 'red';
        }
    } else {
        $data['analysis_21'] = 0;
        $data['show21'] = 'red';
    }

    //analysis 22
    $result22 = $data['analysis'][0]->loan_security_fund_established;
    $data['analysis_22'] = '';
    $data['show22'] = '';

    if ($result22 != '') {
        $data['analysis_22'] = $result22 == 'Yes' ? 3 : 0;
        if ($result22 == "Yes") {
            $data['show22'] = 'green';
        } elseif ($result22 == "No") {
            $data['show22'] = 'red';
        }
    } else {
        $data['analysis_22'] = 0;
        $data['show22'] = 'red';
    }
    //total 21 to 22
    $data['total_21to22'] = (float) $data['analysis_21'] + (float) $data['analysis_22'];
    $x21to22 = ($data['total_21to22'] * 100) / 6;
    $data['score4'] = $x21to22;
    $data['show_21to22'] = $x21to22 >= 90 ? 'green' : ($x21to22 >= 75 ? 'yellow' : ($x21to22 >= 60 ? 'grey' : 'red'));

    //analysis 23
    $count23 = '';
    $result23 = (float) (str_replace('%', '', $data['analysis'][0]->members_covered_under_life_insurance));
    $data['analysis_23'] = '';
    $data['show23'] = '';
    if ($result23 != 0) {
        $count23 = ($result23 >= 90 ? 3 : ($result23 >= 75 ? 2 : ($result23 >= 60 ? 1 : 0)));
        $data['analysis_23'] = $count23;
        if ($result23 >= 90) {
            $data['show23'] = 'green';
        } elseif ($result23 >= 75 && $result23 <= 89) {
            $data['show23'] = 'yellow';
        } elseif ($result23 >= 60 && $result23 <= 74) {
            $data['show23'] = 'grey';
        } elseif ($result23 < 60) {
            $data['show23'] = 'red';
        }
    } else {
        $data['analysis_23'] = 0;
        $data['show23'] = 'red';
    }

    //analysis 24
    $count24 = '';
    $result24 = (float) (str_replace('%', '', $data['analysis'][0]->availed_members_covered_loan_insurance));
    $data['analysis_24'] = '';
    $data['show24'] = '';
    if ($result24 != 0) {
        $count24 = $result24 >= 90 ? 3 : ($result24 >= 75 ? 2 : ($result24 >= 60 ? 1 : 0));
        $data['analysis_24'] = $count24;
        if ($result24 >= 90) {
            $data['show24'] = 'green';
        } elseif ($result24 >= 75 && $result24 <= 89) {
            $data['show24'] = 'yellow';
        } elseif ($result24 >= 60 && $result24 <= 74) {
            $data['show24'] = 'grey';
        } elseif ($result24 < 60) {
            $data['show24'] = 'red';
        }
    } else {
        $data['analysis_24'] = 0;
        $data['show24'] = 'red';
    }

    //analysis 25
    $count25 = '';
    $result25 = (float) (str_replace('%', '', $data['analysis'][0]->animals_insured_purchased));
    $data['analysis_25'] = '';
    $data['show25'] = '';
    if ($result25 != 0) {
        $count25 = $result25 >= 90 ? 3 : ($result25 >= 75 ? 2 : ($result25 >= 60 ? 1 : 0));
        $data['analysis_25'] = $count25;
        if ($result25 >= 90) {
            $data['show25'] = 'green';
        } elseif ($result25 >= 75 && $result25 <= 89) {
            $data['show25'] = 'yellow';
        } elseif ($result25 >= 60 && $result25 <= 74) {
            $data['show25'] = 'grey';
        } elseif ($result25 < 60) {
            $data['show25'] = 'red';
        }
    } else {
        $data['analysis_25'] = 0;
        $data['show25'] = 'red';
    }
    //total 23 to 25
    $data['total_23to25'] = (float) $data['analysis_23'] + (float) $data['analysis_24'] + (float) $data['analysis_25'];
    $x23to25 = ($data['total_23to25'] * 100) / 9;
    $data['score5'] = $x23to25;
    $data['show_23to25'] = $x23to25 >= 90 ? 'green' : ($x23to25 >= 75 ? 'yellow' : ($x23to25 >= 60 ? 'grey' : 'red'));

    $data['analysis_final_total'] = $data['total_23to25'] + $data['total_21to22'] + $data['total_15to20'] + $data['total_12to14'] + $data['total_9to11'] + $data['total_1to8'];
    $xfinal = ($data['analysis_final_total'] * 100) / 100;
    $data['show_final_total'] = $xfinal >= 90 ? 'green' : ($xfinal >= 75 ? 'yellow' : ($xfinal >= 60 ? 'grey' : 'red'));
    $data['show_final_status'] = $data['show_final_total'] == 'green' ? 'Minimal Risk' : ($data['show_final_total'] == 'yellow' ? ' Low Risk' : ($data['show_final_total'] == 'grey' ? 'Moderate Risk' : 'High Risk'));


    return $data;
}

function cluster_analysis($clus_id)
{

    $data['saving'] = DB::table('cluster_saving as a')
        ->where('is_deleted', '=', 0)
        ->where('a.cluster_sub_mst_id', '=', $clus_id)
        ->get()->toArray();
    $data['efficiency'] = DB::table('cluster_efficiency as a')
        ->where('is_deleted', '=', 0)
        ->where('a.cluster_sub_mst_id', '=', $clus_id)
        ->get()->toArray();
    $data['profile'] = DB::table('cluster_profile as a')
        ->where('is_deleted', '=', 0)
        ->where('a.cluster_sub_mst_id', '=', $clus_id)
        ->get()->toArray();

    $data['analysis'] = DB::table('cluster_analysis as a')
        ->where('is_deleted', '=', 0)
        ->where('a.cluster_sub_mst_id', '=', $clus_id)
        ->get()->toArray();

    $data['governance'] = DB::table('cluster_governance as a')
        ->where('is_deleted', '=', 0)
        ->where('a.cluster_sub_mst_id', '=', $clus_id)
        ->get()->toArray();

    $data['inclusion'] = DB::table('cluster_inclusion as a')
        ->where('is_deleted', '=', 0)
        ->where('a.cluster_sub_mst_id', '=', $clus_id)
        ->get()->toArray();
    //indicator  1
    $count = 0;
    $data['show1'] = '';
    $data['analysis_1'] = '';
    if (!empty($data['governance']) > 0) {
        if (($data['governance'][0]->first_election_date) != '') {
            $count += 1;
        }
        if (($data['governance'][0]->date_last_election) != '') {
            $count += 1;
        }
    }
    if ($count != 0) {
        $data['analysis_1'] = $count == 2 ? 5 : ($count == 1 ? 3 : 0);
        $x1_data = ($data['analysis_1'] * 100) / 5;
        $data['show1'] = $x1_data >= 90 ? 'green' : ($x1_data >= 75 ? 'yellow' : ($x1_data >= 60 ? 'grey' : 'red'));
    } else {
        $data['analysis_1'] = 0;
        $data['show1'] = 'red';
    }

    //analysis 2
    $x2 = ($data['analysis'][0]->Average_participation_of);
    $data['analysis_data']['Average_participation_of'] = '';
    $data['analysis_data']['color1'] = '';
    if ($x2 != '') {
        $data['analysis_data']['Average_participation_of'] = ($x2 == 100 ? 5 : ($x2 >= 80 ? 4 : ($x2 >= 60 ? 3 : 2)));
        if ($x2 == 100) {
            $data['analysis_data']['color1'] = 'green';
        } elseif ($x2 >= 80 && $x2 <= 99) {
            $data['analysis_data']['color1'] = 'yellow';
        } elseif ($x2 >= 60 && $x2 <= 79) {
            $data['analysis_data']['color1'] = 'grey';
        } elseif ($x2 < 59) {
            $data['analysis_data']['color1'] = 'red';
        }
    } else {
        $data['analysis_data']['Average_participation_of'] = 0;
        $data['analysis_data']['color1'] = 'red';
    }

    //analysis 3
    $count3 = $data['analysis'][0]->Cluster_Book_updation;

    $data['analysis_data']['Cluster_Book_updation'] = '';
    $data['analysis_data']['color2'] = '';
    if ($count3 != '') {

        if ($count3 == 'Fully updated') {
            $data['analysis_data']['Cluster_Book_updation'] = 5;
            $data['analysis_data']['color2'] = 'green';
        }
        if ($count3 == 'Partially updated') {
            $data['analysis_data']['Cluster_Book_updation'] = 4;
            $data['analysis_data']['color2'] = 'yellow';
        }
        if ($count3 == 'Book not updated') {
            $data['analysis_data']['Cluster_Book_updation'] = 0;
            $data['analysis_data']['color2'] = 'red';
        }
    } else {
        $data['analysis_data']['Cluster_Book_updation'] = '--';
        $data['analysis_data']['color2'] = '';
    }
    //analysis 4

    $data['analysis_data']['Percentage_of_Defunct'] = '';
    $data['analysis_data']['color3'] = '';
    $nine_b = $data['profile'][0]->shg_at_time_creation;
    $ten_b = $data['profile'][0]->total_SHGs;
    if ($nine_b > 0 || $nine_b > 0) {
        $diff = round((($nine_b - $ten_b) / $nine_b) * 100);
        if (($ten_b >= $nine_b) || ($diff <= 5)) {
            $data['analysis_data']['Percentage_of_Defunct'] = 5;
            $data['analysis_data']['color3'] = 'green';
        } elseif ($diff >= 6 && $diff <= 10) {
            $data['analysis_data']['Percentage_of_Defunct'] = 4;
            $data['analysis_data']['color3'] = 'yellow';
        } elseif ($diff >= 11 && $diff <= 20) {
            $data['analysis_data']['Percentage_of_Defunct'] = 3;
            $data['analysis_data']['color3'] = 'grey';
        } else {
            $data['analysis_data']['Percentage_of_Defunct'] = 1;
            $data['analysis_data']['color3'] = 'red';
        }
    } else {
        $data['analysis_data']['Percentage_of_Defunct'] = '--';
    }

    //analysis 5
    $count4 = $data['analysis'][0]->External_audit_completed;
    $data['analysis_data']['External_audit_completed'] = '';
    $data['analysis_data']['color4'] = '';
    if ($count4 != '') {
        $data['analysis_data']['External_audit_completed'] = ($count4 == 'Yes' ? 5 : 0);
        if ($count4 == 'Yes') {
            $data['analysis_data']['color4'] = 'green';
        } elseif ($count4 == 'No') {
            $data['analysis_data']['color4'] = 'red';
        }
    } else {
        $data['analysis_data']['External_audit_completed'] = 0;
        $data['analysis_data']['color4'] = 'red';
    }
    $data['total1'] = (float) $data['analysis_data']['Average_participation_of'] + (float) $data['analysis_data']['Cluster_Book_updation'] + (float) $data['analysis_data']['Percentage_of_Defunct'] + (float) $data['analysis_data']['External_audit_completed'] + (float) $data['analysis_1'];
    $total_gover = ($data['total1'] * 100) / 25;
    $data['score'] = $total_gover;
    $data['tcolor1'] = $total_gover >= 90 ? 'green' : ($total_gover >= 75 ? 'yellow' : ($total_gover >= 60 ? 'grey' : 'red'));

    //analysis 6
    // $x2 = (str_replace('%', '', $data['analysis'][0]->Coverage_of_target));
    // $data['analysis_data']['Coverage_of_target'] = '';
    // $data['analysis_data']['color5'] = '';
    // if ($x2 != '') {
    //     $data['analysis_data']['Coverage_of_target'] = (($x2 >= 80 ? 5 : ($x2 >= 60 ? 4 : ($x2 >= 40 ? 3 : 2))));
    //     if ($x2 >= 80 && $x2 <= 100) {
    //         $data['analysis_data']['color5'] = 'green';
    //     } elseif ($x2 >= 60 && $x2 <= 79) {
    //         $data['analysis_data']['color5'] = 'yellow';
    //     } elseif ($x2 >= 40 && $x2 <= 59) {
    //         $data['analysis_data']['color5'] = 'grey';
    //     } elseif ($x2 < 40) {
    //         $data['analysis_data']['color5'] = 'red';
    //     }
    // } else {
    //     $data['analysis_data']['Coverage_of_target'] = 0;
    //     $data['analysis_data']['color5'] = 'red';
    // }

    $poorest = $data['inclusion'][0]->poorest_board_members != '' ?  $data['inclusion'][0]->poorest_board_members : 0;
    $poor = $data['inclusion'][0]->poor_board_members != '' ?  $data['inclusion'][0]->poor_board_members : 0;
    $members = $poorest + $poor;
    $data['analysis_data']['poor_current_leadership'] = '';
    $data['analysis_data']['color5'] = '';
    $total_SHGs = $data['inclusion'][0]->total_board_members != '' ? $data['inclusion'][0]->total_board_members : 0;
    $x2 = '';
    if ($members != 0 || $total_SHGs != 0) {
        $x2 = ($members / $total_SHGs) * 100;
    }
    if ($x2 != '') {
        $data['analysis_data']['poor_current_leadership'] = (($x2 >= 60 ? 5 : ($x2 >= 40 ? 4 : ($x2 >= 25 ? 3 : 1))));
        if ($x2 >= 60) {
            $data['analysis_data']['color5'] = 'green';
        } elseif ($x2 >= 40 && $x2 < 60) {
            $data['analysis_data']['color5'] = 'yellow';
        } elseif ($x2 >= 25 && $x2 < 40) {
            $data['analysis_data']['color5'] = 'grey';
        } elseif ($x2 < 25) {
            $data['analysis_data']['color5'] = 'red';
        }
    } else {
        $data['analysis_data']['poor_current_leadership'] = 0;
        $data['analysis_data']['color5'] = 'red';
    }

    //analysis 7
    $x2 = $data['analysis'][0]->Percentage_of_poorest_benefiting_from_all_loans;
    $data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] = '';
    $data['analysis_data']['color6'] = '';
    if ($x2 != '') {
        $data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] = (($x2 >= 75 ? 5 : ($x2 >= 60 ? 4 : ($x2 >= 40 ? 3 : 1))));
        if ($x2 >= 75 && $x2 <= 100) {
            $data['analysis_data']['color6'] = 'green';
        } elseif ($x2 >= 50 && $x2 <= 74) {
            $data['analysis_data']['color6'] = 'yellow';
        } elseif ($x2 >= 30 && $x2 <= 49) {
            $data['analysis_data']['color6'] = 'grey';
        } elseif ($x2 < 30) {
            $data['analysis_data']['color6'] = 'red';
        }
    } else {
        $data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] = 0;
        $data['analysis_data']['color6'] = 'red';
    }
    //analysis 8
    $x2 = $data['analysis'][0]->Representation_of_Poorest;
    $data['analysis_data']['Representation_of_Poorest'] = '';
    $data['analysis_data']['color55'] = '';
    if ($x2 != '') {
        $data['analysis_data']['Representation_of_Poorest'] = (($x2 >= 60 ? 5 : ($x2 >= 40 ? 4 : ($x2 >= 25 ? 3 : 1))));
        if ($x2 >= 60) {
            $data['analysis_data']['color55'] = 'green';
        } elseif ($x2 >= 40 && $x2 <= 59) {
            $data['analysis_data']['color55'] = 'yellow';
        } elseif ($x2 >= 25 && $x2 <= 39) {
            $data['analysis_data']['color55'] = 'grey';
        } elseif ($x2 < 25) {
            $data['analysis_data']['color55'] = 'red';
        }
    } else {
        $data['analysis_data']['Representation_of_Poorest'] = 0;
        $data['analysis_data']['color55'] = 'red';
    }
    $data['total2'] = (float) $data['analysis_data']['poor_current_leadership'] + (float) $data['analysis_data']['Percentage_of_poorest_benefiting_from_all_loans'] + (float) $data['analysis_data']['Representation_of_Poorest'];
    $total_in = ($data['total2'] * 100) / 15;
    $data['score1'] = $total_in;
    $data['tcolor2'] = $total_in >= 90 ? 'green' : ($total_in >= 75 ? 'yellow' : ($total_in >= 60 ? 'grey' : 'red'));

    //analysis 9
    $count11 = $data['efficiency'][0]->group_prepare;
    $data['analysis_data']['group_prepare'] = '';
    $data['analysis_data']['color1111'] = '';
    if ($count11 != '') {
        $data['analysis_data']['group_prepare'] = ($count11 == 'Yes' ? 5 : 0);
        $x4 = ($data['analysis_data']['group_prepare'] * 100) / 5;
        $data['analysis_data']['color1111'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
    } else {
        $data['analysis_data']['group_prepare'] = 0;
        $data['analysis_data']['color1111'] = 'red';
    }
    //analysis 11
    $count4 = $data['analysis'][0]->Cluster_is_covering_its;

    $data['analysis_data']['Cluster_is_covering_its'] = '';
    $data['analysis_data']['color7'] = '';
    if ($count4 != '') {
        $data['analysis_data']['Cluster_is_covering_its'] = ($count4 == 'Yes' ? 5 : 0);
        if ($count4 == 'Yes') {
            $data['analysis_data']['color7'] = 'green';
        } elseif ($count4 == 'No') {
            $data['analysis_data']['color7'] = 'red';
        }
    } else {
        $data['analysis_data']['Cluster_is_covering_its'] = 0;
        $data['analysis_data']['color7'] = 'red';
    }
    // indicator 11
    $count11 = $data['efficiency'][0]->time_taken_to_approve_loan;

    $data['analysis_data']['time_taken_to_approve_loan'] = '';
    $data['analysis_data']['color_11'] = '';
    if ($count11 != '') {
        $data['analysis_data']['time_taken_to_approve_loan'] =  (($count11 <= 5  ? 5 : ($count11 <= 10  ? 4 : ($count11 <= 15 ? 3 : 1))));
        if ($data['analysis_data']['time_taken_to_approve_loan'] == 5) {
            $data['analysis_data']['color_11'] = 'green';
        } elseif ($data['analysis_data']['time_taken_to_approve_loan'] == 4) {
            $data['analysis_data']['color_11'] = 'yellow';
        } elseif ($data['analysis_data']['time_taken_to_approve_loan'] == 3) {
            $data['analysis_data']['color_11'] = 'grey';
        } elseif ($data['analysis_data']['time_taken_to_approve_loan'] == 1) {
            $data['analysis_data']['color_11'] = 'red';
        }
    } else {
        $data['analysis_data']['time_taken_to_approve_loan'] = 0;
        $data['analysis_data']['color_11'] = 'red';
    }
    //analysis 10
    $x2 = (int) $data['analysis'][0]->Time_taken_to_disburse;

    $data['analysis_data']['Time_taken_to_disburse'] = '';
    $data['analysis_data']['color8'] = '';
    if ($x2 != '') {
        if ($x2 <= 2) {
            $data['analysis_data']['Time_taken_to_disburse'] = 5;
            $data['analysis_data']['color8'] = 'green';
        } elseif ($x2 > 2 && $x2 <= 3) {
            $data['analysis_data']['Time_taken_to_disburse'] = 4;
            $data['analysis_data']['color8'] = 'yellow';
        } elseif ($x2 > 3 && $x2 <= 5) {
            $data['analysis_data']['Time_taken_to_disburse'] = 3;
            $data['analysis_data']['color8'] = 'grey';
        } elseif ($x2 > 5) {
            $data['analysis_data']['Time_taken_to_disburse'] = 1;
            $data['analysis_data']['color8'] = 'red';
        }
    } else {
        $data['analysis_data']['Time_taken_to_disburse'] = '--';
        $data['analysis_data']['color8'] = 'red';
    }

    $data['total3'] = (float) $data['analysis_data']['Cluster_is_covering_its'] + (float) $data['analysis_data']['Time_taken_to_disburse'] + (float) $data['analysis_data']['time_taken_to_approve_loan'];
    $total_ef = ($data['total3'] * 100) / 15;
    $data['score2'] = $total_ef;
    $data['tcolor3'] = $total_ef >= 90 ? 'green' : ($total_ef >= 75 ? 'yellow' : ($total_ef >= 60 ? 'grey' : 'red'));




    $cluster_formed = $data['profile'][0]->cluster_formed;

    $pattern = '/^\d{2}\/\d{2}\/\d{4}$/';


    if (preg_match($pattern, $cluster_formed)) {
        $originalDate = DateTime::createFromFormat('d/m/Y', $cluster_formed);

        $formattedDate = $originalDate->format('d/M/Y');
    } else {
        $formattedDate = $cluster_formed;
    }

    $currentnewDate = new DateTime();
    $currentDate = strftime('%d/%b/%Y', $currentnewDate->getTimestamp());
    $date1 = DateTime::createFromFormat('d/M/Y', $formattedDate);
    $date2 = DateTime::createFromFormat('d/M/Y', $currentDate);

    // Calculate the difference
    $interval = $date1->diff($date2);
    // Get the difference in years, months, and days
    $years = $interval->m;




    //analysis 12
    $x2 = (str_replace('%', '', $data['analysis'][0]->Repayment_rate_of_cluster_loan));
    $data['analysis_data']['Repayment_rate_of_cluster_loan'] = '';
    $data['analysis_data']['color9'] = '';
    if ($x2 != '') {
        $data['analysis_data']['Repayment_rate_of_cluster_loan'] = (($x2 >= 95 ? 10 : ($x2 >= 85 ? 7 : ($x2 >= 70 ? 5 : 2))));
        if ($x2 >= 95) {
            $data['analysis_data']['color9'] = 'green';
        } elseif ($x2 >= 80 && $x2 <= 94) {
            $data['analysis_data']['color9'] = 'yellow';
        } elseif ($x2 >= 70 && $x2 <= 79) {
            $data['analysis_data']['color9'] = 'grey';
        } elseif ($x2 < 70) {
            $data['analysis_data']['color9'] = 'red';
        }
    } else {

        $data['analysis_data']['Repayment_rate_of_cluster_loan'] = (($years <= 12 ? 10 : ($years <= 2 ? 24 : ($years > 48 ? 0 : 0))));
        if ($years <= 1) {
            $data['analysis_data']['color9'] = 'green';
        } elseif ($years > 1 && $years <= 2) {
            $data['analysis_data']['color9'] = 'yellow';
        } elseif ($years >= 3) {
            $data['analysis_data']['color9'] = 'red';
        }
    }
    //analysis 13
    $x2 = (str_replace('%', '', $data['analysis'][0]->Cluster_loan_PAR));
    $data['analysis_data']['Cluster_loan_PAR'] = '';
    $data['analysis_data']['color10'] = '';
    if ($x2 != '') {
        if ($x2 == 0) {
            $data['analysis_data']['Cluster_loan_PAR'] = 10;
            $data['analysis_data']['color10'] = 'green';
        }
        if ($x2 >= 1 && $x2 <= 5) {
            $data['analysis_data']['Cluster_loan_PAR'] = 7;
            $data['analysis_data']['color10'] = 'yellow';
        }
        if ($x2 >= 6 && $x2 <= 10) {
            $data['analysis_data']['Cluster_loan_PAR'] = 5;
            $data['analysis_data']['color10'] = 'grey';
        }
        if ($x2 > 10) {
            $data['analysis_data']['Cluster_loan_PAR'] = 2;
            $data['analysis_data']['color10'] = 'red';
        }
    } else {
        $data['analysis_data']['Cluster_loan_PAR'] = 0;
        $data['analysis_data']['color10'] = 'red';
    }
    //analysis 14
    $x2 = $data['analysis'][0]->Percentage_members_assisted_more_than_one;
    $data['analysis_data']['Percentage_members_assisted_more_than_one'] = '';
    $data['analysis_data']['color11'] = '';
    if ($x2 != '') {
        $data['analysis_data']['Percentage_members_assisted_more_than_one'] = (($x2 >= 75 ? 5 : ($x2 >= 50 ? 4 : ($x2 >= 25 ? 3 : 1))));
        if ($x2 >= 75) {
            $data['analysis_data']['color11'] = 'green';
        } elseif ($x2 >= 50 && $x2 <= 74) {
            $data['analysis_data']['color11'] = 'yellow';
        } elseif ($x2 >= 25 && $x2 <= 49) {
            $data['analysis_data']['color11'] = 'grey';
        } elseif ($x2 < 25) {
            $data['analysis_data']['color11'] = 'red';
        }
    } else {
        $data['analysis_data']['Percentage_members_assisted_more_than_one'] = 0;
        $data['analysis_data']['color11'] = 'red';
    }
    //analysis 15
    $x2 = $data['analysis'][0]->Percentage_Livelihood_purposes;
    $data['analysis_data']['Percentage_Livelihood_purposes'] = '';
    $data['analysis_data']['color12'] = '';
    if ($x2 != '') {
        $data['analysis_data']['Percentage_Livelihood_purposes'] = (($x2 >= 90 ? 5 : ($x2 >= 75 ? 4 : ($x2 >= 60 ? 3 : 1))));
        if ($x2 >= 90) {
            $data['analysis_data']['color12'] = 'green';
        } elseif ($x2 >= 75 && $x2 <= 89) {
            $data['analysis_data']['color12'] = 'yellow';
        } elseif ($x2 >= 60 && $x2 <= 74) {
            $data['analysis_data']['color12'] = 'grey';
        } elseif ($x2 < 60) {
            $data['analysis_data']['color12'] = 'red';
        }
    } else {
        $data['analysis_data']['Percentage_Livelihood_purposes'] = 0;
        $data['analysis_data']['color12'] = 'red';
    }
    $data['total4'] = (float) $data['analysis_data']['Repayment_rate_of_cluster_loan'] + (float) $data['analysis_data']['Cluster_loan_PAR'] + (float) $data['analysis_data']['Percentage_members_assisted_more_than_one'] + (float) $data['analysis_data']['Percentage_Livelihood_purposes'];
    $total_cr = ($data['total4'] * 100) / 30;
    $data['score3'] = $total_cr;
    $data['tcolor4'] = $total_cr >= 90 ? 'green' : ($total_cr >= 75 ? 'yellow' : ($total_cr >= 60 ? 'grey' : 'red'));

    //analysis 16

    $total_member = (int) $data['profile'][0]->total_members;
    $data['analysis_data']['Percentage_of_the_cluster'] = '';
    $data['analysis_data']['color111'] = '';

    $x2 = $data['analysis'][0]->Percentage_of_the_cluster;
    if ($x2 != '') {
        $data['analysis_data']['Percentage_of_the_cluster'] = (($x2 >= 90 ? 10 : ($x2 >= 75 ? 7 : ($x2 >= 60 ? 4 : 2))));
        $x4 = ($data['analysis_data']['Percentage_of_the_cluster'] * 100) / 10;
        $data['analysis_data']['color111'] = $x4 >= 90 ? 'green' : ($x4 >= 75 ? 'yellow' : ($x4 >= 60 ? 'grey' : 'red'));
    } else {
        $data['analysis_data']['Percentage_of_the_cluster'] = 0;
        $data['analysis_data']['color111'] = 'red';
    }

    // analysis 17
    $lsf = (int) $data['saving'][0]->members;
    $data['analysis_data']['compulsory_savings'] = '';
    $data['analysis_data']['color112'] = '';
    $count12 = '';
    if ($total_member > 0) {
        $res12 = ($lsf / $total_member) * 100;
        $count12 = round($res12, 2);
    }
    //prd($count12);
    if ($count12 != '') {
        $data['analysis_data']['compulsory_savings'] = (($count12 >= 90 ? 5 : ($count12 >= 75 ? 4 : ($count12 >= 60 ? 3 : 1))));
        $x12 = ($data['analysis_data']['compulsory_savings'] * 100) / 5;
        $data['analysis_data']['color112'] = $x12 >= 90 ? 'green' : ($x12 >= 75 ? 'yellow' : ($x12 >= 60 ? 'grey' : 'red'));
    } else {
        $data['analysis_data']['compulsory_savings'] = 0;
        $data['analysis_data']['color112'] = 'red';
    }

    $data['total5'] = (float) $data['analysis_data']['Percentage_of_the_cluster'] + (float) $data['analysis_data']['compulsory_savings'];
    $total_sv = ($data['total5'] * 100) / 15;
    $data['score4'] = $total_sv;
    $data['tcolor5'] = $total_sv >= 90 ? 'green' : ($total_sv >= 75 ? 'yellow' : ($total_sv >= 60 ? 'grey' : 'red'));

    $data['grand_total'] = $data['total1'] + $data['total2'] + $data['total3'] + $data['total4'] + $data['total5'];
    $total_grd = ($data['grand_total'] * 100) / 100;
    $data['grdcolor'] = $total_grd >= 90 ? 'green' : ($total_grd >= 75 ? 'yellow' : ($total_grd >= 60 ? 'grey' : 'red'));
    $data['show_final_status'] = $data['grdcolor'] == 'green' ? 'Minimal Risk' : ($data['grdcolor'] == 'yellow' ? ' Low Risk' : ($data['grdcolor'] == 'grey' ? 'Moderate Risk' : 'High Risk'));

    return $data;
}
function save_login_log()
{


    $user = Auth::User();
    $log = Request::header('User-Agent');
    prd($log);
    // $login_log=new LoginLog();
    // $login_log->UserID=$user->id;
    // $login_log->LoginDateTime=date('Y-m-d H:i:s');
    // $login_log->IPAddress = Request::ip();
    // $login_log->Username = $user->username;
    // $login_log->SessionID = Session::getId();
    // $login_log->Referrer = Request::server('HTTP_REFERER');
    // $login_log->ProcessID = getmypid();
    // $login_log->URL = Request::fullUrl();
    // $login_log->UserAgent = Request::header('User-Agent');
    // $login_log->save();
}

function family_status($id)
{

    $result = DB::table('family_status')
        ->select('value')
        ->where('status_id', '=', $id)
        ->first();
        return $result ? $result->value : null;
}

function getMstCommonData($flag, $common_id)
{
    return DB::table('mst_common')
        ->where('flag', $flag)
        ->where('common_id', $common_id)
        ->get();
}

function getMstCasteData($id)
{
    return DB::table('mst_caste')
        ->where('id', $id)
        ->get();
}
