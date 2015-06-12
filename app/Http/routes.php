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

// redirect root to html version of api entry point
Route::get('/', function() { return redirect()->route('api.v1.system.index', ['format' => 'html']); });

// file access and download
Route::get('/files/preview/{id}',  ['as' => 'file.access',   'uses' => 'FileController@access']);
Route::get('/files/download/{id}', ['as' => 'file.download', 'uses' => 'FileController@download']);

Route::get('/files/', function () { return redirect('/', 302); });