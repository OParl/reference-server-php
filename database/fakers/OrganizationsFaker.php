<?php namespace OParl\Fakers;

use Faker\Provider\Base;

class OrganizationsFaker extends Base
{
  private $prefixes = [
    'Amt für',
    'Zulassungsstelle für '
  ];

  private $suffixes = [
    'samt',
    'behörde'
  ];

  private $names = [
    'Aufräumarbeiten',
    'Grünflächennutzung',
    'Gartenwerkzeug'
  ];

  public function oparlOrganizationName()
  {
    $organization = $this->names[$this->generator->numberBetween(0, count($this->names) - 1)];

    $prefixOrSuffix = $this->generator->boolean();
    if ($prefixOrSuffix)
    {
      $prefix = $this->prefixes[$this->generator->numberBetween(0, count($this->prefixes) - 1)];
      $organization = $prefix.$organization;
    } else
    {
      $suffix = $this->suffixes[$this->generator->numberBetween(0, count($this->suffixes) - 1)];
      $organization = $organization.$suffix;
    }

    return $organization;
  }
}