<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CloseBoxController;
use App\Http\Controllers\CloseTheBoxController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportBookDiaryController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
Route::get('/',function(){
    return redirect('admin/');
});
Route::prefix('reporte')->group(function(){
    Route::get('/',[BusinessController::class,"showReportPublic"])->name('report.public');
});
Route::prefix('admin')->group(function(){
    Route::middleware(["auth"])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/management', [DashboardController::class, 'indexByGestion'])->name('management.index');



        Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
        Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::get('/category/{category}/changeState', [CategoryController::class, 'changeState'])->name('category.change');


        Route::get('/book', [BookController::class, 'index'])->name('book.index');
        Route::post('/book', [BookController::class, 'store'])->name('book.store');

        Route::get('transfer',[BookController::class, 'transferIndex'])->name('transfer.index');
        Route::post('transfer',[BookController::class, 'transferSave'])->name('transfer.save');

        Route::get('report', [ReportBookDiaryController::class, 'index'])->name('report.book.index');
        Route::get('report/range', [ReportBookDiaryController::class, 'getBookRange'])->name('report.getBookRange');
        Route::get('report/range/v2', [ReportBookDiaryController::class, 'getBookRangeV2'])->name('report.getBookRange.v2');

        Route::get('report/yearly', [ReportBookDiaryController::class, 'indexReportYearly'])->name('report.yearly.index');
        Route::get('report/yearly/year', [ReportBookDiaryController::class, 'getReportByYear'])->name('report.getBookRangeYear');

        Route::get('close-box/', [CloseBoxController::class, 'index'])->name('close.box.index');
        Route::get('close-box/close/{year}', [CloseBoxController::class, 'closeManagement'])->name('close.box.year.index');
        Route::post('close-box/close/', [CloseBoxController::class, 'closeManagementConfirm'])->name('close.box.year.confirm.index');



        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::get('/libro-pdf', [ReportBookDiaryController::class, 'showPdf'])->name('show.book.web.pdf');
        Route::get('/download-libro-pdf', [ReportBookDiaryController::class, 'downloadBooksPdf'])->name('download.book.pdf');

        Route::get('business',[BusinessController::class,'index'])->name('business.index');
        Route::put('business/{business}',[BusinessController::class,'update'])->name('business.update');
        Route::post('business/clear/report/public',[BusinessController::class,'clearReportPublic'])->name('business.clear.report.public');

        Route::get('users/',[UserController::class,'index'])->name('users.index');
        Route::post('users/',[UserController::class,'store'])->name('users.store');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('users/{user}/changeState', [UserController::class, 'changeState'])->name('user.change');
        Route::get('users/profile/{user}', [UserController::class, 'myProfile'])->name('user.profile');
        Route::put('users/profile/{user}/update', [UserController::class, 'myProfileUpdate'])->name('user.profile.update');


        /*Route::get('rols/',[RolController::class,'index'])->name('rols.index');
        Route::post('rols/',[RolController::class,'store'])->name('rols.store');
        Route::put('rols/{user}', [RolController::class, 'update'])->name('rols.update');
        Route::delete('rols/{user}', [RolController::class, 'destroy'])->name('user.destroy');
        Route::get('rols/{user}/changeState', [RolController::class, 'changeState'])->name('user.change');*/

    });
    Auth::routes();
});
