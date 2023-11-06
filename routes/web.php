<?php

use App\Http\Controllers\ProfileController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Inertia\Inertia;

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return Inertia::render('Index');
})->middleware(['auth', 'verified'])->name('index');
;

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

Route::get('disqus-auth/redirect', function () {
    return Socialite::driver('disqus')->redirect();
});

Route::get('disqus-auth/callback', function () {
    $user_disqus = Socialite::driver('disqus')->stateless()->user();

    $user = User::updateOrCreate([
        'provider_id' => $user_disqus->id,
    ], [
        'name' => $user_disqus->name,
        'email' => $user_disqus->email,
        'nickname' => $user_disqus->nickname ?? '',
        'img_url' => $user_disqus->avatar ?? null,
    ]);

    Auth::login($user);
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
