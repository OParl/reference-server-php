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
			$table->date('end')->nullable();

			$table->string('street_address')->nullable();
			$table->string('postal_code')->nullable();
			$table->string('locality')->nullable();

			$table->integer('location_id')->nullable();
			$table->foreign('location_id')->references('id')->on('locations');

			$table->integer('organization_id')->nullable();
			$table->foreign('organization_id')->references('id')->on('organizations');

			$table->integer('chair_person_id')->nullable();
			$table->foreign('chair_person_id')->references('id')->on('people');

			$table->integer('scribe_id')->nullable();
			$table->foreign('scribe_id')->references('id')->on('people');

			$table->integer('results_protocol_id')->nullable();
			$table->foreign('results_protocol_id')->references('id')->on('files');

			$table->integer('verbatim_protocol_id')->nullable();
			$table->foreign('verbatim_protocol_id')->references('id')->on('files');

			$table->json('keyword')->nullable();
		});

		// pivot table for persons in meetings
		Schema::create('meetings_participants', function(Blueprint $table) {
			$table->integer('meeting_id');
			$table->integer('participant_id');

			$table->foreign('meeting_id')->references('id')->on('meetings');
			$table->foreign('participant_id')->references('id')->on('people');
		});

		// pivot table for invitation documents
		Schema::create('meetings_invitations', function(Blueprint $table) {
			$table->integer('meeting_id');
			$table->integer('invitation_id');

			$table->foreign('meeting_id')->references('id')->on('meetings');
			$table->foreign('invitation_id')->references('id')->on('files');
		});

		// pivot table for auxiliary files
		Schema::create('meetings_auxiliary_files', function(Blueprint $table) {
			$table->integer('meeting_id');
			$table->integer('auxiliary_id');

			$table->foreign('meeting_id')->references('id')->on('meetings');
			$table->foreign('auxiliary_id')->references('id')->on('files');
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
		Schema::drop('meetings_persons');
		Schema::drop('meetings_invitations');
		Schema::drop('meetings_auxiliary_files');

		Schema::drop('meetings');
	}

}
