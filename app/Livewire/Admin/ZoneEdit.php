<?php

namespace App\Livewire\Admin;

use App\Models\Zone as ZoneModel;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('admin.layout')]
class ZoneEdit extends Component
{
    public ZoneModel $zone;

    public string $code = '';

    public string $state = '';

    public string $description = '';

    public function mount(ZoneModel $zone): void
    {
        $this->zone = $zone;
        $this->code = $zone->code;
        $this->state = $zone->state;
        $this->description = $zone->description;
    }

    public function save(): void
    {
        $this->validate([
            'code' => ['required', 'string', 'max:10', 'unique:zones,code,'.$this->zone->id],
            'state' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
        ]);

        $this->zone->update([
            'code' => $this->code,
            'state' => $this->state,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Zone updated successfully.');

        $this->redirect(route('admin.zones'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.zone-edit');
    }
}
