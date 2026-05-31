<?php

namespace App\Livewire\Admin;

use App\Models\SyncLog as SyncLogModel;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layout')]
class SyncLogs extends Component
{
    use WithPagination;

    public function render()
    {
        $syncLogs = SyncLogModel::latest()->paginate(20);

        return view('livewire.admin.sync-logs', compact('syncLogs'));
    }
}
