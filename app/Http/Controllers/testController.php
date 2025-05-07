<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Agency;
use App\Models\Federation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FederationController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Imports\TestImport;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{

    // public function index(Request $request)
    // {

    //     $data = [];
    //     $data['agency'] = DB::table('agency')
    //         ->where('is_deleted', '=', 0)
    //         ->get()->toArray();

    //     return view('test.list')->with($data);
    // }
    // function import(Request $request)
    // {
    //     $file = $request->file('select_file');
    //     $fileName = $file->getClientOriginalName();
    //     $rows = \Excel::toArray(new TestImport,$file);
    //     echo json_encode($rows);
    //     // prd($request->all());

    // }
    // public function store_csv(Request $request)
    // {//prd($request->all());
    //     if ($request->isMethod('post')) {
    //         try {
    //                 $validation_arr = [
    //                     'partner_name' => ['required'],
    //                 ];

    //                 $validator = Validator::make($request->all(), $validation_arr);
    //                 if ($validator->fails()) {
    //                     return redirect()->back()->withErrors($validator)->withInput();
    //                 }
    //                 $result = DB::transaction(function () use ($request) {
    //                 $user = Auth::user();

    //                     $partner = $request->post('partner_name');
    //                     $agency  = $request->post('agency_name');
    //                     $country_name  = $request->post('country_name');
    //                     $state_name = $request->post('state_name');
    //                     $district_name = $request->post('district_name');
    //                     $block_name = $request->post('block_name');
    //                     $village_name = $request->post('village_name');
    //                     $fed_name  = $request->post('fed_name');
    //                     $fed_srlm = $request->post('fed_srlm');
    //                     $clus_name = $request->post('clus_name');
    //                     $clus_srlm = $request->post('clus_srlm');
    //                     $shg_name = $request->post('shg_name');
    //                     $shg_srlm = $request->post('shg_srlm');
    //                     $fm_name = $request->post('clus_srlm');
    //                     $fm_srlm = $request->post('fm_srlm');


    //                     for ($i=1; $i <= count($partner); $i++) {
    //                         $query = "select id from partners where partners_name = '".$partner[$i]."' ";
    //                         $data = DB::select($query);

    //                         if (count($data) > 0) {
    //                             $partner_details = Partner::find($data[0]->id);
    //                         } else {
    //                             $partner_details = new Partner();
    //                             $partner_details->created_by = $user->id;
    //                             $partner_details->created_at = date('Y-m-d H:i:s');

    //                         }
    //                         $partner_details->partners_name = $partner[$i];
    //                         $partner_details->partners_id = $partner[$i];
    //                         $result = $partner_details->save();
    //                         //partner id
    //                         $partner_id = $partner_details->id;

    //                         //country id
    //                         $query_country = "Select id from countries where name = '".$country_name[$i]."' ";
    //                         $data_country = DB::select($query_country);
    //                         //prd($data_country);
    //                         //state id
    //                         $query_state = "Select id from states where name = '".$state_name[$i]."' AND  country_id = '".$data_country[0]->id."'";
    //                         $data_state = DB::select($query_state);

    //                         //district id
    //                         $query_district = "Select id from district where name = '".$district_name[$i]."' AND  state_id = '".$data_state[0]->id."' ";
    //                         $data_district = DB::select($query_district);

    //                         //agency insert and update
    //                         if (($agency[$i] != '') && ($agency[$i] != 'null')) {
    //                             $query_agency = "select agency_id from agency where agency_name = '".$agency[$i]."' and community_or_local_partners = '".$partner_id."' AND country = '".$data_country[0]->id."' AND  state = '".$data_state[0]->id."' AND district = '".$data_district[0]->id."'";

    //                             $data_agency = DB::select($query_agency);

    //                             if(empty($data_agency))
    //                             {
    //                                 $agency_details = new Agency();
    //                                 $agency_details->agency_id = randomNumber("agency", "agency_id");
    //                                 $agency_details->community_or_local_partners = $partner_id;
    //                                 $agency_details->agency_name = $agency[$i];
    //                                 $agency_details->country = $data_country[0]->id;
    //                                 $agency_details->state = $data_state[0]->id;
    //                                 $agency_details->district = $data_district[0]->id;
    //                                 $agency_details->village = $village_name[$i];
    //                                 $agency_details->block = $block_name[$i];
    //                                 $result =  $agency_details->save();
    //                                 $newagency_id = $agency_details->agency_id;
    //                             }
    //                             else{
    //                                 $newagency_id = $data_agency[0]->agency_id;
    //                             }
    //                         }
    //                         else{
    //                             continue;
    //                         }
    //                         // prd($newagency_id);
    //                         //federation
    //                         if (($fed_srlm[$i] != '') && ($fed_srlm[$i] != 'null')) {
    //                             $query_fed = "select uin from federation_mst where is_deleted=0 and status = 'A' and srlm_code='".$fed_srlm[$i]."' ";
    //                             $data_fed = DB::select($query_fed);
    //                             if (empty($data_fed)) {
    //                                 $request['agency_id'] = $newagency_id;
    //                                 $request['name_of_federation'] = $fed_name[$i];
    //                                 $request['country'] = $data_country[0]->id;
    //                                 $request['state'] = $data_state[0]->id;
    //                                 $request['district'] = $data_district[0]->id;
    //                                 $request['srlm_code'] = $fed_srlm[$i];
    //                                 $request['date_federation_was_found'] = '01/08/2021';
    //                                 $request['status'] = 'A';
    //                                 $request['import'] = '1';
    //                                 $federation  = new FederationController;
    //                                 $abc =  $federation->store($request);
    //                                 $fed_id = $abc;
    //                             } else {
    //                                 $fed_id = $data_fed[0]->uin;
    //                             }
    //                         }
    //                         else{
    //                             continue;
    //                         }

    //                         //cluster
    //                         if(($clus_srlm[$i] != '' ) && ($clus_srlm[$i] != 'null'))
    //                         {
    //                             $query_cl = "select uin from cluster_mst where is_deleted=0 and status = 'A' and srlm_code='".$clus_srlm[$i]."' ";
    //                             $data_cl = DB::select($query_cl);
    //                             if (empty($data_cl)) {
    //                                 $request['agency_id'] = $agency ;
    //                                 $request['federation_id'] = $fed_id;
    //                                 $request['name_of_cluster'] = $clus_name[$i];
    //                                 $request['country'] = $data_country[0]->id;
    //                                 $request['state'] = $data_state[0]->id;
    //                                 $request['district'] = $data_district[0]->id;
    //                                 $request['srlm_code'] = $clus_srlm[$i];
    //                                 $request['cluster_formed'] = '01/Aug/2021';
    //                                 $request['status'] = 'A';
    //                                 $request['import'] = '1';
    //                                 $cluster  = new ClusterController;
    //                                 $abc =  $cluster->store($request);
    //                                 $cl_id = $abc;
    //                             }
    //                             else{
    //                                 $cl_id = $data_cl[0]->uin;
    //                             }
    //                         }


    //                     }
    //                     if ($result) {
    //                         return true;
    //                     }
    //                 });

    //                 if ($result) {
    //                     return redirect('test')->with(['message' => ' import Data saved successfully.']);
    //                 }
    //             }
    //             catch (\Exception $e) {
    //                 // DB::rollback();
    //                 //prd($e->getMessage());
    //                 return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
    //             }
    //     }
    // }

    public function index(){
        $ip = request()->header('X-Forwarded-For') ?? request()->ip();

        prd($ip);
        $location = $this->getLocationFromIp($ip);

                if ($location) {
                    echo "IP: {$location['ip']}, City: {$location['city']}, Country: {$location['country']}";
                } else {
                    echo "Could not determine location.";
                }
                die();
    }
    function getLocationFromIp($ip)
    {
        $apiKey = 'YOUR_IPAPI_KEY'; // Replace with your ipapi key
        $url = "http://api.ipapi.com/{$ip}?access_key={$apiKey}";

        // Make API call
        $response = Http::get($url);

        if ($response->ok()) {
            $data = $response->json();

            if (!empty($data)) {
                return [
                    'ip' => $data['ip'] ?? 'Unknown',
                    'city' => $data['city'] ?? 'Unknown',
                    'region' => $data['region_name'] ?? 'Unknown',
                    'country' => $data['country_name'] ?? 'Unknown',
                    'latitude' => $data['latitude'] ?? 'Unknown',
                    'longitude' => $data['longitude'] ?? 'Unknown',
                ];
            }
        }

        return null;
    }


}
