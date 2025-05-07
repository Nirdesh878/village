<?php
namespace App\Exports\federation;
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


class FederationSustainability implements WithHeadings, ShouldAutoSize, WithEvents, WithTitle, FromCollection, WithColumnFormatting, WithMapping
{

    public $curdate = '';
    public $counter = 1;
    public function __construct()
    {
        $this->curdate = Carbon::now()->format('d-m-Y');
    }

    public function collection()
    {
        // prd("sustainability");
        $user = Auth::user();
        $session_data = Session::get('federation_export_session');
        // prd($session_data);

        $query = "SELECT
        fedp.id,
        fed.uin AS uin ,
        fedp.name_of_federation ,
        fedp.analysis_rating AS risk_rating,
        fedp.clf_code AS NRLM_code,
        fedp.name_of_district AS district_name,
        fedp.name_of_state AS state_name,
        ag.agency_name ,

        feds.*,
        JSON_UNQUOTE(JSON_EXTRACT(feds.Federation_Sustainability_Service, '$[0].service_name')) AS service_name_1,
        JSON_UNQUOTE(JSON_EXTRACT(feds.Federation_Sustainability_Service, '$[1].service_name')) AS service_name_2,
        JSON_UNQUOTE(JSON_EXTRACT(feds.Federation_Sustainability_Service, '$[2].service_name')) AS service_name_3,
        JSON_UNQUOTE(JSON_EXTRACT(feds.Federation_Sustainability_Service, '$[3].service_name')) AS service_name_4,
        JSON_UNQUOTE(JSON_EXTRACT(feds.Federation_Sustainability_Service, '$[4].service_name')) AS service_name_5
     FROM
         federation_mst AS fed
          INNER JOIN federation_profile AS fedp
          ON fed.id = fedp.federation_sub_mst_id
          INNER JOIN agency AS ag
          ON fed.agency_id = ag.agency_id
          INNER JOIN federation_sustainability AS feds
          ON fed.id = feds.federation_sub_mst_id

          WHERE fed.is_deleted = 0";

          if(!empty($session_data['Search'])){
            if(!empty($session_data['agency'])){
                $agency = $session_data['agency'];
                $query .=" AND fed.agency_id = $agency  ";
             }
             if(!empty($session_data['federation'])){
                $query .=" AND fed.uin = '" . $session_data['federation'] . "' ";
             }

          }

          $federation = DB::select($query);
        //  prd($federation);
        return collect($federation);
    }

    public function map($res): array
    {


            return [
                $this->counter++,
                $res->uin,
                $res->name_of_federation,
                $res->risk_rating,
                $res->NRLM_code,
                $res->district_name,
                $res->state_name,
                $res->agency_name,

        (string)$res->have_loan_security_fund,
        (string)$res->date_it_was_established,
        (string)$res->members_contribute_LSF,
        (string)$res->amount_available_security_fund,
        (string)$res->members_benefited_by_LSF,
        (string)$res->cumulative_savings_compulsory,
        (string)$res->amount_saved_compulsory,
        (string)$res->cumulative_savings_voluntary,
        (string)$res->amount_saved_voluntary,
        (string)$res->cumulative_savings_other,
        (string)$res->amount_saved_other,
        (string)$res->provide_any_other_Service,
        (string)$res->service_name_1,
        (string)$res->service_name_2,
        (string)$res->service_name_3,
        (string)$res->service_name_4,
        (string)$res->service_name_5,




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
                $event->sheet->getStyle('A1:Z1')->applyFromArray([
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

            ['S.No',
            'UIN',
            'Name Of Federation',
            'Risk Rating',
            'NRLM Code ',
            'District Name',
            'State Name',
            'Agency Name',

            'Loan Security Fund (LSF) -whether it is in Operation',
            'Date LSF was established',
            'No of SHG members contribute to LSF',
            'Amount available in Loan Security Fund',
            'No of Members benefitted by LSF',
            'Compulsory savings -Cumulative savings of all SHGs upto date',
            'Amount of compulsory savings saved during last 12 months',
            'Voluntary savings -cumulative savings of all SHGs upto daate',
            'Amount of voluntary savings saved during last 12 months',
            'Other savings - cumulative savings of all SHGs upto date',
            'Other savings amount saved during last 12 months',
            'Other services Provided by Federation (yes/No)',
            'Name of services (1)',
            'Name of Services 2',
            'Name of Services 3',
            'Name of Services 4',
            'Name of services 5'
            ]
        ];
    }

    public function title(): string
    {
        return 'Federation Sustainability';
    }
}
