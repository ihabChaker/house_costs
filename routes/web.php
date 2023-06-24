<?php

use App\Http\Controllers\HouseController;
use App\Http\Controllers\SpenderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('house1');
});
Route::resource('house-expenses', HouseController::class);
Route::resource('spenders', SpenderController::class);
Route::get('house-expenses-1', [HouseController::class, 'indexHouse1'])->name('house1');
Route::get('house-expenses-2', [HouseController::class, 'indexHouse2']);
Route::get('spenders-select-data', [SpenderController::class, 'generateSelectOptions'])->name('select.spenders');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
