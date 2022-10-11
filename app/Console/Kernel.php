<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Run the retrieving commands 3 times each, with 5 second intervals every minute
        $schedule->call(function () {
            $commands = ['apex:crafting', 'apex:maps', 'apex:servers'];
            $sleepDuration = 5;
            for ($i = 0; $i < 3; $i++) {
                foreach ($commands as $command) {
                    $this->call($command);
                    sleep($sleepDuration);
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
