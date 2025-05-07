<?php

namespace App\Http\Controllers;

use App\Exports\Family\BasicProfile;
use App\Exports\Family\Assets;
use App\Exports\Family\Goals;
use App\Exports\Family\Challenges;
use App\Exports\Family\Observation;
use App\Exports\Family\Business;
use App\Exports\Family\MemberCommitment;
use App\Exports\Family\Agriculture;
use App\Exports\Family\Horticulture;
use App\Exports\Family\LiveStock;
use App\Exports\Family\FamilyLoans;
use App\Exports\Family\FamilySaving;
use App\Exports\Family\FamilyExpenditures;
use App\Exports\Family\Income;
use App\Exports\Family\Analysis;
use App\Exports\Shg\SHGBasicProfile;
use App\Exports\Shg\SHGGovernance;
use App\Exports\Shg\SHGInclusionBasic;
use App\Exports\Shg\SHGInclusionLoans;
use App\Exports\Shg\SHGInclusionHHsBenefitted;
use App\Exports\Shg\SHGCreditEfficiencyBasic;
use App\Exports\Shg\SHGCreditEfficiencyTraining;
use App\Exports\Shg\SHGCRecoveryCumulativeLoans;
use App\Exports\Shg\SHGCRecoveryHHsBenefitted;
use App\Exports\Shg\SHGCRecoveryDCB;
use App\Exports\Shg\SHGCRecoveryLoanDefault;
use App\Exports\Shg\SHGSavings;
use App\Exports\Shg\SHGAnalysis;
use App\Exports\Shg\SHGChallengesActionPlan;
use App\Exports\Shg\SHGObservation;
use App\Models\Family;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Facades\Session;



class   DataExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->curdate = Carbon::now()->format('d-m-Y');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {

    //     $data = [];
    //     $user = Auth::User();

