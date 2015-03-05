<?php

use Illuminate\Database\Seeder as IlluminateSeeder;

class Seeder extends IlluminateSeeder
{
  protected static $faker = null;

  public function __construct()
  {
    if (is_null(static::$faker))
    {
      static::$faker = Faker\Factory::create('de_DE');
    }
  }

  protected function suffixedShortName($name)
  {
      $shortNameLetters = implode(' ', 
        array_map(
          function ($w) { 
            return strtoupper($w[0]); 
          }, 
        explode(' ', $name))
      );

      return = static::$faker->lexify($shortNameLetters.' ???');
  }
}
