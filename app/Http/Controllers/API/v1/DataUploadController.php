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
use App\Http\Controllers\API\v1\SqlLibController;
use App\Models\DataBackup;
use App\Models\User;


class DataUploadController extends Controller
{

    public function __construct()
    {
    }
    public function authuser($params)
    {
       $mst_users = DB::table('users')
       ->where('email', $params['email'])
       ->where('u_type', '=', 'F')
       ->where('status', '=', 'A')
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
        // prd($request->all());
        if ($request->isMethod('post')) {
            try {
                $args['email'] = $request->post('email');
                $args['password'] = $request->post('password');
                if($this->authuser($args)){

                    if (!$request->hasFile('upload_file')) {
                        return response()->json(['upload_file_not_found'], 400);
                    }

                    $allowedFileExtension = ['db']; // You can extend file types as needed
                    $file = $request->file('upload_file');
                    $extension = $file->getClientOriginalExtension();

                    // Check if the file has an allowed extension
                    if (!in_array(strtolower($extension), $allowedFileExtension)) {
                        return response()->json(['invalid_file_format'], 422);
                    }

                    // Generate a new filename with a timestamp
                    date_default_timezone_set('Asia/Kolkata'); // Set the time zone to IST
                    $filename = date('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('assets/databackup');
                    $file->move($destinationPath, $filename);

                    // File path for download
                    $filePath = url('assets/databackup/' . $filename);

                    // Insert file details into the database using DataBackup model
                    $backup = new DataBackup();
                    $backup->file_name = $filename;
                    $backup->uploaded_time = now();
                    $backup->created_at = now();
                    $backup->user_id = $request->user_id;
                    $backup->user_name = $request->user_name;
                    $backup->path = $filePath; // Save the file path
                    $backup->save();

                    // return response()->json(['file_uploaded'], 200);
                    return response()->json([
                        'success' => true,
                        'mssg' => 'File Uploaded Succesfully',
                    ], 200);
                } else {
                    return $this->sendError('Unauthorized Access.');
                }

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['invalid_data_request'], 400);
        }
    }

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        $response = $this->remove_element_by_key($response);
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




}
