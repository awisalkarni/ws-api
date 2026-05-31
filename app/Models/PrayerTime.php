<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrayerTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'date',
        'imsak',
        'subuh',
        'syuruk',
        'zohor',
        'asar',
        'maghrib',
        'isyak',
        'dhuha',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
            'imsak' => 'datetime:H:i',
            'subuh' => 'datetime:H:i',
            'syuruk' => 'datetime:H:i',
            'zohor' => 'datetime:H:i',
            'asar' => 'datetime:H:i',
            'maghrib' => 'datetime:H:i',
            'isyak' => 'datetime:H:i',
            'dhuha' => 'datetime:H:i',
        ];
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public static function calculateDhuha(?Carbon $syuruk, ?Carbon $subuh): ?Carbon
    {
        if (! $syuruk || ! $subuh) {
            return null;
        }

        $diffInSeconds = abs($subuh->diffInSeconds($syuruk));

        return $syuruk->copy()->addSeconds($diffInSeconds / 3);
    }
}
