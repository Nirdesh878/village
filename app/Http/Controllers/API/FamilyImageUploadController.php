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
use App\Models\FamilyUpload;

class FamilyImageUploadController extends Controller
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
        if ($request->isMethod('post')) {
           try {
                    if (!$request->hasFile('image_file')) {
                        return response()->json(['upload_file_not_found'], 400);
                    }

                    $allowedfileExtension = ['JPEG', 'jpeg', 'jpg', 'png'];
                    $files = $request->file('image_file');
                    $errors = [];
                    $media_ext = $files->getClientOriginalName();
                    $destinationPath = ('./assets/uploads/');
                    $files->move($destinationPath,$media_ext);
                    return response()->json(['file_uploaded'], 200);
            }
            catch(\Exception $e) {
                die($e->getMessage());
                throw new HttpException(500, $e->getMessage());
            }
        } else {
            return $this->sendError('Invalid data request.');
        }
    }
}
