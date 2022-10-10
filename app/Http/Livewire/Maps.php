<?php

namespace App\Http\Livewire;

use App\Events\MapsUpdated;
use App\Models\GameMode;
use Livewire\Component;

class Maps extends Component
{
    protected $listeners = ['timerExpired' => 'refresh'];

    public function refresh() {

    }

    public function render()
    {
        return view('livewire.maps', [
            'modes' => GameMode::all(),
        ]);
    }
}
