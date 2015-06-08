<?php namespace EFrane\Transfugio\Http\Formatter;

use \Illuminate\Support\Collection;

class JSONFormatter implements Formatter
{
  public function getContentType()
  {
    return 'application/json; charset=utf-8';
  }

  public function format(Collection $collection)
  {
    return json_encode(
      $collection->toArray(),
      JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );
  }
}