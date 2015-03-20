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

/*
Route::get('/', 'HomeController@showIndex');
Route::get('/home', function() { return Redirect::to('/'); });
*/

// api
Route::group(['prefix' => 'api/v1'], function() {
  Route::controllers([
    '/' => 'API\APIController'
  ]);
});

Route::get('/pdftest', function() {
  $pdf = new mPDF();


  $meeting = OParl\Meeting::find(14);

  $view = View::make('documents.meeting_invitation', ['meeting' => $meeting]);
  $pdf->WriteHTML($view);

  $output = $pdf->Output('', 'S');

  return Response::make($output, 200, ['Content-type' => 'application/pdf']);
});

/*
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);
*/