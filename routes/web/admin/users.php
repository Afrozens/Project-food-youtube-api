<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

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

Route::get('/', [UserController::class, 'index'])->name('index');

Route::get('/create', [UserController::class, 'create'])->name('create');

Route::post('/', [UserController::class, 'store'])->name('store');

Route::get('/{user:id}', [UserController::class, 'edit'])->name('edit');

Route::put('/{user:id}', [UserController::class, 'update'])->name('update');

Route::delete('/{user:id}', [UserController::class, 'destroy'])->name('destroy');

Route::put('/{user:id}/to-admin', [UserController::class, 'to_admin'])->name('to_admin');