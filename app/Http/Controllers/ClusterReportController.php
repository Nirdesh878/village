<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;


class ClusterReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
         if ($request->ajax()) {

            $start = (int)$request->post('start');
            $limit = (int)$request->post('length');
            $txt_search = $request->post('search')['value'];

            $query = DB::table('cluster_mst as a')
                    ->join('cluster_sub_mst as s', 's.cluster_mst_id', '=', 'a.id')
                    ->join('cluster_profile as b', 'b.cluster_sub_mst_id', '=', 's.id')
                    ->join('federation_mst as c', 'a.federation_uin', '=', 'c.uin')
                    ->join('federation_sub_mst as x', 'x.federation_mst_id', '=', 'c.id')
                    ->join('federation_profile as h', 'h.federation_sub_mst_id', '=', 'x.id')
                    ->join('agency as d', 'a.agency_id', '=', 'd.agency_id')
                    ->leftjoin('countries as e', 'b.name_of_country', '=', 'e.id')
                    ->leftjoin('states as f', 'b.name_of_state', '=', 'f.id')
                    ->leftjoin('district as g', 'b.name_of_district', '=', 'g.id')
                    ->select('b.*', 'd.agency_name', 'e.name as country_name', 'f.name as state_name', 'g.name as district_name', 'a.uin', 'a.id as ids', 'a.status', 'a.federation_uin', 'h.name_of_federation', 's.status as clust_status');
            if($txt_search!='')
            {
                $query->Where(function ($query) use($txt_search) {
                    $query->orwhere('b.agency_name', 'like', '%'.$txt_search.'%')
                           ->orwhere('d.name', 'like', '%'.$txt_search.'%')
                           ->orwhere('e.name', 'like', '%'.$txt_search.'%')
                           ->orwhere('c.name', 'like', '%'.$txt_search.'%');
                });

            }
            $query->where('a.is_deleted', '=', 0);
            $total = $query->count();
            $clusters = $query->orderBy('a.created_at', 'DESC')->limit($limit)->offset($start)->get()->toArray();

            foreach($clusters as $cluster)
            {

                $row = [];
                $row[] = ++$start;
                $row[] = '';
                $row[] = $cluster->name_of_cluster;
                $row[] = $cluster->name_of_federation;
                $row[] = $cluster->name_of_cluster;
                $row[] = $cluster->name_of_country;
                $row[] = $cluster->name_of_state;
                $row[] = $cluster->name_of_district;
                $row[] = '';
                 $x1 = ($cluster->analysis_rating*100)/100;
                 $x2 = $x1>=90 ? 'green' :($x1>=75 ? 'yellow' :($x1>=60 ? 'grey' : 'red_status'));
                 $row[] =  "<div class='status_analysis ".$x2."' style='margin-left: 35%;margin-bottom: 8%;margin-top: 7%;'></div>";
                 $row[] = '';
                 $row[] = '';
                 $row[] = '';
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
        return view('clusterreport.list')->with($data);
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
        //
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
        //
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
