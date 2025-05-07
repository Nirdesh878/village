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


class FederationObservations implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
{

    public $curdate = '';
    public $counter = 1;
    public function __construct()
    {
        $this->curdate = Carbon::now()->format('d-m-Y');
    }

    public function collection()
    {
        // prd("sustainability");
        $user = Auth::user();
        $session_data = Session::get('federation_export_session');
        // prd($session_data);

        $query = "SELECT
        fed.id,
        fed.uin AS uin ,
        fedp.name_of_federation ,
        fedp.analysis_rating AS risk_rating,
        fedp.clf_code AS NRLM_code,
        fedp.name_of_district AS district_name,
        fedp.name_of_state AS state_name,
        ag.agency_name ,


        fedo.*
     FROM
         federation_mst AS fed
          INNER JOIN federation_profile AS fedp
          ON fed.id = fedp.federation_sub_mst_id
          INNER JOIN agency AS ag
          ON fed.agency_id = ag.agency_id
          INNER JOIN federation_observation AS fedo
          ON fed.id = fedo.federation_sub_mst_id

          WHERE fed.is_deleted = 0";

          if(!empty($session_data['Search'])){
            if(!empty($session_data['agency'])){
                $agency = $session_data['agency'];
                $query .=" AND fed.agency_id = $agency  ";
             }
             if(!empty($session_data['federation'])){
                $query .=" AND fed.uin = '" . $session_data['federation'] . "' ";
             }

          }

          $federation = DB::select($query);
        //  prd($federation);
        $answer = [];
        foreach($federation as  $row){
            if ($row->federation_observation_secretary == 1) {
                $answer[] = 'Secretary';
                }
                if ($row->federation_observation_president == 1) {
                $answer[] = 'President';
                }
                if ($row->federation_observation_treasure == 1) {
                $answer[] = 'Treasurer';
                }
                if ($row->federation_observation_bookkeeper == 1) {
                $answer[] = 'Book-Keeper';
                }
                if ($row->federation_observation_sub_commit == 1) {
                    $answer[] = 'Sub-Commitee Members';
                }
                if ($row->federation_observation_other == 1) {
                    $answer[] = 'Other';
                }
                $answer = array_unique($answer);
                $row->answer = implode(',', $answer);


        }
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

        (string)$res->federationObservationMeeting,
        (string)$res->answer,
        (string)$res->federationObservationCarriedOut,
        (string)$res->federationObservationLeadersOnly,
        (string)$res->federationObservationNormsHave,

        (string)$res->federation_understand_benefits_of_being_part,

        (string)$res->federationObservationDefaults,
        (string)$res->federationObservationPractices,

        (string)$res->federationObservationProvidedThem,
        (string)$res->federation_observation_policy_explain,

        (string)$res->federationObservationDocuments,
        (string)$res->federation_observation_any_highlighted,
        (string)$res->federationObservationMinutesMeetings,
        (string)$res->federationObservationUpdatedRecords,
        (string)$res->federation_observation_leaders_office,

        (string)$res->federationObservationWork,
        (string)$res->federationObservationReportingSystem,
        (string)$res->federationObservationFederationSpecial,
        (string)$res->federationObservationClusterFederations,
        (string)$res->federationObserHighlightsA,
        (string)$res->federationObserHighlightsB,
        (string)$res->federationObserHighlightsC,
        (string)$res->federationObserHighlightsD,
        (string)$res->federationObserHighlightsE


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
                $event->sheet->getStyle('A1:AF1')->applyFromArray([
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


            'How many attended the meeting',
            'Who attended the meeting?',
            'Did federation leaders understand purpose of meeting?',
            'What was quality of discussion?',
            'Were federation leaders aware of their rules and norms?',

            'Do they understand benefits of being part of federation? Explain benefits',

            'Does this federation have innovative repayment practices?',
            'If yes, What are those practices?',

            'Does this federation have specific policies for inclusion - what is that policy for for most vulnerable memebrs?',
            'if yes, what are those policies',

            'Does this federation have a satisfactory/weak or very good system of reporting and updating documentation ',
            'Any highlights',
            'Who writes these books and minutes',
            'Are books of accounts managed by the bookkeeper only',
            'Any highlgihts',

            'what was your impression of social audit committee - does it work?',
            'Are office vearers if SAC aware of their roles',
            'Did you notice any unique features/practies-explain',
            'How does federation leaders manage and support their groups and Village Organizations',
            'Important highlights about this federation - Highlight 1',
            'Important highlights about this federation - Highlight 2',
            'Important highlights about this federation - Highlight 3',
            'Important highlights about this federation - Highlight 4',
            'Important highlights about this federation - Highlight 5'

            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Observation';
    }
}
