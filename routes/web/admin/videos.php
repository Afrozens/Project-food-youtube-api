<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VideoController;

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
Route::get('/', [VideoController::class, 'index'])->name('index');
Route::post('/', [VideoController::class, 'store'])->name('store');
Route::get('/create', [VideoController::class, 'create'])->name('create');
Route::post('/youtube-info', [VideoController::class, 'youtubeInfo'])->name('youtube.info');
Route::get('/{video:id}', [VideoController::class, 'show'])->name('show');
Route::get('/{video:id}/edit', [VideoController::class, 'edit'])->name('edit');
Route::put('/{video:id}', [VideoController::class, 'update'])->name('update');
Route::delete('/{video:id}', [VideoController::class, 'destroy'])->name('destroy');