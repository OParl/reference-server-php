<?php namespace App\Http\Controllers\API;

use \Request;

trait APIIndexPaginatedTrait
{
  public function index()
  {
    $query = null;

    if (Request::input('where'))
    {
      $clauses = decode_where(Request::input('where'));

      $clauses = array_filter_keys($clauses, function($clause) {
        return class_method_exists($this->model, $clause)
            || class_method_exists($this->model, str_plural($clause));
      });

      $clauses = array_map_keys(function ($val) {
        return sprintf('where%sId', ucwords($val));
      }, $clauses);

      if (count($clauses) > 0)
      {
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
    }

    if (!$query) $query = call_user_func([$this->model, 'paginate'], config('oparl.pageElements'));

    /*if (Request::input('include'))
    {
      $query->load(explode(',', Request::input('include')));
    }*/

    return $this->respondWithPaginated($query);
  }
}
