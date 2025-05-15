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


class Assets implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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

        $isClusterSelected = !empty($session_data['cluster']);

        $query = "SELECT
        f.id,
        f.uin AS UIN,
        fp.fp_member_name AS Family_Name,
        sp.shgName AS Shg_name,
        cp.name_of_cluster AS Cluster_Name,
        fedp.name_of_federation AS Fedeartion_Name,
        fp.fp_wealth_rank AS Wealth_Rank,
        fp.analysis_rating AS RISK_RATING_SCORECARD,
        fa_land_type AS land_type,
        fa.fa_land_cultivated AS LAND_CULTIVATED_BY_FAMILY ,
        fa.fa_mortagged_how_much_land AS LAND_MORTGAGED_OR_LOST_TO_MONEY_LENDER,
        fa.house_ownership AS House_ownership,
         fa.fa_Pacca_Kaccha_house AS Type_of_house,
         fa.fa_animalsheds,
         fal.cow ,
         fal.Buffalo,
         fal.Goat,
         fal.Sheep,
         fal.Poultry ,
         fal.Pig ,
         fav.bicycles ,
         fav.motorcycle ,
         fam.flour_mills,
         fam.rice_mills,
         fam.Tractors,
         (CASE WHEN fah.refrigerator =1 THEN 'Yes' WHEN fah.refrigerator =0 THEN 'No' END ) AS Refrigerator,
         (CASE WHEN fah.fa_airconditioners =1 THEN 'Yes' WHEN fah.fa_airconditioners =0 THEN 'No' END ) AS Air_conditioners,
         (CASE WHEN fah.fa_smartphone =1 THEN 'Yes' WHEN fah.fa_smartphone =0 THEN 'No' END ) AS Smart_phone,
         (CASE WHEN fah.computer =1 THEN 'Yes' WHEN fah.computer =0 THEN 'No' END ) AS computer,
         (CASE WHEN fah.fa_tvcolor =1 THEN 'Yes' WHEN fah.fa_tvcolor =0 THEN 'No' END ) AS Color_tv,
         (CASE WHEN fah.fa_other =1 THEN fa_other_choice ELSE 'No' END ) AS Gadgets_Others ,
         fa.fa_jewelry_yes_no AS FAMILY_OWN_ANY_JEWELLERY,
         fa.jewelry_pawned_take_loan_yesno AS JEWELLERY_PAWNED_TO_TAKE_LOAN,
         fa.jewelry_pawned_lander_type AS JELEWELRY_LOAN_LENDER_TYPE ,
         fa.jewelry_pawned_loan_amount AS JEWELERY_LOAN_AMOUNT,
         fa.jewelry_pawned_loan_when AS JEWELERY_LOAN_DATE,
         fa.jewelry_pawned_loan_interest AS JEWELERY_LOAN_INTREST,
         fa.jewelry_pawned_lost_yesno AS PAWNED_JEWELERY_TO_TAKE_LOAN_LOST,
         fa.jewelry_pawned_lander_lost_type AS JEWELRY_PAWNED_LOST_LENDER_TYPE,
         fa.jewelry_pawned_loan_lost_amount AS JEWELERY_PAWNED_LOST_AMOUNT,
         fa.jewelry_pawned_loan_lost_when AS  JEWELERY_PAWNED_LOST_DATE,
         fa.jewelry_pawned_loan_lost_interest AS  JEWELERY_PAWNED_LOST_INTREST,
         fa.fa_other_assets_A AS any_other_assets,
         fa.fa_other_assets_B AS has_family_sold_labour,
         fa.fa_other_assets_C AS purpose ,
         fa.fa_other_assets_D AS labour_days

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
        INNER JOIN family_assets AS fa
        ON f.id = fa.family_sub_mst_id
        INNER JOIN family_assets_gadgets AS fah
        ON f.id = fah.family_sub_mst_id
        LEFT JOIN (SELECT SUM(CASE WHEN animal_Types = 'Cow' THEN no_of_animals ELSE 0 END ) AS cow,
                     SUM(CASE WHEN animal_Types = 'Buffalo' THEN no_of_animals ELSE 0 END ) AS Buffalo,
                     SUM(CASE WHEN animal_Types = 'Goat' THEN no_of_animals ELSE 0 END ) AS Goat,
                     SUM(CASE WHEN animal_Types = 'Sheep' THEN no_of_animals ELSE 0 END ) AS Sheep,
                         SUM(CASE WHEN animal_Types = 'Poultry' THEN no_of_animals ELSE 0 END ) AS Poultry,
                         SUM(CASE WHEN animal_Types = 'Pig' THEN no_of_animals ELSE 0 END ) AS Pig,
          family_sub_mst_id FROM family_assets_live_stock GROUP BY family_sub_mst_id) fal
          ON f.id = fal.family_sub_mst_id
          LEFT JOIN (SELECT SUM(CASE WHEN vehicle_Types = 'bicycles' THEN no_of_vehicle ELSE 0 END ) AS bicycles,
                            SUM(CASE WHEN vehicle_Types = 'motorcycle' OR vehicle_Types = 'bike' THEN no_of_vehicle ELSE 0 END ) AS motorcycle

          ,family_sub_mst_id FROM family_assets_vehicle GROUP BY family_sub_mst_id) fav
          ON f.id = fav.family_sub_mst_id
          LEFT JOIN (SELECT SUM(CASE WHEN machinery_Types = 'flour mills' OR machinery_Types = 'flour mill' THEN no_of_machinery ELSE 0 END ) AS flour_mills,
                            SUM(CASE WHEN machinery_Types = 'rice mills'  THEN no_of_machinery ELSE 0 END ) AS rice_mills,
                            SUM(CASE WHEN machinery_Types = 'Tractors'  THEN no_of_machinery ELSE 0 END ) AS Tractors
          ,family_sub_mst_id FROM family_assets_machinery GROUP BY family_sub_mst_id) fam
          ON f.id = fam.family_sub_mst_id
          WHERE  s.is_deleted = 0 AND f.is_deleted = 0";

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

        $WealthData = getMstCommonData(7,$res->Wealth_Rank);
        $wealthName = $WealthData->isNotEmpty() ? $WealthData[0]->common_values : 'N/A';
        // prd($wealthName);

        return [
            $this->counter++,
            $res->UIN,
            $res->Family_Name,
            $res->Shg_name,
            $res->Cluster_Name,
            $res->Fedeartion_Name,
            $wealthName,
            $res->RISK_RATING_SCORECARD,
            $res->land_type,
            $res->LAND_CULTIVATED_BY_FAMILY,
            $res->LAND_MORTGAGED_OR_LOST_TO_MONEY_LENDER,
            $res->House_ownership,
            $res->Type_of_house,
            $res->fa_animalsheds,
            $res->cow,
            $res->Buffalo,
            $res->Goat,
            $res->Sheep,
            $res->Poultry,
            $res->Pig,
            $res->bicycles,
            $res->motorcycle,
            $res->flour_mills,
            $res->rice_mills,
            $res->Tractors,
            $res->Refrigerator,
            $res->Air_conditioners,
            $res->Smart_phone,
            $res->computer,
            $res->Color_tv,
            $res->Gadgets_Others,
            $res->FAMILY_OWN_ANY_JEWELLERY,
            $res->JEWELLERY_PAWNED_TO_TAKE_LOAN,
            $res->JELEWELRY_LOAN_LENDER_TYPE,
            $res->JEWELERY_LOAN_AMOUNT,
            $res->JEWELERY_LOAN_DATE,
            $res->JEWELERY_LOAN_INTREST,
            $res->PAWNED_JEWELERY_TO_TAKE_LOAN_LOST,
            $res->JEWELRY_PAWNED_LOST_LENDER_TYPE,
            $res->JEWELERY_PAWNED_LOST_AMOUNT,
            $res->JEWELERY_PAWNED_LOST_DATE,
            $res->JEWELERY_PAWNED_LOST_INTREST,
            $res->any_other_assets,
            $res->has_family_sold_labour,
            $res->purpose,
            $res->labour_days,

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
                $event->sheet->getStyle('A1:AT1')->applyFromArray([
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
                'LAND SIZE (Units)',
                'Total Land Owned and Cultivated',
                'LAND MORTGAGED OR LOST TO MONEY LENDER (how much land)',
                'HOUSE OWNERSHIP',
                'TYPE OF HOUSE',
                'ANIMALSHEDS',
                'LIVESTOCK- Number OF COWS',
                'LIVESTOCK- Number OF BUFFALOS',
                'LIVESTOCK- Number OF GOATS',
                'LIVESTOCK- Number OF SHEEPS',
                'LIVESTOCK- Number OF POULTRY',
                'LIVESTOCK- Number OF PIGS',
                'VEHICLES - Number OF BICYCLES',
                'VEHICLES - Number OF MOTORCYCLES',
                'MACHINERY/ EQUIPMENT - Number of FLOURMILLS',
                'MACHINERY/ EQUIPMENT - Number OF RICEMILLS',
                'MACHINERY/ EQUIPMENT - Number OF TRACTORS',
                'HOME GADGETS - REFRIGERATOR',
                'HOME GADGETS - AIR CONDITIONING',
                'HOME GADGETS - SMART PHONE',
                'HOME GADETS - COMPUTER ',
                'HOME GADGETS - COLOR TV ',
                'HOME GADGETS -OTHERS ',
                'FAMILY OWN ANY JEWELLERY (YES OR NO)',
                'JEWELLERY PAWNED TO TAKE LOAN ( YES OR NO)',
                'JELEWELRY LOAN - LENDER TYPE ',
                'JEWELERY LOAN - AMOUNT ',
                'Jewellery Loan Date ',
                'Lewellery Loan - Interest %',
                'JEWELERY TO TAKE LOAN LOST ( YES OR NO)',
                'JEWELRY LOST - LENDER TYPE ',
                'JEWELERY  LOST - AMOUNT ',
                'Jewelery  lost - Date',
                'Jewelery  lost - Interest rate',
                'Any other Asset ?',
                'Has Family sold Labour (2 years) - Yes or No ',
                'Purpose',
                'No. of Labour days sold/advanced'
            ]
        ];
    }

    public function title(): string
    {
        return 'Family Assets';
    }
}
