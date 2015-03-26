<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;
use Oparl\Person;

class PersonTransformer extends TransformerAbstract
{
  public function transform(Person $person)
  {
    return [
      'id' => $person->id

    ];
  }
}