<?php

namespace App\Console;

use App\Console\Commands\SendBoletin;
use App\Console\Commands\suscripcion\SendRenovacion;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        SendBoletin::class,
        SendRenovacion::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('users:boletin')
                 ->timezone('America/Lima')
                 ->monthlyOn(1, '10:00');

        $schedule->command('users:renovacion')
            ->timezone('America/Lima')
            ->monthlyOn(23, '15:00');
            //->everyMinute();
            //->everyThirtyMinutes();
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
