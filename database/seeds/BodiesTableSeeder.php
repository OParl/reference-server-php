<?php

use OParl\Body;
use OParl\Person;

class BodiesTableSeeder extends Seeder {
  public function run()
  {
    /*$data = $this->generateData();

    foreach ($data as $body) Body::create($body);

    // assign each person a 
    $people = Person::all();
    foreach ($people as $person)
    {
      $person->body(static::$faker->numberBetween(0, 2));
    }*/
  }

  protected function generateData()
  {
    $data = [];

    for ($i = 0; $i < 3; $i++)
    {

    }

    return $data;
  }
}
