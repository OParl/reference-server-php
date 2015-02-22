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

			$table->foreign('paper_id')->references('id')->on('papers');
			$table->foreign('agenda_item_id')->references('id')->on('agendaitems');
			$table->foreign('organization_id')->references('id')->on('organizations');

			$table->boolean('authoritative')->nullable();
			$table->string('role')->nullable();

			$table->json('keywords')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('consultations');
	}

}
