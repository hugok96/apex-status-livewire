<?php

namespace App\Console\Commands;

use App\Events\MapsUpdated;
use App\Models\CraftingRotation;
use App\Models\GameMode;
use App\Models\ItemDefinition;
use App\Models\ItemType;
use App\Models\MapRotation;
use App\Services\Api;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class RetrieveCraftingRotations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apex:crafting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves and stores the current crafting rotations from the mozambiquehe.re api';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Api $api) : int
    {
        CraftingRotation::each(fn(Model $m) => $m->forceDelete());
        ItemDefinition::each(fn(Model $m) => $m->forceDelete());
        ItemType::each(fn(Model $m) => $m->forceDelete());
        foreach($api->getCraftingRotations() as $rotation) {
            // TODO: implement automatic adding and removing of limited time modes
            $cr = CraftingRotation::create([
               'bundle' => $rotation['bundle'],
               'bundleType' => $rotation['bundleType'],
               'start' => isset($rotation['start']) ? Carbon::createFromTimestampUTC($rotation['start']) : null,
               'end' => isset($rotation['end']) ? Carbon::createFromTimestampUTC($rotation['end']) : null,
            ]);

            foreach ($rotation['bundleContent'] ?? [] as $item) {
                $itemType = ItemType::create([
                   'name' => $item['itemType']['name'],
                   'asset' => $item['itemType']['asset'],
                   'rarity' => $item['itemType']['rarity'],
                   'rarityHex' => $item['itemType']['rarityHex'],
                ]);

                ItemDefinition::create([
                    'item' => $item['item'],
                    'cost' => $item['cost'],
                    'crafting_rotation_id' => $cr->id,
                    'item_type_id' => $itemType->id,
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
