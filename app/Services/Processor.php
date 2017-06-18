<?php

/**
 * The processor service contains the logic for processing different data sets
 * @author ABDOU
 */

namespace App\Services;

use DB;

class Processor {

    /**
     * The data_sets variable contains the different data sets information needed for
     * initiating the various data processing operations
     * @var array 
     */
    protected $data_sets = [
        'adv_stats' => [
            'callable' => '_transfer_adv_stats'
        ]
    ];

    /**
     *  The transfer() function initiates the transfer operation (from mysql to mongo) for the selected data set
     * @param string $data_set
     * @return boolean / other
     */
    public function transfer($data_set) {
        $callable = $this->data_sets[$data_set]['callable'];
        if (!isset($this->data_sets[$data_set]) || !method_exists($this, $callable))
            return false;

        return $this->$callable();
    }

    /**
     * Processes the mysql data and transfers it to mongo 
     * @return boolean
     */
    public function _transfer_adv_stats() {
        $offset = 0;
        $limit = 2000;

        $go = true;
        while ($go) {
            $data = DB::connection('mysql')->table('advert_statistics')->offset($offset)->limit($limit)->get();

            if ($data->count() < $limit)
                $go = false;
            else
                $offset += $limit - 1;

            foreach ($data as $row) {
                $campaigns = \App\Campaign::where('id', $row->campid)->get();
                if ($campaigns->count() > 0) {
                    $campaign = $campaigns[0];
                } else {
                    $campaign = new \App\Campaign();
                    $campaign->id = $row->campid;
                }

                $campaign->visits += $row->visit ? 1 : 0;
                $campaign->uvisits += $row->uvisit ? 1 : 0;
                $campaign->clicks += $row->click ? 1 : 0;
                $campaign->conversions += $row->conversion ? 1 : 0;
                $campaign->adv_cost += $row->advertiser_cost;
                $campaign->pub_profit += $row->publisher_profit;
                $campaign->save();
            }
        }

        return true;
    }

}
