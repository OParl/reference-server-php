<?php namespace App\Http\Controllers\API;

trait APIIndexPaginatedTrait
{
  public function index()
  {
    if (!property_exists($this, 'model'))
    {
      throw new RuntimeException('This trait requires a model property to be set.');
    }

    return $this->respondWithPaginated(call_user_func([$this->model, 'paginate'], 15));
  }
}
