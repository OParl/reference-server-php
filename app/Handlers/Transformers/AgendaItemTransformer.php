<?php namespace App\Handlers\Transformers;

use Oparl\AgendaItem;

class AgendaItemTransformer extends TransformerAbstract
{
  protected $availableIncludes = ['meeting', 'consultation'];

  public function transform(AgendaItem $agendaItem)
  {
    return [
      'id' => route('api.v1.agendaitem.show', $agendaItem->id),
      'type' => 'http://oparl.org/schema/1.0/AgendaItem',
      'meeting' => route('api.v1.meeting.show', $agendaItem->meeting_id),
      'number' => $agendaItem->number,
      'name'  => $agendaItem->name,
      'public' => (boolean)$agendaItem->public,
      'consultation' => ($agendaItem->consultation_id)
                          ? route('api.v1.consultation.show', $agendaItem->consultation_id)
                          : null,
      'result' => $agendaItem->result,
      'resolution' => $agendaItem->resolution,
      'created' => $this->formatDate($agendaItem->created_at),
      'updated' => $this->formatDate($agendaItem->modified_at)
    ];
  }

  public function includeMeeting(AgendaItem $agendaItem)
  {
    return $this->item($agendaItem->meeting, new MeetingTransformer);
  }

  public function includeConsultation(AgendaItem $agendaItem)
  {
    return $this->item($agendaItem->consultation, new ConsultationTransformer);
  }
}