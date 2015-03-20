<?php

use OParl\Body;
use OParl\Membership;

class MembershipsTableSeeder extends Seeder {
  public function run()
  {
    foreach (Body::all() as $body)
    {
      $organizations = $body->organizations;

      foreach ($body->people as $person)
      {
        $organization = $organizations->random();

        $membership = Membership::create([
          'role' => static::$faker->oparlMembershipRole,
          'voting_right' => static::$faker->boolean(),
        ]);

        $membership->person()->associate($person);

        $membership->organization()->associate($organization);

        $membership->save();
      }
    }
  }
}