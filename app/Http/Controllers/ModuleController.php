<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Module;


class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $user = Auth::User();

        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
        if (!empty($request->get('Search'))) {

            Session::put('module_filters', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('module_filters');
        }
        $session_data = Session::get('module_filters');

        if (!empty($session_data)) {
            $module_id = '';
            if (!empty($session_data['module_id'])) {
                $module_id = $session_data['module_id'];
            }
        }
        // prd($module_id);
        if ($request->ajax()) {
            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');
            $txt_search = $request->post('search')['value'];

            $query = " SELECT
                    b.module_id AS module_id,
                    a.language_name,
                    b.module_name

                FROM
                mst_language AS a
                INNER JOIN mst_module AS b
                ON
                    a.language_id = b.language_id
                WHERE
                    a.is_deleted = 0 and b.language_id = 1 ";
            if (!empty($module_id)) {
                $query .= " AND b.module_id = $module_id ";
            }

            if ($txt_search != '') {
                $query .= " AND (b.module_name like '%$txt_search%' )";
            }

            $labels = DB::select($query);
            $total = count($labels);
            $query .= " ORDER BY
                         b.module_id ASC
                    LIMIT $limit OFFSET $start";
            $labels = DB::select($query);
            // prd($labels);
            foreach ($labels as $res) {
                $row = [];
                $row[] = ++$start;
                // $row[] = $res->language_name;
                $row[] = $res->module_name;


                $btns = '';
                $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('module.edit', $res->module_id) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';

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
        $data['module'] = DB::table('mst_module')
            ->select('*')
            ->where('is_deleted', '=', 0)
            ->where('language_id', '=', 1)
            ->get()->toArray();
        // prd($data);
        return view('module.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $view = 'module.edit';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            try {
                $validation_arr = [
                    'module_name' => ['required'],
                ];
                $validator = Validator::make($request->all(), $validation_arr);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request) {

                    $user = Auth::User();

                    // Module updates
                    $module_ids = $request->post('module_ids');
                    $module_name = $request->post('module_name');
                    foreach ($module_ids as $key => $res) {
                        $module_details = Module::find($res);
                        $module_details->module_name = $module_name[$key];
                        $result = $module_details->save();
                    }


                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('module')->with(['message' => 'Module Updates successfully.']);
                }
            } catch (\Exception $e) {
                prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        return view($view);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['module'] = DB::table('mst_module')
        ->select('*')
        ->where('is_deleted', '=', 0)
        ->where('module_id', '=', $id)
        ->get()->toArray();

        return view('module.edit')->with($data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
