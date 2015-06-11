<?php

use OParl\Model\System;
use OParl\Model\Body;
use OParl\Model\Person;

class BodiesTableSeeder extends Seeder {
  public function run()
  {
    Body::truncate();

    $data = $this->generateData();


    foreach ($data as $body) {
      $body['system_id'] = System::all()[0]->id;

      $bodyInstance = Body::create($body);
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
