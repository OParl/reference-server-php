<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;
use Oparl\AgendaItem;

class BodyTransformer extends TransformerAbstract
{
  public function transform(AgendaItem $agendaItem)
  {
    return [
      'id' => $agendaItem->id
    ];
  }
}