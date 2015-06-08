<?php namespace EFrane\Transfugio\Http\Formatter;

/**
 * Collection Formatters
 *
 * The Formatter takes a collection and transforms it to
 * a valid output string.
 *
 * @package EFrane\Transfugio\Formatters
 **/
interface Formatter
{
  public function getContentType();
  public function format(\Illuminate\Support\Collection $collection);
}
