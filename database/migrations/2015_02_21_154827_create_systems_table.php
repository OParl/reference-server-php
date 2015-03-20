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
  		$table->string('id')->unique();
			$table->timestamps();

			$table->string('contact_name')->nullable();
			$table->string('contact_email')->nullable();
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
