<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::livewire('login', 'pages::auth.login')->name('login');
Route::middleware('auth')->group(function () {
    Route::livewire('/', 'pages::dashboard.index')->name('dashboard');
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});