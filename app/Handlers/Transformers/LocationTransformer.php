<?php namespace App\Handlers\Transformers;

use Oparl\Location;

class LocationTransformer extends TransformerAbstract
{
  public function transform(Location $location)
  {
    return [
      'id'          => route('api.v1.location.show', $location->id),
      'type'        => 'http://oparl.org/schema/1.0/Location',
      'description' => $location->description,
      'address'     => $location->address,
      'geometry'    => $location->geometry,
      'keyword'     => $location->keyword
    ];
  }
}