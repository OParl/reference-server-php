<?php namespace OParl;

use Illuminate\Support\ServiceProvider;

class OParlServiceProvider extends ServiceProvider
{
  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $router = app('router');
    $router->group(['prefix' => '/api/v1', 'middleware' => ['api.format']], function() use ($router) {
      $router->resource('system',          'OParl\API\Controllers\SystemController',          ['only' => 'index']);
      $router->resource('body',            'OParl\API\Controllers\BodyController',            ['only' => ['index', 'show']]);
      $router->resource('legislativeterm', 'OParl\API\Controllers\LegislativeTermController', ['only' => ['index', 'show']]);
      $router->resource('agendaitem',      'OParl\API\Controllers\AgendaItemController',      ['only' => ['index', 'show']]);
      $router->resource('person',          'OParl\API\Controllers\PersonController',          ['only' => ['index', 'show']]);
      $router->resource('meeting',         'OParl\API\Controllers\MeetingController',         ['only' => ['index', 'show']]);
      $router->resource('organization',    'OParl\API\Controllers\OrganizationController',    ['only' => ['index', 'show']]);
      $router->resource('membership',      'OParl\API\Controllers\MembershipController',      ['only' => ['index', 'show']]);
      $router->resource('paper',           'OParl\API\Controllers\PaperController',           ['only' => ['index', 'show']]);
      $router->resource('consultation',    'OParl\API\Controllers\ConsultationController',    ['only' => ['index', 'show']]);
      $router->resource('location',        'OParl\API\Controllers\LocationController',        ['only' => ['index', 'show']]);
      $router->resource('file',            'OParl\API\Controllers\FileController',            ['only' => ['index', 'show']]);
    });

    $router->any('/api/{entity}', function($entity) {
      return redirect("/api/v1/{$entity}", 301);
    })->where('entity', '\w+');
  }

}