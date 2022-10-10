<?php

namespace App\Http\Livewire;

use App\Models\CraftingRotation;
use App\Models\ItemDefinition;
use Livewire\Component;

class Crafting extends Component
{
    protected $listeners = ['timerExpired' => 'refresh'];

    public function refresh() {

    }

    public function render()
    {
        return view('livewire.crafting', [
            'daily' => CraftingRotation::where('bundleType', '=', 'daily')->get(),
            'weekly' => CraftingRotation::where('bundleType', '=', 'weekly')->get(),
            'weapon' => CraftingRotation::where('bundle', 'like', 'weapon_%')->get(),
            'permanent' => CraftingRotation::where('bundleType', '=', 'permanent')
                ->whereNot('bundle', 'like', 'weapon_%')
                ->get()
        ]);
    }
}
