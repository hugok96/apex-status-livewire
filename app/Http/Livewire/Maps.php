<?php

namespace App\Http\Livewire;

use App\Models\GameMode;
use Livewire\Component;

class Maps extends Component
{
    protected $listeners = ['timerExpired' => 'refresh'];

    public function refresh(): void
    {
        // dummy function to facilitate re-rendering
    }

    public function render()
    {
        return view('livewire.maps', [
            'modes' => GameMode::all(),
        ]);
    }
}
