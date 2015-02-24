<?php

use App\User;

class UserTableSeeder extends Seeder {
  public function run()
  {
    User::create([
      'name' => 'Testbenutzer',
      'email' => 'nutzer@oparl-de.mo',
      'password' => \Hash::make('testpasswort')
    ]);
  }
}
