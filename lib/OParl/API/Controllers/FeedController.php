<?php namespace OParl\API\Controllers;

use Illuminate\Routing\Controller;

class FeedController extends Controller
{
  public function show($type, $format)
  {
    $feedMaker = sprintf('OParl\API\Feeds\%sFeed', ($format === 'atom') ? 'Atom' : 'RSS');

    $feed = (new $feedMaker($type, $format))->make();
    $mimeType = sprintf('application/%s+xml', $format);

    return response()->make($feed, 200, ['Content-type' => $mimeType]);
  }
}