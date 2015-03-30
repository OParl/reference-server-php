<?php namespace App\Commands;

use PicoFeed\Syndication\Atom;

use OParl\System;

class CreateAtomFeedCommand extends CreateFeedCommand
{
  public function handle()
  {
    $writer = new Atom();
    $writer->title = $this->feedTitle();
    $writer->site_url = url('/');
    $writer->feed_url = route('feed.show', [$this->type, 'atom']);

    $system = System::first();

    $writer->author = [
      'name'  => $system->contact_name,
      'email' => $system->contact_email,
    ];

    $writer->items = $this->objects->map(function($change) {
      $className = class_basename($change->model);

      return [
        'title'   => sprintf('%s: %s[%d]', ucwords($change->action), $className, $change->model_id),
        'url'     => route(sprintf('api.v1.%s.show', strtolower($className)), $change->model_id),
        'updated' => $change->created_at->timestamp
      ];
    });

    return $writer->execute();
  }
}