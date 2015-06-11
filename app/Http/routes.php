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

Route::get('/', function() {
  return redirect()->route('api.v1.system.index', ['format' => 'html']);
});

Route::pattern('id', '(\d+)');

Route::pattern('feedType', '(new|updated|removed)');
Route::pattern('feedFormat', '(rss|atom)');

// feeds
Route::get('/feed/{feedType}.{feedFormat}', ['as' => 'feed.show', 'uses' => 'FeedController@show']);

// file access and download
Route::get('/preview/{id}',  ['as' => 'file.access',   'uses' => 'FileController@access']);
Route::get('/files/{id}', ['as' => 'file.download', 'uses' => 'FileController@download']);
