<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->string('file_name');
			$table->string('name')->nullable();
			
			$table->string('mime_type')->nullable();

			$table->date('date');

			$table->integer('size');
			$table->string('sha1_checksum')->nullable();
			$table->text('text')->nullable();
			
			// access url, download url automatically from model

			// meetings_files, papers_files contain references to meetings and papers

			$table->foreign('master_file_id')->references('id')->on('files');
			$table->string('license');
			$table->string('file_role');

			$table->json('keywords');
		});

		// pivot table for derivative files
		Schema::create('derivative_files', function(Blueprint $table) {
			$table->foreign('file_id')->references('id')->on('files');
			$table->foreign('derivative_id')->references('id')->on('files');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('files');
	}

}
