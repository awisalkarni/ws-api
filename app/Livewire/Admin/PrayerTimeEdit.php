<?php

namespace App\Livewire\Admin;

use App\Models\PrayerTime as PrayerTimeModel;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('admin.layout')]
class PrayerTimeEdit extends Component
{
    public PrayerTimeModel $prayerTime;

    public string $date = '';

    public string $imsak = '';

    public string $subuh = '';

    public string $syuruk = '';

    public string $zohor = '';

    public string $asar = '';

    public string $maghrib = '';

    public string $isyak = '';

    public string $dhuha = '';

    public function mount(PrayerTimeModel $prayerTime): void
    {
        $this->prayerTime = $prayerTime->load('zone');
        $this->date = $prayerTime->date->format('Y-m-d');
        $this->imsak = $prayerTime->imsak->format('H:i');
        $this->subuh = $prayerTime->subuh->format('H:i');
        $this->syuruk = $prayerTime->syuruk->format('H:i');
        $this->zohor = $prayerTime->zohor->format('H:i');
        $this->asar = $prayerTime->asar->format('H:i');
        $this->maghrib = $prayerTime->maghrib->format('H:i');
        $this->isyak = $prayerTime->isyak->format('H:i');
        $this->dhuha = $prayerTime->dhuha->format('H:i');
    }

    public function save(): void
    {
        $this->validate([
            'date' => ['required', 'date'],
            'imsak' => ['required', 'date_format:H:i'],
            'subuh' => ['required', 'date_format:H:i'],
            'syuruk' => ['required', 'date_format:H:i'],
            'zohor' => ['required', 'date_format:H:i'],
            'asar' => ['required', 'date_format:H:i'],
            'maghrib' => ['required', 'date_format:H:i'],
            'isyak' => ['required', 'date_format:H:i'],
            'dhuha' => ['required', 'date_format:H:i'],
        ]);

        $this->prayerTime->update([
            'date' => $this->date,
            'imsak' => $this->imsak,
            'subuh' => $this->subuh,
            'syuruk' => $this->syuruk,
            'zohor' => $this->zohor,
            'asar' => $this->asar,
            'maghrib' => $this->maghrib,
            'isyak' => $this->isyak,
            'dhuha' => $this->dhuha,
        ]);

        session()->flash('success', 'Prayer time updated successfully.');

        $this->redirect(route('admin.prayer-times'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.prayer-time-edit');
    }
}
