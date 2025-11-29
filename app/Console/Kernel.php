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
        // Send weekly newsletters every Monday at 9:00 AM
        $schedule->command('newsletter:send --frequency=weekly')
            ->weekly()
            ->mondays()
            ->at('09:00')
            ->name('send-weekly-newsletters')
            ->withoutOverlapping();

        // Send monthly newsletters on the 1st of each month at 9:00 AM
        $schedule->command('newsletter:send --frequency=monthly')
            ->monthlyOn(1, '09:00')
            ->name('send-monthly-newsletters')
            ->withoutOverlapping();
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
