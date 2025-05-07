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


class SHGSavings implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
            ss.shg_compulsory_savings_spinner AS `Compulsory_savings_yes_or_no`,
            ss.date_savings_started AS `Date_of_saving_started`,
            ss.compulsory_saving_amount AS `Amount_of_Saving_per_month`,
            ss.regular_saving_member AS `No_of_Members_saved_compulsory_savings_regulary_last_12_months`,
            ss.cumulative_compulsory_saving AS `Cumulative_compulsory_savings_since_inception`,
            ss.shg_compulsory_average_amount_saving_1E AS `Average_Compulsory_amount_saved_during_last_12_months`,

            ss.voluntary_saving AS `Voluntary_Savings_Yes_or_no`,
            ss.shg_voluntary_saving_started_date as `shg_voluntary_saving_started_date`,
            ss.shg_voluntary_saving_amount_per_month AS `Amount_of_voluntary_savings_per_month`,
            ss.member_voluntary_saving AS `No_of_members_saved_voluntary_savings_regulary_in_last_12_months`,
            ss.cumulative_voluntary_saving AS `Cumulative_Voluntary_savings_since_inception`,
            ss.shg_voluntary_saving_since_inception AS `Average_voluntary_amount_saved_during_last_12_months`,

            ss.interest_paid AS `Interest_Paid_to_members_on_savings_Yes_or_No`,
            ss.saving_rate  AS `Savings_Rate`,

            ss.saving_redistributed  AS `Are_savings_redistributed_to_members`,
            ss.last_distribution_date  AS `If_yes_Date_of_last_distribution`,

            ss.LSF_participate AS `Does_SHG_participate_in_LSF`,
            ss.members_contribute_LSF AS `If_yes_No_Of_members_contribute_to_LSF`,
            ss.members_benefited_LSF AS `If_yes_No_of_members_benefitted_by_LSF`,
            ss.members_benefited_LSF AS `If_No_reason_memebrs_do_not_contribute`,

            ss.savingsMobilization_Last_year_per_member AS `Per_member_average_compulsory_savings_during_previous_year`,
            ss.savingsMobilization_Current_year_per_member AS `Per_member_average_compulsory_savings_during_last_12_months`,

            ss.savingsMobilization_Previous_year_per_member AS `Per_member_average_Voluntary_savings_during_previous_year_before_12_months`,
            ss.savingsMobilization_voluntary_saving AS `Per_member_average_Voluntary_savings_during_last_12_months`

            FROM
                shg_mst AS s 
                INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
                LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
                LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
                INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
                INNER JOIN federation_profile AS fedp
                ON fed.id = fedp.federation_sub_mst_id
                INNER JOIN shg_saving AS ss
                ON ss.shg_sub_mst_id = s.id
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
            $res->Compulsory_savings_yes_or_no,
            $res->Date_of_saving_started,
            $res->Amount_of_Saving_per_month,
            $res->No_of_Members_saved_compulsory_savings_regulary_last_12_months,
            $res->Cumulative_compulsory_savings_since_inception,
            $res->Average_Compulsory_amount_saved_during_last_12_months,

            $res->Voluntary_Savings_Yes_or_no,
            $res->shg_voluntary_saving_started_date,
            $res->Amount_of_voluntary_savings_per_month,
            $res->No_of_members_saved_voluntary_savings_regulary_in_last_12_months,
            $res->Cumulative_Voluntary_savings_since_inception,
            $res->Average_voluntary_amount_saved_during_last_12_months,

            $res->Interest_Paid_to_members_on_savings_Yes_or_No,
            $res->Savings_Rate,
            $res->Are_savings_redistributed_to_members,
            $res->If_yes_Date_of_last_distribution,
            $res->Does_SHG_participate_in_LSF,
            $res->If_yes_No_Of_members_contribute_to_LSF,
            $res->If_yes_No_of_members_benefitted_by_LSF,
            $res->If_No_reason_memebrs_do_not_contribute,
            $res->Per_member_average_compulsory_savings_during_previous_year,
            $res->Per_member_average_compulsory_savings_during_last_12_months,
            $res->Per_member_average_Voluntary_savings_during_previous_year_before_12_months,
            $res->Per_member_average_Voluntary_savings_during_last_12_months,

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
                $event->sheet->getStyle('A1:AF1')->applyFromArray([
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
                'Compulsory savings ( yes or no)',
                'Date of saving started',
                'Amount of Compulsory Saving per month',
                'No. of Members saved compulsory savings regulary - last 12 months',
                'Cumulative compulsory savings since inception',
                'Average Compulsory amount saved during last 12 months',
                'Voluntary Savings Yes or no',
                'Date of Saving started',
                'Amount of voluntary savings per month',
                'No. of members saved voluntary savings regulary in last 12 months',
                'Cumulative Voluntary savings since inception',
                'Average voluntary amount saved during last 12 months',
                'Interest Paid to members on savings Yes or No',
                'If yes, Savings Rate',
                'Are savings redistributed to members',
                'If yes, Date of last distribution',
                'Does SHG participate in LSF',
                'If yes, No. Of members contribute to LSF',
                'If yes, No. of members benefitted by LSF',
                'If No, reason memebrs do not contribute',
                'Per member average compulsory savings during previous year ( before 12 months)',
                'Per member average compulsory savings during last 12 months',
                'Per member average Voluntary savings during previous year ( before 12 months)',
                'Per member average Voluntary savings during last 12 months'
            ]
        ];
    }

    public function title(): string
    {
        return 'SHG Savings';
    }
}
