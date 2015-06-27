<?php

use Carbon\Carbon;

use OParl\Model\AgendaItem;
use OParl\Model\Body;
use OParl\Model\Consultation;
use OParl\Model\LegislativeTerm;
use OParl\Model\Meeting;
use OParl\Model\Organization;
use OParl\Model\Paper;

class MeetingsSeeder extends Seeder
{
  protected $currentBody = 0;

  public function run()
  {
    // for each body
    Body::all()->each(function(Body $body) {
      $this->currentBody = $body;

      // for each term
      $body->legislativeTerms->each(function (LegislativeTerm $term) use ($body) {
        // for each organization
        $body->organizations->each(function (Organization $organization) use ($term) {
          // create between 30 and 90 meetings
          $numberOfMeetings = static::$faker->numberBetween(30, 90);

          for ($i = 1; $i < $numberOfMeetings + 1; $i++)
            $this->seedMeeting($organization, $term, $i);

        });
      });
    });
  }

  protected function seedMeeting(Organization $organization, LegislativeTerm $term, $meetingNumber)
  {
    // create a meeting in the provided term
    $start_date = Carbon::instance(static::$faker->dateTimeBetween(
      $term->start_date,
      $term->end_date
    ));

    // set it's duration between 2 and 4 hours
    $end_date = Carbon::instance(static::$faker->dateTimeBetween(
      $start_date->addHours(2),
      $start_date->addHours(4)
    ));

    $meeting = Meeting::create([
      'start_date' => $start_date,
      'end_date' => $end_date,
      'organization_id' => $organization->id,
      'locality' => static::$faker->optional()->address
    ]);

    $maxNumberOfParticipants = static::$faker->biasedNumberBetween(
      1,
      $organization->members()->count(),
      function ($x) {
        return pow($x, 3);
      }
    );

    $participants = $organization->members->filter(function () use ($maxNumberOfParticipants)
    {
      return static::$faker->optional(.3) && $maxNumberOfParticipants-- > 0;
    });

    $participants->each(function ($participant) use ($meeting)
    {
      $meeting->participants()->save($participant);
    });

    $numberOfAgendaItems = static::$faker->numberBetween(3, 27);
    for ($i = 0; $i < $numberOfAgendaItems; $i++)
    {
      $agendaItem = $this->seedAgendaItem($meetingNumber, $i + 1);
      $meeting->agendaItems()->save($agendaItem);
    }

    $meeting->save();
  }

  protected function seedAgendaItem($meetingNumber, $agendaItemNumber)
  {
    $consecutiveNumber = base_convert($meetingNumber + 9, 10, 36) . '-' . $agendaItemNumber;
    $result = static::$faker->optional()->paragraphs(5, true);
    $name = static::$faker->words(8, true);

    $agendaItem = AgendaItem::create([
      'consecutive_number' => $consecutiveNumber,
      'order'              => $agendaItemNumber,
      'result'             => $result,
      'name'               => $name
    ]);

    // conditionally add consultation and paper on 60% of the items
    if (static::$faker->optional(.6))
      $this->seedPaper($agendaItem);

    return $agendaItem;
  }

  protected function seedPaper(AgendaItem $item)
  {
    $paper = Paper::whereName($item->name)->first();

    if (is_null($paper))
    {
      $paperFile = static::$faker->oparlPaper($item->name);

      $paper = Paper::create([
        'name'           => $item->name,
        'body_id'        => $this->currentBody->id,
        'published_date' => Carbon::now(),
        'main_file_id'   => $paperFile->id
      ]);
    }

    Consultation::create([
      'paper_id'       => $paper->id,
      'agenda_item_id' => $item->id,

      'authoritative' => static::$faker->optional()->boolean(),
    ]);
  }
}