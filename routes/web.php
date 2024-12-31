<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LineOfCodeController;
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
    // return view('welcome');
    return view('dashboard.index'); // temp URL -- after complete screen Analytics -> change URL
});


Route::group(['prefix' => '_admin/dashboard', 'controller'  => DashboardController::class], function(){
    Route::get('/index', 'index')->name('dashboard.index');
});

Route::group(['prefix' => '_admin/loc', 'controller'  => LineOfCodeController::class], function(){
    Route::get('/index/{type}', 'index')->name('loc.index'); // temp URL - phare2 update in branh update
    Route::get('/index/report/{type}', 'show')->name('loc.show');
    Route::get('/detail_pw/{id_parent}', 'detail')->name('loc.detail');
    Route::get('/detail_beer/{id_parent}', 'detail_beer')->name('loc.detail_beer');
    Route::get('/edit/{type}/{id_parent}', 'edit')->name('loc.edit');
    Route::get('/create/{type}', 'create')->name('loc.create');
    Route::get('/re_edit/{type}', 're_edit')->name('loc.re_edit');
    Route::get('/import-file', 'showUiCSV')->name('loc.importFile');

    Route::post('/cacu_total/{type}', 'updateToTal')->name('loc.cacu_total');

    Route::post('/getHistory', 'getHistoryOfTask')->name('loc.getHistory'); // Ajax get history data in screen re_edit
    Route::post('/update/update_csv', 'updateDataCSV')->name('loc.UpdateCsv'); // Ajax update data in screen re_edit call from import csv  
    Route::post('/create/import_csv', 'importCsv')->name('loc.import_csv'); // Ajax update data in screen re_edit call from import csv  
    
    Route::post('/re_edit/update/runtime', 'updateRuntime')->name('loc.reUpdateDateLoc');    // Ajax update data in screen re_edit
    Route::post('/re_edit/update/update-all', 'updateAllLoc')->name('loc.reUpdateAllLoc');    // Ajax update all data in screen re_edit
    Route::post('/update-old-data', 'update')->name('loc.updateOldData');    // Ajax update data in screen re_edit 
});