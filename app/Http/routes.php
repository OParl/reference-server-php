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

Route::get('/', function() { return Redirect::to('api/v1/system'); });


// api
Route::group(['prefix' => 'api/v1'], function() {
  Route::resource('system', 'API\SystemController', ['only' => 'index']);
  Route::resource('body', 'API\BodyController', ['only' => ['index', 'show']]);
  Route::resource('legislativeTerm', 'API\LegislativeTermController', ['only' => ['index', 'show']]);
  Route::resource('agendaItem', 'API\AgendaItemController', ['only' => ['index', 'show']]);
  Route::resource('person', 'API\PersonController', ['only' => ['index', 'show']]);
  Route::resource('meeting', 'API\MeetingController', ['only' => ['index', 'show']]);
  Route::resource('organization', 'API\OrganizationController', ['only' => ['index', 'show']]);
  Route::resource('membership', 'API\MembershipController', ['only' => ['index', 'show']]);
  Route::resource('paper', 'API\PaperController', ['only' => ['index', 'show']]);
  Route::resource('consultation', 'API\ConsultationController', ['only' => ['index', 'show']]);
  Route::resource('location', 'API\LocationController', ['only' => ['index', 'show']]);
  Route::resource('file', 'API\FileController', ['only' => ['index', 'show']]);
});

