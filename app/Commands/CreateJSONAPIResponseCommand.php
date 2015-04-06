<?php namespace App\Commands;

class CreateJSONAPIResponseCommand extends CreateAPIResponseCommand
{
  public function handle()
  {
    $this->headers['Content-type'] = 'application/json; charset=UTF-8';
    $data = json_encode($this->apiData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    return \Response::make($data, $this->statusCode, $this->headers);
  }
}