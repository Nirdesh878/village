<?php
namespace App\Exports\federation;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FederationSACTraning implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
            fedp.id,
            fed.uin AS uin,
            fedp.name_of_federation ,
            fedp.analysis_rating AS risk_rating,
            fedp.clf_code AS NRLM_code,
            fedp.name_of_district AS district_name,
            fedp.name_of_state AS state_name,
            ag.agency_name ,
            fedg.Federation_SAC_Governance_Training_object,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[0].training_name')) AS training_name_1,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[1].training_name')) AS training_name_2,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[2].training_name')) AS training_name_3,

            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[0].duration')) AS duration_1,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[1].duration')) AS duration_2,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[2].duration')) AS duration_3,

            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[0].date_training')) AS date_training_1,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[1].date_training')) AS date_training_2,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[2].date_training')) AS date_training_3,

            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[0].name')) AS name_1,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[1].name')) AS name_2,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[2].name')) AS name_3,


            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[0].secretary')) AS secretary_1,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[0].president')) AS president_1,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[0].other')) AS other_1,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[0].treasurer')) AS treasurer_1,

            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[1].secretary')) AS secretary_2,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[1].president')) AS president_2,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[1].other')) AS other_2,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[1].treasurer')) AS treasurer_2,

            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[2].secretary')) AS secretary_3,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[2].president')) AS president_3,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[2].other')) AS other_3,
            JSON_UNQUOTE(JSON_EXTRACT(fedg.Federation_SAC_Governance_Training_object, '$[2].treasurer')) AS treasurer_3





        FROM
            federation_mst AS fed
        INNER JOIN federation_profile AS fedp ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN agency AS ag ON fed.agency_id = ag.agency_id
        INNER JOIN federation_governance AS fedg ON fedg.federation_sub_mst_id = fed.id
        WHERE
            fed.is_deleted = 0";

        if (!empty($session_data['Search'])) {
            if (!empty($session_data['agency'])) {
                $agency = $session_data['agency'];
                $query .= " AND fed.agency_id = $agency ";
            }
            if (!empty($session_data['federation'])) {
                $query .= " AND fed.uin = '" . $session_data['federation'] . "' ";
            }
        }

        // $query .= "group by fed.id" ;
        $federation = DB::select($query);
        $Recipient_1 = [];
        $Recipient_2 = [];
        $Recipient_3 = [];

        foreach($federation as  $row){
            if ($row->secretary_1 == 1) {
                $Recipient_1[] = 'Secretary';
                }
                if ($row->president_1 == 1) {
                $Recipient_1[] = 'President';
                }
                if ($row->treasurer_1 == 1) {
                $Recipient_1[] = 'Treasurer';
                }
                if ($row->other_1 == 1) {
                $Recipient_1[] = 'Other';
                }
                $Recipient_1 = array_unique($Recipient_1);
                $row->Training_Recipient_1 = implode(',', $Recipient_1);

                if ($row->secretary_2 == 1) {
                    $Recipient_2[] = 'Secretary';
                    }
                    if ($row->president_2 == 1) {
                    $Recipient_2[] = 'President';
                    }
                    if ($row->treasurer_2 == 1) {
                    $Recipient_2[] = 'Treasurer';
                    }
                    if ($row->other_2 == 1) {
                    $Recipient_2[] = 'Other';
                    }
                    $Recipient_2 = array_unique($Recipient_2);
                    $row->Training_Recipient_2 = implode(',', $Recipient_2);

                    if ($row->secretary_3 == 1) {
                        $Recipient_3[] = 'Secretary';
                        }
                        if ($row->president_3 == 1) {
                        $Recipient_3[] = 'President';
                        }
                        if ($row->treasurer_3 == 1) {
                        $Recipient_3[] = 'Treasurer';
                        }
                        if ($row->other_3 == 1) {
                        $Recipient_3[] = 'Other';
                        }
                        $Recipient_3 = array_unique($Recipient_3);
                        $row->Training_Recipient_3 = implode(',', $Recipient_3);
        }
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


        (string)$res->training_name_1,
        (string)$res->duration_1,
        (string)$res->date_training_1,
        (string)$res->name_1,
        (string)$res->Training_Recipient_1,

        (string)$res->training_name_2,
        (string)$res->duration_2,
        (string)$res->date_training_2,
        (string)$res->name_2,
        (string)$res->Training_Recipient_2,


        (string)$res->training_name_3,
        (string)$res->duration_3,
        (string)$res->date_training_3,
        (string)$res->name_3,
        (string)$res->Training_Recipient_3,






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
            'Name Of Federation',
            'Risk Rating',
            'NRLM Code ',
            'District Name',
            'State Name',
            'Agency Name',

            'Name of Training 1',
            'Duration in days 1',
            'Date 1',
            'Name of Trainer 1',
            'Name of Training Recipient 1',

            'Name of Training 2',
            'Duration in days 2',
            'Date 2',
            'Name of Trainer 2',
            'Name of Training Recipient 2',

            'Name of Training 3',
            'Duration in days 3',
            'Date 3',
            'Name of Trainer 3',
            'Name of Training Recipient 3'

            ]
        ];
    }

    public function title(): string
    {
        return 'Federation SAC Training';
    }


}
