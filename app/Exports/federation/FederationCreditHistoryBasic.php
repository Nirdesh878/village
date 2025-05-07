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


class FederationCreditHistoryBasic implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        ag.agency_name ,
        fedc.*,
        SUM(CAST(fedc.federation_total_members_not_received_federation_loan_year1 AS INT) +
            CAST(fedc.federation_total_members_not_received_federation_loan_year2 AS INT) +
            CAST(fedc.federation_total_members_not_received_federation_loan_year3 AS INT)+
            CAST(fedc.federation_total_members_not_received_bank_loan_year1 AS INT) +
            CAST(fedc.federation_total_members_not_received_bank_loan_year2 AS INT) +
            CAST(fedc.federation_total_members_not_received_bank_loan_year3 AS INT)+
            CAST(fedc.federation_total_members_not_received_other_loan_year1 AS INT) +
            CAST(fedc.federation_total_members_not_received_other_loan_year2 AS INT) +
            CAST(fedc.federation_total_members_not_received_other_loan_year3 AS INT)) as no_of_members_not_received_any_single_loan_during_last_3_years,
        SUM(CAST(fedc.federation_total_members_not_received_federation_loan_year1 AS INT) +
            CAST(fedc.federation_total_members_not_received_federation_loan_year2 AS INT) +
            CAST(fedc.federation_total_members_not_received_federation_loan_year3 AS INT))
            AS no_of_members_not_received_any_single_federation_loan_during_last_3_years,
        SUM(CAST(fedc.federation_total_members_not_received_bank_loan_year1 AS INT) +
            CAST(fedc.federation_total_members_not_received_bank_loan_year2 AS INT) +
            CAST(fedc.federation_total_members_not_received_bank_loan_year3 AS INT))
            AS no_of_members_not_received_any_single_bank_loan_during_last_3_years,
        SUM(CAST(fedc.federation_total_members_not_received_other_loan_year1 AS INT) +
            CAST(fedc.federation_total_members_not_received_other_loan_year2 AS INT) +
            CAST(fedc.federation_total_members_not_received_other_loan_year3 AS INT))
            AS no_of_members_not_received_any_single_other_loan_during_last_3_years
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

        (string)$res->applications_received_for_loans,
        (string)$res->no_of_loans_approved,
        (string)$res->pending_loan_applications,
        (string)$res->no_of_loans_approved_within_15_days,
        (string)$res->no_of_loans_sanctioned_within_15_days,
        (string)$res->no_of_loans_sanctioned_between_1_3_months,

        (string)$res->cumulative_amount,
        (string)$res->cumulative_amount_federation_loan,
        (string)$res->cumulative_amount_bank_loan,
        (string)$res->cumulative_amount_other_loan,

        (string)$res->no_of_members_not_received_any_single_loan_during_last_3_years,

        (string)$res->no_of_members_not_received_any_single_federation_loan_during_last_3_years,
        (string)$res->federation_total_members_not_received_federation_loan_year1,
        (string)$res->federation_total_members_not_received_federation_loan_year2,
        (string)$res->federation_total_members_not_received_federation_loan_year3,

        (string)$res->no_of_members_not_received_any_single_bank_loan_during_last_3_years,
        (string)$res->federation_total_members_not_received_bank_loan_year1,
        (string)$res->federation_total_members_not_received_bank_loan_year2,
        (string)$res->federation_total_members_not_received_bank_loan_year3,

        (string)$res->no_of_members_not_received_any_single_other_loan_during_last_3_years,
        (string)$res->federation_total_members_not_received_other_loan_year1,
        (string)$res->federation_total_members_not_received_other_loan_year2,
        (string)$res->federation_total_members_not_received_other_loan_year3,

        (string)$res->members_have_taken_more_than_one_loan,
        (string)$res->does_Federation_loan_tracking_system,
        (string)$res->when_was_it_established,
        (string)$res->frequency_of_loan_tracking,

        (string)$res->average_loan,
        (string)$res->average_loan_amount,
        (string)$res->maximum_amount,
        (string)$res->minimum_amount


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
                $event->sheet->getStyle('A1:AM1')->applyFromArray([
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

            'No of Loan applications received during last 12 months',
            'No of Loans approved during last 12 months',
            'No of Loan applications pending  during last 12 months',
            'No of Loans approved within 15 days last 12 months',
            'No of Loans approved within 15 -30 days last 12 months',
            'No of Loans approved more than 30 days last 12 months ',

            'Cumulative amount of loan at Federation level',
            'Federation Loan',
            'Bank Loan',
            'Other Loan',

            'No of members not received any single loan (federation, bank and other) during last 3 years- cumulative',

            'No of members not received any single federation loan during last 3 years ',
            'No of members not received any single Federation loan  during last 12 months',
            'No of members not received any single federation loan  during  year before last year',
            'No of members not received any single federation loan 2 Years before last year',

            'No of members not received any single Bank loan during last 3 years ',
            'No of members not received any single bank loan  during last 12 months',
            'No of members not received any single bank loan  during  year before last year',
            'No of members not received any single bank loan 2 Years before last year',

            'No of members not received any single other loan during last 3 years ',
            'No of members not received any single other loan  during last 12 months',
            'No of members not received any single other loan  during  year before last year',
            'No of members not received any single other loan 2 Years before last year',

            'How many members have taken more than one loan during last three years',
            'Does federation have a loan tracking system',
            'if yes, date it was established',
            'what is the frequency of loan tracking',

            'Average No of Loans during last 12 months',
            'Average Loan amount during last 12 months',
            'Maximum Loan amount during last 12 months',
            'Minimum loan amount during last 12 months'

            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Credit History Basic Information';
    }
}
