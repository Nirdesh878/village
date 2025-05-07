<?php

namespace App\Exports;

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


class Credit_loan implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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



        $res = [];
        $session_data = Session::get('credit_loan_filter_session');

        
        $query = "SELECT
        SUM(c.principal) as loan_demand,
        SUM(d.uloan_amount) as loan_approved,
        SUM(e.loan_amount) as loan_disbursed
            FROM
                family_mst a
            INNER JOIN family_sub_mst b ON
                a.id = b.family_mst_id
            INNER JOIN family_profile f ON
                b.id = f.family_sub_mst_id
            INNER JOIN family_loan_repayment c ON
                b.id = c.family_sub_mst_id
            INNER JOIN family_loan_approvel d ON
                b.id = d.family_sub_mst_id
            INNER JOIN family_loan_disbursement e ON
                b.id = e.family_sub_mst_id
            INNER JOIN agency g ON 
                a.agency_id = g.agency_id
            INNER JOIN shg_mst h ON 
                a.shg_uin = h.uin
            LEFT JOIN cluster_mst i ON 
                a.cluster_uin = i.uin
            INNER JOIN federation_mst j ON 
                a.federation_uin = j.uin
            WHERE
                a.is_deleted = 0 AND b.qa_p2='V' AND (d.get_verified = 'Verified' OR e.get_loan = 'Yes')AND b.locked=1";

            if (!empty($session_data['Search'])) {
                // pr("hello");
                if (!empty($session_data['federation'])) {
                    $text = $session_data['federation'];
                    preg_match('#\((.*?)\)#', $text, $match);
                    $uin = $match[1];
                }

                // prd($uin);
                if (!empty($session_data['state'])) {

                    
                        $query .= " AND f.fp_state_id = '" . $session_data['state'] . "' ";
                    
                }
                if (!empty($session_data['district'])) {
                    
                        $query .= " AND f.fp_district_id = '" . $session_data['district'] . "' ";
                    
                }
                if (!empty($session_data['country'])) {
                        $query .= " AND f.fp_country_id = '" . $session_data['country'] . "' ";
                }


                if (!empty($session_data['group'] == 'FD')) {
                    if (!empty($session_data['federation'])) {
                            $query .= " AND a.federation_uin = '" . $uin . "' ";
                        
                    }
                }
                if (!empty($session_data['group'] == 'CL')) {
                    if (!empty($session_data['federation'])) {
                            $query .= " AND a.cluster_uin = '" . $uin . "' ";
                        }
                    
                }
                if (!empty($session_data['group'] == 'SH')) {
                    if (!empty($session_data['federation'])) {
                            $query .= " AND a.shg_uin = '" . $uin . "' ";
                    }
                }
                if (!empty($session_data['group'] == 'FM')) {
                    // prd("kkk");
                    if (!empty($session_data['federation'])) {
                            $query .= " AND a.uin = '" . $uin . "' ";
                        
                    }
                }
                if (!empty($session_data['group'] == 'AG')) {
                    if (!empty($session_data['federation'])) {
                        
                            $query .= " AND a.agency_id = '" . $uin . "' ";
                        
                    }
                }
            }  
        $credit = DB::select($query);

        // prd($credit);

        return collect($credit);
    }

    public function map($res): array
    {


        return [
            $this->counter++,
            $res->loan_demand,
            $res->loan_approved,
            $res->loan_disbursed,



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
                $event->sheet->getStyle('A1:A5')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'color' => ['argb' => '#CCCCCC']
                    ]
                ]);

                $event->sheet->getStyle('A7:E7')->applyFromArray([
                    'font' => ['bold' => true]
                ]);
                
            },
        ];
    }

    public function headings(): array
    {
        $group = '';


        $session_data = Session::get('credit_loan_filter_session');
        if ($session_data != '') {
            if ($session_data['group'] == 'AG') {
                $group = 'Agency';
            }
            if ($session_data['group'] == 'FM') {
                $group = 'Family';
            }
            if ($session_data['group'] == 'FD') {
                $group = 'Federation';
            }
            if ($session_data['group'] == 'CL') {
                $group = 'Cluster';
            }
            if ($session_data['group'] == 'SH') {
                $group = 'SHG';
            }
        }
        if (!empty($session_data)) {
            return [
                ['Country', (getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']) : "-")],
                ['State', (getStateName($session_data['country'], $session_data['state']) != '' ? getStateName($session_data['country'], $session_data['state']) : "-")],
                ['District', (getDistrictName($session_data['state'], $session_data['district']) != '' ? getDistrictName($session_data['state'], $session_data['district']) : "-")],
                ['Name', ($session_data['federation'] != '' ? $session_data['federation'] : "-")],
                ['Group Type', $group],
                [],
                ['S.No', 'Loan Demmand', 'Loan Approved', 'Loan Disbursed']
            ];
        } else {
            return [
                ['Country', (getCountryByID(101))],
                ['State', "-"],
                ['District', "-"],
                ['Name', "-"],
                ['Group Type', "-"],
                [],
                ['S.No', 'Loan Demmand', 'Loan Approved', 'Loan Disbursed']
            ];
        }
    }

    public function title(): string
    {
        return 'Credit_Loan' . pdf_date() . ' ';
    }
}
