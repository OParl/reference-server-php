<?php namespace EFrane\Transfugio;

use Illuminate\Support\ServiceProvider;

class TransfugioServiceProvider extends ServiceProvider
{
  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->publishes([
      __DIR__.'/config/transfugio.php' => config_path('transfugio.php')
    ]);
  }

  public function boot()
  {
    $this->loadViewsFrom(__DIR__.'/resources/views', 'transfugio');
  }
}