<?php

use OParl\Organization;
use OParl\Person;

class OrganizationsTableSeeder extends Seeder {
  public function run()
  {
    for (OParl\Body::all() as $body)
    {
      $organizations = $this->organizationsData(static::$faker->numberBetween(5, 10));
      
    }

    // create a few organizations in every body
    // + add a few random members from every body? or do that in special seeder for memberships?
  }

  /** 
   * returns basic organization data array w/o set body or members
   **/
  protected function organizationsData($numberOfOrganizations = 10)
  {
    $data = [];
    for ($i = 0; $i < $numberOfOrganizations; $i++)
    {
      $name = static::$faker->company;

      $organization = [
        'name'       => $name,
        'short_name' => $this->suffixedShortName($name),
        'website'    => static::$faker->url
      ];

      $data[] = $organization;
    }

    return $data;
  }
}
