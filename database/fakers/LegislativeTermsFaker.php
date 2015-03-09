<?php namespace OParl\Fakers;

use Faker\Provider\Base;
use Carbon\Carbon;

class LegislativeTermsFaker extends Base
{
  public function oparlLegislativeTerm($startYear = 'current', $numYears = 4)
  {
    if ($startYear === 'current' || !is_numeric($startYear))
      $startYear = date('Y');

    return [
      'start' => Carbon::createFromDate($startYear, 1, 1),
      'end' => Carbon::createFromDate($startYear + $numYears, 12, 31)
    ];
  }
}