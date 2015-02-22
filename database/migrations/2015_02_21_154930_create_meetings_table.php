<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meetings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->date('start');
			$table->date('end');

			$table->string('street_address');
			$table->string('postal_code');
			$table->string('locality');

			$table->foreign('location_id')->references('id')->on('locations');
			$table->foreign('organization_id')->references('id')->on('organizations');

			$table->foreign('chair_person_id')->references('id')->on('users');
			$table->foreign('scribe_id')->references('id')->on('users');

			$table->foreign('results_protocol_id')->references('id')->on('files');
			$table->foreign('verbatim_protocol_id')->references('id')->on('files');

			$table->json('keywords');
		});

		// pivot table for persons in meetings
		Schema::create('meetings_persons', function(Blueprint $table) {
			$table->foreign('meeting_id')->references('id')->on('meetings');
			$table->foreign('participant_id')->references('id')->on('users');
		});

		// pivot table for invitation documents
		Schema::create('meetings_invitations', function(Blueprint $table) {
			$table->foreign('meeting_id')->references('id')->on('meetings');
			$table->foreign('invitation_id')->references('id')->on('users');
		});

		// pivot table for auxiliary files
		Schema::create('meetings_auxiliary_files', function(Blueprint $table) {
			$table->foreign('meeting_id')->references('id')->on('meetings');
			$table->foreign('auxiliary_id')->references('id')->on('users');
		});

		// agendaItem references are stored in the agendaitems table
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('meetings');
	}

}
