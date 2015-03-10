<?php namespace OParl\Fakers;

use Faker\Provider\Base;

class BodiesFaker extends Base
{
  protected $prefixes = [
    "Bezirk ",
    "Gemeinde ",
    "Stadt ",
    "Kommune"
  ];

  protected static $lastName;

  public function oparlBodyName()
  {
    static::$lastName = sprintf("%s %s", $this->prefixes[$this->generator->numberBetween(0, count($this->prefixes) - 1)], $this->generator->city);
    return static::$lastName;
  }

  public function oparlBodyShortName()
  {
    $words = explode(' ', static::$lastName);
    return $this->generator->lexify(sprintf('%s ???', $words[0], $words[1][0]));
  }
}
