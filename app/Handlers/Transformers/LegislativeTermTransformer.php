<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;
use OParl\LegislativeTerm;

class LegislativeTermTransformer extends TransformerAbstract
{
  public function transform(LegislativeTerm $legislativeTerm)
  {
    return [
      'id' => $legislativeTerm->id
    ];
  }
}