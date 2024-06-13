<?php

namespace App\Http\Controllers\Admin;
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
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;            
            

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->name('login');
	Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index')->middleware('auth');

	Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
		Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
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

		Route::get('/user-mhs', [UserMhsController::class, 'index'])->name('admin.user-mhs.index');
		Route::get('/user-mhs/create', [UserMhsController::class, 'create'])->name('admin.user-mhs.create');
		Route::post('/user-mhs', [UserMhsController::class, 'store'])->name('admin.user-mhs.store');
		Route::get('/user-mhs/{userMhs}/edit', [UserMhsController::class, 'edit'])->name('admin.user-mhs.edit');
		Route::put('/user-mhs/{userMhs}', [UserMhsController::class, 'update'])->name('admin.user-mhs.update');
		Route::delete('/user-mhs/{userMhs}', [UserMhsController::class, 'destroy'])->name('admin.user-mhs.destroy');
		Route::get('/user-mhs/{userMhs}', [UserMhsController::class, 'show'])->name('admin.user-mhs.show');
		
		// UserPic Routes
		Route::get('/user-pic', [UserPicController::class, 'index'])->name('admin.user-pic.index');
    Route::get('/user-pic/create', [UserPicController::class, 'create'])->name('admin.user-pic.create');
    Route::post('/user-pic', [UserPicController::class, 'store'])->name('admin.user-pic.store');
    Route::get('/user-pic/{userPic}/edit', [UserPicController::class, 'edit'])->name('admin.user-pic.edit');
    Route::put('/user-pic/{userPic}', [UserPicController::class, 'update'])->name('admin.user-pic.update');
    Route::delete('/user-pic/{userPic}', [UserPicController::class, 'destroy'])->name('admin.user-pic.destroy');
    Route::get('/user-pic/{userPic}', [UserPicController::class, 'show'])->name('admin.user-pic.show');

	Route::get('/bullying-report', [BullyingReportController::class, 'index'])->name('admin.bullying-report.index');
	Route::get('admin/bullying-report/{bullyingReport}', [BullyingReportController::class, 'show'])->name('admin.bullying-report.show');

	Route::get('items-reports', [ItemsReportController::class, 'index'])->name('admin.items-report.index');
    Route::get('items-reports/{itemsReport}', [ItemsReportController::class, 'show'])->name('admin.items-report.show');

	Route::get('sarana-report', [SaranaReportController::class, 'index'])->name('admin.sarana-report.index');
Route::get('sarana-report/{saranaReport}', [SaranaReportController::class, 'show'])->name('admin.sarana-report.show');

Route::get('sexual-reports', [SexualReportController::class, 'index'])->name('admin.sexual-report.index');
Route::get('sexual-reports/{sexualReport}', [SexualReportController::class, 'show'])->name('admin.sexual-report.show');

	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static'); 
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static'); 
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::prefix('api')->group(function () {
});