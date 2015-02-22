<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('memberships', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->foreign('person_id')->references('id')->on('people');
			$table->foreign('organization_id')->references('id')->on('organizations');

			$table->string('role')->nullable();
			$table->string('post')->nullable();

			$table->string('on_behalf_of')->nullable();
			$table->boolean('voting_right')->nullable();

			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('memberships');
	}

}
