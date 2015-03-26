<?php namespace App\Handlers\Transformers;

use Oparl\Consultation;

class ConsultationTransformer extends TransformerAbstract
{
  public function transform(Consultation $consultation)
  {
    return [
      'id' => $consultation->id
    ];
  }
}