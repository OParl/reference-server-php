<?php namespace App\Handlers\Transformers;

use Oparl\Location;
use EFrane\Transfugio\Transformers\BaseTransformer;

class LocationTransformer extends BaseTransformer
{
  public function transform(Location $location)
  {
    return [
      'id'          => route('api.v1.location.show', $location->id),
      'type'        => 'http://oparl.org/schema/1.0/Location',
      'description' => $location->description,
      'address'     => $location->address,
      'geometry'    => $location->geometry,
      'keyword'     => $location->keyword,
      'created'     => $this->formatDate($location->created_at),
      'modified'    => $this->formatDate($location->updated_at)
    ];
  }
}