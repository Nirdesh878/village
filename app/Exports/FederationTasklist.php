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
// use Maatwebsite\Excel\Concerns\WithDrawings;
// use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class FederationTasklist implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $query = " SELECT
        'Federation' AS TYPE,
        i.uin,
        j.name_of_federation,
        d.agency_name,
        e.name,
        Y.status,
        Y.created_at,
        Y.updated_at,
        Y.task
    FROM
        task_assignment AS Y
    INNER JOIN federation_mst AS i
    ON
        i.id = Y.assignment_id
    INNER JOIN federation_sub_mst AS k
    ON
        i.id = k.federation_mst_id
    INNER JOIN federation_profile AS j
    ON
        j.federation_sub_mst_id = k.id
    INNER JOIN agency AS d
    ON
        i.agency_id = d.agency_id
    INNER JOIN users AS e
    ON
        Y.user_id = e.id
    WHERE
        Y.is_deleted = 0 AND Y.assignment_type = 'FD'";
        $federations = DB::select($query);
    // prd($federations);
        return collect($federations);
    }

    public function map($res): array
    {
        if($res->status == 'P')
        {
            $status = 'Pending';
        }
        if($res->status == 'D')
        {
            $status = 'Done';
        }
        if($res->status == 'R')
        {
            $status = 'Reject';
        }
         if($res->task == 'A')
         {
             $task='Analytics';
         }
         else{
             $task='Rating';
         }
            
        return [
            $this->counter++,
            $res->uin,
            $res->name_of_federation,
            $res->name,
            $task,
            $status,
            change_date_month_name_char(str_replace('/','-',$res->created_at)),
            change_date_month_name_char(str_replace('/','-',$res->updated_at)),
          
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
                $event->sheet->getStyle('A1:H1')->applyFromArray([
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

            ['S.No','Federation-UIN','Name','Facilitator','task','Status','Create','Update']
        ];
    }

    public function title(): string
    {
        return 'FederationTasklist';
    }
}
