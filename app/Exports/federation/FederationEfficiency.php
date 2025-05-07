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


class FederationEfficiency implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        fedp.id,
        fed.uin AS uin ,
        fedp.name_of_federation ,
        fedp.analysis_rating AS risk_rating,
        fedp.clf_code AS NRLM_code,
        fedp.name_of_district AS district_name,
        fedp.name_of_state AS state_name,
        ag.agency_name ,

        fede.*
     FROM
         federation_mst AS fed
          INNER JOIN federation_profile AS fedp
          ON fed.id = fedp.federation_sub_mst_id
          INNER JOIN agency AS ag
          ON fed.agency_id = ag.agency_id
          INNER JOIN federation_efficiency AS fede
          ON fed.id = fede.federation_sub_mst_id

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

        (string)$res->integrated_Federation_plan,
        (string)$res->date_federation_plan_approved,
        (string)$res->date_federation_plan_submitted,
        (string)$res->time_taken_to_approve_loan,
        (string)$res->loans_per_month_approved,
        (string)$res->time_taken_to_give_money_from_approval,
        (string)$res->cost_ratio_per_active_client,
        (string)$res->operating_expenes,
        (string)$res->average_no,
        (string)$res->federation_operation_expense_ratio,
        (string)$res->operation_expense,
        (string)$res->avg_gross_portfolio,

        (string)$res->cost_income_ratio_year1,
        (string)$res->operating_income_year1,
        (string)$res->operating_expenses_year1,

        (string)$res->cost_income_ratio_year2,
        (string)$res->operating_income_year2,
        (string)$res->operating_expenses_year2,

        (string)$res->cost_income_ratio_year3,
        (string)$res->operating_income_year3,
        (string)$res->operating_expenses_year3,

        (string)$res->outstanding_loan_ratio_year1,
        (string)$res->outstanding_loan_year1,
        (string)$res->active_borrower_year1,

        (string)$res->outstanding_loan_ratio_year2,
        (string)$res->outstanding_loan_year2,
        (string)$res->active_borrower_year2,

        (string)$res->outstanding_loan_ratio_year3,
        (string)$res->outstanding_loan_year3,
        (string)$res->active_borrower_year3,

        (string)$res->integrated_credit_plan_approved,
        (string)$res->date_last_report_submitted







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
                $event->sheet->getStyle('A1:AN1')->applyFromArray([
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
            'Agency',

            'Has Federation Prepared an Integrated Credit plan',
            'If Yes - date plan was approved by the federation',
            'Date the plan was subkitted to the Partner org./NGO',
            'No of days taken to approve loan applications',
            'How many loans approved per month during last 12 months',
            'No of days taken from approval to cash in hand',
            'Cost Ratio per client',
            'Average Operating expense',
            'Average No of clients',
            'Federation Operation Expense Ratio',
            'Average Operating expense',
            'Average Gross Portfolio',

            'Cost Income Ratio -Last 12 months',
            'Operating income last 12 months ',
            'Operating expense last 12 months',

            'Cost Income Ratio -year before last year',
            'Operating income year before last year',
            'Operating Expense year before last year',

            'Cost Income Ratio 2 years before last year',
            'Operating income two years before last year',
            'Operating expenses 2 years before last year',

            'Average Outstanding Loan size and active borrowers last 12 months',
            'Loan outstanding amount last 12 months',
            'Active Borrowers last 12 months',

            'Average Outstanding Loan size and active borrowers year before last year',
            'Loan outstanding amount year before last year',
            'Active Borrowers year before last year',

            'Average Outstanding Loan size and active borrowers 2 years before last year',
            'Loan outstanding amount 2 years before last year',
            'Active Borrowers 2 years before last year',

            'Does Federation Prepare & submit a monthly progress report',
            'If yes, date of last progress report submitted'

            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Efficiency';
    }
}
