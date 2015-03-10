<?php

use OParl\Body;
use OParl\Membership;

class MembershipsTableSeeder extends Seeder {
  public function run()
  {
    foreach (Body::all() as $body)
    {
      $organizations = $body->organizations;
      $organizationCount = $body->organizations->count() - 1;

      foreach ($body->people as $person)
      {
        $organization = $organizations[static::$faker->numberBetween(0, $organizationCount)];

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