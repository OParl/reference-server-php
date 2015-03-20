<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('consultations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->integer('paper_id')->unsigned()->nullable();
			$table->foreign('paper_id')->references('id')->on('papers');
			
			$table->integer('agenda_item_id')->unsigned()->nullable();
			$table->foreign('agenda_item_id')->references('id')->on('agendaitems');

			$table->boolean('authoritative')->nullable();
			$table->string('role')->nullable();

			$table->json('keyword')->nullable();
		});

		Schema::create('consultations_organizations', function(Blueprint $table) {
			$table->integer('consulation_id')->unsigned();
			$table->integer('organization_id')->unsigned();

			$table->foreign('consulation_id')->references('id')->on('consultations');
			$table->foreign('organization_id')->references('id')->on('organizations');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
    Schema::drop('consultations_organizations');
		Schema::drop('consultations');
	}

}
