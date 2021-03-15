<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\Bot\{CommandRun, CommandRegister};

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CommandRun::class,
        CommandRegister::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        
        $schedule->command("cache:clear")->daily();

        $schedule->command("bot:register")
            ->everyFiveMinutes();

       /* $schedule->command("queue:restart")
            ->everyFiveMinutes();*/

        $command = "queue:work --stop-when-empty";

        if (! os_process_is_running($command)) {
            $schedule->command($command)->everyMinute();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
