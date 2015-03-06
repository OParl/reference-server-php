<?php namespace OParl\Fakers;

use Faker\Provider\Base;

class OrganizationsFaker extends Base
{
  private $prefixes = [
    'Amt für ',
    'Zulassungsstelle für ',
    'AG ',
    'Ausschuss für ',
    'Sonderausschuss für ',
    'Arbeitsgruppe ',
    'Krisenausschuss für '
  ];

  private $names = [
    'Aufräumarbeiten',
    'Grünflächennutzung',
    'Bürgerdienste',
    'Weiterbildung und Kultur',
    'Schule',
    'Rechnungsprüfung',
    'Haushalt',
    'Sport',
    'Soziales',
    'Soziales und Gesundheit',
    'Gesundheit',
    'Bauwesen',
    'Frauen und Gender',
    'Jugendhilfe',
    'Verwaltungsreform'
  ];

  public function oparlOrganizationName()
  {
    $prefix = $this->prefixes[$this->generator->numberBetween(0, count($this->prefixes) - 1)];
    $organization = $this->names[$this->generator->numberBetween(0, count($this->names) - 1)];

    return $prefix.$organization;
  }
}