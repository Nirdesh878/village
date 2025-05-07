<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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

            $query = DB::table('rating_mst_category as a');
            if($txt_search!='')
            {
                $query->Where(function ($query) use($txt_search) {
                    $query->orwhere('a.mst_id', 'like', '%'.$txt_search.'%')
                          ->orwhere('a.mst_cat_name', 'like', '%'.$txt_search.'%');
                });

            }
            $total = $query->where('a.is_deleted', '=', 0)->count();

            $query = DB::table('rating_mst_category as a')
                    ->select('a.*');
            if($txt_search!='')
            {
                $query->Where(function ($query) use($txt_search) {
                    $query->orwhere('a.mst_id', 'like', '%'.$txt_search.'%')
                          ->orwhere('a.mst_cat_name', 'like', '%'.$txt_search.'%');
                });

            }
            $Categories = $query->where('a.is_deleted', '=', 0)
                        ->orderBy('a.mst_id')
                        ->limit($limit)
                        ->offset($start)
                        ->get()->toArray();
            //prd($Categories);
            foreach ($Categories as $Category)
            {

                $row = [];
                $row[] = ++$start;
                $row[] = $Category->mst_cat_name;
                $row[] = $Category->mst_cat_description;
                $row[] = $Category->mst_cat_status == 'A' ? '<span class="status-active">Active</span>' : '<span class="status-inactive">InActive</span>';
                $btns= '';
                $row[] =change_date_month_name_char($Category->created_at);
                //$row[] = change_date_format_display($Category->created_at);

                $btns= '';

                $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="'. route('category.edit', $Category->mst_id).'" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
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
        return view('category.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];

        return view('category.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $view = 'category.add';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            //prd($request->all());
            try {
                $validation_arr = [
                    'mst_cat_name' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $result = DB::transaction(function () use ($request) {

                $user = Auth::User();

                $user_details = new Category();
                $user_details->mst_cat_name = $request->post('mst_cat_name');
                $user_details->mst_cat_status = $request->post('mst_cat_status');
                $user_details->mst_cat_type = $request->post('mst_cat_type');
                $user_details->mst_cat_description = $request->post('mst_cat_description');
                $user_details->created_by = $user->id;
                $user_details->mst_cat_ad = date('Y-m-d H:i:s');
                $user_details->created_at = date('Y-m-d H:i:s');

                $result = $user_details->save();

                if ($result) {
                    return true;
                }
            });
                if ($result) {
                    return redirect('category')->with(['message' => 'Category saved successfully.']);
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $data['edit'] = 1 ;
        //prd($data);
        return view('category.edit', compact('category'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $view = 'category.edit';

        /* Check post either add or update */
        if ($request->isMethod('PATCH')) {//prd($request->all());
            try {
                $validation_arr = [
                    'mst_cat_name' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $result = DB::transaction(function () use ($request , $category) {

                $loginuser = Auth::User();
                $user_details = Category::find($category->mst_id);

                $user_details->mst_cat_name = $request->post('mst_cat_name');
                $user_details->mst_cat_status = $request->post('mst_cat_status');
                $user_details->mst_cat_type = $request->post('mst_cat_type');
                $user_details->mst_cat_description = $request->post('mst_cat_description');
                $user_details->updated_by = $loginuser->id;
                $user_details->updated_at = date('Y-m-d H:i:s');
                $user_details->mst_cat_ud = date('Y-m-d H:i:s');

                $result = $user_details->save();
                if ($result) {
                    return true;
                }
            });
                if ($result) {
                    return redirect('category')->with(['message' => 'Category updated successfully.']);
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            if ($category->mst_id != '') {
                $user_details = Category::find($category->mst_id);
                $user_details->is_deleted = 1;
                $user_details->save();

                $data['message'] = 'Category Deleted Successfully';
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
