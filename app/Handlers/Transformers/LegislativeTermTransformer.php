<?php namespace App\Handlers\Transformers;

use OParl\LegislativeTerm;

class LegislativeTermTransformer extends TransformerAbstract
{
  public function transform(LegislativeTerm $legislativeTerm)
  {
    return [
      'id' => route('api.v1.legislativeterm.show', $legislativeTerm->id),
      
    ];
  }
}