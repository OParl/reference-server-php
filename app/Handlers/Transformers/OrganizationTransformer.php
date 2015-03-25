<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;
use Oparl\Organization;

class OrganizationTransformer extends TransformerAbstract
{
  public function transform(Organization $organization)
  {
    return [
      'id' => $organization->id
    ];
  }
}