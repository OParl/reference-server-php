<?php namespace OParl\API\Transformers;

use Illuminate\Support\Collection;

use OParl\Model\Body;
use EFrane\Transfugio\Transformers\BaseTransformer;

class BodyTransformer extends BaseTransformer
{
  protected $availableIncludes = ['system', 'organization', 'member', 'meeting', 'paper', 'legislativeTerm'];

  public function transform(Body $body)
  {
    return [
      'id'                => route('api.v1.body.show', $body->id),
      'type'              => 'http://oparl.org/schema/1.0/Body',
      'system'            => route('api.v1.system.index'),
      'contactEmail'      => $this->formatEmail($body->contact_email),
      'contactName'       => $body->contact_name,
      'rgs'               => $body->rgs,
      'equivalentBody'    => $body->equivalent_body,
      'shortName'         => $body->short_name,
      'name'              => $body->name,
      'website'           => $body->website,
      'license'           => $body->license,
      'licenseValidSince' => ($body->license_valid_since) ? $this->formatDate($body->license_valid_since) : null,
      'organization'      => route_where('api.v1.organization.index',    ['body' => $body->id]),
      'meeting'           => route_where('api.v1.meeting.index',         ['body' => $body->id]),
      'paper'             => route_where('api.v1.paper.index',           ['body' => $body->id]),
      'person'            => route_where('api.v1.person.index',          ['body' => $body->id]),
      'agendaItem'        => route_where('api.v1.agendaitem.index',      ['body' => $body->id]),
      'file'              => route_where('api.v1.file.index',            ['body' => $body->id]), // TODO: DISCUSS!
      'consultation'      => route_where('api.v1.consultation.index',    ['body' => $body->id]),
      'location'          => route_where('api.v1.location.index',        ['body' => $body->id]), // TODO: DISCUSS!
      'membership'        => route_where('api.v1.membership.index',      ['body' => $body->id]), // TODO: DISCUSS!
      'legislativeTerm'   => $this->collectionRouteList('api.v1.legislativeterm.show', $body->legislativeTerms),
      'classification'    => $body->classification,
      'keyword'           => $body->keyword,
      'created'           => $this->formatDate($body->created_at),
      'modified'          => $this->formatDate($body->updated_at)
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