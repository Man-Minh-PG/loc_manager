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
    Route::get('/index', 'index')->name('loc.index'); // temp URL - phare2 update in branh update
    Route::get('/index/show_all', 'show')->name('loc.show');
    Route::get('/detail/123', 'detail')->name('loc.detail');
    Route::get('/edit/123', 'edit')->name('loc.edit');
    Route::get('/create', 'create')->name('loc.create');
}); 