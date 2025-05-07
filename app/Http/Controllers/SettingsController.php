<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
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

        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
        if ($request->ajax()) {

            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');
            $txt_search = $request->post('search')['value'];
            $query = DB::table('settings as a');
            if($txt_search!='')
            {
                $query->Where(function ($query) use($txt_search) {
                    $query->orwhere('a.name', 'like', '%'.$txt_search.'%');
                });

            }
            $total = $query->where('a.is_deleted', '=', 0)->count();

            $query = DB::table('settings as a');
            if($txt_search!='')
            {
                $query->Where(function ($query) use($txt_search) {
                    $query->orwhere('a.name', 'like', '%'.$txt_search.'%');
                });

            }
            $settings = $query->where('a.is_deleted', '=', 0)
                        ->orderBy('a.created_at','DESC')
                        ->limit($limit)
                        ->offset($start)
                        ->get()->toArray();

            foreach ($settings as $setting)
            {

                $row = [];
                $row[] = ++$start;
                $row[] = $setting->name;
                $row[] = $setting->value;

                $btns= '';

                $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="'. route('settings.edit', $setting->id).'" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                // $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $setting->id . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';

                $row[] = $btns;

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
        return view('settings.list')->with($data);
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
        $view = 'settings.add';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            //prd($request->all());
            try {
                $validation_arr = [
                    'name'=>['required'],
                    'value'=>['required'],
                ];
                //prd($validation_arr);
                $validator = Validator::make($request->all(), $validation_arr);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                //prd('ssew');
                $result = DB::transaction(function () use ($request) {

                $user = Auth::User();

                $user_details = new Settings();
                $user_details->name = $request->post('name');
                $user_details->value = $request->post('value');
                $user_details->created_by = $user->id;
                $user_details->created_at = date('Y-m-d H:i:s');

                $result = $user_details->save();

                if ($result) {
                    return true;
                }
            });
                if ($result) {
                    return redirect('settings')->with(['message' => 'Settings saved successfully.']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $setting)
    {
        $data['edit'] = 1 ;
        return view('settings.edit', compact('setting'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $setting)
    {
        $view = 'settings.edit';

        /* Check post either add or update */
        if ($request->isMethod('PATCH')) {//prd($request->all());
            try {
                $validation_arr = [
                    'name' => ['required'],
                    'value'=>['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request , $setting) {


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
        }
        catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }
}
