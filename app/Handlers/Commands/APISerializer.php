<?php namespace App\Handlers\Commands;

use League\Fractal\Serializer\DataArraySerializer;

class APISerializer extends DataArraySerializer
{
  public function item($resourceKey, array $data)
  {
    foreach ($data as $key => $value)
      if (is_null($value)) unset($data[$key]);

    return parent::item($resourceKey, $data);
  }
}