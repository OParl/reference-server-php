<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
    if (config('database.default') === 'mysql')
    {
      \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
    }

    Storage::delete(Storage::files('files/'));

		Model::unguard();

		$this->call('UserTableSeeder');

		$this->call('SystemsTableSeeder');
		$this->call('LocationsTableSeeder');
		$this->call('PeopleTableSeeder');
		$this->call('BodiesTableSeeder');
		$this->call('OrganizationsTableSeeder');
    $this->call('MembershipsTableSeeder');
    $this->call('LegislativeTermsTableSeeder');
    $this->call('MeetingsTableSeeder');
    $this->call('ConsultationsTableSeeder');

    Model::reguard();

    if (config('database.default') === 'mysql')
    {
      \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
	}
}
