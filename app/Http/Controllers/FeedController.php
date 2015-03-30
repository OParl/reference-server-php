<?php namespace App\Http\Controllers;

use PicoFeed\Syndication\Rss20;


class FeedController extends Controller
{
  public function show($type, $format)
  {
    $command = sprintf('App\Commands\Create%sFeedCommand', ($format === 'atom') ? 'Atom' : 'Rss');

    $feed = $this->dispatch(new $command($type, $format));
    $mimeType = sprintf('application/%s+xml', $format);

    return response()->make($feed, 200, ['Content-type' => $mimeType]);
  }
}