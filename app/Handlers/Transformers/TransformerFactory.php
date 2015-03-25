<?php namespace App\Handlers\Transformers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

final class TransformerFactory {
  static public function makeForModel(Model $model)
  {
    $modelName = class_basename($model);
    $transformerClass = sprintf('App\Handlers\Transformers\%sTransformer', $modelName);
    if (class_exists($transformerClass))
    {
      return new $transformerClass;
    }
  }

  static public function makeForCollection(Collection $collection)
  {
    if ($collection->count() == 0)
    {
      throw new \OutOfRangeException("Can't access collection model.");
    }

    return static::makeForModel($collection->first());
  }
}