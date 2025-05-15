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


class LoanSummary implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        fp.fp_wealth_rank,
        sp.shgName,
        cp.name_of_cluster,
        fedp.name_of_federation,
        fp.analysis_rating,

        sum(case when fl.lo_type = 'SHG Loan' THEN 1 ELSE 0 END) AS shg_loan_count,
        sum(case when fl.lo_type = 'Cluster Loan' THEN 1 ELSE 0 END) AS cluster_loan_count,
        sum(case when fl.lo_type = 'Federation Loan' THEN 1 ELSE 0 END) AS fed_loan_count,
        sum(case when fl.lo_type = 'Bank Loan' THEN 1 ELSE 0 END) AS bank_loan_count,
        sum(case when fl.lo_type = 'MFI Loan' THEN 1 ELSE 0 END) AS mfi_loan_count,
        sum(case when fl.lo_type = 'NBFC Loan' THEN 1 ELSE 0 END) AS nbfc_loan_count,
        sum(case when fl.lo_type = 'Money Lenders Loan' THEN 1 ELSE 0 END) AS money_loan_count,
        sum(case when fl.lo_type = 'Other Private Loan' THEN 1 ELSE 0 END) AS other_loan_count,
        sum(case when fl.lo_type !='VI Loan' AND  fl.lo_type !='' then  1 ELSE 0 END)  AS total_loans,
        SUM(COALESCE(fl.lo_principle_amount,0)) AS total_principle,
        SUM(COALESCE(fl.total_paid_interest,0)) AS total_paid_interest ,
        SUM(COALESCE(fl.overdue,0)) AS overdue,
        SUM(COALESCE(fl.lo_next_year,0)) AS lo_next_year

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
        LEFT JOIN family_loan_outstanding AS fl
        ON f.id = fl.family_sub_mst_id

	 WHERE  s.is_deleted = 0 AND f.is_deleted = 0 ";

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

        $query .= " GROUP BY f.id ORDER  BY f.id  ";
        // prd($query);

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

            $res->shg_loan_count,
            $res->cluster_loan_count,
            $res->fed_loan_count,
            $res->bank_loan_count,
            $res->mfi_loan_count,
            $res->nbfc_loan_count,
            $res->money_loan_count,
            $res->other_loan_count,
            $res->total_loans,
            $res->total_principle,
            $res->total_paid_interest,
            $res->overdue,
            $res->lo_next_year,



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
                $event->sheet->getStyle('A1:U1')->applyFromArray([
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

                'SHG LOANS',
                'CLUSTER LOANS ',
                'FEDERATION LOANS',
                'BANK LOANS',
                'MFI  LOANS',
                'NBFC LOANS',
                'MONEY LENDER LOANS',
                'OTHER PRIVATE LOANS',
                'TOTAL LOANS',
                'TOTAL PRINCIPLE',
                'TOTAL CUMULATIVE REPAID',
                'TOTAL OVERDUE',
                'Total NEXT YEAR LOAN REPAYMENT COMMITMENT',



            ]
        ];
    }

    public function title(): string
    {
        return 'Family Loans Summary';
    }
}
