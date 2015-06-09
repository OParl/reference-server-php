<?php namespace EFrane\Transfugio\Web;

use Illuminate\Support\Collection;

class WebView
{
  protected $json = [];

  public function __construct(Collection $collection)
  {
    $this->json = json_encode(
      $collection->toArray(),
      JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );


  }

  public function render()
  {
    $data = [
      'schema'          => null,//$this->loadSchema($this->additionalData['modelName']),
      'url'             => null,//$this->additionalData['url'],
      'json'            => $this->json,
      'module'          => null,//$this->additionalData['modelName'],
      'isError'         => false,
      'paginationCode'  => null,//$this->additionalData['paginationCode'],
      'collectionClass' => null//(!is_null($this->additionalData['paginationCode'])) ? '' : 'collection',
    ];

    return view('transfugio::api.base', $data);
  }
}
