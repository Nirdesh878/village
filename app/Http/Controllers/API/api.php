<?php

namespace App\Http\Controllers\API\Common;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//=================================================================================================//
//====================================== WEB ======================================================//
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/forgot-password', [PasswordResetRequestController::class, 'sendPasswordResetEmail']);
Route::group(['middleware' => ['jwt.verify']], function () {
   
    Route::get('logout', [LoginController::class, 'logout']);
    Route::get('get_user', [LoginController::class, 'get_user']);
    Route::get('users', [LoginController::class, 'get_users']);
    Route::get('users/{id}', [LoginController::class, 'show']);
    Route::post('users/add', [LoginController::class, 'store']);
    Route::post('users/{id}/update', [LoginController::class, 'update']);
    Route::get('users/{id}/delete', [LoginController::class, 'destroy']);
    Route::get('user/export', [LoginController::class, 'export']);
    Route::post('change-password', [LoginController::class, 'change_password']);
    //=========================== States Route =================================//
    Route::get('states', [StateController::class, 'index']);
    Route::get('states/show/{id}', [StateController::class, 'show']);
    Route::post('/states/add', [StateController::class, 'store']);
    Route::post('states/{id}/update', [StateController::class, 'update']);
    Route::get('states/{id}/delete', [StateController::class, 'destroy']);
    Route::get('states/export', [StateController::class, 'export']);
    //=========================== Cities Route =================================//
    Route::get('city', [CityController::class, 'index']);
    Route::get('city/show/{id}', [CityController::class, 'show']);
    Route::post('/city/add', [CityController::class, 'store']);
    Route::post('city/{id}/update', [CityController::class, 'update']);
    Route::get('city/{id}/delete', [CityController::class, 'destroy']);
    Route::get('city/export', [CityController::class, 'export']);
    //=========================== Partner Route =================================//
    Route::get('partner', [PartnerController::class, 'index']);
    Route::get('partner/show/{id}', [PartnerController::class, 'show']);
    Route::post('/partner/add', [PartnerController::class, 'store']);
    Route::post('partner/{id}/update', [PartnerController::class, 'update']);
    Route::get('partner/{id}/delete', [PartnerController::class, 'destroy']);
    Route::get('partner/export', [PartnerController::class, 'export']);
    //=========================== Language Route =================================//
    Route::get('language', [LanguageController::class, 'index']);
    Route::get('language/show/{id}', [LanguageController::class, 'show']);
    Route::post('/language/add', [LanguageController::class, 'store']);
    Route::post('language/{id}/update', [LanguageController::class, 'update']);
    Route::get('language/{id}/delete', [LanguageController::class, 'destroy']);
    //=========================== Districts Route =================================//
    Route::get('district', [DistrictController::class, 'index']);
    Route::get('district/show/{id}', [DistrictController::class, 'show']);
    Route::post('/district/add', [DistrictController::class, 'store']);
    Route::post('district/{id}/update', [DistrictController::class, 'update']);
    Route::get('district/{id}/delete', [DistrictController::class, 'destroy']);
    Route::get('district/export', [DistrictController::class, 'export']);
    //=========================== Zone Route =================================//
    Route::get('zone', [ZoneController::class, 'index']);
    Route::get('zone/show/{id}', [ZoneController::class, 'show']);
    Route::post('/zone/add', [ZoneController::class, 'store']);
    Route::post('zone/{id}/update', [ZoneController::class, 'update']);
    Route::get('zone/{id}/delete', [ZoneController::class, 'destroy']);
    Route::get('zone/export', [ZoneController::class, 'export']);
    //=========================== Ward Route =================================//
    Route::get('ward', [WardController::class, 'index']);
    Route::get('ward/show/{id}', [WardController::class, 'show']);
    Route::post('/ward/add', [WardController::class, 'store']);
    Route::post('ward/{id}/update', [WardController::class, 'update']);
    Route::get('ward/{id}/delete', [WardController::class, 'destroy']);
    Route::get('ward/export', [WardController::class, 'export']);
    //=========================== Slum Route =================================//
    Route::get('slum', [SlumController::class, 'index']);
    Route::get('slum/show/{id}', [SlumController::class, 'show']);
    Route::post('/slum/add', [SlumController::class, 'store']);
    Route::post('slum/{id}/update', [SlumController::class, 'update']);
    Route::get('slum/{id}/delete', [SlumController::class, 'destroy']);
    Route::get('slum/export', [SlumController::class, 'export']);
    //====================================== CommonRoutes ======================================================//
    Route::get('/getDistrictsByStateId', 'App\Http\Controllers\API\Common\CommonController@getDistrictsByStateId');
    Route::get('/getCitiesByDistrictId', 'App\Http\Controllers\API\Common\CommonController@getCitiesByDistrictId');
    Route::get('/getZonesByCityId', 'App\Http\Controllers\API\Common\CommonController@getZonesByCityId');
    Route::get('/getWardsByZoneId', 'App\Http\Controllers\API\Common\CommonController@getWardsByZoneId');
    Route::get('/getSlumsByWardId', 'App\Http\Controllers\API\Common\CommonController@getSlumsByWardId');
    Route::get('/getquestiontype', 'App\Http\Controllers\API\Common\CommonController@getquestiontype');
    Route::get('/getlocations', 'App\Http\Controllers\API\Common\CommonController@getlocations');
    Route::get('/GetChildQuestionByQuestionID', 'App\Http\Controllers\API\Common\CommonController@GetChildQuestionByQuestionID');
    Route::get('/getrolesbypartner_id', 'App\Http\Controllers\API\Common\CommonController@getrolesbypartner_id');

    Route::get('/getDistrictsByMultiStateId', 'App\Http\Controllers\API\Common\CommonController@getDistrictsByMultiStateId');
    Route::get('/getCitiesByMultiDistrictId', 'App\Http\Controllers\API\Common\CommonController@getCitiesByMultiDistrictId');
    Route::get('/getZonesByMultiCityId', 'App\Http\Controllers\API\Common\CommonController@getZonesByMultiCityId');
    Route::get('/getWardsByMultiZoneId', 'App\Http\Controllers\API\Common\CommonController@getWardsByMultiZoneId');
    Route::get('/getSlumsByMultiWardId', 'App\Http\Controllers\API\Common\CommonController@getSlumsByMultiWardId');
    Route::get('/getSchemeTypes', 'App\Http\Controllers\API\Common\CommonController@getSchemeTypes');
    Route::get('/getAttributesBySchemeId', 'App\Http\Controllers\API\Common\CommonController@getAttributesBySchemeId');
    Route::get('/enableDisableById', 'App\Http\Controllers\API\Common\CommonController@enableDisableById');
    Route::get('/getzonesbypartner', 'App\Http\Controllers\API\Common\CommonController@getzonesbypartner');
    Route::get('/getquestionlogicdetails', 'App\Http\Controllers\API\Common\CommonController@getquestionlogicdetails');
    Route::get('/getOptionsByquestionId', 'App\Http\Controllers\API\Common\CommonController@getOptionsByquestionId');
    Route::get('/GetQuestionBySurveyid', 'App\Http\Controllers\API\Common\CommonController@GetQuestionBySurveyid');
    Route::get('/getoptionsByattributeID', 'App\Http\Controllers\API\Common\CommonController@getoptionsByattributeID');
    Route::get('/getLinkedWardsByZoneId', 'App\Http\Controllers\API\Common\CommonController@getLinkedWardsByZoneId');
    Route::get('/getLinkedSlumsByWardId', 'App\Http\Controllers\API\Common\CommonController@getLinkedSlumsByWardId');
    Route::get('/getSurveyReportfilters', 'App\Http\Controllers\API\Common\CommonController@getSurveyReportfilters');
    //=========================== Survey Route =================================//
    Route::get('survey', [SurveyController::class, 'index']);
    Route::get('survey/show/{id}', [SurveyController::class, 'show']);
    Route::post('survey/add', [SurveyController::class, 'store']);
    Route::post('survey/{id}/update', [SurveyController::class, 'update']);
    Route::get('survey/{id}/delete', [SurveyController::class, 'destroy']);
    //=========================== Role Route =================================//
    Route::get('role', [RoleController::class, 'index']);
    Route::get('role/show/{id}', [RoleController::class, 'show']);
    Route::post('role/add', [RoleController::class, 'store']);
    Route::post('role/{id}/update', [RoleController::class, 'update']);
    Route::get('role/{id}/delete', [RoleController::class, 'destroy']);
    Route::get('role/export', [RoleController::class, 'export']);
    //=========================== Common Route =================================//
    Route::get('common', [MstCommonController::class, 'index']);
    Route::get('common/show/{id}', [MstCommonController::class, 'show']);
    Route::post('common/add', [MstCommonController::class, 'store']);
    Route::post('common/{id}/update', [MstCommonController::class, 'update']);
    Route::get('common/{id}/delete', [MstCommonController::class, 'destroy']);
    Route::post('common/AddMainFlag', [MstCommonController::class, 'AddMainFlag']);
    Route::get('common/edit', [MstCommonController::class, 'edit']);
    Route::get('common/optionsequence', [MstCommonController::class, 'optionsequence']);
    Route::get('showoptions/{flag}/{common_id}', [MstCommonController::class, 'showoptions']);
    //=========================== Resource Center Route =================================//
    Route::get('resourcecenter', [ResouceCenterController::class, 'index']);
    Route::get('resourcecenter/show/{id}', [ResouceCenterController::class, 'show']);
    Route::post('resourcecenter/add', [ResouceCenterController::class, 'store']);
    Route::post('resourcecenter/{id}/update', [ResouceCenterController::class, 'update']);
    Route::get('resourcecenter/{id}/delete', [ResouceCenterController::class, 'destroy']);
    Route::get('resourcecenter/export', [ResouceCenterController::class, 'export']);
    //=========================== Question Type Route =================================//
    Route::get('questiontype', [QuestionTypeController::class, 'index']);
    Route::get('questiontype/show/{id}', [QuestionTypeController::class, 'show']);
    Route::post('questiontype/add', [QuestionTypeController::class, 'store']);
    Route::post('questiontype/{id}/update', [QuestionTypeController::class, 'update']);
    Route::get('questiontype/{id}/delete', [QuestionTypeController::class, 'destroy']);
    //===========================Survey Question  Route =================================//
    Route::get('surveyquestion', [SurveyQuestionsController::class, 'index']);
    Route::get('surveyquestion/show/{id}', [SurveyQuestionsController::class, 'show']);
    Route::post('surveyquestion/add', [SurveyQuestionsController::class, 'store']);
    Route::post('surveyquestion/{id}/update', [SurveyQuestionsController::class, 'update']);
    Route::get('surveyquestion/{id}/delete', [SurveyQuestionsController::class, 'destroy']);
    Route::get('surveyquestion/getChildQuestions', [SurveyQuestionsController::class, 'getChildQuestions']);
    Route::get('/linkoptiontoquestion', [SurveyQuestionsController::class, 'linkoptiontoquestion']);
    Route::get('/orderquestion', [SurveyQuestionsController::class, 'orderquestion']);

    //=========================== Scheme Route =================================//
    Route::get('scheme', [SchemeController::class, 'index']);
    Route::get('scheme/show/{id}', [SchemeController::class, 'show']);
    Route::post('scheme/add', [SchemeController::class, 'store']);
    Route::post('scheme/{id}/update', [SchemeController::class, 'update']);
    Route::get('scheme/{id}/delete', [SchemeController::class, 'destroy']);
    Route::get('scheme/export', [SchemeController::class, 'export']);
     //=========================== Scheme Attribute Route =================================//
     Route::get('schemeAttribute', [SchemeAttributeController::class, 'index']);
     Route::get('schemeAttribute/show/{id}', [SchemeAttributeController::class, 'show']);
     Route::post('schemeAttribute/add', [SchemeAttributeController::class, 'store']);
     Route::post('schemeAttribute/{id}/update', [SchemeAttributeController::class, 'update']);
     Route::get('schemeAttribute/{id}/delete', [SchemeAttributeController::class, 'destroy']);
     //=========================== Document Required =================================//
     Route::get('schemeDocument', [SchemeDocumentController::class, 'index']);
     Route::get('schemeDocument/show/{id}', [SchemeDocumentController::class, 'show']);
     Route::post('schemeDocument/add', [SchemeDocumentController::class, 'store']);
     Route::post('schemeDocument/{id}/update', [SchemeDocumentController::class, 'update']);
     Route::get('schemeDocument/{id}/delete', [SchemeDocumentController::class, 'destroy']);
     //=========================== Criteria Required =================================//
     Route::get('schemeCriteria', [SchemeCriteriaController::class, 'index']);
     Route::get('schemeCriteria/show/{id}', [SchemeCriteriaController::class, 'show']);
     Route::post('schemeCriteria/add', [SchemeCriteriaController::class, 'store']);
     Route::post('schemeCriteria/{id}/update', [SchemeCriteriaController::class, 'update']);
     Route::get('schemeCriteria/{id}/delete', [SchemeCriteriaController::class, 'destroy']);
    
     //=========================== Grievances Issue  =================================//
     Route::get('grievances_issues', [IssueController::class, 'index']);
     Route::get('grievances_issues/show/{id}', [IssueController::class, 'show']);
     Route::post('grievances_issues/add', [IssueController::class, 'store']);
     Route::post('grievances_issues/{id}/update', [IssueController::class, 'update']);
     Route::get('grievances_issues/{id}/delete', [IssueController::class, 'destroy']);
    
     //=========================== Grievances  =================================//
     Route::get('grievances', [GrievanceController::class, 'index']);
     Route::get('grievances/show/{id}', [GrievanceController::class, 'show']);
     Route::post('grievances/add_comment', [GrievanceController::class, 'store']);
     Route::post('grievances/{id}/update', [GrievanceController::class, 'update']);
     Route::get('grievances/{id}/delete', [GrievanceController::class, 'destroy']);
    
     //=========================== SurveyHousehold Export  =================================//
     Route::get('list_export', [HouseholdExportController::class, 'index']);
     //Route::get('grievances/show/{id}', [SurveyHouseholdExportController::class, 'show']);
     Route::post('create_export', [HouseholdExportController::class, 'store']);
    
     Route::get('delete_export/{id}', [HouseholdExportController::class, 'destroy']);
    
    
     //=========================== Survey Household =================================//
     Route::get('SurveyHousehold', [SurveyHouseholdController::class, 'index']);
     Route::get('SurveyHousehold/show/{id}', [SurveyHouseholdController::class, 'show']);
     Route::post('SurveyHousehold/add', [SurveyHouseholdController::class, 'store']);
     Route::POST('household/{id}/update', [SurveyHouseholdController::class, 'update']);
     Route::GET('SurveyHousehold/{id}/edit', [SurveyHouseholdController::class, 'edit']);
     Route::get('SurveyHousehold/{id}/delete', [SurveyHouseholdController::class, 'destroy']);
     Route::get('householdstatus/{id}/{status_id}', [SurveyHouseholdController::class, 'householdstatus']);
     Route::get('SurveyHousehold/export', [SurveyHouseholdController::class, 'export']);
 //=========================== Attribute Mapping =================================//
     Route::post('map_unmap_attribute', [AttributeMappingController::class, 'store']);
 //=========================== Permission Mapping =================================//
     //Route::get('permissions', [PermissionController::class, 'index']);
     Route::match(['get', 'post'],'permissions', [PermissionController::class, 'index']);
     //Route::match( 'permissions','PermissionController@index');
     //=========================== Survey Question Logic =================================//
//Route::get('SurveyLogic', [SurveyQuestionsLogicController::class, 'index']);
Route::get('SurveyLogic/show/{id}', [SurveyQuestionsLogicController::class, 'show']);
Route::post('SurveyLogic/add', [SurveyQuestionsLogicController::class, 'store']);
//Route::post('SurveyHousehold/{id}/update', [SurveyHouseholdController::class, 'update']);
Route::get('SurveyLogic/{id}/delete', [SurveyQuestionsLogicController::class, 'destroy']);

/////////////// Reports Controller////////////////
Route::get('Reports', [ReportsController::class, 'index']);
Route::get('group_filter_report', [ReportsController::class, 'group_filter_report']);
Route::get('multi_filter_report/{id}', [ReportsController::class, 'multi_filter_report']);

     ///////////////////////APP/////////////////
     Route::post('/surveydata_upload', 'App\Http\Controllers\API\Mobile\SurveyDataUploadController@index');
     Route::get('/tokenbased_data_download', 'App\Http\Controllers\API\Mobile\ApiLoginController@tokenbased_data_download');
     Route::post('/download_data', 'App\Http\Controllers\API\Mobile\ApiLoginController@download_data');
     Route::post('/download_data_in_chunks', 'App\Http\Controllers\API\Mobile\ApiLoginController@download_data_in_chunks');
     Route::post('/update_profile', 'App\Http\Controllers\API\Mobile\ApiLoginController@update_profile');
     Route::post('/changePin', 'App\Http\Controllers\API\Mobile\ApiLoginController@changePin');
     Route::get('/removeduplicates', 'App\Http\Controllers\API\Common\RemoveDuplicateSurveyHouseholdController@index');
    });
