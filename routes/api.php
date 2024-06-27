<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
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

// Rute untuk mengambil user yang terautentikasi
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Api Register dan login
 */
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [LoginController::class, 'logout']);

Route::post('password/forgot', [PasswordController::class, 'forgot']);
Route::post('password/reset', [PasswordController::class, 'reset']);

/**
 * APi Sarpras
 */
Route::get('/sarpras', [SarprasController::class, 'index']);
Route::get('/sarpras/{slug}', [SarprasController::class, 'show']);

/**
 * APi Lost Item
 */
Route::get('/lost-item', [LostItemController::class, 'index']);
Route::get('/lost-item/{slug}', [LostItemController::class, 'show']);

/**
 * APi Status
 */
Route::get('/statuses', [StatusController::class, 'index']);
Route::get('/statuses/{slug}', [StatusController::class, 'show']);

/**
 * APi Get Lost Items Report and Detail
 */
Route::get('items-reports/all', [ItemsReportController::class, 'getAllReports']);
Route::get('items-reports/{id}', [ItemsReportController::class, 'show']);


Route::group(['middleware' => ['auth:api']], function() {
    /**
     * APi Profile
     */
    Route::get('profile', [ProfileController::class, 'index']);
    Route::post('profile', [ProfileController::class, 'update']);
    Route::patch('profile', [ProfileController::class, 'update']);
    
    /**
     * APi Change Password
     */
    Route::put('profile/change-password', [ProfileController::class, 'updatePassword']);
    Route::post('profile/change-password', [ProfileController::class, 'updatePassword']);
    
    /**
     * APi Bullying Reports
     */
    Route::post('/bullying-reports', [BullyingReportController::class, 'store']); //create
    Route::get('/bullying-reports', [BullyingReportController::class, 'index']); //get all
    Route::get('/bullying-reports/{id}', [BullyingReportController::class, 'show']); //detail
    Route::put('/bullying-reports/{id}/status', [BullyingReportController::class, 'updateStatus']); //update status (put)
    Route::post('/bullying-reports/{id}/status', [BullyingReportController::class, 'updateStatus']); //update status using post
    Route::delete('/bullying-reports/{id}', [BullyingReportController::class, 'destroy']);
    

    /**
     * APi Sexual Reports
     */
    Route::post('/sexual-reports', [SexualReportController::class, 'store']);
    Route::get('/sexual-reports', [SexualReportController::class, 'index']);
    Route::get('/sexual-reports/{id}', [SexualReportController::class, 'show']);
    Route::put('/sexual-reports/{id}/status', [SexualReportController::class, 'updateStatus']);
    Route::post('/sexual-reports/{id}/status', [SexualReportController::class, 'updateStatus']);
    Route::delete('sexual-reports/{id}', [SexualReportController::class, 'destroy']);

    /**
     * APi Items Reports
     */
    Route::post('items-reports', [ItemsReportController::class, 'store']); //create
    Route::get('items-reports', [ItemsReportController::class, 'index']); //user own reports
    Route::put('items-reports/{id}/status', [ItemsReportController::class, 'updateStatus']); //update status
    Route::post('items-reports/{id}/status', [ItemsReportController::class, 'updateStatus']); //update status
    Route::delete('/items-reports/{id}', [ItemsReportController::class, 'destroy']);

    /**
     * APi Sarana Reports
     */

    // Rute untuk menyimpan laporan sarana
    Route::post('/sarana-reports', [SaranaReportController::class, 'store']);

    // Rute untuk mendapatkan daftar laporan sarana
    Route::get('/sarana-reports', [SaranaReportController::class, 'index']);

    // Rute untuk memperbarui status laporan sarana
    Route::put('/sarana-reports/{id}/status', [SaranaReportController::class, 'updateStatus']);
    Route::post('/sarana-reports/{id}/status', [SaranaReportController::class, 'updateStatus']);

    // Rute untuk melihat detail laporan sarana
    Route::get('/sarana-reports/{id}', [SaranaReportController::class, 'show']);
    Route::delete('sarana-reports/{id}', [SaranaReportController::class, 'destroy']);

});