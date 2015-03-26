<?php namespace App\Handlers\Transformers;

use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;
use Oparl\Body;

class BodyTransformer extends TransformerAbstract
{
  protected $availableIncludes = ['system', 'organization', 'member', 'meeting', 'paper', 'legislativeTerm'];

  public function transform(Body $body)
  {
    return [
      'id'                => route('api.v1.body.show', $body->id),
      'type'              => 'http://oparl.org/schema/1.0/Body',
      'system'            => route('api.v1.system.index'),
      'contactEmail'      => $body->contact_email,
      'contactName'       => $body->contact_name,
      'rgs'               => $body->rgs,
      'equivalentBody'    => $body->equivalent_body,
      'shortName'         => $body->short_name,
      'name'              => $body->name,
      'website'           => $body->website,
      'license'           => $body->license,
      'licenseValidSince' => ($body->license_valid_since) ? $body->license_valid_since->toRfc2822String() : null,
      'organization'      => route_where('api.v1.organization.index', ['body' => $body->id]),
      'meeting'           => route_where('api.v1.meeting.index', ['body' => $body->id]),
      'paper'             => route_where('api.v1.paper.index',    ['body' => $body->id]),
      'member'            => route_where('api.v1.person.index',   ['body' => $body->id]),
      'legislativeTerm'   => route_where('api.v1.legislativeTerm.index', ['body' => $body->id]),
      'classification'    => $body->classification,
      'keyword'           => $body->keyword,
      'created'           => $body->created_at->toRfc2822String(),
      'modified'          => $body->updated_at->toRfc2822String()
    ];
  }

  public function includeSystem(Body $body)
  {
    return $this->item($body->system, new SystemTransformer);
  }

  public function includeMember(Body $body)
  {
    return $this->collection($body->people, new PersonTransformer);
  }

  public function includeOrganization(Body $body)
  {
    return $this->collection($body->organizations, new OrganizationTransformer);
  }

  /**
   * Return the first 30 meetings for this body, sorted by organization
   *
   * @param Body $body
   * @return \League\Fractal\Resource\Collection
   **/
  public function includeMeeting(Body $body)
  {
    $meetings = new Collection;
    foreach ($body->organizations as $organization)
    {
      $meetings = $meetings->merge($organization->meetings);
      if ($meetings->count() >= 30) break;
    }

    return $this->collection($meetings->slice(0, 30), new MeetingTransformer);
  }

  public function includePaper(Body $body)
  {
    $papers = new Collection;
    foreach ($body->organizations as $organization)
    {
      foreach ($organization->meetings as $meeting)
      {
        $papers = $papers->merge($meeting->papers);
        if ($papers->count() >= 30) break;
      }
    }

    return $this->collection($papers->slice(0, 30), new PaperTransformer);
  }

  public function includeLegislativeTerm(Body $body)
  {
    return $this->collection($body->legislativeTerms, new LegislativeTermTransformer);
  }
}