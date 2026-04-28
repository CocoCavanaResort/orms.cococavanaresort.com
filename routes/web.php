<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::livewire('/auth/login','pages::auth.login')->name('login');
});