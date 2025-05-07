<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\DataBackup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Facades\Session;


class DataBackupController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->curdate = Carbon::now()->format('d-m-Y');
    }

    public function index(Request $request)
    {
        $data = [];
        $user = Auth::User();


        if ($request->ajax()) {
            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');
            $txt_search = $request->post('search')['value'];

            $query = " SELECT * FROM data_backup";
            $backup = DB::select($query);
            $total = count($backup);
            $query .= " ORDER BY
                    updated_at
                DESC,id DESC
                LIMIT $limit OFFSET $start";
            $backup = DB::select($query);

            foreach ($backup as $res) {


                $row = [];
                $row[] = ++$start;
                $row[] = $res->user_name;
                $row[] = $res->file_name;
                $row[] = change_date_month_name_char($res->uploaded_time);
                $btns = '';
                $btns .= '<a href="' . $res->path . '" class="btn btn-success  btn-link btn-sm" rel="tooltip" title="Download" data-original-title="Download" style="padding:0px;margin:0px;"><i class="feather icon-download"></i></a>';

                $row[] = $btns;
                $data[] = $row;
            }

            $output = array(
                "draw" => $request->post('draw'),
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $data,
            );
            echo json_encode($output);
            exit;
        }
        return view('DataBackup.list')->with($data);
    }






}
