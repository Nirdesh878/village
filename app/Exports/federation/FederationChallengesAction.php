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


class FederationChallengesAction implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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



        $query = "WITH RankesChallenges AS (SELECT
        fed.id,
        fed.uin AS uin,
        fedp.name_of_federation,
        fedp.analysis_rating AS risk_rating,
        fedp.clf_code AS NRLM_code,
        fedp.name_of_district AS district_name,
        fedp.name_of_state AS state_name,
        ag.agency_name,
        fedc.challenge as challenges,
        fedc.action as action,
         ROW_NUMBER() OVER (PARTITION BY fed.id ORDER BY fedc.id) AS challengesRank
      FROM
            federation_mst AS fed
        INNER JOIN federation_profile AS fedp ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN agency AS ag ON fed.agency_id = ag.agency_id
        INNER JOIN federation_challenges AS fedc ON fedc.federation_sub_mst_id = fed.id
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

          $query .=" ORDER  BY fed.id ) ";
        // prd($query);
         $query .="  SELECT
         id,
         uin,
         name_of_federation,
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
        // prd($query);
        $federation = DB::select($query);
        // prd($federation);
        return collect($federation);
    }



    public function map($res): array
    {


            return [
                $this->counter++,
                $res->uin,
                $res->name_of_federation,
                $res->risk_rating,
                $res->NRLM_code,
                $res->district_name,
                $res->state_name,
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
                $event->sheet->getStyle('A1:R1')->applyFromArray([
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
        return 'Federation Challenges & Action';
    }
}
