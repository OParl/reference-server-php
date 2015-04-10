<?php namespace App\Http\Controllers\API;

use \Request;

trait APIIndexPaginatedTrait
{
  private function parseWhere($where)
  {
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
    } else
    {
      return $this->respondWithNotAllowed("The requested query method is not allowed on `{$this->getModelName()}`.");
    }

    return $query;
  }

  private function parseInclude($include, $query)
  {
    $eagerLoadingKeys = explode(',', $include);

    foreach ($eagerLoadingKeys as $eagerLoadingKey)
    {
      if (class_method_exists($this->model, $eagerLoadingKey))
      {
        $query->load($eagerLoadingKey);
        continue;
      }

      $eagerLoadingKey = str_plural($eagerLoadingKey);
      if (class_method_exists($this->model, $eagerLoadingKey))
        $query->load($eagerLoadingKey);
    }

    return $query;
  }

  public function index()
  {
    $query = null;

    if (Request::has('where'))
    {
      $parsed = $this->parseWhere(Request::input('where'));
      if ($parsed instanceof \HttpResponse)
        return $parsed;

      $query = $parsed;
    } else
    {
      $query = call_user_func([$this->model, 'paginate'], config('oparl.pageElements'));
    }

    if (Request::has('include'))
      $query = $this->parseInclude(Request::input('include'), $query);

    return $this->respondWithPaginated($query);
  }
}
