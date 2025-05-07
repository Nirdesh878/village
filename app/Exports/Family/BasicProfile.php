<?php

namespace App\Exports\Family;

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


class BasicProfile implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $session_data = Session::get('family_export_session');
        // prd($session_data);

        $isClusterSelected = !empty($session_data['cluster']);

        $query = "SELECT

        f.id,
        f.uin,
        fp.fp_member_name AS `SHG_MEMBER_NAME`,
        sp.shgName AS `NAME_OF_SHG`,
        cp.name_of_cluster AS `CLUSTER_NAME`,
        fedp.name_of_federation AS `FEDERATION_NAME`,
        fp.fp_wealth_rank AS `WEALTH_POVERTY_RANKING`,
        fp.analysis_rating AS `RISK_RATING_SCORE_CARD`,
        fp.fp_gender AS `GENDER` ,
        fp.fp_age AS AGE ,
        d.education AS `Member_Education_Level`,
        fp.fp_state AS STATE,
        fp.fp_district AS DISTRICT,
        fp.fp_caste AS `CASTE_OF_MEMBER`,
        fp.fp_spouse_name AS `NAME_OF_SPOUSE`,
        fp.fp_female_headed AS `FEMALE_HEADED`,
        fp.fp_bank_account AS `BANK_ACCOUNT`,
        fp.fp_family_mambers_no AS `TOTAL_MEMBERS_PER_FAMILY`,
        fp.fp_total_children AS `NO_OF_CHILDREN`,
        fp.fp_others_no AS `OTHERS`,
        fp.non_school_children_no AS `NON_SCHOOL_CHILDREN`,
        fp.fp_children_no_in_primary_school AS PRIMARY_SCHOOL_GOING,
        fc.middle_school,
        fc.under_graduation,
        fc.post_graduation,
        fc.technical,
        fc.special_school,
        fc.Studied_home,
        fc.employed,
        fp.fp_children_no_in_secondary_higher AS High_school_going_children,
        fp.fp_children_no_in_secondary_higher AS fp_children_no_in_secondary_higher,
        fp.fp_children_no_in_college AS college_going_children,
        fp.studiedat_home AS studiet_at_home,
        fp.fp_family_mamber_over_60year AS fp_family_mamber_over_60year,
        fp.fp_family_mamber_medication AS diffrently_abled,
        fp.fp_vulnerable_people AS vulnerable,
        fp.fp_earning_an_income AS fp_earning_an_income ,
        fp.fp_family_migrated AS family_migration,
        fp.fp_family_reason_of_migration AS fp_family_reason_of_migration,
        fp.aNutritionMortality as aNutritionMortality,
        fp.aNutritionMortalityMale AS aNutritionMortalityMale,
        fp.aNutritionMortalityFeMale AS aNutritionMortalityFeMale,
        fp.bNutritionMortality as bNutritionMortality,
        fp.bNutritionMortalityMale AS bNutritionMortalityMale ,
        fp.bNutritionMortalityFeMale AS bNutritionMortalityFeMale ,
        fp.cNutritionMortality as cNutritionMortality,
        fp.cNutritionMortalityMale AS cNutritionMortalityMale,
        fp.cNutritionMortalityFeMale AS cNutritionMortalityFeMale,
        fp.sanitation AS sanitation,
        fp.sElectricity AS sElectricity ,
        fp.sDrinkingWater AS sDrinkingWater,
        fp.sCookingFuel AS sCookingFuel,
        fp.sHealthIssues as sHealthIssues,
        fp.sHealthIssuesMale AS sHealthIssuesMale ,
        fp.sHealthIssuesFeMale AS sHealthIssuesFeMale,
        fp.gov_liveilhood_program AS gov_liveilhood_program,
        fg.program_name AS program
     FROM
        family_mst AS f 
        INNER JOIN family_profile AS fp ON f.id = fp.family_sub_mst_id
        INNER JOIN shg_mst AS s ON f.shg_uin = s.uin
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
            LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
            INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
          INNER JOIN federation_profile AS fedp
          ON fed.id = fedp.federation_sub_mst_id
        LEFT JOIN family_member_information AS fm ON f.id = fm.family_sub_mst_id
        LEFT JOIN (SELECT * FROM family_member_information WHERE relation = 'self') AS d
            ON d.family_sub_mst_id = f.id
        LEFT JOIN (
            SELECT GROUP_CONCAT(program_name) AS program_name, family_sub_mst_id
            FROM family_gov_liveilhood_program GROUP BY family_sub_mst_id
        ) AS fg ON f.id = fg.family_sub_mst_id
        LEFT JOIN (
            SELECT family_sub_mst_id,
                SUM(CASE WHEN education = 'middle school' THEN 1 ELSE 0 END) AS middle_school,
                SUM(CASE WHEN education = 'under graduation (ug)' THEN 1 ELSE 0 END) AS under_graduation,
                SUM(CASE WHEN education = 'post graduation (pg)' THEN 1 ELSE 0 END) AS post_graduation,
                SUM(CASE WHEN education = 'technical/higher education (engineering/medicine/ph.d/other higher education)' THEN 1 ELSE 0 END) AS technical,
                SUM(CASE WHEN education = 'special school' THEN 1 ELSE 0 END) AS special_school,
                SUM(CASE WHEN education = 'studied and at home' THEN 1 ELSE 0 END) AS Studied_home,
                SUM(CASE WHEN education = 'employed' THEN 1 ELSE 0 END) AS employed
            FROM family_member_information
            GROUP BY family_sub_mst_id
        ) AS fc ON fc.family_sub_mst_id = f.id
        WHERE s.is_deleted = 0 AND f.is_deleted = 0 ";

        if ($isClusterSelected) {
            $query .= " AND c.is_deleted = 0 ";
        }

        if (!empty($session_data['Search'])) {
            if (!empty($session_data['agency'])) {
                $agency = $session_data['agency'];
                $query .= " AND f.agency_id = $agency  ";
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
            if (!empty($session_data['family'])) {
                $query .= " AND f.uin = '" . $session_data['family'] . "' ";
            }
        }

        $query .= "  GROUP BY f.id
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
            $res->SHG_MEMBER_NAME,
            $res->NAME_OF_SHG,
            $res->CLUSTER_NAME,
            $res->FEDERATION_NAME,
            $res->WEALTH_POVERTY_RANKING,
            $res->RISK_RATING_SCORE_CARD,
            $res->GENDER,
            $res->AGE,
            $res->Member_Education_Level,
            $res->STATE,
            $res->DISTRICT,
            $res->CASTE_OF_MEMBER,
            $res->NAME_OF_SPOUSE,
            $res->FEMALE_HEADED,
            $res->BANK_ACCOUNT,
            $res->TOTAL_MEMBERS_PER_FAMILY,
            $res->NO_OF_CHILDREN,
            $res->OTHERS,
            $res->NON_SCHOOL_CHILDREN,
            $res->PRIMARY_SCHOOL_GOING,
            $res->middle_school,
            $res->High_school_going_children,
            $res->fp_children_no_in_secondary_higher,
            $res->under_graduation,
            $res->post_graduation,
            $res->technical,
            $res->special_school,
            $res->employed,
            $res->studiet_at_home,
            $res->fp_family_mamber_over_60year,
            $res->diffrently_abled,
            $res->vulnerable,
            $res->fp_earning_an_income,
            $res->family_migration,
            $res->fp_family_reason_of_migration,
            $res->aNutritionMortality,
            $res->aNutritionMortalityMale,
            $res->aNutritionMortalityFeMale,
            $res->bNutritionMortality,
            $res->bNutritionMortalityMale,
            $res->bNutritionMortalityFeMale,
            $res->cNutritionMortality,
            $res->cNutritionMortalityMale,
            $res->cNutritionMortalityFeMale,
            $res->sanitation,
            $res->sElectricity,
            $res->sDrinkingWater,
            $res->sCookingFuel,
            $res->sHealthIssues,
            $res->sHealthIssuesMale,
            $res->sHealthIssuesFeMale,
            $res->gov_liveilhood_program,
            $res->program,




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
                $event->sheet->getStyle('A1:BC1')->applyFromArray([
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
                'SHG MEMBER NAME',
                'NAME OF SHG',
                'CLUSTER NAME ',
                'FEDERATION NAME',
                'WEALTH/POVERTY RANKING',
                'RISK RATING/SCORE CARD',
                'GENDER',
                'AGE',
                'Member Education Level',
                'STATE',
                'DISTRICT',
                'CASTE OF MEMBER',
                'NAME OF SPOUSE',
                'FEMALE HEADED ',
                'BANK ACCOUNT',
                'TOTAL MEMBERS PER FAMILY',
                'NO. OF CHILDREN',
                'OTHERS',
                'NON- SCHOOL CHILDREN ',
                'PRIMARY SCHOOL GOING',
                'Middle School',
                'HIGH SCHOOL GOING',
                'Hr. Secondary School',
                'Under Graduation (UG)',
                'Post Graduation (PG)',
                'Technical/Higher Education',
                'Special School',
                'EMPLOYED CHILDREN',
                'STUDIED & AT HOME',
                'Family Member Over 60year',
                'DIFFERENTLY ABLED members',
                'VULNERABLE members',
                'TOTAL MEMEBRS EARNING INCOME',
                'FAMILY MIGRATION (Yes or No)',
                'REASON FOR MIGRATION (IF MIATED)',
                'FAMILY MEMEBERS HAVE ACCESS TO ALL THREE MEALS ON DAILY BASIS',
                'FAMILY MEMEBRS HAVE ACCESS TO ALL THREE MEALS ON DAILY BASIS - Male ',
                'FAMILY MEMEBRS HAVE ACCESS TO ALL THREE MEALS ON DAILY BASIS - Female ',
                'MEMBER WHO SUFFER DUE TO MALNUTRITION',
                'MEMBER WHO SUFFFER DUE TO MALNUTRITION - male ',
                'MEMBER WHO SUFFFER DUE TO MALNUTRITION - Female ',
                'CHILDREN UNDERNOURISEHD',
                'CHILDREN /ADULTS UNDERNOURISEHD - Male ',
                'CHILDREN /ADULTS UNDERNOURISEHD - Female ',
                'SANITATION',
                'ELECTRICITY',
                'DRINKING WATER',
                'COOKING FUEL',
                'HEALTH ISSUES PAST 2 YEARS',
                'HEALTH ISSUES PAST 2 YEARS - male ',
                'HEALTH ISSUES PAST 2 YEARS - Female',
                'AWARE OF GOVT LIVELIHOOD PROGRAM (yes or no) ',
                'AWARE OF GOVT LIVELIHOOD PROGRAMS '

            ]
        ];
    }

    public function title(): string
    {
        return 'Family Basic Profile';
    }
}
