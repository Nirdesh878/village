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
use App\Exports\Shg\SHGParameterWiseAnalysis;
use App\Exports\federation\FederationBasicInformation;
use App\Exports\federation\FederationGovernance;
use App\Exports\federation\FederationGovernanceTraning;
use App\Exports\federation\FederationInclusionBasic;
use App\Exports\federation\FederationInclusionLoans;
use App\Exports\federation\FederationInclusionHHsBenifitted;
use App\Exports\federation\FederationCreditHistoryBasic;
use App\Exports\federation\FederationCreditDCB;
use App\Exports\federation\FederationCreditLoanDefaultInternate;
use App\Exports\federation\FederationSustainability;
use App\Exports\federation\FederationRiskMigration;
use App\Exports\federation\FederationChallengesAction;
use App\Exports\federation\FederationObservations;
use App\Exports\federation\FederationAnalysis;
use App\Exports\federation\FederationParameterWiseAnalysis;
use App\Exports\federation\FederationEfficiency;
use App\Exports\federation\FederationCreditPurposeRotationVel;
use App\Exports\Cluster\ClusterBasicInformation;
use App\Exports\Cluster\ClusterGovernance;
use App\Exports\Cluster\ClusterInclusionBasic;
use App\Exports\Cluster\ClusterInclusionLoans;
use App\Exports\Cluster\ClsusterEfficiency;
use App\Exports\Cluster\ClusterSavings;
use App\Exports\Cluster\ClusterChallengesActions;
use App\Exports\Cluster\ClusterEfficiencySACTraining;
use App\Exports\Cluster\CurrentLeadTraining;
use App\Exports\Cluster\ClusterEfficiencyBookkeeperTraining;
use App\Exports\Cluster\ClusterAnalysis;
use App\Exports\Cluster\ClusterParameterWiseAnalysis;
use App\Exports\Cluster\ClusterZeroLoansReceived;
use App\Exports\Cluster\ClusterCumulativeloans;
use App\Exports\Cluster\ClusterObservation;
use App\Exports\Cluster\ClusterDCB;
use App\Exports\Cluster\ClusterLoanDefault;
use App\Exports\Cluster\ClusterInclusionHHsBenifitted;











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
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
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
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
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



    // Family exports

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


    // shg exports

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

    public function shg_ParameterWise_analysis(Request $request)
    {
        return Excel::download(new SHGParameterWiseAnalysis(), 'SHGParameterWiseAnalysis_' . pdf_date() . '.xlsx');
    }

    // federation

    public function federation_export(Request $request)
    {

        $data = [];
        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
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

    public function federation_basic_profile(Request $request)
    {
        return Excel::download(new FederationBasicInformation(), 'FederationBasicInformation_' . pdf_date() . '.xlsx');
    }

    public function federation_governance(Request $request)
    {
        return Excel::download(new FederationGovernance(), 'FederationGovernance_' . pdf_date() . '.xlsx');
    }

    public function federation_governance_traning(Request $request)
    {
        return Excel::download(new FederationGovernanceTraning(), 'FederationGovernanceTraning_' . pdf_date() . '.xlsx');
    }

    public function federation_inclusion_basic(Request $request)
    {
        return Excel::download(new FederationInclusionBasic(), 'FederationInclusionBasic_' . pdf_date() . '.xlsx');
    }
    public function federation_inclusion_loans(Request $request)
    {
        return Excel::download(new FederationInclusionLoans(), 'FederationInclusionLoans_' . pdf_date() . '.xlsx');
    }


    public function federation_inclusion_hhs_benifited(Request $request)
    {
        return Excel::download(new FederationInclusionHHsBenifitted(), 'FederationInclusionHHsBenifitted_' . pdf_date() . '.xlsx');
    }

     public function federation_efficiency(Request $request)
    {
        return Excel::download(new FederationEfficiency(), 'FederationEfficiency_' . pdf_date() . '.xlsx');
    }

    public function federation_credit_history_basic(Request $request)
    {
        return Excel::download(new FederationCreditHistoryBasic(), 'FederationCreditHistoryBasic_' . pdf_date() . '.xlsx');
    }

     public function federation_credit_dcb(Request $request)
    {
        return Excel::download(new FederationCreditDCB(), 'FederationCreditDCB_' . pdf_date() . '.xlsx');
    }

    public function federation_credit_loan_default_internate(Request $request)
    {
        return Excel::download(new FederationCreditLoanDefaultInternate(), 'FederationCreditLoanDefaultInternate_' . pdf_date() . '.xlsx');
    }

    public function federation_credit_perpose_rotation_vel(Request $request)
    {
        return Excel::download(new FederationCreditPurposeRotationVel(), 'FederationCreditPurposeRotationVel_' . pdf_date() . '.xlsx');
    }

    public function federation_sustainability(Request $request)
    {
        return Excel::download(new FederationSustainability(), 'FederationSustainability_' . pdf_date() . '.xlsx');
    }

    public function federation_risk_migration(Request $request)
    {
        return Excel::download(new FederationRiskMigration(), 'FederationRiskMigration_' . pdf_date() . '.xlsx');
    }

    public function federation_challenges_action(Request $request)
    {
        return Excel::download(new FederationChallengesAction(), 'FederationChallengesAction_' . pdf_date() . '.xlsx');
    }

    public function federation_observations(Request $request)
    {
        return Excel::download(new FederationObservations(), 'FederationObservations_' . pdf_date() . '.xlsx');
    }

    public function federation_analysis(Request $request)
    {
        return Excel::download(new FederationAnalysis(), 'FederationAnalysis_' . pdf_date() . '.xlsx');
    }
    public function federation_parameter_wise_analysis(Request $request)
    {
        return Excel::download(new FederationParameterWiseAnalysis(), 'FederationParameterWiseAnalysis_' . pdf_date() . '.xlsx');
    }



    //   cluster

    public function cluster_export(Request $request)
    {

        $data = [];
        $user = Auth::User();
        if($user->u_type == 'M' || $user->u_type == 'QA'){
            return redirect('qualitycheck')->with('error', 'You do not have access to this page.');
         }
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


    public function cluster_basic_profile(Request $request)
    {

        return Excel::download(new ClusterBasicInformation(), 'ClusterBasicInformation_' . pdf_date() . '.xlsx');
    }

    public function cluster_governance(Request $request)
    {

        return Excel::download(new ClusterGovernance(), 'ClusterGovernance_' . pdf_date() . '.xlsx');
    }

    public function cluster_inclusion_basic(Request $request)
    {

        return Excel::download(new ClusterInclusionBasic(), 'ClusterInclusionBasic_' . pdf_date() . '.xlsx');
    }

    public function cluster_inclusion_loans(Request $request)
    {

        return Excel::download(new ClusterInclusionLoans(), 'ClusterInclusionLoans_' . pdf_date() . '.xlsx');
    }
    public function cluster_efficiency_basic(Request $request)
    {

        return Excel::download(new ClsusterEfficiency(), 'ClsusterEfficiency_' . pdf_date() . '.xlsx');
    }
    public function cluster_savings(Request $request)
    {

        return Excel::download(new ClusterSavings(), 'ClusterSavings_' . pdf_date() . '.xlsx');
    }

    public function Cluster_Challenges(Request $request)
    {

        return Excel::download(new ClusterChallengesActions(), 'ClusterChallengesActions_' . pdf_date() . '.xlsx');
    }

    public function Cluster_sac_training(Request $request)
    {

        return Excel::download(new ClusterEfficiencySACTraining(), 'ClusterEfficiencySACTraining_' . pdf_date() . '.xlsx');
    }

    public function Cluster_lead_training(Request $request)
    {

        return Excel::download(new CurrentLeadTraining(), 'CurrentLeadTraining_' . pdf_date() . '.xlsx');
    }

    public function Cluster_book_training(Request $request)
    {

        return Excel::download(new ClusterEfficiencyBookkeeperTraining(), 'ClusterEfficiencyBookkeeperTraining_' . pdf_date() . '.xlsx');
    }

    public function Cluster_analysis(Request $request)
    {

        return Excel::download(new ClusterAnalysis(), 'ClusterAnalysis_' . pdf_date() . '.xlsx');
    }

    public function Cluster_Parameter_analysis(Request $request)
    {

        return Excel::download(new ClusterParameterWiseAnalysis(), 'ClusterParameterWiseAnalysis_' . pdf_date() . '.xlsx');
    }
    public function cluster_zero_loan(Request $request)
    {

        return Excel::download(new ClusterZeroLoansReceived(), 'ClusterZeroLoansReceived_' . pdf_date() . '.xlsx');
    }

    public function Cluster_cumulative_loans(Request $request)
    {

        return Excel::download(new ClusterCumulativeloans(), 'ClusterCumulativeloans_' . pdf_date() . '.xlsx');
    }

    public function cluster_observation(Request $request)
    {

        return Excel::download(new ClusterObservation(), 'ClusterObservation_' . pdf_date() . '.xlsx');
    }
    public function cluster_DCB(Request $request)
    {

        return Excel::download(new ClusterDCB(), 'ClusterDCB_' . pdf_date() . '.xlsx');
    }

    public function cluster_loan_default(Request $request)
    {

        return Excel::download(new ClusterLoanDefault(), 'ClusterLoanDefault_' . pdf_date() . '.xlsx');
    }

    public function cluster_inclusion_hhs_benefitted(Request $request)
    {

        return Excel::download(new ClusterInclusionHHsBenifitted(), 'ClusterInclusionHHsBenifitted_' . pdf_date() . '.xlsx');
    }


}
