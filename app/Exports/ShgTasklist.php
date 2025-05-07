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

class ShgTasklist implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $query = "SELECT
        'SHG' AS TYPE,
        i.uin,
        j.shgName,
        l.name_of_cluster,
        jj.name_of_federation,
        d.agency_name,
        e.name,
        Y.status,
        Y.created_at,
        Y.updated_at,
        Y.task
    FROM
        task_assignment AS Y
    INNER JOIN shg_mst AS i
    ON
        i.id = Y.assignment_id
    INNER JOIN shg_sub_mst AS m
    ON
        i.id = m.shg_mst_id
    INNER JOIN shg_profile AS j
    ON
        j.shg_sub_mst_id = m.id
    LEFT JOIN cluster_mst AS k
    ON
        k.uin = i.cluster_uin
    LEFT JOIN cluster_sub_mst AS n
    ON
        k.id = n.cluster_mst_id
    LEFT JOIN cluster_profile AS l
    ON
        l.cluster_sub_mst_id = n.id
    INNER JOIN federation_mst AS ii
    ON
        ii.uin = i.federation_uin
    INNER JOIN federation_sub_mst AS nn
    ON
        ii.id = nn.federation_mst_id
    INNER JOIN federation_profile AS jj
    ON
        jj.federation_sub_mst_id = nn.id
    INNER JOIN agency AS d
    ON
        i.agency_id = d.agency_id
    INNER JOIN users AS e
    ON
        Y.user_id = e.id
    WHERE
        Y.is_deleted = 0 AND Y.assignment_type = 'SH'";
        $shg = DB::select($query);
    // prd($shg);
        return collect($shg);
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
            $res->shgName,
            $res->name_of_cluster !='' ? $res->name_of_cluster : 'N/A' ,
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
                $event->sheet->getStyle('A1:L1')->applyFromArray([
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

            ['S.No','SHG-UIN','Name','Cluster','Federation','Facilitator','task','Status','Create','Update']
        ];
    }

    public function title(): string
    {
        return 'ShgTasklist';
    }
}
