<?php

use OParl\Model\AgendaItem;

class AgendaItemsTableSeeder extends Seeder {
  public function run()
  {
    // create a ridiculous amount of agenda items
    foreach (range(1, 75000) as $i)
    {
      $agendaItem = AgendaItem::create([
        'consecutive_number' => base_convert($i, 10, 32),
        'name'               => $this->name(),
        'public'             => static::$faker->boolean(70),
        'result'             => implode(' ', static::$faker->optional(30)->words(static::$faker->numberBetween(6, 21))),
        'order'              => $i,
      ]);
    }
  }

  protected function name()
  {
    if (static::$faker->boolean(35))
    {
      return 'Besprechung DRS '.static::$faker->word;
    } else
    {
      return implode(' ', static::$faker->words(static::$faker->numberBetween(3, 8)));
    }
  }
}