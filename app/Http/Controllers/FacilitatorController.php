<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class FacilitatorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $data = [];
        $user = Auth::User();
        if($user->u_type !='M'){
            return redirect('home')->with('error', 'You do not have access to this page.');
        }
        //prd($user);
        if ($request->ajax()) {
            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');

            $query = DB::table('users as a')
                    ->select('a.*')
                    ->where('a.u_type','=','F')
                    ->where('a.parent_id','=',$user->id)
                    ->where('a.is_deleted', '=', 0);
            $total = $query->count();
            $user = $query ->orderBy('a.id')
                        ->limit($limit)
                        ->offset($start)
                        ->get()->toArray();

            foreach ($user as $users)
            {
                $row = [];
                $row[] = ++$start;
                $row[] = $users->name;
                $row[] = $users->uin;
                $row[] = $users->email;
                $row[] = $users->mobile;

                $data[] = $row;
            }
            $output = array(
                "draw"            => $request->post('draw'),
                "recordsTotal"    => $total,
                "recordsFiltered" => $total,
                "data"            => $data,
            );
            echo json_encode($output);
            exit;
        }

        return view('Facilitator.list')->with($data);
    }
}
