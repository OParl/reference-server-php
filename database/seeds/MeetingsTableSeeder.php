<?php

use \Storage;

use Carbon\Carbon;

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
            'start'    => $start,
            'end'      => (static::$faker->boolean(40)) ? $end : null,
            'locality' => static::$faker->optional()->address,
          ]);

          $meeting->organization()->associate($organization);
          $meeting->chair()->associate($organization->members->random());
          $meeting->scribe()->associate($organization->members->random());

          $meeting->participants()->saveMany($this->getRandomArrayFromCollection($organization->members)->all());

          $invitationFileName = static::$faker->oparlMeetingInvitation($meeting);
          $invitationFile = File::create([
            'file_name'     => $invitationFileName,
            'file_modified' => Carbon::createFromTimestampUTC(Storage::lastModified($invitationFileName)),
            'size'          => Storage::size($invitationFileName),
            'date'          => static::$faker->dateTimeBetween($termStart, $termEnd),
            'name'          => static::$faker->optional()->word,
            'text'          => static::$faker->optional()->paragraphs(2)
          ]);

          $meeting->invitations()->save($invitationFile);

          $meeting->save();
        }
      }
    }
  }
}