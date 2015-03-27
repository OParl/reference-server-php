<?php namespace App\Handlers\Transformers;

use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract as LeagueTransformer;

use Carbon\Carbon;

abstract class TransformerAbstract extends LeagueTransformer
{
  protected function collectionRouteList(Collection $collection, $routeName, $key = 'id')
  {
    $keys = $collection->lists($key);

    return array_map(function ($key) use ($routeName) {
      return route($routeName, $key);
    }, $keys);
  }

  protected function formatDate(Carbon $date = null)
  {
    if (is_null($date)) return null;

    return $date->toIso8601String();
  }

  /**
   * Format a phone number to the tel: schema
   *
   * It might be beneficial to make use of something like
   * https://github.com/giggsey/libphonenumber-for-php for this
   * eventhough it is such a small detail.
   *
   * @param string $phone raw phone number
   * @return string formatted phone number
   **/
  protected function formatPhoneNumber($phone)
  {
    // remove common formatting characters
    str_replace(['(', ')', ' '], '', $phone);

    // remove leading zeroes
    while (strpos($phone, '0') === 0)
    $phone = substr($phone, 1);

    return sprintf('tel:%s', $phone);
  }

  protected function formatEmail($email)
  {
    return sprintf('mailto:%s', strtolower($email));
  }
}