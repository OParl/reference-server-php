<?php namespace App\Http\Controllers\API;

use App\Exceptions\APIQueryException;
use App\Services\APIQueryService\APIQueryService;
use \Input;

trait APIIndexPaginatedTrait
{
  public function index()
  {
    try
    {
      $parameters = \Input::only(['limit', 'where', 'include']);
      $query = APIQueryService::create($this->model, $parameters);

      if ($query->isUnresolved())
      {
        $toResolve = $query->getUnresolvedParameters();
        foreach ($toResolve as $field => $valueExpression)
        {
          $method = sprintf("query%s", ucfirst(camel_case($field)));

          if (method_exists($this, $method))
          {
            $this->{$method}($query, $valueExpression);
          } else
          {
            return $this->respondWithNotFound("The requested query could not be resolved on `{$this->getModelName()}`");
          }

          $query->paginate();
        }
      }

      $paginated = $query->getQuery();
    } catch (APIQueryException $e)
    {
      return $this->respondWithNotAllowed("The requested query method is not allowed on `{$this->getModelName()}`.");
    }

    return $this->respondWithPaginated($paginated);
  }
}
