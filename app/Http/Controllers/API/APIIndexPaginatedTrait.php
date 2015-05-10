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
      $parameters = \Input::only(['where', 'include']);
      $query = APIQueryService::create($this->model, $parameters);
    } catch (APIQueryException $e)
    {
      return $this->respondWithNotAllowed("The requested query method is not allowed on `{$this->getModelName()}`.");
    }

    return $this->respondWithPaginated($query);
  }
}
