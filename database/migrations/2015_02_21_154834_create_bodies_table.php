<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bodies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->string('short_name')->unique();
			$table->string('name')->unique();

			$table->string('website')->nullable();
			$table->string('license')->nullable();
			
			$table->date('license_valid_since')->nullable();
			
			$table->string('rgs');
			
			$table->json('equivalent_body')->nullable();

			$table->string('contact_email')->nullable();
			$table->string('contact_name')->nullable();

			$table->integer('system_id')->nullable();
			$table->foreign('system_id')->references('id')->on('systems')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bodies');
	}

}
