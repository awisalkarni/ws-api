<?php

namespace App\Livewire\Consumer;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('consumer.layout')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.consumer.dashboard', [
            'user' => Auth::user(),
        ]);
    }
}
