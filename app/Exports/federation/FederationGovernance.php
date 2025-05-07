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


class FederationGovernance implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        // prd($session_data);

        $query = "SELECT
        fedg.id,
        fed.uin AS uin,
        fedp.name_of_federation AS federation_name,
        fedp.analysis_rating AS risk_rating,
        fedp.clf_code AS NRLM_code,
        fedp.name_of_district AS district_name,
        fedp.name_of_state AS state_name,
        ag.agency_name AS agency_name,
        fedg.*
     FROM
         federation_mst AS fed
          INNER JOIN federation_profile AS fedp
          ON fed.id = fedp.federation_sub_mst_id
          INNER JOIN agency AS ag
          ON fed.agency_id = ag.agency_id
          INNER JOIN federation_governance AS fedg
          ON fed.id = fedg.federation_sub_mst_id

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

         $query .="  GROUP BY fedg.id
         ";
        // prd($query);
        $federation = DB::select($query);
        //  prd($federation);

        foreach($federation as $result){
            $list_internal = [
                $result->internal_misappropriation_of_fund == 1 ? 'Misappropriation of fund' : '',
                $result->internal_not_updation_of_books == 1 ? 'Not Updation of books of accounts' : '',
                $result->internal_utilization == 1 ? 'Deviation of utilisation of loan' : '',
                $result->internal_non_adherance == 1 ? 'Non adherence of norms' : '',
                $result->internal_others == 1 ? 'Other-'.$result->Issues_highlighted_by_internal_audit_other : '',
            ];

            // Remove empty values
            $list_internal = array_filter($list_internal);

            // Join non-empty values with commas
            $result->list_of_issue_internal = implode(',', $list_internal);

            $list_external = [
                $result->external_misappropriation_of_fund == 1 ? 'Misappropriation of fund' : '',
                $result->external_not_updation_of_books == 1 ? 'Not Updation of books of accounts' : '',
                $result->external_utilization == 1 ? 'Deviation of utilisation of loan' : '',
                $result->external_non_adherance == 1 ? 'Non adherence of norms' : '',
                $result->external_others == 1 ? 'Other-'.$result->issues_highlighted_external_audit_other : '',
            ];

              // Remove empty values
              $list_external = array_filter($list_external);
            //   pr($list_external);
              // Join non-empty values with commas
              $result->list_of_issue_external = implode(',', $list_external);
        }
        // prd("ddd");
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

        (string)$res->adoption_of_rules,
        (string)$res->written_norms,
        (string)$res->date_of_adoption,
        (string)$res->frequency_as_per_norms,
        (string)$res->first_election_date,
        (string)$res->no_of_elections_conducted_so_far,
        (string)$res->date_of_last_election_option,
        (string)$res->last_two_election_conducted,
        (string)$res->last_two_election_conducted_2nd,
        (string)$res->last_two_election_conducted_3rd,
        (string)$res->frequency_of_meetings_on_a_monthly_basis,
        (string)$res->meetings_federation_last_six_months,
        (string)$res->participation_members_last_six_months,
        (string)$res->Total_board_members,
        (string)$res->minutes_of_group_meetings_recorded,
        (string)$res->who_writes_the_minutes,
        (string)$res->general_assembly,
        (string)$res->frequency_assembly_meetings,
        (string)$res->number_of_GA_members,
        (string)$res->date_of_last_metting,
        (string)$res->budget_approval_by_general_assembly,
        (string)$res->date_of_last_budget_and_annual_approval,
        (string)$res->Annual_plan_Financial_specify,
        (string)$res->Annual_plan_Livelihood_specify,
        (string)$res->Annual_plan_Social_specify,
        (string)$res->Annual_plan_Convergence_specify,
        (string)$res->Annual_plan_Others_specify,
        (string)$res->member_aware,
        (string)$res->how_often_are_books_updated,
        (string)$res->date_of_last_updated_books,
        (string)$res->updated_status,
        (string)$res->issues_highlighted_external_audit,
        (string)$res->federation_social_audit_committee,
        (string)$res->when_was_the_SAC_created,
        (string)$res->SAC_functioned,
        (string)$res->date_last_report_submitted,
        (string)$res->issues_highlighted1,
        (string)$res->issues_highlighted2,
        (string)$res->issues_highlighted3,
        (string)$res->issues_highlighted4,
        (string)$res->issues_highlighted5,
        (string)$res->any_other_committee_formed,
        (string)$res->please_mention_names_of_committee,
        (string)$res->please_mention_names_of_committee2,
        (string)$res->please_mention_names_of_committee3,
        (string)$res->internal_audit,
        (string)$res->frequency_internal_audit_conducted,
        (string)$res->date_of_last_internal_audit,
        (string)$res->Issues_highlighted_by_internal_audit,
        (string)$res->list_of_issue_internal,
        (string)$res->Highlighted_issues_addressed,

        (string)$res->external_audit,
        (string)$res->date_external_audit_conducted,
        (string)$res->issues_highlighted_external_audit,
        (string)$res->list_of_issue_external,
        (string)$res->issues_highlighted_resolved,
        (string)$res->Total_SHGs_formed,
        (string)$res->present_no_of_SHGs_defunct,
        (string)$res->Defunct_SHGs,
        (string)$res->Defunct_SHGs_reasons

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
                $event->sheet->getStyle('A1:BP1')->applyFromArray([
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
            'Name of Federation',
            'Risk Rating',
            'NRLM Code ',
            'District Name',
            'State Name',
            'Agency Name',
            'Adoption Of Rules',
            'If Yes, Wriiten Rules',
            'If Yes, Date Of Adoption',
            'Details On Election - frequency In Year',
            'Details On Election- 1st Election Date',
            'Details On Election- No. Conducted So Far',
            'Details On Election- Date Of Last Election',
            'Last 3 Elections conducted as per Norms- 1st Elelection',
            'Last 3 Elections conducted as per Norms- 2nd Elelection',
            'Last 3 Elections conducted as per Norms- 3rd Elelection',
            'Frequency Of Meetings On Monthly Basis',
            'No. Of Meetings In Last 12 Months',
            'Avg Participation Of Board members/EC In 12 Months',
            'total No of Board/EC members',
            'Minutes Of Board/EC Meetings Recorded Written Last 12 Months',
            'Who Writes The Minutes?',
            'General Assembly (GA) Meeting (yes/No)',
            'Frequency of GA meetings',
            'No of GA/GB hconducted during last 12 months',
            'Date of last GA/GB meeting',
            'Has Annual Plan and budget for last FY approved by GA/GB',
            'Date of last budget and annual plan proved',
            'Achievement of last year Annual Plan- Financial',
            'Achievement of last year Annual Plan- Livelihood',
            'Achievement of last year Annual Plan-  Social',
            'Achievement of last year Annual Plan-  Convergence',
            'Achievement of last year Annual Plan-  Others',
            'Are members aware of this achievement?',
            'Updating Of Books Of Accounts - How Often Updated?',
            'Updating Of Books Of Accounts -  Date Of Last Update',
            'Updating Of Books Of Accounts - Updated Status',
            'Are Bank Accounts In Regular Operation Last 12 Months',
            'Social Audit Committee in Operation Y/N',
            'Date of SAC formation',
            'Whether SAC functioned during last 12 months',
            'Date of last report submitted by SAC to GA/GB',
            'Issues highlighted by SAC-1st',
            'Issues highlighted by SAC-2nd',
            'Issues highlighted by SAC-3rd',
            'Issues highlighted by SAC-4th',
            'Issues highlighted by SAC-5th',
            'Any other committees formed',
            'Name of committees-1st',
            'Name of committees-2nd',
            'Name of committees-3rd',
            'Internal Audit Conducted',
            'Frequency of Internal audit conducted during last 12 months',
            'If Yes, Last Internal Audit Date',
            'Issues highlighted by internal audit Y/N',
            'List issues highlighted by Internal audit',
            'No of highlighted issues resolved by Federation',

            'External Audit Conducted',
            'Last External Audit Date',
            'Issues highlighted by external audit Y/N',
            'List issues highlighted by External audit',
            'No of issues resolved by the federation',
            'Defunct SHG status in Federation-total Member SHG',
            'Current Defunct SHG',
            'Defunct SHG %',
            'Reasons for Defunct',

            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Governance';
    }
}
