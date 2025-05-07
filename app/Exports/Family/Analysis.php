<?php

namespace App\Exports\Family;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;


class Analysis implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
{
    public $curdate = '';
    public $counter = 1;
    public function __construct()
    {
        $this->curdate = Carbon::now()->format('d-m-Y');
    }

    public function collection()
    {

        $user = Auth::user();
        $session_data = Session::get('family_export_session');

        $isClusterSelected = !empty($session_data['cluster']);

        $query = "SELECT
        f.id,
        f.uin,
        fp.fp_member_name,
        sp.shgName,
        cp.name_of_cluster,
        fedp.name_of_federation,
        fp.fp_gender,
        fp.fp_age,
        fp.fp_wealth_rank,
        fp.analysis_rating

     FROM
        family_mst AS f 
        INNER JOIN family_profile AS fp ON f.id = fp.family_sub_mst_id
        INNER JOIN shg_mst AS s ON f.shg_uin = s.uin
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        WHERE  s.is_deleted = 0 AND f.is_deleted = 0 ";

        if ($isClusterSelected) {
            $query .= " AND c.is_deleted = 0 ";
        }

        if (!empty($session_data['Search'])) {
            if (!empty($session_data['agency'])) {
                $agency = $session_data['agency'];
                $query .= " AND f.agency_id = $agency  ";
            }
            if (!empty($session_data['federation'])) {
                $query .= " AND fed.uin = '" . $session_data['federation'] . "' ";
            }
            if (!empty($session_data['cluster'])) {
                $query .= " AND c.uin = '" . $session_data['cluster'] . "' ";
            }
            if (!empty($session_data['shg'])) {
                $query .= " AND s.uin = '" . $session_data['shg'] . "' ";
            }
            if (!empty($session_data['family'])) {
                $query .= " AND f.uin = '" . $session_data['family'] . "' ";
            }
        }



        $query .= " GROUP BY f.id  ORDER BY f.id
         ";
        // prd($query);
        $familys = DB::select($query);
        // prd($familys);
        $data = [];
        foreach ($familys as $res) {

            $data[] = $this->family_analysis($res->id);
        }
        // die();
        // prd($data);
        return collect($data);
    }

    public function map($res): array
    {


        return [
            $this->counter++,
            $res['UIN'],
            $res['Family_Name'],
            $res['SHG_Nmae'],
            $res['Cluster_Name'],
            $res['Fedeartion_Name'],
            $res['Wealth_Rank'],
            $res['Rating_score'],

            (string)$res['analysis_1_cy'],
            (string)$res['analysis_2_cy'],
            (string)$res['analysis_3_cy'],
            (string)$res['analysis_4_cy'],
            (string)$res['analysis_other'],
            (string)$res['analysis_5_cy'],
            (string)$res['analysis_6_cy'],
            (string)$res['analysis_7_cy'],
            (string)$res['analysis_8_cy'],
            (string)$res['analysis_10_cy'],
            (string)$res['analysis_11_cy'],
            (string)$res['analysis_12_ny'],
            (string)$res['analysis_13_ny'],


        ];
    }

