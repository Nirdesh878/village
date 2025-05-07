<?php

namespace App\Exports\Shg;
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


class SHGChallengesActionPlan implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $session_data = Session::get('shg_export_session');

        $isClusterSelected = !empty($session_data['cluster']);

        $query = "WITH RankesChallenges AS (SELECT
        s.id,
        s.uin AS uin ,
        sp.shgName AS shg_name,
        sp.analysis_rating AS risk_rating,
        sp.shg_code AS NRLM_code,
        cp.name_of_cluster AS cluster_name,
        fedp.name_of_federation AS federation_name,
        sp.village AS village,
        sc.challenge as challenges,
         ROW_NUMBER() OVER (PARTITION BY s.id ORDER BY sc.id) AS challengesRank
     FROM
        shg_mst AS s 
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        LEFT JOIN shg_challenges AS sc
        ON s.id = sc.shg_sub_mst_id
        INNER JOIN agency AS ag
        ON s.agency_id = ag.agency_id
	    WHERE s.is_deleted = 0 ";
        
        if ($isClusterSelected) {
            $query .= " AND c.is_deleted = 0 ";
        }

          if(!empty($session_data['Search'])){
            if(!empty($session_data['agency'])){
                $agency = $session_data['agency'];
                $query .=" AND s.agency_id = $agency  ";
             }
             if(!empty($session_data['federation'])){
                $query .=" AND fed.uin = '" . $session_data['federation'] . "' ";
             }
             if(!empty($session_data['cluster'])){
                $query .=" AND c.uin = '" . $session_data['cluster'] . "' ";
             }
             if(!empty($session_data['shg'])){
                $query .=" AND s.uin = '" . $session_data['shg'] . "' ";
             }
          }

          $query .=" ORDER  BY s.id ) ";
        // prd($query);
         $query .="  SELECT
         id,
         uin,
         shg_name,
         risk_rating,
         NRLM_code,
         cluster_name,
         federation_name,
         village,
          MAX(CASE WHEN challengesRank = 1 THEN challenges END) AS challenges1,
                MAX(CASE WHEN challengesRank = 2 THEN challenges END) AS challenges2,
                MAX(CASE WHEN challengesRank = 3 THEN challenges END) AS challenges3,
                MAX(CASE WHEN challengesRank = 4 THEN challenges END) AS challenges4,
                MAX(CASE WHEN challengesRank = 5 THEN challenges END) AS challenges5
           FROM RankesChallenges
           GROUP BY id
         ";
        // prd($query);
        $familys = DB::select($query);
        // prd($familys);
        return collect($familys);
    }

    public function map($res): array
    {


            return [
                $this->counter++,
                $res->uin,
                $res->shg_name,
                $res->risk_rating,
                $res->NRLM_code,
                $res->cluster_name,
                $res->federation_name,
                $res->village,
                $res->challenges1,
                $res->challenges2,
                $res->challenges3,
                $res->challenges4,
                $res->challenges5,

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
                $event->sheet->getStyle('A1:M1')->applyFromArray([
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
            'Name of SHG',
            'RISK RATING',
            'NRLM Code ',
            'Cluster Name',
            'Federation name',
            'Name of Village',
            'CHALLENGE 1',
            'CHALLENGE 2',
            'CHALLENGE 3',
            'CHALLENGE 4',
            'CHALLENGE 5'
          ]
        ];
    }

    public function title(): string
    {
        return 'SHG Challenges';
    }
}
