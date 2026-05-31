<?php

namespace App\Livewire\Admin;

use App\Models\PrayerTime as PrayerTimeModel;
use App\Models\Zone;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layout')]
class PrayerTimes extends Component
{
    use WithPagination;

    public string $searchDate = '';

    public string $zoneFilter = '';

    public function render()
    {
        $prayerTimes = PrayerTimeModel::with('zone')
            ->when($this->searchDate, fn ($query) => $query->where('date', $this->searchDate))
            ->when($this->zoneFilter, fn ($query) => $query->where('zone_id', $this->zoneFilter))
            ->orderByDesc('date')
            ->paginate(30);

        $zones = Zone::orderBy('code')->get();

        return view('livewire.admin.prayer-times', compact('prayerTimes', 'zones'));
    }
}
