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

class HistoryController extends Controller
{

    public function __construct()
    {
    }
    public function authuser($params)
    {
       //prd($params);
        $mst_users = DB::table('users')
            ->where('email', $params['email'])
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
       
        if (!empty($mst_users)) {
            $hashed = Hash::make($params['password']);
            if (Hash::check($params['password'], $mst_users[0]->password)) {
                return 1;
            } else {
                return 0;
            }
        }
       
    }
    public function index(Request $request)
    {
        $SqlLib=new SqlLibController();
        $resAre = array();
        if (isset($_POST['email']) && trim($_POST['email']) != '' && isset($_POST['pwd']) && trim($_POST['pwd']) != '') {

            $args['email'] = $request->post('email');
            $args['password'] = $request->post('pwd');

            if ($this->authuser($args))
            {
                //die('kkk');
                $q1 = DB::table('users')
                        ->where('email', $args['email'])
                        ->where('u_type', '=', 'F')
                        ->where('status', '=', 'A')
                        ->where('is_deleted', '=', 0)
                        ->get()->toArray();
                
                //prd($q1[0]->uin);
                if (count($q1) > 0) {
                    $uin=$q1[0]->uin;
                    
                    $resAre=$SqlLib->Userhistory($uin);
                    prd($resAre);
                }
            }
            else
            {
                return $this->sendError('Unauthorized Access.');
            }
          }
         
        echo json_encode($resAre); 
    }
    
}
