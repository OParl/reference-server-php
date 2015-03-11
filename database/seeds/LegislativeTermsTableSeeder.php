<?php

use OParl\Body;
use OParl\LegislativeTerm;

class LegislativeTermsTableSeeder extends Seeder
{
  function run()
  {
    foreach (Body::all() as $body)
    {
      $startYear = date('Y') - 12;

      for ($i = 0; $i < 3; $i++)
      {
        $termDates = static::$faker->oparlLegislativeTerm($startYear + ($i * 4), 4);

        LegislativeTerm::create([
          'name' => static::$faker->word,
          'start_date' => $termDates['start'],
          'end_date'   => $termDates['end'],
          'body_id'    => $body->getKey()
        ]);
      }
    }
  }
}