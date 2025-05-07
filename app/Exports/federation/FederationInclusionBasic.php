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


class FederationInclusionBasic implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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

        $query = "SELECT
            fed.id,
            fed.uin AS uin,
            fedp.name_of_federation AS federation_name,
            fedp.analysis_rating AS risk_rating,
            fedp.clf_code AS NRLM_code,
            fedp.name_of_district AS district_name,
            fedp.name_of_state AS state_name,
            ag.agency_name AS agency_name,
            SUM(CAST(fedi.federation_inclusion_poor_members AS INT) +
                CAST(fedi.federation_inclusion_poor1_members AS INT) +
                CAST(fedi.federation_inclusion_rich_members AS INT)) AS Total_no_of_office_bearers_federation,
            fedi.*
        FROM
            federation_mst AS fed
        INNER JOIN federation_profile AS fedp ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN agency AS ag ON fed.agency_id = ag.agency_id
        INNER JOIN federation_inclusion AS fedi ON fedi.federation_sub_mst_id = fed.id
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

        $query .=" group by fed.id  ";

        $federation = DB::select($query);
         // prd($federation);
        return collect($federation);
    }

    public function map($res): array
    {


            return [
                $this->counter++,
                $res->uin,
                $res->federation_name,
                $res->risk_rating,
                $res->NRLM_code,
                $res->district_name,
                $res->state_name,
                $res->agency_name,

        (string)$res->wealth_ranking_mapping,
        (string)$res->month_year_of_1st_poverty_mapping,
        (string)$res->month_year_of_last_update,
        (string)$res->total_poverty_mapping_households,
        (string)$res->total_poverty_mapping_ineligible_mobilised,
        (string)$res->total_poverty_mapping_mobilised_member,

        (string)$res->no_of_poorest_and_most_vulnerable,
        (string)$res->no_of_poorest_and_most_vulnerable_hhm,
        (string)$res->no_of_poorest_and_most_vulnerable_mobilised,


        (string)$res->no_of_poor_category,
        (string)$res->no_of_poor_category_hhm,
        (string)$res->no_of_poor_category_mobilised,

        (string)$res->no_of_medium_poor,
        (string)$res->no_of_medium_poor_hhm,
        (string)$res->no_of_medium_poor_mobilised,

        (string)$res->no_of_rich,
        (string)$res->no_of_rich_hhm,
        (string)$res->no_of_rich_mobilised,

        (string)$res->no_of_SC_and_ST,
        (string)$res->no_of_OBC,
        (string)$res->no_of_others,

        (string)$res->total_board_members_cluster,
        (string)$res->members_from_poorest_category,
        (string)$res->members_from_poor_category,
        (string)$res->members_from_middle_and_rich_category,

        (string)$res->Total_no_of_office_bearers_federation,
        (string)$res->federation_inclusion_poor_members,
        (string)$res->federation_inclusion_poor1_members,
        (string)$res->federation_inclusion_rich_members,

        (string)$res->federation_social_goal_a,
        (string)$res->federation_social_goal_b,
        (string)$res->federation_social_goal_c

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
                $event->sheet->getStyle('A1:AR1')->applyFromArray([
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
            'Agency',


            'Wealth Ranking/Poverty Mapping',
            'If Yes, Date Of 1st Poverty Mapping',
            'Date Of Last Update ( in 12 months)',
            'Last Wealth Ranking results - total HHs',
            'total ineligible to get mobilzws inro SHGs',
            'total SHG members mobilized',

            '(a) No Of Poorest and Vulnerable category',
            'HH Member (i)',
            'Ineligble to get mobilized (ii)',


            '(b) Number Of  Poor',
            'HH Member (i)',
            'Ineligble to get mobilized (ii)',


            '(c) Number Of Medium Poor',
            'HH Member (i)',
            'Ineligble to get mobilized (ii)',


            '(d) Number Of Rich',
            'HH Member (i)',
            'Ineligble to get mobilized (ii)',


            'Number Of SC/ST',
            'Number Of OBC',
            'Number Of Others',

            'total no of Board members in the federation (QN 5)',
            'Number of Board members from the Poorest & vulnerable',
            'No of Board members from Poor category',
            'No of Board members from middle and rich category',

            'Total no of office bearers in the federation (Q6)',
            'total office bearers from the Poorest & vulnerable',
            'total office bearers from the Poor',
            'total office bearers from the Middle Poor & Rich',

            'What is the federation Social goal for current year (Q&) -Goal 1',
            'What is the federation Social goal for current year (Q&) -Goal 2',
            'What is the federation Social goal for current year (Q&) -Goal 3'
            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Inclusion Basic';
    }
}
