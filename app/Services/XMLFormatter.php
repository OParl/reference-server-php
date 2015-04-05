<?php namespace App\Services;

use XMLWriter;

class XMLFormatter
{
  public static function format(array $data)
  {
    $formatter = new XMLFormatter;
    return $formatter->run($data);
  }

  private function __construct() {}

  private function run($data)
  {
    $writer = new XMLWriter;
    $writer->openMemory();

    $writer->startDocument('1.0', 'utf-8');
    $writer->startElement('result');

    $this->processItem('data', $data['data'], $writer);
    //$this->processItem($key, $value, $writer);

    $writer->endElement();

    return $writer->outputMemory();
  }

  private function processItem($key, $value, XMLWriter $writer)
  {
    if (is_array($value))
    {
      if (isset($value[0]))
      {
        $writer->startElement($key);
        foreach ($value as $key => $item)
        {
          $writer->startElement('item');
          $writer->writeAttribute('value', $item);
          $writer->endElement();
        }
        $writer->endElement();
      } else
      {
        foreach ($value as $key => $innerValue)
          $this->processItem($key, $innerValue, $writer);
      }
    } else
    {
      $writer->writeElement($key, $value);
    }
  }
}