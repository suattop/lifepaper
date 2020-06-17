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

Route::get('/', 'PagesController@index')->name('/home');
Route::get('destiny/create', 'DestinyController@create')->name('destiny.create');
Route::post('destiny', 'DestinyController@store')->name('destiny.store');
Route::get('destiny/{destiny}', 'DestinyController@show')->name('destiny.show');


Auth::routes(['verify' => true]);


