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


class ClusterChallengesActions implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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

        $query = "WITH RankesChallenges AS (SELECT
        cl.id,
        cl.uin as uin,
        fedp.name_of_federation,
        clp.name_of_cluster,
        clp.analysis_rating AS risk_rating,
        clp.vo_code AS NRLM_code,
        clp.name_of_district AS district_name,
        clp.name_of_state AS state_name,
        ag.agency_name,
        clc.challenge as challenges,
        clc.action as action,
         ROW_NUMBER() OVER (PARTITION BY cl.id ORDER BY clc.id) AS challengesRank
      FROM
         cluster_mst AS cl
          INNER JOIN cluster_profile AS clp
          ON cl.id = clp.cluster_sub_mst_id
          INNER JOIN federation_mst as fed
          on fed.uin = cl.federation_uin
          INNER JOIN cluster_challenges as clc
          on cl.id = clc.cluster_sub_mst_id
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

          $query .=" ORDER  BY cl.id ) ";

           $query .="  SELECT
           id,
           uin,
           name_of_federation,
           name_of_cluster,
           risk_rating,
           NRLM_code,
           district_name,
           state_name,
           agency_name,
                  MAX(CASE WHEN challengesRank = 1 THEN challenges END) AS challenges1,
                  MAX(CASE WHEN challengesRank = 2 THEN challenges END) AS challenges2,
                  MAX(CASE WHEN challengesRank = 3 THEN challenges END) AS challenges3,
                  MAX(CASE WHEN challengesRank = 4 THEN challenges END) AS challenges4,
                  MAX(CASE WHEN challengesRank = 5 THEN challenges END) AS challenges5,

                  MAX(CASE WHEN challengesRank = 1 THEN JSON_UNQUOTE(JSON_EXTRACT(action, '$[0].sa_describe_action')) END) AS action1,
                  MAX(CASE WHEN challengesRank = 2 THEN JSON_UNQUOTE(JSON_EXTRACT(action, '$[0].sa_describe_action')) END) AS action2,
                  MAX(CASE WHEN challengesRank = 3 THEN JSON_UNQUOTE(JSON_EXTRACT(action, '$[0].sa_describe_action')) END) AS action3,
                  MAX(CASE WHEN challengesRank = 4 THEN JSON_UNQUOTE(JSON_EXTRACT(action, '$[0].sa_describe_action')) END) AS action4,
                  MAX(CASE WHEN challengesRank = 5 THEN JSON_UNQUOTE(JSON_EXTRACT(action, '$[0].sa_describe_action')) END) AS action5
             FROM RankesChallenges
             GROUP BY id
           ";
        $cluster = DB::select($query);
        return collect($cluster);
    }

    public function map($res): array
    {


            return [
                $this->counter++,
                $res->uin,
                $res->name_of_cluster,
                $res->risk_rating,
                $res->NRLM_code,
                $res->district_name,
                $res->state_name,
                $res->name_of_federation,
                $res->agency_name,


                (string)$res->challenges1,
                (string)$res->challenges2,
                (string)$res->challenges3,
                (string)$res->challenges4,
                (string)$res->challenges5,

                (string)$res->action1,
                (string)$res->action2,
                (string)$res->action3,
                (string)$res->action4,
                (string)$res->action5



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
                $event->sheet->getStyle('A1:S1')->applyFromArray([
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


            'CHALLENGE 1',
            'CHALLENGE 2',
            'CHALLENGE 3',
            'CHALLENGE 4',
            'CHALLENGE 5',

            'ACTION 1',
            'ACTION 2',
            'ACTION 3',
            'ACTION 4',
            'ACTION 5'

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Challenges & Action';
    }
}
