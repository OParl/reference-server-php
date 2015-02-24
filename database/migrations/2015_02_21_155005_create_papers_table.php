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

			$table->string('name')->nullable();

			$table->integer('body_id')->nullable();
			$table->foreign('body_id')->references('id')->on('bodies')->onDelete('cascade');

			$table->date('published_date');
			$table->string('paper_type')->nullable();
			$table->string('reference')->nullable();

			$table->integer('main_file_id')->nullable();
			$table->foreign('main_file_id')->references('id')->on('files');

			$table->json('keywords');

			$table->integer('under_direction_of_id')->nullable();
			$table->foreign('under_direction_of_id')->references('id')->on('organizations');
		});

		// pivot table for locations
		Schema::create('papers_locations', function(Blueprint $table) {
			$table->integer('paper_id');
			$table->integer('location_id');

			$table->foreign('paper_id')->references('id')->on('papers');
			$table->foreign('location_id')->references('id')->on('locations');
		});

		// pivot table for related papers
		Schema::create('papers_related_papers', function(Blueprint $table) {
			$table->integer('paper_id');
			$table->integer('related_id');

			$table->foreign('paper_id')->references('id')->on('papers');
			$table->foreign('related_id')->references('id')->on('papers');
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

			// spec 1.0-draft:
			// $table->string('originator');

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
