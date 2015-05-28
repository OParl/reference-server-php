<?php namespace App\Handlers\Transformers;

use Oparl\Consultation;

class ConsultationTransformer extends TransformerAbstract
{
  protected $availableIncludes = ['paper', 'agendaItem', 'organization'];

  public function transform(Consultation $consultation)
  {
    return [
      'id'            => route('api.v1.consultation.show', $consultation->id),
      'type'          => 'http://oparl.org/schema/1.0/Consultation',
      'paper'         => route('api.v1.paper.show', $consultation->paper_id),
      'agendaItem'    => route('api.v1.agendaitem.show', $consultation->agenda_item_id),
      'organization'  => ($consultation->organizations)
                           ? $this->collectionRouteList('api.v1.organization.show', $consultation->organizations)
                           : null,
      'authoritative' => (boolean)$consultation->authoritative,
      'role'          => $consultation->role,
      'keyword'       => $consultation->keyword
    ];
  }

  public function includePaper(Consultation $consultation)
  {
    return $this->item($consultation->paper, new PaperTransformer);
  }

  public function includeAgendaItem(Consultation $consultation)
  {
    return $this->item($consultation->agendaItem, new AgendaItemTransformer);
  }

  public function includeOrganization(Consultation $consultation)
  {
    return $this->collection($consultation->organization, new OrganizationTransformer);
  }
}