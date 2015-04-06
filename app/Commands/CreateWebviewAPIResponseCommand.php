<?php namespace App\Commands;

class CreateWebviewAPIResponseCommand extends CreateAPIResponseCommand
{
  public function handle()
  {
    $this->headers['Content-type'] = 'text/html; charset=UTF-8';

    $data = json_encode($this->apiData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $viewData = [
      'url'             => $this->additionalData['url'],
      'json'            => $data,
      'module'          => $this->additionalData['modelName'],
      'isError'         => false,
      'paginationCode'  => $this->additionalData['paginationCode'],
      'collectionClass' => (!is_null($this->additionalData['paginationCode'])) ? '' : 'collection',
    ];

    if ($this->statusCode != 200)
    {
      $viewData['isError'] = true;
    }

    $view = \View::make('api.base', $viewData);
    return \Response::make($view, $this->statusCode, $this->headers);
  }
}