<?php

use OParl\Model\System;

class SystemsTableSeeder extends Seeder {
  public function run()
  {
    System::truncate();

    System::create([
      'id' => 'Testsystem',
    ]);
  }
}
