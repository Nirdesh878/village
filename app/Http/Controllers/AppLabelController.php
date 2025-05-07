<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Module;
use App\Models\Section;
use App\Models\SubSection;
use App\Models\AppLabel;
use App\Models\AppLabelLanguage;




class AppLabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $user = Auth::User();
        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
        // prd($request->all());
        if (!empty($request->get('Search'))) {
            Session::put('app_label_filters', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('app_label_filters');
        }
        $session_data = Session::get('app_label_filters');
        if (!empty($session_data)) {
            $module_id = '';
            $section_id = '';
            $sub_section_id = '';
            $app_label_id = '';
            if (!empty($session_data['module_id'])) {
                $module_id = $session_data['module_id'];
            }
            if (!empty($session_data['section_id'])) {
                $section_id = $session_data['section_id'];
            }
            if (!empty($session_data['sub_section_id'])) {
                $sub_section_id = $session_data['sub_section_id'];
            }
            if (!empty($session_data['app_label_id'])) {
                $app_label_id = $session_data['app_label_id'];
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
                    e.app_label_id AS app_label_id,
                    a.language_name,
                    b.module_name,
                    c.section_name,
                    d.sub_section_name,
                    e.app_label_text
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
                INNER JOIN mst_app_label AS e
                ON
                    d.sub_section_id = e.sub_section_id

                WHERE
                    a.is_deleted = 0 and b.language_id = 1 and c.language_id = 1 and d.language_id = 1 and e.language_id = 1 ";
            if (!empty($module_id)) {
                $query .= "AND b.module_id = $module_id and c.module_id = $module_id and d.module_id = $module_id and e.module_id = $module_id";
            }
            if (!empty($section_id)) {
                $query .= " AND  c.section_id = $section_id and d.section_id = $section_id and e.section_id = $section_id";
            }
            if (!empty($sub_section_id)) {
                $query .= " AND d.sub_section_id = $sub_section_id and e.sub_section_id = $sub_section_id";
            }
            if (!empty($app_label_id)) {
                $query .= " AND e.app_label_id = $app_label_id";
            }

            if ($txt_search != '') {
                $query .= " AND (e.app_label_text like '%$txt_search%' ";
                $query .= " or c.section_name like '%$txt_search%' ";
                $query .= " or d.sub_section_name like '%$txt_search%' ";
                $query .= " or b.module_name like '%$txt_search%' )";
            }
            $labels = DB::select($query);
            $total = count($labels);
            $query .= " ORDER BY
                         b.module_id ASC , c.section_id ASC ,d.sub_section_id ASC , e.sub_section_id ASC
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
                $row[] = $res->app_label_text;

                $btns = '';
                $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('applabel.edit', $res->app_label_id) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';

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
        return view('applabel.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];

        return view('settings.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // prd($request->all());
        $view = 'applabel.edit';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            try {
                $validation_arr = [
                    'app_label_name' => ['required'],
                    'app_label_text' => ['required'],
                ];
                $validator = Validator::make($request->all(), $validation_arr);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request) {

                    $user = Auth::User();

                    // app label upadtes
                    $app_label_ids = $request->post('app_label_ids');
                    $app_label_name = $request->post('app_label_name');
                    foreach ($app_label_ids as $key => $res) {
                        $app_label_details = AppLabel::find($res);
                        $app_label_details->app_label_text = $app_label_name[$key];
                        $result = $app_label_details->save();
                    }

                    // app label language upadtes
                    $app_label_lang_ids = $request->post('app_label_lang_ids');
                    $app_label_text = $request->post('app_label_text');
                    foreach ($app_label_lang_ids as $key => $res) {
                        $app_label_lang_details = AppLabelLanguage::find($res);
                        $app_label_lang_details->app_label_text = $app_label_text[$key];
                        $result = $app_label_lang_details->save();
                    }



                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('applabel')->with(['message' => 'Labels Updates successfully.']);
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
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        $data = [];
        return view('applabel.list')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $data['app_label'] = DB::table('mst_app_label')
            ->select('*')
            ->where('is_deleted', '=', 0)
            ->where('app_label_id', '=', $id)
            ->get()->toArray();
        $data['app_label_language'] = DB::table('mst_app_label_language')
            ->select('*')
            ->where('is_deleted', '=', 0)
            ->where('app_label_id', '=', $id)
            ->get()->toArray();

        // prd($data);
        return view('applabel.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $view = 'settings.edit';

        /* Check post either add or update */
        if ($request->isMethod('PATCH')) {
            try {
                $validation_arr = [
                    'name' => ['required'],
                    'value' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request, $setting) {

                    $loginuser = Auth::User();
                    $user_details = Settings::find($setting->id);

                    $user_details->name = $request->post('name');
                    $user_details->value = $request->post('value');
                    $user_details->updated_by = $loginuser->id;
                    $user_details->updated_at = date('Y-m-d H:i:s');

                    $result = $user_details->save();
                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('settings')->with(['message' => 'Setting updated successfully.']);
                }
            } catch (\Exception $e) {
                prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        return view($view);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        try {
            if ($settings->id != '') {
                $user_details = Settings::find($settings->id);
                $user_details->is_deleted = 1;
                $user_details->save();

                $data['message'] = 'Setting Deleted Successfully';
                echo json_encode($data);
            } else {
                $data['message'] = 'Invalid Request';
                echo json_encode($data);
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function module_index(Request $request)
    {
        $data = [];
        $user = Auth::User();
        // prd($request->all());
        if (!empty($request->get('Search'))) {

            Session::put('module_filters', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('module_filters');
        }
        $session_data = Session::get('module_filters');

        if (!empty($session_data)) {
            $module_id = $session_data['module_id'];
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
                $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . url('module_edit', $res->module_id) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';

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

    public function module_edit($id)
    {


        $data['module'] = DB::table('mst_module')
            ->select('*')
            ->where('is_deleted', '=', 0)
            ->where('module_id', '=', $id)
            ->get()->toArray();
        // prd($data['module']);
        // $data['section'] = DB::table('mst_section')
        //     ->select('*')
        //     ->where('is_deleted', '=', 0)
        //     ->where('section_id', '=', $edit_data['section_id'])
        //     ->get()->toArray();
        // $data['sub_section'] = DB::table('mst_sub_section')
        //     ->select('*')
        //     ->where('is_deleted', '=', 0)
        //     ->where('sub_section_id', '=', $edit_data['sub_section_id'])
        //     ->get()->toArray();
        // $data['app_label'] = DB::table('mst_app_label')
        //     ->select('*')
        //     ->where('is_deleted', '=', 0)
        //     ->where('app_label_id', '=', $labels)
        //     ->get()->toArray();
        // $data['app_label_language'] = DB::table('mst_app_label_language')
        //     ->select('*')
        //     ->where('is_deleted', '=', 0)
        //     ->where('app_label_id', '=', $labels)
        //     ->get()->toArray();

        // prd($data);
        return view('module.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function module_update(Request $request)
    {
        $module_ids = $request->post('module_ids');
        $view = "module.module_index";
        // prd($request->all());
        // $module_ids = $request->post('module_ids');
        // prd($module_ids);
        /* Check post either add or update */
        if ($request->isMethod('PUT')) {
            try {
                $validation_arr = [
                    'module_name' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request) {

                    $loginuser = Auth::User();

                    // Module updates
                    $module_ids = $request->post('module_ids');
                    $module_name = $request->post('module_name');
                    // prd($module_name);
                    foreach ($module_ids as $key => $res) {
                        $module_details = Module::find($res);
                        $module_details->module_name = $module_name[$key];
                        // $module_details->updated_by = $loginuser->id;
                        $module_details->updated_at = date('Y-m-d H:i:s');

                        $result = $module_details->save();
                    }


                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('module_index')->with(['message' => 'Module updated successfully.']);
                }
            } catch (\Exception $e) {
                prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        $data['module'] = DB::table('mst_module')
            ->select('*')
            ->where('is_deleted', '=', 0)
            ->where('language_id', '=', 1)
            ->get()->toArray();
        // prd($data);

        return view('module.list')->with($data);
    }

    public function section_index(Request $request)
    {
        $data = [];
        $user = Auth::User();
        // prd($request->all());
        if (!empty($request->get('Search'))) {
            Session::put('section_filters', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('section_filters');
        }
        $session_data = Session::get('section_filters');
        if (!empty($session_data)) {
            $module_id = $session_data['module_id'];
            $section_id = $session_data['section_id'];
        }
        // prd($session_data['module_id']);
        if ($request->ajax()) {
            $start = (int) $request->post('start');
            $limit = (int) $request->post('length');
            $txt_search = $request->post('search')['value'];

            $query = " SELECT
                    b.module_id AS module_id,
                    c.section_id AS section_id,
                    a.language_name,
                    b.module_name,
                    c.section_name
                FROM
                mst_language AS a
                INNER JOIN mst_module AS b
                ON
                    a.language_id = b.language_id
                INNER JOIN mst_section AS c
                ON
                    b.module_id = c.module_id

                WHERE
                    a.is_deleted = 0 and b.language_id = 1 and c.language_id = 1";

            if (!empty($module_id)) {
                $query .= " AND b.module_id = $module_id ";
            }

            if (!empty($section_id)) {
                $query .= " AND  c.section_id = $section_id ";
            }

            $labels = DB::select($query);
            $total = count($labels);
            $query .= " ORDER BY
                         c.section_id ASC
                    LIMIT $limit OFFSET $start";
            $labels = DB::select($query);
            // prd($labels);
            foreach ($labels as $res) {
                $row = [];
                $row[] = ++$start;
                // $row[] = $res->language_name;
                $row[] = $res->module_name;
                $row[] = $res->section_name;

                $btns = '';
                $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . url('section_edit', $res->section_id) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';

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
        return view('section.list')->with($data);
    }

    public function section_edit($id)
    {

        // $data['module'] = DB::table('mst_module')
        //     ->select('*')
        //     ->where('is_deleted', '=', 0)
        //     ->where('module_id', '=', $id)
        //     ->get()->toArray();
        $data['section'] = DB::table('mst_section')
            ->select('*')
            ->where('is_deleted', '=', 0)
            ->where('section_id', '=', $id)
            ->get()->toArray();




        return view('section.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function section_update(Request $request)
    {
        $view = "section.section_index";
        // prd($request->all());
        // $module_ids = $request->post('module_ids');
        // prd($module_ids);
        /* Check post either add or update */
        if ($request->isMethod('PUT')) {
            try {
                $validation_arr = [
                    'module_name' => ['required'],
                    'section_name' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request) {

                    $loginuser = Auth::User();

                    // Module updates
                    $module_ids = $request->post('module_ids');
                    $module_name = $request->post('module_name');
                    // prd($module_name);
                    foreach ($module_ids as $key => $res) {
                        $module_details = Module::find($res);
                        $module_details->module_name = $module_name[$key];
                        // $module_details->updated_by = $loginuser->id;
                        $module_details->updated_at = date('Y-m-d H:i:s');

                        $result = $module_details->save();
                    }

                    // section upadtes
                    $section_ids = $request->post('section_ids');
                    $section_name = $request->post('section_name');
                    foreach ($section_ids as $key => $res) {
                        $section_details = Section::find($res);
                        $section_details->section_name = $section_name[$key];
                        $result = $section_details->save();
                    }


                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('section_index')->with(['message' => 'Section updated successfully.']);
                }
            } catch (\Exception $e) {
                prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        $data['module'] = DB::table('mst_module')
            ->select('*')
            ->where('is_deleted', '=', 0)
            ->where('language_id', '=', 1)
            ->get()->toArray();
        // prd($data);

        return view('section.list')->with($data);
    }
}