    public function columnFormats(): array
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:U1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'color' => ['argb' => '#CCCCCC']
                    ]
                ]);
            },
        ];
    }

    public function headings(): array
    {
        return [

            [
                'S.No',
                'UIN',
                'SHG MEMBER NAME',
                'NAME OF SHG',
                'CLUSTER NAME ',
                'FEDERATION NAME',
                'WEALTH/POVERTY RANKING',
                'RISK RATING/SCORE CARD',

                'Income -Expenditure Gap during last 12 months',
                'Income and Expenditure ratio',
                'Regularity of Savings (compulsory savings during 12 months)',
                'Voluntary savings during last 12 months',
                'Other savings during 12 months',
                'Annual Savings to annual income',
                'Passbook in possession',
                'Annual Income and Loan Repayment Ratio',
                'Debt-Service-Ratio',
                'Internal & External loan Overdue',
                'Family Indebtedness',
                'Meeting Attendance',
                'Understanding of SHG Rules'
            ]
        ];
    }

    public function title(): string
    {
        return 'Family Analysis';
    }

    function family_analysis($family_id)
    {

        $session_data = Session::get('family_export_session');
        // prd($session_data);

        $isClusterSelected = !empty($session_data['cluster']);

        // pr($family_id);
        $query = "SELECT
            f.id,
            f.uin AS UIN,
            fp.fp_member_name AS Family_Name,
            fp.fp_wealth_rank AS Wealth_Rank,
            sp.shgName AS SHG_Nmae,
            cp.name_of_cluster AS Cluster_Name,
            fedp.name_of_federation AS Fedeartion_Name,
            fp.analysis_rating AS Rating_score
         FROM
            family_mst AS f 
            INNER JOIN family_profile AS fp ON f.id = fp.family_sub_mst_id
            INNER JOIN shg_mst AS s ON f.shg_uin = s.uin
            INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
            LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
            LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
            INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
            INNER JOIN federation_profile AS fedp
            ON fed.id = fedp.federation_sub_mst_id
            WHERE  s.is_deleted = 0 AND f.is_deleted = 0 AND f.id = $family_id
            ORDER  BY f.id";

        if ($isClusterSelected) {
            $query .= " AND c.is_deleted = 0 ";
        }

        $family_info = DB::select($query)[0];
        // prd($family_info);
        $data['id'] = $family_info->id;
        $data['UIN'] = $family_info->UIN;
        $data['Family_Name'] = $family_info->Family_Name;
        $data['Wealth_Rank'] = $family_info->Wealth_Rank;
        $data['SHG_Nmae'] = $family_info->SHG_Nmae;
        $data['Cluster_Name'] = $family_info->Cluster_Name;
        $data['Fedeartion_Name'] = $family_info->Fedeartion_Name;
        $data['Rating_score'] = $family_info->Rating_score;

        $analysis_this_year = DB::table('family_analysis_this_year as a')
            ->where('is_deleted', '=', 0)
            ->where('a.family_sub_mst_id', '=', $family_id)
            ->get()->toArray();

        $analysis_next_year = DB::table('family_analysis_next_year as a')
            ->where('is_deleted', '=', 0)
            ->where('a.family_sub_mst_id', '=', $family_id)
            ->get()->toArray();

        $query = "SELECT
                    COALESCE(SUM(a.sum),
                    0) AS expenditure_this_total
                FROM
                    (
                    SELECT
                        a.s_type AS TYPE,
                        a.s_last_saved_amt AS SUM
                    FROM
                        family_savings_source AS a
                    WHERE
                        a.family_sub_mst_id = $family_id
                    UNION ALL
                SELECT
                    b.other_loan AS TYPE,
                    b.last_saved_amt AS SUM
                FROM
                    family_savings_source_other AS b
                WHERE
                    b.family_sub_mst_id = $family_id
                UNION ALL
                SELECT
                    c.e_cat AS TYPE,
                    c.e_total_amount AS SUM
                FROM
                    family_expenditure_this_year c
                WHERE
                    c.family_sub_mst_id = $family_id
                UNION ALL
                SELECT
                    d.lo_type AS TYPE,
                    d.current_year_interest AS SUM
                FROM
                    family_loan_outstanding d
                WHERE
                    d.family_sub_mst_id = $family_id
                ) a";
        $total_expenditure_this = DB::select($query);

        $query = "SELECT
            COALESCE(e_total_amount, 0) AS income
            FROM
                family_income_this_year
            WHERE
                family_sub_mst_id = $family_id";
        $total_income_this_year = DB::select($query);



        $total_expenditure = $total_expenditure_this[0]->expenditure_this_total;
        $total_income_this =  $total_income_this_year[0]->income;

        //analysis 1 current year
        $data['analysis_1_cy'] = 0;
        // $ana_this = $analysis_this_year[0]->a_i_e_gap;
        if ($total_income_this > 0 || $total_expenditure > 0) {
            if ($total_income_this > $total_expenditure) {
                $data['analysis_1_cy'] = 5;
            } elseif ($total_income_this == $total_expenditure) {
                $data['analysis_1_cy'] = 3;
            } elseif ($total_income_this < $total_expenditure) {
                $data['analysis_1_cy'] = 0;
            }
        }



        $query = "SELECT
                    COALESCE(SUM(a.sum),
                    0) AS expenditure_next_total
                FROM
                    (

                SELECT
                    c.e_cat AS TYPE,
                    c.e_total_amount AS SUM
                FROM
                    family_expenditure_next_year c
                WHERE
                    c.family_sub_mst_id = $family_id
                UNION ALL
                SELECT
                    d.lo_type AS TYPE,
                    d.lo_next_year AS SUM
                FROM
                    family_loan_outstanding d
                WHERE
                    d.family_sub_mst_id = $family_id
                ) a";
        $total_expenditure_next_year = DB::select($query);

        $query = "SELECT
                COALESCE(e_total_amount, 0) AS income
                FROM
                    family_income_this_year
                WHERE
                    family_sub_mst_id = $family_id";
        $total_income_next_year = DB::select($query);
        $total_expenditure_next = 0;
        if ($total_expenditure_next_year[0]->expenditure_next_total != '') {
            $total_expenditure_next = $total_expenditure_next_year[0]->expenditure_next_total;
        }
        $total_income_next = 0;
        if ($total_income_next_year[0]->income != '') {
            $total_income_next =  $total_income_next_year[0]->income;
        }

        //analysis 1 next year
        $data['analysis_1_ny'] = 0;
        // $ana_ny = $analysis_next_year[0]->a_i_e_gap;
        if ($total_income_next > 0 || $total_expenditure_next > 0) {
            if ($total_income_next > $total_expenditure_next) {
                $data['analysis_1_ny'] = 5;
            } elseif ($total_income_next == $total_expenditure_next) {
                $data['analysis_1_ny'] = 3;
            } elseif ($total_income_next < $total_expenditure_next) {
                $data['analysis_1_ny'] = 0;
            }
        }


        //analysis 2 current year
        $count2_cy = '';
        $data['analysis_2_cy'] = 0;
        $average_2_cy = (float) $analysis_this_year[0]->a_i_e_ratio;

        if ($average_2_cy != 0) {
            $count2_cy = (($average_2_cy <= 80 ? 10 : ($average_2_cy <= 90 ? 7 : ($average_2_cy <= 100 ? 5 : 1))));
            $data['analysis_2_cy'] = $count2_cy;
        }

        //analysis 2 next year
        $count2_ny = '';
        $data['analysis_2_ny'] = 0;
        $average_2_ny = (float) $analysis_next_year[0]->a_i_e_ratio;
        if ($average_2_ny != 0) {
            $count2_ny = (($average_2_ny <= 80 ? 10 : ($average_2_ny <= 90 ? 7 : ($average_2_ny <= 100 ? 5 : 1))));
            $data['analysis_2_ny'] = $count2_ny;
        }

        //analysis 3 current year
        $count3_cy = '';
        $data['analysis_3_cy'] = 0;
        $query = "SELECT * FROM family_savings_source where family_sub_mst_id=$family_id and s_type = 'Compulsory' ";
        $compulsory = DB::select($query);
        if (!empty($compulsory)) {
            $save_per_month = $compulsory[0]->s_saving_per_month;
            $expected_amt = $save_per_month * 12;
            $s_last_saved_amt = $compulsory[0]->s_last_saved_amt;
            if ($s_last_saved_amt > 0 && $expected_amt > 0) {
                $average_3_cy = (($s_last_saved_amt / $expected_amt) * 100);
            } else {
                $average_3_cy = 0;
            }

            $data['analysis_3_cy'] = $average_3_cy > 99 ? 10 : ($average_3_cy >= 85 ? 8 : ($average_3_cy >= 75 ? 6 : 2));
        }

        //analysis 34current year
        $data['analysis_4_cy'] = 0;
        $quer4 = "SELECT s_contribute_regular FROM family_savings_source where family_sub_mst_id=$family_id and s_type = 'Voluntary' ";
        $average_4_cy = DB::select($quer4);

        if (!empty($average_4_cy)) {
            if ($average_4_cy[0]->s_contribute_regular == 'Yes') {
                $data['analysis_4_cy'] = 2;
            } else {
                $data['analysis_4_cy'] = 0;
            }
        }

        //analysis 35current year
        $data['analysis_other'] = 0;
        $query = "SELECT other_amount FROM family_savings_source_other where family_sub_mst_id=$family_id  ";
        $average_other = DB::select($query);

        if (!empty($average_other)) {
            $count_other = $average_other[0]->other_amount != '' ? 5 : 0;
            if ($average_other[0]->other_amount != '') {
                $data['analysis_other'] = 2;
            } else {
                $data['analysis_other'] = 0;
            }
        }

        $query = "SELECT
                        COALESCE(SUM(a.sum), 0) AS saving_total
                    FROM
                        (
                        SELECT
                            a.s_last_saved_amt AS SUM
                        FROM
                            family_savings_source AS a
                        WHERE
                            a.family_sub_mst_id = $family_id
                        UNION ALL
                    SELECT
                        b.last_saved_amt AS SUM
                    FROM
                        family_savings_source_other AS b
                    WHERE
                        b.family_sub_mst_id = $family_id
                    ) a";

        $saving_total_this = DB::select($query);

        //analysis 5 current year

        $saving_total = $saving_total_this[0]->saving_total;
        $data['analysis_5_cy'] = 0;
        $average_5_cy = '';
        if ($saving_total > 0 && $total_income_this > 0) {
            $average_5_cy = (float) (($saving_total / $total_income_this) * 100);
        }
        if ($average_5_cy != '') {
            $data['analysis_5_cy'] = (($average_5_cy >= 10 ? 8 : ($average_5_cy >= 5 ? 7 : ($average_5_cy >= 2 ? 5 : 2))));
        }


        //analysis 5 next year
        $data['analysis_5_ny'] = 0;
        $average_5_ny = '';
        if ($saving_total > 0 && $total_income_next > 0) {
            $average_5_ny = (float) (($saving_total / $total_income_next) * 100);
        }
        if ($average_5_ny != '') {
            $data['analysis_5_ny'] = (($average_5_ny >= 10 ? 8 : ($average_5_ny >= 5 ? 7 : ($average_5_ny >= 2 ? 5 : 2))));
        }


        //analysis 6 current year
        $savings = DB::table('family_savings as a')
            ->where('is_deleted', '=', 0)
            ->where('a.family_sub_mst_id', '=', $family_id)
            ->get()->toArray();

        $data['analysis_6_cy'] = 0;
        $average_6_cy = $savings[0]->s_passbook_physically;
        if ($average_6_cy != '') {
            if ($average_6_cy == 1) {
                $data['analysis_6_cy'] = 1;
            } else {
                $data['analysis_6_cy'] = 0;
            }
        }

        //analysis 7 current year
        $count7_cy = '';
        $data['analysis_7_cy'] = 0;
        $average_7_cy = $analysis_this_year[0]->a_alr_i_ratio;
        if ($average_7_cy != '') {
            $count7_cy = (($average_7_cy <= 25 ? 10 : ($average_7_cy <= 35 ? 7 : ($average_7_cy <= 50 ? 5 : ($average_7_cy > 50 ? 2 : 0)))));
            $data['analysis_7_cy'] = $count7_cy;
        }

        //analysis 7 next year
        $count7_ny = '';
        $data['analysis_7_ny'] = 0;
        $average_7_ny = $analysis_next_year[0]->a_alr_i_ratio;
        if ($average_7_ny != '') {
            $count7_ny = (($average_7_ny <= 25 ? 10 : ($average_7_ny <= 35 ? 7 : ($average_7_ny <= 50 ? 5 : ($average_7_ny > 50 ? 2 : 0)))));
            $data['analysis_7_ny'] = $count7_ny;
        }

        //analysis 8 current year
        $count8_cy = '';
        $data['analysis_8_cy'] = 0;
        $average_8_cy = (float) $analysis_this_year[0]->a_debit_ratio;
        if ($average_8_cy != '') {
            $count8_cy = (($average_8_cy >= 1.25 ? 10 : ($average_8_cy >= 1.00 ? 7 : ($average_8_cy >= 0.5 ? 3 : 0))));
            $data['analysis_8_cy'] = $count8_cy;
        }

        //analysis 8 next year
        $count8_ny = '';
        $data['analysis_8_ny'] = 0;
        $average_8_ny = (float) $analysis_next_year[0]->a_debit_ratio;
        if ($average_8_ny != '') {
            $count8_ny = (($average_8_ny >= 1.25 ? 10 : ($average_8_ny >= 1.00 ? 7 : ($average_8_ny >= 0.5 ? 3 : 0))));
            $data['analysis_8_ny'] = $count8_ny;
        }

        //analysis 9 current year
        $loan_outstanding = DB::table('family_loan_outstanding as a')
            ->where('is_deleted', '=', 0)
            ->where('a.family_sub_mst_id', '=', $family_id)
            ->get()->toArray();
        $count9_cy = '';
        $data['analysis_9_cy'] = 0;
        $sum_overdue_cy = 0;
        $sum_emi_cy = 0;
        foreach ($loan_outstanding as $row) {

            if ($row->lo_type == 'SHG Loan' && $row->overdue != '') {

                $sum_overdue_cy = $sum_overdue_cy + $row->overdue;
                $sum_emi_cy = $sum_emi_cy + $row->monthly_emi;
            }
            if ($row->lo_type == '' && $row->overdue == '') {
                $sum_overdue_cy = '';
                $sum_emi_cy = '';
            }
        }

        if ($sum_overdue_cy != '' || $sum_emi_cy != '') {
            if ($sum_emi_cy > 0) {
                $average_9_cy = round(($sum_overdue_cy / $sum_emi_cy), 2);

                $count9_cy = (($average_9_cy < 1 ? 5 : ($average_9_cy < 2 ? 3 : ($average_9_cy <= 4 ? 1 : 0))));
                $data['analysis_9_cy'] = $count9_cy;
            } else {
                $data['analysis_9_cy'] = 5;
            }
        } else {
            $data['analysis_9_cy'] = 5;
        }

        $query = "SELECT fp_wealth_rank FROM family_profile where family_sub_mst_id = $family_id";
        $wealth_rank = DB::select($query)[0]->fp_wealth_rank;

        //analysis 10 current year
        $count10_cy = '';
        $data['analysis_10_cy'] = 0;
        if (!empty($wealth_rank)) {
            $data['analysis_10_cy'] = 10;
        }

        $sum_emi_money = 0;
        $sum_overdue_money = 0;
        $num = 0;
        $no_of_days = 0;
        // pr($loan_outstanding);
        if (!empty($loan_outstanding)) {
            foreach ($loan_outstanding as $row) {
                if ($row->lo_type == 'SHG Loan') {

                    $num = $num + 1;
                    $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                    $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                    if ($row->overdue > 0 && $row->monthly_emi > 0) {
                        $no_of_days =   (int) $no_of_days + ($row->overdue  / $row->monthly_emi);
                    } else {
                        $no_of_days = 0;
                    }
                }

                if ($row->lo_type == 'Money Lenders Loan') {
                    $num = $num + 1;
                    $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                    $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                    if ($row->overdue > 0 && $row->monthly_emi > 0) {
                        $no_of_days =   (int) $no_of_days + ($row->overdue  / $row->monthly_emi);
                    } else {
                        $no_of_days = 0;
                    }
                }
                if ($row->lo_type == 'Bank Loan') {
                    $num = $num + 1;
                    $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                    $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                    if ($row->overdue > 0 && $row->monthly_emi > 0) {
                        $no_of_days =   (int) $no_of_days + ($row->overdue  / $row->monthly_emi);
                    } else {
                        $no_of_days = 0;
                    }
                }
                if ($row->lo_type == 'Federation Loan') {
                    $num = $num + 1;
                    $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                    $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                    if ($row->overdue > 0 && $row->monthly_emi > 0) {
                        $no_of_days =   (int) $no_of_days + ($row->overdue  / $row->monthly_emi);
                    } else {
                        $no_of_days = 0;
                    }
                }
                if ($row->lo_type == 'Cluster Loan') {
                    $num = $num + 1;
                    $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                    $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                    if ($row->overdue > 0 && $row->monthly_emi > 0) {
                        $no_of_days =   (int) $no_of_days + ($row->overdue  / $row->monthly_emi);
                    } else {
                        $no_of_days = 0;
                    }
                }
                if ($row->lo_type == 'Other Private Loan') {
                    $num = $num + 1;
                    $sum_overdue_money = $sum_overdue_money + ($row->overdue != '' ? $row->overdue : 0);
                    $sum_emi_money = $sum_emi_money + $row->monthly_emi;
                    if ($row->overdue > 0 && $row->monthly_emi > 0) {
                        $no_of_days =   (int) $no_of_days + ($row->overdue  / $row->monthly_emi);
                    } else {
                        $no_of_days = 0;
                    }
                }
            }
            if (!empty($no_of_days)) {
                $average_10_cy = $no_of_days * 30;
                $data['analysis_10_cy'] = (($average_10_cy <= 30 ? 20 : ($average_10_cy <= 60 ? 12 : ($average_10_cy <= 120 ? 6 : 2))));
            }
        }

        //analysis 11 current year
        $count11_cy = '';
        $data['analysis_11_cy'] = 0;
        $average_11_cy = $analysis_this_year[0]->family_indebtedness;

        if ($average_11_cy != '') {
            $count11_cy = (($average_11_cy < 20 ? 10 : ($average_11_cy <= 40 ? 7 : ($average_11_cy <= 50 ? 3 : 0))));
            $data['analysis_11_cy'] = $count11_cy;
        }

        //analysis 12 current year
        $shgmember_commitment = DB::table('family_shgmember_commitment as a')
            ->where('is_deleted', '=', 0)
            ->where('a.family_sub_mst_id', '=', $family_id)
            ->get()->toArray();
        $count12_ny = '';
        $data['analysis_12_ny'] = 0;
        $average_12_ny = $shgmember_commitment[0]->yo_meeting_yes_no;

        if ($average_12_ny != '') {
            $count12_ny = ($average_12_ny == 'Yes' ? 10 : 0);
            $data['analysis_12_ny'] = $count12_ny;
        }

        //analysis 13 next year
        $count13_ny = '';
        $data['analysis_13_ny'] = 0;
        $average_13_ny = $shgmember_commitment[0]->yo_member_aware_categories;
        // prd( $average_13_ny);
        if ($average_13_ny != '') {
            $count13_ny = $average_13_ny == "Strong" ? 2 : ($average_13_ny == "Average" ? 1 : ($average_13_ny == "Weak" ? 0 : 0));
            $data['analysis_13_ny'] = $count13_ny;
        }

        return $data;
    }
}
