<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;

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
    return view('login');
})->name('/');

// Home
Route::get('home/page',[App\Http\Controllers\HomeController::class,'userChart'])->name('home/page');
Route::get('home/save',[App\Http\Controllers\ChartController::class,'userChart1'])->name('home/save');

// route test 
Route::get('form/personal/new',[App\Http\Controllers\TestController::class,'viewTest'])->name('form/personal/new');
Route::post('form/page_test/save',[App\Http\Controllers\TestController::class,'viewTestSave'])->name('form/page_test/save');
Route::post('form/update',[App\Http\Controllers\TestController::class,'update'])->name('form/update');
Route::get('form/delete{id}',[App\Http\Controllers\TestController::class,'delete']);

// report
Route::get('form/report',[App\Http\Controllers\ReportController::class,'report'])->name('form/report');

// form test request
Route::get('form/register',[App\Http\Controllers\LoginController::class,'index'])->name('form/register');
Route::post('form/request/save',[App\Http\Controllers\LoginController::class,'storeRegister'])->name('form/request/save');

// login
Route::get('form/login/view/new',[App\Http\Controllers\LoginController::class,'viewLogin'])->name('form/login/view/new');
Route::post('form/login',[App\Http\Controllers\LoginController::class,'login'])->name('form/login');
Route::get('form/logout',[App\Http\Controllers\LoginController::class,'logout'])->name('form/logout');

Route::get('/chart',[App\Http\Controllers\ChartController::class,'userChart']);