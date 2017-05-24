<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$app->get('/', function () use ($app) {
//dd(DB::connection('mongodb')->collection('potato')->get());
   // $label =  new \App\Label;
    //$label->identity = '5040404';
    //$label->save();
    print_r(\App\Label::all());

    return $app->version();
});
