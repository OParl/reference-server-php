<?php

use OParl\Body;
use OParl\LegislativeTerm;

class LegislativeTermsSeeder extends Seeder
{
  function run()
  {
    foreach (Body::all() as $body)
    {
      for ($i = 0; $i < 3; $i++)
      {
        $termDates = static::$faker->oparlLegislativeTerm(date('Y') + ($i * 4), 4);

        $term = LegislativeTerm::create([
          'name' => static::$faker->word,
          'start_date' => $termDates['start'],
          'end_date'   => $termDates['end']
        ]);

        $term->body()->associate($body);
        $term->save();
      }
    }
  }
}