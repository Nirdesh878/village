<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Exports\Partner_report;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CheckName;
use App\Rules\CheckNumber;
use PDF;
use Carbon\Carbon;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->curdate = Carbon::now()->format('d-m-Y');

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
            $query = DB::table('partners as a')
                    ->leftjoin('countries as c','a.country_id','=','a.id');
            if($txt_search!='')
            {
                $query->Where(function ($query) use($txt_search) {
                    $query->orwhere('a.partners_id', 'like', '%'.$txt_search.'%')
                          ->orwhere('a.partners_name', 'like', '%'.$txt_search.'%');
                });

            }
            $total = $query->where('a.is_deleted', '=', 0)->count();

            $query = DB::table('partners as a')
                    ->leftjoin('countries as c','a.country_id','=','c.id')
                    ->select('a.*','c.name as country_name');
            if($txt_search!='')
            {
                $query->Where(function ($query) use($txt_search) {
                    $query->orwhere('a.partners_id', 'like', '%'.$txt_search.'%')
                          ->orwhere('a.partners_name', 'like', '%'.$txt_search.'%');
                });

            }
            $partners = $query->where('a.is_deleted', '=', 0)
                        ->orderBy('a.created_at','DESC')
                        ->limit($limit)
                        ->offset($start)
                        ->get()->toArray();

            foreach ($partners as $partner)
            {

                $row = [];
                $row[] = ++$start;
                $row[] = $partner->partners_name;
                $row[] = $partner->contact_person;
                $row[] = $partner->country_name;
                $row[] = $partner->contact_number;
                $row[] = $partner->address;
                $row[] = $partner->email;
                $row[] =change_date_month_name_char($partner->created_at);
                $row[] =change_date_month_name_char($partner->updated_at);
                // $row[] = change_date_format_display($partner->created_at);
                // $row[] = change_date_format_display($partner->updated_at);

                $btns= '';

                $btns .= '<a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="'. route('partner.edit', $partner->id).'" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $partner->id . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';

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
        return view('partner.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['countries'] = DB::table('countries')
        ->where('is_deleted', '=', 0)
        ->get()->toArray();

        return view('partner.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $view = 'partner.add';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            //prd($request->all());
            try {
                $validation_arr = [
                    'partners_name' => ['required', new CheckName],
                    'country'=>['required'],
                    'contact_person'=>['required'],
                    'address'=>['required'],
                    'email'=>['required'],
                    'contact_number'=>['required', new CheckNumber],
                ];
                //prd($validation_arr);
                $validator = Validator::make($request->all(), $validation_arr);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                //prd('ssew');
                $result = DB::transaction(function () use ($request) {

                $user = Auth::User();

                $user_details = new Partner();
                $user_details->partners_name = $request->post('partners_name');
                $user_details->partners_id = $request->post('partners_name');
                $user_details->country_id = $request->post('country');
                $user_details->address = $request->post('address');
                $user_details->email = $request->post('email');
                $user_details->contact_person = $request->post('contact_person');
                $user_details->contact_number = $request->post('contact_number');
                $user_details->created_by = $user->id;
                $user_details->created_at = date('Y-m-d H:i:s');

                $result = $user_details->save();

                if ($result) {
                    return true;
                }
            });
                if ($result) {
                    return redirect('partner')->with(['message' => 'Partner saved successfully.']);
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
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        $data['edit'] = 1 ;
        //prd($data);
        $data['countries'] = DB::table('countries')
        ->where('is_deleted', '=', 0)
        ->get()->toArray();
        return view('partner.edit', compact('partner'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $view = 'partner.edit';

        /* Check post either add or update */
        if ($request->isMethod('PATCH')) {//prd($request->all());
            try {
                $validation_arr = [
                    'partners_name' => ['required',],
                    'country'=>['required'],
                    'contact_person'=>['required'],
                    'address'=>['required'],
                    'email'=>['required'],
                    'contact_number'=>['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request , $partner) {
                $loginuser = Auth::User();
                $name = DB::table('partners')
                    ->where('is_deleted', '=', 0)
                    ->where('id', '!=', $request->post('id'))
                    ->where('partners_name', '=', $request->post('partners_name'))
                    ->get()->toArray();
                $number = DB::table('partners')
                    ->where('is_deleted', '=', 0)
                    ->where('id', '!=', $request->post('id'))
                    ->where('contact_number', '=', $request->post('contact_number'))
                    ->get()->toArray();
                $email = DB::table('partners')
                    ->where('is_deleted', '=', 0)
                    ->where('id', '!=', $request->post('id'))
                    ->where('email', '=', $request->post('email'))
                    ->get()->toArray();
                if (count($name) > 0) {
                    return 'alreadyexist';
                }
                else if (count($number) > 0) {
                    return 'alreadyexist';
                }
                else if (count($email) > 0) {
                    return 'alreadyexist';
                }
                else{

                        $user_details = Partner::find($partner->id);

                        $user_details->partners_id = $request->post('partners_name');
                        $user_details->partners_name = $request->post('partners_name');
                        $user_details->country_id = $request->post('country');
                        $user_details->address = $request->post('address');
                        $user_details->email = $request->post('email');
                        $user_details->contact_person = $request->post('contact_person');
                        $user_details->contact_number = $request->post('contact_number');

                        $user_details->updated_by = $loginuser->id;
                        $user_details->updated_at = date('Y-m-d H:i:s');

                        $result = $user_details->save();

                }
                if ($result) {
                    return true;
                }
            });
            if ('alreadyexist' === $result) {

                return redirect()->back()->withErrors(['message' => 'This Partner information is already stored please check in list.']);
            }
            elseif($result == 1){
                    return redirect('partner')->with(['message' => 'Partner updated successfully.']);
                }
            } catch (\Exception $e) {
                // prd($e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
        }

        return view($view);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        try {
            if ($partner->id != '') {
                $user_details = Partner::find($partner->id);
                $user_details->is_deleted = 1;
                $user_details->save();

                $data['message'] = 'Partner Deleted Successfully';
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

    public function export_partnerPdf()
    {
        $data['partner'] = DB::table('partners as a')
                    ->leftjoin('countries as c', 'a.country_id', '=', 'c.id')
                    ->select('a.*', 'c.name as country_name')
                    ->where('a.is_deleted', '=', 0)
                    ->orderBy('a.created_at', 'DESC')
                    ->get()->toArray();

        // prd($data['partner']);
        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.partnerPdf', $data)->setPaper('a4', 'landscape');

        return $pdf_doc->download('Partner_PDF'.pdf_date().'.pdf');
    }

    public function export(Request $request)
    {

       return Excel::download(new Partner_report(), 'Partner_'.pdf_date().'.xlsx');
    }

}
