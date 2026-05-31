<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'state',
        'description',
    ];

    public function prayerTimes(): HasMany
    {
        return $this->hasMany(PrayerTime::class);
    }

    public function prayerTimeForDate(string $date): ?PrayerTime
    {
        return $this->prayerTimes()->where('date', $date)->first();
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
