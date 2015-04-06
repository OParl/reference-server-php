<?php namespace App\Commands;

use App\Services\XMLFormatter;

class CreateXMLAPIResponseCommand extends CreateAPIResponseCommand
{
  public function handle()
  {
    $this->headers['Content-type'] = 'text/xml; charset=UTF-8';

    try
    {
      $data = XMLFormatter::format($this->apiData);
    } catch (\ErrorException $e)
    {
      $data = \View::make('api.xml_error');
    }

    return \Response::make($data, $this->statusCode, $this->headers);
  }
}