<?php namespace App\Handlers\Commands;

use League\Fractal\Serializer\DataArraySerializer;

class APISerializer extends DataArraySerializer
{
  public function item($resourceKey, array $data)
  {
    foreach ($data as $key => $value)
    {
      if (is_null($value)
      || (is_array($value) && count($value) == 0)) unset($data[$key]);
    }

    $data = $this->applyFormatParameterToUrls($data);

    return parent::item($resourceKey, $data);
  }

  protected function applyFormatParameterToUrls(array $data)
  {
    return array_map(function ($value) {
      if (is_array($value))
        return $this->applyFormatParameterToUrls($value);

      $pattern = sprintf('/%s[[:print:]]+/', preg_quote(url('api/v1/'), '/'));
      if (is_string($value) && preg_match($pattern, $value))
      {
        $value .= '?format='.config('api.format');
      }

      return $value;
    }, $data);
  }
}