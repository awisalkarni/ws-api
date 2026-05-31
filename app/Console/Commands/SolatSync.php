<?php

namespace App\Console\Commands;

use App\Models\PrayerTime;
use App\Models\SyncLog;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SolatSync extends Command
{
    protected $signature = 'solat:sync {zone? : Zone code to sync (e.g., SGR01)}';

    protected $description = 'Sync prayer times from e-solat.gov.my';

    private const BASE_URL = 'https://www.e-solat.gov.my';

    private string $sessionId = '';

    private string $csrfToken = '';

    public function handle(): int
    {
        $zoneCode = $this->argument('zone');
        $zones = $zoneCode
            ? Zone::where('code', $zoneCode)->get()
            : Zone::orderBy('code')->get();

        if ($zones->isEmpty()) {
            $this->error($zoneCode ? "Zone not found: {$zoneCode}" : 'No zones found in database. Run ZoneSeeder first.');

            return self::FAILURE;
        }

        $year = now()->year;

        $this->info('Initializing e-Solat session...');

        if (! $this->initializeSession()) {
            $this->error('Failed to initialize e-Solat session.');

            return self::FAILURE;
        }

        $this->info("Syncing {$zones->count()} zone(s) for year {$year}...");

        $bar = $this->output->createProgressBar($zones->count());
        $bar->start();

        foreach ($zones as $zone) {
            try {
                $count = $this->syncZone($zone, $year);

                SyncLog::create([
                    'zone_code' => $zone->code,
                    'year' => $year,
                    'status' => 'success',
                    'records_created' => $count,
                ]);

                $bar->advance();
            } catch (\Exception $e) {
                SyncLog::create([
                    'zone_code' => $zone->code,
                    'year' => $year,
                    'status' => 'failed',
                    'records_created' => 0,
                    'error_message' => $e->getMessage(),
                ]);

                $this->warn("\nFailed to sync {$zone->code}: {$e->getMessage()}");
            }

            usleep(500000);
        }

        $bar->finish();
        $this->newLine();
        $this->info('Sync complete.');

        return self::SUCCESS;
    }

    private function initializeSession(): bool
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            ])
            ->get(self::BASE_URL.'/index.php?siteId=24&pageId=24');

        if (! $response->successful()) {
            return false;
        }

        $setCookie = $response->header('Set-Cookie');

        if ($setCookie && preg_match('/PHPSESSID=([^;]+)/', $setCookie, $m)) {
            $this->sessionId = $m[1];
        }

        $body = $response->body();

        if (preg_match('/YII_CSRF_TOKEN\s*=\s*[\'"]([^\'"]+)[\'"]/', $body, $matches)) {
            $this->csrfToken = $matches[1];
        } elseif (preg_match('/name="_csrf"[^>]*value="([^"]+)"/', $body, $matches)) {
            $this->csrfToken = $matches[1];
        }

        if (empty($this->sessionId)) {
            $this->error('Failed to get PHPSESSID.');

            return false;
        }

        if (empty($this->csrfToken)) {
            $this->warn('CSRF token extraction from page source failed, continuing without token...');
            $this->csrfToken = '';
        }

        return true;
    }

    private function syncZone(Zone $zone, int $year): int
    {
        $cookieHeader = 'PHPSESSID='.$this->sessionId;
        if ($this->csrfToken) {
            $cookieHeader .= '; YII_CSRF_TOKEN='.$this->csrfToken;
        }

        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                'Accept' => '*/*',
                'Referer' => self::BASE_URL.'/index.php?siteId=24&pageId=24',
                'X-Requested-With' => 'XMLHttpRequest',
            ])
            ->withCookies([
                'PHPSESSID' => $this->sessionId,
                'YII_CSRF_TOKEN' => $this->csrfToken,
            ], parse_url(self::BASE_URL, PHP_URL_HOST))
            ->get(self::BASE_URL.'/index.php', [
                'r' => 'esolatApi/takwimsolat',
                'period' => 'year',
                'zone' => $zone->code,
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException("HTTP {$response->status()} for zone {$zone->code}");
        }

        $data = $response->json();

        if (! is_array($data)) {
            throw new \RuntimeException("Invalid response format for zone {$zone->code}");
        }

        if (empty($data)) {
            throw new \RuntimeException("Empty response for zone {$zone->code}");
        }

        $count = 0;

        foreach ($data as $entry) {
            $date = $entry['date'] ?? null;
            $imsak = $entry['imsak'] ?? null;
            $subuh = $entry['subuh'] ?? null;
            $syuruk = $entry['syuruk'] ?? null;
            $zohor = $entry['zohor'] ?? null;
            $asar = $entry['asar'] ?? null;
            $maghrib = $entry['maghrib'] ?? null;
            $isyak = $entry['isyak'] ?? null;

            if (! $date || ! $subuh) {
                continue;
            }

            $syurukCarbon = $syuruk ? Carbon::createFromFormat('H:i', $syuruk) : null;
            $subuhCarbon = $subuh ? Carbon::createFromFormat('H:i', $subuh) : null;
            $dhuha = PrayerTime::calculateDhuha($syurukCarbon, $subuhCarbon)?->format('H:i') ?? '00:00';

            $result = PrayerTime::updateOrCreate(
                [
                    'zone_id' => $zone->id,
                    'date' => $date,
                ],
                [
                    'imsak' => $imsak ?: '00:00',
                    'subuh' => $subuh ?: '00:00',
                    'syuruk' => $syuruk ?: '00:00',
                    'zohor' => $zohor ?: '00:00',
                    'asar' => $asar ?: '00:00',
                    'maghrib' => $maghrib ?: '00:00',
                    'isyak' => $isyak ?: '00:00',
                    'dhuha' => $dhuha,
                ]
            );

            if ($result->wasRecentlyCreated) {
                $count++;
            }
        }

        return $count;
    }
}
