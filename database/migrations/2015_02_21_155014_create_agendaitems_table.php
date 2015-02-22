<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaitemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agendaitems', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->integer('number');
			$table->foreign('meeting_id')->references('id')->on('meetings');

			$table->string('name');
			$table->boolean('public');

			$table->foreign('consulation_id')->references('id')->on('consulations');
			
			$table->string('result');

			$table->foreign('resolution_id')->references('id')->on('files');

			$table->json('keywords');
		});

		// pivot table for auxiliary files
		Schema::create('agendaitems_auxiliary_files', function(Blueprint $table) {
			$table->foreign('agendaitem_id')->references('id')->on('agendaitems');
			$table->foreign('auxiliary_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agendaitems');
	}

}
