<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;
use Oparl\Membership;

class MembershipTransformer extends TransformerAbstract
{
  public function transform(Membership $membership)
  {
    return [
      'id' => $membership->id
    ];
  }
}