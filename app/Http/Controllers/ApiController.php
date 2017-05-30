<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function index() {
        //dd(DB::connection('mongodb')->collection('potato')->get());
        //$label = new \App\Campaign;
        //$label->id = '118546';
        //$label->stats = ['visits' => 1548888, "clicks" => 500];
        //$label->save();
        echo http_build_query(['labels' => [456654, 5040404]]);
        return response()->json();
    }

    public function labels(Request $request, $sequences = null) {

        parse_str($sequences, $arr);

        if (is_array($arr) && isset($arr['labels']))
            $labels = $this->getLabels($arr['labels']);
        else
            $labels = \App\Label::all();

        return response()->json($labels);
    }

    public function campaigns($id = null) {
        if ($id) {
            $campaigns = \App\Campaign::where('id', $id)->get();
        } else {
            $campaigns = \App\Campaign::all();
        }
        return response()->json($campaigns);
    }

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

    private function getLabels($identities) {
        $labels = \App\Label::whereIn('identity', $identities)->get();
        return $labels;
    }

}
