<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;
use Oparl\Body;

class BodyTransformer extends TransformerAbstract
{
  public function transform(Body $body)
  {
    return [
      'id' => $body->id
    ];
  }
}