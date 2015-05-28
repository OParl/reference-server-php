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
      $query = APIQueryService::create($this->model, $parameters, function ($unresolved, $service) {
        return $this->resolveQuery($unresolved, $service);
      });

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
   * Controllers implementing custom resolvers have to follow the below
   * naming scheme for resolver methods:
   *
   * <code>
   *   protected function query<Field>(APIQueryService $query, ValueExpression $valueExpression);
   * </code>
   *
   * with `Field` being the camel case version of the field for the queried
   * constraint.
   *
   * If a resolver method can not be called succesfully, the request will fail
   * into a `405 Method Not Allowed` explaining that the requested query method
   * is not allowed.
   *
   * NOTE: Although, `ValueExpression` delivers a lot of flexibility in terms of
   * evaluating input expressions, it is always possible to get the raw input expression with
   * `$valueExpression->getRaw()`.
   *
   * @param array $toResolve Conditions to resolve
   * @param APIQueryService $query
   * @return boolean resolve success
   **/
  protected function resolveQuery(array $toResolve, APIQueryService $query)
  {
    foreach ($toResolve as $field => $valueExpression) {
      $method = sprintf("query%s", ucfirst(camel_case($field)));

      if (method_exists($this, $method))
      {
        $this->{$method}($query, $valueExpression);
      } else
      {
        throw new APIQueryException("Query method {$method} not found.");
      }
    }

    return true;
  }
}
