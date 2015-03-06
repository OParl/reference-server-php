<?php

use Illuminate\Database\Seeder as IlluminateSeeder;

class Seeder extends IlluminateSeeder
{
  /**
   * @var $faker Faker\Generator
   */
  protected static $faker = null;

  public function __construct()
  {
    if (is_null(static::$faker))
    {
      static::$faker = Faker\Factory::create('de_DE');
      static::$faker->seed(1727273948272); // have the faker always use the same seed for convenience

      static::$faker->addProvider(new OParl\Fakers\OrganizationsFaker(static::$faker));
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

      return static::$faker->lexify($shortNameLetters.' ???');
  }
}
