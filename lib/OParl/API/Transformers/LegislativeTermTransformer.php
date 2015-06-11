<?php namespace OParl\API\Transformers;

use OParl\Model\LegislativeTerm;
use EFrane\Transfugio\Transformers\BaseTransformer;

class LegislativeTermTransformer extends BaseTransformer
{
  protected $availableIncludes = ['body'];

  public function transform(LegislativeTerm $legislativeTerm)
  {
    return [
      'id'        => route('api.v1.legislativeterm.show', $legislativeTerm->id),
      'type'      => $this->formatURL('http://oparl.org/schema/1.0/LegislativeTerm'),
      'body'      => route('api.v1.body.show', $legislativeTerm->body_id),
      'name'      => $legislativeTerm->name,
      'startDate' => $this->formatDate($legislativeTerm->start_date),
      'endDate'   => $this->formatDate($legislativeTerm->end_date),
      'created'   => $this->formatDate($legislativeTerm->created_at),
      'modified'  => $this->formatDate($legislativeTerm->updated_at)
    ];
  }

  public function includeBody(LegislativeTerm $legislativeTerm)
  {
    return $this->item($legislativeTerm->body, new BodyTransformer);
  }
}