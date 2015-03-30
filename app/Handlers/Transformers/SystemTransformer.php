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
      'contactEmail' => $this->formatEmail('email@address.com'),
      'contactName'  => 'Contact Name',
      'body'         => route('api.v1.body.index'),
      
      'links' => [
        [
          'rel'  => 'feed+atom',
          'type' => 'newObjects',
          'href' => route('feed.show', ['new', 'atom'])
        ],
        [
          'rel'  => 'feed+atom',
          'type' => 'updatedObjects',
          'href' => route('feed.show', ['updated', 'atom'])
        ],
        [
          'rel'  => 'feed+atom',
          'type' => 'removedObjects',
          'href' => route('feed.show', ['removed', 'atom'])
        ],
        [
          'rel'  => 'feed+rss',
          'type' => 'newObjects',
          'href' => route('feed.show', ['new', 'rss'])
        ],
        [
          'rel'  => 'feed+rss',
          'type' => 'updatedObjects',
          'href' => route('feed.show', ['updated', 'rss'])
        ],
        [
          'rel'  => 'feed+rss',
          'type' => 'removedObjects',
          'href' => route('feed.show', ['removed', 'rss'])
        ],
      ]
    ];
  }

  public function includeBody(System $system)
  {
    return $this->collection($system->bodies, new BodyTransformer);
  }
}