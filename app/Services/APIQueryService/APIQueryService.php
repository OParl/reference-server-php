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
    $this->parseWhere();
    $this->parseInclude();

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
    if (!array_has($this->parameters, 'where') || is_null($this->parameters['include']))
    {
      // There's nothing to do, just paginate the model query and we're done
      $this->paginate();
      return;
    }

    if (!is_a($this->model, 'App\Services\APIQueryService\APIQueryableContract'))
      throw new APIQueryException("Model is not queryable.");

    $clauses = decode_where($this->parameters['where']);

    $modelCallable = $this->model;

    $fields    = $modelCallable::getQueryableFields();
    $relations = $modelCallable::getQueryableRelations();

    foreach ($clauses as $key => $value)
    {
      if (array_has($relations, $key))
      {
        // TODO: handle relation

        // case a) relation is method in model
        // case b) relation is of type APIRelationPath
      }

      if (array_has($fields, $key))
      {
        // TODO: handle field

      }
    }

    // TODO: the long where
    /*
    $query = null;

    $clauses = decode_where($where);

    $clauses = array_filter_keys($clauses, function($clause) {
      return class_method_exists($this->model, $clause)
          || class_method_exists($this->model, str_plural($clause));
    });

    $clauses = array_map_keys(function ($val) {
      return sprintf('where%sId', ucwords($val));
    }, $clauses);

    if (count($clauses) > 0) {
      $firstKey = array_keys($clauses)[0];

      $query = call_user_func([$this->model, $firstKey], $clauses[$firstKey]);
      array_shift($clauses);
      foreach ($clauses as $where => $value)
        $query->{$where}($value);

      $query = $query->paginate(config('oparl.pageElements'));
    }
     *
     */
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
    if (array_has($this->parameters, 'limit') && is_int($this->parameters['limit']))
    {
      return intval($this->parameters['limit']);
    } else
    {
      return config('oparl.pageElements');
    }
  }

  protected function parseInclude()
  {
    if (!array_has($this->parameters, 'include') || is_null($this->parameters['include']))
    {
      return;
    }

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