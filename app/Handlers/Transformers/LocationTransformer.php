<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;
use Oparl\Location;

class LocationTransformer extends TransformerAbstract
{
  public function transform(Location $location)
  {
    return [
      'id' => $location->id
    ];
  }
}