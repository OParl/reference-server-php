<?php namespace App\Http\Controllers\API;

use \Request;

trait APIIndexPaginatedTrait
{
  public function index()
  {
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

        return $this->respondWithPaginated($query->paginate(15));
      } else
      {
        return $this->respondWithNotAllowed("The requested query method is not allowed on `{$this->getModelName()}`.");
      }
    }

    return $this->respondWithPaginated(call_user_func([$this->model, 'paginate'], 15));
  }
}
