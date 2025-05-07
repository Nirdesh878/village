<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\SubSection;

class SubSectionController extends Controller
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
        $user = Auth::User();
        // prd($request->all());
        if (!empty($request->get('Search'))) {
            Session::put('sub_section_filters', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('sub_section_filters');
        }
        $session_data = Session::get('sub_section_filters');
        if (!empty($session_data)) {
            $module_id = '';
            $section_id = '';
            $sub_section_id = '';
            if (!empty($session_data['module_id'])) {
                $module_id = $session_data['module_id'];
            }
            if (!empty($session_data['section_id'])) {
                $section_id = $session_data['section_id'];
            }
            if (!empty($session_data['sub_section_id'])) {
                $sub_section_id = $session_data['sub_section_id'];
            }
        }
        // prd($session_data['module_id']);
        if ($request->ajax()) {
            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');
            $txt_search = $request->post('search')['value'];

            $query = " SELECT
                    b.module_id AS module_id,
                    c.section_id AS section_id,
                    d.sub_section_id AS sub_section_id,
                    a.language_name,
                    b.module_name,
                    c.section_name,
                    d.sub_section_name
                FROM
                mst_language AS a
                INNER JOIN mst_module AS b
                ON
                    a.language_id = b.language_id
                INNER JOIN mst_section AS c
                ON
                    b.module_id = c.module_id
                INNER JOIN mst_sub_section AS d
                ON
                    c.section_id = d.section_id
                WHERE
                    a.is_deleted = 0 and b.language_id = 1 and c.language_id = 1 and d.language_id = 1";
            if (!empty($module_id)) {
                $query .= " AND b.module_id = $module_id and c.module_id = $module_id and d.module_id = $module_id";
            }
            if (!empty($section_id)) {
                $query .= " AND  c.section_id = $section_id and d.section_id = $section_id ";
            }
            if (!empty($sub_section_id)) {
                $query .= " AND d.sub_section_id = $sub_section_id";
            }

            if ($txt_search != '') {
                $query .= " AND (c.section_name like '%$txt_search%' ";
                $query .= " or d.sub_section_name like '%$txt_search%' ";
                $query .= " or b.module_name like '%$txt_search%' )";
            }

            $labels = DB::select($query);
            $total = count($labels);
            $query .= " ORDER BY
                         b.module_id ASC , c.section_id ASC ,d.sub_section_id ASC
                    LIMIT $limit OFFSET $start";
            $labels = DB::select($query);
            // prd($labels);
            foreach ($labels as $res) {
                $row = [];
                $row[] = ++$start;
                // $row[] = $res->language_name;
                $row[] = $res->module_name;
                $row[] = $res->section_name;
                $row[] = $res->sub_section_name;

                $btns = '';
                $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('subsection.edit',  $res->sub_section_id) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';

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
        return view('subsection.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $view = 'subsection.edit';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            try {
                $validation_arr = [
                    'sub_section_name' => ['required']
                ];
                $validator = Validator::make($request->all(), $validation_arr);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request) {

                    $user = Auth::User();

                    // sub section upadtes
                    $sub_section_ids = $request->post('sub_section_ids');
                    $sub_section_name = $request->post('sub_section_name');
                    foreach ($sub_section_ids as $key => $res) {
                        $sub_section_details = SubSection::find($res);
                        $sub_section_details->sub_section_name = $sub_section_name[$key];
                        $result = $sub_section_details->save();
                    }

                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('subsection')->with(['message' => 'Sub Section Updates successfully.']);
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

        $data['sub_section'] = DB::table('mst_sub_section')
            ->select('*')
            ->where('is_deleted', '=', 0)
            ->where('sub_section_id', '=', $id)
            ->get()->toArray();

        // prd($data);
        return view('subsection.edit')->with($data);
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