//=================================================================================================//
//====================================== APP ======================================================//
Route::post('/api_login', 'App\Http\Controllers\API\Mobile\ApiLoginController@index');
Route::post('/sendOTP', 'App\Http\Controllers\API\Mobile\OneTimePasswordRequestController@sendOtpPasswordEmail');
Route::post('/changeForgetPin', 'App\Http\Controllers\API\Mobile\ApiLoginController@changeForgetPin');
Route::get('update_summary', [SummaryController::class, 'update_summary_daily']);
//Route::get('update_summary_new', [SummaryController::class, 'summary_update']);
Route::get('process_export', [HouseholdExportController::class, 'process_export']);
Route::get('update_household_name', [SummaryController::class, 'update_household_name']);
Route::get('fix_is_deleted_in_summary', [SummaryController::class, 'fix_is_deleted_in_summary']);

//=================================================================================================//
//=================================================================================================//
//=======================V_1_1_5========================
Route::group(['middleware' => ['jwt.verify']], function () {
   
    Route::post('/v_1_1_5/surveydata_upload', 'App\Http\Controllers\API\v_1_1_5\Mobile\SurveyDataUploadController@index');
    Route::get('/v_1_1_5/tokenbased_data_download', 'App\Http\Controllers\API\v_1_1_5\Mobile\ApiLoginController@tokenbased_data_download');
    Route::post('/v_1_1_5/download_data', 'App\Http\Controllers\API\v_1_1_5\Mobile\ApiLoginController@download_data');
    Route::post('/v_1_1_5/download_data_in_chunks', 'App\Http\Controllers\API\v_1_1_5\Mobile\ApiLoginController@download_data_in_chunks');
    Route::post('/v_1_1_5/update_profile', 'App\Http\Controllers\API\v_1_1_5\Mobile\ApiLoginController@update_profile');
    Route::post('/v_1_1_5/changePin', 'App\Http\Controllers\API\v_1_1_5\Mobile\ApiLoginController@changePin');

    Route::post('/v_1_1_5/check_existing_survey', 'App\Http\Controllers\API\v_1_1_5\Mobile\ApiLoginController@check_existing_survey');
    Route::post('/v_1_1_5/download_data_in_chunks_v1_1_8', 'App\Http\Controllers\API\v_1_1_5\Mobile\ApiLoginController@download_data_in_chunks_v1_1_8');
});
Route::post('/v_1_1_5/api_login', 'App\Http\Controllers\API\v_1_1_5\Mobile\ApiLoginController@index');
Route::post('/v_1_1_5/sendOTP', 'App\Http\Controllers\API\v_1_1_5\Mobile\OneTimePasswordRequestController@sendOtpPasswordEmail');
Route::post('/v_1_1_5/changeForgetPin', 'App\Http\Controllers\API\v_1_1_5\Mobile\ApiLoginController@changeForgetPin');