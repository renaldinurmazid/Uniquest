<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// FIX: Aktifkan route '/' dengan logic redirect
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::livewire('login', 'pages::auth.login')->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', \App\Livewire\Dashboard\Index::class)->name('dashboard');

    // ... rute lainnya tetap sama ...
    Route::get('/quests', \App\Livewire\Quest\Index::class)->name('quests');
    Route::get('/leaderboard', \App\Livewire\Leaderboard\Index::class)->name('leaderboard');
    Route::get('/campus-insight', \App\Livewire\CampusInsight\Index::class)->name('campus-insight');
    Route::get('/organizations', \App\Livewire\Organizations\Index::class)->name('organizations');
    Route::get('/skills', \App\Livewire\Skills\Index::class)->name('skills');
    Route::get('/achievements', \App\Livewire\Achievements\Index::class)->name('achievements');
    Route::get('/point-shop', \App\Livewire\PointShop\Index::class)->name('point-shop');
    Route::get('/verification', \App\Livewire\Verification\Index::class)->name('verification');
    Route::get('/students', \App\Livewire\Students\Index::class)->name('students');
    Route::get('/users', \App\Livewire\Users\Index::class)->name('users');
    Route::get('/roles', \App\Livewire\Roles\Index::class)->name('roles');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
