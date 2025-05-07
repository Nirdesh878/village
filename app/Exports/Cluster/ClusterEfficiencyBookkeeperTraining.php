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


class ClusterEfficiencyBookkeeperTraining implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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

        $query = "SELECT
            cl.id,
            cl.uin AS uin,
            fedp.name_of_federation,
            clp.name_of_cluster,
            clp.analysis_rating AS risk_rating,
            clp.vo_code AS NRLM_code,
            clp.name_of_district AS district_name,
            clp.name_of_state AS state_name,
            ag.agency_name,
            cle.*

        FROM
            cluster_mst AS cl
            INNER JOIN cluster_profile AS clp ON cl.id = clp.cluster_sub_mst_id
            INNER JOIN federation_mst AS fed ON fed.uin = cl.federation_uin
            INNER JOIN cluster_efficiency AS cle ON cl.id = cle.cluster_sub_mst_id
            INNER JOIN federation_profile AS fedp ON fed.id = fedp.federation_sub_mst_id
            INNER JOIN agency AS ag ON cl.agency_id = ag.agency_id

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
                $res->risk_rating,
                $res->NRLM_code,
                $res->name_of_federation,
                $res->agency_name,


        (string)$res->book_keeper_trained,
        (string)$res->name_training,
        (string)$res->duration,
        (string)$res->date_training,






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
                $event->sheet->getStyle('A1:Z1')->applyFromArray([
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
            'Federation Name',
            'Agency Name',

            'Has book-keeper been trained during last 12 months (Yes/No)',
            'Name of Training',
            'Duration in days',
            'Date of training'

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Efficiency CurrentLeadTraining';
    }
}
