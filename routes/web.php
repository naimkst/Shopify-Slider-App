<?php

use Illuminate\Support\Facades\Log;
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

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/', function () {
//    return view('welcome');
//})->middleware(['verify.shopify'])->name('home');

Route::middleware(['verify.shopify', 'billable'])->group(function (){
    Route::get('/', 'App\Http\Controllers\DashboardController@dashboard')->name('dashboard');
    Route::get('/home', 'App\Http\Controllers\DashboardController@home')->name('home');
    Route::get('/theme', 'App\Http\Controllers\DashboardController@getTheme')->name('getTheme');
    Route::get('/documentation', 'App\Http\Controllers\DashboardController@documentation')->name('documentation');
    Route::post('/slider-switch', 'App\Http\Controllers\DashboardController@sliderOnOff')->name('sliderOnOff');
});
Route::post('/webhook/app/uninstalled', 'App\Http\Controllers\DashboardController@uninstall')->name('uninstall')->middleware('auth.webhook');

Route::post('/webhooks', function()
{
    Log::info('workingg..................................');

});
//Route::post('/slider-switch', 'App\Http\Controllers\DashboardController@sliderOnOff')->name('sliderOnOff')->middleware("auth.custom.shopify", 'verify.shopify');

//Route::group(['middleware' => ['verify.shopify']], function () {
//
//});
