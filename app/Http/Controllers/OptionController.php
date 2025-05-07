<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
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


            $query = DB::table('rating_mst_qam_set as a')
                        ->join('rating_mst_category as b','a.mst_category_id', '=', 'b.mst_id')
                        ->join('rating_mst_ques_list as c','a.mst_ques_id', '=', 'c.mst_id')
                        ->join('rating_mst_sub_category as d','a.mst_sub_category_id', '=', 'd.mst_id');
            if($txt_search!='')
            {
                $query->Where(function ($query) use($txt_search) {
                    $query->orwhere('a.mst_id', 'like', '%'.$txt_search.'%')
                          ->orwhere('b.mst_cat_name', 'like', '%'.$txt_search.'%')
                          ->orwhere('c.mst_ques_name', 'like', '%'.$txt_search.'%')
                          ->orwhere('a.mst_ans_name', 'like', '%'.$txt_search.'%')
                          ->orwhere('a.mst_description', 'like', '%'.$txt_search.'%')
                          ->orwhere('d.mst_subcat_name', 'like', '%'.$txt_search.'%');
                });

            }
            $ttl = $query->where('a.is_deleted', '=', 0)->whereRaw("(a.mst_ans_name!='' && a.mst_ans_name is not NULL)")->groupBy(['a.mst_category_id','a.mst_sub_category_id','a.mst_ques_id']) ->get()->toArray();
            $total=count($ttl);
            $query = DB::table('rating_mst_qam_set as a')
             ->join('rating_mst_category as b','a.mst_category_id', '=', 'b.mst_id')
                        ->join('rating_mst_ques_list as c','a.mst_ques_id', '=', 'c.mst_id')
                        ->join('rating_mst_sub_category as d','a.mst_sub_category_id', '=', 'd.mst_id')
                    ->select('a.*','b.mst_cat_name','d.mst_subcat_name','c.mst_ques_name',DB::raw("GROUP_CONCAT(ifnull(a.mst_ans_name,'') ORDER BY a.mst_id) as mst_ans_name1,GROUP_CONCAT(a.mst_status ORDER BY a.mst_id) as mst_status1,GROUP_CONCAT(a.mst_point ORDER BY a.mst_id) as mst_point1"));
            if($txt_search!='')
            {
                $query->Where(function ($query) use($txt_search) {
                    $query->orwhere('a.mst_id', 'like', '%'.$txt_search.'%')
                          ->orwhere('b.mst_cat_name', 'like', '%'.$txt_search.'%')
                           ->orwhere('c.mst_ques_name', 'like', '%'.$txt_search.'%')
                           ->orwhere('a.mst_ans_name', 'like', '%'.$txt_search.'%')
                          ->orwhere('a.mst_description', 'like', '%'.$txt_search.'%')
                          ->orwhere('d.mst_subcat_name', 'like', '%'.$txt_search.'%');
                });

            }
            $Options = $query->where('a.is_deleted', '=', 0)
                        ->whereRaw("(a.mst_ans_name!='' && a.mst_ans_name is not NULL)")
                        ->orderBy('a.mst_id')
                        ->limit($limit)
                        ->offset($start)
                        ->groupBy(['a.mst_category_id','a.mst_sub_category_id','a.mst_ques_id'])
                        ->get()->toArray();
            $query = DB::getQueryLog();

            foreach ($Options as $Option)
            {
                $td_data='<br>';
                 $i=0;
                $row = [];
                $row[] = ++$start;
                $row[] = $Option->mst_cat_name;
                $row[] = $Option->mst_subcat_name;
                $row[] = $Option->mst_ques_name;
                foreach (explode(',', $Option->mst_ans_name1) as $key => $value) {

                   $td_data.=($i+1).". ".(!empty($value)>0 ? $value : '') ." = ".(!empty(explode(',', $Option->mst_point1)[$i])>0 ? explode(',', $Option->mst_point1)[$i] : '')."  ".(!empty(explode(',', $Option->mst_status1)[$i])>0 ? (explode(',', $Option->mst_status1)[$i]== 'A' ? '<span class="status-active">Active</span>' : '<span class="status-inactive">InActive</span>') : '')."<br><br>";
                   $i++;
                }
                $row[]=$td_data;
                $btns= '';

                $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="'. route('option.edit', array($Option->mst_category_id,'mst_sub_category_id'=>$Option->mst_sub_category_id,'mst_ques_id'=>$Option->mst_ques_id)).'" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete('.$Option->mst_category_id.','.$Option->mst_sub_category_id.','.$Option->mst_ques_id.')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';

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
        return view('option.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['category']=DB::table('rating_mst_category as a')
                                ->select('a.*')
                                ->where('a.is_deleted','=',0)->get()->toArray();
        return view('option.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $view = 'option.add';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            //prd($request->all());
            try {
                $validation_arr = [
                    'mst_category_id' => ['required'],
                    'mst_sub_category_id' => ['required'],
                    'mst_ques_id' => ['required'],
                    'mst_description' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $result = DB::transaction(function () use ($request) {

                $user = Auth::User();
                $mst_ans_name = $request->post('mst_ans_name');
                $mst_point = $request->post('mst_point');
                $mst_status = $request->post('mst_status');
                for ($i=0; $i <count($mst_ans_name) ; $i++) {
                    $user_details = new Option();
                    $user_details->mst_category_id = $request->post('mst_category_id');
                $user_details->mst_sub_category_id = $request->post('mst_sub_category_id');
                $user_details->mst_ques_id = $request->post('mst_ques_id');
                $user_details->mst_description = $request->post('mst_description');
                    $user_details->mst_ans_name = !empty($mst_ans_name[$i])>0 ? $mst_ans_name[$i] : '';
                $user_details->mst_point = !empty($mst_point[$i])>0 ? $mst_point[$i] : '';
                $user_details->mst_status = $mst_status[$i];
                $user_details->created_by = $user->id;
                $user_details->mst_qam_ad = date('Y-m-d H:i:s');
                $user_details->created_at = date('Y-m-d H:i:s');

                $result = $user_details->save();
                }


                if ($result) {
                    return true;
                }
            });
                if ($result) {
                    return redirect('option')->with(['message' => 'Option saved successfully.']);
                }
            } catch (\Exception $e) {
                // /prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        return view($view);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function show(Option $option)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function edit($option, Request $request)
    {
        $data['edit'] = 1 ;
        $edit_data=($request->all());
        //prd($edit_data);
        $data['option'] = DB::table('rating_mst_qam_set as a')
             ->join('rating_mst_category as b','a.mst_category_id', '=', 'b.mst_id')
                        ->join('rating_mst_ques_list as c','a.mst_ques_id', '=', 'c.mst_id')
                        ->join('rating_mst_sub_category as d','a.mst_sub_category_id', '=', 'd.mst_id')
                    ->select('a.*','b.mst_cat_name','d.mst_subcat_name','c.mst_ques_name',DB::raw("GROUP_CONCAT(ifnull(a.mst_ans_name,'') ORDER BY a.mst_id) as mst_ans_name1,GROUP_CONCAT(a.mst_status ORDER BY a.mst_id) as mst_status1,GROUP_CONCAT(a.mst_point ORDER BY a.mst_id) as mst_point1,GROUP_CONCAT(a.mst_id ORDER BY a.mst_id) as mst_id1"))
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.mst_category_id', '=', $option)
                    ->where('a.mst_sub_category_id', '=', $edit_data['mst_sub_category_id'])
                    ->where('a.mst_ques_id', '=', $edit_data['mst_ques_id'])
                        ->orderBy('a.mst_id')
                        ->groupBy(['a.mst_category_id','a.mst_sub_category_id','a.mst_ques_id'])
                        ->get()->toArray()[0];
        //prd($data['option']);exit();
         $data['category']=DB::table('rating_mst_category as a')
                                ->select('a.*')
                                ->where('a.is_deleted','=',0)->get()->toArray();
        return view('option.edit', compact('option'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option $option)
    {
        $view = 'option.edit';

        /* Check post either add or update */
        if ($request->isMethod('PATCH')) {//prd($request->all());
            try {
                $validation_arr = [
                    'mst_category_id' => ['required'],
                    'mst_sub_category_id' => ['required'],
                    'mst_ques_id' => ['required'],
                    'mst_description' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $result = DB::transaction(function () use ($request , $option) {
                $loginuser = Auth::User();
               $mst_ans_name = $request->post('mst_ans_name');
               $mst_id = $request->post('mst_id');
                $mst_point = $request->post('mst_point');
                $mst_status = $request->post('mst_status');
                 Option::where([['mst_category_id', '=', $request->post('mst_category_id')],['mst_sub_category_id', '=', $request->post('mst_sub_category_id')],['mst_ques_id', '=', $request->post('mst_ques_id')]])->update(['is_deleted' => 1,'mst_status'=>'I']);
                 //prd($mst_id);exit();
                for ($i=0; $i <count($mst_ans_name) ; $i++) {
                    if ($mst_id[$i] > 0) {

                    $user_details = Option::find($mst_id[$i]);
                    $user_details->updated_by = $loginuser->id;
                    $user_details->is_deleted = 0;
                    $user_details->mst_qam_ud = date('Y-m-d H:i:s');
                    $user_details->updated_at = date('Y-m-d H:i:s');
                    }
                    else{
                        $user_details = new Option();
                        $user_details->created_by = $loginuser->id;
                        $user_details->mst_qam_ad = date('Y-m-d H:i:s');
                        $user_details->created_at = date('Y-m-d H:i:s');
                    }
                    $user_details->mst_category_id = $request->post('mst_category_id');
                $user_details->mst_sub_category_id = $request->post('mst_sub_category_id');
                $user_details->mst_ques_id = $request->post('mst_ques_id');
                $user_details->mst_description = $request->post('mst_description');
                    $user_details->mst_ans_name = !empty($mst_ans_name[$i])>0 ? $mst_ans_name[$i] : '';
                $user_details->mst_point = !empty($mst_point[$i])>0 ? $mst_point[$i] : '';
                $user_details->mst_status = $mst_status[$i];


                $result = $user_details->save();
                }
                if ($result) {
                    return true;
                }
            });
                if ($result) {
                    return redirect('option')->with(['message' => 'Option updated successfully.']);
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
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function destroy($option,Request $request)
    {
        try {
            if ($option != '') {
               Option::where([['mst_category_id', '=', explode(',', $option)[0]],['mst_sub_category_id', '=', explode(',', $option)[1]],['mst_ques_id', '=', explode(',', $option)[2]]])->update(['is_deleted' => 1,'mst_status'=>'I']);

                $data['message'] = 'Option Deleted Successfully';
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
