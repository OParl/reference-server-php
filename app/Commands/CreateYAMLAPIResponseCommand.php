<?php namespace App\Commands;

use Symfony\Component\Yaml\Yaml;

class CreateYAMLAPIResponseCommand extends CreateAPIResponseCommand
{
  public function handle()
  {
    $this->headers['Content-type'] = 'text/yaml; charset=UTF-8';
    $data = Yaml::dump($this->apiData);

    return \Response::make($data, $this->statusCode, $this->headers);
  }
}