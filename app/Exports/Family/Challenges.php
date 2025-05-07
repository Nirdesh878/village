<?php

namespace App\Exports\Family;

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


class Challenges implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $session_data = Session::get('family_export_session');

        $isClusterSelected = !empty($session_data['cluster']);

        $query = "WITH RankesChallenges AS (SELECT
        f.id,
        f.uin,
        fp.fp_member_name,
        fp.fp_wealth_rank,
        sp.shgName,
        cp.name_of_cluster,
        fedp.name_of_federation,
        fp.analysis_rating,
        fc.challenges,
         ROW_NUMBER() OVER (PARTITION BY f.id ORDER BY fc.id) AS challengesRank
     FROM
        family_mst AS f 
        INNER JOIN family_profile AS fp ON f.id = fp.family_sub_mst_id
        INNER JOIN shg_mst AS s ON f.shg_uin = s.uin
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        LEFT JOIN family_challenges AS fc
        ON f.id = fc.family_sub_mst_id

	 WHERE  s.is_deleted = 0 AND f.is_deleted = 0  ";

        if ($isClusterSelected) {
            $query .= " AND c.is_deleted = 0 ";
        }

        if (!empty($session_data['Search'])) {
            if (!empty($session_data['agency'])) {
                $agency = $session_data['agency'];
                $query .= " AND f.agency_id = $agency  ";
            }
            if (!empty($session_data['federation'])) {
                $query .= " AND fed.uin = '" . $session_data['federation'] . "' ";
            }
            if (!empty($session_data['cluster'])) {
                $query .= " AND c.uin = '" . $session_data['cluster'] . "' ";
            }
            if (!empty($session_data['shg'])) {
                $query .= " AND s.uin = '" . $session_data['shg'] . "' ";
            }
            if (!empty($session_data['family'])) {
                $query .= " AND f.uin = '" . $session_data['family'] . "' ";
            }
        }

        $query .= " ORDER  BY f.id ) ";
        // prd($query);
        $query .= "  SELECT
         id,
         uin,
         fp_member_name,
         fp_wealth_rank,
         shgName,
         name_of_cluster,
         name_of_federation,
         analysis_rating,
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
            $res->fp_member_name,
            $res->shgName,
            $res->name_of_cluster,
            $res->name_of_federation,
            $res->fp_wealth_rank,
            $res->analysis_rating,
            $res->challenges1,
            $res->challenges2,
            $res->challenges3,
            $res->challenges4,
            $res->challenges5,

        ];
    }

    public function columnFormats(): array
    {
        return [];
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
                        'color' => ['argb' => '#CCCCCC']
                    ]
                ]);
            },
        ];
    }

    public function headings(): array
    {
        return [

            [
                'S.No',
                'UIN',
                'SHG MEMBER NAME',
                'NAME OF SHG',
                'CLUSTER NAME ',
                'FEDERATION NAME',
                'WEALTH/POVERTY RANKING',
                'RISK RATING/SCORE CARD',
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
        return 'Family Challenges';
    }
}
