<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
    $faker = Faker\Factory::create('de_DE');

    $data = [];
    for ($i = 0; $i < 100; $i++)
    {
      $gender = ($faker->boolean(50)) ? 'female' : 'male';

      $person = [
        'given_name'      => $faker->firstName($gender), 
        'family_name'     => $faker->lastName,
        'title'           => $faker->title($gender),
        'form_of_address' => ($gender === 'female') ? 'Frau' : 'Herr',
        'gender'          => $gender,
        
        'street_address'  => $faker->streetAddress,
        'postal_code'     => $faker->postcode,

        'phone'           => $faker->phoneNumber,
        'email'           => $faker->email,

        'created_at'      => $faker->dateTimeThisMonth('now')
      ];

      $person['name'] = sprintf('%s %s %s %s', $person['form_of_address'], 
                                               $person['title'], 
                                               $person['given_name'], 
                                               $person['family_name']);

      $data[] = $person;
    }

    return $data;
  }
}
