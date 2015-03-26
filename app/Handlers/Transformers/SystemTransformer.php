<?php namespace App\Handlers\Transformers;

use Oparl\System;

class SystemTransformer extends TransformerAbstract
{
  protected $availableIncludes = ['body'];

  public function transform(System $system)
  {
    return [
      'id'           => route('api.v1.system.index'),
      'name'         => $system->id,
      'type'         => 'http://oparl.org/schema/1.0/System',
      'oparlVersion' => $system->oparlVersion,
      'vendor'       => $system->vendor,
      'product'      => $system->product,
      'contactEmail' => 'email@address',
      'contactName'  => 'Contact Name',
      'body'         => route('api.v1.body.index'),

      // TODO: feed links
      'links' => [
        [
          'rel'  => 'feed',
          'type' => 'newObjects',
          'href' => ''
        ],
        [
          'rel'  => 'feed',
          'type' => 'updatedObjects',
          'href' => ''
        ],
        [
          'rel'  => 'feed',
          'type' => 'removedObjects',
          'href' => ''
        ],
      ]
    ];
  }

  public function includeBody(System $system)
  {
    return $this->collection($system->bodies, new BodyTransformer);
  }
}