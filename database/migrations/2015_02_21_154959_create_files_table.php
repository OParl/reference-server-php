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
			$table->date('file_modified');

			$table->string('name')->nullable();
			
			$table->string('mime_type')->nullable();

			$table->date('date');

			$table->integer('size');
			$table->string('sha1_checksum')->nullable();
			$table->text('text')->nullable();
			
			// access url, download url automatically from model

			// meetings_files, papers_files contain references to meetings and papers

			$table->integer('master_file_id')->nullable();
			$table->foreign('master_file_id')->references('id')->on('files');

			$table->string('license')->nullable();
			$table->string('file_role')->nullable();

			$table->json('keyword')->nullable();
		});

		// pivot table for derivative files
		Schema::create('files_derivatives', function(Blueprint $table) {
			$table->integer('file_id');
			$table->integer('derivative_id');

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
		Schema::drop('files_derivatives');

		Schema::drop('files');
	}

}
