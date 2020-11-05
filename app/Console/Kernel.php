<?php

namespace App\Console;

use App\Jobs\SendMailTicket;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands =[
        'App\Console\Commands\SendMailJob',
        'App\Console\Commands\BillingJob',
        'App\Console\Commands\BlockService',
        'App\Console\Commands\EncryptEnvValues'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:MailJob')->everyMinute();
        $schedule->command('send:Billing')->monthlyOn(30, '00:00');
        $schedule->command('send:BockService')->dailyAt('17:00');

//        $schedule->job(new Heartbeat, 'heartbeats')->everyFiveMinutes();
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
