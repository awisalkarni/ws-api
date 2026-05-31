<?php

namespace App\Livewire\Admin;

use App\Models\Zone as ZoneModel;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layout')]
class Zones extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $zones = ZoneModel::withCount('prayerTimes')
            ->when($this->search, fn ($query) => $query
                ->where('code', 'like', '%'.$this->search.'%')
                ->orWhere('state', 'like', '%'.$this->search.'%')
            )
            ->orderBy('code')
            ->paginate(20);

        return view('livewire.admin.zones', compact('zones'));
    }
}
