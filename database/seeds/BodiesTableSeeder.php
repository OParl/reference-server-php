<?php

use OParl\System;
use OParl\Body;
use OParl\Person;

class BodiesTableSeeder extends Seeder {
  public function run()
  {
    Body::truncate();

    $data = $this->generateData();

    $system = System::find(1);
    foreach ($data as $body) {
      $bodyInstance = Body::create($body);
      $bodyInstance->system()->associate($system);
      $bodyInstance->save();
    }

    // assign each person a body
    $bodies = Body::all();
    $people = Person::all();
    
    foreach ($people as $person)
    {
      $person->body()->associate($bodies[static::$faker->numberBetween(0, 2)]);
      $person->save();
    }
  }

  protected function generateData()
  {
    $data = [];

    for ($i = 0; $i < 3; $i++)
    {
      $body = [
        'name'      => static::$faker->oparlBodyName,
        'short_name' => static::$faker->oparlBodyShortName,

        'website' => static::$faker->url,

        'contact_email' => static::$faker->email,
        'contact_name'  => static::$faker->name,
      ];

      $data[] = $body;
    }

    return $data;
  }
}
