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


class SHGGovernance implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        s.uin AS uin ,
        sp.shgName AS shg_name,
        sp.analysis_rating AS risk_rating,
        sp.shg_code AS NRLM_code,
        cp.name_of_cluster AS cluster_name,
        fedp.name_of_federation AS federation_name,
        sp.village AS village,
        sg.adoption_rules AS `Adoption_of_Rules`,
        sg.written_norms  AS `If_Yes_Wriiten_Rules`,
        sg.adoption_date  AS `If_Yes_Date_of_adoption`,
        sg.election_frequency AS `Details_on_Election_frequency_in_year`,
        sg.first_election_date AS `Details_on_Election_1st_Election_date`,
        sg.no_of_election_conducted AS `Details_on_Election_No_conducted_so_far`,
        sg.last_election_date AS `Details_on_Election_Date_of_Last_Election`,
        sg.meetings_frequency_spinner AS `Frequency_of_meetings_on_monthly_basis`,
        sg.no_of_meeting_conducted AS `No_of_meetings_in_last_12_months`,
        sg.average_participation AS `Avg_Participation_of_members_in_12months`,
        sg.meetings_recorded AS `Minutes_of_Group_meetings_recorded_last_12months`,
        sg.who_writes_minutes AS `Who_writes_the_minutes`,
        sg.how_book_updated AS `Updating_of_Books_of_accounts_How_often_updated`,
        sg.date_last_update_book AS `Updating_of_Books_of_accounts_Date_of_last_update`,
        sg.shg_updated_status AS `Updating_of_Books_of_accounts_updated_status`,
        sg.passbook_updated  AS `Bank_accounts_in_regular_operation_last_12months`,
        sg.grading AS `Grading_obtained_last_12months`,
        sg.internal_audit  AS `Internal_audit_conducted`,
        sg.internal_audit_date  AS `If_Yes_Last_Internal_audit_date`,
        sg.external_audit   AS `External_Audit_conducted`,
        sg.external_audit_date  AS `Last_External_audit_date`

     FROM
        shg_mst AS s 
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN shg_governance AS sg
        ON sg.shg_sub_mst_id = s.id
        WHERE s.is_deleted = 0";

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

        $query .= "  GROUP BY s.id
         ";
        // prd($query);
        $familys = DB::select($query);
        // prd($familys);
        return collect($familys);
    }

    public function map($res): array
    {


        return [
            $this->counter++,
            $res->uin,
            $res->shg_name,
            $res->risk_rating,
            $res->NRLM_code,
            $res->cluster_name,
            $res->federation_name,
            $res->village,
            $res->Adoption_of_Rules,
            $res->If_Yes_Wriiten_Rules,
            $res->If_Yes_Date_of_adoption,
            $res->Details_on_Election_frequency_in_year,
            $res->Details_on_Election_1st_Election_date,
            $res->Details_on_Election_No_conducted_so_far,
            $res->Details_on_Election_Date_of_Last_Election,
            $res->Frequency_of_meetings_on_monthly_basis,
            $res->No_of_meetings_in_last_12_months,
            $res->Avg_Participation_of_members_in_12months,
            $res->Minutes_of_Group_meetings_recorded_last_12months,
            $res->Who_writes_the_minutes,
            $res->Updating_of_Books_of_accounts_How_often_updated,
            $res->Updating_of_Books_of_accounts_Date_of_last_update,
            $res->Updating_of_Books_of_accounts_updated_status,
            $res->Bank_accounts_in_regular_operation_last_12months,
            $res->Grading_obtained_last_12months,
            $res->Internal_audit_conducted,
            $res->If_Yes_Last_Internal_audit_date,
            $res->External_Audit_conducted,
            $res->Last_External_audit_date
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
                $event->sheet->getStyle('A1:AC1')->applyFromArray([
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
                'Name Of Village',
                'Adoption Of Rules',
                'If Yes, Wriiten Rules',
                'If Yes, Date Of Adoption',
                'Details On Election - frequency In Year',
                'Details On Election- 1st Election Date',
                'Details On Election- No. Conducted So Far',
                'Details On Election- Date Of Last Election',
                'Frequency Of Meetings On Monthly Basis',
                'No. Of Meetings In Last 12 Months',
                'Avg Participation Of Members In 12 Months',
                'Minutes Of Group Meetings Recorded Last 12 Months',
                'Who Writes The Minutes?',
                'Updating Of Books Of Accounts - How Often Updated?',
                'Updating Of Books Of Accounts -  Date Of Last Update',
                'Updating Of Books Of Accounts - Updated Status',
                'Are Bank Accounts In Regular Operation Last 12 Months',
                'Grading Obtained Last 12 Months',
                'Internal Audit Conducted',
                'If Yes, Last Internal Audit Date',
                'External Audit Conducted',
                'Last External Audit Date'
            ]
        ];
    }

    public function title(): string
    {
        return 'SHG Governance';
    }
}
