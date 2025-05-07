<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\Controller as controller;
use App\Models\AttributeMapping;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class AttributeMappingController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
        ]);

        $user = JWTAuth::authenticate($request->token);
        if ($user) {
            $users = DB::table('mst_districts as a')
                ->join('mst_states as b', 'a.state_id', '=', 'b.state_id')
                ->where('a.is_deleted', '=', '0')
                ->select('district_id', 'state_name', 'district_name','district_code')
                ->get()->toArray();

            return response()->json($users);
        }
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                //Validate data
                $data = $request->only('scheme_id', 'attribute_id','action');
                $validator = Validator::make($data, [
                    'action' => 'required',
                    'attribute_id' => 'required',
                    'scheme_id' => 'required',
                ]);

                //Send failed response if request is not valid
                if ($validator->fails()) {
                    return response()->json(['mssg' => $validator->errors()->all()], 404);
                }

                $result = DB::transaction(function () use ($request) {
                    $user = JWTAuth::authenticate($request->token);
                        if ($request->post('scheme_id') > 0 && !empty($request->post('attribute_id'))) {
                        $countMapping=DB::table('tbl_scheme_attributes_mapping')
                                      ->where('scheme_id',$request->scheme_id)
                                      ->where('attribute_id',$request->attribute_id) ->get()->toArray();

                            if($request->action=='link' || $request->action=='unlink')
                            {
                                if(!empty($countMapping[0]->id))
                                {
                                    $mapping_details =  AttributeMapping::find($countMapping[0]->id);
                                    $mapping_details->is_deleted = (($request->action=='link') ? 0 : 1);
                                    $mapping_details->updated_by = $user->id;
                                    $mapping_details->updated_at = date('Y-m-d H:i:s');
                                    $result = $mapping_details->save();
                                }
                                else
                                {
                                    $mapping_details = new AttributeMapping();
                                    $mapping_details->scheme_id = $request->scheme_id;
                                    $mapping_details->attribute_id = $request->attribute_id;
                                    $mapping_details->is_deleted = (($request->action=='link') ? 0 : 1);
                                    $mapping_details->created_by = $user->id;
                                    $mapping_details->created_at = date('Y-m-d H:i:s');
                                    $result = $mapping_details->save();
                                }
                            }
                           
                           
                        }  else {
                            return 'enterattribute';
                        }
                    if ($result) {
                        return true;
                    }
                });
                if ('enterattribute' === $result) {
                    return response()->json([
                        'success' => false,
                        'mssg' => 'Please Enter Data in Attribute Maping.',
                    ], 404);
                } elseif ('language' === $result) {
                    return response()->json([
                        'success' => false,
                        'mssg' => 'Please Enter Language.',
                    ], 404);
                } elseif ($result == 1) {
                    return response()->json([
                        'success' => true,
                        'mssg' => 'Attribute Maping Updated Successfully',
                    ], Response::HTTP_OK);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'mssg' => $e->getMessage(),
                ], 404);
            }
        }
    }

    public function show(Request $request,$district_id)
    {
        try {
            $user = JWTAuth::authenticate($request->token);
            if ($user) {
                $districtml = DB::table('mst_districts_ml')
                ->select('lang_id', 'district_name', 'district_id', 'state_id', DB::raw(" '' as district_code"))
                ->where('is_deleted', '=', 0)
                ->where('district_id', '=', $district_id);

                $districts = DB::table('mst_districts')
                ->select('lang_id', 'district_name', 'district_id', 'state_id', 'district_code')
                ->where('is_deleted', '=', 0)
                ->where('district_id', '=', $district_id)->union($districtml);

                $districtdata = DB::table('mst_language as a')
                ->select('a.lang_id','a.lang','a.lang_code','d.district_name','d.district_id', 'd.state_id', 'd.district_code')
                ->leftjoinSub($districts, 'd', function ($join) {
                    $join->on('d.lang_id', '=', 'a.lang_id');
                })
                ->where('a.is_deleted', '=', 0)
                ->get()->toArray();
                if (!$districtdata) {
                    return response()->json([
                        'success' => false,
                        'mssg' => 'Sorry, State not found.',
                    ], 404);
                }

                return $districtdata;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mssg' => $e->getMessage(),
            ], 404);
        }        
    }

    public function update(Request $request, AttributeMapping $district)
    {
        //prd($request->id);
        if ($request->isMethod('post')) {
            try {
                //Validate data
                $data = $request->only('district_name', 'district_code', 'state_id');
                $validator = Validator::make($data, [
                    'state_id' => 'required',
                    'district_code' => 'required|string',
                    'district_name' => 'required|string',
                ]);

                //Send failed response if request is not valid
                if ($validator->fails()) {
                    return response()->json(['mssg' => $validator->errors()->all()], 404);
                }

                $result = DB::transaction(function () use ($request) {
                    $user = JWTAuth::authenticate($request->token);
                    $count = language::where('lang_id', $request->post('lang_id'))->count();
                    if ($count > 0) {
                        if ($request->post('lang_id') == 1 && !empty($request->post('lang_id'))) {
                            $district_details = AttributeMapping::find($request->id);
                            $district_details->lang_id = $request->lang_id;
                            $district_details->state_id = $request->state_id;
                            $district_details->district_code = $request->district_code;
                            $district_details->district_name = $request->district_name;
                            $district_details->updated_by = $user->id;
                            $district_details->updated_at = date('Y-m-d H:i:s');
                            $result = $district_details->save();
                        }else {
                            return 'enterdistrict';
                        }
                    } else {
                        return 'language';
                    }
                    if ($result) {
                        return true;
                    }
                });
                if ('enterdistrict' === $result) {
                    return response()->json([
                        'success' => false,
                        'mssg' => 'Please Enter Data in AttributeMapping.',
                    ], 404);
                } elseif ('language' === $result) {
                    return response()->json([
                        'success' => false,
                        'mssg' => 'Please Enter Language.',
                    ], 404);
                } elseif ($result == 1) {
                    return response()->json([
                        'success' => true,
                        'mssg' => 'AttributeMapping Updated Successfully',
                    ], Response::HTTP_OK);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'mssg' => $e->getMessage(),
                ], 404);
            }
        }
    }

    public function destroy(Request $request, $district_id)
    {
        try {
            $user = JWTAuth::authenticate($request->token);
            if ($user)
             {
                $district_details = AttributeMapping::find($district_id);
                $district_details->is_deleted = 1;
                $district_details->updated_by = $user->id;
                $district_details->updated_at = date('Y-m-d H:i:s');
                $district_details->save();
                
                return response()->json([
                'success' => true,
                'mssg' => 'AttributeMapping deleted successfully',
            ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mssg' => $e->getMessage(),
            ], 404);
        }        
    }
}
