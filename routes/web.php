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
$app->get('/', 'ApiController@index');
$app->get('labels', 'ApiController@labels');
$app->get('labels/{sequences}', 'ApiController@labels');
$app->get('rtb/{sequences}', 'ApiController@rtb');
$app->get('campaigns', 'ApiController@campaigns');
$app->get('campaigns/{id}', 'ApiController@campaigns');
