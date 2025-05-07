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


class ClusterGovernance implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        clg.*,
        clp.*,
        cl.uin,
        ag.agency_name,
        fedp.name_of_federation,
        GROUP_CONCAT(CONCAT_WS(',', clg.function_sac_a, clg.function_sac_b, clg.function_sac_c, clg.function_sac_d)) AS functions_of_sac,

        -- Extract  names
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[0].name')) AS name_1,
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[1].name')) AS name_2,
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[2].name')) AS name_3,

        -- Extract purpose
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[0].purpose')) AS purpose_1,
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[1].purpose')) AS purpose_2,
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[2].purpose')) AS purpose_3,

        -- Extract training dates
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[0].date_formed')) AS date_formed_1,
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[1].date_formed')) AS date_formed_2,
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[2].date_formed')) AS date_formed_3,

        -- Extract training dates
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[0].members')) AS members_1,
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[1].members')) AS members_2,
        JSON_UNQUOTE(JSON_EXTRACT(REPLACE(clg.Cluster_Subcommittee_object, '\\\\', ''), '$[2].members')) AS members_3

     FROM
         cluster_mst AS cl
          INNER JOIN cluster_profile AS clp
          ON cl.id = clp.cluster_sub_mst_id
          INNER JOIN federation_mst as fed
          on fed.uin = cl.federation_uin
          INNER JOIN cluster_governance as clg
          on cl.id = clg.cluster_sub_mst_id
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


        $query .=" group by cl.id  ";
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

        (string)$res->adoption_of_rules,
        (string)$res->written_norms,
        (string)$res->date_adoption,
        (string)$res->frequency_per_norms,
        (string)$res->first_election_date,
        (string)$res->elections_conducted,
        (string)$res->date_last_election,
        (string)$res->last_two_election_conducted,
        (string)$res->frequency_of_meetings,
        (string)$res->meetings_cluster_conducted,
        (string)$res->participation_members,
        (string)$res->minute_book_to_record_minute,
        (string)$res->meetings_recorded,
        (string)$res->who_writes_minutes,
        (string)$res->books_updated,
        (string)$res->date_last_updated,
        (string)$res->updated_status,
        (string)$res->accounts_regular,
        (string)$res->grading_cluster,
        (string)$res->social_audit_committee,
        (string)$res->sac_created,
        (string)$res->functions_of_sac,
        (string)$res->sac_reports_submitted,
        (string)$res->date_last_report,
        (string)$res->internal_audit,
        (string)$res->internal_how_often,
        (string)$res->date_last_audit_conducted,
        (string)$res->internal_observations_raised,
        (string)$res->internal_issues_resolved,
        (string)$res->issues_highlighted_by_internal_audit_other,
        (string)$res->external_audit,
        (string)$res->external_how_often,
        (string)$res->date_last_audit_conducted,
        (string)$res->external_observations_raised,
        (string)$res->external_issues_resolved,
        (string)$res->issues_highlighted_external_audit_other,



        (string)$res->total_shgs_formed,
        (string)$res->shgs_defunct,
        (string)$res->defunct_shgs_par,
        (string)$res->defunct_shgs_reasons,

        (string)$res->cluster_sub_committees,

        (string)$res->name_1,
        (string)$res->purpose_1,
        (string)$res->date_formed_1,
        (string)$res->members_1,

        (string)$res->name_2,
        (string)$res->purpose_2,
        (string)$res->date_formed_2,
        (string)$res->members_2,

        (string)$res->name_3,
        (string)$res->purpose_3,
        (string)$res->date_formed_3,
        (string)$res->members_3,







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
                $event->sheet->getStyle('A1:BJ1')->applyFromArray([
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


            'Adoption of Rules (yes or No)',
            'If Yes, Wriiten Rules - Yes or No',
            'If Yes, Date of adoption',

            'Details on Election - frequency ',
            '1st election Date',
            'No. of elections conducted so far',
            'Date of Last Election',
            'Last two elections conducted as per norms (Yes/no)',

            'Frequency of meetings on a monthly basis',
            'No. of meetings in last 12 months ',
            'Avg monthly Participation of board members in 12 months ',

            'Do thye have a separate minute book to record minutes? (Yes or No)',
            'if yes - Minutes of Group meetings recorded ',
            'Who writes the minutes?',

            'Updating of Books of accounts - How often updated?',
            'Updating of Books of accounts -  Date of last update',
            'Updating of Books of accounts - updated status',

            'Are Bank accounts in regular operation last 12 months ( yes or no)',

            'Grading obtained last 12 months ',

            'Does Cluster have a social audit committee?(Yes or No)',
            'If yes - when was SAC created',
            'Function of SAC ',
            'How many SAC reports prepared & Submitted in last 12 months',
            'Date of Last Report',

            'Internal audit conducted  - yes/ no/NA',
            'If yes, How often?',
            'If Yes, Last Internal audit date ',
            'Issues & observations raised',
            'How many issues described were relsoved in the last year',
            'Describe',

            'External Audit conducted - Yes/ No/NA',
            'If yes, How often?',
            'If Yes, Last External audit date ',
            'Issues & observations raised - External audit',
            'How many issues described were relsoved in the last year? - External Audit',
            'Describe (for External audit)',



            'Defunct SHG status - Total SHGs formed in the cluster',
            'At present no of SHGs defunct',
            'Defunct SHG %',
            'Reasons for Defunct',

            'Are there any Cluster Sub-committees? ',

            'Sub-comittee Name 1',
            'Comittee Purpose 1',
            'Subcomittee Date 1',
            'Subcomittee memebrs 1',

            'Sub-comittee Name 2',
            'Comittee Purpose 2',
            'Subcomittee Date 2',
            'Subcomittee memebrs 2',

            'Sub-comittee Name 3',
            'Comittee Purpose 3',
            'Subcomittee Date 3',
            'Subcomittee memebrs 3',

            ]
        ];
    }

    public function title(): string
    {
        return 'Cluster Governance';
    }
}
