<?php

namespace App\Console;

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
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            $oldkey = \DB::table("singular_items")->first()->instagram_api_key;
            $cSession = curl_init();
            curl_setopt($cSession, CURLOPT_URL,"https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&&access_token=" . $oldkey);
            curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cSession, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $result=curl_exec($cSession);
            curl_close($cSession);
            $json = json_decode($result, true);
            $newkey = $json['access_token'];
            \DB::table("singular_items")->first()->update(['instagram_api_key'=>$newkey]);
        })->monthly();
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
