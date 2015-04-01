<?php

use \Storage;

use Carbon\Carbon;

use Illuminate\Support\Collection;

use OParl\Body;
use OParl\File;
use OParl\Meeting;

class MeetingsTableSeeder extends Seeder {
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
  }

  protected function getAgendaItems(Meeting $meeting)
  {
    $numItems = static::$faker->numberBetween(3, 25);

    for ($i = 0; $i < $numItems; $i++)
    {
      $agendaItem = null;

      $k = 1;
      do
      {
        $agendaItem = AgendaItem::find($k++);
      } while ($agendaItem->meeting_id != null);

      $meeting->agendaItems()->save($agendaItem);
    }
  }
}