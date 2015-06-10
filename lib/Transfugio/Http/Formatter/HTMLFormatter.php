<?php namespace EFrane\Transfugio\Http\Formatter;

use EFrane\Transfugio\Web\WebView;

class HTMLFormatter implements Formatter
{
  public function getContentType()
  {
    return "text/html; encoding = utf-8";
  }

  public function format(\Illuminate\Support\Collection $collection)
  {
    return json_encode(
      $collection->toArray(),
      JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
  }

}