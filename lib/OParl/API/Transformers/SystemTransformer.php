<?php namespace OParl\API\Transformers;

use OParl\Model\System;
use EFrane\Transfugio\Transformers\BaseTransformer;

class SystemTransformer extends BaseTransformer
{
  protected $availableIncludes = ['body'];

  public function transform(System $system)
  {
    return [
      'id'           => route('api.v1.system.index'),
      'name'         => $system->id,
      'type'         => 'http://oparl.org/schema/1.0/System',
      'oparlVersion' => 'http://oparl.org/specs/1.0/',
      'vendor'       => 'http://oparl.org/',
      'product'      => 'http://oparl.org/implementations/php-reference-server',
      'contactEmail' => $this->formatEmail('email@address.com'),
      'contactName'  => $system->contact_name,
      'body'         => $this->collectionRouteList('api.v1.body.show', $system->bodies),

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