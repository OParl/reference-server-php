<?php namespace App\Handlers\Transformers;

use Oparl\Paper;

class PaperTransformer extends TransformerAbstract
{
  public function transform(Paper $paper)
  {
    return [
      'id' => $paper->id
    ];
  }
}