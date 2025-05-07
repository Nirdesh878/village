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


class FederationInclusionHHsBenifitted implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
            fedi.*,
        SUM(CAST(fedi.federation_poorest_category_hhs AS INT)+
            CAST(fedi.federation_poor_category_hhs AS INT) +
            CAST(fedi.federation_medium_hhs AS INT) +
            CAST(fedi.federation_rich_hhs AS INT)
            ) AS total_hh_benefits,
        SUM(CAST(fedi.federation_poorest_category_recloan AS INT)+
            CAST(fedi.federation_poor_category_recloan AS INT) +
            CAST(fedi.federation_medium_recloan AS INT) +
            CAST(fedi.federation_rich_recloan AS INT)
            ) AS total_hh_federation,
        SUM(CAST(fedi.external_poorest_category_recloan AS INT)+
            CAST(fedi.external_poor_category_recloan AS INT) +
            CAST(fedi.external_medium_recloan AS INT) +
            CAST(fedi.external_rich_recloan AS INT)
            ) AS total_hh_external
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

        (string)$res->total_hh_benefits,
        (string)$res->total_hh_federation,

        (string)$res->federation_poorest_category_hhs,
        (string)$res->federation_poor_category_hhs,
        (string)$res->federation_medium_hhs,
        (string)$res->federation_rich_hhs,

        (string)$res->total_hh_federation,

        (string)$res->federation_poorest_category_recloan,
        (string)$res->federation_poor_category_recloan,
        (string)$res->federation_medium_recloan,
        (string)$res->federation_rich_recloan,

        (string)$res->total_hh_external,

        (string)$res->external_poorest_category_recloan,
        (string)$res->external_poor_category_recloan,
        (string)$res->external_medium_recloan,
        (string)$res->external_rich_recloan


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
                $event->sheet->getStyle('A1:X1')->applyFromArray([
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

            'Total HHs in federation',
            'Total HHs Benefitted',

            'No of Poorest and Vulnerable Members',
            'Number of Poor members',
            'Number of medium poor',
            'Number of Rich',

            '1 Total SHG membesr HHs received Federation loan',
            'Poorest & Vulnerable Category  HHs Received Federation Loan',
            'PoorCategory  HHs Received Federation Loan',
            'Medium Poor Category  HHs Received Federation Loan',
            'Rich Category  HHs Received Federation Loan',

            '2 Total  SHG member HHs received External loan',
            'Poorest & Vulnerable Category  HHs Received External  Loan',
            'Poor Category  HHs Received External Loan',
            'Medium Poor Category  HHs Received External Loan',
            'Rich Category  HHs Received External Loan'
            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Information HHs Benifitted';
    }
}
