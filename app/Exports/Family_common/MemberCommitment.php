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


class MemberCommitment implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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

        $query = "SELECT
        f.id,
        f.uin,
        fp.fp_member_name,
        sp.shgName,
        cp.name_of_cluster,
        fedp.name_of_federation,
        fp.fp_wealth_rank,
        fp.analysis_rating,
        fs.yo_meeting_yes_no,
        fs.yo_meeting_attend,

        GROUP_CONCAT(
           CASE WHEN fs.yo_frequency_metting = 1 THEN 'Frequency of meeting, ' ELSE '' END,
           CASE WHEN fs.yo_interest_rates = 1 THEN 'Interest rates, ' ELSE '' END,
           CASE WHEN fs.yo_receive_loan = 1 THEN 'Receive loan, ' ELSE '' END,
           CASE WHEN fs.yo_max_loan_amount = 1 THEN 'Max loan amount' ELSE '' END
        ) AS understanding_of_rules,
        fs.yo_somewhat_yes_no,
        fs.yo_family_member_participate_no_of_activity,
        fs.yo_member_aware_categories
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
        INNER JOIN family_shgmember_commitment AS fs
        ON f.id = fs.family_sub_mst_id


          WHERE  s.is_deleted = 0 AND f.is_deleted = 0";

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



        $query .= "GROUP BY  f.id  ORDER BY f.id
         ";
        // prd($query);
        $familys = DB::select($query);
        // prd($familys);
        return collect($familys);
    }

    public function map($res): array
    {

        $WealthData = getMstCommonData(7,$res->fp_wealth_rank);
        $wealthName = $WealthData->isNotEmpty() ? $WealthData[0]->common_values : 'N/A';

        return [
            $this->counter++,
            $res->uin,
            $res->fp_member_name,
            $res->shgName,
            $res->name_of_cluster,
            $res->name_of_federation,
            $wealthName,
            $res->analysis_rating,
            $res->yo_meeting_yes_no,
            $res->yo_meeting_attend,
            $res->understanding_of_rules,
            $res->yo_somewhat_yes_no,
            $res->yo_family_member_participate_no_of_activity,
            $res->yo_member_aware_categories,

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
                $event->sheet->getStyle('A1:N1')->applyFromArray([
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
                'Regularly attend SHG meeting?(yes or no)',
                'No. of meetings attended in last 12 months',
                'Understanding of SHG rules',
                'Participate in community development activities',
                'No. of activities member has participated',
                'IF THE MEMEBER IS AWARE OF ALL CATEGORIES ? '

            ]
        ];
    }

    public function title(): string
    {
        return 'Family Member Commitment';
    }
}
