<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;


class SqlLibController extends Controller
{

    public function __construct()
    {

    }
    public function Agency() {
        
        $agency = "SELECT agency_id,agency_name FROM agency";
        $agency_query = DB::select($agency);
        $model= array();
        if (!empty($agency_query)) {
            foreach ($agency_query as $val) {
                $val=(array) $val;
                $model[$val['agency_id']] = $val['agency_name'];
            }
        }

        return $model;
        //return array('srijan1' => 'srijan', 'srijan2' => 'srijandd');
        
    }

    public function Agencyuncode() {
        
        $agency = "SELECT agency_id,agency_name FROM agency";
        $agency_query = DB::select($agency);
        
        $model= array();
        if (!empty($agency_query)) {
            foreach ($agency_query as $val) {
                $model[$val['agency_id']] = 'A'.substr($val['agency_id'], -3);
            }
        }

        return $model;
        //return array('srijan1' => 'srij', 'srijan2' => 'sri2');
        
     }
     
     
    public function AgencynameByid($agencyid) {
        
        $agency = "SELECT agency_name FROM agency WHERE agency_id='$agencyid'";
        $agency_query = DB::select($agency);
        //prd($agency_query);
        $agency_name=''; 
        if (!empty($agency_query)) {
            $agency_name = $agency_query[0]->agency_name;
        }

        return $agency_name;
     }
     
     

    public function Sql_Federation() {

        $FedUinNameAre = array();
        $feduinSql = "SELECT federation_mst.uin,federation_profile.name_of_federation as name FROM federation_profile
                    LEFT JOIN federation_sub_mst ON federation_sub_mst.id = federation_profile.federation_sub_mst_id
                    LEFT JOIN federation_mst ON federation_mst.id = federation_sub_mst.federation_mst_id
                    WHERE federation_sub_mst.status='A'";
        $feduinFetch = DB::select($feduinSql);
        if (!empty($feduinFetch)) {
            foreach ($feduinFetch as $val) {
                $val=(array) $val;
                $FedUinNameAre[$val['uin']] = $val['name'];
            }
        }

        return $FedUinNameAre;
    }

    public function Sql_Cluster() {
        $ClsUinNameAre = array();
        $clsuinSql = "SELECT cluster_mst.uin,cluster_profile.name_of_cluster as name FROM cluster_profile
                    LEFT JOIN cluster_sub_mst ON cluster_sub_mst.id = cluster_profile.cluster_sub_mst_id
                    LEFT JOIN cluster_mst ON cluster_mst.id = cluster_sub_mst.cluster_mst_id
                    WHERE cluster_sub_mst.status='A'";
        $clsuinFetch = DB::select($clsuinSql);
        if (!empty($clsuinFetch)) {
            foreach ($clsuinFetch as $val) {
                $val=(array) $val;
                $ClsUinNameAre[$val['uin']] = $val['name'];
            }
        }

        return $ClsUinNameAre;
    }

    public function Sql_Shg() {

        $ShgUinNameAre = array();
        $shguinSql = "SELECT shg_mst.uin,shg_profile.shgName as name FROM shg_profile
                    LEFT JOIN shg_sub_mst ON shg_sub_mst.id = shg_profile.shg_sub_mst_id
                    LEFT JOIN shg_mst ON shg_mst.id = shg_sub_mst.shg_mst_id
                    WHERE shg_sub_mst.status='A'";
        $shguinFetch = DB::select($shguinSql);
        if (!empty($shguinFetch)) {
            foreach ($shguinFetch as $val) {
                $val=(array) $val;
                $ShgUinNameAre[$val['uin']] = $val['name'];
            }
        }

        return $ShgUinNameAre;
    }

    public function Sql_Family() {

        $FmlUinNameAre = array();
        $fmluinSql = "SELECT family_mst.uin,family_profile.fp_member_name as name FROM family_profile
                    LEFT JOIN family_sub_mst ON family_sub_mst.id = family_profile.family_sub_mst_id
                    LEFT JOIN family_mst ON family_mst.id = family_sub_mst.family_mst_id
                    WHERE family_sub_mst.status='A'";
        $fmluinFetch = DB::select($fmluinSql);
        if (!empty($fmluinFetch)) {
            foreach ($fmluinFetch as $val) {
                $val=(array) $val;
                $FmlUinNameAre[$val['uin']] = $val['name'];
            }
        }

        return $FmlUinNameAre;
    }

