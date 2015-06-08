<?php namespace EFrane\Transfugio\Transformers\Formatter;

class EMailURI implements FormatHelper
{
  public function format($value)
  {
    if (is_array($value))
    {
      return array_map([$this, '_do'], $value);
    } else
    {
      return $this->_do($value);
    }
  }

  protected function _do($address)
  {
    return strtolower("mailto:{$address}");
  }
}