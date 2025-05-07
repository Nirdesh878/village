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


class ClusterCumulativeloans implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        clp.*,

        SUM( CAST(cumulative_members_cluster as int) +
            CAST(cumulative_members_federation as int) +
            CAST(cumulative_members_bank as int) +
            CAST(cumulative_members_vi as int) +
            CAST(cumulative_members_other as int) +
            CAST(new_cluster_creditHistory_question5ai as int) +
            CAST(new_cluster_creditHistory_question5bi as int) +
            CAST(new_cluster_creditHistory_question5ci as int) +
            CAST(new_cluster_creditHistory_question5di as int) +
            CAST(new_cluster_creditHistory_question5ei as int) +
            CAST(new_cluster_creditHistory_question5aii as int) +
            CAST(new_cluster_creditHistory_question5bii as int) +
            CAST(new_cluster_creditHistory_question5cii as int) +
            CAST(new_cluster_creditHistory_question5dii as int) +
            CAST(new_cluster_creditHistory_question5eii as int) +
            CAST(new_cluster_creditHistory_question5aiii as int) +
            CAST(new_cluster_creditHistory_question5biii as int) +
            CAST(new_cluster_creditHistory_question5ciii as int) +
            CAST(new_cluster_creditHistory_question5diii as int) +
            CAST(new_cluster_creditHistory_question5eiii as int)
        ) as total_Cumalative_Of_Loans_Disbursed

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


        (string)$res->applications_received_loans,
        (string)$res->approved_loan,
        (string)$res->pending_loan_applications,

        (string)$res->total_cumulative_amount,
        (string)$res->cumulative_amount_cluster,
        (string)$res->cumulative_amount_federation,
        (string)$res->cumulative_amount_bank,
        (string)$res->cumulative_amount_other,

        (string)$res->total_Cumalative_Of_Loans_Disbursed,

        (string)$res->cumulative_members_cluster,
        (string)$res->new_cluster_creditHistory_question5ai,
        (string)$res->new_cluster_creditHistory_question5aii,
        (string)$res->new_cluster_creditHistory_question5aiii,

        (string)$res->cumulative_members_federation,
        (string)$res->new_cluster_creditHistory_question5bi,
        (string)$res->new_cluster_creditHistory_question5bii,
        (string)$res->new_cluster_creditHistory_question5biii,

        (string)$res->cumulative_members_bank,
        (string)$res->new_cluster_creditHistory_question5ci,
        (string)$res->new_cluster_creditHistory_question5cii,
        (string)$res->new_cluster_creditHistory_question5ciii,

        (string)$res->cumulative_members_other,
        (string)$res->new_cluster_creditHistory_question5ei,
        (string)$res->new_cluster_creditHistory_question5eii,
        (string)$res->new_cluster_creditHistory_question5eiii,

        (string)$res->interest_rate,
        (string)$res->cluster_cumulative_interest,
        (string)$res->federation_cumulative_interest,
        (string)$res->vi_cumulative_interest,
        (string)$res->other_cumulative_interest,

        (string)$res->cumulative_poor_members_cluster,
        (string)$res->cumulative_poor_members_federation,
        (string)$res->cumulative_poor_members_bank,
        (string)$res->cumulative_poor_members_other,
        (string)$res->total_cumulative_poor_members,






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


            'No. Of applications Cluster has received for loans in last 12 months',
            'No. Of loan applications approved in last 12 months',
            'Pending loan applications for  more than 3 months',

            'Cumalative amount of loan at cluster level',
            'Cluster Loan',
            'Federation Loan',
            'Bank Loan',
            'Other Loan',

            'Cumalative No. Of Loans Disbursed - last 3 years',

            'No. of Cluster loans disbursed in last 3 years - Very Poor category',
            'No. of Cluster loans disbursed in last 3 years  -  Poor category',
            'No. of Cluster loans disbursed in last 3 years  - Medium category',
            'No. of Cluster loans disbursed in last 3 years  - Rich category',

            'No. of Federation loans  Disbursed in last 3 years  - Very Poor category',
            'No. of Federation loans  Disbursed in last 3 years  - Poor category ',
            'No. of Federation loans  Disbursed in last 3 years- Medium Category',
            'No. of Federation loans  Disbursed in last 3 years - Rich Category',

            'No. of Banks loans  Disbursed in last 3 years  - Very Poor category',
            'No. of Banks loans  Disbursed in last 3 years  - Poor category ',
            'No. of Banks loans  Disbursed in last 3 years- Medium Category',
            'No. of Banks loans  Disbursed in last 3 years - Rich Category',

            'No. of Other loans  Disbursed in last 3 years  - Very Poor category',
            'No. of Other loans  Disbursed in last 3 years  - Poor category ',
            'No. of Other loans  Disbursed in last 3 years- Medium Category',
            'No. of Other loans  Disbursed in last 3 years - Rich Category',

            'Percent Charged',
            'Cluster Loans',
            'Federation Loans',
            'Bank Loans',
            'Other Loans',

            'No. Of member HHs who received loan during last 3 years - Cluster ',
            'No. Of member HHs who received loan during last 3 years - Federation',
            'No. Of member HHs who received loan during last 3 years - Bank',
            'No. Of member HHs who received loan during last 3 years - Other',
            'Total No. of Member hhs who received loans during last 3 years',

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster CRecovery - Cumulative loans';
    }
}
