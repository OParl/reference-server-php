<?php

use OParl\Consultation;

class ConsultationsTableSeeder extends Seeder {
  public function run()
  {
    foreach (range(1, 1000) as $i)
    {
      Consultation::create([

      ]);
    }
  }
}