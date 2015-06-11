<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
    'App\Console\Commands\Deploy',
	];

  protected function schedule(Schedule $schedule)
  {
    $schedule
      ->exec(function () {
        exec('php artisan down');
        exec('php artisan migrate:refresh --env=local');
        exec('php artisan db:seed --env=local');
        exec('php artisan up');
      })
      ->dailyAt('05:00')
      ->sendOutputTo(storage_path('/logs/db_update.log'))
      ->emailOutputTo(['stefan.graupner@gmail.com']);
  }
}
