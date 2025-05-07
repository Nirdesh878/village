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


class ClusterLoans implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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

        $query = "WITH Rankes AS (SELECT
        f.id,
        f.uin,
        fp.fp_member_name,
        fp.fp_wealth_rank,
        sp.shgName,
        cp.name_of_cluster,
        fedp.name_of_federation,
        fp.analysis_rating,
        fl.lo_principle_amount,
        fl.lo_purpose,
        fl.lo_interest_type,
        fl.lo_interest_rate,
        fl.lo_no_of_tenure,
        (case when fl.lo_tenure_mode = 1 then 'Year'
        when fl.lo_tenure_mode = 0 then 'Month' END ) AS tenure_mode,
        fl.lo_start_date,
        fl.lo_last_Repayment_to_paid,
        fl.total_paid_interest,
        fl.overdue,
        fl.lo_next_year,
        fl.cate_specify,
         ROW_NUMBER() OVER (PARTITION BY f.id ORDER BY fl.id) AS loans
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
        LEFT JOIN family_loan_outstanding AS fl
        ON f.id = fl.family_sub_mst_id

	 WHERE  s.is_deleted = 0 AND f.is_deleted = 0 AND fl.lo_type ='Cluster Loan' ";

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

        $query .= " ORDER  BY f.id ) ";
        // prd($query);
        $query .= "SELECT
         loans,
             id,
             uin,
             fp_member_name,
             fp_wealth_rank,
             shgName,
             name_of_cluster,
             name_of_federation,
             analysis_rating,
             MAX(CASE WHEN loans = 1 THEN lo_principle_amount END) AS lo_principle_amount1,
              MAX(CASE WHEN loans = 1 THEN lo_purpose END) AS lo_purpose1,
              MAX(CASE WHEN loans = 1 THEN lo_interest_type END) AS lo_interest_type1,
              MAX(CASE WHEN loans = 1 THEN lo_interest_rate END) AS lo_interest_rate1,
              MAX(CASE WHEN loans = 1 THEN lo_no_of_tenure END) AS lo_no_of_tenure1,
              MAX(CASE WHEN loans = 1 THEN tenure_mode END) AS tenure_mode1,
              MAX(CASE WHEN loans = 1 THEN lo_start_date END) AS lo_start_date1,
              MAX(CASE WHEN loans = 1 THEN lo_last_Repayment_to_paid END) AS lo_last_Repayment_to_paid1,
              MAX(CASE WHEN loans = 1 THEN total_paid_interest END) AS total_paid_interest1,
              MAX(CASE WHEN loans = 1 THEN overdue END) AS overdue1,
              MAX(CASE WHEN loans = 1 THEN lo_next_year END) AS lo_next_year1,
              MAX(CASE WHEN loans = 1 THEN cate_specify END) AS cate_specify1,


              MAX(CASE WHEN loans = 2 THEN lo_principle_amount END) AS lo_principle_amount2,
              MAX(CASE WHEN loans = 2 THEN lo_purpose END) AS lo_purpose2,
              MAX(CASE WHEN loans = 2 THEN lo_interest_type END) AS lo_interest_type2,
              MAX(CASE WHEN loans = 2 THEN lo_interest_rate END) AS lo_interest_rate2,
              MAX(CASE WHEN loans = 2 THEN lo_no_of_tenure END) AS lo_no_of_tenure2,
              MAX(CASE WHEN loans = 2 THEN tenure_mode END) AS tenure_mode2,
              MAX(CASE WHEN loans = 2 THEN lo_start_date END) AS lo_start_date2,
              MAX(CASE WHEN loans = 2 THEN lo_last_Repayment_to_paid END) AS lo_last_Repayment_to_paid2,
              MAX(CASE WHEN loans = 2 THEN total_paid_interest END) AS total_paid_interest2,
              MAX(CASE WHEN loans = 2 THEN overdue END) AS overdue2,
              MAX(CASE WHEN loans = 2 THEN lo_next_year END) AS lo_next_year2,
              MAX(CASE WHEN loans = 2 THEN cate_specify END) AS cate_specify2,


              MAX(CASE WHEN loans = 3 THEN lo_principle_amount END) AS lo_principle_amount3,
              MAX(CASE WHEN loans = 3 THEN lo_purpose END) AS lo_purpose3,
              MAX(CASE WHEN loans = 3 THEN lo_interest_type END) AS lo_interest_type3,
              MAX(CASE WHEN loans = 3 THEN lo_interest_rate END) AS lo_interest_rate3,
              MAX(CASE WHEN loans = 3 THEN lo_no_of_tenure END) AS lo_no_of_tenure3,
              MAX(CASE WHEN loans = 3 THEN tenure_mode END) AS tenure_mode3,
              MAX(CASE WHEN loans = 3 THEN lo_start_date END) AS lo_start_date3,
              MAX(CASE WHEN loans = 3 THEN lo_last_Repayment_to_paid END) AS lo_last_Repayment_to_paid3,
              MAX(CASE WHEN loans = 3 THEN total_paid_interest END) AS total_paid_interest3,
              MAX(CASE WHEN loans = 3 THEN overdue END) AS overdue3,
              MAX(CASE WHEN loans = 3 THEN lo_next_year END) AS lo_next_year3,
              MAX(CASE WHEN loans = 3 THEN cate_specify END) AS cate_specify3



               FROM Rankes
               GROUP BY id
         ";
        // prd($query);
        $familys = DB::select($query);
        // prd($familys);
        return collect($familys);
    }

    public function map($res): array
    {


        return [
            $this->counter++,
            $res->uin,
            $res->fp_member_name,
            $res->shgName,
            $res->name_of_cluster,
            $res->name_of_federation,
            $res->fp_wealth_rank,
            $res->analysis_rating,

            $res->lo_principle_amount1,
            $res->lo_purpose1,
            $res->lo_interest_type1,
            $res->lo_interest_rate1,
            $res->lo_no_of_tenure1,
            $res->tenure_mode1,
            $res->lo_start_date1,
            $res->lo_last_Repayment_to_paid1,
            $res->total_paid_interest1,
            $res->overdue1,
            $res->lo_next_year1,
            $res->cate_specify1,

            $res->lo_principle_amount2,
            $res->lo_purpose2,
            $res->lo_interest_type2,
            $res->lo_interest_rate2,
            $res->lo_no_of_tenure2,
            $res->tenure_mode2,
            $res->lo_start_date2,
            $res->lo_last_Repayment_to_paid2,
            $res->total_paid_interest2,
            $res->overdue2,
            $res->lo_next_year2,
            $res->cate_specify2,

            $res->lo_principle_amount3,
            $res->lo_purpose3,
            $res->lo_interest_type3,
            $res->lo_interest_rate3,
            $res->lo_no_of_tenure3,
            $res->tenure_mode3,
            $res->lo_start_date3,
            $res->lo_last_Repayment_to_paid3,
            $res->total_paid_interest3,
            $res->overdue3,
            $res->lo_next_year3,
            $res->cate_specify3,


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
                $event->sheet->getStyle('A1:AO1')->applyFromArray([
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

                'CLUSTER LOAN - PRINCIPAL AMOUNT  1',
                'CLUSTER LOAN - PURPOSE 1',
                'CLUSTER LOAN - INTEREST TYPE 1',
                'CLUSTER LOAN - RATE OF INTEREST  1',
                'CLUSTER LOAN - TENURE 1',
                'CLUSTER LOAN - TENURE MODE 1',
                'CLUSTER LOAN - Repayment Start Date  1',
                'CLUSTER LOAN -  Last Repayment date 1',
                'CLUSTER LOAN - TOTAL CUMULATIVE REPAID AMOUNT  1',
                'CLUSTER LOAN - OVERDUE AMOUNT  1',
                'CLUSTER LOAN - Next year Loan repayment commitmen  1',
                'CLUSTER LOAN - SPECIFY 1',


                'CLUSTER LOAN - PRINCIPAL AMOUNT 2',
                'CLUSTER LOAN - PURPOSE 2',
                'CLUSTER LOAN - INTEREST TYPE 2',
                'CLUSTER LOAN - RATE OF INTEREST  2',
                'CLUSTER LOAN - TENURE 2',
                'CLUSTER LOAN - TENURE MODE 2',
                'CLUSTER LOAN - Repayment Start Date  2',
                'CLUSTER LOAN -  Last Repayment date 2',
                'CLUSTER LOAN - TOTAL CUMULATIVE REPAID AMOUNT  2',
                'CLUSTER LOAN - OVERDUE AMOUNT  2',
                'CLUSTER LOAN - Next year Loan repayment commitmen  2',
                'CLUSTER LOAN -  SPECIFY 2',


                'CLUSTER LOAN - PRINCIPAL AMOUNT 3',
                'CLUSTER LOAN - PURPOSE 3',
                'CLUSTER LOAN - INTEREST TYPE 3',
                'CLUSTER LOAN - RATE OF INTEREST  3',
                'CLUSTER LOAN - TENURE 3',
                'CLUSTER LOAN - TENURE MODE 3',
                'CLUSTER LOAN - Repayment Start Date  3',
                'CLUSTER LOAN -  Last Repayment date 3',
                'CLUSTER LOAN - TOTAL CUMULATIVE REPAID AMOUNT  3',
                'CLUSTER LOAN - OVERDUE AMOUNT  3',
                'CLUSTER LOAN - Next year Loan repayment commitmen  3',
                'CLUSTER LOAN - SPECIFY  3',


            ]
        ];
    }

    public function title(): string
    {
        return 'Family Cluster Loan';
    }
}
