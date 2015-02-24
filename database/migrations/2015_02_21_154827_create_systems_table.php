<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('systems', function(Blueprint $table)
		{
			$table->string('id');
			$table->timestamps();

			$table->string('contact_name')->nullable();
			$table->string('contact_email')->nullable();
			$table->string('website')->nullable();
		});

		Schema::create('systems_bodies', function(Blueprint $table) {
			$table->integer('system_id');
			$table->integer('body_id');

			$table->foreign('system_id')->references('id')->on('systems')->onDelete('cascade');
			$table->foreign('body_id')->references('id')->on('body')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('systems');
	}

}
