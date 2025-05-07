<?php
namespace App\Exports\Cluster;
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


class ClusterInclusionLoans implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $session_data = Session::get('cluster_export_session');
        // prd($session_data);

        $query = "SELECT
        cli.*,
        cl.uin,
        ag.agency_name,
        fedp.name_of_federation,
        clp.*,
        SUM(CAST(cli. federation_poorest_category AS INT) +
            CAST(cli.external_poorest_category AS INT) +
            CAST(cli.vi_poorest_category AS INT)+
            CAST(cli.federation_poor_category AS INT) +
            CAST(cli.external_poor_category AS INT)+
            CAST(cli.vi_poor_category AS INT) +
            CAST(cli.federation_medium AS INT)+
            CAST(cli.external_medium AS INT) +
            CAST(cli.vi_medium AS INT)+
            CAST(cli.federation_rich AS INT) +
            CAST(cli.external_rich AS INT)+
            CAST(cli.vi_rich AS INT)
            )
            AS total_no_of_loan_disbursed,
            SUM(CAST(cli. federation_poorest_category_amount AS INT) +
            CAST(cli.external_poorest_category_amount AS INT) +
            CAST(cli.vi_poorest_category_amount AS INT)+
            CAST(cli.federation_poor_category_amount AS INT) +
            CAST(cli.external_poor_category_amount AS INT)+
            CAST(cli.vi_poor_category_amount AS INT) +
            CAST(cli.federation_medium_amount AS INT)+
            CAST(cli.external_medium_amount AS INT) +
            CAST(cli.vi_medium_amount AS INT)+
            CAST(cli.federation_rich_amount AS INT) +
            CAST(cli.external_rich_amount AS INT)+
            CAST(cli.vi_rich_amount AS INT)
            )
            AS total_no_of_loan_ammount_disbursed ,

            SUM(CAST(cli. federation_poorest_category AS INT) +
            CAST(cli.federation_poor_category AS INT) +
            CAST(cli.federation_medium AS INT) +
            CAST(cli.federation_rich AS INT) )as cluster_total_loan_disburesd,

            SUM(CAST(cli. federation_poorest_category_amount AS INT) +
            CAST(cli.federation_poor_category_amount AS INT) +
            CAST(cli.federation_medium_amount AS INT) +
            CAST(cli.federation_rich_amount AS INT) )as cluster_total_loan_amount_disburesd ,

            SUM(CAST(cli. external_poorest_category AS INT) +
            CAST(cli.external_poor_category AS INT) +
            CAST(cli.external_medium AS INT) +
            CAST(cli.external_rich AS INT) )as external_total_loan_disburesd ,

            SUM(CAST(cli. external_poorest_category_amount AS INT) +
            CAST(cli.external_poor_category_amount AS INT) +
            CAST(cli.external_medium_amount AS INT) +
            CAST(cli.external_rich_amount AS INT) )as external_total_loan_amount_disburesd,

            SUM(CAST(cli. vi_poorest_category AS INT) +
            CAST(cli.vi_poor_category AS INT) +
            CAST(cli.vi_medium AS INT) +
            CAST(cli.vi_rich AS INT) )as vi_total_loan_disburesd ,

            SUM(CAST(cli. vi_poorest_category_amount AS INT) +
            CAST(cli.vi_poor_category_amount AS INT) +
            CAST(cli.vi_medium_amount AS INT) +
            CAST(cli.vi_rich_amount AS INT) ) as vi_total_loan_amount_disburesd




     FROM
         cluster_mst AS cl
          INNER JOIN cluster_profile AS clp
          ON cl.id = clp.cluster_sub_mst_id
          INNER JOIN federation_mst as fed
          on fed.uin = cl.federation_uin
          INNER JOIN cluster_inclusion as cli
          on cl.id = cli.cluster_sub_mst_id
          INNER JOIN federation_profile as fedp
          on fed.id = fedp.federation_sub_mst_id
          INNER JOIN agency AS ag
          ON cl.agency_id = ag.agency_id

          WHERE cl.is_deleted = 0";
          if(!empty($session_data['Search'])){
            if(!empty($session_data['agency'])){
                $agency = $session_data['agency'];
                $query .=" AND cl.agency_id = $agency  ";
             }
             if(!empty($session_data['cluster'])){
                $query .=" AND cl.uin = '" . $session_data['cluster'] . "' ";
             }
             if(!empty($session_data['federation'])){
                $query .=" AND fed.uin = '" . $session_data['federation'] . "' ";
             }

          }

        $query .=" group by cl.id  ";
        $cluster = DB::select($query);
        return collect($cluster);
    }

    public function map($res): array
    {


            return [
                $this->counter++,
                $res->uin,
                $res->name_of_cluster,
                $res->analysis_rating,
                $res->vo_code,
                $res->name_of_district,
                $res->name_of_state,
                $res->name_of_federation,
                $res->agency_name,


        (string)$res->visual_poorest_category,
        (string)$res->visual_poor_category,
        (string)$res->visual_medium_category,
        (string)$res->visual_rich_category,
        (string)$res->total_no_of_loan_disbursed,
        (string)$res->total_no_of_loan_ammount_disbursed,

        (string)$res->cluster_total_loan_disburesd,
        (string)$res->cluster_total_loan_amount_disburesd,

        (string)$res->federation_poorest_category,
        (string)$res->federation_poorest_category_amount,
        (string)$res->federation_poor_category,
        (string)$res->federation_poor_category_amount,
        (string)$res->federation_medium,
        (string)$res->federation_medium_amount,
        (string)$res->federation_rich,
        (string)$res->federation_rich_amount,


        (string)$res->external_total_loan_disburesd,
        (string)$res->external_total_loan_amount_disburesd,

        (string)$res->external_poorest_category,
        (string)$res->external_poorest_category_amount,
        (string)$res->external_poor_category,
        (string)$res->external_poor_category_amount,
        (string)$res->external_medium,
        (string)$res->external_medium_amount,
        (string)$res->external_rich,
        (string)$res->external_rich_amount,

        (string)$res->vi_total_loan_disburesd,
        (string)$res->vi_total_loan_amount_disburesd,

        (string)$res->vi_poorest_category,
        (string)$res->vi_poorest_category_amount,
        (string)$res->vi_poor_category,
        (string)$res->vi_poor_category_amount,
        (string)$res->vi_medium,
        (string)$res->vi_medium_amount,
        (string)$res->vi_rich,
        (string)$res->vi_rich_amount,

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
                $event->sheet->getStyle('A1:AS1')->applyFromArray([
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
            'Name Of Cluster',
            'Risk Rating',
            'NRLM Code ',
            'District Name',
            'State Name',
            'Federation name',
            'Agency Name',


            'No of Poorest and Vulnerable Members',
            'Number of Poor members',
            'Number of medium poor',
            'Number of Rich',
            'Total No. Loans Disbursed - last 3 years',
            'Total Amount Loans Disbursed - last 3 years',

            'Cluster Loans (Last 3 years) -  Total No of  Loan Disbursed',
            'Cluster Loans (Last 3 years) -  Total amount Disbursed',

            'No. of Cluster Loans disbursed - Poorest category (Last 3 years)',
            'Amount of Cluster Loans - Poorest category (Last 3 years)',
            'No. of Cluster Loans disbursed - Poor category (Last 3 years)',
            'Amount of Cluster Loans - Poor category (Last 3 years)',
            'No. of Cluster Loans disbursed - Medium Poor category (Last 3 years)',
            'Amount of Cluster Loans - Medium Poor category (Last 3 years)',
            'No. of Cluster Loans disbursed - Rich category (Last 3 years)',
            'Amount of Cluster Loans - Rich category (Last 3 years)',

            'External Loans (Last 3 years) -  Total No of  Loan Disbursed',
            'External Loans (Last 3 years) -  Total amount Disbursed',

            'No. of  External Loans disbursed - Poorest category (Last 3 years)',
            'Amount of External Loans - Poorest category (Last 3 years)',
            'No. of External Loans disbursed - Poor category (Last 3 years)',
            'Amount of External Loans - Poor category (Last 3 years)',
            'No. of External Loans disbursed - Medium Poor category (Last 3 years)',
            'Amount of External Loans - Medium Poor category (Last 3 years)',
            'No. of External Loans disbursed - Rich category (Last 3 years)',
            'Amount of External Loans - Rich category (Last 3 years)',

            'Other Loans (Last 3 years) -  Total No of  Loan Disbursed',
            'Other Loans (Last 3 years) -  Total amount Disbursed',

            'No. of  other Loans disbursed - Poorest category (Last 3 years)',
            'Amount of Other Loans - Poorest category (Last 3 years)',
            'No. of other Loans disbursed - Poor category (Last 3 years)',
            'Amount of other Loans - Poor category (Last 3 years)',
            'No. of other Loans disbursed - Medium Poor category (Last 3 years)',
            'Amount of other Loans - Medium Poor category (Last 3 years)',
            'No. of other Loans disbursed - Rich category (Last 3 years)',
            'Amount of other Loans - Rich category (Last 3 years)',

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Inclusion Loans';
    }
}
