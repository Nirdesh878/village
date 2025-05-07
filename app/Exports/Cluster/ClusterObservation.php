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


class ClusterObservation implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        clo.*

     FROM
         cluster_mst AS cl
          INNER JOIN cluster_profile AS clp
          ON cl.id = clp.cluster_sub_mst_id
          INNER JOIN federation_mst as fed
          on fed.uin = cl.federation_uin
          INNER JOIN cluster_observation as clo
          on cl.id = clo.cluster_sub_mst_id
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
        $answer = [];
        foreach($cluster as  $row){
            if ($row->cluster_observation_secretary == 1) {
                $answer[] = 'Secretary';
                }
                if ($row->cluster_observation_president == 1) {
                $answer[] = 'President';
                }
                if ($row->cluster_observation_treasure == 1) {
                $answer[] = 'Treasurer';
                }
                if ($row->cluster_observation_bookkeeper == 1) {
                $answer[] = 'Book-Keeper';
                }
                if ($row->cluster_observation_sub_commit == 1) {
                    $answer[] = 'Sub-Commitee Members';
                }
                if ($row->cluster_observation_other == 1) {
                    $answer[] = 'Other';
                }
                $answer = array_unique($answer);
                $row->answer = implode(',', $answer);


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

        (string)$res->cluster_observation_meeting,
        (string)$res->answer,
        (string)$res->cluster_observation_carried_out,
        (string)$res->cluster_observation_leaders_only,
        (string)$res->cluster_observation_Cluster,
        (string)$res->cluster_observation_benefits,
        (string)$res->cluster_observation_paid_time,
        (string)$res->cluster_observation_practices,
        (string)$res->cluster_observation_provided_them,
        (string)$res->cluster_observation_policy_explain,
        (string)$res->cluster_observation_updated_records,
        (string)$res->cluster_observation_leaders_office,
        (string)$res->cluster_observation_special,
        (string)$res->cluster_observation_support_groups,
        (string)$res->cluster_observation_highlights_a,
        (string)$res->cluster_observation_highlights_b,
        (string)$res->cluster_observation_highlights_c,
        (string)$res->cluster_observation_highlights_d,
        (string)$res->cluster_observation_highlights_e



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
                $event->sheet->getStyle('A1:AB1')->applyFromArray([
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


            'Who attended the meeting? - No of members',
            'Were all office bearers and leaders present?',
            'Did Cluster leaders understand purpose of meeting?',
            'What was quality of discussion?',
            'Did Cluster leaders & members understand vision of the cluster ?',
            'Do they understand benefits of being part of group? Explain benefits',
            'Does cluster have set practice of how repayments and savings are collected? Any Penalties?',
            'What are those practices?',
            'Does Cluster include any members who are the most poor and vulnerable?',
            'if yes, What is cluster policy on most vulnerable memebrs?  ',
            'Are books of accounts managed by book-keeper only or others are aware of information as well?',
            'Any highlights?',
            'Any unique features of this Cluster?',
            'What are the unique rules/practices?',
            'Important Higlights (1)',
            'Important highlights (2)',
            'Important highlights (3)',
            'Important highlights (4)',
            'Important highlights (5)',

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Observation';
    }
}
