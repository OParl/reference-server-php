<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
