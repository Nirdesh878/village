<?php

namespace App\Exports\Shg;

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


class SHGCRecoveryDCB implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $session_data = Session::get('shg_export_session');
        // prd($session_data);

        $isClusterSelected = !empty($session_data['cluster']);

        $query = "SELECT 
        s.id,
        s.uin AS uin ,
        sp.shgName AS shg_name,
        sp.analysis_rating AS Risk_Rating,
        sp.shg_code AS NRLM_code,
        cp.name_of_cluster AS cluster_name,
        fedp.name_of_federation AS federation_name,
        sp.village AS village,
        sc.internal_loan_amount AS `DCB_Internal_Loan_Total_Amount_of_Loan_given`,
        sc.dcb_internal AS `DCB_Internal_Loan_Total_Demand_upto_Last_month`,
        sc.repaid_internal AS `DCB_Internal_Loan_Actual_Amount_Repaid_upto_last_month`,
        sc.overdue_internal AS `DCB_Internal_Loan_Overdue_amount`,
        sc.current_outstanding_internal AS `DCB_Internal_Loan_Outstanding_amount`,
        sc.repayment_internal AS `DCB_Internal_Loan_Repayment_Ratio`,

        sc.cluster_loan_amount AS `DCB_Cluster_Loan_Loan_Total_Amount_of_Loan_given`,
        sc.dcb_cluster AS `DCB_Cluster_Loan_Total_Demand_upto_Last_month`,
        sc.repaid_cluster AS `DCB_Cluster_Loan_Actual_Amount_Repaid_upto_last_month`,
        sc.overdue_cluster AS `DCB_Cluster_Loan_Overdue_amount`,
        sc.current_outstanding_cluster AS `DCB_Cluster_Loan_Outstanding_amount`,
        sc.repayment_cluster AS `DCB_Cluster_Loan_Repayment_Ratio`,

        sc.federation_loan_amount AS `DCB_Federation_Loan_Total_Amount_of_Loan_given`,
        sc.dcb_federation AS `DCB_Federation_Loan_Total_Demand_upto_Last_month`,
        sc.repaid_federation AS `DCB_Federation_Loan_Actual_Amount_Repaid_upto_last_month`,
        sc.overdue_federation AS `DCB_Federation_Loan_Overdue_amount`,
        sc.current_outstanding_federation AS `DCB_Federation_Loan_Outstanding_amount`,
        sc.repayment_federation AS `DCB_Federation_Loan_Repayment_Ratio`,

        sc.bank_loan_amount AS `DCB_Bank_Loan_Total_Amount_of_Loan_given`,
        sc.dcb_bank AS `DCB_Bank_Loan_Total_Demand_upto_Last_month`,
        sc.repaid_bank AS `DCB_Bank_Loan_Actual_Amount_Repaid_upto_last_month`,
        sc.overdue_bank AS `DCB_Bank_Loan_Overdue_amount`,
        sc.current_outstanding_bank AS `DCB_Bank_Loan_Outstanding_amount`,
        sc.repayment_bank AS `DCB_Bank_Loan_Repayment_Ratio`,

        sc.other_loan_amount AS `DCB_Other_Loan_Total_Amount_of_Loan_given`,
        sc.dcb_other AS `DCB_Other_Loan_Total_Demand_upto_Last_month`,
        sc.repaid_other AS `DCB_Other_Loan_ctual_Amount_Repaid_upto_last_month`,
        sc.overdue_other AS `DCB_OtherLoan_Overdue_amount`,
        sc.current_outstanding_other AS `DCB_Other_Loan_Outstanding_amount`,
        sc.repayment_other AS `DCB_Other_Loan_Repayment_Ratio`,

        sc.total_loan_amount AS `Total_Amount_of_Loan_given_from_all_Sources`,
        sc.total_demand AS `Total_Demand_upto_Last_month`,
        sc.total_actual_repaid_amount AS `Actual_Amount_Repaid_upto_last_month`,
        sc.total_overdue AS `Total_Overdue`,
        sc.total_outstanding_amount AS `Total_Outstanding_amount`,
        sc.total_repayment_ratio AS `Total_repayment_Ratio`
     
     FROM
        shg_mst AS s 
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN shg_creditrecovery AS sc
        ON sc.shg_sub_mst_id = s.id
        WHERE s.is_deleted = 0";

        if ($isClusterSelected) {
            $query .= " AND c.is_deleted = 0 ";
        }

        if (!empty($session_data['Search'])) {
            if (!empty($session_data['agency'])) {
                $agency = $session_data['agency'];
                $query .= " AND s.agency_id = $agency  ";
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
        }

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
            $res->shg_name,
            $res->Risk_Rating,
            $res->NRLM_code,
            $res->cluster_name,
            $res->federation_name,
            $res->village,
            $res->DCB_Internal_Loan_Total_Amount_of_Loan_given,
            $res->DCB_Internal_Loan_Total_Demand_upto_Last_month,
            $res->DCB_Internal_Loan_Actual_Amount_Repaid_upto_last_month,
            $res->DCB_Internal_Loan_Overdue_amount,
            $res->DCB_Internal_Loan_Outstanding_amount,
            $res->DCB_Internal_Loan_Repayment_Ratio,
            $res->DCB_Cluster_Loan_Loan_Total_Amount_of_Loan_given,
            $res->DCB_Cluster_Loan_Total_Demand_upto_Last_month,
            $res->DCB_Cluster_Loan_Actual_Amount_Repaid_upto_last_month,
            $res->DCB_Cluster_Loan_Overdue_amount,
            $res->DCB_Cluster_Loan_Outstanding_amount,
            $res->DCB_Cluster_Loan_Repayment_Ratio,
            $res->DCB_Federation_Loan_Total_Amount_of_Loan_given,
            $res->DCB_Federation_Loan_Total_Demand_upto_Last_month,
            $res->DCB_Federation_Loan_Actual_Amount_Repaid_upto_last_month,
            $res->DCB_Federation_Loan_Overdue_amount,
            $res->DCB_Federation_Loan_Outstanding_amount,
            $res->DCB_Federation_Loan_Repayment_Ratio,
            $res->DCB_Bank_Loan_Total_Amount_of_Loan_given,
            $res->DCB_Bank_Loan_Total_Demand_upto_Last_month,
            $res->DCB_Bank_Loan_Actual_Amount_Repaid_upto_last_month,
            $res->DCB_Bank_Loan_Overdue_amount,
            $res->DCB_Bank_Loan_Outstanding_amount,
            $res->DCB_Bank_Loan_Repayment_Ratio,
            $res->DCB_Other_Loan_Total_Amount_of_Loan_given,
            $res->DCB_Other_Loan_Total_Demand_upto_Last_month,
            $res->DCB_Other_Loan_ctual_Amount_Repaid_upto_last_month,
            $res->DCB_OtherLoan_Overdue_amount,
            $res->DCB_Other_Loan_Outstanding_amount,
            $res->DCB_Other_Loan_Repayment_Ratio,
            $res->Total_Amount_of_Loan_given_from_all_Sources,
            $res->Total_Demand_upto_Last_month,
            $res->Actual_Amount_Repaid_upto_last_month,
            $res->Total_Overdue,
            $res->Total_Outstanding_amount,
            $res->Total_repayment_Ratio,

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
                $event->sheet->getStyle('A1:AR1')->applyFromArray([
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
                'Name of SHG',
                'Risk Rating',
                'NRLM Code',
                'Cluster Name',
                'Federation Name',
                'Name of Village',

                'DCB - Internal Loan - Total Amount of Loan given ',
                'DCB - Internal Loan - Total Demand upto Last month',
                'DCB - Internal Loan - Actual Amount Repaid upto last month',
                'DCB - Internal Loan - Overdue amount',
                'DCB - Internal Loan - Outstanding amount',
                'DCB - Internal Loan- Repayment Ratio',

                'DCB - Cluster Loan Loan - Total Amount of Loan given',
                'DCB - Cluster Loan - Total Demand upto Last month',
                'DCB - Cluster Loan - Actual Amount Repaid upto last month',
                'DCB - Cluster Loan - Overdue amount ',
                'DCB - Cluster Loan - Outstanding amount',
                'DCB - Cluster Loan- Repayment Ratio',

                'DCB - Federation  Loan - Total Amount of Loan given ',
                'DCB - Federation Loan - Total Demand upto Last month',
                'DCB- Federation Loan - Actual Amount Repaid upto last month',
                'DCB- Federation Loan - Overdue amount ',
                'DCB- Federation Loan - Outstanding amount',
                'DCB- Federation Loan- Repayment Ratio',
                'DCB - Bank  Loan - Total Amount of Loan given ',
                'DCB - Bank Loan - Total Demand upto Last month ',
                'DCB- Bank Loan - Actual Amount Repaid upto last month',
                'DCB- Bank Loan - Overdue amount ',
                'DCB- Bank Loan - Outstanding amount',
                'DCB- Bank Loan- Repayment Ratio',
                'DCB - Other  Loan - Total Amount of Loan given',
                'DCB - Other Loan - Total Demand upto Last month',
                'DCB- Other Loan - Actual Amount Repaid upto last month',
                'DCB- OtherLoan - Overdue amount ',
                'DCB- Other Loan - Outstanding amount',
                'DCB - Other Loan- Repayment Ratio',
                'Total Amount of Loan given from all Sources',
                'Total Demand upto Last month',
                'Actual Amount Repaid upto last month',
                'Total Overdue',
                'Total Outstanding amount',
                'Total repayment Ratio'
            ]
        ];
    }

    public function title(): string
    {
        return 'SHG CRecovery - DCB';
    }
}
