<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');

    Route::prefix('booking')->middleware('can:manage-booking')->group(function () {

    });

    Route::prefix('settings')->middleware('can:access-system-settings')->group(function () {
        Route::livewire('/users', 'pages::system.users')->name('users');
        Route::livewire('/users/add', 'pages::settings.users.add-user')->name('users.add');
        Route::livewire('/users/edit/{id}', 'pages::settings.users.edit-user')->name('users.edit');

        Route::livewire('/roles-and-permissions','pages::system.roles-and-permissions')->name('roles-and-permissions');
        Route::livewire('/roles/add', 'pages::settings.roles.add-role')->name('roles.add');
        Route::livewire('/roles/edit/{id}', 'pages::settings.roles.edit-role')->name('roles.edit');
    });
    
    Route::prefix('property')->middleware('can:manage-property')->group(function () {
        Route::livewire('/branches','pages::property.branches')->name('branches');
        Route::livewire('/branches/add', 'pages::settings.branches.add-branch')->name('branches.add');
        Route::livewire('/branches/edit/{id}', 'pages::settings.branches.edit-branch')->name('branches.edit');

        Route::livewire('/rooms','pages::property.rooms')->name('rooms');
        Route::livewire('/rooms/add', 'pages::settings.rooms.add-room')->name('rooms.add');
        Route::livewire('/rooms/edit/{id}', 'pages::settings.rooms.edit-room')->name('rooms.edit');
    });
});

Route::middleware('guest')->group(function () {
    Route::livewire('/auth/login','pages::auth.login')->name('login');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');