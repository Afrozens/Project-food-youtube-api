<?php

use App\Http\Controllers\Admin\SoporteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SoporteController::class, 'index'])->name('index');
