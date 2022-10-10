<?php

namespace App\View\Components;

use App\Models\GameMode;
use Illuminate\View\Component;

class Map extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public GameMode $mode)
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.map');
    }
}
