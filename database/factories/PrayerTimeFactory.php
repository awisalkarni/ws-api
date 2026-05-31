<?php

namespace Database\Factories;

use App\Models\PrayerTime;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PrayerTime>
 */
class PrayerTimeFactory extends Factory
{
    public function definition(): array
    {
        $subuh = Carbon::createFromTime(5, fake()->numberBetween(30, 55));
        $syuruk = Carbon::createFromTime(7, fake()->numberBetween(0, 15));
        $zohor = Carbon::createFromTime(13, fake()->numberBetween(15, 30));
        $asar = Carbon::createFromTime(16, fake()->numberBetween(30, 45));
        $maghrib = Carbon::createFromTime(19, fake()->numberBetween(15, 30));
        $isyak = Carbon::createFromTime(20, fake()->numberBetween(30, 45));

        return [
            'zone_id' => Zone::factory(),
            'date' => fake()->dateTimeBetween('2026-01-01', '2026-12-31')->format('Y-m-d'),
            'imsak' => $subuh->copy()->subMinutes(10)->format('H:i'),
            'subuh' => $subuh->format('H:i'),
            'syuruk' => $syuruk->format('H:i'),
            'zohor' => $zohor->format('H:i'),
            'asar' => $asar->format('H:i'),
            'maghrib' => $maghrib->format('H:i'),
            'isyak' => $isyak->format('H:i'),
            'dhuha' => (fn () => PrayerTime::calculateDhuha($syuruk, $subuh)?->format('H:i'))(),
        ];
    }
}
