<?php namespace App\Http\Controllers\API;

use App\Exceptions\APIQueryException;
use App\Services\APIQueryService\APIQueryService;
use \Input;

trait APIIndexPaginatedTrait
{
  public function index()
  {
    \DB::enableQueryLog();

    try
    {
      $parameters = \Input::only(['limit', 'where', 'include']);
      $query = APIQueryService::create($this->model, $parameters);

      $paginated = $query->getQuery();

      if ($query->isUnresolved())
      {
        // TODO: handle unresolved query

        // $toResolve = $query->getUnresolvedParameters();
        // $paginated = $query->paginate();

        return $this->respondWithNotFound("The requested query could not be resolved on `{$this->getModelName()}`");
      }
    } catch (APIQueryException $e)
    {
      return $this->respondWithNotAllowed("The requested query method is not allowed on `{$this->getModelName()}`.");
    }

    return $this->respondWithPaginated($paginated);
  }
}
