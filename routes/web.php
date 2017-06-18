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
$app->get('/tryit', 'ApiController@tryit');
$app->get('labels', 'Api\V1\RTBController@index');
$app->get('labels/{sequences}', 'Api\V1\RTBController@index');
$app->get('rtb/{sequences}', 'Api\V1\RTBController@rtb');
$app->get('campaigns', 'Api\V1\CampaignsController@index');
$app->get('campaigns/{id}', 'Api\V1\CampaignsController@index');
