<?php

namespace App\Console\Commands;

use App\Models\CraftingRotation;
use App\Models\ItemDefinition;
use App\Models\ItemType;
use App\Services\Api;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
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
     * @param Api $api
     * @return int
     * @throws GuzzleException
     */
    public function handle(Api $api): int
    {
        // Remove existing data
        CraftingRotation::each(fn(Model $m) => $m->forceDelete());
        ItemDefinition::each(fn(Model $m) => $m->forceDelete());
        ItemType::each(fn(Model $m) => $m->forceDelete());

        // Iterate crafting rotations retrieved by the api and store them in the database
        foreach ($api->getCraftingRotations() as $rotation) {
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

        return Command::SUCCESS;
    }
}
