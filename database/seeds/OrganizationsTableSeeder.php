<?php

use OParl\Organization;
use OParl\Person;

class OrganizationsTableSeeder extends Seeder {
  public function run()
  {
    foreach (OParl\Body::all() as $body)
    {
      // create a few organizations in every body
      $organizationsData = $this->organizationsData(static::$faker->numberBetween(5, 10));
      
      foreach ($organizationsData as $organizationData)
      {
        $organization = Organization::create($organizationData);

        $organization->body()->associate($body);
        $organization->save();
      }
    }


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
      try
      {
        $name = static::$faker->unique()->oparlOrganizationName;

        $organization = [
            'name'       => $name,
            'short_name' => $this->suffixedShortName($name),
            'website'    => static::$faker->url
        ];

        $data[] = $organization;
      } catch (\OverflowException $e)
      {
        break;
      }
    }

    return $data;
  }
}
