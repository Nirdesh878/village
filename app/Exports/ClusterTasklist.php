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


class ClusterTasklist implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        'Cluster' AS TYPE,
        k.uin,
        l.name_of_cluster,
        j.name_of_federation,
        e.name,
        d.agency_name,
        Y.status,
        Y.created_at,
        Y.updated_at,
        Y.task
    FROM
        task_assignment AS Y
    INNER JOIN cluster_mst AS k
    ON
        k.id = Y.assignment_id
    INNER JOIN cluster_sub_mst AS m
    ON
        k.id = m.cluster_mst_id
    INNER JOIN cluster_profile AS l
    ON
        l.cluster_sub_mst_id = m.id
    INNER JOIN federation_mst AS i
    ON
        i.uin = k.federation_uin
    INNER JOIN federation_sub_mst AS n
    ON
        i.id = n.federation_mst_id
    INNER JOIN federation_profile AS j
    ON
        j.federation_sub_mst_id = n.id
    INNER JOIN agency AS d
    ON
        k.agency_id = d.agency_id
    INNER JOIN users AS e
    ON
        Y.user_id = e.id
    WHERE
        Y.is_deleted = 0 AND Y.assignment_type = 'CL'";
        $cluster = DB::select($query);
    // prd($cluster);
        return collect($cluster);
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
            $res->name_of_cluster,
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
                $event->sheet->getStyle('A1:K1')->applyFromArray([
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

            ['S.No','Cluster-UIN','Name','Federation','Facilitator','task','Status','Create','Update']
        ];
    }

    public function title(): string
    {
        return 'ClusterTasklist';
    }
}
