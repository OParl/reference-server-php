<?php namespace EFrane\Transfugio\Http\Formatter;

class FormatterFactory 
{
  public static function get($format)
  {
    $format = strtolower($format);

    // remove "underscore specifier part" from format
    if (strpos($format, '_') > 0)
      $format = substr($format, 0, strpos($format, '_'));

    switch ($format)
    {
      case 'json': return new JSONFormatter();
      case 'yaml': return new YAMLFormatter();
      case 'html': return new HTMLFormatter();

      default:
        throw new \LogicException("Requested unresolvable output format '{$format}'.");
    }
  }
}
