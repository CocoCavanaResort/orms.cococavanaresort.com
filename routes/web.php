<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');

    Route::prefix('booking')->middleware('can:manage-booking')->group(function () {
        Route::prefix('rooms')->middleware('can:manage-rooms')->group(function () {
            Route::livewire('/','pages::booking.rooms')->name('rooms');
            Route::livewire('/add', 'pages::booking.rooms.add-room')->name('rooms.add');
            Route::livewire('/edit/{id}', 'pages::booking.rooms.edit-room')->name('rooms.edit');
        });

        Route::prefix('reservations')->middleware('can:manage-reservations')->group(function () {
            Route::livewire('/','pages::booking.reservations')->name('reservations');
            Route::livewire('/add', 'pages::booking.reservations.add-reservation')->name('reservations.add');
            Route::livewire('/edit/{id}', 'pages::booking.reservations.edit-reservation')->name('reservations.edit');
        });

        Route::prefix('discounts')->middleware('can:manage-discounts')->group(function () {
            Route::livewire('/','pages::booking.discounts')->name('discounts');
            Route::livewire('/add', 'pages::booking.discounts.add-discount')->name('discounts.add');
            Route::livewire('/edit/{id}', 'pages::booking.discounts.edit-discount')->name('discounts.edit');
        });

        Route::prefix('customers')->middleware('can:manage-customers')->group(function () {
            Route::livewire('/','pages::booking.customers')->name('customers');
            Route::livewire('/add', 'pages::booking.customers.add-customer')->name('customers.add');
            Route::livewire('/edit/{id}', 'pages::booking.customers.edit-customer')->name('customers.edit');
        });

        Route::prefix('payments')->middleware('can:manage-payments')->group(function () {
            Route::livewire('/','pages::booking.payments')->name('payments');
            Route::livewire('/add', 'pages::booking.payments.add-payment')->name('payments.add');
            Route::livewire('/edit/{id}', 'pages::booking.payments.edit-payment')->name('payments.edit');
        });
    });

    Route::prefix('settings')->middleware('can:access-system-settings')->group(function () {
        Route::livewire('/users', 'pages::system.users')->name('users');
        Route::livewire('/users/add', 'pages::settings.users.add-user')->name('users.add');
        Route::livewire('/users/edit/{id}', 'pages::settings.users.edit-user')->name('users.edit');

        Route::livewire('/roles-and-permissions','pages::system.roles-and-permissions')->name('roles-and-permissions');
        Route::livewire('/roles/add', 'pages::settings.roles.add-role')->name('roles.add');
        Route::livewire('/roles/edit/{id}', 'pages::settings.roles.edit-role')->name('roles.edit');
    });

    Route::prefix('branches')->middleware('can:manage-branches')->group(function () {
        Route::livewire('/','pages::property.branches')->name('branches');
        Route::livewire('/add', 'pages::settings.branches.add-branch')->name('branches.add');
        Route::livewire('/edit/{id}', 'pages::settings.branches.edit-branch')->name('branches.edit');
    });
});

Route::middleware('guest')->group(function () {
    Route::livewire('/auth/login','pages::auth.login')->name('login');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');