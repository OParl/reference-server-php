<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;
use Oparl\System;

class SystemTransformer extends TransformerAbstract
{
  public function transform(System $system)
  {
    return [
      'id' => $system->id
    ];
  }
}