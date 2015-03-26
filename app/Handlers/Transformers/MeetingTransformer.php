<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;
use Oparl\Meeting;

class MeetingTransformer extends TransformerAbstract
{
  public function transform(Meeting $meeting)
  {
    return [
      'id' => $meeting->id
    ];
  }
}