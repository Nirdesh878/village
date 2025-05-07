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


class ClusterLoanDefault implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        SUM(CAST(clr. other_loan_default_member AS INT) +
        CAST(clr.bank_loan_default_member AS INT) +
        CAST(clr.federation_loan_default_member AS INT) +
        CAST(clr.cluster_loan_default_member AS INT)
        ) as cluster_total_no_members,
        SUM(CAST(clr. other_loan_default_no AS INT) +
        CAST(clr.bank_loan_default_no AS INT) +
        CAST(clr.federation_loan_default_no AS INT) +
        CAST(clr.cluster_loan_default_no AS INT)
        ) as cluster_total_no_loans,
        SUM(CAST(clr. overdue_a AS INT) +
        CAST(clr.overdue_b AS INT) +
        CAST(clr.overdue_c AS INT) +
        CAST(clr.overdue_e AS INT)
        ) as cluster_more_than_three_month_total_no_loans
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


        (string)$res->cluster_loan_default_member,
        (string)$res->cluster_loan_default_no,
        (string)$res->federation_loan_default_member,
        (string)$res->federation_loan_default_no,
        (string)$res->bank_loan_default_member,
        (string)$res->bank_loan_default_no,
        (string)$res->other_loan_default_member,
        (string)$res->other_loan_default_no,
        (string)$res->cluster_total_no_members,
        (string)$res->cluster_total_no_loans,

        (string)$res->cluster_more_than_three_month_total_no_loans,
        (string)$res->overdue_a,
        (string)$res->overdue_b,
        (string)$res->overdue_c,
        (string)$res->overdue_e,

        (string)$res->cluster_loan_par,
        (string)$res->federation_loan_par,
        (string)$res->bank_loan_par,
        (string)$res->other_loan_par,

        (string)$res->productive,
        (string)$res->consumption,
        (string)$res->debt_swapping,
        (string)$res->other_Purposes,

        (string)$res->average_loan_amount,


        (string)$res->maximum_amount,
        (string)$res->minimum_amount,


        (string)$res->members_more_than_one,

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
                $event->sheet->getStyle('A1:AJ1')->applyFromArray([
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


            'Cluster Loan - No. Of members',
            'Cluster Loan - No. Of loan',
            'Federation Loans - No. of members',
            'Federation Loans  - No. of loans',
            'Bank Loan  - No. of members',
            'Bank Loan  - No. of loans',
            'Other Loan  - No. of members',
            'Other Loan  - No. of loans',
            'Total - No. of members',
            'Total - No of Loans',


            'Total amount',
            'Cluster Loan',
            'Federation Loan',
            'Bank Loan',
            'Other Loans',
            'Cluster Loan',
            'Federation Loan',
            'Bank Loan',
            'Other Loans',
            'Productive',
            'Consumption',
            'Debt Swapping',
            'Other',
            'Average loan amount during last 12 months',
            'Minimum Loan Amount  in last 12 months',
            'Maximum Loan Amount in last 12 months',
            'No. of members taken more than 1 loan during last 3 years'

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Loan Default';
    }
}
