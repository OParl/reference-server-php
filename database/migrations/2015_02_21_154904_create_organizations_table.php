<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organizations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->integer('body_id')->nullable();
			$table->foreign('body_id')->references('id')->on('bodies')->onDelete('cascade');

			$table->string('name')->unique();
			$table->string('short_name')->unique();

			$table->string('post')->nullable();

			$table->integer('suborganization_of')->nullable();
			$table->foreign('suborganization_of')->references('id')->on('organizations')->onDelete('cascade');

			$table->string('classification')->nullable();
			$table->json('keyword')->nullable();

			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();

			$table->string('website')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('organizations');
	}

}
