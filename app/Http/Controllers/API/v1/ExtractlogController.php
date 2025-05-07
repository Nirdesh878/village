<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;


class ExtractlogController extends Controller
{

    public function __construct()
    {
        // echo url('/api/userauth');
    }

    public function authuser($params)
    {

        $mst_users = DB::table('users')
            ->where('email', $params['email'])
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        if (!empty($mst_users)) {
            // prd($mst_users[0]->password);
            $hashed = Hash::make($params['password']);
            //echo($hashed);
            if (Hash::check($params['password'], $mst_users[0]->password)) {
                //die('hi');
                return 1;
            } else {
                //die('bye');
                return 0;
            }
        }
    }

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response['data'], 200);
    }

    public function sendError($error, $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        return response()->json($response['message'], $code);
    }

    public function index(Request $request)
    {
        //die('kkk');
        if ($request->isMethod('POST')) {
            try {
                    $response_msg = 'failed';
                    if(isset($_REQUEST['agninsID']) && trim($_REQUEST['agninsID']) > 0){
                        {
                            $asgtkn   = trim($_REQUEST['agninsID']);
                            //$data     = trim($request->post('data'));
                        }
                        // $args['data']     = $request->post('data');
                        // $data = json_decode($args['data'], TRUE);

                        if ($asgtkn > 0) { // check array count
                            $log_Sql = "SELECT data FROM sync_data WHERE asgtkn = '$asgtkn' ORDER BY id DESC limit 1";
                            $log_row = DB::select($log_Sql);
                            if (!empty($log_row)) {

                            $fname = 'familylog_'.date('YmdHis');
                            $file = $fname.".txt";
                            $txt = fopen($file, "w") or die("Unable to open file!");
                            fwrite($txt, $log_row[0]['data']);
                            fclose($txt);
                            header('Content-Description: File Transfer');
                            header('Content-Disposition: attachment; filename='.basename($file));
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
                            header('Content-Length: ' . filesize($file));
                            header("Content-Type: text/plain");readfile($file);
                            if (file_exists($file)){unlink($file);}

                            }
                            $response_msg = 'success';
                        }
                    }
                } catch (\Exception $e) {
                die($e->getMessage());
                throw new HttpException(500, $e->getMessage());
                }
        } else {
            return $this->sendError('Invalid data request.');
        }
    }

}
