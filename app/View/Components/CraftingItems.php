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
    public function __construct(public CraftingRotation $rotation)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.crafting-items');
    }
}
