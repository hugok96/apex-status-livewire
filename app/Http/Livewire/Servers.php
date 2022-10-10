<?php

namespace App\Http\Livewire;

use App\Models\ServerStatus;
use Livewire\Component;

class Servers extends Component
{
    public function render()
    {
        return view('livewire.servers', [
            'serverTypes' => $this->getServers()
        ]);
    }

    /**
     * @return array
     */
    private function getServers() : array
    {
        $result = [];
        foreach(ServerStatus::all() as $server) {
            $result[$server->server_type] ??= [];
            $result[$server->server_type][] = $server;
        }
        return $result;
    }
}
