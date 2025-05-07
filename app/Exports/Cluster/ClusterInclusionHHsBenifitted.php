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


class ClusterInclusionHHsBenifitted implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        SUM(CAST(cli.visual_poorest_category AS INT) +
            CAST(cli.visual_poor_category AS INT) +
            CAST(cli.visual_medium_category AS INT) +
            CAST(cli.visual_rich_category AS INT)
        ) AS total_no_of_hh_benefitted,

        SUM(CAST(cli.federation_poorest_category_recloan AS INT) +
            CAST(cli.federation_poor_category_recloan AS INT) +
            CAST(cli.federation_medium_recloan AS INT) +
            CAST(cli.rich_members_benefited_cluster AS INT) +
            CAST(cli.external_poorest_category_recloan AS INT) +
            CAST(cli.external_poor_category_recloan AS INT) +
            CAST(cli.external_medium_recloan AS INT) +
            CAST(cli.external_rich_recloan AS INT) +
            CAST(cli.vi_poorest_category_recloan AS INT) +
            CAST(cli.vi_poor_category_recloan AS INT) +
            CAST(cli.vi_medium_recloan AS INT) +
            CAST(cli.vi_rich_recloan AS INT)
        ) AS total_no_of_loan_received,

        SUM(CAST(cli.federation_poorest_category_recloan AS INT) +
            CAST(cli.federation_poor_category_recloan AS INT) +
            CAST(cli.federation_medium_recloan AS INT) +
            CAST(cli.rich_members_benefited_cluster AS INT)
        ) AS total_no_cluster_loan,

        SUM(CAST(cli.external_poorest_category_recloan AS INT) +
            CAST(cli.external_poor_category_recloan AS INT) +
            CAST(cli.external_medium_recloan AS INT) +
            CAST(cli.external_rich_recloan AS INT)
        ) AS total_no_external_loan,

        SUM(CAST(cli.vi_poorest_category_recloan AS INT) +
            CAST(cli.vi_poor_category_recloan AS INT) +
            CAST(cli.vi_medium_recloan AS INT) +
            CAST(cli.vi_rich_recloan AS INT)
        ) AS total_no_other_loan





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

        (string)$res->total_no_of_hh_benefitted,

        (string)$res->total_no_cluster_loan,
        (string)$res->federation_poorest_category_recloan,
        (string)$res->federation_poor_category_recloan,
        (string)$res->federation_medium_recloan,
        (string)$res->federation_rich_recloan,

        (string)$res->total_no_external_loan,
        (string)$res->external_poorest_category_recloan,
        (string)$res->external_poor_category_recloan,
        (string)$res->external_medium_recloan,
        (string)$res->external_rich_recloan,

        (string)$res->total_no_other_loan,
        (string)$res->vi_poorest_category_recloan,
        (string)$res->vi_poor_category_recloan,
        (string)$res->vi_medium_recloan,
        (string)$res->vi_rich_recloan,





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

            'Total Current Members',

            'Total No of cluster loan received',

            // 'Cluster loans No.  Of HHs benefitted in last 12 months  - Very Poor category',
            'Cluster loan amount  received in last 12 months  - Very Poor category',
            // 'Cluster loans No.  Of HHs benefitted in last 12 months  -  Poor category',
            'Cluster loan amount  received in last 12 months  - Poor category',
            // 'Cluster loans No.  Of HHs benefitted in last 12 months  - Medium category',
            'Cluster loan amount  received in last 12 months  - Medium Poor category',
            // 'Cluster loans No.  Of HHs benefitted in last 12 months   - Rich category',
            'Cluster loan amount  received in last 12 months  - Rich category',

            // 'No. of HHs benefitted from External loans',
            'Total no of External loan received',

            // 'External loans No.  Of HHs benefitted in last 12 months  - Very Poor category',
            'External loan amount  received in last 12 months  - Very Poor category',
            // 'External loans No.  Of HHs benefitted in last 12 months  -  Poor category',
            'External loan amount  received in last 12 months  - Poor category',
            // 'External loans No.  Of HHs benefitted in last 12 months  - Medium category',
            'External loan amount  received in last 12 months  - Medium Poor category',
            // 'External loans No.  Of HHs benefitted in last 12 months   - Rich category',
            'External loan amount  received in last 12 months  - Rich category',

            // 'No. of HHs benefitted from Other loans',
            'Total No of Other loan received',

            // 'Other loans No.  Of HHs benefitted in last 12 months  - Very Poor category',
            'Other loan amount  received in last 12 months  - Very Poor category',
            // 'Other  loans No.  Of HHs benefitted in last 12 months  -  Poor category',
            'Other loan amount  received in last 12 months  - Poor category',
            // 'Other loans No.  Of HHs benefitted in last 12 months  - Medium category',
            'Other  loan amount  received in last 12 months  - Medium Poor category',
            // 'Other loans No.  Of HHs benefitted in last 12 months   - Rich category',
            'Other loan amount  received in last 12 months  - Rich category',

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Inclusion HHs Benifitted';
    }
}
