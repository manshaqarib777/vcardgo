<?php

namespace App\Console;

use App\Console\Commands\GenerateSiteMap;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ExpirationVcardEmail;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        GenerateSiteMap::class,
        ExpirationVcardEmail::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('sitemap:generate')->daily();
        $schedule->command('email:expiration')->daily();
        $schedule->command('gallery:expiration')->daily();

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
