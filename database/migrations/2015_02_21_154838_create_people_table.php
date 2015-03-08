<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('people', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->integer('body_id')->nullable();
			$table->foreign('body_id')->references('id')->on('bodies');

			$table->string('name');
			
			$table->string('family_name')->nullable();
			$table->string('given_name')->nullable();
			
			$table->string('form_of_address')->nullable();
			$table->string('title')->nullable();
			$table->string('gender')->nullable();

			$table->string('phone')->nullable();
			$table->string('email')->unique()->nullable();

			$table->string('street_address')->nullable();
			$table->string('postal_code')->nullable();

			$table->string('locality')->nullable();

			$table->string('status')->nullable();

			$table->json('keyword')->nullable();

      // add necessary fields for laravel auth capabilities
      $table->string('password', 60)->nullable();
      $table->rememberToken();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('people');
	}

}
