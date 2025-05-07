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

class CreditReport implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $session_data = Session::get('credit_filter_session');
        $res = [];
        $query = "SELECT
                    Y.uin,
                    X.id as sub_mst,
                    t.fp_member_name as name,
                    t.fp_spouse_name as husband,
                    t.fp_aadhar_no as adhar,
                    t.fp_wealth_rank,
                    t.analysis_rating,
                    h.name_of_federation,
                    b.name_of_cluster,
                    j.shgName,
                    d.agency_name,
                    xy.principal as loan1,
                    xy.loan_tenure as tenure1,
                    xy.tenure_mode,
                    xx.get_loan,
                    xx.disbursement_date,
                    xx.loan_amount as disb_loan,
                    xx.loan_purpose as disb_purpose,
                    xx.repayment_mode as disb_mode,
                    xx.loan_duration as disb_duration,
                    xx.no_installments,
                    yx.get_verified,
                    yx.uloan_amount,
                    yx.uloan_purpose,
                    yx.urepayment_mode,
                    yx.uloan_duration,
                    yx.uloan_installments,
                    zx.type_of_business
                FROM
                    family_mst AS Y
                INNER JOIN family_sub_mst AS X
                ON
                    Y.id = X.family_mst_id
                INNER JOIN family_profile AS t
                ON
                    X.id = t.family_sub_mst_id
                INNER JOIN family_loan_repayment AS xy
                ON
                    X.id = xy.family_sub_mst_id
                INNER JOIN family_loan_disbursement AS xx
                ON
                    X.id = xx.family_sub_mst_id
                INNER JOIN family_loan_approvel AS yx
                ON
                    X.id = yx.family_sub_mst_id
                INNER JOIN family_business_investment_plan as zx
                ON
                    X.id = zx.family_sub_mst_id
                INNER JOIN shg_mst AS i
                ON
                    i.uin = Y.shg_uin
                INNER JOIN shg_sub_mst AS w
                ON
                    i.id = w.shg_mst_id
                INNER JOIN shg_profile AS j
                ON
                    j.shg_sub_mst_id = w.id
                LEFT JOIN cluster_mst AS a
                ON
                    i.cluster_uin = a.uin
                LEFT JOIN cluster_sub_mst AS v
                ON
                    a.id = v.cluster_mst_id
                LEFT JOIN cluster_profile AS b
                ON
                    b.cluster_sub_mst_id = v.id
                INNER JOIN federation_mst AS c
                ON
                    i.federation_uin = c.uin
                INNER JOIN federation_sub_mst AS u
                ON
                    c.id = u.federation_mst_id
                INNER JOIN federation_profile AS h
                ON
                    h.federation_sub_mst_id = u.id
                INNER JOIN agency AS d
                ON
                    Y.agency_id = d.agency_id
                WHERE
                    Y.is_deleted = 0 AND X.qa_p2='V' AND X.locked=1 ";
                if (!empty($session_data['Search'])) {
                    if (!empty($session_data['state']))
                        if ($session_data['state'] != '' && $session_data['state'] > 0)
                            $query .= " AND t.fp_state_id = '".$session_data['state']."' ";
                    if (!empty($session_data['district']))
                        if ($session_data['district'] != '' && $session_data['district'] > 0)
                            $query .= " AND t.fp_district_id = '".$session_data['district']."' ";
                    if (!empty($session_data['country']))
                        if ($session_data['country'] != '' && $session_data['country'] > 0)
                            $query .= " AND t.fp_country_id = '".$session_data['country']."' ";
                    if (!empty($session_data['federation'])) {
                            $text_search = $session_data['federation'];
                            if($session_data['group'] == 'AG')
                            {
                                $query .= " AND ( d.agency_name like '%".$text_search."%' )";
                            }
                            if($session_data['group'] == 'FM')
                            {
                                $query .= " AND ( t.fp_member_name like '%".$text_search."%' )";
                            }
                            if($session_data['group'] == 'SH')
                            {
                                $query .= " AND ( j.shgName like '%".$text_search."%' )";
                            }
                            if($session_data['group'] == 'CL')
                            {
                                $query .= " AND ( b.name_of_cluster like '%".$text_search."%' )";
                            }
                            if($session_data['group'] == 'FD')
                            {
                                $query .= " AND ( h.name_of_federation like '%".$text_search."%' )";
                            }
                    }
                }

            $query .= " ORDER BY t.analysis_rating DESC ";
            $credit_result = DB::select($query);


        return collect($credit_result);

    }

    public function map($res): array
    {
        if($res->tenure_mode == 1)
        {
            $loan_duration = $res->tenure1.'Year';
        }
        else
        {
            $loan_duration = $res->tenure1.'Month';
        }
        if ($res->tenure_mode == 1) {
            $loan_tenure = 12 * $res->tenure1;
        } else {
        $loan_tenure = $res->tenure1;
        }

        if($res->get_verified == 'Verified')
        {
            $u_loan = $res->uloan_amount;
            $u_purpose = $res->uloan_purpose;
            $u_repayment = $res->urepayment_mode;
            $u_duration = $res->uloan_duration;
            $u_installment = $res->uloan_installments;
        }
        else{
            $u_loan = '-';
            $u_purpose = '-';
            $u_repayment = '-';
            $u_duration = '-';
            $u_installment = '-';
        }
        $loan_disbursement_date = change_date_month_name_char(str_replace('/','-',$res->disbursement_date));
        if($res->get_loan == 'Yes')
        {

            $disb_date = $loan_disbursement_date;
            $disb_loan = $res->disb_loan;
            $disb_purpose = $res->disb_purpose;
            $disb_mode = $res->disb_mode;
            $disb_duration = $res->disb_duration;
            $no_installments = $res->no_installments;
        }
        else{
            $disb_date = '-';
            $disb_loan = '-';
            $disb_purpose = '-';
            $disb_mode = '-';
            $disb_duration = '-';
            $no_installments = '-';
        }
        //$loan_mode = $res->tenure_mode == 1 ? 'Yearly' : 'Monthly';
        return [
            $this->counter++,
            $res->uin,
            $res->name,
            $res->husband,
            aadhar($res->adhar),
            $res->shgName,
            $res->name_of_cluster,
            $res->name_of_federation,
            $res->analysis_rating,
            $res->loan1,
            $res->type_of_business,
            $res->tenure_mode == 1 ? 'Yearly' : 'Monthly',
            $loan_duration,
            $loan_tenure,
            $res->get_verified,
            $u_loan,
            $u_purpose,
            $u_repayment,
            $u_duration,
            $u_installment,
            $res->get_loan,
            $loan_disbursement_date,
            $disb_loan,
            $disb_purpose,
            $disb_mode,
            $disb_duration,
            $no_installments,
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




                $event->sheet->getStyle('A1:A4')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'color' => array('rgb' => '249, 214, 249')
                    ]
                ]);

                $event->sheet->getStyle('A6:M6')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                   'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'dff0d8',
                         ]
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
                $event->sheet->getStyle('N6:S6')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                   'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'dff0d8',
                         ]
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],

                ]);
                $event->sheet->getStyle('T6:Z6')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'dff0d8',
                         ]
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],

                ]);


                $event->sheet->getStyle('A8:H8')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                $event->sheet->getStyle('I8:M8')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'dff0d8',
                         ]
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
                $event->sheet->getStyle('N8:S8')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'dff0d8',
                         ]
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
                $event->sheet->getStyle('T8:Z8')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'dff0d8',
                         ]
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A10:Z10')->applyFromArray([
                    'font' => ['bold' => true],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);


                $event->sheet->mergeCells('A6:M6',);
                $event->sheet->mergeCells('N6:S6',);
                $event->sheet->mergeCells('T6:Z6',);
                $event->sheet->mergeCells('A8:H8',);
                $event->sheet->mergeCells('I8:M8',);

                $event->sheet->mergeCells('N8:S8',);
                $event->sheet->mergeCells('T8:Z8',);
                $event->sheet->getDelegate()->getStyle('A11:Z11')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

               
            },
        ];
    }

    public function headings(): array
    {
        $session_data = Session::get('credit_filter_session');
        if (!empty($session_data)){
            return [
                ['Country',(getCountryByID($session_data['country']) != '' ? getCountryByID($session_data['country']):getCountryByID(101))],
                ['State',(getStateName($session_data['country'],$session_data['state']) != '' ? getStateName($session_data['country'],$session_data['state']):"-")],
                ['District',(getDistrictName($session_data['state'],$session_data['district']) != '' ? getDistrictName($session_data['state'],$session_data['district']):"-")],
                ['Name',($session_data['federation'] != '' ? $session_data['federation']: "-")],
                [],
                ['Section 1 - Credit Requirement Details ','','','','','','','','','','','','','Section 2 - Final Loan Approval detailsSection 2 - Final Loan Approval details','','','','','','Section 3 - AFTER DISBURSEMENT'],
                [],
                ['','','','','','','','','1st REQUESTED LOAN','','','','','Changes to 1st loan','','','','','','Final changes in loan no. 1'],
                [],
                ['S.No','UIN','SHG Member Name','Husband Name','Adhar Card No','SHG Name','Cluster Name','Federation Name','Score','Amount','Purpose','Repayment Mode','Duration','Installment','Reviewed/verified','Amount','Purpose','Repayment Mode','Duration','Installment','Get Loan','Date','Amount','Purpose','Repayment Mode','Duration','Installment']
            ];
        }
        else{
            return [
                ['Country',(getCountryByID(101))],
                ['State',"-"],
                ['District',"-"],
                ['Name',"-"],
                [],
                ['Section 1 - Credit Requirement Details ','','','','','','','','','','','','','Section 2 - Final Loan Approval detailsSection 2 - Final Loan Approval details','','','','','','Section 3 - AFTER DISBURSEMENT'],
                [],
                ['','','','','','','','','1st REQUESTED LOAN','','','','','Changes to 1st loan','','','','','','Final changes in loan no. 1'],
                [],
                ['S.No','UIN','SHG Member Name','Husband Name','Adhar Card No','SHG Name','Cluster Name','Federation Name','Score','Amount','Purpose','Repayment Mode','Duration','Installment','Reviewed/verified','Amount','Purpose','Repayment Mode','Duration','Installment','Get Loan','Date','Amount','Purpose','Repayment Mode','Duration','Installment']

            ];
        }
    }

    public function title(): string
    {
        return 'CreditReport_'.pdf_date().' ';
    }
}
