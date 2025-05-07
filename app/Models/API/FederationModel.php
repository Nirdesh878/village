<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Response;

class FederationModel extends Model
{
    public static function index($username = NULL)
    {
        try {
            $data['users'] = DB::table('users as a')
                ->select('a.*')
                ->where('a.is_deleted', '=', '0')
                ->where('a.email', $username)
                ->get()->toArray();

            return $data;
        } catch (\Exception $e) {
            echo $e->getMessage();

        }
    }
}
