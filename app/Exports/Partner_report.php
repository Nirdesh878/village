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


class Partner_report implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
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
        $partner= DB::table('partners as a')
                            ->leftjoin('countries as c', 'a.country_id', '=', 'c.id')
                            ->select('a.*', 'c.name as country_name')
                            ->where('a.is_deleted', '=', 0)
                            ->orderBy('a.created_at', 'DESC')
                            ->get()->toArray();
        
    

        return collect($partner);


    }

    public function map($res): array
    { 
        
        
        
        
        return [
           $this->counter++, 
            $res->partners_name,
            $res->contact_person,
            $res->country_name,
            $res->email,
            $res->contact_number,
            $res->address,
           
            
            
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
            
            ['S.No','Name','Conttact Person','Country','Email','Number','Address']
        ];
    }

    public function title(): string
    {
        return 'Partner'.pdf_date().' ';
    }
}
