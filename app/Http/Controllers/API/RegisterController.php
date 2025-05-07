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


class RegisterController extends Controller
{

    public function __construct()
    {
       
    }

    public function index(Request $request)
    {
        if (isset($_POST['token']) && ($_POST['token'] != "") && isset($_POST['device']) && ($_POST['device'] != "") && isset($_POST['email']) && ($_POST['email'] != "")) {

            $tkn = trim($_POST['token']);
            $dvc = trim($_POST['device']);
            $email = trim($_POST['email']);
           
            $date = date('Y-m-d H:s:i');
            $res = "SELECT * FROM mst_device_register WHERE device_id='$dvc'";
            $query = DB::select($res);

            if (count($query) > 0) {
                DB::update('update mst_device_register set email = ?, token_id=? where device_id = ?', [$email,$tkn,$dvc]);
                // Yii::app()->db->createCommand("UPDATE mst_device_register SET email='$email', token_id='$tkn' WHERE device_id='$dvc'")->execute();
            } else {
                DB::insert('insert into mst_device_register (email, token_id, device_id, created_dt) values (?, ?, ?, ?)', [$email, $tkn, $dvc, $date]);
                // Yii::app()->db->createCommand("insert into mst_device_register set email='$email', token_id='$tkn', device_id='$dvc',created_dt='$date'")->execute();
            }

            $msg = "Device registered successfully ";
        } else {
            $msg = "Device registration fail,Incorrect Parameters";
        }
        $resAre['status'] = $msg;
        echo json_encode($resAre);
    }
    
}
