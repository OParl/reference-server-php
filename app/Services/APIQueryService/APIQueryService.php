<?php namespace App\Services\APIQueryService;

use App\Exceptions\APIQueryException;
use Carbon\Carbon;

class APIQueryService
{
  /**
   * @var string
   **/
  protected $model = '';

  /**
   * @var APIModelInformation
   */
  protected $modelInformation = null;

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

    $this->modelInformation = new APIModelInformation($model);

    $this->query = $model::query();
  }

  function __call($name, array $arguments)
  {
    return call_user_func_array([$this->query, $name], $arguments);
  }

  public function run()
  {
    if (array_has($this->parameters, 'where')
    && !is_null($this->parameters['where']))
    {
      $this->parseWhere();
    }

    if (array_has($this->parameters, 'include')
    && !is_null($this->parameters['include']))
    {
      $this->parseInclude();
    }


    if (!$this->isUnresolved())
    {
      $this->paginate();
    }

    return $this;
  }

  public function getQuery()
  {
    return $this->query;
  }

  public function isUnresolved()
  {
    return isset($this->parameters['unresolved']);
  }

  public function getUnresolvedParameters()
  {
    return $this->parameters['unresolved'];
  }

  public static function create($model, array $parameters)
  {
    return (new APIQueryService($model, $parameters))->run();
  }

  protected function parseWhere()
  {
    $conditions = decode_where($this->parameters['where']);
    $unresolved = [];

    foreach ($conditions as $field => $valueExpression)
    {
      $valueExpression = new ValueExpression($valueExpression);

      if ($this->modelInformation->isDate($field))
      {
        $this->parseDate($field, $valueExpression);
      } else if ($this->modelInformation->isRelation($field))
      {
         $this->parseRelation($field, $valueExpression);
      } else
      {
        $unresolved[$field] = $valueExpression;
      }
    }

    if (count($unresolved) > 0)
    {
      $this->parameters['unresolved'] = $unresolved;
    }
  }

  protected function parseDate($field, ValueExpression $valueExpression)
  {
    $date = $valueExpression->getValue();

    try
    {
      /**
       * URL decoding leads to + being transformed into a white space.
       * This + however is important as it denotes the timezone of
       * the input string in ISO 8601.
       *
       * If thus, a whitespace is in a date string, it is assumed
       * that this is an URL decoding error and it will be replaced to a +.
       */
      $date = str_replace(' ', '+', $date, $count);
      $date = Carbon::createFromFormat(Carbon::ISO8601, $date);
    } catch (\Exception $e)
    {
      throw new APIQueryException("Date {$date} is malformed, needs to be ISO 8601");
    }

    // check if we already have a snake case field name
    if (strpos($field, '_') <= 0) $field = snake_case($field);

    $this->query->where($field, $valueExpression->getExpression(), $date->toDateTimeString());
  }

  protected function parseRelation($field, ValueExpression $valueExpression)
  {
    // TODO: parse relations
  }

  /**
   * Execute the query and paginate the results according to request or config
   *
   * @throws \Exception Rethrows any exception that happens on pagination (query execution)
   **/
  public function paginate()
  {
    try
    {
      $this->query = $this->query->paginate($this->getPaginationConfig());
    } catch (\Exception $e)
    {
      throw $e;
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
      $this->query->load(array_diff($this->modelInformation->getRelations(), $eagerLoadingKey));
    }
  }
}