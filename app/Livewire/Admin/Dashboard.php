<?php

namespace App\Livewire\Admin;

use App\Models\PrayerTime;
use App\Models\SyncLog;
use App\Models\Zone;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('admin.layout')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'zonesCount' => Zone::count(),
            'prayerTimesCount' => PrayerTime::count(),
            'latestSyncLog' => SyncLog::latest()->first(),
            'recentSyncLogs' => SyncLog::latest()->limit(5)->get(),
        ]);
    }
}
