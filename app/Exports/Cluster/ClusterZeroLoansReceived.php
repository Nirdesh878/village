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


class ClusterZeroLoansReceived implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        clr.*,
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
          INNER JOIN cluster_creditrecovery as clr
          on cl.id = clr.cluster_sub_mst_id
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


        (string)$res->cluster_poorest_members_not_received_cluster_loan_year1,
        (string)$res->cluster_poor_members_not_received_cluster_loan_year1,
        (string)$res->cluster_medium_members_not_received_cluster_loan_year1,
        (string)$res->cluster_rich_members_not_received_cluster_loan_year1,
        (string)$res->cluster_poorest_members_not_received_cluster_loan_year2,
        (string)$res->cluster_poor_members_not_received_cluster_loan_year2,
        (string)$res->cluster_medium_members_not_received_cluster_loan_year2,
        (string)$res->cluster_rich_members_not_received_cluster_loan_year2,
        (string)$res->cluster_poorest_members_not_received_cluster_loan_year3,
        (string)$res->cluster_poor_members_not_received_cluster_loan_year3,
        (string)$res->cluster_medium_members_not_received_cluster_loan_year3,
        (string)$res->cluster_rich_members_not_received_cluster_loan_year3,

        (string)$res->federation_poorest_members_not_received_federation_loan_year1,
        (string)$res->federation_poor_members_not_received_federation_loan_year1,
        (string)$res->federation_medium_members_not_received_federation_loan_year1,
        (string)$res->federation_rich_members_not_received_federation_loan_year1,
        (string)$res->federation_poorest_members_not_received_federation_loan_year2,
        (string)$res->federation_poor_members_not_received_federation_loan_year2,
        (string)$res->federation_medium_members_not_received_federation_loan_year2,
        (string)$res->federation_rich_members_not_received_federation_loan_year2,
        (string)$res->federation_poorest_members_not_received_federation_loan_year3,
        (string)$res->federation_poor_members_not_received_federation_loan_year3,
        (string)$res->federation_medium_members_not_received_federation_loan_year3,
        (string)$res->federation_rich_members_not_received_federation_loan_year3,

        (string)$res->federation_poorest_members_not_received_bank_loan_year1,
        (string)$res->federation_poor_members_not_received_bank_loan_year1,
        (string)$res->federation_medium_members_not_received_bank_loan_year1,
        (string)$res->federation_rich_members_not_received_bank_loan_year1,
        (string)$res->federation_poorest_members_not_received_bank_loan_year2,
        (string)$res->federation_poor_members_not_received_bank_loan_year2,
        (string)$res->federation_medium_members_not_received_bank_loan_year2,
        (string)$res->federation_rich_members_not_received_bank_loan_year2,
        (string)$res->federation_poorest_members_not_received_bank_loan_year3,
        (string)$res->federation_poor_members_not_received_bank_loan_year3,
        (string)$res->federation_medium_members_not_received_bank_loan_year3,
        (string)$res->federation_rich_members_not_received_bank_loan_year3,

        (string)$res->federation_poorest_members_not_received_other_loan_year1,
        (string)$res->federation_poor_members_not_received_other_loan_year1,
        (string)$res->federation_medium_members_not_received_other_loan_year1,
        (string)$res->federation_rich_members_not_received_other_loan_year1,
        (string)$res->federation_poorest_members_not_received_other_loan_year2,
        (string)$res->federation_poor_members_not_received_other_loan_year2,
        (string)$res->federation_medium_members_not_received_other_loan_year2,
        (string)$res->federation_rich_members_not_received_other_loan_year2,
        (string)$res->federation_poorest_members_not_received_other_loan_year3,
        (string)$res->federation_poor_members_not_received_other_loan_year3,
        (string)$res->federation_medium_members_not_received_other_loan_year3,
        (string)$res->federation_rich_members_not_received_other_loan_year3,

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
                $event->sheet->getStyle('A1:BE1')->applyFromArray([
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


            'Cluster Loan (last 12 months) - Poorest & Vulnerable',
            'Cluster Loan (last 12 months) - Poor',
            'Cluster Loan (last 12 months) - Medium Poor',
            'Cluster Loan (last 12 months) - Rich',
            'Cluster Loan (Year before last) - Poorest & Vulnerable',
            'Cluster Loan  (Year before last)- Poor',
            'Cluster Loan  (Year before last)-  Medium Poor',
            'Cluster Loan  (Year before last) - Rich',
            'Cluster Loan (2 Years before last) - Poorest & Vulnerable',
            'Cluster Loan  (2 Years before last)- Poor',
            'Cluster Loan  (2 Years before last)-  Medium Poor',
            'Cluster Loan  (2 Years before last) - Rich',

            'Federation Loan (last 12 months) - Poorest & Vulnerable',
            'Federation Loan (last 12 months) - Poor',
            'Federation Loan (last 12 months) - Medium Poor',
            'Federation Loan (last 12 months) - Rich',
            'Federation Loan (Year before last) - Poorest & Vulnerable',
            'Federation Loan  (Year before last)- Poor',
            'Federation Loan  (Year before last)-  Medium Poor',
            'Federation Loan  (Year before last) - Rich',
            'Federation Loan (2 Years before last) - Poorest & Vulnerable',
            'Federation Loan  (2 Years before last)- Poor',
            'Federation Loan  (2 Years before last)-  Medium Poor',
            'Federation Loan  (2 Years before last) - Rich',

            'Bank Loan (last 12 months) - Poorest & Vulnerable',
            'Bank Loan (last 12 months) - Poor',
            'Bank Loan (last 12 months) - Medium Poor',
            'Bank Loan (last 12 months) - Rich',
            'Bank Loan (Year before last) - Poorest & Vulnerable',
            'Bank Loan  (Year before last)- Poor',
            'Bank Loan  (Year before last)-  Medium Poor',
            'Bank Loan  (Year before last) - Rich',
            'Bank Loan (2 Years before last) - Poorest & Vulnerable',
            'Bank Loan  (2 Years before last)- Poor',
            'Bank Loan  (2 Years before last)-  Medium Poor',
            'Bank Loan  (2 Years before last) - Rich',

            'Other Loan (last 12 months) - Poorest & Vulnerable',
            'Other Loan (last 12 months) - Poor',
            'Other Loan (last 12 months) - Medium Poor',
            'Other Loan (last 12 months) - Rich',
            'Other Loan (Year before last) - Poorest & Vulnerable',
            'Other Loan  (Year before last)- Poor',
            'Other Loan  (Year before last)-  Medium Poor',
            'Other Loan  (Year before last) - Rich',
            'Other Loan (2 Years before last) - Poorest & Vulnerable',
            'Other Loan  (2 Years before last)- Poor',
            'Other Loan  (2 Years before last)-  Medium Poor',
            'Other Loan  (2 Years before last) - Rich',

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Zero Loans Recived ';
    }
}
