<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/docs', 'docs.index');

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])
    ->name('admin.login')
    ->middleware('guest');

Route::post('/admin/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::post('/admin/logout', [AuthController::class, 'logout'])
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
