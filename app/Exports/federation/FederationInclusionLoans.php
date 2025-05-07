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


class FederationInclusionLoans implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
    fed.uin AS uin,
    fedp.name_of_federation AS federation_name,
    fedp.analysis_rating AS risk_rating,
    fedp.clf_code AS NRLM_code,
    fedp.name_of_district AS district_name,
    fedp.name_of_state AS state_name,
    ag.agency_name AS agency_name,
    SUM(CAST(fedi.federation_poorest_category AS INT) +
        CAST(fedi.external_poorest_category AS INT) +
        CAST(fedi.vi_poorest_category AS INT)+
        CAST(fedi.federation_poor_category AS INT)+
        CAST(fedi.external_poor_category AS INT)+
        CAST(fedi.vi_poor_category AS INT)+
        CAST(fedi.federation_rich AS INT)+
        CAST(fedi.external_rich AS INT)+
        CAST(fedi.vi_rich AS INT)+
        CAST(fedi.federation_medium AS INT)+
        CAST(fedi.external_medium AS INT) +
        CAST(fedi.vi_medium AS INT)
        ) AS Total_no_of_loans_Disbursed,
    SUM( CAST(fedi.federation_rich_amount AS INT)+
        CAST(fedi.external_rich_amount AS INT) +
        CAST(fedi.vi_rich_amount AS INT) +
        CAST(fedi.federation_poorest_category_amount AS INT)+
        CAST(fedi.external_poorest_category_amount AS INT)+
        CAST(fedi.vi_poorest_category_amount AS INT)+
        CAST(fedi.federation_poor_category_amount AS INT)+
        CAST(fedi.external_poor_category_amount AS INT)+
        CAST(fedi.vi_poor_category_amount AS INT)+
        CAST(fedi.federation_medium_amount AS INT)+
        CAST(fedi.external_medium_amount AS INT)+
        CAST(fedi.vi_medium_amount AS INT)
        ) AS Total_no_of_loans_amount_Disbursed,
    SUM(CAST(fedi.federation_poorest_category AS INT)+
        CAST(fedi.federation_poor_category AS INT) +
        CAST(fedi.federation_medium AS INT) +
        CAST(fedi.federation_rich AS INT)
        ) AS Total_no_of_fedeartion_loans_Disbursed,
    SUM(CAST(fedi.federation_poorest_category_amount AS INT)+
        CAST(fedi.federation_poor_category_amount AS INT) +
        CAST(fedi.federation_medium_amount AS INT) +
        CAST(fedi.federation_rich_amount AS INT)
        ) AS Total_no_of_fedeartion_loans_ammount_Disbursed,

    SUM(CAST(fedi.external_poorest_category AS INT)+
        CAST(fedi.external_poor_category AS INT) +
        CAST(fedi.external_medium AS INT) +
        CAST(fedi.external_rich AS INT)
        ) AS Total_no_of_external_loans_Disbursed,
    SUM(CAST(fedi.external_poorest_category_amount AS INT)+
        CAST(fedi.external_poor_category_amount AS INT) +
        CAST(fedi.external_medium_amount AS INT) +
        CAST(fedi.external_rich_amount AS INT)
        ) AS Total_no_of_external_loans_ammount_Disbursed,
    fedi.*
FROM
    federation_mst AS fed
INNER JOIN federation_profile AS fedp ON fed.id = fedp.federation_sub_mst_id
INNER JOIN agency AS ag ON fed.agency_id = ag.agency_id
INNER JOIN federation_inclusion AS fedi ON fedi.federation_sub_mst_id = fed.id
WHERE
    fed.is_deleted = 0";



          if(!empty($session_data['Search'])){
            if(!empty($session_data['agency'])){
                $agency = $session_data['agency'];
                $query .=" AND fed.agency_id = $agency  ";
             }
             if(!empty($session_data['federation'])){
                $query .=" AND fed.uin = '" . $session_data['federation'] . "' ";
             }

          }

          $query .=" group by fed.id  ";
        $federation = DB::select($query);
         // prd($federation);
        return collect($federation);
    }

    public function map($res): array
    {


            return [
                $this->counter++,
                $res->uin,
                $res->federation_name,
                $res->risk_rating,
                $res->NRLM_code,
                $res->district_name,
                $res->state_name,
                $res->agency_name,

        (string)$res->no_of_poorest_and_most_vulnerable_hhm,
        (string)$res->no_of_poor_category_hhm,
        (string)$res->no_of_medium_poor_hhm,
        (string)$res->no_of_rich_hhm,

        (string)$res->Total_no_of_loans_Disbursed,
        (string)$res->Total_no_of_loans_amount_Disbursed,

        (string)$res->Total_no_of_fedeartion_loans_Disbursed,
        (string)$res->Total_no_of_fedeartion_loans_ammount_Disbursed,

        (string)$res->federation_poorest_category,
        (string)$res->federation_poorest_category_amount,
        (string)$res->federation_poor_category,
        (string)$res->federation_poor_category_amount,
        (string)$res->federation_medium,
        (string)$res->federation_medium_amount,
        (string)$res->federation_rich,
        (string)$res->federation_rich_amount,

        (string)$res->Total_no_of_external_loans_Disbursed,
        (string)$res->Total_no_of_external_loans_ammount_Disbursed,

        (string)$res->external_poorest_category,
        (string)$res->external_poorest_category_amount,
        (string)$res->external_poor_category,
        (string)$res->external_poor_category_amount,
        (string)$res->external_medium,
        (string)$res->external_medium_amount,
        (string)$res->external_rich,
        (string)$res->external_rich_amount


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
                $event->sheet->getStyle('A1:AH1')->applyFromArray([
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

            'No of Poorest and Vulnerable Members',
            'Number of Poor members',
            'Number of medium poor',
            'Number of Rich',

            'Total No. Loans Disbursed - last 12 months',
            'Total Amount Loans Disbursed - last 12 months',

            '1. Total Federation Loans Nos disbursed',
            '1. Total Federation Loans Amounts disbursed',

            'Federation loans  No. in last 12 months - Very Poor category',
            'Federation loans amount disbursed in last 12 months - Very Poor category',

            'Federation loans Nos disbursed in last 12 months -  Poor category',
            'Federation loans amount disbursed in last 12 months -  Poor category',

            'Federation loans Nos disbursed in last 12 months -  Medium Poor category',
            'Federation loans amount disbursed in last 12 months -  Medium Poor category',

            'Federation loans No. in last 12 months - Rich category',
            'Federation loans amounts in last 12 months - Rich category',

            '2. External Loans - Total Nos during last 12 months',
            '2. External Loans - Total Nos during last 12 months',

            'External loans  No. in last 12 months - Very Poor category',
            'External loans  amount disbursed in last 12 months -  Poor category',
            'External loans  Nos disbursed in last 12 months -  Poor category',
            'External loans  amount disbursed in last 12 months -  Poor category',
            'External loans  Nos disbursed in last 12 months -  Medium Poor category',
            'External loans   amount disbursed in last 12 months -  Medium Poor category',
            'External loans  loans No. in last 12 months - Rich category',
            'External loans  amounts in last 12 months - Rich category',

            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Inclusion Loans';
    }
}
