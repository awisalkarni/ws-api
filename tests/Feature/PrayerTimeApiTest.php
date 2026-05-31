<?php

use App\Models\PrayerTime;
use App\Models\Zone;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->zone = Zone::factory()->create([
        'code' => 'SGR01',
        'state' => 'Selangor',
    ]);
});

it('lists all zones', function () {
    Zone::factory()->create(['code' => 'JHR01']);

    $this->getJson('/api/v1/zones')
        ->assertSuccessful()
        ->assertJsonPath('data.0.code', 'JHR01')
        ->assertJsonPath('data.1.code', 'SGR01');
});

it('returns prayer times for today by default', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => today()->format('Y-m-d'),
    ]);

    $this->getJson("/api/v1/zones/{$this->zone->code}")
        ->assertSuccessful()
        ->assertJsonPath('data.0.date', today()->format('Y-m-d'))
        ->assertJsonPath('data.0.prayers.subuh', fn ($v) => ! empty($v));
});

it('returns prayer times for a specific date', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => '2026-06-15',
    ]);

    $this->getJson("/api/v1/zones/{$this->zone->code}?date=2026-06-15")
        ->assertSuccessful()
        ->assertJsonPath('data.0.date', '2026-06-15');
});

it('returns prayer times for a month', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => '2026-06-01',
    ]);
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => '2026-06-30',
    ]);

    $this->getJson("/api/v1/zones/{$this->zone->code}?month=6&year=2026")
        ->assertSuccessful()
        ->assertJsonCount(2, 'data');
});

it('returns empty array when no prayer times found for date', function () {
    $this->getJson("/api/v1/zones/{$this->zone->code}?date=2026-01-01")
        ->assertSuccessful()
        ->assertJsonCount(0, 'data');
});

it('returns today prayer time via today endpoint', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => today()->format('Y-m-d'),
        'subuh' => '05:50',
    ]);

    $this->getJson("/api/v1/prayer-times/today?zone={$this->zone->code}")
        ->assertSuccessful()
        ->assertJsonPath('data.prayers.subuh', '05:50');
});

it('returns 404 when today endpoint has no data', function () {
    $this->getJson("/api/v1/prayer-times/today?zone={$this->zone->code}")
        ->assertNotFound();
});

it('returns prayer time for specific date via date endpoint', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => '2026-12-25',
        'isyak' => '20:30',
    ]);

    $this->getJson("/api/v1/prayer-times/date/2026-12-25?zone={$this->zone->code}")
        ->assertSuccessful()
        ->assertJsonPath('data.prayers.isyak', '20:30');
});

it('includes zone info in prayer time response', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => today()->format('Y-m-d'),
    ]);

    $this->getJson("/api/v1/prayer-times/today?zone={$this->zone->code}")
        ->assertSuccessful()
        ->assertJsonPath('data.zone.code', 'SGR01')
        ->assertJsonPath('data.zone.state', 'Selangor');
});

it('includes dhuha in prayer times', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => today()->format('Y-m-d'),
        'subuh' => '05:48',
        'syuruk' => '07:10',
        'dhuha' => '07:39',
    ]);

    $this->getJson("/api/v1/prayer-times/today?zone={$this->zone->code}")
        ->assertSuccessful()
        ->assertJsonPath('data.prayers.dhuha', '07:39');
});
