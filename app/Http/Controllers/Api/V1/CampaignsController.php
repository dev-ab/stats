<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class CampaignsController extends \App\Http\Controllers\Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Retrieve campaigns data or specify a certain campaign
     * @param int $id
     * @return response object
     */
    public function index($id = null) {
        if ($id) {
            $campaigns = \App\Campaign::where('id', intval($id))->get();
        } else {
            $campaigns = \App\Campaign::all();
        }
        return response()->json($campaigns);
    }

}
