<?php namespace App\Http\Controllers\API;

trait APIIndexCollectionTrait
{
  public function index()
  {
    if (!property_exists($this, 'model'))
    {
      throw new RuntimeException('This trait requires a model property to be set.');
    }

    return $this->respondWithCollection(call_user_func([$this->model, 'all']));
  }
}
