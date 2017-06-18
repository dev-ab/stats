<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class ApiController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function tryit() {
        $time_start = microtime(true);
        DB::connection('mysql')->statement('DROP TABLE IF EXISTS `advert_statistics`');
        $command = 'mysql -uroot -pzwaar123 testing < /var/www/data/storage/app/incoming/advert_statistics.sql';
        $output = [];
        exec($command, $output, $worked);
        var_dump($output);
        var_dump($worked);
        Storage::move('incoming/advert_statistics.sql', 'processed/advert_statistics_' . time() . '.sql');

        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start) / 60;
        echo '<b>Total Execution Time:</b> ' . $execution_time . ' Mins';
    }

    public function index() {

        /* $camps = \App\Campaign::all();
          foreach($camps as $camp)
          $camp->delete(); */
        return response()->json();
    }

}
