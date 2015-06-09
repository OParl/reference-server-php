<?php namespace EFrane\Transfugio\Transformers\Formatter;

class HttpURI implements FormatHelper
{
  public function format($value)
  {
    $uri = parse_url($value);

    return sprintf(
      '%s:/%s/%s?%s',
      $uri['scheme'],
      strtolower($uri['host']).(!isset($uri['port'])) ?: $uri['port'],
      $uri['path'],
      $uri['query']
    );
  }
}