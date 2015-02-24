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
}
