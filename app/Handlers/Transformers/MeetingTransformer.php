<?php namespace App\Handlers\Transformers;

use Oparl\Meeting;

class MeetingTransformer extends TransformerAbstract
{
  protected $availableIncludes = [
    'location',
    'organization',
    'chairPerson',
    'scribe',
    'participant',
    'invitation',
    'resultsProtocol',
    'verbatimProtocol',
    'auxiliaryFile',
    'agendaItem'
  ];

  public function transform(Meeting $meeting)
  {
    return [
      'id'               => route('api.v1.meeting.show', $meeting->id),
      'type'             => 'http://oparl.org/schema/1.0/Meeting',
      'start'            => $this->formatDate($meeting->start),
      'end'              => $this->formatDate($meeting->end),
      'streetAddress'    => $meeting->street_address,
      'postalCode'       => $meeting->postal_code,
      'locality'         => $meeting->locality,
      'location'         => route('api.v1.location.show', $meeting->location_id),
      'organization'     => route('api.v1.organization.show', $meeting->organization_id),
      'chairPerson'      => route('api.v1.person.show', $meeting->chair_person_id),
      'scribe'           => route('api.v1.person.show', $meeting->scribe_id),
      'participant'      => $this->collectionRouteList('api.v1.person.show', $meeting->participants),
      'invitation'       => $this->collectionRouteList('api.v1.file.show', $meeting->invitations),
      'resultsProtocol'  => ($meeting->results_protocol_id)
                              ? route('api.v1.file.show', $meeting->results_protocol_id)
                              : null,
      'verbatimProtocol' => ($meeting->verbatim_protocol_id)
                              ?route('api.v1.file.show', $meeting->verbatim_protocol_id)
                              : null,
      'auxiliaryFile'    => $this->collectionRouteList('api.v1.file.show', $meeting->auxiliaryFiles),
      'agendaItem'       => route_where('api.v1.agendaitem.index', ['meeting' => $meeting->id]),
      'keyword'          => $meeting->keyword,
      'created'          => $this->formatDate($meeting->created_at),
      'updated'          => $this->formatDate($meeting->modified_at)
    ];
  }

  public function includeLocation(Meeting $meeting)
  {
    return $this->item($meeting->location, new LocationTransformer);
  }

  public function includeOrganization(Meeting $meeting)
  {
    return $this->item($meeting->organization, new OrganizationTransformer);
  }

  public function includeChairPerson(Meeting $meeting)
  {
    return $this->item($meeting->chair, new PersonTransformer);
  }

  public function includeScribe(Meeting $meeting)
  {
    return $this->item($meeting->scribe, new PersonTransformer);
  }

  public function includeParticipant(Meeting $meeting)
  {
    return $this->collection($meeting->participants, new PersonTransformer);
  }

  public function includeInvitation(Meeting $meeting)
  {
    return $this->collection($meeting->invitations, new FileTransformer);
  }

  public function includeResultsProtocol(Meeting $meeting)
  {
    return $this->item($meeting->resultsProtocol, new FileTransformer);
  }

  public function includeVerbatimProtocol(Meeting $meeting)
  {
    return $this->item($meeting->verbatimProtocol, new FileTransformer);
  }

  public function includeAuxiliaryFile(Meeting $meeting)
  {
    return $this->collection($meeting->auxiliaryFiles, new FileTransformer);
  }

  public function includeAgendaItem(Meeting $meeting)
  {
    return $this->collection($meeting->agendaItems, new AgendaItemTransformer);
  }
}
