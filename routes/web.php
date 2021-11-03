<?php

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

Route::group(['middleware' => ['verify.shopify']], function () {
    Route::get('/', 'App\Http\Controllers\DashboardController@dashboard')->name('dashboard');
    Route::get('/home', 'App\Http\Controllers\DashboardController@home')->name('home');
    Route::get('/theme', 'App\Http\Controllers\DashboardController@getTheme')->name('getTheme');
});
Route::post('/slider-switch', 'App\Http\Controllers\DashboardController@sliderOnOff')->name('sliderOnOff');


