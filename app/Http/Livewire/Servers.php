<?php

namespace App\Http\Livewire;

use App\Models\ServerStatus;
use Livewire\Component;

class Servers extends Component
{
    protected $listeners = ['timerExpired' => 'refresh'];

    public function refresh()
    {
        // dummy function to facilitate re-rendering
    }

    public function render()
    {
        return view('livewire.servers', [
            'serverTypes' => $this->getServers()
        ]);
    }

    /**
     * Group sets of servers by server_type
     *
     * @return array<string, array<ServerStatus>>
     */
    private function getServers(): array
    {
        $result = [];
        foreach (ServerStatus::all() as $server) {
            $result[$server->server_type] ??= [];
            $result[$server->server_type][] = $server;
        }
        return $result;
    }
}
