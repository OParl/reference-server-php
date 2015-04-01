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

      // make some organizations be sub-organizations
      foreach ($body->organizations as $organization)
      {
        $parent = $body->organizations[static::$faker->numberBetween(0, count($body->organizations) - 1)];
        if (static::$faker->boolean(25) && $parent !== $organization && $parent->subOrganizationOf !== $organization)
        {
          $organization->suborganizationOf()->associate($parent);
          $organization->save();
        }
      }
    }
  }

  /**
   * This will always return unique organization names.
   *
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
            'website'    => static::$faker->url,
        ];

        // TODO: organization.post => membership.role as table

        $data[] = $organization;
      } catch (\OverflowException $e)
      {
        break;
      }
    }

    return $data;
  }
}
