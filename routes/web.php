<?php

use App\Http\Controllers\EmployeeController;
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

Route::resource('house-expenses', HouseController::class);
Route::get('house-expenses-1', [HouseController::class, 'indexHouse1'])->name('house1');
Route::get('house-expenses-2', [HouseController::class, 'indexHouse2']);
Route::get('employees-select-data', [EmployeeController::class, 'generateSelectOptions'])->name('select.employees');
Route::redirect('/', 'house-expenses-1', 301);