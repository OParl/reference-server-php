<?php namespace App\Handlers\Commands;

use League\Fractal\Serializer\DataArraySerializer;

class APISerializer extends DataArraySerializer
{
  public function item($resourceKey, array $data)
  {
    $data = $this->reformatData($data);

    return parent::item($resourceKey, $data);
  }

  public function collection($resourceKey, array $data)
  {
    $data = $this->reformatData($data);

    return parent::collection($resourceKey, $data);
  }

  protected function applyFormatParameterToUrls(array $data)
  {
    return array_map(function ($value) {
      if (is_array($value))
        return $this->applyFormatParameterToUrls($value);

      $pattern = sprintf('/%s.+/', preg_quote(url('api/v1/'), '/'));
      $format = config('api.format');

      if (is_string($value)
      &&  preg_match($pattern, $value)
      &&  $format !== 'json_accept')
      {
        $value .= (strpos($value, '?') > 0) ? '&' : '?';
        $value .= 'format='.config('api.format');
      }

      return $value;
    }, $data);
  }

  /**
   * @param array $data
   * @return array
   **/
  protected function reformatData(array $data)
  {
    foreach ($data as $key => $value) {
      if (is_null($value)
        || (is_array($value) && count($value) == 0)
      ) unset($data[$key]);
    }

    $data = $this->applyFormatParameterToUrls($data);
    return $data;
  }
}