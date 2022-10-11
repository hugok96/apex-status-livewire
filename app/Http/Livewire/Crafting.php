<?php

namespace App\Http\Livewire;

use App\Models\CraftingRotation;
use Livewire\Component;

class Crafting extends Component
{
    protected $listeners = ['timerExpired' => 'refresh'];

    public function refresh(): void
    {
        // dummy function to facilitate re-rendering
    }

    public function render()
    {
        // Pass the filtered rotations to the template
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
