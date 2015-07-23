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
      ->call(function () {
        $this->call('down');

        $this->call('migrate:refresh', ['env' => 'local']);
        $this->call('db:seed', ['env' => 'local']);

        $this->call('up');
      })
      ->dailyAt('05:00')
      ->sendOutputTo(storage_path('/logs/db_update.log'))
      ->emailOutputTo(['Stefan Graupner <stefan.graupner@gmail.com>']);
  }
}
