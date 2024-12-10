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
    Route::get('/index/show_all/{type}', 'show')->name('loc.show');
    Route::get('/detail_pw/{id_parent}', 'detail')->name('loc.detail');
    Route::get('/detail_beer/{id_parent}', 'detail_beer')->name('loc.detail_beer');
    Route::get('/edit/{type}/{id_parent}', 'edit')->name('loc.edit');
    Route::get('/create/{type}', 'create')->name('loc.create');
    Route::get('/re_edit/{type}', 're_edit')->name('loc.re_edit');
    Route::get('/import-file', 'showUiCSV')->name('loc.importFile');

    Route::post('/update/update_csv', 'updateDataCSV')->name('loc.UpdateCsv');    
    Route::post('/create/import_csv', 'importCsv')->name('loc.import_csv');
    Route::post('/re_edit/update/loc_datetime', 'updateLocDate')->name('loc.reUpdateDateLoc');    // url temp fix after done ver1
    Route::post('/re_edit/update/update-all', 'updateAllLoc')->name('loc.reUpdateAllLoc');    // url temp fix after done ver1
}); 