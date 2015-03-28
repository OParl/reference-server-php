<?php namespace App\Handlers\Transformers;

use Oparl\Paper;

class PaperTransformer extends TransformerAbstract
{
  public function transform(Paper $paper)
  {
    return [
      'id'            => route('api.v1.paper.show', $paper->id),
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

      'publishedDate' => $this->formatDate('published_date'),
      'modified'      => $this->formatDate('modified_at'),
    ];
  }
}