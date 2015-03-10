<?php

use OParl\Person;

class PeopleTableSeeder extends Seeder
{
  public function run()
  {
    $data = $this->generateData();
    foreach ($data as $person) Person::create($person);
  }

  protected function generateData()
  {
    $data = [];
    for ($i = 0; $i < 100; $i++)
    {
      $gender = (static::$faker->boolean(70)) ? 'female' : 'male';

      $person = [
        'given_name'      => static::$faker->firstName($gender), 
        'family_name'     => static::$faker->lastName,
        'title'           => static::$faker->title($gender),
        'form_of_address' => ($gender === 'female') ? 'Frau' : 'Herr',
        'gender'          => $gender,
        
        'street_address'  => static::$faker->streetAddress,
        'postal_code'     => static::$faker->postcode,

        'phone'           => static::$faker->phoneNumber,
        'email'           => static::$faker->email,

        'created_at'      => static::$faker->dateTimeThisMonth('now')
      ];

      if ($person['title'] === $person['form_of_address']) $person['title'] = '';

      $person['name'] = sprintf('%s %s %s %s', $person['form_of_address'], 
                                               $person['title'], 
                                               $person['given_name'], 
                                               $person['family_name']);

      $data[] = $person;
    }

    return $data;
  }
}
