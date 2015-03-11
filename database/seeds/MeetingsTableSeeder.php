<?php

use \Storage;

use OParl\Body;
use OParl\File;

class MeetingsTableSeeder extends Seeder {
  public function run()
  {
    Storage::delete(Storage::files('files/'));

    foreach (Body::all() as $body)
    {
      $termStart = $body->legislativeTerms->sortBy('start_date')[0]->start_date;
      $termEnd   = $body->legislativeTerms->sortBy('start_date')[0]->end_date;

      foreach ($body->organizations() as $organization)
      {
        foreach (range(1, static::$faker->numberBetween(15, 35)) as $meetingNumber)
        {
          $start = Carbon\Carbon::create(static::$faker->dateTimeBetween($termStart, $termEnd));
          $end   = Carbon\Carbon::create($start)->addHours(3);

          $meeting = Meeting::create([
            'start' => $start,
            'end'   => (static::$faker->boolean(40)) ? $end : null
          ]);

          $invitationFileName = static::$faker->oparlMeetingInvitation($body, $meeting);
          $invitationFile = File::create([
            'file_name'     => $invitationFileName,
            'file_modified' => Carbon\Carbon::createFromTimestampUTC(Storage::lastModified($invitationFileName)),
            'size'          => Storage::size($invitationFileName),
            'date'          => static::$faker->dateTimeBetween($termStart, $termEnd),
            'name'          => static::$faker->optional()->word,
            'text'          => static::$faker->optional()->paragraphs(2)
          ]);

          $meeting->invitations->save($invitationFile);
        }
      }
    }
  }
}