<?php namespace App\Handlers\Transformers;

use Oparl\Organization;

class OrganizationTransformer extends TransformerAbstract
{
  protected $availableIncludes = ['body', 'meeting', 'membership'];

  public function transform(Organization $organization)
  {
    return [
      'id'                => route('api.v1.organization.show', $organization->id),
      'type'              => 'http://oparl.org/schema/1.0/Organization',
      'body'              => route('api.v1.body.show', $organization->body->id),
      'name'              => $organization->name,
      'shortName'         => $organization->short_name,
      'post'              => $organization->post,
      'meeting'           => route_where('api.v1.meeting.index', ['organization' => $organization->id]),
      'membership'        => route_where('api.v1.membership.index', ['organization' => $organization->id]),
      'suborganizationOf' => ($organization->suborganizationOf)
                               ? route('api.v1.organization.show', $organization->suborganizationOf->id)
                               : null,
      'classification'    => $organization->classification,
      'keyword'           => $organization->keyword,
      'startDate'         => $this->formatDate($organization->start_date),
      'endDate'           => $this->formatDate($organization->end_date),
      'created'           => $this->formatDate($organization->created_at),
      'modified'          => $this->formatDate($organization->updated_at)
    ];
  }

  public function includeBody(Organization $organization)
  {
    return $this->item($organization->body, new BodyTransformer);
  }

  public function includeMeeting(Organization $organization)
  {
    return null; // FIXME: implement
  }

  public function includeMembership(Organization $organization)
  {
    return $this->collection($organization->members, new MembershipTransformer);
  }
}