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

			$table->string('number')->nullable();

			$table->integer('meeting_id')->nullable();
			$table->foreign('meeting_id')->references('id')->on('meetings');

			$table->string('name');
			$table->boolean('public')->nullable();

			$table->integer('consulation_id')->nullable();
			$table->foreign('consulation_id')->references('id')->on('consultations');
			
			$table->string('result')->nullable();

			$table->integer('resolution_id')->nullable();
			$table->foreign('resolution_id')->references('id')->on('files');

			$table->json('keywords');
		});

		// pivot table for auxiliary files
		Schema::create('agendaitems_auxiliary_files', function(Blueprint $table) {
			$table->integer('agendaitem_id');
			$table->integer('auxiliary_id');
			$table->integer('order'); // used to denote the order of agenda items

			$table->foreign('agendaitem_id')->references('id')->on('agendaitems');
			$table->foreign('auxiliary_id')->references('id')->on('files');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agendaitems_auxiliary_files');

		Schema::drop('agendaitems');
	}

}
