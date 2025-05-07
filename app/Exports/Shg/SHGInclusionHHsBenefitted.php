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


class SHGInclusionHHsBenefitted implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        // prd($session_data);

        $isClusterSelected = !empty($session_data['cluster']);

        $query = "SELECT
         s.id,
        s.uin AS uin ,
        sp.shgName AS shg_name,
        sp.analysis_rating AS Risk_Rating,
        sp.shg_code AS NRLM_code,
        cp.name_of_cluster AS cluster_name,
        fedp.name_of_federation AS federation_name,
        sp.village AS village,
        si.no_of_total_members_benefited_hhs AS `Total_HHs_Benefitted`,
        si.no_of_visual_poorest AS No_of_Poorest_and_Vulnerable_Members,
        si.no_of_visual_poor AS Number_of_Poor_members,
        si.no_of_visual_medium_poor AS Number_of_medium_poor,
        si.no_of_visual_rich AS Number_of_Rich,
        si.no_of_internal_poorest_recloan AS `Internal_loans_No_Of_HHs_benefitted_in_last_12_months_Very_Poor_category`,
        si.no_of_internal_poor_recloan AS `Internal_loans_No_Of_HHs_benefitted_in_last_12_months_Poor_category`,
        si.no_of_internal_medium_recloan AS `Internal_loans_No_Of_HHs_benefitted_in_last_12_months_Medium_category`,
        si.no_of_internal_rich_recloan AS `Internal_loans_No_Of_HHs_benefitted_in_last_12_months_Rich_category`,
        
        si.no_of_external_poorest_recloan AS `Federation_loans_No_Of_HHs_benefitted_in_last_12_months_Very_Poor_category`,
        si.no_of_external_poor_recloan AS `Federation_loans_No_Of_HHs_benefitted_in_last_12_months_Poor_category`,
        si.no_of_external_medium_recloan AS `Federation_loans_No_Of_HHs_benefitted_in_last_12_months_Medium_category`,
        si.no_of_external_rich_recloan AS `Federation_loans_No_Of_HHs_benefitted_in_last_12_months_Rich_category`,
        
        si.no_of_bank_external_poorest_recloan AS `Bank_loans_No_Of_HHs_benefitted_in_last_12_months_Very_Poor_category`,
        si.no_of_bank_external_poor_recloan AS `Bank_loans_No_Of_HHs_benefitted_in_last_12_months_Poor_category`,
        si.no_of_bank_external_medium_recloan AS `Bank_loans_No_Of_HHs_benefitted_in_last_12_months_Medium_category`,
        si.no_of_bank_external_rich_recloan AS `Bank_loans_No_Of_HHs_benefitted_in_last_12_months_Rich_category`,
        
        si.no_of_other_external_poorest_recloan AS `Other_loans_No_Of_HHs_benefitted_in_last_12_months_Very_Poor_category`,
        si.no_of_other_external_poor_recloan AS `Other_loans_No_Of_HHs_benefitted_in_last_12_months_Poor_category`,
        si.no_of_other_external_medium_recloan AS `Other_loans_No_Of_HHs_benefitted_in_last_12_months_Medium_category`,
        si.no_of_other_external_rich_recloan AS `Other_loans_No_Of_HHs_benefitted_in_last_12_months_Rich_category`
      
      FROM
        shg_mst AS s 
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        INNER JOIN shg_inclusion AS si
        ON si.shg_sub_mst_id = s.id
        WHERE s.is_deleted = 0 ";

