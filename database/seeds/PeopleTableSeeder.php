<?php

use OParl\Person;

class PeopleTableSeeder extends Seeder
{
  public function run()
  {
    $data = $this->generateData(400);
    foreach ($data as $person) Person::create($person);
  }

  protected function generateData($numPeople = 100)
  {
    $data = [];
    for ($i = 0; $i < $numPeople; $i++)
    {
      $gender = (static::$faker->boolean(50)) ? 'female' : 'male';

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
