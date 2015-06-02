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
        // 3 bodies * [5,10] organizations * [150,200] meetings = [2250, 6000] meetings
        $numberOfMeetings = static::$faker->numberBetween(150, 200);
        for ($i = 0; $i < $numberOfMeetings; $i++)
        {
          $start = Carbon::instance(static::$faker->dateTimeBetween($termStart, $termEnd));
          $end   = Carbon::instance($start)->addHours(3);

          $meeting = Meeting::create([
            'start_date' => $start,
            'end_date'   => (static::$faker->boolean(40)) ? $end : null,
            'locality'   => static::$faker->optional()->address,
          ]);

          $meeting->organization_id = $organization->id;

          $meeting->chair()->associate($organization->members->random());
          $meeting->scribe()->associate($organization->members->random());

          $meeting->participants()->saveMany($this->getRandomArrayFromCollection($organization->members)->all());
          $this->getAgendaItems($meeting);

          if ($meeting->agendaItems()->count() == 0)
          {
            // we're done here, all agenda items have been used up
            $meeting->delete();
            break 2;
          }

          //$invitationFile = static::$faker->oparlMeetingInvitation($meeting, $termStart, $termEnd);
          //$meeting->invitations()->save($invitationFile);

          $meeting->save();
        }
      }
    }
  }

  protected function getAgendaItems(Meeting $meeting)
  {
    // 75000 agenda items / 6000 meetings == 12.5 agenda items / meeting
    $numItems = static::$faker->numberBetween(7, 14);

    $items = [];
    for ($i = 0; $i < $numItems; $i++)
    {
      try
      {
        $agendaItem = AgendaItem::findOrFail($this->lastAgendaItemID++);
        $items[] = $agendaItem;
      } catch (\Exception $e)
      {
        \Log::error("Tried to request too many agenda items: {$this->lastAgendaItemID}.");
      }
    }

    if (count($items) > 0)
      $meeting->agendaItems()->saveMany($items);
  }
}