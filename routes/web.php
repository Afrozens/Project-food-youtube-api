<?php

use App\Http\Controllers\Dashboard\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Video\VideoController;
use App\Http\Controllers\Video\CommentController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\ProfileController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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


Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('index');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('/videos')->name('videos.')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('index');
    Route::get('/{video:id}', [VideoController::class, 'show'])->name('show');

    Route::prefix('/{video:id}/comments')->name('comments.')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('index');
    });
});

Route::get('google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('google-auth/callback', function () {
    $user_google = Socialite::driver('google')->stateless()->user();

    $user = User::updateOrCreate([
        'provider_id' => $user_google->id,
    ], [
        'name' => $user_google->name,
        'email' => $user_google->email,
        'nickname' => $user_google->nickname ?? '',
        'img_url' => $user_google->avatar ?? null,
    ]);

    Auth::login($user);
    return redirect('/dashboard');
});

Route::get('facebook-auth/redirect', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('facebook-auth/callback', function () {
    $user_facebook = Socialite::driver('facebook')->stateless()->user();

    $user = User::updateOrCreate([
        'provider_id' => $user_facebook->id,
    ], [
        'name' => $user_facebook->name,
        'email' => $user_facebook->email,
        'nickname' => $user_facebook->nickname ?? '',
        'img_url' => $user_facebook->avatar ?? null,
    ]);

    Auth::login($user);
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::prefix('/videos/{video:id}/comments')->name('videos.comments.')->group(function () {
        Route::post('/', [CommentController::class, 'store'])->name('store');
        Route::put('/{comment:id}', [CommentController::class, 'update'])->name('update');
        Route::delete('/{comment:id}', [CommentController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/{id}/{userreceiver}', [MessageController::class, 'inbox_user'])->name('inbox_user');
        Route::post('/', [MessageController::class, 'store'])->name('store');
        Route::put('/{id}', [MessageController::class, 'update'])->name('update');
        Route::delete('/{id}', [MessageController::class, 'destroy'])->name('destroy');
    });

    Route::resource("chats", ChatController::class)->parameters(["chats" => "id"]);


    Route::prefix('/dashboard')
        ->name('dashboard.')
        ->group(base_path('routes/web/dashboard.php'));

    Route::prefix('/admin')
        ->middleware(['role:admin|Super Admin'])
        ->name('admin.')
        ->group(base_path('routes/web/admin.php'));
});

Route::get('/symlink', function () {
    Artisan::call('storage:link');
});

Route::get('/cache-clear', function () {
    Artisan::call('optimize');
});

require __DIR__ . '/auth.php';
