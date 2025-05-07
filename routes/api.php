<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FederationController;
use App\Http\Controllers\API\ShgController;
use App\Http\Controllers\API\ClusterController;
use App\Http\Controllers\API\FamilyController;
use App\Http\Controllers\API\ExtractlogController;
use App\Http\Controllers\API\HistoryController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\API\v1\DataUploadController;

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
Route::POST('/extractlog', [App\Http\Controllers\API\ExtractlogController::class, 'index']);
Route::POST('/federationin', [App\Http\Controllers\API\FederationController::class, 'index']);
Route::POST('/shgin ', [App\Http\Controllers\API\ShgController::class, 'index']);
Route::POST('/clusterin ', [App\Http\Controllers\API\ClusterController::class, 'index']);
Route::POST('/familyin ', [App\Http\Controllers\API\FamilyController::class, 'index']);
Route::POST('/userauth', [App\Http\Controllers\API\UserController::class, 'index']);
Route::GET('/master', [App\Http\Controllers\API\UserController::class, 'download_master']);
// Route::POST('/device_registration', [App\Http\Controllers\API\UserController::class, 'device_registration']);
Route::GET('/rating', [App\Http\Controllers\API\RatingController::class, 'index']);
Route::POST('/history', [App\Http\Controllers\API\HistoryController::class, 'index']);
Route::GET('/register', [App\Http\Controllers\API\RegisterController::class, 'index']);
Route::POST('/image_upload', [App\Http\Controllers\API\FamilyImageUploadController::class, 'index']);
Route::get('send-email', [SendEmailController::class, 'index']);

// v1 routes 22/08/2024

Route::POST('/v1/extractlog', [App\Http\Controllers\API\v1\ExtractlogController::class, 'index']);
Route::POST('/v1/federationin', [App\Http\Controllers\API\v1\FederationController::class, 'index']);
Route::POST('/v1/shgin ', [App\Http\Controllers\API\v1\ShgController::class, 'index']);
Route::POST('/v1/clusterin ', [App\Http\Controllers\API\v1\ClusterController::class, 'index']);
Route::POST('/v1/familyin ', [App\Http\Controllers\API\v1\FamilyController::class, 'index']);
Route::POST('/v1/userauth', [App\Http\Controllers\API\v1\UserController::class, 'index']);
Route::GET('/v1/master', [App\Http\Controllers\API\v1\UserController::class, 'download_master']);
// Route::POST('/v1/device_registration', [App\Http\Controllers\API\v1\UserController::class, 'device_registration']);
Route::GET('/v1/rating', [App\Http\Controllers\API\v1\RatingController::class, 'index']);
Route::POST('/v1/history', [App\Http\Controllers\API\v1\HistoryController::class, 'index']);
Route::GET('/v1/register', [App\Http\Controllers\API\v1\RegisterController::class, 'index']);
Route::POST('/v1/image_upload', [App\Http\Controllers\API\v1\FamilyImageUploadController::class, 'index']);
Route::get('send-email', [SendEmailController::class, 'index']);
Route::POST('/v1/data_upload', [App\Http\Controllers\API\v1\DataUploadController::class, 'index']);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
