<?php namespace App\Handlers\Transformers;

use Oparl\Membership;

class MembershipTransformer extends TransformerAbstract
{
  public function transform(Membership $membership)
  {
    return [
      'id' => route('api.v1.membership.show', $membership->id),
      'person' => route('api.v1.person.show', $membership->person_id),
      'organization' => route('api.v1.organization.show', $membership->organization_id)
    ];
  }
}