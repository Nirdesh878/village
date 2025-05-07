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


class DartTeam implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        
        $session_data = Session::get('user_filter_session');
        
        $res = [];
        
        $query = "SELECT a.* 
        from 
        users a
        WHERE 
        is_deleted  = 0";
        if (!empty($session_data['Search'])) {
            if(!empty($session_data['user_type']))
                if ($session_data['user_type']!='')
                    $query .= " AND a.u_type  = '" . $session_data['user_type']. "'";
        }
        $users = DB::select($query);
        return collect($users);

    }

    public function map($res): array
    { if($res->u_type == 'M')
        {
            $user_type = 'District Manager';
        }
        if($res->u_type == 'QA')
        {
            $user_type = 'Quality Analyst';
        }
        if($res->u_type == 'F')
        {
            $user_type = 'FACILITATOR';
        }
        if($res->u_type == 'A')
        {
            $user_type = 'Admin';
        }
        if($res->u_type == 'CEO')
        {
            $user_type = 'Super-Admin';
        }
        
        
        return [
           $this->counter++,
            $res->name,
            $res->email,
            $user_type,
            $res->password_show,
            $res->status_inex,
            change_date_month_name_char($res->created_at)
           
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
        $group = '';
        
        return [
            
            ['S.No','Name','Email','User Type','Password','Member Type','Date']
        ];
    }

    public function title(): string
    {
        return 'Dart_Team'.pdf_date().' ';
    }
}