    public function Dynatree_fed() {

        //Dynatree------------------
        $data_fed = array();
        $query = "SELECT id,pid as parent_id,uin FROM fcsnode_mst";
        $data1=DB::select($query);
        $itemsByReference = array();
        if (count($data1) > 0) {
            foreach ($data1 as $val) {
                $newAre = array();
                $val=(array) $val;
                $newAre['id'] = $val['id'];
                $newAre['parent_id'] = $val['parent_id'];
                $newAre['uin'] = $val['uin'];
                $data_fed[] = $newAre;
            }
        }
        foreach ($data_fed as $key => &$item) {
            $itemsByReference[$item['id']] = &$item;
            $itemsByReference[$item['id']]['children'] = array();
        }
        foreach ($data_fed as $key => &$item)
            if ($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                $itemsByReference [$item['parent_id']]['children'][] = &$item;
        foreach ($data_fed as $key => &$item) {
            if ($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                unset($data_fed[$key]);
        }
        //End Dynatree-------------

        return $data_fed;
    }

    public function Dynatree_clu() {

        //Dynatree------------------
        $data_cl = array();
        $query = "SELECT id,pid as parent_id,uin FROM fcsnode_mst where type!='F'";
         $data_cl=DB::select($query);
        $itemsByReference_cl = array();

        if (count($data1_cl) > 0) {
            foreach ($data1_cl as $val_cl) {
                $newAre_cl = array();
                $val_cl=(array) $val_cl;
                $newAre_cl['id'] = $val_cl['id'];
                $newAre_cl['parent_id'] = $val_cl['parent_id'];
                $newAre_cl['uin'] = $val_cl['uin'];
                $data_cl[] = $newAre_cl;
            }
        }
        foreach ($data_cl as $key_cl => &$item_cl) {
            $itemsByReference_cl[$item_cl['id']] = &$item_cl;
            $itemsByReference_cl[$item_cl['id']]['children'] = array();
        }
        foreach ($data_cl as $key_cl => &$item_cl)
            if ($item_cl['parent_id'] && isset($itemsByReference_cl[$item_cl['parent_id']]))
                $itemsByReference_cl [$item_cl['parent_id']]['children'][] = &$item_cl;


        foreach ($data_cl as $key_cl => &$item_cl) {
            if ($item_cl['parent_id'] && isset($itemsByReference_cl[$item_cl['parent_id']]))
                unset($data_cl[$key_cl]);
        }
        //End Dynatree-------------

        return $data_cl;
    }

    public function Dynatree_sh() {

        //Dynatree------------------
        $data_sh = array();
         $query="SELECT id,pid as parent_id,uin FROM fcsnode_mst where type IN ('S','I')";
        $data1_sh = DB::select($query);

        $itemsByReference = array();
        if (count($data1_sh) > 0) {
            foreach ($data1_sh as $val) {
                $newAre = array();
                 $val=(array) $val;
                $newAre['id'] = $val['id'];
                $newAre['parent_id'] = $val['parent_id'];
                $newAre['uin'] = $val['uin'];
                $data_sh[] = $newAre;
            }
        }
        foreach ($data_sh as $key => &$item) {
            $itemsByReference[$item['id']] = &$item;
            $itemsByReference[$item['id']]['children'] = array();
        }
        foreach ($data_sh as $key => &$item)
            if ($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                $itemsByReference [$item['parent_id']]['children'][] = &$item;
        foreach ($data_sh as $key => &$item) {
            if ($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                unset($data_sh[$key]);
        }
//End Dynatree------------- 

        return $data_sh;
    }

    /**
     * Manages all parent of family member.
     */
    public function Familyparent($mid) {
        
        $resAre['shg'] = array();
        $resAre['cluster'] = array();
        $resAre['federation'] = array();


        $model = DB::table('family_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.id', '=',$mid)
                    ->get()->toArray();
        
        if (!empty($model)) {
            $model[0]=(array)$model[0];
            //pr($model[0]);
            $shg_uin = $model[0]['shg_uin'];

            $model = array();
            $model = DB::table('shg_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.uin', '=',$shg_uin)
                    ->get()->toArray();
                    //ShgMst::model()->findAll("uin='$shg_uin'");
          
            $model[0]=(array)$model[0];
            $shg_mst_id = $model[0]['id'];

            $q1 = "SELECT shg_profile.shgName FROM shg_sub_mst
                   LEFT JOIN shg_profile ON shg_profile.shg_sub_mst_id=shg_sub_mst.id
                   WHERE shg_sub_mst.shg_mst_id=$shg_mst_id";
            $sub_nameAre = DB::select($q1);
            $sub_nameAre[0] = (array)($sub_nameAre[0]);

            if (!empty($sub_nameAre)) {
                $resAre['shg'] = $sub_nameAre[0]['shgName'];
            }



            $cluster_uin = $model[0]['cluster_uin'];
            //die($cluster_uin);
            
            
            if(!empty($cluster_uin))
            {
                $model = array();
                $model = DB::table('cluster_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.uin', '=',$cluster_uin)
                    ->get()->toArray();
                    //ClusterMst::model()->findAll("uin='$cluster_uin'");
           
                $model[0]=(array)$model[0];
                $cluster_mst_id = $model[0]['id'];
                //die($cluster_mst_id);
                $q2 = "SELECT cluster_profile.name_of_cluster FROM cluster_sub_mst
                       LEFT JOIN cluster_profile ON cluster_profile.cluster_sub_mst_id=cluster_sub_mst.id
                       WHERE cluster_sub_mst.cluster_mst_id=$cluster_mst_id";
                $cluster_nameAre = DB::select($q2);
                $cluster_nameAre[0] = (array)($cluster_nameAre[0]);
                if (!empty($cluster_nameAre)) {
                    $resAre['cluster'] = $cluster_nameAre[0]['name_of_cluster'];
                }
            }
            //prd($model[0]);
            $federation_uin = $model[0]['federation_uin'];
            //prd($federation_uin);
            $model = array();
            $model = DB::table('federation_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.uin', '=',$federation_uin)
                    ->get()->toArray();
                  
            //FederationMst::model()->findAll("uin='$federation_uin'");
            //die('modal_fed');
            if (!empty($model)) {
            $model[0]=(array)$model[0];

            $federation_mst_id = $model[0]['id'];

            $q3 = "SELECT federation_profile.name_of_federation FROM federation_sub_mst
                   LEFT JOIN federation_profile ON federation_profile.federation_sub_mst_id=federation_sub_mst.id
                   WHERE federation_sub_mst.federation_mst_id=$federation_mst_id";

            $federation_nameAre = DB::select($q3);
            $federation_nameAre[0] = (array)($federation_nameAre[0]);

            if (!empty($federation_nameAre)) {
                $resAre['federation'] = $federation_nameAre[0]['name_of_federation'];
            }
        }
    }

        
        return $resAre;
    }
    
    
    
    
    /**
     * Manages all parent of family member.
     */
    public function FamilyparentUIN($mid) {
                    
        $resAre['family'] = array();
        $resAre['shg'] = array();
        $resAre['cluster'] = array();
        $resAre['federation'] = array();


        $model = FamilyMst::model()->findAll("id=$mid");
        if (!empty($model)) {
            $profile = "SELECT family_profile.fp_member_name,family_profile.fp_rate,family_profile.fp_wealth_rank,family_mst.uin FROM family_profile
                        LEFT JOIN family_sub_mst ON family_sub_mst.id = family_profile.family_sub_mst_id
                        LEFT JOIN family_mst ON family_mst.id = family_sub_mst.family_mst_id
                        WHERE family_mst.id=$mid";
            $profileAre = DB::select($profile);
             $profileAre = (array)($profileAre);
            if(!empty($profileAre)){
            $resAre['family']['uin']= $profileAre[0]['uin'];
            $resAre['family']['name']= $profileAre[0]['fp_member_name'];
            $resAre['family']['fp_rate']= $profileAre[0]['fp_rate'];
            $resAre['family']['fp_wealth_rank']= $profileAre[0]['fp_wealth_rank'];
            }
                    
            $shg_uin = $model[0]['shg_uin'];
            $model = array();
            $model = ShgMst::model()->findAll("uin='$shg_uin'");
            $shg_mst_id = $model[0]['id'];

            $q1 = "SELECT shg_profile.shgName FROM shg_sub_mst
                   LEFT JOIN shg_profile ON shg_profile.shg_sub_mst_id=shg_sub_mst.id
                   WHERE shg_sub_mst.shg_mst_id=$shg_mst_id AND shg_sub_mst.status='A'";
            $sub_nameAre = DB::select($q1);
            $sub_nameAre = (array)($sub_nameAre);
            if (!empty($sub_nameAre)) {
                $resAre['shg']['uin'] = $model[0]['uin'];
                $resAre['shg']['name'] = $sub_nameAre[0]['shgName'];
            }

            $cluster_uin = $model[0]['cluster_uin'];

            $model = array();
            $model = ClusterMst::model()->findAll("uin='$cluster_uin'");
            $cluster_mst_id = $model[0]['id'];

            $q2 = "SELECT cluster_profile.name_of_cluster FROM cluster_sub_mst
                   LEFT JOIN cluster_profile ON cluster_profile.cluster_sub_mst_id=cluster_sub_mst.id
                   WHERE cluster_sub_mst.cluster_mst_id=$cluster_mst_id AND cluster_sub_mst.status='A'";
            $cluster_nameAre = DB::select($q2);
            $cluster_nameAre = (array)($cluster_nameAre);
            if (!empty($cluster_nameAre)) {
                $resAre['cluster']['uin'] = $model[0]['uin'];
                $resAre['cluster']['name'] = $cluster_nameAre[0]['name_of_cluster'];
            }

            $federation_uin = $model[0]['federation_uin'];

            $model = array();
            $model = FederationMst::model()->findAll("uin='$federation_uin'");
            $federation_mst_id = $model[0]['id'];

            $q3 = "SELECT federation_profile.name_of_federation FROM federation_sub_mst
                   LEFT JOIN federation_profile ON federation_profile.federation_sub_mst_id=federation_sub_mst.id
                   WHERE federation_sub_mst.federation_mst_id=$federation_mst_id AND federation_sub_mst.status='A'";

            $federation_nameAre = DB::select($q3);
            $federation_nameAre = (array)$federation_nameAre;

            if (!empty($federation_nameAre)) {
                $resAre['federation'][$model[0]['uin']] = $federation_nameAre[0]['name_of_federation'];
                
                $resAre['federation']['uin'] = $model[0]['uin'];
                $resAre['federation']['name'] = $federation_nameAre[0]['name_of_federation'];
            }
        }


        return $resAre;
    }
    
                    
    /**
     * Manages all parent of family member.
     */
    public function Shgparent($mid) {

        $resAre['number_of_family'] = 0;
        $resAre['family_details'] = array();
        $resAre['cluster'] = '';
        $resAre['federation'] = '';

        $model = DB::table('shg_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.id', '=',$mid)
                    ->get()->toArray();
                    //ShgMst::model()->findAll("id=$mid");
                    
        if (!empty($model)) {

            $shg_uin = $model[0]->uin;
            $cluster_uin = $model[0]->cluster_uin;
            $federation_uin = $model[0]->federation_uin;

            $model_family = DB::table('family_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.shg_uin', '=',$shg_uin)
                    ->get()->toArray();
                   // FamilyMst::model()->findAll("shg_uin='$shg_uin'");
            $resAre['number_of_family'] = count($model_family);

            if (count($model_family) > 0) {
                foreach ($model_family as $family) {
                    $family=(array)$family;
                    $resAre['family_details'][$family['id']] = $family['uin'];
                }
            }

            
            
             
            
            $model = array();
            $model = DB::table('federation_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.uin', '=',$federation_uin)
                    ->get()->toArray();
                    //FederationMst::model()->findAll("uin='$federation_uin'");
            $federation_mst_id = $model[0]->id;

            $q3 = "SELECT federation_profile.name_of_federation FROM federation_sub_mst
                   LEFT JOIN federation_profile ON federation_profile.federation_sub_mst_id=federation_sub_mst.id
                   WHERE federation_sub_mst.federation_mst_id=$federation_mst_id";

            $federation_nameAre = DB::select($q3);
            
             $federation_nameAre = (array)$federation_nameAre;
            if (!empty($federation_nameAre)) {
                $resAre['federation'] = $federation_nameAre[0]->name_of_federation;
            }
            
            $model = DB::table('cluster_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.uin', '=',$cluster_uin)
                    ->get()->toArray();
           // ClusterMst::model()->findAll("uin='$cluster_uin'");
                    if (!empty($model)) {
            $cluster_mst_id = $model[0]->id;

            $q2 = "SELECT cluster_profile.name_of_cluster FROM cluster_sub_mst
                   LEFT JOIN cluster_profile ON cluster_profile.cluster_sub_mst_id=cluster_sub_mst.id
                   WHERE cluster_sub_mst.cluster_mst_id=$cluster_mst_id";
            $cluster_nameAre =DB::select($q2);
            
            $cluster_nameAre = (array)$cluster_nameAre;
            if (!empty($cluster_nameAre)) {
                $resAre['cluster'] = $cluster_nameAre[0]->name_of_cluster;
            }

        }
    }
        return $resAre;
    }

    /**
     * Manages all parent of family member.
     */
    public function Clusterparent($mid) {

        $resAre['number_of_family'] = 0;
        $resAre['family_details'] = array();
        $resAre['number_of_shg'] = 0;
        $resAre['shg_details'] = array();

        $resAre['federation'] = '';
        $fmlycnt = 0;

        $model = DB::table('cluster_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.id', '=',$mid)
                     ->get()->toArray();
        if (!empty($model)) {

            $cluster_uin = $model[0]->uin;
            $federation_uin = $model[0]->federation_uin;


            $model_shg_uin = DB::table('shg_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.cluster_uin', '=',$cluster_uin)
                     ->get()->toArray();
            //ShgMst::model()->findAll("cluster_uin='$cluster_uin'");
            // /die('hi');
            $resAre['number_of_shg'] = count($model_shg_uin);

            if (!empty($model_shg_uin)) {
                foreach ($model_shg_uin as $shg_uin) {
                    $shg_uin=(array)$shg_uin;
                    $resAre['shg_details'][$shg_uin['id']] = $shg_uin['uin'];
                    $shguin = $shg_uin['uin'];

                    $model_family = DB::table('family_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.shg_uin', '=',$shguin)
                     ->get()->toArray();
                    $fmlycnt = $fmlycnt + count($model_family);
                    $resAre['number_of_family'] = $fmlycnt;

                    if (count($model_family) > 0) {
                        foreach ($model_family as $fmldtl) {
                            $fmldtl=(array)$fmldtl;
                            $resAre['family_details'][$shguin][$fmldtl['id']] = $fmldtl['uin'];
                        }
                    }
                }
            }

            $model = array();
            $model = DB::table('federation_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.uin', '=',$federation_uin)
                     ->get()->toArray();
                     //FederationMst::model()->findAll("uin='$federation_uin'");
            $federation_mst_id = $model[0]->id;

            $q3 = "SELECT federation_profile.name_of_federation FROM federation_sub_mst
                   LEFT JOIN federation_profile ON federation_profile.federation_sub_mst_id=federation_sub_mst.id
                   WHERE federation_sub_mst.federation_mst_id=$federation_mst_id";

            $federation_nameAre = DB::select($q3);
             $federation_nameAre = (array)$federation_nameAre;
            if (!empty($federation_nameAre)) {
                $resAre['federation'] = $federation_nameAre[0]->name_of_federation;
            }
        }

        return $resAre;
    }

    /**
     * Manages all parent of family member.
     */
    public function Federationparent($mid) {

        $resAre['number_of_family'] = 0;
        $resAre['family_details'] = array();
        $resAre['number_of_shg'] = 0;
        $resAre['shg_details'] = array();
        $resAre['number_of_cluster'] = 0;
        $resAre['cluster_details'] = array();

        $fmlycnt = 0;
        $shgcnt = 0;

        $model = FederationMst::model()->findAll("id=$mid");
        if (!empty($model)) {
            $federation_uin = $model[0]['uin'];

            $model_cluster = ClusterMst::model()->findAll("federation_uin='$federation_uin'");
            $resAre['number_of_cluster'] = count($model_cluster);

            if (count($model_cluster)) {
                foreach ($model_cluster as $clst_dtl) {
                    $cluster_uin = $clst_dtl['uin'];
                    $resAre['cluster_details'][$clst_dtl['id']] = $cluster_uin;


                    $model_shg_uin = ShgMst::model()->findAll("cluster_uin='$cluster_uin'");
                    $shgcnt = $shgcnt + count($model_shg_uin);
                    $resAre['number_of_shg'] = $shgcnt;

                    if (count($model_shg_uin) > 0) {
                        foreach ($model_shg_uin as $shg_uin) {

                            $resAre['shg_details'][$cluster_uin][$shg_uin['id']] = $shg_uin['uin'];
                            $shguin = $shg_uin['uin'];

                            $model_family = FamilyMst::model()->findAll("shg_uin='$shguin'");
                            $fmlycnt = $fmlycnt + count($model_family);
                            $resAre['number_of_family'] = $fmlycnt;

                            if (count($model_family) > 0) {
                                foreach ($model_family as $fmldtl) {

                                    $resAre['family_details'][$shguin][$fmldtl['id']] = $fmldtl['uin'];
                                }
                            }
                        }
                    }
                }
            }
        }

        return $resAre;
    }

    /**
     * Manages all parent of family member.
     */
    public function Userhistory($uin) {

        $resAre = array();

        $model = DB::table('users as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.uin', '=',$uin)
                     ->get()->toArray();
        if (!empty($model)) {
            $newAre = array();
            $model[0]=(array)$model[0];
            $user_id = $model[0]['id'];
            $newAre['uin'] = $model[0]['uin'];
            $newAre['agency'] = $this->AgencynameByid($model[0]['agency_id']);
            $newAre['name'] = $model[0]['name'];
            $newAre['gender'] = $model[0]['gender'];
            $newAre['adress'] = $model[0]['adress'];
            $newAre['city'] = $model[0]['city'];
            $newAre['pincode'] = $model[0]['pincode'];
            $newAre['email'] = $model[0]['email'];
            $newAre['mobile'] = $model[0]['mobile'];
            $newAre['password'] = $model[0]['password'];

            $roles = array('CEO' => 'CEO',
                'M' => 'Manager',
                'QA' => 'Quality Analyst',
                'F' => 'Facilitator');

            $role = $roles[$model[0]['u_type']];
 
            $newAre['role'] = $role; 
            $newAre['created_at'] = date("d-m-Y", strtotime($model[0]['created_at'])); 
            $resAre['user'] = $newAre;

            $model_task = DB::table('task_assignment as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.user_id', '=',$user_id)
                     ->get()->toArray();
                    // TaskAssignment::model()->findAll("user_id=$user_id");
            if (count($model_task) > 0) {
                $nare = array('FM' => 'Family', 'SH' => 'Shg', 'CL' => 'Cluster', 'FD' => 'Federation',
                    'PR' => 'Process',
                    'A' => 'Analytics', 'R' => 'Rating');

                 $statusAre = array('P' => 'Pending', 'D' => 'Completed', 'R' => 'Reject','PR' => 'Process');

                foreach ($model_task as $val) {
                    $newAre = array();
                    $val=(array)$val;

                $newAre['assignd_id'] = $val['asgtkn'];

                    $mstid = $val['assignment_id'];

                    if ($val['assignment_type'] == 'FM') {
                        $dtl = $this->FamilyProfile($mstid);
                        $newAre['shg_name'] = $dtl['shg_name'];
                    }

                    if ($val['assignment_type'] == 'SH') {
                        $dtl = $this->ShgProfile($mstid);
                    }

                    if ($val['assignment_type'] == 'CL') {
                        $dtl = $this->ClusterProfile($mstid);
                    }

                    if ($val['assignment_type'] == 'FD') {
                        $dtl = $this->FederationProfile($mstid);
                    }

                    $newAre['uin'] = $dtl['uin'];
                    $newAre['name'] = $dtl['name'];
                    $newAre['qa_status'] = $dtl['qa_status'];

                    if($val['task']=='A')
                    {
                    $newAre['task'] = $nare[$val['task']].'-'.$val['task_a1'];
                    }else{
                    $newAre['task'] = $nare[$val['task']];  
                    }
                    
                    $newAre['status'] = $statusAre[$val['status']];

                    $newAre['assign_date'] = date("d-m-Y", strtotime($val['created_at']));
                    $newAre['update_date'] = date("d-m-Y", strtotime($val['updated_at']));

                    $resAre[$nare[$val['assignment_type']]][] = $newAre;
                }
            }
        }
        return $resAre;
    }
    
    /**
     * Manages all parent of family member.
     */
    public function FamilyProfile($mstid) {

        $resAre['uin'] = '';
        $resAre['name'] = '';
        $resAre['qa_status'] = '';
        $resAre['shg_name'] = '';

        $q = "SELECT family_mst.uin, family_mst.shg_uin, family_profile.fp_member_name as name,family_sub_mst.qa_status
            FROM family_profile
            LEFT JOIN family_sub_mst ON family_sub_mst.id = family_profile.family_sub_mst_id
            LEFT JOIN family_mst ON family_mst.id = family_sub_mst.family_mst_id
            WHERE family_sub_mst.status='A' AND family_sub_mst.family_mst_id=$mstid";

        $model = DB::select($q);
         $model = (array)$model;
        if (count($model) > 0) {

            $resAre['uin'] = $model[0]->uin;
            $resAre['name'] = $model[0]->name;
            $resAre['qa_status'] = $model[0]->qa_status;

            $shg_uin = $model[0]->shg_uin;
            $model_shg = DB::table('shg_mst as a')
                    ->where('a.is_deleted', '=', 0)
                    ->where('a.uin', '=',$shg_uin)
                     ->get()->toArray();
            //$model_shg = ShgMst::model()->findAll("uin='$shg_uin'");
            $shg_mst_id = $model_shg[0]->id;

            $q1 = "SELECT shg_profile.shgName FROM shg_sub_mst
                   LEFT JOIN shg_profile ON shg_profile.shg_sub_mst_id=shg_sub_mst.id
                   WHERE shg_sub_mst.shg_mst_id=$shg_mst_id AND shg_sub_mst.status='A'";
            $sub_nameAre = DB::select($q1);
            $sub_nameAre[0] = (array)$sub_nameAre[0];
            if (count($sub_nameAre) > 0) {
                $resAre['shg_name'] = $sub_nameAre[0]['shgName'];
            }
        }
        return $resAre;
    }

    /**
     * Manages all parent of family member.
     */
    public function ShgProfile($mstid) {

        $resAre['uin'] = '';
        $resAre['name'] = '';
        $resAre['qa_status'] = '';
        $q = "SELECT shg_mst.uin,shg_profile.shgName as name, shg_sub_mst.qa_status
            FROM shg_profile
            LEFT JOIN shg_sub_mst ON shg_sub_mst.id = shg_profile.shg_sub_mst_id
            LEFT JOIN shg_mst ON shg_mst.id = shg_sub_mst.shg_mst_id
            WHERE shg_sub_mst.status='A' AND shg_sub_mst.shg_mst_id=$mstid";

        $model = DB::select($q);
        $model = (array)$model;
        if (count($model) > 0) {
            $resAre['uin'] = $model[0]->uin;
            $resAre['name'] = $model[0]->name;
            $resAre['qa_status'] = $model[0]->qa_status;
        }
        return $resAre;
    }

    /**
     * Manages all parent of family member.
     */
    public function ClusterProfile($mstid) {

        $resAre['uin'] = '';
        $resAre['name'] = '';
        $resAre['qa_status'] = '';

        $q = "SELECT cluster_mst.uin,cluster_profile.name_of_cluster as name,cluster_sub_mst.qa_status
            FROM cluster_profile
            LEFT JOIN cluster_sub_mst ON cluster_sub_mst.id = cluster_profile.cluster_sub_mst_id
            LEFT JOIN cluster_mst ON cluster_mst.id = cluster_sub_mst.cluster_mst_id
            WHERE cluster_sub_mst.status='A' AND cluster_sub_mst.cluster_mst_id =$mstid";

        $model = DB::select($q);
        $model = (array)$model;
        if (count($model) > 0) {

            $resAre['uin'] = $model[0]->uin;
            $resAre['name'] = $model[0]->name;
            $resAre['qa_status'] = $model[0]->qa_status;
        }
        return $resAre;
    }

    /**
     * Manages all parent of family member.
     */
    public function FederationProfile($mstid) {

        $resAre['uin'] = '';
        $resAre['name'] = '';
        $resAre['qa_status'] = '';

        $q = "SELECT federation_mst.uin,federation_profile.name_of_federation as name,federation_sub_mst.qa_status
            FROM federation_profile
            LEFT JOIN federation_sub_mst ON federation_sub_mst.id = federation_profile.federation_sub_mst_id
            LEFT JOIN federation_mst ON federation_mst.id = federation_sub_mst.federation_mst_id
            WHERE federation_sub_mst.status='A' AND federation_sub_mst.federation_mst_id=$mstid";

        $model = DB::select($q);
        $model = (array)$model;
        if (count($model) > 0) {

            $resAre['uin'] = $model[0]->uin;
            $resAre['name'] = $model[0]->name;
            $resAre['qa_status'] = $model[0]->qa_status;
        }
        return $resAre;
    }
    
     /**
     * Manages all parent of family member.
     */
    public function InstutinalDetails($instute_type,$uin) {
    
            $mdata = array();
                    
            switch ($instute_type){
                    case 'federation':
                        //FEDERATION
                        $fd = "SELECT federation_profile.name_of_federation,federation_mst.uin FROM federation_profile
                                    LEFT JOIN federation_sub_mst ON federation_sub_mst.id = federation_profile.federation_sub_mst_id
                                    LEFT JOIN federation_mst ON federation_mst.id = federation_sub_mst.federation_mst_id
                                    WHERE federation_mst.uin = '$uin' AND federation_sub_mst.status='A'";
                        $fdAre = DB::select($fd);
                        if(!empty($fdAre)){
                        foreach($fdAre as $pval){
                            $pval=(array)$pval;
                        $mdata['federation'][$pval['uin']]= $pval['name_of_federation'];
                        }
                        }
                        
                    break;
                    
                    case 'cluster':
                        //CLUSTER        
                        $cl = "SELECT cluster_profile.name_of_cluster,cluster_mst.uin FROM cluster_profile
                                    LEFT JOIN cluster_sub_mst ON cluster_sub_mst.id = cluster_profile.cluster_sub_mst_id
                                    LEFT JOIN cluster_mst ON cluster_mst.id = cluster_sub_mst.cluster_mst_id
                                    WHERE cluster_mst.uin='$uin' AND cluster_sub_mst.status='A'";
                        $clAre = DB::select($cl);
                        if(!empty($clAre)){
                        foreach($clAre as $pval){
                             $pval=(array)$pval;
                        $mdata['cluster'][$pval['uin']]= $pval['name_of_cluster'];
                        }
                        }
                        
                    break;
                    
                    case 'shg':
                        //SHG
                        $sh = "SELECT shg_profile.shgName,shg_mst.uin FROM shg_profile
                                    LEFT JOIN shg_sub_mst ON shg_sub_mst.id = shg_profile.shg_sub_mst_id
                                    LEFT JOIN shg_mst ON shg_mst.id = shg_sub_mst.shg_mst_id
                                    WHERE shg_mst.uin='$uin' AND shg_sub_mst.status='A'";
                        $shAre = DB::select($sh);
                        if(!empty($shAre)){       
                        foreach($shAre as $pval) {
                             $pval=(array)$pval;
                        $mdata['shg'][$pval['uin']]= $pval['shgName'];
                        }
                        }
                        
                    break;
                    
                    case 'family':
                        //FAMILY
                        $fm = "SELECT family_profile.fp_member_name,family_mst.uin FROM family_profile
                                    LEFT JOIN family_sub_mst ON family_sub_mst.id = family_profile.family_sub_mst_id
                                    LEFT JOIN family_mst ON family_mst.id = family_sub_mst.family_mst_id
                                    WHERE family_mst.mst='$uin' AND family_sub_mst.status='A'";
                        $fmAre = DB::select($fm);
                        if(!empty($fmAre)){
                        foreach($fmAre as $pval){
                             $pval=(array)$pval;
                        $mdata['family'][$pval['uin']]= $pval['fp_member_name'];
                        }
                        }
                        
                    break;
                } 
                    
                if(array_key_exists($uin, $mdata[$instute_type])){
                  return $mdata[$instute_type][$uin];
                }else{
                 return array();   
                }
          }
    
     /**
     * Manages all parent of family member.
     */
        public function ManagerWorkDetails($uin) {
          
                $workOfmng['federation'] = array();
                $workOfmng['cluster'] = array();
                $workOfmng['shg'] = array();
                $workOfmng['family'] = array();
                
                $mng = "SELECT * FROM mngwork WHERE mng_uin ='$uin' AND status='A'";
                $mngAre = DB::select($mng);
                if(!empty($mngAre)){       
                foreach($mngAre as $ob1) {
                     $ob1=(array)$ob1;
                $workOfmng[$ob1['section']][$ob1['section_mst_id']]=$ob1['section_uin'];
                }
                }
                
                $family_uin_id = array();
                $fm = "SELECT family_profile.fp_member_name,family_mst.uin,family_mst.id FROM family_profile
                            LEFT JOIN family_sub_mst ON family_sub_mst.id = family_profile.family_sub_mst_id
                            LEFT JOIN family_mst ON family_mst.id = family_sub_mst.family_mst_id
                            WHERE family_sub_mst.status='A'";
                $fmAre = DB::select($fm);
                if(!empty($fmAre)){
                foreach($fmAre as $pval){
                     $pval=(array)$pval;
                $family_uin_id[$pval['uin']]= $pval['id'];
                }
                }
                
                //===============
                $tree = $this->Dynatree_sh();
                if(array_key_exists('shg', $workOfmng)){
                foreach($workOfmng['shg'] as $vob2){
                    foreach($tree as $ob3){
                        if($ob3['uin']==$vob2){
                           foreach($ob3['children'] as $ob4){
                               $workOfmng['family'][$family_uin_id[$ob4['uin']]]=$ob4['uin'];
                           } 
                            
                        }
                    }
                  }
               }
          return $workOfmng;
         }
         
         
     /**
     * Manages all parent of family member.
     */
        public function ChiledofManager() {
             $chiledOfam = array();
             $mag = Yii::app()->db->createCommand("SELECT * FROM users WHERE parent_id=".Yii::app()->user->id)->queryAll();   
             if(!empty($mag)){
                 foreach($mag as $mngid){
                 $chiledOfam[$mngid['id']] = $mngid['id'];
                 }
               }
              return $chiledOfam;
        }  
        
         /**
     * Manages all parent of family member.
     */
        public function CountrytateOfdistrict($distid) {
              
            $lisstAre = array();
            $lisstAre['country'] = '';
            $lisstAre['state'] = '';
            $lisstAre['district'] = '';     
                    
            if($distid){
            $criteria = new CDbCriteria();
            $criteria->compare('id', $distid);
            $district = District::model()->findAll($criteria);
            if(!empty($district)){
            $lisstAre['district'] = $district[0]->name;
            $state_id = $district[0]->state_id;
                    
            $criteria1 = new CDbCriteria();
            $criteria1->compare('id', $state_id);
            $states = States::model()->findAll($criteria1);
            if(!empty($states)){
            $lisstAre['state'] = $states[0]->name;
            $country_id = $states[0]->country_id;
            
            $criteria2 = new CDbCriteria();
            $criteria2->compare('id', $country_id);
            $country = Countries::model()->findAll($criteria2);
            if(!empty($country)){
            $lisstAre['country'] = $country[0]->name;
            }
            }
            }
            }
           return $lisstAre; 
             
        } 
        
        
            /**
     * Manages all parent of family member.
     */
        public function CountrytateOfdistrictbyagency($agency_id) {
              
            $lisstAre = array();
            $lisstAre['country'] = '';
            $lisstAre['state'] = '';
            $lisstAre['district'] = '';     
                
            $criteria = new CDbCriteria();
            $criteria->compare('agency_id', $agency_id);
            $agency = Agency::model()->findAll($criteria);
            if(!empty($agency)){
            $distid = $agency[0]->district;
            if($distid){
            $criteria = new CDbCriteria();
            $criteria->compare('id', $distid);
            $district = District::model()->findAll($criteria);
            if(!empty($district)){
            $lisstAre['district'] = $district[0]->name;
            $state_id = $district[0]->state_id;
                    
            $criteria1 = new CDbCriteria();
            $criteria1->compare('id', $state_id);
            $states = States::model()->findAll($criteria1);
            if(!empty($states)){
            $lisstAre['state'] = $states[0]->name;
            $country_id = $states[0]->country_id;
            
            $criteria2 = new CDbCriteria();
            $criteria2->compare('id', $country_id);
            $country = Countries::model()->findAll($criteria2);
            if(!empty($country)){
            $lisstAre['country'] = $country[0]->name;
            }
            }
            }
            }
           return $lisstAre; 
          }    
        }
        
        
       
     /**
     * Manages all parent of family member.
     */
    public function InstutinalRatingcnt($instute_type,$mstid) {
    
            $mdata = 0;
                    
            switch ($instute_type){
                    case 'federation':
                        //FEDERATION
                    
                    break;
                    
                    case 'cluster':
                        //CLUSTER        
                    
                    break;
                    
                    case 'shg':
                        //SHG
                    
                        
                    break;
                    
                    case 'family':
                        //FAMILY
                        $query = "SELECT count(*) as cnt FROM family_sub_mst WHERE rating = 'D' AND family_mst_id = $mstid";
                        $fmAre =DB::select($query);
                        $fmAre =(array)$fre;
                        if(!empty($fmAre)){
                        $mdata = $fmAre[0]['cnt'];
                        }
                        
                    break;
                } 
                    
              return $mdata;      
          } 
                    
        
        
   
}
