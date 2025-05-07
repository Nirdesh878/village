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


class SHGCreditEfficiencyBasic implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        se.integrated_family   AS `Integrated_member_plans_submitted_to_cluster_or_federation`,
        se.integrated_family_date   AS `If_Yes_Last_report_submitted`,
        se.total_income AS `Total_income_for_last_12_months`,
        se.expense AS `Expense_in_last_12_months`,
        se.covering_operational_cost   AS `Is_SHG_covering_Operational_cost_through_its_own_income`,
        se.no_of_days_approve_loan AS `No_of_days_taken_to_approve_loan_application`,
        se.no_of_days_cash_in_hand AS `No_of_days_from_loan_approval_to_cash_in_hand`,
        se.prepare_monthly_progress AS `Does_Group_prepare_a_monthly_prgress_report_and_submit_to_federation_and_Not_cluster`,
        se.shg_last_submission_date  AS `If_yes_last_submitted_date`
      FROM
        shg_mst AS s 
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN shg_efficiency AS se
        ON se.shg_sub_mst_id = s.id
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
            $res->Integrated_member_plans_submitted_to_cluster_or_federation,
            $res->If_Yes_Last_report_submitted,
            $res->Total_income_for_last_12_months,
            $res->Expense_in_last_12_months,
            $res->Is_SHG_covering_Operational_cost_through_its_own_income,
            $res->No_of_days_taken_to_approve_loan_application,
            $res->No_of_days_from_loan_approval_to_cash_in_hand,
            $res->Does_Group_prepare_a_monthly_prgress_report_and_submit_to_federation_and_Not_cluster,
            $res->If_yes_last_submitted_date,

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
                $event->sheet->getStyle('A1:Q1')->applyFromArray([
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
                'Has SHG Integrated member plans & submitted to cluster or federation',
                'If Yes - Last report submitted',
                'Total income for last 12 months',
                'Total Expense in last 12 months',
                'Is SHG covering Operational cost through its own income',
                'No. of days taken to approve loan application',
                'No. of days from loan approval to cash in hand',
                'Does Group prepare a monthly prgress report and submit to federation and Not cluster',
                'If yes - last submitted date'
            ]
        ];
    }

    public function title(): string
    {
        return 'SHG Credit Efficiency - Basic';
    }
}
