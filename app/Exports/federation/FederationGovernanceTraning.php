<?php
namespace App\Exports\federation;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;



class FederationGovernanceTraning implements WithMultipleSheets
{
    public $curdate = '';
    public $counter = 1;

    public function __construct()
    {
        $this->curdate = Carbon::now()->format('d-m-Y');
    }
    use Exportable;
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new FederationBookTraning;

        $sheets[] = new FederationSACTraning;

        $sheets[] = new FederationLeaderTraning;







        return $sheets;
    }


    public function title(): string
    {
        return 'Federation Governance Training';
    }


}
