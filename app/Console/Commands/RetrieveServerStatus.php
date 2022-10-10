<?php

namespace App\Console\Commands;

use App\Events\MapsUpdated;
use App\Models\CraftingRotation;
use App\Models\GameMode;
use App\Models\ItemDefinition;
use App\Models\ItemType;
use App\Models\MapRotation;
use App\Models\ServerStatus;
use App\Services\Api;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class RetrieveServerStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apex:servers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves and stores the current server status from the mozambiquehe.re api';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Api $api) : int
    {
        ServerStatus::each(fn(Model $m) => $m->forceDelete());
        foreach($api->getServerStatus() as $serverType => $regions) {
            foreach($regions as $serverRegion => $serverStatus) {
                // TODO: implement automatic adding and removing of limited time modes
                ServerStatus::create([
                    'server_type' => $serverType,
                    'server_region' => $serverRegion,
                    'status_code' => $serverStatus['HTTPCode'] ?? -1,
                    'response_time' => $serverStatus['ResponseTime'] ?? -1,
                    'status' => $serverStatus['Status'],
                    'query_dt' => Carbon::createFromTimestampUTC($serverStatus['QueryTimestamp']),
                ]);
            }
        }

        // TODO: implements events over websockets
        // event(new MapsUpdated());

        return Command::SUCCESS;
    }

    private function processGameMode(GameMode $gameMode, array $currentRotation, ?array $nextRotation) : void
    {
        if(null === $gameMode->current_rotation || $gameMode->current_rotation?->start->timestamp !== $currentRotation['start']) {
            $gameMode->current_rotation?->forceDelete();
            $gameMode->current_rotation()->associate(MapRotation::create($this->rotationToArray($currentRotation)))->save();
        }

        if(null === $gameMode->next_rotation || $gameMode->next_rotation?->start->timestamp !== $nextRotation['start']) {
            $gameMode->next_rotation?->forceDelete();
            $gameMode->next_rotation()->associate(MapRotation::create($this->rotationToArray($nextRotation)))->save();
        }
    }

    private function rotationToArray(array $rotation) : array {
        return [
            'start' => Carbon::createFromTimestampUTC($rotation['start']),
            'end' => Carbon::createFromTimestampUTC($rotation['end']),
            'name' => $rotation['map'],
            'code' => $rotation['code'],
            'asset' => $rotation['asset'],
            'duration' => $rotation['DurationInSecs']
        ];
    }
}
