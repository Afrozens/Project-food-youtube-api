<?php

use App\Http\Controllers\Dashboard\{ChatController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Message\MessageController;

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


Route::get('/', [ChatController::class, 'indexInertia'])->name('index');
//Route::get('/', [ChatController::class, 'edit'])->name('edit');
//Route::get('/messages', [MessageController::class, 'getMessages'])->name('messages');
