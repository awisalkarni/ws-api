<?php

use App\Models\PrayerTime;
use App\Models\SyncLog;
use App\Models\Zone;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\artisan;

uses(LazilyRefreshDatabase::class);

function fakeSessionHeaders(): array
{
    return ['Set-Cookie' => 'PHPSESSID=fake_session_id; path=/'];
}

function fakeESolatResponse(string $subuh = '05:50', string $syuruk = '07:12'): array
{
    return [[
        'date' => '2026-06-15',
        'imsak' => '05:40',
        'subuh' => $subuh,
        'syuruk' => $syuruk,
        'zohor' => '13:15',
        'asar' => '16:35',
        'maghrib' => '19:21',
        'isyak' => '20:32',
    ]];
}

beforeEach(function () {
    Zone::factory()->create(['code' => 'SGR01']);
    Zone::factory()->create(['code' => 'JHR01']);
});

function fakeSuccess(): void
{
    Http::fake([
        'https://www.e-solat.gov.my/*' => function (Request $request) {
            $url = $request->url();

            if (str_contains($url, 'r=esolatApi')) {
                return Http::response(fakeESolatResponse());
            }

            return Http::response(
                '<html><head><script>var YII_CSRF_TOKEN = "fake-token";</script></head><body>Login</body></html>',
                200,
                fakeSessionHeaders()
            );
        },
    ]);
}

it('creates sync log entries for each zone', function () {
    fakeSuccess();

    artisan('solat:sync')->assertSuccessful();

    expect(SyncLog::count())->toBe(2);
    expect(SyncLog::where('status', 'success')->count())->toBe(2);
});

it('stores prayer times from external API', function () {
    fakeSuccess();

    artisan('solat:sync')->assertSuccessful();

    expect(PrayerTime::count())->toBe(2);
    expect(PrayerTime::first()->subuh->format('H:i'))->toBe('05:50');
    expect(PrayerTime::first()->dhuha->format('H:i'))->toBe('07:39');
});

it('calculates dhuha correctly using syuruk + ⅓(syuruk − subuh)', function () {
    fakeSuccess();

    artisan('solat:sync')->assertSuccessful();

    expect(PrayerTime::first()->dhuha->format('H:i'))->toBe('07:39');
});

it('deduplicates prayer times on repeated sync', function () {
    fakeSuccess();

    $zone = Zone::where('code', 'SGR01')->first();

    PrayerTime::factory()->create([
        'zone_id' => $zone->id,
        'date' => '2026-06-15',
    ]);

    artisan('solat:sync')->assertSuccessful();

    expect(PrayerTime::where('zone_id', $zone->id)->count())->toBe(1);
});

it('handles session init failure gracefully', function () {
    Http::fake([
        'https://www.e-solat.gov.my/*' => Http::response('Error', 500),
    ]);

    artisan('solat:sync');

    expect(PrayerTime::count())->toBe(0);
});
