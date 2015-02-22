<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('papers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->foreign('body_id')->references('id')->on('bodies')->onDelete('cascade');

			$table->date('published_date');
			$table->string('paper_type')->nullable();
			$table->string('reference')->nullable();

			$table->foreign('related_paper_id')->references('id')->on('papers')->onDelete('cascade');
			$table->foreign('main_file_id')->references('id')->on('files');

			$table->foreign('location_id')->references('id')->on('locations');

			$table->foreign('consulation_id')->references('id')->on('consulations')->onDelete('cascade');

			$table->json('keywords');

			$table->foreign('under_direction_of_id')->references('id')->on('organizations');
		});

		// pivot table for auxiliary files
		Schema::create('papers_auxiliary_files', function(Blueprint $table) {
			$table->foreign('paper_id')->references('id')->on('papers');
			$table->foreign('auxiliary_id')->references('id')->on('users');
		});

		Schema::create('papers_originaters', function(Blueprint $table) {
			$table->foreign('paper_id')->references('id')->on('papers');
			$table->foreign('originator_id')->references('id')->on('persons');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('papers');
	}

}
