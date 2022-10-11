<?php

namespace App\View\Components;

use App\Models\CraftingRotation;
use Illuminate\View\Component;

class CraftingItems extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(private CraftingRotation $rotation)
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // Ensure that only unique items are displayed (e.g. ignore the same ammo item)
        return view('components.crafting-items', [
            'items' => $this->rotation->items->unique(fn($definition) => $definition->item_type->name)
        ]);
    }
}
