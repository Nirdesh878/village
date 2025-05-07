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


class SHGCRecoveryLoanDefault implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        sc.default_internal_member AS `Internal_Loans_No_of_Members`,
        sc.default_internal_loan AS `Internal_Loans_No_Of_Loans`,
        sc.default_cluster_member AS `Cluster_Loan_No_Of_members`,
        sc.default_cluster_loan AS `Cluster_Loan_No_Of_loans`,
        sc.default_federation_member AS `Federation_Loans_No_of_members`,
        sc.default_federation_loan AS `Federation_Loans_No_of_loans`,
        sc.default_bank_member AS `Bank_Loan_No_of_members`,
        sc.default_bank_loan AS `Bank_Loan_No_of_loans`,
        sc.default_other_member AS `Other_Loan_No_of_members`,
        sc.default_other_loan AS `Other_Loan_No_of_loans`,
        sc.default_other_member AS `Total_No_of_members`,
        sc.default_other_loan AS `Total_No_of_Loans`,
        sc.creditHistory_PAR_status_Internal  AS `PAR_Status_Internal_Loan_3_months_overdue_accounts_loan_outstanting_amount`,
        sc.creditHistory_PAR_status_External AS `PAR_Status_EXternal_Loan_3_months_overdue_accounts_loan_outstanting_amount`,
        sc.purposes_productive AS `Productive_Bank_Loans`,
        sc.purposes_consumption AS `Consumption_Bank_Loans`,
        sc.purposes_debt_swapping AS `Debt_Swapping_Bank_Loans`,
        sc.purposes_other AS `Other_Bank_Loans`,
        sc.purposes_productive_federation AS `Productive_Federation_Cluster_Loans`,
        sc.purposes_consumption_federation AS `Consumption_Federation_Bank_Loans`,
        sc.purposes_debt_swapping AS `Debt_Swapping_Federation_Cluster_Loans`,
        sc.purposes_other AS `Other_Federation_Cluster_Loans`,
        sc.average_loan_amount AS `Average_loan_amount_during_last_12_months`,
        sc.minimum_amount AS `Minimum_Loan_Amount`,
        sc.maximum_amount AS `Maximum_Loan_Amount`,
        sc.no_of_member_loan_more AS `No_of_members_taken_more_than_1_loan_during_last`


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
        WHERE s.is_deleted = 0 ";

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

        $query .= "  GROUP BY s.id
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
            $res->shg_name,
            $res->Risk_Rating,
            $res->NRLM_code,
            $res->cluster_name,
            $res->federation_name,
            $res->village,
            $res->Internal_Loans_No_of_Members,
            $res->Internal_Loans_No_Of_Loans,
            $res->Cluster_Loan_No_Of_members,
            $res->Cluster_Loan_No_Of_loans,
            $res->Federation_Loans_No_of_members,
            $res->Federation_Loans_No_of_loans,
            $res->Bank_Loan_No_of_members,
            $res->Bank_Loan_No_of_loans,
            $res->Other_Loan_No_of_members,
            $res->Other_Loan_No_of_loans,
            $res->Total_No_of_members,
            $res->Total_No_of_Loans,
            $res->PAR_Status_Internal_Loan_3_months_overdue_accounts_loan_outstanting_amount,
            $res->PAR_Status_EXternal_Loan_3_months_overdue_accounts_loan_outstanting_amount,
            $res->Productive_Bank_Loans,
            $res->Consumption_Bank_Loans,
            $res->Debt_Swapping_Bank_Loans,
            $res->Other_Bank_Loans,
            $res->Productive_Federation_Cluster_Loans,
            $res->Consumption_Federation_Bank_Loans,
            $res->Debt_Swapping_Federation_Cluster_Loans,
            $res->Other_Federation_Cluster_Loans,
            $res->Average_loan_amount_during_last_12_months,
            $res->Minimum_Loan_Amount,
            $res->Maximum_Loan_Amount,
            $res->No_of_members_taken_more_than_1_loan_during_last,

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
                $event->sheet->getStyle('A1:AH1')->applyFromArray([
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
                'Internal Loans - No. of Members',
                'Internal Loans - No. Of Loans',
                'Cluster Loan - No. Of members',
                'Cluster Loan - No. Of loans',
                'Federation Loans - No. of members',
                ' Federation Loans - No. of loans',
                'Bank Loan - No. of members ',
                ' Bank Loan - No. of loans',
                'Other Loan - No. of members ',
                'Other Loan - No. of loans',
                'Total - No. of members',
                'Total - No of Loans',
                'PAR Status - Internal Loan - 3 months overdue accounts loan outstanting amount ',
                'PAR Status - EXternal Loan - 3 months overdue accounts loan outstanting amount',
                'Productive Bank Loans',
                'Consumption Bank Loans',
                'Debt Swapping Bank Loans',
                'Other Bank Loans',
                'Productive Federation/Cluster Loans',
                'Consumption Federation/Cluster Loans',
                'Debt Swapping Federation/Cluster Loans',
                'Other Federation/Cluster Loans',
                'Average loan amount during last 12 months',
                'Minimum Loan Amount  in last 12 months',
                'Maximum Loan Amount  in last 12 months',
                'No. of members taken more than 1 loan during last 3 years'
            ]
        ];
    }

    public function title(): string
    {
        return 'SHG CRecovery - Loan Default';
    }
}
