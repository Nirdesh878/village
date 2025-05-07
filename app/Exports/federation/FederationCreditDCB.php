<?php
namespace App\Exports\federation;
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


class FederationCreditDCB implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
{

    public $curdate = '';
    public $counter = 1;
    public function __construct()
    {
        $this->curdate = Carbon::now()->format('d-m-Y');
    }

    public function collection()
    {
        // prd("sustainability");
        $user = Auth::user();
        $session_data = Session::get('federation_export_session');
        // prd($session_data);

        $query = "SELECT
        fed.id,
        fed.uin AS uin ,
        fedp.name_of_federation ,
        fedp.analysis_rating AS risk_rating,
        fedp.clf_code AS NRLM_code,
        fedp.name_of_district AS district_name,
        fedp.name_of_state AS state_name,
        ag.agency_name,
         SUM(CAST(fedc.federation_loan_active AS INT) +
        CAST(fedc.bank_loan_active AS INT) +
        CAST(fedc.vi_loan_active AS INT)+
        CAST(fedc.other_loan_active AS INT))
            AS total_active_loans ,

        SUM(CAST(fedc.federation_loan_amount AS INT) +
        CAST(fedc.bank_loan_amount AS INT) +
        CAST(fedc.vi_loan_amount AS INT)+
        CAST(fedc.other_loan_amount AS INT))
            AS Total_amount_given_from_all_source,

        SUM(CAST(fedc.dcb_federation AS INT) +
        CAST(fedc.dcb_bank AS INT) +
        CAST(fedc.dcb_vi AS INT)+
        CAST(fedc.dcb_other AS INT))
            AS Total_demond_upto_last_month,

        SUM(CAST(fedc.repaid_federation AS INT) +
        CAST(fedc.repaid_bank AS INT) +
        CAST(fedc.repaid_vi AS INT)+
        CAST(fedc.repaid_other AS INT))
            AS Total_actual_amount_repaid_upto_last_month,

        SUM(CAST(fedc.overdue_amount_federation AS Float) +
        CAST(fedc.overdue_amount_bank AS Float) +
        CAST(fedc.overdue_amount_vi AS Float)+
        CAST(fedc.overdue_amount_other AS Float))
            AS total_overdue,

        SUM(CAST(fedc.loan_outstanding_federation AS INT) +
        CAST(fedc.loan_outstanding_bank AS INT) +
        CAST(fedc.loan_outstanding_vi AS INT)+
        CAST(fedc.loan_outstanding_other AS INT))
            AS total_outstanding_amount,

        SUM(CAST(fedc.repayment_rate_federation_loans AS INT) +
        CAST(fedc.repayment_rate_bank_loans AS INT) +
        CAST(fedc.repayment_rate_vi_loans AS INT)+
        CAST(fedc.repayment_rate_other_loans AS INT))
            AS total_repaid_ratio,

        SUM(CAST(fedc.overdue_More_than_1_months_Federation AS INT) +
        CAST(fedc.overdue_More_than_1_months_Bank AS INT) +
        CAST(fedc.overdue_More_than_1_months_other AS INT))
            AS PAR_Status_defaulted_loans_for_30_days_total_outstanding_loans_for_defaulted_loans,

        SUM(CAST(fedc.overdue_More_than_2_months_Federation AS Float) +
        CAST(fedc.overdue_More_than_2_months_Bank AS Float) +
        CAST(fedc.overdue_More_than_2_months_other AS Float))
            AS PAR_Status_defaulted_loans_for_60_days_total_outstanding_loans_for_defaulted_loans,

        SUM(CAST(fedc.overdue_More_than_3_months_Federation AS Float) +
        CAST(fedc.overdue_More_than_3_months_Bank AS Float) +
        CAST(fedc.overdue_More_than_3_months_other AS Float))
            AS PAR_Status_defaulted_loans_for_90_days_total_outstanding_loans_for_defaulted_loans,

        round(SUM(CAST(fedc.percentage_More_than_30_days_Federation AS Float) +
        CAST(fedc.percentage_More_than_30_days_Bank AS Float) +
        CAST(fedc.percentage_More_than_30_days_other AS Float)),2)
            AS PAR_Status_Defaulted_loans_for_30_days_total_oututstanting_amount,

        round(SUM(CAST(fedc.percentage_More_than_60_days_Federation AS Float) +
        CAST(fedc.percentage_More_than_60_days_Bank AS Float) +
        CAST(fedc.percentage_More_than_60_days_other AS Float)),2)
            AS PAR_Status_Defaulted_loans_for_60_days_total_oututstanting_amount,

        round(SUM(CAST(fedc.percentage_More_than_90_days_Federation AS Float) +
        CAST(fedc.percentage_More_than_90_days_Bank  AS Float) +
        CAST(fedc.percentage_More_than_90_days_other AS Float)),2)
            AS PAR_Status_Defaulted_loans_for_90_days_total_oututstanting_amount,

        fedc.*
     FROM
         federation_mst AS fed
          INNER JOIN federation_profile AS fedp
          ON fed.id = fedp.federation_sub_mst_id
          INNER JOIN agency AS ag
          ON fed.agency_id = ag.agency_id
          INNER JOIN federation_credithistory AS fedc
          ON fed.id = fedc.federation_sub_mst_id

          WHERE fed.is_deleted = 0";

          if(!empty($session_data['Search'])){
            if(!empty($session_data['agency'])){
                $agency = $session_data['agency'];
                $query .=" AND fed.agency_id = $agency  ";
             }
             if(!empty($session_data['federation'])){
                $query .=" AND fed.uin = '" . $session_data['federation'] . "' ";
             }

          }
          $query .="group by fed.id ";
          $federation = DB::select($query);
        //  prd($federation);
        return collect($federation);
    }

