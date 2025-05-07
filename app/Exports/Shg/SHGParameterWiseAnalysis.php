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
use DateTime;


class SHGParameterWiseAnalysis implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        s.id
      FROM
        shg_mst AS s 
        INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
        LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
        LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
        INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
        INNER JOIN federation_profile AS fedp
        ON fed.id = fedp.federation_sub_mst_id
        WHERE s.is_deleted = 0 ";

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
        $shg = DB::select($query);
        // prd($shg);
        $data = [];
        foreach ($shg as $res) {
            $data[] = $this->shg_analysis($res->id);
        }

        // prd($data);
        return collect($data);
    }

    public function map($res): array
    {
        // prd($res);


        return [
            $this->counter++,
            $res['uin'],
            $res['shg_name'],
            $res['Risk_Rating'],
            $res['NRLM_code'],
            $res['cluster_name'],
            $res['federation_name'],
            $res['village'],
            (string) $res['total_1'],
            (string) $res['total_2'],
            (string) $res['total_3'],
            (string) $res['total_4'],
            (string) $res['total_5'],
            (string) $res['grd_total'],


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
                $event->sheet->getStyle('A1:W1')->applyFromArray([
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
                'NRLM Code ',
                'Cluster Name',
                'Federation Name',
                'Name of Village',

                'Governance',
                'Inclusion',
                'Efficiency',
                'Credit History',
                'Savings',
                'Total/Overall Rating',

            ]
        ];
    }

    public function title(): string
    {
        return 'SHG ParameterWise Analysis';
    }

    public function shg_analysis($shg_id)
    {

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
                sp.village AS village

                FROM

                shg_mst AS s 
                INNER JOIN shg_profile AS sp ON s.id = sp.shg_sub_mst_id
                LEFT JOIN cluster_mst AS c ON c.uin = s.cluster_uin
                LEFT JOIN cluster_profile AS cp ON c.id = cp.cluster_sub_mst_id
                INNER JOIN federation_mst as fed on  fed.uin = s.federation_uin
                INNER JOIN federation_profile AS fedp
                ON fed.id = fedp.federation_sub_mst_id
                WHERE s.is_deleted = 0  and s.id = $shg_id
                ORDER  BY s.id";

        if ($isClusterSelected) {
            $query .= " AND c.is_deleted = 0 ";
        }

        $shg_info = DB::select($query)[0];
        $data['id'] = $shg_info->id;
        $data['uin'] = $shg_info->uin;
        $data['shg_name'] = $shg_info->shg_name;
        $data['Risk_Rating'] = $shg_info->Risk_Rating;
        $data['NRLM_code'] = $shg_info->NRLM_code;
        $data['cluster_name'] = $shg_info->cluster_name;
        $data['federation_name'] = $shg_info->federation_name;
        $data['village'] = $shg_info->village;

        $analysis = DB::table('shg_analysis as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $shg_id)
            ->get()->toArray();

        $inclusion = DB::table('shg_inclusion as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $shg_id)
            ->get()->toArray();

        // analysis 1
        $x2 = $analysis[0]->shg_average_participation;
        $data['Average_participation_of'] = '';

        if ($x2 != '') {
            $data['Average_participation_of'] = ($x2 >= 90 ? 10 : ($x2 >= 75 ? 8 : ($x2 >= 60 ? 6 : 2)));
        } else {
            $data['Average_participation_of'] = 0;
        }
        //  analysis 2
        $count3 = $analysis[0]->shg_book_updation;
        $data['shg_book_updation'] = '';

        if ($count3 != '') {
            $data['shg_book_updation'] = ($count3 == 'Fully updated' ? 10 : ($count3 == 'Mostly updated' ? 7 : ($count3 == 'Partially updated' ? 5 : ($count3 == 'Unsatisfactory recording' ? 2 : ($count3 == 'Book not updated' ? 0 : 0)))));
        } else {
            $data['shg_book_updation'] = 0;
        }

        // analysis 3
        $count4 = $analysis[0]->shg_grading_status;
        $data['shg_grading_status'] = '';

        if ($count4 != '') {

            $data['shg_grading_status'] = ($count4 == 'A' ? 1 : ($count4 == 'B' ? 1 : ($count4 == 'C' ? 0 : 0)));
        } else {
            $data['shg_grading_status'] = 0;
        }

        // analysis 4
        $x2 = (str_replace('%', '', $analysis[0]->shg_percent_of_poorest_internal));
        $data['shg_percent_of_poorest_internal'] = '';

        if ($x2 != '') {
            $data['shg_percent_of_poorest_internal'] = (($x2 >= 80 ? 4 : ($x2 >= 60 ? 3 : ($x2 >= 40 ? 2 : 1))));
        } else {
            $data['shg_percent_of_poorest_internal'] = 0;
        }

        // analysis 5
        $data['shg_percent_of_poorest_other'] = '';
        $x2 = $analysis[0]->shg_percent_of_poorest_other;
        if ($x2 != '') {
            $data['shg_percent_of_poorest_other'] = (($x2 >= 80 ? 4 : ($x2 >= 60 ? 3 : ($x2 >= 40 ? 2 : 1))));
        } else {
            $data['shg_percent_of_poorest_other'] = 0;
        }

        // analysis 6
        $x2 = $inclusion[0]->no_of_leadership_poor;
        $data['no_of_leadership_poor'] = '';

        if ($x2 != '') {
            if ($x2 >= 3) {
                $data['no_of_leadership_poor'] = 5;
            } elseif ($x2 == 2) {
                $data['no_of_leadership_poor'] = 4;
            } elseif ($x2 == 1) {
                $data['no_of_leadership_poor'] = 2;
            } elseif ($x2 == 0) {
                $data['no_of_leadership_poor'] = 0;
            }
        } else {
            $data['no_of_leadership_poor'] = 0;
        }

        // analysis 7
        $count5 = $analysis[0]->shg_operational_cost;

        $data['shg_operational_cost'] = '';
        if ($count5 != '') {
            $data['shg_operational_cost'] = ($count5 == 'Yes' ? 5 : 0);
        } else {
            $data['shg_operational_cost'] = '--';
        }

        // analysis 8
        $count6 = $analysis[0]->shg_time_taken_loan_disburse;

        $data['shg_time_taken_loan_disburse'] = '';
        if ($count6 != '') {
            $data['shg_time_taken_loan_disburse'] = (($count6 == 1 ? 5 : ($count6 == 2 ? 4 : ($count6 == 3 ? 3 : 1))));
        } else {
            $data['shg_time_taken_loan_disburse'] = 0;
        }

        // analysis 9

        $shg_profile = DB::table('shg_profile as a')
            ->where('is_deleted', '=', 0)
            ->where('a.shg_sub_mst_id', '=', $shg_id)
            ->get()->toArray();


        $shg_formed = $shg_profile[0]->formed;
        $pattern = '/^\d{2}\/\d{2}\/\d{4}$/';


        if (preg_match($pattern, $shg_formed)) {
            $originalDate = DateTime::createFromFormat('d/m/Y', $shg_formed);

            $formattedDate = $originalDate->format('d/M/Y');
        } else {
            $formattedDate = $shg_formed;
        }

        $currentnewDate = new DateTime();
        $currentDate = strftime('%d/%b/%Y', $currentnewDate->getTimestamp());
        $date1 = DateTime::createFromFormat('d/M/Y', $formattedDate);
        $date2 = DateTime::createFromFormat('d/M/Y', $currentDate);

        // Calculate the difference
        $interval = $date1->diff($date2);
        // Get the difference in years, months, and days
        $years = $interval->y;



        $x2 = (str_replace('%', '', $analysis[0]->shg_repayment_internal));
        $data['shg_repayment_internal'] = '';
        if ($x2 != '') {
            $data['shg_repayment_internal'] = (($x2 >= 95 ? 12 : ($x2 >= 85 ? 10 : ($x2 >= 75 ? 7 : 5))));
        } else {
            $data['shg_repayment_internal'] = (($years <= 1 ? 12 : ($years <= 2 ? 6 : ($years >= 3 ? 0 : 0))));
        }

        // analysis 10
        $x2 = (str_replace('%', '', $analysis[0]->shg_repayment_other));

        $data['shg_repayment_other'] = '';
        if ($x2 != '') {
            $data['shg_repayment_other'] = (($x2 >= 95 ? 12 : ($x2 >= 85 ? 10 : ($x2 >= 75 ? 7 : 5))));
        } else {
            $data['shg_repayment_other'] = (($years <= 2 ? 12 : ($years >= 2 ? 6 : ($years >= 3 ? 0 : 0))));
        }


        // analysis 11
        $count9 = $analysis[0]->shg_PAR_status_internal_loan;
        $data['shg_PAR_status_internal_loan'] = '';
        if ($count9 != '') {
            $data['shg_PAR_status_internal_loan'] = (($count9 < 1 ? 6 : ($count9 < 5 ? 4 : ($count9 < 10 ? 3 : 1))));
        } else {
            $data['shg_PAR_status_internal_loan'] = (($years <= 1 ? 6 : ($years <= 2 ? 3 : ($years > 3 ? 0 : 0))));
        }

        // analysis 12
        $count19 = $analysis[0]->shg_PAR_status_other_loan;
        $data['shg_PAR_status_other_loan'] = '';
        if ($count19 != '') {
            $data['shg_PAR_status_other_loan'] = (($count19 < 1 ? 6 : ($count19 < 5 ? 4 : ($count19 < 10 ? 3 : 1))));
        } else {
            $data['shg_PAR_status_other_loan'] = (($years < 2 ? 6 : ($years >= 2 ? 3 : ($years >= 3 ? 0 : 0))));
        }

        // analysis 13

        $count15 = $analysis[0]->shg_compulsory_savings;

        $data['shg_compulsory_savings'] = '';
        if ($count15 > 0) {
            $data['shg_compulsory_savings'] = 5;
        } else {
            $data['shg_compulsory_savings'] = 0;
        }

        // analysis 14
        $count51 = $analysis[0]->shg_voluntary_savings;

        $data['shg_voluntary_savings'] = '';
        if ($count51 > 0) {
            $data['shg_voluntary_savings'] = 5;
        } else {
            $data['shg_voluntary_savings'] = 0;
        }

        // analysis 15
        $x2 = (str_replace('%', '', $analysis[0]->shg_regularity_savings));
        $data['shg_regularity_savings'] = '';
        if ($x2 != '') {
            $data['shg_regularity_savings'] = (($x2 >= 90 ? 10 : ($x2 >= 80 ? 7 : ($x2 >= 70 ? 5 : ($x2 >= 60 ? 3 : ($x2 >= 50 ? 1 : 0))))));
        } else {
            $data['shg_regularity_savings'] = 0;
        }


        //total analysis
        $data['total_1'] = (float) $data['Average_participation_of'] + (float) $data['shg_book_updation'] + (float) $data['shg_grading_status'];


        $data['total_2'] = (float) $data['shg_percent_of_poorest_internal'] + (float) $data['shg_percent_of_poorest_other'] + (float) $data['no_of_leadership_poor'];

        $data['total_3'] = (float) $data['shg_operational_cost'] + (float) $data['shg_time_taken_loan_disburse'];


        $data['total_4'] = (float) $data['shg_repayment_internal'] + (float) $data['shg_repayment_other'] + (float) $data['shg_PAR_status_internal_loan'] + (float) $data['shg_PAR_status_other_loan'];


        $data['total_5'] = (float) $data['shg_compulsory_savings'] + (float) $data['shg_voluntary_savings'] + (float) $data['shg_regularity_savings'];


        $data['grd_total'] = $data['total_5'] + $data['total_4'] + $data['total_3'] + $data['total_2'] + $data['total_1'];


        return $data;
    }
}
