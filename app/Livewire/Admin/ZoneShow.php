<?php

namespace App\Livewire\Admin;

use App\Models\PrayerTime;
use App\Models\Zone as ZoneModel;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layout')]
class ZoneShow extends Component
{
    use WithPagination;

    public ZoneModel $zone;

    public function mount(ZoneModel $zone): void
    {
        $this->zone = $zone;
    }

    public function render()
    {
        $prayerTimes = PrayerTime::where('zone_id', $this->zone->id)
            ->with('zone')
            ->orderByDesc('date')
            ->paginate(30);

        return view('livewire.admin.zone-show', compact('prayerTimes'));
    }
}
