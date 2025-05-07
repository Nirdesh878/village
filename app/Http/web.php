<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\FederationController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\ShgController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\PreanalyticsController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\QualityCheckController;
use App\Http\Controllers\fedReportsController;
use App\Http\Controllers\ClusterReportController;
use App\Http\Controllers\CummulativeReportController;
use App\Http\Controllers\FamilyWealthReportController;
use App\Http\Controllers\FacilitatorWiseReportController;
use App\Http\Controllers\CreditReportController;
use App\Http\Controllers\CreditLoanReportController;
use App\Http\Controllers\ProcessStepReportController;

use App\Http\Controllers\ManagerWiseController;
use App\Http\Controllers\QualityWiseController;
use App\Http\Controllers\CreationController;
use App\Http\Controllers\FacilitatorController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LockedController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\logsController;
use App\Http\Controllers\AuthOtpController;
use App\Http\Middleware\CheckOtp;
use App\Http\Controllers\MailShootController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

// Route::get('/', ['middleware' => 'guest', function () {
//     return view('auth.login');
// }]);
Route::middleware([CheckOtp::class])->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
    Route::POST('/home', [App\Http\Controllers\HomeController::class, 'index']);
    Route::resource('/users', UsersController::class);
    Route::resource('/agency', AgencyController::class);
    Route::resource('/logs', logsController::class);
    Route::resource('/federation', FederationController::class);
    Route::resource('/partner', PartnerController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/subcategory', SubCategoryController::class);
    Route::resource('/questions', QuestionsController::class);
    Route::resource('/cluster', ClusterController::class);
    Route::resource('/shg', ShgController::class);
    Route::resource('/family', FamilyController::class);
    Route::resource('/users', UsersController::class);
    Route::resource('/option', OptionController::class);
    Route::resource('/fedreports', fedReportsController::class);
    Route::resource('/CummulativeReport', CummulativeReportController::class);
    Route::resource('/FamilyWealthReport', FamilyWealthReportController::class);
    Route::resource('/FacilitatorWiseReport', FacilitatorWiseReportController::class);
    Route::resource('/creditreport', CreditReportController::class);
    Route::resource('/qualitycheck', QualityCheckController::class);
    Route::resource('/settings', SettingsController::class);
    
    Route::get('/add_family_task', [App\Http\Controllers\PreanalyticsController::class , 'add_family_task']);
    Route::get('/shg_task', [App\Http\Controllers\PreanalyticsController::class , 'shg_task']);
    Route::get('/shgtask', [App\Http\Controllers\PreanalyticsController::class , 'shgtask']);
    Route::get('/cluster_task', [App\Http\Controllers\PreanalyticsController::class , 'cluster_task']);
    Route::get('/clustertask', [App\Http\Controllers\PreanalyticsController::class , 'clustertask']);
    Route::get('/federation_task', [App\Http\Controllers\PreanalyticsController::class , 'federation_task']);
    Route::get('/federationtask', [App\Http\Controllers\PreanalyticsController::class , 'federationtask']);
    Route::POST('/store_shg', [App\Http\Controllers\PreanalyticsController::class , 'store_shg']);
    Route::POST('/store_cluster', [App\Http\Controllers\PreanalyticsController::class , 'store_cluster']);
    Route::POST('/store_federation', [App\Http\Controllers\PreanalyticsController::class , 'store_federation']);
    Route::resource('/preanalytics', PreanalyticsController::class);
    Route::resource('/processStepreport', ProcessStepReportController::class);
    Auth::routes(['register' => false]);
    Route::get('/get_state', [App\Http\Controllers\CommonController::class , 'get_state']);
    Route::get('/get_district', [App\Http\Controllers\CommonController::class , 'get_district']);
    Route::get('/get_block', [App\Http\Controllers\CommonController::class , 'get_block']);
    Route::get('/get_village', [App\Http\Controllers\CommonController::class , 'get_village']);
    Route::get('/get_federation_list', [App\Http\Controllers\CommonController::class , 'get_federation_list']);
    Route::get('/get_cluster_list', [App\Http\Controllers\CommonController::class , 'get_cluster_list']);
    Route::get('/get_shg_list', [App\Http\Controllers\CommonController::class , 'get_shg_list']);
    Route::get('/get_partner_list', [App\Http\Controllers\CommonController::class , 'get_partner_list']);
    Route::get('/get_shg_list_task', [App\Http\Controllers\CommonController::class , 'get_shg_list_task']);
    Route::get('/get_family_list_task', [App\Http\Controllers\CommonController::class , 'get_family_list_task']);
    Route::get('/get_facilitator_list', [App\Http\Controllers\CommonController::class , 'get_facilitator_list']);
    Route::get('/get_facilitator_list_task', [App\Http\Controllers\CommonController::class , 'get_facilitator_list_task']);
    Route::get('/get_cluster_list_task', [App\Http\Controllers\CommonController::class , 'get_cluster_list_task']);
    Route::get('/get_shg_list_task_shg', [App\Http\Controllers\CommonController::class , 'get_shg_list_task_shg']);
    Route::get('/get_subcategory', [App\Http\Controllers\CommonController::class , 'get_subcategory']);
    Route::get('/get_questions', [App\Http\Controllers\CommonController::class , 'get_questions']);
    Route::get('/edit/{category}/{subcategory}/{question_id}', [App\Http\Controllers\OptionController::class , 'edit']);
    Route::get('/get_federation_list_task', [App\Http\Controllers\CommonController::class , 'get_federation_list_task']);
    Route::get('/get_federation_list_task_federation', [App\Http\Controllers\CommonController::class , 'get_federation_list_task_federation']);
    Route::get('/get_cluster_list_task_cluster', [App\Http\Controllers\CommonController::class , 'get_cluster_list_task_cluster']);
    Route::get('/get_family_list', [App\Http\Controllers\CommonController::class , 'get_family_list']);

    // Route::get('/get_shg_list_qa', [App\Http\Controllers\QualityCheckController::class , 'shg_task']);
    // Route::get('/cluster_task_qa', [App\Http\Controllers\QualityCheckController::class , 'cluster_task']);
    // Route::get('/federation_task_qa', [App\Http\Controllers\QualityCheckController::class , 'federation_task']);
    Route::get('/get_family_list_task_new', [App\Http\Controllers\CommonController::class , 'get_family_list_task_new']);
    Route::get('/get_profile_data', [App\Http\Controllers\CommonController::class , 'get_profile_data']);
    Route::get('/change_qa_status_fed', [App\Http\Controllers\QualityCheckController::class , 'change_qa_status_fed']);
    Route::get('/change_qa_status_fm', [App\Http\Controllers\QualityCheckController::class , 'change_qa_status_fm']);

    Route::get('/change_qa_status_fed1', [App\Http\Controllers\QualityCheckController::class , 'change_qa_status_fed1']);
    Route::get('/get_federation_demography', [App\Http\Controllers\CommonController::class , 'get_federation_demography']);
    Route::get('/change_task_status_fed', [App\Http\Controllers\PreanalyticsController::class , 'change_task_status_fed']);
    Route::get('/export_fedreport', [App\Http\Controllers\fedReportsController::class, 'export']);
    Route::get('/get_fed_suggestion', [App\Http\Controllers\CommonController::class , 'get_fed_suggestion']);
    Route::get('/get_credit_suggestion', [App\Http\Controllers\CreditLoanReportController::class , 'get_credit_suggestion']);
    Route::get('/get_agency_suggestion', [App\Http\Controllers\CommonController::class , 'get_agency_suggestion']);
    Route::get('/export_family', [App\Http\Controllers\FamilyWealthReportController::class, 'export']);
    Route::get('/products/create-pdf', [App\Http\Controllers\fedReportsController::class, 'exportPDF']);
    Route::get('/wealth-report-pdf', [App\Http\Controllers\FamilyWealthReportController::class, 'exportPDF']);
    Route::get('/cummulative-report-pdf', [App\Http\Controllers\CummulativeReportController::class, 'exportPDF']);
    Route::get('/mapping_expense', [App\Http\Controllers\CommonController::class , 'mapping_expense']);
    Route::get('/mapping_income', [App\Http\Controllers\CommonController::class , 'mapping_income']);
    Route::get('/get_task_assignment_details', [App\Http\Controllers\FacilitatorWiseReportController::class , 'get_task_assignment_details']);
    Route::get('/export_facilitator', [App\Http\Controllers\FacilitatorWiseReportController::class, 'export']);
    Route::get('/get_facilitator_suggestion', [App\Http\Controllers\CommonController::class, 'get_facilitator_suggestion']);
    Route::get('/facilitatorWiseReportPdf', [App\Http\Controllers\FacilitatorWiseReportController::class, 'exportPDF']);
    Route::get('/get_agency_demography', [App\Http\Controllers\CommonController::class , 'get_agency_demography']);
    Route::get('change-password', [App\Http\Controllers\ChangePasswordController::class, 'index']);
    Route::post('change-password', [App\Http\Controllers\ChangePasswordController::class, 'store'])->name('change.password');

    Route::get('/shgDetailsPdf/{id}', [App\Http\Controllers\ShgController::class, 'exportPDF']);
    Route::get('/clusterDetailsPdf/{id}', [App\Http\Controllers\ClusterController::class, 'exportPDF']);
    Route::get('/federationDetailsPdf/{id}', [App\Http\Controllers\FederationController::class, 'exportPDF']);

    Route::get('/mapping_agriculture', [App\Http\Controllers\CommonController::class , 'mapping_agriculture']);
    Route::get('/mapping_agriculture_next', [App\Http\Controllers\CommonController::class , 'mapping_agriculture_next']);
    Route::get('/expenditure_this', [App\Http\Controllers\CommonController::class , 'expenditure_this']);
    Route::get('/expenditure_next', [App\Http\Controllers\CommonController::class , 'expenditure_next']);
    Route::get('/loan_expenditure_this', [App\Http\Controllers\CommonController::class , 'loan_expenditure_this']);
    Route::get('/loan_expenditure_next', [App\Http\Controllers\CommonController::class , 'loan_expenditure_next']);
    Route::get('/export_credreport', [App\Http\Controllers\CreditReportController::class, 'export']);
    //Route::get('/credit-report-pdf', [App\Http\Controllers\CreditReportController::class, 'exportPDF']);

    Route::get('/requested_loan_first', [App\Http\Controllers\CommonController::class , 'requested_loan_first']);
    Route::get('/requested_loan_second', [App\Http\Controllers\CommonController::class , 'requested_loan_second']);
    //Route::get('/loan_disbursement', [App\Http\Controllers\FamilyController::class , 'loan_disbursement']);
    Route::get('/loan_disbursement', [App\Http\Controllers\FamilyController::class , 'loan_disbursement']);
    Route::get('/loan_approvel', [App\Http\Controllers\FamilyController::class , 'loan_approvel']);
    Route::resource('/creditloanreport', CreditLoanReportController::class);
    Route::get('/taskassignedReportPdf', [App\Http\Controllers\FacilitatorWiseReportController::class, 'export_taskPDF']);
    Route::get('/familyBusinessplanPdf/{id}', [App\Http\Controllers\FamilyController::class, 'exportPDF']);
    Route::get('/familyPdf/{id}', [App\Http\Controllers\FamilyController::class, 'export_familyPDF']);

    Route::get('/familycardPdf/{id}', [App\Http\Controllers\FamilyController::class, 'export_familyCardPDF']);
    Route::get('/shgcardPdf/{id}', [App\Http\Controllers\ShgController::class, 'export_shgCardPDF']);
    Route::get('/clustercardPdf/{id}', [App\Http\Controllers\ClusterController::class, 'export_clusterCardPDF']);
    Route::get('/federationcardPdf/{id}', [App\Http\Controllers\FederationController::class, 'export_federationCardPDF']);
    Route::get('/familyloanPdf/{id}', [App\Http\Controllers\FamilyController::class, 'export_familyloanPDF']);

    // Route::get('/federation_task_qa_fed', [App\Http\Controllers\QualityCheckController::class , 'federation_task_fed']);
    // Route::get('/cluster_task_qa_clus', [App\Http\Controllers\QualityCheckController::class , 'cluster_task_clus']);
    // Route::get('/get_shg_list_qa_shg', [App\Http\Controllers\QualityCheckController::class , 'shg_task_shg']);
    // Route::get('/family_task_qa', [App\Http\Controllers\QualityCheckController::class , 'family_task']);
    Route::get('/cluster_pre_task', [App\Http\Controllers\PreanalyticsController::class , 'cluster_pre_task']);
    Route::get('/federation_pre_task', [App\Http\Controllers\PreanalyticsController::class , 'federation_pre_task']);
    Route::get('/shg_pre_task', [App\Http\Controllers\PreanalyticsController::class , 'shg_pre_task']);
    Route::get('/family_pre_task', [App\Http\Controllers\PreanalyticsController::class , 'family_pre_task']);
    // Route::get('/family_task_qa', [App\Http\Controllers\QualityCheckController::class , 'family_task']);
    // Route::get('/federation_task_qa1', [App\Http\Controllers\QualityCheckController::class , 'federation_task1']);
    Route::get('/get_agency_list', [App\Http\Controllers\CommonController::class , 'get_agency_list']);


    Route::resource('/ManagerWiseReport', ManagerWiseController::class);
    Route::resource('/QualityWiseReport', QualityWiseController::class);
    Route::get('/get_quality_task_assignment_details', [App\Http\Controllers\QualityWiseController::class , 'get_quality_task_assignment_details']);
    Route::get('/get_manager_task_assignment_details', [App\Http\Controllers\ManagerWiseController::class , 'get_manager_task_assignment_details']);
    Route::get('/processStepPdf', [App\Http\Controllers\ProcessStepReportController::class , 'export_pdf']);
    Route::get('/managerWiseReportPdf', [App\Http\Controllers\ManagerWiseController::class , 'export_Pdf']);
    Route::get('/managerTaskAssignmentPdf', [App\Http\Controllers\ManagerWiseController::class , 'export_managerWisePdf']);
    Route::get('/qualityTaskAssignmentPdf', [App\Http\Controllers\QualityWiseController::class , 'export_qualityWisePdf']);
    Route::get('/qualityWiseReportPdf', [App\Http\Controllers\QualityWiseController::class , 'export_Pdf']);
    Route::get('/export_manager', [App\Http\Controllers\ManagerWiseController::class, 'export']);
    Route::get('/export_quality', [App\Http\Controllers\QualityWiseController::class, 'export']);
    Route::POST('/store_task', [App\Http\Controllers\PreanalyticsController::class , 'store_task']);
    Route::get('/preanalytics_task', [App\Http\Controllers\PreanalyticsController::class , 'store_task']);



    Route::POST('/import_excel', [App\Http\Controllers\CreationController::class , 'import']);
    Route::POST('/store_csv', [App\Http\Controllers\CreationController::class , 'store_csv']);
    Route::resource('/creation', CreationController::class);
    // Route::get('/quality_check_tasks', [App\Http\Controllers\QualityCheckController::class , 'quality_tasks']);
    // Route::get('/quality_tasks_complete', [App\Http\Controllers\QualityCheckController::class , 'quality_tasks_complete']);
    Route::get('/get_shg_list2', [App\Http\Controllers\CommonController::class , 'get_shg_list2']);
    Route::get('/get_partner_demography', [App\Http\Controllers\CommonController::class , 'get_partner_demography']);

    Route::get('/group_creation_export_template', [App\Http\Controllers\CreationController::class, 'export']);
    Route::resource('/facilitator', FacilitatorController::class);
    Route::get('family_table', [App\Http\Controllers\FamilyController::class, 'family_table']);
    Route::get('family_table_two', [App\Http\Controllers\FamilyController::class, 'family_table_two']);
    Route::get('/familyConsentPdf/{id}', [App\Http\Controllers\FamilyController::class, 'export_familyConsentPdf']);
    Route::get('/export_user', [App\Http\Controllers\UsersController::class, 'export']);

    Route::get('shg_table', [App\Http\Controllers\ShgController::class, 'shg_table']);
    Route::get('shg_table_two', [App\Http\Controllers\ShgController::class, 'shg_table_two']);

    Route::get('cluster_table', [App\Http\Controllers\ClusterController::class, 'cluster_table']);
    Route::get('cluster_table_second', [App\Http\Controllers\ClusterController::class, 'cluster_table_second']);

    Route::get('federation_table', [App\Http\Controllers\FederationController::class, 'federation_table']);
    Route::get('federation_table_second', [App\Http\Controllers\FederationController::class, 'federation_table_second']);
    Route::get('familyloanApplicationPdf/{id}', [App\Http\Controllers\FamilyController::class, 'family_loan_applicationPdf']);
    Route::get('/get_phone_code', [App\Http\Controllers\CommonController::class , 'get_phone_code']);
    Route::get('/get_district_user', [App\Http\Controllers\CommonController::class , 'get_district_user']);
    Route::get('/get_shg_village', [App\Http\Controllers\CommonController::class , 'get_shg_village']);
    Route::get('/get_block_list', [App\Http\Controllers\CommonController::class , 'get_block_list']);
    Route::get('/get_tasks_list', [App\Http\Controllers\ProcessStepReportController::class , 'get_tasks_list']);
    Route::get('/agencyPdf', [App\Http\Controllers\AgencyController::class , 'export_agencyPdf']);
    Route::get('/agencyExport', [App\Http\Controllers\AgencyController::class , 'export']);
    Route::get('/partnerPdf', [App\Http\Controllers\PartnerController::class , 'export_partnerPdf']);
    Route::get('/partnerExport', [App\Http\Controllers\PartnerController::class , 'export']);
    Route::get('/credit_loan_report', [App\Http\Controllers\CreditLoanReportController::class , 'export_pdf']);
    Route::get('/credit_loan', [App\Http\Controllers\CreditLoanReportController::class , 'export']);
    Route::get('/quality_check_pdf', [App\Http\Controllers\QualityCheckController::class , 'export_pdf']);
    Route::get('/quality_export', [App\Http\Controllers\QualityCheckController::class , 'export']);

    Route::get('/FederationExport', [App\Http\Controllers\FederationController::class , 'export']);
    Route::get('/federationPDF', [App\Http\Controllers\FederationController::class , 'federationPDF']);
    Route::get('/clusterExport', [App\Http\Controllers\ClusterController::class , 'export']);
    Route::get('/clusterPDF', [App\Http\Controllers\ClusterController::class , 'clusterPDF']);
    Route::get('/SHGExport', [App\Http\Controllers\ShgController::class , 'export']);
    Route::get('/shgPDF', [App\Http\Controllers\ShgController::class , 'shgPDF']);
    Route::get('/FamilyExport', [App\Http\Controllers\FamilyController::class , 'export']);
    Route::get('/familyPDF', [App\Http\Controllers\FamilyController::class , 'familyPDF']);
    Route::get('send-email', [SendEmailController::class, 'index']);
    Route::get('/usersPdf', [App\Http\Controllers\UsersController::class , 'export_usersPdf']);
    Route::get('/get_notification_read', [App\Http\Controllers\CommonController::class , 'get_notification_read']);
    Route::get('/get_allnotification_read', [App\Http\Controllers\CommonController::class , 'get_allnotification_read']);
    Route::get('/federationDetailsCardPdf/{id}', [App\Http\Controllers\FederationController::class, 'federationDetailsCardPdf']);
    Route::get('/shgDetailscardPdf/{id}', [App\Http\Controllers\ShgController::class, 'exportshgPDF']);
    Route::get('/clusterDetailsCardPdf/{id}', [App\Http\Controllers\ClusterController::class, 'exportclusterPDF']);
    Route::get('/federationTasklistPdf', [App\Http\Controllers\PreanalyticsController::class, 'export_federation_list']);
    Route::get('/clusterTasklistPdf', [App\Http\Controllers\PreanalyticsController::class, 'export_cluster_list']);
    Route::get('/shgTasklistPdf', [App\Http\Controllers\PreanalyticsController::class, 'export_shg_list']);
    Route::get('/familyTasklistPdf', [App\Http\Controllers\PreanalyticsController::class, 'export_family_list']);
    Route::get('/FederationTasklist', [App\Http\Controllers\PreanalyticsController::class , 'export_federation']);
    Route::get('/ClusterTasklist', [App\Http\Controllers\PreanalyticsController::class , 'export_cluster']);
    Route::get('/ShgTasklist', [App\Http\Controllers\PreanalyticsController::class , 'export_shg']);
    Route::get('/FamilyTasklist', [App\Http\Controllers\PreanalyticsController::class , 'export_family']);
    Route::get('/familyDetailCardPdf/{id}', [App\Http\Controllers\FamilyController::class, 'export_familyDetailCardPDF']);
    Route::get('/logout_detail', [App\Http\Controllers\CommonController::class , 'logout_details']);
    Route::get('/get_user_agency_demography', [App\Http\Controllers\UsersController::class , 'get_agency_demography']);
    Route::get('/mapping_other_income', [App\Http\Controllers\CommonController::class , 'mapping_other_income']);
    Route::get('/get_remarks', [App\Http\Controllers\CommonController::class , 'get_remarks']);
    Route::get('/get_shg_remarks', [App\Http\Controllers\CommonController::class , 'get_shg_remarks']);

   
});
Route::get('/otp_login', [App\Http\Controllers\AuthOtpController::class , 'login']);
Route::post('/loginWithOtp', [App\Http\Controllers\AuthOtpController::class , 'loginWithOtp']);
Route::post('/generate', [App\Http\Controllers\AuthOtpController::class , 'generate']);
// Route::controller(AuthOtpController::class)->group(function(){
//     Route::get('/otp/login', 'login')->name('otp.login');
//     Route::post('/otp/generate', 'generate')->name('otp.generate');
//     Route::get('/otp/verification/{user_id}', 'verification')->name('otp.verification');
//     Route::post('/otp/login', 'loginWithOtp')->name('otp.getlogin');
// });
Route::resource('/mail_shoot', MailShootController::class);
Route::resource('/locked', LockedController::class);



Auth::routes();
