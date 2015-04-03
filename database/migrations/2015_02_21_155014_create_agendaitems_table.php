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
		Schema::create('agenda_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->string('consecutive_number')->nullable();

			$table->integer('meeting_id')->unsigned()->nullable();
			$table->foreign('meeting_id')->references('id')->on('meetings');

			$table->string('name');
			$table->boolean('public')->nullable();

			$table->integer('consultation_id')->unsigned()->nullable();
			$table->foreign('consultation_id')->references('id')->on('consultations');
			
			$table->string('result')->nullable();

			$table->integer('resolution_id')->unsigned()->nullable();
			$table->foreign('resolution_id')->references('id')->on('files');

      $table->integer('order'); // used to denote the order of agenda items

			$table->json('keyword')->nullable();
		});

		// pivot table for auxiliary files
		Schema::create('agenda_items_auxiliary_files', function(Blueprint $table) {
			$table->integer('agenda_item_id')->unsigned();
			$table->integer('auxiliary_id')->unsigned();

			$table->foreign('agenda_item_id')->references('id')->on('agenda_items');
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
		Schema::drop('agenda_items_auxiliary_files');

		Schema::drop('agenda_items');
	}

}
