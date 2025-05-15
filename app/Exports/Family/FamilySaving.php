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


class FamilySaving implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        (case when fs.s_passbook_physically = 1 then 'Yes' ELSE NULL END ) AS PASSBOOK_IN_POSSESION,
        (case when fs.s_passbook_updated = 1 then 'Yes' ELSE NULL END ) AS PASSBOOK_UPDATED,

        fv.s_contribute_regular AS DO_YOU_CONTRIBUTE_TO_VOLUNTARTY_SAVINGS,
        fv.s_started_from AS voluntry_satrted_date,
        fv.s_saving_per_month AS voluntry_saving_per_month,
        fv.s_last_saved_amt AS VOLUNTARY_TOTAL_AMOUNT_SAVED_IN_LAST_12_MONTHS,
        fv.s_total_saving AS VOLUNTARY_TOTAL_SAVINGS_TO_DATE,

        fc.s_contribute_regular AS DO_YOU_CONTRIBUTE_TO_COMPULSORY_SAVINGS,
        fc.s_started_from AS voluntry_satrted_date_c,
        fc.s_saving_per_month AS voluntry_saving_per_month_c,
        fc.s_last_saved_amt AS COMPULSORY_TOTAL_AMOUNT_SAVED_IN_LAST_12_MONTHS,
        fc.s_total_saving AS COMPULSORY_TOTAL_SAVINGS_TO_DATE_C,

        ff.other_loan AS fixed_other_loan,
        ff.other_where_fixed_deposit_made AS fixed_other_where_fixed_deposit_made,
        ff.other_amount AS fixed_other_amount,
        ff.other_date_of_deposit AS fixed_other_date_of_deposit,
        ff.other_fixed_deposit_term_period AS fixed_other_fixed_deposit_term_period,
        ff.other_interest AS fixed_other_interest,
        ff.last_saved_amt AS fixed_last_saved_amt,

        fr.other_loan AS rd_other_loan,
        fr.other_where_fixed_deposit_made AS rd_other_where_fixed_deposit_made,
        fr.other_amount AS rd_other_amount,
        fr.other_date_of_deposit AS rd_other_date_of_deposit,
        fr.other_fixed_deposit_term_period AS rd_other_fixed_deposit_term_period,
        fr.other_interest AS rd_other_interest,
        fr.last_saved_amt AS rd_last_saved_amt,

        fch.other_loan AS chit_other_loan,
        fch.other_where_fixed_deposit_made AS chit_other_where_fixed_deposit_made,
        fch.other_amount AS chit_other_amount,
        fch.other_date_of_deposit AS chit_other_date_of_deposit,
        fch.other_fixed_deposit_term_period AS chit_other_fixed_deposit_term_period,
        fch.other_interest AS chit_other_interest,
        fch.last_saved_amt AS chit_last_saved_amt,

        fpo.other_loan AS post_other_loan,
        fpo.other_where_fixed_deposit_made AS post_other_where_fixed_deposit_made,
        fpo.other_amount AS post_other_amount,
        fpo.other_date_of_deposit AS post_other_date_of_deposit,
        fpo.other_fixed_deposit_term_period AS post_other_fixed_deposit_term_period,
        fpo.other_interest AS post_other_interest,
        fpo.last_saved_amt AS post_last_saved_amt,


        foo.other_loan AS other_other_loan,
        foo.other_where_fixed_deposit_made AS other_other_where_fixed_deposit_made,
        foo.other_amount AS other_other_amount,
        foo.other_date_of_deposit AS other_other_date_of_deposit,
        foo.other_fixed_deposit_term_period AS other_other_fixed_deposit_term_period,
        foo.other_interest AS other_other_interest,
        foo.last_saved_amt AS other_last_saved_amt,


        SUM(COALESCE(fv.s_total_saving, 0) + COALESCE(fc.s_total_saving, 0) + COALESCE(ff.total_saving, 0) + COALESCE(fr.total_saving, 0) + COALESCE(fch.total_saving, 0) + COALESCE(fpo.total_saving, 0) + COALESCE(foo.total_saving, 0)) AS total_savings


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
        INNER JOIN family_savings AS fs
        ON f.id = fs.family_sub_mst_id
        LEFT  JOIN (SELECT * FROM family_savings_source WHERE s_type = 'Voluntary') AS fv
        ON f.id = fv.family_sub_mst_id
        LEFT JOIN (SELECT * FROM family_savings_source WHERE s_type = 'Compulsory') AS fc
        ON f.id = fc.family_sub_mst_id
        LEFT JOIN (SELECT
			GROUP_CONCAT(other_loan) AS other_loan,
         GROUP_CONCAT(other_where_fixed_deposit_made) AS other_where_fixed_deposit_made,
         GROUP_CONCAT(other_amount) AS other_amount,
         GROUP_CONCAT(other_date_of_deposit) AS other_date_of_deposit,
         GROUP_CONCAT(other_fixed_deposit_term_period) AS other_fixed_deposit_term_period,
         GROUP_CONCAT(other_interest) AS other_interest,
         GROUP_CONCAT(last_saved_amt) AS last_saved_amt,
         COALESCE(SUM(last_saved_amt),0) AS total_saving,
         family_sub_mst_id
			 FROM family_savings_source_other WHERE other_loan = 'Fixed deposit' group by family_sub_mst_id ORDER BY id) AS ff
         ON f.id = ff.family_sub_mst_id
         LEFT JOIN (SELECT
         	GROUP_CONCAT(other_loan) AS other_loan,
         GROUP_CONCAT(other_where_fixed_deposit_made) AS other_where_fixed_deposit_made,
         GROUP_CONCAT(other_amount) AS other_amount,
         GROUP_CONCAT(other_date_of_deposit) AS other_date_of_deposit,
         GROUP_CONCAT(other_fixed_deposit_term_period) AS other_fixed_deposit_term_period,
         GROUP_CONCAT(other_interest) AS other_interest,
         GROUP_CONCAT(last_saved_amt) AS last_saved_amt,
         COALESCE(SUM(last_saved_amt),0) AS total_saving,
         family_sub_mst_id
			 FROM family_savings_source_other WHERE other_loan = 'Rd, bank/post ofice' GROUP BY family_sub_mst_id ORDER BY id) AS fr
         ON f.id = fr.family_sub_mst_id
         LEFT JOIN (SELECT
				GROUP_CONCAT(other_loan) AS other_loan,
         GROUP_CONCAT(other_where_fixed_deposit_made) AS other_where_fixed_deposit_made,
         GROUP_CONCAT(other_amount) AS other_amount,
         GROUP_CONCAT(other_date_of_deposit) AS other_date_of_deposit,
         GROUP_CONCAT(other_fixed_deposit_term_period) AS other_fixed_deposit_term_period,
         GROUP_CONCAT(other_interest) AS other_interest,
         GROUP_CONCAT(last_saved_amt) AS last_saved_amt,
         COALESCE(SUM(last_saved_amt),0) AS total_saving,
         family_sub_mst_id
			 FROM family_savings_source_other WHERE other_loan = 'Chit' GROUP BY family_sub_mst_id ORDER BY id) AS fch
         ON f.id = fch.family_sub_mst_id
         LEFT JOIN (SELECT
         	GROUP_CONCAT(other_loan) AS other_loan,
         GROUP_CONCAT(other_where_fixed_deposit_made) AS other_where_fixed_deposit_made,
         GROUP_CONCAT(other_amount) AS other_amount,
         GROUP_CONCAT(other_date_of_deposit) AS other_date_of_deposit,
         GROUP_CONCAT(other_fixed_deposit_term_period) AS other_fixed_deposit_term_period,
         GROUP_CONCAT(other_interest) AS other_interest,
         GROUP_CONCAT(last_saved_amt) AS last_saved_amt,
         COALESCE(SUM(last_saved_amt),0) AS total_saving,
         family_sub_mst_id
			 FROM family_savings_source_other WHERE other_loan = 'Post office savings' GROUP BY family_sub_mst_id ORDER BY id) AS fpo
         ON f.id = fpo.family_sub_mst_id
         LEFT JOIN (SELECT
				GROUP_CONCAT(other_loan) AS other_loan,
         GROUP_CONCAT(other_where_fixed_deposit_made) AS other_where_fixed_deposit_made,
         GROUP_CONCAT(other_amount) AS other_amount,
         GROUP_CONCAT(other_date_of_deposit) AS other_date_of_deposit,
         GROUP_CONCAT(other_fixed_deposit_term_period) AS other_fixed_deposit_term_period,
         GROUP_CONCAT(other_interest) AS other_interest,
         GROUP_CONCAT(last_saved_amt) AS last_saved_amt,
         COALESCE(SUM(last_saved_amt),0) AS total_saving,
         family_sub_mst_id
			 FROM family_savings_source_other WHERE other_loan NOT IN ('Post office savings','Chit','Rd, bank/post ofice','Fixed deposit') GROUP BY family_sub_mst_id ORDER BY id) AS foo
         ON f.id = foo.family_sub_mst_id
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



        $query .= " group by f.id  ORDER BY f.id 
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

            $res->PASSBOOK_IN_POSSESION,
            $res->PASSBOOK_UPDATED,

            $res->DO_YOU_CONTRIBUTE_TO_VOLUNTARTY_SAVINGS,
            $res->voluntry_satrted_date,
            $res->voluntry_saving_per_month,
            $res->VOLUNTARY_TOTAL_AMOUNT_SAVED_IN_LAST_12_MONTHS,
            $res->VOLUNTARY_TOTAL_SAVINGS_TO_DATE,

            $res->DO_YOU_CONTRIBUTE_TO_COMPULSORY_SAVINGS,
            $res->voluntry_satrted_date_c,
            $res->voluntry_saving_per_month_c,
            $res->COMPULSORY_TOTAL_AMOUNT_SAVED_IN_LAST_12_MONTHS,
            $res->COMPULSORY_TOTAL_SAVINGS_TO_DATE_C,

            $res->fixed_other_loan,
            $res->fixed_other_where_fixed_deposit_made,
            $res->fixed_other_amount,
            $res->fixed_other_date_of_deposit,
            $res->fixed_other_fixed_deposit_term_period,
            $res->fixed_other_interest,
            $res->fixed_last_saved_amt,

            $res->rd_other_loan,
            $res->rd_other_where_fixed_deposit_made,
            $res->rd_other_amount,
            $res->rd_other_date_of_deposit,
            $res->rd_other_fixed_deposit_term_period,
            $res->rd_other_interest,
            $res->rd_last_saved_amt,

            $res->chit_other_loan,
            $res->chit_other_where_fixed_deposit_made,
            $res->chit_other_amount,
            $res->chit_other_date_of_deposit,
            $res->chit_other_fixed_deposit_term_period,
            $res->chit_other_interest,
            $res->chit_last_saved_amt,

            $res->post_other_loan,
            $res->post_other_where_fixed_deposit_made,
            $res->post_other_amount,
            $res->post_other_date_of_deposit,
            $res->post_other_fixed_deposit_term_period,
            $res->post_other_interest,
            $res->post_last_saved_amt,

            $res->other_other_loan,
            $res->other_other_where_fixed_deposit_made,
            $res->other_other_amount,
            $res->other_other_date_of_deposit,
            $res->other_other_fixed_deposit_term_period,
            $res->other_other_interest,
            $res->other_last_saved_amt,
            $res->total_savings





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
                $event->sheet->getStyle('A1:BD1')->applyFromArray([
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

                'Passbook in possesion',
                'Passbook updated regularly in last 6 months',

                'DO YOU CONTRIBUTE TO VOLUNTARTY SAVINGS (YES OR NO ANSWER)',
                'DATE - WHEN STARTED',
                'AMOUNT SAVED PER MONTH',
                'VOLUNTARY - TOTAL AMOUNT SAVED IN LAST 12 MONTHS',
                'VOLUNTARY - TOTAL SAVINGS TO DATE',

                'DO YOU CONTRIBUTE TO COMPULSORY SAVINGS (YES OR NO ANSWER)',
                'DATE - WHEN STARTED',
                'AMOUNT SAVED PER MONTH',
                'COMPULSORY - TOTAL AMOUNT SAVED IN LAST 12 MONTHS',
                'COMPULSORY - TOTAL SAVINGS TO DATE',

                'OTHER SAVINGS - FIXED DEPOSIT',
                'OTHER SAVINGS -Where deposit made',
                'OTHER SAVINGS - AMOUNT ',
                'OTHER SAVINGS- Date of deposit',
                'OTHER SAVINGS - Deposit terms (years)',
                'OTHER SAVINGS - INTEREST RATE OFFERED ',
                'OTHER SAVINGS - TOTAL AMOUNT SAVED IN LAST 12 MONTHS ',

                'OTHER SAVINGS - RD, BANK/POST OFFICE',
                'OTHER SAVINGS -Where deposit made',
                'OTHER SAVINGS - AMOUNT ',
                'OTHER SAVINGS- Date of deposit',
                'OTHER SAVINGS - Deposit terms (years)',
                'OTHER SAVINGS - INTEREST RATE OFFERED ',
                'OTHER SAVINGS - TOTAL AMOUNT SAVED IN LAST 12 MONTHS ',

                'OTHER SAVINGS - Chit',
                'OTHER SAVINGS -Where deposit made',
                'OTHER SAVINGS - AMOUNT ',
                'OTHER SAVINGS- Date of deposit',
                'OTHER SAVINGS - Deposit terms (years)',
                'OTHER SAVINGS - INTEREST RATE OFFERED ',
                'OTHER SAVINGS - TOTAL AMOUNT SAVED IN LAST 12 MONTHS ',

                'OTHER SAVINGS - Post Office Savings',
                'OTHER SAVINGS -Where deposit made',
                'OTHER SAVINGS - AMOUNT ',
                'OTHER SAVINGS- Date of deposit',
                'OTHER SAVINGS - Deposit terms (years)',
                'OTHER SAVINGS - INTEREST RATE OFFERED ',
                'OTHER SAVINGS - TOTAL AMOUNT SAVED IN LAST 12 MONTHS ',

                'OTHER SAVINGS - Others Office Savings',
                'OTHER SAVINGS -Where deposit made',
                'OTHER SAVINGS - AMOUNT ',
                'OTHER SAVINGS- Date of deposit',
                'OTHER SAVINGS - Deposit terms (years)',
                'OTHER SAVINGS - INTEREST RATE OFFERED ',
                'OTHER SAVINGS - TOTAL AMOUNT SAVED IN LAST 12 MONTHS ',
                'TOTAL SAVINGS'

            ]
        ];
    }

    public function title(): string
    {
        return 'Family Savings';
    }
}
