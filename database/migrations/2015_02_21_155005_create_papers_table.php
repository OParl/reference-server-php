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

			$table->integer('body_id')->nullable();
			$table->foreign('body_id')->references('id')->on('bodies')->onDelete('cascade');

			$table->date('published_date');
			$table->string('paper_type')->nullable();
			$table->string('reference')->nullable();

			$table->integer('related_paper_id')->nullable();
			$table->foreign('related_paper_id')->references('id')->on('papers')->onDelete('cascade');

			$table->integer('main_file_id')->nullable();
			$table->foreign('main_file_id')->references('id')->on('files');

			$table->integer('location_id')->nullable();
			$table->foreign('location_id')->references('id')->on('locations');

			$table->integer('consulation_id')->nullable();
			$table->foreign('consulation_id')->references('id')->on('consulations')->onDelete('cascade');

			$table->json('keywords');

			$table->integer('under_direction_of_id')->nullable();
			$table->foreign('under_direction_of_id')->references('id')->on('organizations');
		});

		// pivot table for auxiliary files
		Schema::create('papers_auxiliary_files', function(Blueprint $table) {
			$table->integer('paper_id');
			$table->integer('auxiliary_id');

			$table->foreign('paper_id')->references('id')->on('papers');
			$table->foreign('auxiliary_id')->references('id')->on('users');
		});

		Schema::create('papers_originaters', function(Blueprint $table) {
			$table->integer('paper_id');
			$table->integer('originator_id');

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
		Schema::drop('papers_auxiliary_files');
		Schema::drop('papers_originaters');
		
		Schema::drop('papers');
	}

}