    public function map($res): array
    {


            return [
                $this->counter++,
                $res->uin,
                $res->name_of_federation,
                $res->risk_rating,
                $res->NRLM_code,
                $res->district_name,
                $res->state_name,
                $res->agency_name,

        (string)$res->federation_loan_active,
        (string)$res->federation_loan_amount,
        (string)$res->dcb_federation,
        (string)$res->repaid_federation,
        (string)$res->overdue_amount_federation,
        (string)$res->loan_outstanding_federation,
        (string)$res->repayment_rate_federation_loans,
        (string)$res->bank_loan_active,
        (string)$res->bank_loan_amount,
        (string)$res->dcb_bank,
        (string)$res->repaid_bank,
        (string)$res->overdue_amount_bank,
        (string)$res->loan_outstanding_bank,
        (string)$res->repayment_rate_bank_loans,
        (string)$res->other_loan_active,
        (string)$res->other_loan_amount,
        (string)$res->dcb_other,
        (string)$res->repaid_other,
        (string)$res->overdue_amount_other,
        (string)$res->loan_outstanding_other,
        (string)$res->repayment_rate_other_loans,
        (string)$res->total_active_loans,
        (string)$res->Total_amount_given_from_all_source,
        (string)$res->Total_demond_upto_last_month,
        (string)$res->Total_actual_amount_repaid_upto_last_month,
        (string)$res->total_overdue,
        (string)$res->total_outstanding_amount,
        (string)$res->total_repaid_ratio,

        (string)$res->PAR_Status_defaulted_loans_for_30_days_total_outstanding_loans_for_defaulted_loans,
        (string)$res->overdue_More_than_1_months_Federation,
        (string)$res->overdue_More_than_1_months_Bank,
        (string)$res->overdue_More_than_1_months_other,

        (string)$res->PAR_Status_defaulted_loans_for_60_days_total_outstanding_loans_for_defaulted_loans,
        (string)$res->overdue_More_than_2_months_Federation,
        (string)$res->overdue_More_than_2_months_Bank,
        (string)$res->overdue_More_than_2_months_other,

        (string)$res->PAR_Status_defaulted_loans_for_90_days_total_outstanding_loans_for_defaulted_loans,
        (string)$res->overdue_More_than_3_months_Federation,
        (string)$res->overdue_More_than_3_months_Bank,
        (string)$res->overdue_More_than_3_months_other,

        (string)$res->PAR_Status_Defaulted_loans_for_30_days_total_oututstanting_amount,
        (string)$res->percentage_More_than_30_days_Federation,
        (string)$res->percentage_More_than_30_days_Bank,
        (string)$res->percentage_More_than_30_days_other,

        (string)$res->PAR_Status_Defaulted_loans_for_60_days_total_oututstanting_amount,
        (string)$res->percentage_More_than_60_days_Federation,
        (string)$res->percentage_More_than_60_days_Bank,
        (string)$res->percentage_More_than_60_days_other,

        (string)$res->PAR_Status_Defaulted_loans_for_90_days_total_oututstanting_amount,
        (string)$res->percentage_More_than_90_days_Federation,
        (string)$res->percentage_More_than_90_days_Bank,
        (string)$res->percentage_More_than_90_days_other





            ];
    }

