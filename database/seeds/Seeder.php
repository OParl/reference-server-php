<?php

use Illuminate\Database\Seeder as IlluminateSeeder;
use \Illuminate\Support\Collection;

/**
 * Class Seeder
 */
class Seeder extends IlluminateSeeder
{
  /**
   * @var $faker Faker\Generator
   */
  protected static $faker = null;

  /**
   * @var array
   */
  private $collectionItemStack = [];

  /**
   *
   */
  public function __construct()
  {
    if (is_null(static::$faker))
    {
      static::$faker = Faker\Factory::create('de_DE');
      static::$faker->seed(1727273948272); // have the faker always use the same seed for convenience

      static::$faker->addProvider(new OParl\Fakers\OrganizationsFaker(static::$faker));
      static::$faker->addProvider(new OParl\Fakers\MembershipsFaker(static::$faker));
      static::$faker->addProvider(new OParl\Fakers\LegislativeTermsFaker(static::$faker));
      static::$faker->addProvider(new OParl\Fakers\BodiesFaker(static::$faker));
      static::$faker->addProvider(new OParl\Fakers\DocumentsFaker(static::$faker));
    }
  }

  /**
   * @param string $name
   * @return string
   */
  protected function suffixedShortName($name)
  {
      $shortNameLetters = implode(' ', 
        array_map(
          function ($w) { 
            return strtoupper($w[0]); 
          }, 
        explode(' ', $name))
      );

      return static::$faker->lexify($shortNameLetters.' ???');
  }

  /**
   * @param \Illuminate\Support\Collection $collection
   * @param bool $unique
   * @return mixed
   */
  protected function getRandomItemFromCollection(Collection $collection, $unique = false, $resetUnique = false)
  {
    $max = $collection->count() - 1;

    if (!$unique)
    {
      return static::$faker->unique()->randomElement($collection);
    } else
    {
      $hash = md5($collection);
      if (!array_key_exists($hash, $this->collectionItemStack) || $resetUnique)
        $this->collectionItemStack[$hash] = [];

      do
      {
        $index = static::$faker->numberBetween(0, $max);
      } while (in_array($index, $this->collectionItemStack[$hash]));

      $this->collectionItemStack[$hash][] = $index;

      return $collection->get($index);
    }
  }

  /**
   * @param \Illuminate\Support\Collection $collection
   * @param int $minItems
   * @param int $maxItems
   * @return array
   */
  protected function getRandomArrayFromCollection(Collection $collection, $nbItems = 10)
  {
    if ($collection->count() <= $nbItems) return $collection;
    return $collection->random($nbItems);
  }
}
