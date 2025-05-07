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


class FederationCreditLoanDefaultInternate implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        ag.agency_name ,
        SUM(CAST(fedc. loan_default_federation_members AS INT) +
            CAST(fedc.loan_default_bank_members AS INT) +
            CAST(fedc.loan_default_other_members AS INT))
            AS Loan_default_total_member,

        SUM(CAST(fedc. default_federation_no_of_loans AS INT) +
            CAST(fedc.default_bank_no_of_loans AS INT) +
            CAST(fedc.default_other_no_of_loans AS INT))
            AS Loan_default_total_loans,

        SUM(CAST(fedc. cumulative_interest_federation_loans AS INT) +
            CAST(fedc.cumulative_interest_bank_loans AS INT) +
            CAST(fedc.cumulative_interest_other_loans AS INT))
            AS total_commulative_intrest_income,

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

        (string)$res->Loan_default_total_member,
        (string)$res->Loan_default_total_loans,
        (string)$res->loan_default_federation_members,
        (string)$res->default_federation_no_of_loans,
        (string)$res->loan_default_bank_members,
        (string)$res->default_bank_no_of_loans,
        (string)$res->loan_default_other_members,
        (string)$res->default_other_no_of_loans,
        (string)$res->maximum_amount,
        (string)$res->minimum_amount,
        (string)$res->declining_or_flat,
        (string)$res->percent_charged,
        (string)$res->declining_or_flat_bank,
        (string)$res->percent_charged_bank,
        (string)$res->declining_or_flat_other,
        (string)$res->percent_charged_other,
        (string)$res->total_commulative_intrest_income,
        (string)$res->cumulative_interest_federation_loans,
        (string)$res->cumulative_interest_bank_loans,
        (string)$res->cumulative_interest_other_loans,
        (string)$res->actions_previous_year_defaults_a,
        (string)$res->actions_previous_year_defaults_b,
        (string)$res->actions_previous_year_defaults_c,
        (string)$res->actions_previous_year_defaults_d

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
                $event->sheet->getStyle('A1:AF1')->applyFromArray([
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
            'Loan Defualt total members',
            'Loan Defualt total Loans',
            'Federation Loan - No of members',
            'Federation Loan - No of Loans',
            'Bank Loan - No. of members',
            'Bank Loan - No. of loans',
            'Other Loan - No. of members',
            'Other Loan - No. of loans',
            'Maximum Loan amount',
            'Minimum loan amount',
            'Interest Rate Method--Federation declining or flat',
            'Rate of Interest-Federation % charged',
            'Interest Rate Method--Bank declining or flat',
            'Rate of Interest-Bank % charged',
            'Interest Rate Method--other declining or flat',
            'Rate of Interest-other % charged',
            'Cumulative Interest Income (ALL LOANS)',
            'Interest income Federation loans',
            'Interest income Bank loans',
            'Interest income other loans',
            'Actions taken to address defaults during last 12 Months - Action 1',
            'Actions taken to address defaults during last 12 Months - Action 2',
            'Actions taken to address defaults during last 12 Months - Action 3',
            'Actions taken to address defaults during last 12 Months - Action 4',

            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Credit Loan Default Internate';
    }
}
