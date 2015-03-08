<?php

use OParl\Location;

class LocationsTableSeeder extends Seeder
{
  public function run()
  {
    $data = $this->generateData();

    foreach ($data as $loc) Location::create($loc);
  }

  public function generateData()
  {
    $data = [];
    
    for ($i = 0; $i < 200; $i++)
    {
      $loc = [];

      $loc['description'] = static::$faker->text(static::$faker->numberBetween(100, 250));

      if ($i % 2 == 0)
      {
        // generate address
        $loc['address'] = static::$faker->address;
      } else
      {
        // generate geo coordinate

        $lat = static::$faker->latitude;
        $lon = static::$faker->longitude;

        $wkt = sprintf("POINT(%f, %f)", $lat, $lon);

        $loc['geometry'] = $wkt;
      }

      $data[] = $loc;
    }

    return $data;
  }
}
