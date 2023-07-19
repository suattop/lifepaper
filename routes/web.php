<?php

use App\Http\Controllers\DestinyController;
use App\Http\Controllers\PagesController;
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

Route::get('/', [PagesController::class, 'index'])->name('/home');
Route::get('destiny/create', [DestinyController::class, 'create'])->name('destiny.create');
Route::post('destiny', [DestinyController::class, 'store'])->name('destiny.store');
Route::get('destiny/{destiny}', [DestinyController::class, 'show'])->name('destiny.show');

Auth::routes(['verify' => true]);
