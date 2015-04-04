<?php

use \Storage;

use Carbon\Carbon;

use OParl\Body;
use OParl\Meeting;
use OParl\AgendaItem;

class MeetingsTableSeeder extends Seeder {
  protected $lastAgendaItemID = 1;

  public function run()
  {
    foreach (Body::all() as $body)
    {
      $termStart = $body->legislativeTerms->sortBy('start_date')[0]->start_date;
      $termEnd   = $body->legislativeTerms->sortBy('start_date')[0]->end_date;

      foreach ($body->organizations as $organization)
      {
        foreach (range(1, static::$faker->numberBetween(15, 35)) as $meetingNumber)
        {
          $start = Carbon::instance(static::$faker->dateTimeBetween($termStart, $termEnd));
          $end   = Carbon::instance($start)->addHours(3);

          $meeting = Meeting::create([
            'start_date'    => $start,
            'end_date'      => (static::$faker->boolean(40)) ? $end : null,
            'locality' => static::$faker->optional()->address,
          ]);

          $meeting->organization()->associate($organization);
          $meeting->chair()->associate($organization->members->random());
          $meeting->scribe()->associate($organization->members->random());

          $meeting->participants()->saveMany($this->getRandomArrayFromCollection($organization->members)->all());
          $this->getAgendaItems($meeting);

          $invitationFile = static::$faker->oparlMeetingInvitation($meeting, $termStart, $termEnd);
          $meeting->invitations()->save($invitationFile);

          $meeting->save();
        }
      }
    }

    // remove excess agenda items
    \DB::statement('DELETE FROM agenda_items WHERE meeting_id = null');
  }

  protected function getAgendaItems(Meeting $meeting)
  {
    $numItems = static::$faker->numberBetween(3, 25);

    for ($i = 0; $i < $numItems; $i++)
    {
      $agendaItem = AgendaItem::find($this->lastAgendaItemID++);
      $meeting->agendaItems()->save($agendaItem);
    }
  }
}