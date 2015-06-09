<?php namespace App\Handlers\Transformers;

use Oparl\Paper;
use EFrane\Transfugio\Transformers\BaseTransformer;

class PaperTransformer extends BaseTransformer
{
  public function transform(Paper $paper)
  {
    return [
      'id'            => route('api.v1.paper.show', $paper->id),
      'type'          => 'http://oparl.org/schema/1.0/Paper',
      'body'          => route('api.v1.body.show', $paper->body_id),
      'name'          => $paper->name,
      'reference'     => $paper->reference,
      'paperType'     => $paper->paper_type,
      'relatedPaper'  => $this->collectionRouteList('api.v1.paper.show', $paper->relatedPapers),
      'mainFile'      => route('api.v1.file.show', $paper->main_file_id),
      'auxiliaryFile' => $this->collectionRouteList('api.v1.file.show', $paper->auxiliaryFiles),
      'location'      => route('api.v1.location.show', $paper->location_id),
      'originator'    => null, // FIXME: This really is BAD SCHEMA DESIGN
      'consultation'  => $this->collectionRouteList('api.v1.consultation.show', $paper->consultations),
      'keyword'       => $paper->keyword,

      'underDirectionOf' => route('api.v1.organization.show', $paper->under_direction_of_id),

      'publishedDate' => $this->formatDate($paper->published_date),
      'modifiedDate'  => $this->formatDate($paper->modified_at),
    ];
  }
}