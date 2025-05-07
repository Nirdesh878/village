<?php

namespace App\Exports;

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
use Carbon\Carbon;
class ManagerWiseReportExport implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
{
    public $curdate = '';
    public $counter = 1;
    public function __construct()
    {

        $this->curdate = Carbon::now()->format('d-m-Y');
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::user();
        
        $res = [];
        $main_query_where = '';
        $query = "SELECT
        a.id,
        a.name AS quality,
        b.total,
        b.done_task,
        b.Pending_task
    FROM
        (
            (
            SELECT NAME
                ,
                id
            FROM
                users
            WHERE
                u_type = 'M' AND is_deleted = 0
        ) a
    LEFT JOIN(
        SELECT
            a.verified_by,
            COUNT(*) AS total,
            SUM(
                CASE WHEN(
                    a.qa_status = 'V' OR a.qa_status = 'R'
                ) THEN 1 ELSE 0
            END
    ) AS done_task,
    SUM(
        CASE WHEN a.qa_status = 'P' THEN 1 ELSE 0
    END
        ) AS Pending_task,
        is_deleted
    FROM
        task_qa_assignment a
    INNER JOIN(
        SELECT
            assignment_id,
            MAX(id) AS ids,
            assignment_type
        FROM
            task_qa_assignment
        WHERE
            is_deleted = 0
        GROUP BY
            assignment_type,
            assignment_id
        ORDER BY
            assignment_type
    ) b
    ON
        a.id = b.ids
    WHERE
        a.verified_by != 0 AND a.is_deleted = 0
    GROUP BY
        a.verified_by
    ) b
    ON
        a.id = b.verified_by
    )";

            $result = DB::select($query);
            //prd($result);

        return collect($result);

    }

    public function map($res): array
    {
        //prd($res);
        return [
            $this->counter++, 
            $res->quality,
            $res->total != '' ? $res->total : '0',
            $res->done_task != '' ? $res->done_task : '0',
            $res->Pending_task != '' ? $res->Pending_task : '0',
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
                $event->sheet->getStyle('A1:G1')->applyFromArray([
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
            
            ['S.No','District Manager','Total Task Assigned ','Total Task Completed','Total Task Pending ']
        ];
    }

    public function title(): string
    {
        return 'Manager_Wise_Report_'.pdf_date().' ';
    }
}
