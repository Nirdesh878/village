<?php

namespace App\Http\Controllers\API\v1;
use App\Models\TaskQaAssignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;


class RatingController extends Controller
{

    public function __construct()
    {

    }

    public function remove_element_by_key($arr) {
        $return = array();
        foreach($arr as $k => $v) {
           if(is_array($v)) {
              $return[$k] = $this->remove_element_by_key($v); //recursion
              continue;
           }
           if(($k == 'created_at') || ($k == 'created_by') || ($k == 'updated_at') || ($k == 'updated_by') || ($k == 'is_deleted') || ($k == 'country_id') || ($k == 'state_id') || ($k == 'district_id')) continue;
           $return[$k] = $v;
        }
        return $return;
     }

    public function index(Request $request)
    {
        $resAre = array();
        $ruleare = array();
        $data = array();
        $qp = array();
        $qpoint = 0;
        $qpd1 = array();
        $qpd2 = array();

        $q1 = "SELECT mst_ques_id, mst_point as qpoint FROM rating_mst_qam_set WHERE mst_status='A'";
        $result1 = DB::select($q1);
        // prd($result1);
        if (!empty($result1)) {
                    foreach ($result1 as $res) {
                $qpd1[$res->mst_ques_id][] = $res->qpoint;
            }
        }
        if (count($qpd1) > 0) {
            foreach ($qpd1 as $keys => $vsval) {
                $qpd2[$keys] = max($vsval);
            }
        }

        $q2 = "SELECT rating_mst_qam_set.mst_id as id, rating_mst_qam_set.mst_ques_id as mqid, rating_mst_qam_set.mst_sub_category_id as icatid, rating_mst_qam_set.mst_point as point, rating_mst_qam_set.mst_ans_name as ansname, rating_mst_category.mst_cat_name as category,rating_mst_sub_category.mst_subcat_name as subcategory,rating_mst_ques_list.mst_ques_name as qname FROM rating_mst_qam_set LEFT JOIN rating_mst_category ON rating_mst_category.mst_id=rating_mst_qam_set.mst_category_id LEFT JOIN rating_mst_sub_category ON rating_mst_sub_category.mst_id=rating_mst_qam_set.mst_sub_category_id LEFT JOIN rating_mst_ques_list ON rating_mst_ques_list.mst_id=rating_mst_qam_set.mst_ques_id where rating_mst_category.mst_cat_status='A' AND rating_mst_sub_category.mst_subcat_status='A' AND rating_mst_ques_list.mst_ques_status='A' AND rating_mst_qam_set.mst_status='A' order by rating_mst_qam_set.mst_sub_category_id asc, rating_mst_qam_set.mst_ques_id asc, rating_mst_qam_set.mst_id asc";
        $result2 = DB::select($q2);
          if (!empty($result2)) {
                    foreach ($result2 as $res1) {
                if ($qpd2[$res1->mqid]) {
                    $qpoint = $qpd2[$res1->mqid];
                }
                $resAre[$res1->category][$res1->icatid][$res1->subcategory][$res1->mqid][$res1->qname][] = array('id' => $res1->id, 'ans' => $res1->ansname, 'point' => $res1->point, 'quespoint' => $qpoint);
            }
        }
        $data['institution'] = $this->remove_element_by_key($resAre);
        echo json_encode($data);
    }
}
