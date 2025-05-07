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


class ClusterBasicInformation implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        fedp.name_of_federation

     FROM
         cluster_mst AS cl
          INNER JOIN cluster_profile AS clp
          ON cl.id = clp.cluster_sub_mst_id
          INNER JOIN federation_mst as fed
          on fed.uin = cl.federation_uin
          INNER JOIN federation_profile as fedp
          on fed.id = fedp.federation_sub_mst_id
          INNER JOIN agency AS ag
          ON cl.agency_id = ag.agency_id

          WHERE cl.is_deleted = 0";
        if (!empty($session_data['Search'])) {
            if (!empty($session_data['agency'])) {
                $agency = $session_data['agency'];
                $query .= " AND cl.agency_id = $agency  ";
            }
            if (!empty($session_data['cluster'])) {
                $query .= " AND cl.uin = '" . $session_data['cluster'] . "' ";
            }
            if (!empty($session_data['federation'])) {
                $query .= " AND fed.uin = '" . $session_data['federation'] . "' ";
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

            (string)$res->cluster_formed,
            (string)$res->shg_at_time_creation,
            (string)$res->total_members,
            (string)$res->total_SHGs,
            (string)$res->total_members,
            (string)$res->president,
            (string)$res->secretary,
            (string)$res->treasure,
            (string)$res->book_keeper_name,
            (string)$res->date_of_appointment,
            (string)$res->account_opening_date,
            (string)$res->name_of_the_bank,
            (string)$res->name_of_the_contact_person,
            (string)$res->designation,
            (string)$res->contact_number



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
                $event->sheet->getStyle('A1:Z1')->applyFromArray([
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
                'Name Of Cluster',
                'Risk Rating',
                'NRLM Code ',
                'District Name',
                'State Name',
                'Federation name',
                'Agency Name',


                'Date Formed',
                'No. Of SHG,s at creation',
                'No. of Members at time of creation',
                'Current SHG no.',
                'Current Members',
                'Current President',
                'Current Secretary',
                'Current Treasurer',
                'Current Book- keeper',
                'Date of Appointment - Book keeper',
                'Bank Account opening date',
                'Name of Bank',
                'Name of contact person',
                'Designation',
                'Contact Number'

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Basic Information';
    }
}
