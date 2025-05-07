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

class Agency_report implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $agency = DB::table('agency as a')
                    ->join('partners as b', 'a.community_or_local_partners','=','b.id')
                    ->join('countries as c','a.country','=','c.id')
                    ->join('states as d','a.state','=','d.id')
                    ->leftjoin('district as e','a.district','=','e.id')
                    ->select('a.*','b.partners_name','c.name as country_name','d.name as state_name','e.name as district_name')
                    ->where('a.is_deleted', '=', 0)
                    ->orderBy('a.created_at','DESC')
                    ->get()->toArray();
        
    

        return collect($agency);


    }

    public function map($res): array
    { 
        
        
        return [
            $this->counter++, 
            $res->agency_name,
            $res->partners_name,
            $res->country_name,
            $res->state_name,
            $res->district_name,
            $res->contact_name,
            $res->contact_email,
            $res->contact_number,
            $res->contact_address,
            
            
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
        $group = '';
        
        return [
            
            ['S.No','Name','Partner Name','Country','State','District ','Contact
            Name','Email','Number','Address']
        ];
    }

    public function title(): string
    {
        return 'Agency'.pdf_date().' ';
    }
}
