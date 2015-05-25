<?php namespace App\Http\Controllers\API;

use App\Exceptions\APIQueryException;
use App\Services\APIQueryService\APIQueryService;
use Illuminate\Http\Request;

trait APIIndexPaginatedTrait
{
  public function index(Request $request)
  {
    try
    {
      $parameters = $request->only(['limit', 'where', 'include']);
      $query = APIQueryService::create($this->model, $parameters);

      if ($query->isUnresolved())
        $this->resolveQuery($query);

      $paginated = $query->getQuery();
    } catch (APIQueryException $e)
    {
      return $this->respondWithNotAllowed("The requested query method is not allowed on `{$this->getModelName()}`.");
    }

    return $this->respondWithPaginated($paginated);
  }

  /**
   * Resolve unfinished queries
   *
   * If the `APIQueryService` is unable to resolve all conditions on a query
   * the query remains unresolved. This gives entity controllers the
   * opportunity to implement resolvers for custom conditions that may
   * for instance require joins on the database or other information that is
   * not accessible to the `APIQueryService`.
   *
   * @param $query APIQueryService
   **/
  protected function resolveQuery(APIQueryService $query)
  {
    $toResolve = $query->getUnresolvedParameters();

    foreach ($toResolve as $field => $valueExpression) {
      $method = sprintf("query%s", ucfirst(camel_case($field)));

      if (method_exists($this, $method))
      {
        $this->{$method}($query, $valueExpression);
      } else
      {
        throw new APIQueryException("Query method {$method} not found.");
      }

      $query->paginate();
    }
  }
}
