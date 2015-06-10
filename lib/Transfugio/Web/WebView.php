<?php namespace EFrane\Transfugio\Web;

use Illuminate\Http\Response;

class WebView extends Response
{
  protected $json = [];
  protected $modelName = '';
  protected $paginationCode = '';
  protected $collectionClass = '';
  protected $error = false;

  public function __construct($data, $status)
  {
    $this->json = $data;
    parent::__construct('', $status);
  }

  public function setIsCollection($isCollection = true)
  {
    $this->collectionClass = ($isCollection) ? 'collection' : '';
  }

  /**
   * @param string $modelName
   */
  public function setModelName($modelName)
  {
    $this->modelName = $modelName;
  }

  public function setPaginationCode($paginationCode)
  {
    $this->paginationCode = $paginationCode;
  }

  public function setIsError($isError = true)
  {
    $this->error = $isError;
  }

  public function render()
  {
    $data = [
      'schema'          => $this->loadSchema(),
      'url'             => app('request')->url(),
      'json'            => $this->json,
      'module'          => $this->modelName,
      'isError'         => $this->error,
      'paginationCode'  => $this->paginationCode,
      'collectionClass' => $this->collectionClass,
    ];

    $this->setContent(view('transfugio::api.base', $data));
  }

  protected function loadSchema()
  {
    try
    {
      $json = file_get_contents(app_path('../resources/assets/schema/'.ucfirst($this->modelName).'.json'));
      $schema = json_decode($json, true);
    } catch (\ErrorException $e)
    {
      $schema = null;
    }

    return $schema;
  }
}
