<?php namespace App\Handlers\Transformers;

use Oparl\AgendaItem;

class AgendaItemTransformer extends TransformerAbstract
{
  public function transform(AgendaItem $agendaItem)
  {
    return [
      'id' => $agendaItem->id
    ];
  }
}