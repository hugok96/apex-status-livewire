<?php

namespace Database\Seeders;

use App\Models\GameMode;
use Illuminate\Database\Seeder;

class GameModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modes = [
            'battle_royale' => "Battle Royale",
            'arenas' => "Arenas",
            'ranked' => "Ranked",
            'arenasRanked' => "Ranked Arenas"
        ];

        foreach ($modes as $apiId => $name) {
            GameMode::firstOrCreate(['api_id' => $apiId], [
                'name' => $name
            ]);
        }
    }
}
