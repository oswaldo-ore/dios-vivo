<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryController;
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

    Route::get('report', [ReportBookDiaryController::class, 'index'])->name('report.book.index');
    Route::get('report/range', [ReportBookDiaryController::class, 'getBookRange'])->name('report.getBookRange');

    Route::get('report/yearly', [ReportBookDiaryController::class, 'indexReportYearly'])->name('report.yearly.index');
    Route::get('report/yearly/year', [ReportBookDiaryController::class, 'getReportByYear'])->name('report.getBookRangeYear');

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/libro-pdf', [ReportBookDiaryController::class, 'showPdf'])->name('show.book.web.pdf');
    Route::get('/download-libro-pdf', [ReportBookDiaryController::class, 'downloadBooksPdf'])->name('download.book.pdf');

    Route::get('business',[BusinessController::class,'index'])->name('business.index');
    Route::put('business/{business}',[BusinessController::class,'update'])->name('business.update');

    Route::get('users/',[UserController::class,'index'])->name('users.index');
    Route::post('users/',[UserController::class,'store'])->name('users.store');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('users/{user}/changeState', [UserController::class, 'changeState'])->name('user.change');


    Route::get('rols/',[RolController::class,'index'])->name('rols.index');
    Route::post('rols/',[RolController::class,'store'])->name('rols.store');
    Route::put('rols/{user}', [RolController::class, 'update'])->name('rols.update');
    Route::delete('rols/{user}', [RolController::class, 'destroy'])->name('user.destroy');
    Route::get('rols/{user}/changeState', [RolController::class, 'changeState'])->name('user.change');

});
Auth::routes();
