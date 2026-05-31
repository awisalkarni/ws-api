<?php

use App\Http\Controllers\Api\V1\PrayerTimeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/zones', [PrayerTimeController::class, 'zones']);
    Route::get('/zones/{zone}', [PrayerTimeController::class, 'zone']);
    Route::get('/prayer-times/today', [PrayerTimeController::class, 'today']);
    Route::get('/prayer-times/date/{date}', [PrayerTimeController::class, 'date'])->where('date', '\d{4}-\d{2}-\d{2}');
});
