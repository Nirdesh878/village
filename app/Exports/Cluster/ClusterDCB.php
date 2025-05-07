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


class ClusterDCB implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        clp.*,
        cl.uin,
        ag.agency_name,
        fedp.name_of_federation,
        clr.*,
        SUM(CAST(clr. cluster_loan_amount AS INT) +
        CAST(clr.federation_loan_amount AS INT) +
        CAST(clr.bank_loan_amount AS INT) +
        CAST(clr.other_loan_amount AS INT)
        ) as cluster_total_loan_disburesd,
        SUM(CAST(clr. dcb_cluster AS INT) +
        CAST(clr.dcb_federation AS INT) +
        CAST(clr.dcb_bank AS INT) +
        CAST(clr.dcb_other AS INT)
        ) as cluster_total_demand_disburesd,
        SUM(CAST(clr. repaid_cluster AS INT) +
        CAST(clr.repaid_federation AS INT) +
        CAST(clr.repaid_bank AS INT) +
        CAST(clr.repaid_other AS INT)
        ) as cluster_actual_amount_paid_disburesd,
        SUM(CAST(clr. overdue_amount_cluster AS INT) +
        CAST(clr.overdue_amount_federation AS INT) +
        CAST(clr.overdue_amount_bank AS INT) +
        CAST(clr.overdue_amount_other AS INT)
        ) as cluster_overdue_amount_paid_disburesd,
        SUM(CAST(clr. outstanding_amount_cluster AS INT) +
        CAST(clr.outstanding_amount_federation AS INT) +
        CAST(clr.outstanding_amount_bank AS INT) +
        CAST(clr.outstanding_amount_other AS INT)
        ) as cluster_outstanding_amount_paid_disburesd

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

        foreach ($cluster as $raw) {
            $num = 0;
            $a = !empty($raw->cluster_repayment_rate) ? (float)str_replace('%', '', $raw->cluster_repayment_rate) : 0;
            $num += !empty($raw->cluster_repayment_rate) ? 1 : 0;

            $b = !empty($raw->federation_repayment_rate) ? (float)str_replace('%', '', $raw->federation_repayment_rate) : 0;
            $num += !empty($raw->federation_repayment_rate) ? 1 : 0;

            $c = !empty($raw->bank_repayment_rate) ? (float)str_replace('%', '', $raw->bank_repayment_rate) : 0;
            $num += !empty($raw->bank_repayment_rate) ? 1 : 0;

            $d = !empty($raw->vi_repayment_rate) ? (float)str_replace('%', '', $raw->vi_repayment_rate) : 0;
            $num += !empty($raw->vi_repayment_rate) ? 1 : 0;

            $e = !empty($raw->other_repayment_rate) ? (float)str_replace('%', '', $raw->other_repayment_rate) : 0;
            $num += !empty($raw->other_repayment_rate) ? 1 : 0;

            $g = $num > 0 ? number_format((float)(($a + $b + $c + $d + $e) / $num), 2, '.', '') : 0;

            $raw->average_repayment_rate = $g; // Save the calculated average in the object.
        }

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


        (string)$res->cluster_loan_amount,
        (string)$res->dcb_cluster,
        (string)$res->repaid_cluster,
        (string)$res->overdue_amount_cluster,
        (string)$res->outstanding_amount_cluster,
        (string)$res->cluster_repayment_rate,

        (string)$res->federation_loan_amount,
        (string)$res->dcb_federation,
        (string)$res->repaid_federation,
        (string)$res->overdue_amount_federation,
        (string)$res->outstanding_amount_federation,
        (string)$res->federation_repayment_rate,


        (string)$res->bank_loan_amount,
        (string)$res->dcb_bank,
        (string)$res->repaid_bank,
        (string)$res->overdue_amount_bank,
        (string)$res->outstanding_amount_bank,
        (string)$res->bank_repayment_rate,

        (string)$res->other_loan_amount,
        (string)$res->dcb_other,
        (string)$res->repaid_other,
        (string)$res->overdue_amount_other,
        (string)$res->outstanding_amount_other,
        (string)$res->other_repayment_rate,


        (string)$res->cluster_total_loan_disburesd,
        (string)$res->cluster_total_demand_disburesd,
        (string)$res->cluster_actual_amount_paid_disburesd,
        (string)$res->cluster_overdue_amount_paid_disburesd,
        (string)$res->cluster_outstanding_amount_paid_disburesd,
        (string)$res->average_repayment_rate,

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


            'Clusterl Loan - Total Amount of Loan given',
            'Cluster Loan - Total Demand upto Last month (to be repaid)',
            'Cluster Loan - Actual Amount Repaid upto last month',
            'Cluster Loan - Overdue amount (%)',
            'Cluster Loan - Outstanding amoun',
            'Cluster Loan- Repayment Ratio',
            'Federation  Loan - Total Amount of Loan given',
            'Federation Loan - Total Demand upto Last month (to be repaid)',
            'Federation Loan - Actual Amount Repaid upto last month',
            'Federation Loan - Overdue amount',
            'Federation Loan - Outstanding amount',
            'Federation Loan- Repayment Ratio',
            'Bank  Loan - Total Amount of Loan given',
            'Bank Loan - Total Demand upto Last month (to be repaid)',
            'Bank Loan - Actual Amount Repaid upto last month',
            'Bank Loan - Overdue amount',
            'Bank Loan - Outstanding amount',
            'Bank Loan- Repayment Ratio',
            'Other  Loan - Total Amount of Loan given',
            'Other Loan - Total Demand upto Last month (to be repaid)',
            'Other Loan - Actual Amount Repaid upto last month',
            'OtherLoan - Overdue amount',
            'Other Loan - Outstanding amount',
            'Other Loan- Repayment Ratio',
            'Total Amount of Loan given from all Sources',
            'Total Demand upto Last month (to be repaid)',
            'Total Actual Amount Repaid upto last month',
            'Total Overdue',
            'Total Outstanding amount',
            'Total repayment Ratio/ Overall Percentage'

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster DCB Loans';
    }
}
