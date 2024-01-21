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
//Route::get('form/delete{id}',[App\Http\Controllers\TestController::class,'delete']);
Route::get('form/deleteProduction{id}',[App\Http\Controllers\TestController::class,'deleteProduction']);

// report
Route::get('form/report',[App\Http\Controllers\ReportController::class,'report'])->name('form/report');
Route::get('form/export',[App\Http\Controllers\ReportController::class, 'exportData'])->name('form/export');

// form test request
Route::get('form/register',[App\Http\Controllers\LoginController::class,'index'])->name('form/register');
Route::post('form/request/save',[App\Http\Controllers\LoginController::class,'storeRegister'])->name('form/request/save');

// login
Route::get('form/login/view/new',[App\Http\Controllers\LoginController::class,'viewLogin'])->name('form/login/view/new');
Route::post('form/login',[App\Http\Controllers\LoginController::class,'login'])->name('form/login');
Route::get('form/logout',[App\Http\Controllers\LoginController::class,'logout'])->name('form/logout');

//RM
Route::get('rm/formin',[App\Http\Controllers\RMController::class,'viewDataIn'])->name('rm/formin');
Route::post('rm/datainsave',[App\Http\Controllers\RMController::class,'viewDataInSave'])->name('rm/datainsave');
Route::get('rm/formout',[App\Http\Controllers\RMController::class,'viewDataOut'])->name('rm/formout');
Route::post('rm/dataoutsave',[App\Http\Controllers\RMController::class,'viewDataOutSave'])->name('rm/dataoutsave');
Route::get('rm/report',[App\Http\Controllers\RMController::class,'viewDataReport'])->name('rm/report');
Route::post('rm/reportsave',[App\Http\Controllers\RMController::class,'viewDataReportSave'])->name('rm/reportsave');
Route::get('rm/downloadpdf{id}',[App\Http\Controllers\RMController::class,'downloadPdf']);
Route::get('rm/dataindelete{id}',[App\Http\Controllers\RMController::class,'datainDelete']);
Route::get('rm/dataoutdelete{id}',[App\Http\Controllers\RMController::class,'dataoutDelete']);

//settings
Route::get('form/addoperator',[App\Http\Controllers\SettingController::class,'viewOperator'])->name('form/addoperator');
Route::post('form/operatorsave',[App\Http\Controllers\SettingController::class,'saveOperator'])->name('form/operatorsave');
Route::get('form/deleteOperators{id}',[App\Http\Controllers\SettingController::class,'deleteOprator']);

Route::get('form/addmachine',[App\Http\Controllers\SettingController::class,'viewMachine'])->name('form/addmachine');
Route::post('form/machinesave',[App\Http\Controllers\SettingController::class,'saveMachine'])->name('form/machinesave');
Route::get('form/deleteMachines{id}',[App\Http\Controllers\SettingController::class,'deleteMachine']);

Route::get('form/addproduct',[App\Http\Controllers\SettingController::class,'viewProduct'])->name('form/addproduct');
Route::post('form/productsave',[App\Http\Controllers\SettingController::class,'saveProduct'])->name('form/productsave');
Route::get('form/deleteProducts{id}',[App\Http\Controllers\SettingController::class,'deleteProduct']);

Route::get('form/adduser',[App\Http\Controllers\SettingController::class,'viewUser'])->name('form/adduser');
Route::post('form/usersave',[App\Http\Controllers\SettingController::class,'saveUser'])->name('form/usersave');
Route::get('form/deleteUsers{id}',[App\Http\Controllers\SettingController::class,'deleteUser']);

Route::get('form/addsupplier',[App\Http\Controllers\SettingController::class,'viewSupplier'])->name('form/addsupplier');
Route::post('form/suppliersave',[App\Http\Controllers\SettingController::class,'saveSupplier'])->name('form/suppliersave');
Route::get('form/deleteSupplier{id}',[App\Http\Controllers\SettingController::class,'deleteSupplier']);

Route::get('form/addgrades',[App\Http\Controllers\SettingController::class,'viewGrades'])->name('form/addgrades');
Route::post('form/gradessave',[App\Http\Controllers\SettingController::class,'saveGrades'])->name('form/gradessave');
Route::get('form/deleteGrades{id}',[App\Http\Controllers\SettingController::class,'deleteGrades']);

Route::get('form/addsize',[App\Http\Controllers\SettingController::class,'viewSize'])->name('form/addsize');
Route::post('form/sizesave',[App\Http\Controllers\SettingController::class,'saveSize'])->name('form/sizesave');
Route::get('form/deleteSize{id}',[App\Http\Controllers\SettingController::class,'deleteSize']);


