<?php

namespace App\Console\Commands;

use App\Models\ServerStatus;
use App\Services\Api;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
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
     * @param Api $api
     * @return int
     * @throws GuzzleException
     */
    public function handle(Api $api): int
    {
        // Remove existing data
        ServerStatus::each(fn(Model $m) => $m->forceDelete());

        // Iterate server types and regions retrieved from the api and store them in the database
        foreach ($api->getServerStatus() as $serverType => $regions) {
            foreach ($regions as $serverRegion => $serverStatus) {
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

        return Command::SUCCESS;
    }
}
