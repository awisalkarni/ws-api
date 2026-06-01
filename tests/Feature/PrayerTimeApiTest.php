<?php

use App\Models\PrayerTime;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->zone = Zone::factory()->create([
        'code' => 'SGR01',
        'state' => 'Selangor',
    ]);

    $this->user = User::factory()->create([
        'name' => 'API Tester',
        'email' => 'tester@example.com',
        'api_key' => 'ws_test_api_key_12345',
    ]);

    $this->apiKey = $this->user->api_key;
    $this->headers = ['Authorization' => 'Bearer '.$this->apiKey];
});

it('lists all zones', function () {
    Zone::factory()->create(['code' => 'JHR01']);

    $this->withHeaders($this->headers)
        ->getJson('/api/v1/zones')
        ->assertSuccessful()
        ->assertJsonPath('data.0.code', 'JHR01')
        ->assertJsonPath('data.1.code', 'SGR01');
});

it('returns prayer times for today by default', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => today()->format('Y-m-d'),
    ]);

    $this->withHeaders($this->headers)
        ->getJson("/api/v1/zones/{$this->zone->code}")
        ->assertSuccessful()
        ->assertJsonPath('data.0.date', today()->format('Y-m-d'))
        ->assertJsonPath('data.0.prayers.subuh', fn ($v) => ! empty($v));
});

it('returns prayer times for a specific date', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => '2026-06-15',
    ]);

    $this->withHeaders($this->headers)
        ->getJson("/api/v1/zones/{$this->zone->code}?date=2026-06-15")
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

    $this->withHeaders($this->headers)
        ->getJson("/api/v1/zones/{$this->zone->code}?month=6&year=2026")
        ->assertSuccessful()
        ->assertJsonCount(2, 'data');
});

it('returns empty array when no prayer times found for date', function () {
    $this->withHeaders($this->headers)
        ->getJson("/api/v1/zones/{$this->zone->code}?date=2026-01-01")
        ->assertSuccessful()
        ->assertJsonCount(0, 'data');
});

it('returns today prayer time via today endpoint', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => today()->format('Y-m-d'),
        'subuh' => '05:50',
    ]);

    $this->withHeaders($this->headers)
        ->getJson("/api/v1/prayer-times/today?zone={$this->zone->code}")
        ->assertSuccessful()
        ->assertJsonPath('data.prayers.subuh', '05:50');
});

it('returns 404 when today endpoint has no data', function () {
    $this->withHeaders($this->headers)
        ->getJson("/api/v1/prayer-times/today?zone={$this->zone->code}")
        ->assertNotFound();
});

it('returns prayer time for specific date via date endpoint', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => '2026-12-25',
        'isyak' => '20:30',
    ]);

    $this->withHeaders($this->headers)
        ->getJson("/api/v1/prayer-times/date/2026-12-25?zone={$this->zone->code}")
        ->assertSuccessful()
        ->assertJsonPath('data.prayers.isyak', '20:30');
});

it('includes zone info in prayer time response', function () {
    PrayerTime::factory()->create([
        'zone_id' => $this->zone->id,
        'date' => today()->format('Y-m-d'),
    ]);

    $this->withHeaders($this->headers)
        ->getJson("/api/v1/prayer-times/today?zone={$this->zone->code}")
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

    $this->withHeaders($this->headers)
        ->getJson("/api/v1/prayer-times/today?zone={$this->zone->code}")
        ->assertSuccessful()
        ->assertJsonPath('data.prayers.dhuha', '07:39');
});

it('rejects requests without api key', function () {
    $this->getJson('/api/v1/zones')
        ->assertStatus(401)
        ->assertJson(['message' => 'API key is required.']);
});

it('rejects requests with invalid api key', function () {
    $this->withHeaders(['Authorization' => 'Bearer invalid_key'])
        ->getJson('/api/v1/zones')
        ->assertStatus(401)
        ->assertJson(['message' => 'Invalid API key.']);
});

it('accepts api key via query parameter', function () {
    $this->getJson("/api/v1/zones?api_key={$this->apiKey}")
        ->assertSuccessful();
});

it('registers a new user and returns api key', function () {
    $this->postJson('/api/v1/register', [
        'name' => 'New User',
        'email' => 'new@example.com',
    ])
        ->assertCreated()
        ->assertJsonPath('data.name', 'New User')
        ->assertJsonPath('data.email', 'new@example.com')
        ->assertJsonStructure(['data' => ['api_key']]);
});

it('validates registration fields', function () {
    $this->postJson('/api/v1/register', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'email']);
});
