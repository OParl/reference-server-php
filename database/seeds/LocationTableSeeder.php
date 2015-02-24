<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use OParl\Location;

class LocationTableSeeder extends Seeder
{
  public function run()
  {
    $data = $this->generateData();

    foreach ($data as $loc) Location::create($loc);
  }

  public function generateData()
  {
    $faker = Faker\Factory::create('de_DE');

    $data = [];
    
    for ($i = 0; $i < 400; $i++)
    {
      $loc = [];

      $loc['description'] = $faker->text($faker->numberBetween(100, 250));

      if ($i % 2 == 0)
      {
        // generate address
        $loc['address'] = $faker->address;
      } else
      {
        // generate geo coordinate

        $lat = $faker->latitude;
        $lon = $faker->longitude;

        $wkt = sprintf("POINT(%f, %f)", $lat, $lon);

        $loc['geometry'] = $wkt;
      }

      $data[] = $loc;
    }

    return $data;
  }
}
