<?php

namespace App\Console\Commands;

use App\Models\GameMode;
use App\Models\MapRotation;
use App\Services\Api;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class RetrieveMapRotations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apex:maps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves and stores the current and future map rotations from the mozambiquehe.re api';

    /**
     * Execute the console command.
     *
     * @param Api $api
     * @return int
     * @throws GuzzleException
     */
    public function handle(Api $api): int
    {
        // Iterate maps rotations retrieved by the api, unpacking the apiId, current and next rotations
        foreach ($api->getMapRotations() as $apiId => ['current' => $currentRotation, 'next' => $nextRotation]) {
            // Only process if the game mode already exists in the database (seeded)
            $gameMode = GameMode::where('api_id', '=', $apiId)->first();
            if ($gameMode instanceof GameMode) {
                $this->updateGameMode($gameMode, $currentRotation, $nextRotation);
            }
        }

        // TODO: implement automatic adding and removing of limited time modes
        // TODO: implements events over websockets

        return Command::SUCCESS;
    }

    /**
     * Updates the game mode's rotations if necessary
     *
     * @param GameMode $gameMode
     * @param array $currentRotation
     * @param array|null $nextRotation
     * @return void
     */
    private function updateGameMode(GameMode $gameMode, array $currentRotation, ?array $nextRotation): void
    {
        // Only process if rotation does not exist (null-safety) or its timestamp differs from the api timestamp
        if ($gameMode->current_rotation?->start->timestamp !== $currentRotation['start']) {
            $gameMode->current_rotation?->forceDelete();
            $gameMode->current_rotation()->associate($this->createMapRotation($currentRotation))->save();
        }

        if ($gameMode->next_rotation?->start->timestamp !== $nextRotation['start']) {
            $gameMode->next_rotation?->forceDelete();
            $gameMode->next_rotation()->associate($this->createMapRotation($nextRotation))->save();
        }
    }

    /**
     * Creates a MapRotation in the database with normalised data
     *
     * @param array $rotation
     * @return MapRotation
     */
    private function createMapRotation(array $rotation): MapRotation
    {
        return MapRotation::create([
            'start' => Carbon::createFromTimestampUTC($rotation['start']),
            'end' => Carbon::createFromTimestampUTC($rotation['end']),
            'name' => $rotation['map'],
            'code' => $rotation['code'],
            'asset' => $rotation['asset'],
            'duration' => $rotation['DurationInSecs']
        ]);
    }
}
