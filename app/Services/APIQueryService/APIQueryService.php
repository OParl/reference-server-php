<?php namespace App\Services\APIQueryService;

use App\Exceptions\APIQueryException;

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

  /**
   * Setup a new query service
   *
   * Store the request information, load a model information object
   * and initiate the query builder.
   *
   * @param string $model
   * @param array $parameters
   */
  public function __construct($model, array $parameters)
  {
    $this->model = $model;
    $this->parameters = $parameters;

    $this->modelInformation = new APIModelInformation($model);

    $this->query = $model::query();
  }

  /**
   * Forward any unknown method calls to the query builder
   *
   * This effectively renders the query service to a proxy
   * to it's query builder, allowing for simpler query
   * manipulation in custom resolvers.
   *
   * @param string $name
   * @param array $arguments
   * @return mixed
   **/
  function __call($name, array $arguments)
  {
    return call_user_func_array([$this->query, $name], $arguments);
  }

  /**
   * Generate the query object
   *
   * After preparing the query this will execute it and paginate the results
   *
   * @param \Closure $queryResolver
   * @return APIQueryService
   **/
  public function run(\Closure $queryResolver)
  {
    $this->prepare($queryResolver);
    $this->paginate();

    return $this;
  }

  /**
   * Prepare the query
   *
   * Do everything necessary to prepare the query object for execution
   * This includes calling a queryResolver closure if the query
   * remains unresolved.
   *
   * The queryResolver closure will be passed two parameters,
   * firstly the array of unresolved conditions and secondly
   * the whole query service object.
   *
   * <code>
   *   // an example closure
   *   function (array $unresolved, APIQueryService $query)
   *   {
   *      ...
   *   }
   * </code>
   *
   * @see getUnresolvedParameters
   * @param \Closure $queryResolver
   */
  public function prepare(\Closure $queryResolver)
  {
    // parse where conditions
    if (array_has($this->parameters, 'where') && !is_null($this->parameters['where']))
      $this->parseWhere();

    // parse includes for eager loading
    if (array_has($this->parameters, 'include') && !is_null($this->parameters['include']))
      $this->parseInclude();

    // resolve query with caller
    if ($this->isUnresolved())
    {
      $result = $queryResolver($this->getUnresolvedParameters(), $this);
      if (!is_bool($result) && !$result)
        throw new APIQueryException("Query was not resolved successfully.");
    }
  }

  /**
   * Get the processed query
   *
   * If the query is resolved, this will be a LengthAwarePaginator,
   * else it will be the current state of the Query\Builder instance
   * allowing for changes to the query.
   *
   * NOTE: It is recommended not to use this method to alter the
   * query in custom requests but instead directly access the query
   * object via magic methods.
   *
   * @see APIQueryService:__call()
   * @return \Illuminate\Database\Query\Builder|\Illuminate\Pagination\LengthAwarePaginator
   **/
  public function getQuery()
  {
    return $this->query;
  }

  /**
   * Check if the query is unresolved
   *
   * @return bool
   **/
  public function isUnresolved()
  {
    return isset($this->parameters['unresolved']);
  }

  /**
   * Get the unresolved query parameters
   *
   * @return array An associative array of unresolved fields and their `ValueExpression`'s
   **/
  public function getUnresolvedParameters()
  {
    return $this->parameters['unresolved'];
  }

  /**
   * Easily create a new query service instance
   *
   * @param string $model
   * @param array $parameters
   * @param \Closure $queryResolver
   *
   * @see prepare
   *
   * @return APIQueryService
   **/
  public static function create($model, array $parameters, \Closure $queryResolver)
  {
    return (new APIQueryService($model, $parameters))->run($queryResolver);
  }

  /**
   * Parse the request's where constraints
   *
   * This parses the request's where constraints and adds
   * them to the query if they are resolvable with the information
   * obtainable by `APIModelInformation`.
   *
   * In case a condition can not be met, it's parsed `ValueExpression`
   * is added to an array of unresolved constraints thus rendering
   * the whole query unresolved. Controllers then have the opportunity
   * to add custom query resolvers to make the query pass.
   *
   * @see APIIndexPaginatedTrait:resolveQuery
   */
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
      $this->parameters['unresolved'] = $unresolved;
  }

  /**
   * Add a date constraint to the query object
   *
   * @param $field
   * @param ValueExpression $valueExpression
   **/
  protected function parseDate($field, ValueExpression $valueExpression)
  {
    // check if we already have a snake case field name
    if (strpos($field, '_') <= 0) $field = snake_case($field);

    $this->query->where(
      $field,
      $valueExpression->getExpression(),
      $valueExpression->getValue()->toDateTimeString()
    );
  }

  /**
   * Add a relation constraint to the query object
   *
   * @param string $field
   * @param ValueExpression $valueExpression
   **/
  protected function parseRelation($field, ValueExpression $valueExpression)
  {
    // TODO: parse relations
    $this->query->has($field, $valueExpression->getValue());
  }

  /**
   * Execute the query and paginate the results according to request or config
   *
   * @throws \App\Exceptions\APIQueryException Rethrows any exception that happens on pagination (query execution)
   **/
  public function paginate()
  {
    try
    {
      $this->query = $this->query->paginate($this->getPaginationConfig());
    } catch (\Exception $e)
    {
      throw new APIQueryException($e);
    }
  }

  /**
   * Get number of items per page
   *
   * Check for a numeric limit parameter in the request,
   * if present use the absolute value of that parameter.
   *
   * Else, or if that parameter is 0, revert to the default
   * number of items per page stored in `oparl.itemsPerPage`
   *
   * @return int
   * @see config/oparl.php
   **/
  protected function getPaginationConfig()
  {
    $limit = 0;

    if (array_has($this->parameters, 'limit') && is_numeric($this->parameters['limit']))
    {
      $limit = intval($this->parameters['limit']);
      $limit = abs($limit);
    }

    return ($limit > 0) ? $limit : config('oparl.itemsPerPage');
  }

  /**
   * Speed up response generation with eager loading
   *
   * This method checks for includes that will be performed by
   * the output transformer and eagerly loads the models
   * in question beforehand.
   */
  protected function parseInclude()
  {
    $eagerLoadingKeys = explode(',', $this->parameters['include']);

    foreach ($eagerLoadingKeys as $eagerLoadingKey)
    {
      $this->query->load(array_diff($this->modelInformation->getRelations(), $eagerLoadingKey));
    }
  }
}