    public function columnFormats(): array
    {
        return [

        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:BH1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'color' => ['argb' => '#CCCCCC' ]
                    ]
                ]);
            },
        ];
    }

    public function headings(): array
    {
        return [

            ['S.No',
            'UIN',
            'Name Of Federation',
            'Risk Rating',
            'NRLM Code ',
            'District Name',
            'State Name',
            'Agency Name',
            'DCB - Federation Loan-No of Active Borrowers',
            'DCB Federation -total amount of love given (latest given loans)',
            'DCB -Federation - Total Demand upto Last month',
            'DCB - Federation- Actual Amount Repaid upto last month',
            'DCB - Federation - Overdue amount',
            'DCB - Federation - Outstanding amount',
            'DCB - Federation- Repayment Ratio',
            'DCB -Bank Loan-No of Active Borrowers',
            'DCB Bank -total amount of love given (latest given loans)',
            'DCB -Bank - Total Demand upto Last month',
            'DCB -Bank- Actual Amount Repaid upto last month',
            'DCB - Bank-Overdue amount',
            'DCB - Bank- Outstanding amount',
            'DCB - Bank- Repayment Ratio',
            'DCB -Other Loan-No of Active Borrowers',
            'DCB Other Loan -total amount of love given (latest given loans)',
            'DCB -Other - Total Demand upto Last month',
            'DCB -Other- Actual Amount Repaid upto last month',
            'DCB - Other-Overdue amount',
            'DCB - Other- Outstanding amoun',
            'DCB - Other- Repayment Ratio',
            'DCB total -No of active loans',
            'Total Amount of Loan given from all Sources',
            'Total Demand upto Last month',
            'Total Actual Amount Repaid upto last month',
            'Total Overdue',
            'Total Outstanding amount',
            'Total repayment Ratio',

            'PAR Status - Defaulted loans for 30 days total oututstanting amount',
            'PAR status - Federation loan defaulted for 30 days',
            'PAR status - Bank loan defaulted for 30 days',
            'PAR status - Other loan defaulted for 30 days',

            'PAR Status - Defaulted loans for 60 days total oututstanting amount',
            'PAR status - Federation loan defaulted for 60 days',
            'PAR status - Bank loan defaulted for 60 days',
            'PAR status - Other loan defaulted for 60 days',

            'PAR Status - Defaulted loans for 90 days total oututstanting amount',
            'PAR status - Federation loan defaulted for 90 days',
            'PAR status - Bank loan defaulted for 90 days',
            'PAR status - Other loan defaulted for 90 days',

            'PAR Status %- Defaulted loans for 30 days total oututstanting amount',
            'PAR status % - Federation loan defaulted for 30 days',
            'PAR status %- Bank loan defaulted for 30 days',
            'PAR status %- Other loan defaulted for 30 days',

            'PAR Status %- Defaulted loans for 60 days total oututstanting amount',
            'PAR status %- Federation loan defaulted for 60 days',
            'PAR status %- Bank loan defaulted for 60 days',
            'PAR status %- Other loan defaulted for 60 days',

            'PAR Status %- Defaulted loans for 90 days total oututstanting amount',
            'PAR status %- Federation loan defaulted for 90 days',
            'PAR status % - Bank loan defaulted for 90 days',
            'PAR status % - Other loan defaulted for 90 days'


            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Credit DCB';
    }
}
