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


class ClusterSavings implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        cls.*,
        cl.uin,
        ag.agency_name,
        fedp.name_of_federation,
        clp.*




     FROM
         cluster_mst AS cl
          INNER JOIN cluster_profile AS clp
          ON cl.id = clp.cluster_sub_mst_id
          INNER JOIN federation_mst as fed
          on fed.uin = cl.federation_uin
          INNER JOIN cluster_saving as cls
          on cl.id = cls.cluster_sub_mst_id
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


        (string)$res->compulsory_savings,
        (string)$res->amount_of_compulsory,
        (string)$res->trend,
        (string)$res->compulsory_savings_inception,

        (string)$res->voluntary_savings,
        (string)$res->date_voluntary_saving,
        (string)$res->amount_of_voluntary,
        (string)$res->voluntary_savings_inception,
        (string)$res->no_of_shg_member,
        (string)$res->interest_paid,
        (string)$res->savings_redistributed,
        (string)$res->date_last_distribution,

        (string)$res->loan_security_fund,
        (string)$res->date_established,
        (string)$res->members,
        (string)$res->members_benefitted,
        (string)$res->amount_available,
        (string)$res->reasons,




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


            'Compulsory savings ( yes or no or NA)',
            'If yes,Amount of Compulsory Saving per month',
            'Average Monthly Savings in last 12 months',
            'Cumulative cumpolsary savings since inception',

            'Voluntary Savings Yes or no or NA',
            'Date of Saving started',
            'Average Amount of voluntary savings per month',
            'Cumulative Voluntary savings since inception',
            'No. of SHG members contribute to voluntary savings ',
            'Interest Paid to members on savings Yes or No',
            'Are savings redistributed to members ( yes or No)',
            'If yes, Date of last distribution',

            'Does SHG participate in LSF( Yes or No)',
            'If yes, date established',
            'If yes, No. Of members contribute to LSF',
            'If yes, No. of members benefitted by LSF',
            'If yes, Amount avaialble in LSF',
            'If No, reason memebrs do not contribute',

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Savings';
    }
}
