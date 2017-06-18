<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class RTBController extends \App\Http\Controllers\Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Retrieve labels data (not finished - data not received)
     * @param Request $request
     * @param string $sequences
     * @return response object
     */
    public function index(Request $request, $sequences = null) {

        parse_str($sequences, $arr);

        if (is_array($arr) && isset($arr['labels']))
            $labels = $this->getLabels($arr['labels']);
        else
            $labels = \App\Label::all();

        return response()->json($labels);
    }

    /**
     * Retrieve rtb data from labels (not finished - data not received)
     * @param Request $request
     * @param string $sequences
     * @return response object
     */
    public function rtb($sequences) {
        parse_str($sequences, $arr);

        if (is_array($arr) && isset($arr['labels']))
            $labels = $this->getLabels($arr['labels']);

        $responseObj = [];

        foreach ($labels as $label) {
            if (isset($responseObj['demand'])) {
                $responseObj['demand'] += $label->demand;
                $responseObj['available'] += $label->available;
            } else {
                $responseObj['demand'] = $label->demand;
                $responseObj['available'] = $label->available;
            }
        }

        return !empty($responseObj) ? response()->json($responseObj) : response()->json('no labels specified');
    }

    /**
     * Retrieve Labels from mongo db
     * @param array $identities
     * @return collection object
     */
    private function getLabels($identities) {
        $labels = \App\Label::whereIn('identity', $identities)->get();
        return $labels;
    }

}
