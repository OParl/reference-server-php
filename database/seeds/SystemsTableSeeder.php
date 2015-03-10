<?php

use OParl\System;

class SystemsTableSeeder extends Seeder {
  public function run()
  {
    System::truncate();

    System::create([
      'id' => static::$faker->word,
    ]);
  }
}
