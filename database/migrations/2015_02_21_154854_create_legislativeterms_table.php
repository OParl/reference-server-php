<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegislativetermsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('legislative_terms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->integer('body_id');
			$table->foreign('body_id')->references('id')->on('bodies');
			$table->string('name');

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
		Schema::drop('legislativeterms');
	}

}
