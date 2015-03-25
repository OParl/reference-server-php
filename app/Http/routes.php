<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function() { return Redirect::to('api/v1/'); });


// api
Route::group(['prefix' => 'api/v1'], function() {
  Route::controllers([
    '/system/' => 'API\SystemController',
    '/body'    => 'API\BodyController',
    ''
  ]);
});

