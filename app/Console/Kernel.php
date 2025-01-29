<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('app:send-scheduled-notifications')->everyMinute();
        // $schedule->command('assignments:send-reminders')->daily();
        $schedule->command('notifications:send-pending')->everyMinute();
        // $schedule->command('fetch:leagues')->everyMinute();
        // $schedule->command('fetch:players')->everyMinute();
        // $schedule->command('fetch:countries')->daily();
        $schedule->command('fetch:match-data')->everyMinute();
        $schedule->command('fixtures:update-live')->everyMinute();
        $schedule->command('fetch:livefixtures')->dailyAt('6:00');
        // $schedule->command('fetch:cities')->daily();



        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
