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
		Model::unguard();

		$this->call('UserTableSeeder');

		$this->call('SystemsTableSeeder');
		$this->call('LocationTableSeeder');
		$this->call('PeopleTableSeeder');
		$this->call('BodiesTableSeeder');
		$this->call('OrganizationsTableSeeder');
    $this->call('MembershipsTableSeeder');
	}
}
