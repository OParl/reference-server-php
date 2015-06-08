<?php namespace EFrane\Transfugio\Http\Formatter;

use Symfony\Component\Yaml\Yaml;

class YAMLFormatter implements Formatter
{
  public function getContentType()
  {
    return 'text/yaml; charset=UTF-8';
  }

  public function format(\Illuminate\Support\Collection $collection)
  {
    return Yaml::dump($collection->toArray());
  }
}