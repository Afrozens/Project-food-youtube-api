<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;

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


Route::get('/', [TagController::class, 'index'])->name('index');
Route::post('/', [TagController::class, 'store'])->name('store');
Route::put('/{tag}', [TagController::class, 'update'])->name('update');
Route::delete('/{tag}', [TagController::class, 'destroy'])->name('destroy');