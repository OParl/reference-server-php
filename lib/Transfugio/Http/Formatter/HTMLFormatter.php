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
    $view = new WebView($collection);
    return $view->render();
  }

}