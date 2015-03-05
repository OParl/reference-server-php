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
			// relational tables without a primary key are...well...difficult...sometimes
			$table->increments('pk');

			$table->string('id');
			$table->timestamps();

			$table->string('contact_name')->nullable();
			$table->string('contact_email')->nullable();
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
		Schema::drop('systems');
	}

}
