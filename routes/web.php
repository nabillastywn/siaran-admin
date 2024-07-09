<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\VerificationController;
use Illuminate\Support\Facades\Route;


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
    return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PasswordController;         
            

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->name('login');
	Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

Route::get('/forgot-password', [PasswordController::class, 'showLinkRequestForm'])->middleware('guest')->name('password.request');
	Route::post('/forgot-password', [PasswordController::class, 'sendResetLinkEmail'])->middleware('guest')->name('password.email');
	Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])->middleware('guest')->name('password.reset');
	Route::post('/reset-password', [PasswordController::class, 'reset'])->middleware('guest')->name('password.update');
	Route::get('/api/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

	Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index')->middleware('auth');

	Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
        Route::resource('/users', UserController::class, ['as' => 'admin'])->parameters(['users' => 'user']);

		// Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
	Route::resource('/sarpras', SarprasController::class, ['as' => 'admin'])->parameters([
			'sarpras' => 'sarpras'
		]); 
		Route::get('/lost-item', [LostItemController::class, 'index'])->name('admin.lost-item.index');
		Route::get('/lost-item/create', [LostItemController::class, 'create'])->name('admin.lost-item.create');
		Route::post('/lost-item', [LostItemController::class, 'store'])->name('admin.lost-item.store'); // Route for store
		Route::get('/lost-item/{lostitem}/edit', [LostItemController::class, 'edit'])->name('admin.lost-item.edit');
		Route::put('/lost-item/{lostitem}', [LostItemController::class, 'update'])->name('admin.lost-item.update');
		Route::delete('/lost-item/{lostitem}', [LostItemController::class, 'destroy'])->name('admin.lost-item.destroy');
		
		Route::resource('/status', StatusController::class, ['as' => 'admin'])->parameters([
			'status' => 'status'
		]);

	Route::get('/bullying-report', [BullyingReportController::class, 'index'])->name('admin.bullying-report.index');
	Route::get('admin/bullying-report/{bullyingReport}', [BullyingReportController::class, 'show'])->name('admin.bullying-report.show');

	Route::get('items-reports', [ItemsReportController::class, 'index'])->name('admin.items-report.index');
    Route::get('items-reports/{itemsReport}', [ItemsReportController::class, 'show'])->name('admin.items-report.show');

	Route::get('sarana-report', [SaranaReportController::class, 'index'])->name('admin.sarana-report.index');
Route::get('sarana-report/{saranaReport}', [SaranaReportController::class, 'show'])->name('admin.sarana-report.show');

Route::get('sexual-reports', [SexualReportController::class, 'index'])->name('admin.sexual-report.index');
Route::get('sexual-reports/{sexualReport}', [SexualReportController::class, 'show'])->name('admin.sexual-report.show');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Route::get('/debug-passport', function () {
//     return [
//         'passport_class_exists' => class_exists(\Laravel\Passport\Passport::class),
//         'passport_routes_method_exists' => method_exists(\Laravel\Passport\Passport::class, 'routes'),
//     ];
// });


Route::prefix('api')->group(function () {
});