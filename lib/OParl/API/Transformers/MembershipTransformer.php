<?php namespace OParl\API\Transformers;

use OParl\Model\Membership;
use EFrane\Transfugio\Transformers\BaseTransformer;

class MembershipTransformer extends BaseTransformer
{
  public function transform(Membership $membership)
  {
    return [
      'id'           => route('api.v1.membership.show', $membership->id),
      'type'         => 'http://oparl.org/schema/1.0/Membership',
      'person'       => route('api.v1.person.show', $membership->person_id),
      'organization' => route('api.v1.organization.show', $membership->organization_id),
      'role'         => $membership->role,
      'post'         => $membership->post,
      'onBehalfOf'   => null, // FIXME: See database/migrations/2015_02_21_154911_create_memberships_table.php
      'votingRight'  => $membership->voting_right,
      'startDate'    => $this->formatDate($membership->start_date),
      'endDate'      => $this->formatDate($membership->end_date)
    ];
  }
}