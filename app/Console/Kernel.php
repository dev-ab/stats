<?php

namespace App\Console;

use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

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
    protected function schedule(Schedule $schedule) {
        $schedule->call(function () {
            if (Storage::exists('incoming/advert_statistics.sql')) {
                try {
                    DB::connection('mysql')->statement('DROP TABLE IF EXISTS `advert_statistics`');
                    $command = 'mysql -uroot -pzwaar123 testing < /var/www/data/storage/app/incoming/advert_statistics.sql';
                    $output = [];
                    exec($command, $output, $worked);
                    Storage::move('incoming/advert_statistics.sql', 'processed/advert_statistics_' . time() . '.sql');
                } catch (\Exception $e) {
                    DB::connection('mysql')->table('errors')->insert(['message' => $e->getMessage()]);
                }
            }
        })->dailyAt('00:10');

        $schedule->call(function () {
            $processor = new \App\Services\Processor();
            $processor->transfer('adv_stats');
            DB::connection('mysql')->statement('DROP TABLE IF EXISTS `advert_statistics`');
        })->dailyAt('00:20');
    }

}
