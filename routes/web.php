<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::livewire('login', 'pages::auth.login')->name('login');
Route::middleware('auth')->group(function () {
    Route::livewire('/', 'pages::dashboard.index')->name('dashboard');
    Route::livewire('students', 'pages::students.index')->name('students');
    Route::livewire('users', 'pages::users.index')->name('users');
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});