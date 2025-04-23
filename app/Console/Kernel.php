<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    private $data;

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        // queue:work
        $schedule->command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();
        // cache:currency-rates
        $schedule->command('cache:currency-rates')->dailyAt('00:00');

        $schedule->command('price:cron')->everyMinute();
        $schedule->command('rate:cron')->everyMinute();

        $schedule->command('scheduler:check')->everyMinute();
        $schedule->command('scheduler:send')->everyTenMinutes();
        $schedule->command('generate:sitemap')->daily();

        $schedule->command('historical:daily')->dailyAt('00:00');
        $schedule->command('historical:hourly')->hourly();
        $schedule->command('historical:fifteen')->everyFifteenMinutes();
        $schedule->command('historical:five')->everyFiveMinutes();
        $schedule->command('historical:one')->everyMinute();

        // historical:listen
        // $schedule->command('historical:listen')->everyMinute()->withoutOverlapping();
        // 'alerts:check'
        // $schedule->command('alerts:check')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
