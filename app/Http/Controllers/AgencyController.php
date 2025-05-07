<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Agency_report;
use App\Rules\CheckAgencyName;
use App\Rules\CheckAgencyEmail;
use PDF;
use Carbon\Carbon;

class AgencyController extends Controller
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

        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
        $data = [];
        if ($request->ajax()) {

            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');
            $txt_search = $request->post('search')['value'];

            $query = DB::table('agency as a')
                ->join('partners as b', 'a.community_or_local_partners', '=', 'b.id')
                ->join('countries as c', 'a.country', '=', 'c.id')
                ->join('states as d', 'a.state', '=', 'd.id')
                ->leftjoin('district as e', 'a.district', '=', 'e.id');
            if ($txt_search != '') {
                $query->Where(function ($query) use ($txt_search) {
                    $query->orwhere('a.agency_name', 'like', '%' . $txt_search . '%')
                        ->orwhere('b.partners_name', 'like', '%' . $txt_search . '%')
                        ->orwhere('d.name', 'like', '%' . $txt_search . '%')
                        ->orwhere('e.name', 'like', '%' . $txt_search . '%')
                        ->orwhere('c.name', 'like', '%' . $txt_search . '%');
                });
            }
            $total = $query->where('a.is_deleted', '=', 0)->count();

            $query = DB::table('agency as a')
                ->join('partners as b', 'a.community_or_local_partners', '=', 'b.id')
                ->join('countries as c', 'a.country', '=', 'c.id')
                ->join('states as d', 'a.state', '=', 'd.id')
                ->leftjoin('district as e', 'a.district', '=', 'e.id')
                ->select('a.*', 'b.partners_name', 'c.name as country_name', 'd.name as state_name', 'e.name as district_name');
            if ($txt_search != '') {
                $query->Where(function ($query) use ($txt_search) {
                    $query->orwhere('a.agency_name', 'like', '%' . $txt_search . '%')
                        ->orwhere('b.partners_name', 'like', '%' . $txt_search . '%')
                        ->orwhere('d.name', 'like', '%' . $txt_search . '%')
                        ->orwhere('e.name', 'like', '%' . $txt_search . '%')
                        ->orwhere('c.name', 'like', '%' . $txt_search . '%');
                });
            }
            $agencies = $query->where('a.is_deleted', '=', 0)
                ->orderBy('a.created_at', 'DESC')
                ->limit($limit)
                ->offset($start)
                ->get()->toArray();

            foreach ($agencies as $agency) {

                $row = [];
                $row[] = ++$start;
                $row[] = $agency->partners_name;
                $row[] = $agency->agency_name;
                $row[] = $agency->country_name;
                $row[] = $agency->state_name;
                $row[] = ($agency->district_name != '' ?  $agency->district_name : '-');
                $row[] = change_date_month_name_char($agency->created_at);
                $row[] = change_date_month_name_char($agency->updated_at);

                // $row[] = change_date_format_display($agency->created_at);
                //  $row[] = change_date_format_display($agency->updated_at);
                $row[] = $agency->status  == 'A' ? '<span class="status-active">Active</span>' : '<span class="status-inactive">InActive</span>';

                $btns  = '';

                $btns .= '<a class="btagencyn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="' . route('agency.edit', $agency->id) . '" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>';
                $btns .= ' <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete(\'' . $agency->id . '\')" title="Delete User"  style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>';

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

        return view('agency.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];

        $data['partners_list'] = DB::table('partners')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        return view('agency.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $view = 'agency.add';

        /* Check post either add or update */
        if ($request->isMethod('post')) {
            // prd($request->all());
            try {
                $validation_arr = [
                    'community_or_local_partners' => ['required'],
                    'agency_name' => ['required', new CheckAgencyName],
                    'country' => ['required'],
                    'state' => ['required'],
                    'contact_email' => ['required', new CheckAgencyEmail],
                    'contact_name' => ['required'],
                    'status' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request) {


                    $user = Auth::User();

                    $user_details = new Agency();
                    $user_details->community_or_local_partners = $request->post('community_or_local_partners');
                    $user_details->agency_id = randomNumber("agency", "agency_id");
                    $user_details->agency_name = $request->post('agency_name');
                    $user_details->country = $request->post('country');

                    $user_details->state = $request->post('state');
                    $user_details->district = $request->post('district');
                    $user_details->contact_number = $request->post('contact_number');
                    $user_details->contact_email = $request->post('contact_email');
                    $user_details->contact_name = $request->post('contact_name');
                    $user_details->contact_address = $request->post('contact_address');
                    $user_details->status = $request->post('status');

                    $user_details->created_by = $user->id;
                    $user_details->created_at = date('Y-m-d H:i:s');
                    //prd($user_details);
                    $result = $user_details->save();

                    if ($result) {
                        return true;
                    }
                });
                if ($result) {
                    return redirect('agency')->with(['message' => 'Agency saved successfully.']);
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
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function show(Agency $agency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function edit(Agency $agency)
    {

        $data['partners_list'] = DB::table('partners')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();
        $data['countries'] = DB::table('countries')
            ->where('is_deleted', '=', 0)
            ->get()->toArray();

        $data['edit'] = 1;
        //prd($data);
        return view('agency.edit', compact('agency'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agency $agency)
    {
        $view = 'agency.edit';
        
        /* Check post either add or update */
        if ($request->isMethod('PATCH')) { //prd($request->all());
            try {
                $validation_arr = [
                    'community_or_local_partners' => ['required'],
                    'agency_name' => ['required'],
                    'country' => ['required'],
                    'state' => ['required'],
                    'contact_email' => ['required'],
                    'contact_name' => ['required'],
                    'status' => ['required'],
                ];

                $validator = Validator::make($request->all(), $validation_arr);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $result = DB::transaction(function () use ($request, $agency) {


                    $loginuser = Auth::User();
                    $name = DB::table('agency')
                        ->where('is_deleted', '=', 0)
                        ->where('id', '!=', $request->post('id'))
                        ->where('agency_name', '=', $request->post('agency_name'))
                        ->get()->toArray();

                    $email = DB::table('agency')
                        ->where('is_deleted', '=', 0)
                        ->where('id', '!=', $request->post('id'))
                        ->where('contact_email', '=', $request->post('contact_email'))
                        ->get()->toArray();
                    if (count($name) > 0) {
                        return 'alreadyexist';
                    } else if (count($email) > 0) {
                        return 'alreadyexist';
                    } else {
                        $user_details = Agency::find($agency->id);

                        $user_details->community_or_local_partners = $request->post('community_or_local_partners');
                        $user_details->agency_name = $request->post('agency_name');
                        $user_details->country = $request->post('country');
                        $user_details->state = $request->post('state');
                        $user_details->district = $request->post('district');
                        $user_details->contact_name = $request->post('contact_name');
                        $user_details->contact_email = $request->post('contact_email');
                        $user_details->contact_number = $request->post('contact_number');
                        $user_details->contact_address = $request->post('contact_address');

                        $user_details->status = $request->post('status');

                        $user_details->updated_by = $loginuser->id;
                        $user_details->updated_at = date('Y-m-d H:i:s');

                        $result = $user_details->save();
                    }
                    if ($result) {
                        return true;
                    }
                });
                if ('alreadyexist' === $result) {

                    return redirect()->back()->withErrors(['message' => 'This Agency information is already stored please check in list.']);
                } elseif ($result == 1) {
                    return redirect('agency')->with(['message' => 'Agency updated successfully.']);
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
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agency $agency)
    {

        try {
            $query = "SELECT count(*) as name FROM federation_mst WHERE agency_id = $agency->agency_id AND is_deleted = 0";
            $fed_count = DB::select($query)[0]->name;

            if ($fed_count == 0) {

                if ($agency->id != '') {
                    $user_details = Agency::find($agency->id);
                    $user_details->is_deleted = 1;
                    $user_details->save();

                    $data['message'] = 'Partner/Organization Deleted Successfully';
                    echo json_encode($data);
                } else {
                    $data['message'] = "Invalid Request";
                    echo json_encode($data);
                }
            } else {
                $data['message'] = "Total number of Federation created under this agency are $fed_count  . Please delete these Federation first";
                echo json_encode($data);
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function export_agencyPdf()
    {
        $data['pre_url'] = (url()->previous());
        $user = Auth::user();
        $data['u_type'] = $user->u_type;
        //    prd("hh");

        $data['agency'] = DB::table('agency as a')
            ->join('partners as b', 'a.community_or_local_partners', '=', 'b.id')
            ->join('countries as c', 'a.country', '=', 'c.id')
            ->join('states as d', 'a.state', '=', 'd.id')
            ->leftjoin('district as e', 'a.district', '=', 'e.id')
            ->select('a.*', 'b.partners_name', 'c.name as country_name', 'd.name as state_name', 'e.name as district_name')
            ->where('a.is_deleted', '=', 0)
            ->orderBy('a.created_at', 'DESC')
            ->get()->toArray();


        view()->share('data', $data);
        $pdf_doc = PDF::loadView('pdf.agencyPdf', $data)->setPaper('a4', 'landscape');

        return $pdf_doc->download('Agency_PDF' . pdf_date() . '.pdf');
    }

    public function export(Request $request)
    {

        return Excel::download(new Agency_report(), 'Agency_' . pdf_date() . '.xlsx');
    }
}
