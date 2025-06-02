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
        $schedule->command('app:cache-global-rating-average')->everyThreeHours()->withoutOverlapping()->onFailure(function () {
            \Log::error('Failed to cache global rating average');
        });
        $schedule->command('app:cache-global-rating-average')->dailyAt('00:00')->onFailure(function () {
            \Log::error('Failed to cache global rating average at daily schedule');
        });
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
