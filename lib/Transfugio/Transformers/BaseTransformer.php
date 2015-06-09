<?php namespace EFrane\Transfugio\Transformers;

use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
  private $availableFormatters = [];
  private $loadedFormatters = [];

  public function __construct()
  {
    $this->availableFormatters = config('transfugio.transformers.formatHelpers');
  }

  /**
   * Get a route list (object list) from a Collection
   *
   * @param string $routeName
   * @param Collection $collection
   * @param string $key
   * @return array
   **/
  protected function collectionRouteList($routeName, Collection $collection, $key = 'id')
  {
    $keys = $collection->lists($key);

    return array_map(function ($key) use ($routeName) {
      return route($routeName, $key);
    }, $keys);
  }

  public function __call($formatHelperMethod, array $value)
  {
    if (substr($formatHelperMethod, 0, 6) !== 'format')
      throw new \LogicException("Format helper {$formatHelperMethod} is invalid");

    $formatHelperName = strtolower(substr($formatHelperMethod, 6));

    if (array_key_exists($formatHelperName, $this->availableFormatters))
    {
      // load the format helper
      if (!array_key_exists($formatHelperName, $this->loadedFormatters))
        $this->loadedFormatters[$formatHelperName] = new $this->availableFormatters[$formatHelperName];

      // check for null value
      if (is_null($value[0])) return null;

      return $this->loadedFormatters[$formatHelperName]->format($value[0]);
    }
  }
}
