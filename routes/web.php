<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');
    Route::livewire('/users', 'pages::system.users')->name('users');
    Route::livewire('/roles-and-permissions','pages::system.roles-and-permissions')->name('roles-and-permissions');

    Route::prefix('settings')->group(function () {
        Route::middleware('can:access-system-settings')->group(function () {
            Route::livewire('/users/add', 'pages::settings.users.add-user')->name('users.add');
            Route::livewire('/users/edit/{id}', 'pages::settings.users.edit-user')->name('users.edit');
            Route::livewire('/roles/add', 'pages::settings.roles.add-role')->name('roles.add');
            Route::livewire('/roles/edit/{id}', 'pages::settings.roles.edit-role')->name('roles.edit');
        });
    });
});

Route::middleware('guest')->group(function () {
    Route::livewire('/auth/login','pages::auth.login')->name('login');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');