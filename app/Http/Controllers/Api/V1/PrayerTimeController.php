<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrayerTimeResource;
use App\Http\Resources\ZoneResource;
use App\Models\PrayerTime;
use App\Models\Zone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PrayerTimeController extends Controller
{
    public function zones(): JsonResponse
    {
        $zones = Zone::orderBy('code')->get();

        return response()->json([
            'data' => ZoneResource::collection($zones),
        ]);
    }

    public function zone(Request $request, Zone $zone): JsonResponse
    {
        $query = $zone->prayerTimes()->with('zone');

        if ($request->filled('date')) {
            $query->where('date', $request->get('date'));
        } elseif ($request->filled('month') && $request->filled('year')) {
            $query->whereYear('date', $request->get('year'))
                ->whereMonth('date', $request->get('month'));
        } elseif ($request->filled('year')) {
            $query->whereYear('date', $request->get('year'));
        } else {
            $query->where('date', today()->format('Y-m-d'));
        }

        $prayerTimes = $query->orderBy('date')->get();

        return response()->json([
            'data' => PrayerTimeResource::collection($prayerTimes),
        ]);
    }

    public function today(Request $request): JsonResponse
    {
        $zone = Zone::where('code', $request->get('zone'))->firstOrFail();

        $prayerTime = $zone->prayerTimeForDate(today()->format('Y-m-d'));

        if (! $prayerTime) {
            return response()->json([
                'message' => 'No prayer times found for today.',
            ], 404);
        }

        $prayerTime->load('zone');

        return response()->json([
            'data' => new PrayerTimeResource($prayerTime),
        ]);
    }

    public function date(Request $request, string $date): JsonResponse
    {
        $zone = Zone::where('code', $request->get('zone'))->firstOrFail();

        $prayerTime = PrayerTime::where('zone_id', $zone->id)
            ->where('date', $date)
            ->with('zone')
            ->first();

        if (! $prayerTime) {
            return response()->json([
                'message' => 'No prayer times found for the specified date.',
            ], 404);
        }

        return response()->json([
            'data' => new PrayerTimeResource($prayerTime),
        ]);
    }
}
