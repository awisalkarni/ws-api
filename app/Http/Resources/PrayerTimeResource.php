<?php

namespace App\Http\Resources;

use App\Models\PrayerTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PrayerTime */
class PrayerTimeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'zone' => new ZoneResource($this->whenLoaded('zone')),
            'date' => $this->date->format('Y-m-d'),
            'prayers' => [
                'imsak' => $this->imsak->format('H:i'),
                'subuh' => $this->subuh->format('H:i'),
                'syuruk' => $this->syuruk->format('H:i'),
                'zohor' => $this->zohor->format('H:i'),
                'asar' => $this->asar->format('H:i'),
                'maghrib' => $this->maghrib->format('H:i'),
                'isyak' => $this->isyak->format('H:i'),
                'dhuha' => $this->dhuha->format('H:i'),
            ],
        ];
    }
}
