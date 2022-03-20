<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
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

Route::get('/', [StudentController::class, 'index'])->name('index');
Route::get('/create', [StudentController::class, 'create'])->name('create');
Route::post('/', [StudentController::class, 'store'])->name('store');
Route::match(['get', 'post'], '/student-dt', [StudentController::class, 'studentsDatatable'])->name('students-dt');
