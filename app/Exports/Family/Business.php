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


class Business implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        f.uin,
        fp.fp_member_name,
        sp.shgName,
        cp.name_of_cluster,
        fedp.name_of_federation,
        fp.fp_wealth_rank,
        fp.analysis_rating,
        fb.is_buisness_plan_avl,
        fb.type_of_category,
        fb.type_of_business,
        fb.is_existing_business_plan,
        fb.current_business,
        fb.proposed_activity_new,
        fb.date_of_business_plan,
        fb.primarily_business,
        fr.principal,
        fr.interest,
        fr.interest_type,
        fr.loan_tenure,
        (CASE WHEN fr.tenure_mode = 1 THEN 'Year' WHEN fr.tenure_mode = 0 THEN 'Month' END ) AS duration_mode,
        fb.comments

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
        INNER JOIN family_business_investment_plan AS fb
        ON f.id = fb.family_sub_mst_id
        INNER JOIN family_loan_repayment AS fr
        ON f.id = fr.family_sub_mst_id 
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



        $query .= "  ORDER BY f.id
         ";
        // prd($query);
        $familys = DB::select($query);
        // prd($familys);
        return collect($familys);
    }

    public function map($res): array
    {

        $WealthData = getMstCommonData(7,$res->fp_wealth_rank);
        $wealthName = $WealthData->isNotEmpty() ? $WealthData[0]->common_values : 'N/A';

        return [
            $this->counter++,
            $res->uin,
            $res->fp_member_name,
            $res->shgName,
            $res->name_of_cluster,
            $res->name_of_federation,
            $wealthName,
            $res->analysis_rating,
            $res->is_buisness_plan_avl,
            $res->type_of_category,
            $res->type_of_business,
            $res->is_existing_business_plan,
            $res->current_business,
            $res->proposed_activity_new,
            $res->date_of_business_plan,
            $res->primarily_business,
            $res->principal,
            $res->interest,
            $res->interest_type,
            $res->loan_tenure,
            $res->duration_mode,
            $res->comments,

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
                $event->sheet->getStyle('A1:V1')->applyFromArray([
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
                'DOES THE FAMILY HAVE A BUSINESS PLAN ',
                'TYPE OF CATEGORY',
                'TYPE OF BUSINESS/INVESTMENT',
                'EXISTING OR NEW BUSINESS',
                'WILL THIS BE IMPROVING ON EXISTING OR ADDING?',
                'PROPOSED ACTIVITY',
                'Date of Business Plan',
                'Who will run business?',
                'Loan Amount',
                'Interest Rate',
                'Interest Type',
                'Duration',
                'Duration Mode',
                'FF COMMENTS'
            ]
        ];
    }

    public function title(): string
    {
        return 'Family Business';
    }
}
