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


class FederationCreditPurposeRotationVel implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        SUM(CAST(fedc.productive AS INT) +
        CAST(fedc.consumption AS INT) +
        CAST(fedc.debt_swapping AS INT)+
        CAST(fedc.education AS INT)+
            CAST(fedc.health AS INT)+
            CAST(fedc.Other AS INT))
            AS purpose_of_all_loans_TOTAL_NO_of_loans ,
            SUM(CAST(fedc.productive_amount AS INT) +
            CAST(fedc.consumption_amount AS INT) +
            CAST(fedc.debt_swapping_amount AS INT)+
            CAST(fedc.education_amount AS INT)+
            CAST(fedc.health_amount AS INT)+
            CAST(fedc.Other_amount AS INT))
            AS purpose_of_all_loans_TOTAL_amount_loans ,

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

        (string)$res->purpose_of_all_loans_TOTAL_NO_of_loans,
        (string)$res->purpose_of_all_loans_TOTAL_amount_loans,
        (string)$res->productive,
        (string)$res->productive_amount,
        (string)$res->consumption,
        (string)$res->consumption_amount,
        (string)$res->debt_swapping,
        (string)$res->debt_swapping_amount,
        (string)$res->education,
        (string)$res->education_amount,
        (string)$res->health,
        (string)$res->health_amount,
        (string)$res->Other,
        (string)$res->Other_amount,
        (string)$res->Total_corpus_fund_received,
        (string)$res->Total_loan_given,
        (string)$res->completed_received_corpus_fund,
        (string)$res->Yearly_rotation_ratio

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
                $event->sheet->getStyle('A1:Z1')->applyFromArray([
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
            'Purpose of all Loans -total No of loans',
            'Purpose of all Loans -total Amount of loans',
            'Purpose -Productive loans - Nos',
            'Purpose-Productive loans -Amount',
            'PurposeConsumption Loans -Nos',
            'Purpose Consumption Loans -Amount',
            'Purpose Debt Swaping -No of loans',
            'Purpose Debt Swaping -Amount of loans',
            'Purpose Education -No of loans',
            'Purpose Education -Amount of loans',
            'Purpose Health -No of Loans',
            'Purpose Health -Amount of Loans',
            'Purpose Others - No of Loans',
            'Purpose Others - Amount of Loans',
            'Rotation of Funds in the federation (Velocity)- total Corpus funds received (Q 21)',
            'Rotation of Funds in Federation -total Loan disbursed (Q21)',
            'No of Years completed since receipt of corpus funds (Q21)',
            'yearly rotation ratio (Q21)'
            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Credit Perpose Rotation & vel';
    }
}
