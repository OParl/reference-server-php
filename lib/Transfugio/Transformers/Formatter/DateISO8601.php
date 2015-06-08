<?php namespace EFrane\Transfugio\Transformers\Formatter;

use Carbon\Carbon;

class DateISO8601 implements FormatHelper
{
  public function format($value)
  {
    if (is_null($value)) return null;

    if ($value instanceof \DateTime)
    {
      $date = new Carbon($value);
      return $date->toIso8601String();
    }
  }
}