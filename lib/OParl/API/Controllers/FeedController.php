<?php namespace OParl\API\Controllers;

use Illuminate\Routing\Controller;

/**
 * Generate Feeds
 *
 * Feed formats are RSS 2.0 and Atom 1.0
 *
 * Provided feeds:
 *
 * - new objects
 * - updated objects
 * - deleted objects
 *
 * @package OParl\API\Controllers
 **/
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