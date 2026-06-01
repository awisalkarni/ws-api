<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Consumer\AuthController as ConsumerAuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/docs', 'docs.index')->name('docs');

Route::get('/register', [ConsumerAuthController::class, 'showRegisterForm'])
    ->name('consumer.register')
    ->middleware('guest');

Route::post('/register', [ConsumerAuthController::class, 'register'])
    ->middleware('guest');

Route::get('/login', [ConsumerAuthController::class, 'showLoginForm'])
    ->name('consumer.login')
    ->middleware('guest');

Route::post('/login', [ConsumerAuthController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [ConsumerAuthController::class, 'logout'])
    ->name('consumer.logout')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::livewire('dashboard', 'consumer.dashboard')
        ->name('consumer.dashboard');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])
    ->name('admin.login')
    ->middleware('guest');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->middleware('guest');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout')
    ->middleware('auth');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::livewire('dashboard', 'admin.dashboard')
        ->name('dashboard');

    Route::livewire('zones', 'admin.zones')
        ->name('zones');

    Route::livewire('zones/{zone}/edit', 'admin.zone-edit')
        ->name('zones.edit');

    Route::livewire('zones/{zone}', 'admin.zone-show')
        ->name('zones.show');

    Route::livewire('prayer-times', 'admin.prayer-times')
        ->name('prayer-times');

    Route::livewire('prayer-times/{prayerTime}/edit', 'admin.prayer-time-edit')
        ->name('prayer-times.edit');

    Route::livewire('sync-logs', 'admin.sync-logs')
        ->name('sync-logs');
});
