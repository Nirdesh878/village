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


class ClusterInclusionBasic implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        cli.*,
        cl.uin,
        ag.agency_name,
        fedp.name_of_federation,
        clp.*

     FROM
         cluster_mst AS cl
          INNER JOIN cluster_profile AS clp
          ON cl.id = clp.cluster_sub_mst_id
          INNER JOIN federation_mst as fed
          on fed.uin = cl.federation_uin
          INNER JOIN cluster_inclusion as cli
          on cl.id = cli.cluster_sub_mst_id
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

        (string)$res->wealth_ranking,
        (string)$res->first_poverty_mapping,
        (string)$res->last_update,
        (string)$res->total_members,
        (string)$res->visual_poorest_category,
        (string)$res->visual_poor_category,
        (string)$res->visual_medium_category,
        (string)$res->visual_rich_category,
        (string)$res->sc_st_caste,
        (string)$res->obc_caste,
        (string)$res->other_caste,
        (string)$res->poor_current_leadership,
        (string)$res->board_members_constitution,
        (string)$res->total_board_members,
        (string)$res->poorest_board_members,
        (string)$res->poor_board_members,
        (string)$res->rich_board_members,
        (string)$res->total_target_poor,
        (string)$res->target_poor_mobilized,
        (string)$res->percentage_poor_mobilized,

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
                $event->sheet->getStyle('A1:AC1')->applyFromArray([
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


            'Wealth ranking/poverty mapping (yes or no)',
            'if yes, Date of 1st Poverty mapping ',
            'Date of last update ( in 12 months)',
            'Current members ',
            'No of Poorest and Vulnerable Members',
            'Number of Poor members',
            'Number of medium poor',
            'Number of Rich',
            'Number of SC/ST',
            'Number of OBC',
            'Number of others',
            'No. Of most poor and poor in current leadership position',
            'Cluster/Habitation board member constitution (Yes or No)',
            'If yes, Total no. of board members in the cluster',
            'No. of members from poorest category',
            'No. of members from poor category',
            'No. of members from middle and rich category',
            'Total Target poor in the Cluster',
            'No. of target poor mobilized into SHGs ',
            'Percentage of target poor mobilized into SHGs '

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Inclusion';
    }
}
