<?php namespace App\Http\Controllers\API;

trait APIShowItemTrait
{
  public function show($id)
  {
    if (!property_exists($this, 'model'))
    {
      throw new RuntimeException('This trait requires a model property to be set.');
    }

    try
    {
      $item = call_user_func([$this->model, 'findOrFail'], $id);
      return $this->respondWithItem($item);
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e)
    {
      return $this->respondWithNotFound("The requested item from `{$this->model}` does not exist.");
    }
  }
}
