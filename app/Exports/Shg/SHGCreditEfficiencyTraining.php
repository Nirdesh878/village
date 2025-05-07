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


class SHGCreditEfficiencyTraining implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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

        $query = "SELECT
        s.id,
        s.uin AS uin,
        sp.shgName AS shg_name,
        sp.analysis_rating AS Risk_Rating,
        sp.shg_code AS NRLM_code,
        cp.name_of_cluster AS cluster_name,
        fedp.name_of_federation AS federation_name,
        sp.village AS village,
        se.bookkeeper_trained,
        se.name_training,
        se.date_training as date_of_training,
        se.duration_training,
        se.leaders_received_training,
        se.SHG_Efficiency_Training_object
    FROM
        shg_mst AS s 
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN shg_efficiency AS se ON se.shg_sub_mst_id = s.id
        WHERE s.is_deleted = 0 ";

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

        $shg_data = DB::select($query);
        // prd($query);
        $efficiency_training = [];

        foreach ($shg_data as $result) {
            $desg = [];
            $training_name = [];
            $duration = [];
            $date_training = [];
            $secretary = [];
            $president = [];
            $treasurer = [];
            $who_received = [];
            $other = [];
            $other_value = [];

            if (!empty($result->SHG_Efficiency_Training_object)) {
                $efficiency_details = json_decode(stripslashes($result->SHG_Efficiency_Training_object));

                foreach ($efficiency_details as $entry) {
                    $training_name[] = $entry->training_name;
                    $duration[] = $entry->duration;
                    $date_training[] = $entry->date_training;
                    $secretary[] = $entry->secretary == 1 ? 'secretary' : '';
                    $president[] = $entry->president == 1 ? 'president' : '';
                    $treasurer[] = $entry->treasurer == 1 ? 'treasurer' : '';
                    $other[] = $entry->other == 1 ? 'other' : '';
                    $who_received[] = $entry->who_received;
                    // if (!empty($entry->other)) {
                    //     $other[] = $entry->other;
                    // }
                    // if (!empty($entry->other_value)) {
                    //     $other_value[] = $entry->other_value;
                    // }
                }
            }

            $result->training_name = implode(',', $training_name);
            $result->duration = implode(',', $duration);
            $result->date_training = implode(',', $date_training);
            $result->secretary = implode(',', $secretary);
            $result->president = implode(',', $president);
            $result->treasurer = implode(',', $treasurer);
            $result->other = implode(',', $other);
            $result->who_deliverd = implode(',', array_merge($secretary, $president, $treasurer, $other));
            $result->who_received = implode(',', $who_received);
            // $result->other = implode(',', $other);
            // $result->other_value = implode(',', $other_value);

            $efficiency_training[] = $result;
        }

        // The $data['efficiency_training'] now contains the combined result


        // prd($efficiency_training);




        // prd($familys);
        return collect($efficiency_training);
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
            $res->bookkeeper_trained,
            $res->name_training,
            $res->date_of_training,
            $res->duration_training,
            $res->leaders_received_training,
            $res->training_name,
            $res->duration,
            $res->date_training,
            $res->who_deliverd,
            $res->who_received,
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
                $event->sheet->getStyle('A1:R1')->applyFromArray([
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
                'Risk Rating',
                'NRLM Code',
                'Cluster Name',
                'Federation Name',
                'Name of Village',
                'Bookkeeper Trained',
                'Name of Training(bookkeepr)',
                'Date of Training(bookkeeper)',
                'Duration of Ttraining(bookkeeper)',
                'Current leaders Received any Training ( yes or No)',
                'Name of Training',
                'Duration in days',
                'Date of Training',
                'Who Received the training?',
                'Delivered By ',

            ]
        ];
    }

    public function title(): string
    {
        return 'SHG Credit Efficiency - Training';
    }
}