if ($isClusterSelected) {
    $query .= " AND c.is_deleted = 0 ";
}

          if(!empty($session_data['Search'])){
            if(!empty($session_data['agency'])){
                $agency = $session_data['agency'];
                $query .=" AND s.agency_id = $agency  ";
             }
             if(!empty($session_data['federation'])){
                $query .=" AND fed.uin = '" . $session_data['federation'] . "' ";
             }
             if(!empty($session_data['cluster'])){
                $query .=" AND c.uin = '" . $session_data['cluster'] . "' ";
             }
             if(!empty($session_data['shg'])){
                $query .=" AND s.uin = '" . $session_data['shg'] . "' ";
             }
          }

         $query .="  GROUP BY s.id
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
                $res->Risk_Rating,
                $res->NRLM_code,
                $res->cluster_name,
                $res->federation_name,
                $res->village,
                $res->Total_HHs_Benefitted,
                $res->No_of_Poorest_and_Vulnerable_Members,
                $res->Number_of_Poor_members,
                $res->Number_of_medium_poor,
                $res->Number_of_Rich,
                $res->Internal_loans_No_Of_HHs_benefitted_in_last_12_months_Very_Poor_category,
                $res->Internal_loans_No_Of_HHs_benefitted_in_last_12_months_Poor_category,
                $res->Internal_loans_No_Of_HHs_benefitted_in_last_12_months_Medium_category,
                $res->Internal_loans_No_Of_HHs_benefitted_in_last_12_months_Rich_category,
                $res->Federation_loans_No_Of_HHs_benefitted_in_last_12_months_Very_Poor_category,
                $res->Federation_loans_No_Of_HHs_benefitted_in_last_12_months_Poor_category,
                $res->Federation_loans_No_Of_HHs_benefitted_in_last_12_months_Medium_category,
                $res->Federation_loans_No_Of_HHs_benefitted_in_last_12_months_Rich_category,
                $res->Bank_loans_No_Of_HHs_benefitted_in_last_12_months_Very_Poor_category,
                $res->Bank_loans_No_Of_HHs_benefitted_in_last_12_months_Poor_category,
                $res->Bank_loans_No_Of_HHs_benefitted_in_last_12_months_Medium_category,
                $res->Bank_loans_No_Of_HHs_benefitted_in_last_12_months_Rich_category,
                $res->Other_loans_No_Of_HHs_benefitted_in_last_12_months_Very_Poor_category,
                $res->Other_loans_No_Of_HHs_benefitted_in_last_12_months_Poor_category,
                $res->Other_loans_No_Of_HHs_benefitted_in_last_12_months_Medium_category,
                $res->Other_loans_No_Of_HHs_benefitted_in_last_12_months_Rich_category,
                
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
                $event->sheet->getStyle('A1:AC1')->applyFromArray([
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
            'Name of SHG',
            'Risk Rating',
            'NRLM Code',
            'Cluster Name',
            'Federation Name',
            'Name of Village',
            'Total HHs Benefitted',
            'No of Poorest and Vulnerable Members',
            'Number of Poor members',
            'Number of medium poor',
            'Number of Rich',
            'Internal loans No. Of HHs benefitted in last 12 months - Very Poor category',
            'Internal loans No. Of HHs benefitted in last 12 months -  Poor category',
            'Internal loans No. Of HHs benefitted in last 12 months - Medium category',
            'Internal loans No. Of HHs benefitted in last 12 months - Rich category',
            'Federation/Cluster loans No.  Of HHs benefitted in last 12 months  - Very Poor category' 
            ,'Federation/Cluster loans No.  Of HHs benefitted in last 12 months  -  Poor category',
            'Federation/Cluster loans No.  Of HHs benefitted in last 12 months  - Medium category',
            'Federation/Cluster loans No.  Of HHs benefitted in last 12 months   - Rich category',
            'Bank loans No. Of HHs benefitted in last 12 months - Very Poor category',
            'Bank loans No. Of HHs benefitted in last 12 months - Poor category',
            'Bank loans No. Of HHs benefitted in last 12 months - Medium category',
            'Bank loans No. Of HHs benefitted in last 12 months - Rich category'
            ,'Other loans No. Of HHs benefitted in last 12 months - Very Poor category'
            ,'Other loans No. Of HHs benefitted in last 12 months - Poor category'
            ,'Other loans No. Of HHs benefitted in last 12 months - Medium category'
            ,'Other loans No. Of HHs benefitted in last 12 months - Rich category'
           ]
        ];
    }

    public function title(): string
    {
        return 'SHG Inclusion - HHs Benefitted';
    }
}