    //     return view('family_export.list')->with($data);
    // }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function family(Request $request)
    {

        // phpinfo();
        // die();
        $data = [];
        $user = Auth::User();
        if (!empty($request->get('Search'))) {
           Session::put('family_export_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('family_export_session');
        }
        $query = "SELECT * from agency WHERE is_deleted = 0";
        $data['agency'] = DB::select($query);

        return view('DataExport.family')->with($data);
    }


    public function shg_export(Request $request)
    {

        // phpinfo();
        // die();
        $data = [];
        $user = Auth::User();
        if (!empty($request->get('Search'))) {
           Session::put('shg_export_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('shg_export_session');
        }
        $query = "SELECT * from agency WHERE is_deleted = 0";
        $data['agency'] = DB::select($query);

        return view('DataExport.shg')->with($data);
    }




    public function Family_basic_profile(Request $request)
    {
        // prd("kk");
        return Excel::download(new BasicProfile(), 'FamilyBasicProfile_' . pdf_date() . '.xlsx');
    }

    public function Family_assests(Request $request)
    {
        // prd("kk");
        return Excel::download(new Assets(), 'FamilyAssets_' . pdf_date() . '.xlsx');
    }

    public function Family_goals(Request $request)
    {
        // prd("kk");
        return Excel::download(new Goals(), 'FamilyGoals_' . pdf_date() . '.xlsx');
    }

    public function Family_Challenges(Request $request)
    {
        // prd("kk");
        return Excel::download(new Challenges(), 'FamilyChallenges_' . pdf_date() . '.xlsx');
    }

    public function Family_Observation(Request $request)
    {
        // prd("kk");
        return Excel::download(new Observation(), 'FamilyObservation_' . pdf_date() . '.xlsx');
    }

    
    public function Family_Business(Request $request)
    {
        // prd("kk");
        return Excel::download(new Business(), 'FamilyBusiness' . pdf_date() . '.xlsx');
    }

    public function Family_Commitment(Request $request)
    {
        // prd("kk");
        return Excel::download(new MemberCommitment(), 'FamilyMemberCommitment' . pdf_date() . '.xlsx');
    }
    public function Family_Agriculture(Request $request)
    {
        // prd("kk");
        return Excel::download(new Agriculture(), 'FamilyAgriculture' . pdf_date() . '.xlsx');
    }

    public function Family_Horticulture(Request $request)
    {
        // prd("kk");
        return Excel::download(new Horticulture(), 'FamilyHorticulture' . pdf_date() . '.xlsx');
    }

    public function Family_LiveStock(Request $request)
    {
        // prd("kk");
        return Excel::download(new LiveStock(), 'FamilyLiveStock' . pdf_date() . '.xlsx');
    }

    public function Family_Loans(Request $request)
    {
        // prd("kk");
        return Excel::download(new FamilyLoans(), 'FamilyLoans' . pdf_date() . '.xlsx');
    }

    public function Family_Savings(Request $request)
    {
        // prd("kk");
        return Excel::download(new FamilySaving(), 'FamilySavings' . pdf_date() . '.xlsx');
    }

    public function Family_Expenditure(Request $request)
    {
        // prd("kk");
        return Excel::download(new FamilyExpenditures(), 'FamilyExpenditure' . pdf_date() . '.xlsx');
    }

    public function Family_income(Request $request)
    {
        // prd("kk");
        return Excel::download(new Income(), 'FamilyIncome' . pdf_date() . '.xlsx');
    }

    public function Family_analysis(Request $request)
    {
        // prd("kk");
        return Excel::download(new Analysis(), 'FamilyAnalysis' . pdf_date() . '.xlsx');
    }


    public function shg_basic_profile(Request $request)
    {
        // prd("kk");
        return Excel::download(new SHGBasicProfile(), 'SHGBasicProfile_' . pdf_date() . '.xlsx');
    }

    
    public function shg_governance(Request $request)
    {
        // prd("kk");
        return Excel::download(new SHGGovernance(), 'SHGGovernance_' . pdf_date() . '.xlsx');
    }
   
    public function shg_inclusion_besic(Request $request)
    {
        // prd("kk");
        return Excel::download(new SHGInclusionBasic(), 'SHGInclusionBasic_' . pdf_date() . '.xlsx');
    }

    public function shg_inclusion_loans(Request $request)
    {
        // prd("kk");
        return Excel::download(new SHGInclusionLoans(), 'SHGInclusionLoans_' . pdf_date() . '.xlsx');
    }

    public function shg_inclusion_hhs_benefitted(Request $request)
    {
        // prd("kk");
        return Excel::download(new SHGInclusionHHsBenefitted(), 'SHGInclusionHHsBenefitted_' . pdf_date() . '.xlsx');
    }
    public function shg_credit_efficiency_basic(Request $request)
    {
        // prd("kk");
        return Excel::download(new SHGCreditEfficiencyBasic(), 'SHGCreditEfficiencyBasic_' . pdf_date() . '.xlsx');
    }
    public function shg_credit_efficiency_training(Request $request)
    {
        // prd("kk");
        return Excel::download(new SHGCreditEfficiencyTraining(), 'SHGCreditEfficiencyTraining_' . pdf_date() . '.xlsx');
    }
    
    public function shg_crecovery_cumulative_loans(Request $request)
    {
        return Excel::download(new SHGCRecoveryCumulativeLoans(), 'SHGCRecoveryCumulativeLoans_' . pdf_date() . '.xlsx');
    }
    
    public function shg_crecovery_hhs_benefitted(Request $request)
    {
        return Excel::download(new SHGCRecoveryHHsBenefitted(), 'SHGCRecoveryHHsBenefitted_' . pdf_date() . '.xlsx');
    }
    public function shg_crecovery_dcb(Request $request)
    {
        return Excel::download(new SHGCRecoveryDCB(), 'SHGCRecoveryDCB_' . pdf_date() . '.xlsx');
    }

    public function shg_crecovery_loan_default(Request $request)
    {
        return Excel::download(new SHGCRecoveryLoanDefault(), 'SHGCRecoveryLoanDefault_' . pdf_date() . '.xlsx');
    }
    public function shg_savings(Request $request)
    {
        return Excel::download(new SHGSavings(), 'SHGSavings_' . pdf_date() . '.xlsx');
    }
    public function shg_analysis(Request $request)
    {
        return Excel::download(new SHGAnalysis(), 'SHGAnalysis_' . pdf_date() . '.xlsx');
    }

    public function shg_challenges_action_plan(Request $request)
    {
        return Excel::download(new SHGChallengesActionPlan(), 'SHGChallengesActionPlan_' . pdf_date() . '.xlsx');
    }
    
    public function shg_observation(Request $request)
    {
        return Excel::download(new SHGObservation(), 'SHGObservation_' . pdf_date() . '.xlsx');
    }

    public function cluster_export(Request $request)
    {

        $data = [];
        $user = Auth::User();
        if (!empty($request->get('Search'))) {
           Session::put('cluster_export_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('cluster_export_session');
        }
        $query = "SELECT * from agency WHERE is_deleted = 0";
        $data['agency'] = DB::select($query);

        return view('DataExport.cluster')->with($data);
    }

    public function federation_export(Request $request)
    {

        $data = [];
        $user = Auth::User();
        if (!empty($request->get('Search'))) {
           Session::put('federation_export_session', $request->all());
        }
        if (!empty($request->get('clear'))) {
            $request->session()->forget('federation_export_session');
        }
        $query = "SELECT * from agency WHERE is_deleted = 0";
        $data['agency'] = DB::select($query);

        return view('DataExport.federation')->with($data);
    }

    

    
    
    
    







}
