<?php namespace App\Services\APIQueryService;

use App\Exceptions\APIQueryException;

class APIQueryService
{
  /**
   * @var string
   **/
  protected $model  = '';
  /**
   * @var array
   **/
  protected $parameters = [];

  /**
   * @var \Illuminate\Database\Query\Builder
   **/
  protected $query = null;

  public function __construct($model, array $parameters)
  {
    $this->model = $model;
    $this->parameters = $parameters;
  }

  public function run()
  {
    if (array_has($this->parameters, 'where') && !is_null($this->parameters['where']))     $this->parseWhere();
    if (array_has($this->parameters, 'include') && !is_null($this->parameters['include'])) $this->parseInclude();

    $this->paginate();

    return $this->query;
  }

  public static function create($model, array $parameters)
  {
    return (new APIQueryService($model, $parameters))->run();
  }

  protected function modelHasMethod($methodName)
  {
    $methods = get_class_methods($this->model);
    return array_has($methods, $methodName);
  }

  protected function modelHasField($fieldName)
  {
    $fields = get_class_vars($this->model);
    return array_has($fields, $fieldName);
  }

  protected function parseWhere()
  {

  }

  protected function paginate()
  {
    if (is_null($this->query))
    {
      $this->query = call_user_func([$this->model, 'paginate'], $this->getPaginationConfig());
    } else
    {
      $this->query->paginate($this->getPaginationConfig());
    }
  }

  protected function getPaginationConfig()
  {
    // check for limit parameter to adjust number of items per page
    if (array_has($this->parameters, 'limit') && is_numeric($this->parameters['limit']))
    {
      return intval($this->parameters['limit']);
    } else
    {
      return config('oparl.pageElements');
    }
  }

  protected function parseInclude()
  {
    $eagerLoadingKeys = explode(',', $this->parameters['include']);

    foreach ($eagerLoadingKeys as $eagerLoadingKey)
    {
      if (class_method_exists($this->model, $eagerLoadingKey))
      {
        $this->query->load($eagerLoadingKey);
        continue;
      }

      $eagerLoadingKey = str_plural($eagerLoadingKey);
      if (class_method_exists($this->model, $eagerLoadingKey))
        $this->query->load($eagerLoadingKey);
    }
  }
}