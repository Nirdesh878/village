<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
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

            $query = DB::table('rating_mst_sub_category as a')
                        ->join('rating_mst_category as b','a.mst_category_id', '=', 'b.mst_id');
            if($txt_search!='')
            {
                $query->Where(function ($query) use($txt_search) {
                    $query->orwhere('a.mst_id', 'like', '%'.$txt_search.'%')
                          ->orwhere('a.mst_subcat_name', 'like', '%'.$txt_search.'%')
                          ->orwhere('b.mst_cat_name', 'like', '%'.$txt_search.'%');
                });

            }
            $total = $query->where('a.is_deleted', '=', 0)->count();

            $query = DB::table('rating_mst_sub_category as a')
             ->join('rating_mst_category as b','a.mst_category_id', '=', 'b.mst_id')
                    ->select('a.*','b.mst_cat_name');
            if($txt_search!='')
            {
                $query->Where(function ($query) use($txt_search) {
                    $query->orwhere('a.mst_id', 'like', '%'.$txt_search.'%')
                          ->orwhere('b.mst_cat_name', 'like', '%'.$txt_search.'%')
                          ->orwhere('a.mst_subcat_name', 'like', '%'.$txt_search.'%');
                });

            }
            $SubCategories = $query->where('a.is_deleted', '=', 0)
                        ->orderBy('a.mst_id')
                        ->limit($limit)
                        ->offset($start)
                        ->get()->toArray();

            foreach ($SubCategories as $Category)
            {

                $row = [];
                $row[] = ++$start;
                $row[] = $Category->mst_cat_name;
                $row[] = $Category->mst_subcat_name;
                $row[] = $Category->mst_subcat_description;
                $row[] = $Category->mst_subcat_status== 'A' ? '<span class="status-active">Active</span>' : '<span class="status-inactive">InActive</span>';
                $row[] =change_date_month_name_char($Category->mst_subcat_ad);
                //$row[] = date("M d y",strtotime($Category->mst_subcat_ad));
                //$row[] = change_date_format_display($Category->mst_subcat_ad);

                $btns= '';

                $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="'. route('subcategory.edit', $Category->mst_id).'" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $Category->mst_id . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';

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
        return view('subcategory.list')->with($data);
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
        return view('subcategory.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $view = 'subcategory.add';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            //prd($request->all());
            try {
                $validation_arr = [
                    'mst_subcat_name' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request) {
                 $user = Auth::User();

                $user_details = new SubCategory();
                $user_details->mst_category_id = $request->post('mst_category_id');
                $user_details->mst_subcat_status = $request->post('mst_subcat_status');
                $user_details->mst_subcat_name = $request->post('mst_subcat_name');
                $user_details->mst_subcat_description = $request->post('mst_subcat_description');
                $user_details->created_by = $user->id;
                $user_details->mst_subcat_ad = date('Y-m-d H:i:s');
                $user_details->created_at = date('Y-m-d H:i:s');

                $result = $user_details->save();

                if ($result) {
                    return true;
                }
            });
                if ($result) {
                    return redirect('subcategory')->with(['message' => 'Sub Category saved successfully.']);
                }
            } catch (\Exception $e) {
                //prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        return view($view);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subcategory)
    {
        $data['edit'] = 1 ;
        // prd($subcategory);
         $data['category']=DB::table('rating_mst_category as a')
                                ->select('a.*')
                                ->where('a.is_deleted','=',0)->get()->toArray();
        return view('subcategory.edit', compact('subcategory'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subcategory)
    {
        $view = 'subcategory.edit';

        /* Check post either add or update */
        if ($request->isMethod('PATCH')) {//prd($request->all());
            try {
                $validation_arr = [
                    'mst_subcat_name' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $result = DB::transaction(function () use ($request , $subcategory) {

                $loginuser = Auth::User();
                $user_details = SubCategory::find($subcategory->mst_id);

               $user_details->mst_category_id = $request->post('mst_category_id');
                $user_details->mst_subcat_status = $request->post('mst_subcat_status');
                $user_details->mst_subcat_name = $request->post('mst_subcat_name');
                $user_details->mst_subcat_description = $request->post('mst_subcat_description');
                $user_details->updated_by = $loginuser->id;
                $user_details->updated_at = date('Y-m-d H:i:s');
                $user_details->mst_subcat_ud = date('Y-m-d H:i:s');

                $result = $user_details->save();
                if ($result) {
                    return true;
                }
            });
                if ($result) {
                    return redirect('subcategory')->with(['message' => 'Sub Category updated successfully.']);
                }
            } catch (\Exception $e) {
                //prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        return view($view);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subcategory)
    {
        try {
            if ($subcategory->mst_id != '') {
                $user_details = SubCategory::find($subcategory->mst_id);
                $user_details->is_deleted = 1;
                $user_details->save();

                $data['message'] = 'Sub Category Deleted Successfully';
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
