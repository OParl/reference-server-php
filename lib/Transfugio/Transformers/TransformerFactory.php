<?php namespace EFrane\Transfugio\Transformers;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class TransformerFactory 
{
  protected static $instance = null;

  protected function __construct() {}
  private function __clone() {}

  protected static function get()
  {
    if (static::$instance === null)
      static::$instance = new TransformerFactory;

    return static::$instance;
  }

  protected function determineTransformerClass(Model $model)
  {
    $modelName = class_basename($model);
    $transformerNamespace = config('transfugio.transformers.namespace');

    $classPattern = config('transfugio.transformers.classPattern');
    $classBaseName = str_replace('[:modelName]', $modelName, $classPattern);

    $transformerClass = sprintf('%s\%s', $transformerNamespace, $classBaseName);

    return $transformerClass;
  }

  protected function makeTransformer($className)
  {
    if (class_exists($className))
    {
      return new $className;
    } else
    {
      throw new \LogicException("Could not instantiate transformer {$className}.");
    }
  }

  static public function makeForModel(Model $model)
  {
    $instance = static::get();

    $className = $instance->determineTransformerClass($model);
    return $instance->makeTransformer($className);
  }

  static public function makeForCollection(Collection $collection)
  {
    if ($collection->count() === 0)
      throw new \OutOfRangeException("Can't access collection model.");

    return static::makeForModel($collection->first());
  }
}