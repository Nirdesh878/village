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


class SHGObservation implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
{

    public $curdate = '';
    public $counter = 1;
    public function __construct()
    {
        $this->curdate = Carbon::now()->format('d-m-Y');
    }

    public function collection()
    {

        // dd("SHGObservation heading complete");
        $user = Auth::user();
        $session_data = Session::get('shg_export_session');
        // prd($session_data);

        $isClusterSelected = !empty($session_data['cluster']);

        $query = "SELECT
        s.id,
        s.uin AS uin ,
        sp.shgName AS shg_name,
        sp.analysis_rating AS Risk_Rating,
        sp.shg_code AS NRLM_code,
        cp.name_of_cluster AS cluster_name,
        fedp.name_of_federation AS federation_name,
        sp.village AS village,
        CONCAT(
        CASE WHEN so.shg_observation_chair = 1 THEN 'Chair ,' ELSE '' END ,
        CASE WHEN so.shg_observation_secretary = 1 THEN 'Secretary ,' ELSE '' END ,
        CASE WHEN so.shg_observation_bookkeeper = 1 THEN 'Bookkeeper ,' ELSE '' END ,
        CASE WHEN so.shg_observation_treasure = 1 THEN 'Treasure ,' ELSE '' END ,
        CASE WHEN so.shg_observation_other = 1 THEN 'Other' ELSE '' END
        ) AS attended_the_meeting,
        so.shg_observation_Purpose_a AS understand_purpose_of_meeting,
        so.shg_observation_discussion_a AS quality_of_Discussion,
        shg_observation_norms_a AS aware_of_their_rules_and_norms,
        so.shg_observation_norms_b AS  being_part_of_group,
        so.shg_observation_savings_a AS  repayments_and_savings_are_collected,
        so.shg_observation_savings_b AS What_are_practices,
        so.shg_observation_vulnerable_members AS most_vulnerable_memebrs,
        so.shg_observation_financial_information_a AS only_or_others_are_aware_as_well,
        so.shg_observation_financial_information_b AS  their_savings_loans_and_financial_information,
        so.shg_observation_features_group_a AS unique_features_of_this_group,
        so.shg_observation_highlights_a AS Important_highlights_1,
        so.shg_observation_highlights_b AS Important_highlights_2,
        so.shg_observation_highlights_c AS Important_highlights_3,
        so.shg_observation_highlights_d AS Important_highlights_4,
        so.shg_observation_highlights_e AS Important_highlights_5
        FROM
            shg_mst AS s 
            INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
            LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
            LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
            INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
            INNER JOIN federation_profile AS fedp
            ON fed.id = fedp.federation_sub_mst_id
            INNER JOIN shg_observation AS so
            ON so.shg_sub_mst_id = s.id
            WHERE s.is_deleted = 0 AND fed.is_deleted = 0";

        if ($isClusterSelected) {
            $query .= " AND c.is_deleted = 0 ";
        }

        if (!empty($session_data['Search'])) {
            if (!empty($session_data['agency'])) {
                $agency = $session_data['agency'];
                $query .= " AND s.agency_id = $agency  ";
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
        }

        $query .= "  GROUP BY s.id
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
            $res->Risk_Rating,
            $res->NRLM_code,
            $res->cluster_name,
            $res->federation_name,
            $res->village,

            $res->attended_the_meeting,
            $res->understand_purpose_of_meeting,
            $res->quality_of_Discussion,
            $res->aware_of_their_rules_and_norms,
            $res->being_part_of_group,
            $res->repayments_and_savings_are_collected,
            $res->What_are_practices,
            $res->most_vulnerable_memebrs,
            $res->only_or_others_are_aware_as_well,
            $res->their_savings_loans_and_financial_information,
            $res->unique_features_of_this_group,
            $res->Important_highlights_1,
            $res->Important_highlights_2,
            $res->Important_highlights_3,
            $res->Important_highlights_4,
            $res->Important_highlights_5,


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
                $event->sheet->getStyle('A1:X1')->applyFromArray([
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
                'Name of SHG',
                'RISK RATING',
                'NRLM Code',
                'Cluster Name',
                'Federation Name',
                'Name of Village',
                'Who attended the meeting?',
                'Did members understand purpose of meeting?',
                'What was quality of discussion?',
                'Were group memebrs aware of their rules and norms?',
                'Do they understand benefits of being part of group? Explain benefits',
                'Does Group have set practice of how repayments and savings are collected?',
                'What are practices?',
                'What is groups policy on most vulnerable memebrs?',
                'Are books of accounts managed by book-keeper only or others are aware as well?',
                'Explain if all members are aware of their savings, loans and financial information',
                'Any unique features of this group?',
                'Important highlights (1)',
                'Important highlights (2)',
                'Important highlights (3)',
                'Important highlights (4)',
                'Important highlights (5)'
            ]
        ];
    }

    public function title(): string
    {
        return 'SHG Observation';
    }
}
