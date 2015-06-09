<?php namespace EFrane\Transfugio\Transformers\Formatter;

use Carbon\Carbon;

class DateISO8601 implements FormatHelper
{
  public function format($value)
  {
    return $value->toIso8601String();
  }
}