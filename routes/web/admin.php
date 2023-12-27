<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('/tags')
	->name('tags.')
	->group(base_path('routes/web/admin/tags.php'));

Route::prefix('/videos')
	->name('videos.')
	->group(base_path('routes/web/admin/videos.php'));

Route::prefix('/chats')
	->name('chats.')
	->group(base_path('routes/web/admin/other.php'));

Route::middleware('role:Super Admin')->prefix('/users')
	->name('users.')
	->group(base_path('routes/web/admin/users.php'));
