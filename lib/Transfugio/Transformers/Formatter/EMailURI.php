<?php namespace EFrane\Transfugio\Transformers\Formatter;

class EMailURI implements FormatHelper
{
  public function format($value)
  {
    return strtolower("mailto:{$value}");
  }
}