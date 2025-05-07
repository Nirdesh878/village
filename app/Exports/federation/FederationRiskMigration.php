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


class FederationRiskMigration implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        fedp.id,
        fed.uin AS uin ,
        fedp.name_of_federation ,
        fedp.analysis_rating AS risk_rating,
        fedp.clf_code AS NRLM_code,
        fedp.name_of_district AS district_name,
        fedp.name_of_state AS state_name,
        ag.agency_name ,
        fedr.*,
        round((fedr.animal_insured_last_one_year * 100) /fedr.animal_purchased_during_last_one_year) as coverage_of_livilstock
     FROM
         federation_mst AS fed
          INNER JOIN federation_profile AS fedp
          ON fed.id = fedp.federation_sub_mst_id
          INNER JOIN agency AS ag
          ON fed.agency_id = ag.agency_id
          INNER JOIN federation_risk_mitigation AS fedr
          ON fedr.federation_sub_mst_id = fed.id
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


        // prd($query);
        $federation = DB::select($query);
        //  prd($federation);
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

        (string)$res->total_general_assembly_members,
        (string)$res->members_covered_under_life_insurance,
        (string)$res->par_covered_under_life_insurance,

        (string)$res->availed_members_covered_under_loan_insurance,
        (string)$res->par_availed_members_covered_under_loan_insurance,

        (string)$res->animal_purchased_during_last_one_year,
        (string)$res->animal_insured_last_one_year,
        (string)$res->coverage_of_livilstock,

        (string)$res->No_of_claim_received,
        (string)$res->Total_claim_amount_requested,
        (string)$res->No_of_person_claim_setteled,
        (string)$res->Total_claim_amount_setteled,
        (string)$res->settlement_claimed_insurance_no,
        (string)$res->settlement_claimed_insurance_per,

        (string)$res->death_claim_requested,
        (string)$res->Total_claim_amount_requested_animal_death,
        (string)$res->animal_claim_setteled,
        (string)$res->Total_claim_amount_setteled_for_animal_death,
        (string)$res->settlement_asset_insurance_no,
        (string)$res->settlement_asset_insurance_per

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
                $event->sheet->getStyle('A1:AB1')->applyFromArray([
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

            'Total Members in Federation',
            'Life Insurance Coveage for all members -No of members covered under life Insurance',
            'Coverage of Life Insurance for all members in %',

            'Life Insurance Coveage for active Borrowers-No of active borrowers covered under life Insurance',
            'Coverage of Life Insurance for active borrowers in %',

            'Asset insurance - no of asset/livestock purchased',
            'No of assets/livestock insured',
            'Coverage of asset insurance in %',

            'Benefits claimed under life Insurance -no of claims submitted',
            'Benefits claimed under life Insurance -claim amount requested',
            'No of claims settled',
            'Claim amount settled ',
            'Settlement done in Nos ',
            'Settlement done in %',

            'Benefits claimed under Livestock - no of animal dealths submitted during last 12 months',
            'Total amount of claim submitted during last 12 months',
            'Total no of claims settled during last 12 months',
            'Total claim amount settled for animal deaths during last 12 months',
            'settlement done in Nos-Assets',
            'Settlement done in % - assets'
            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Risk Migration';
    }
}
