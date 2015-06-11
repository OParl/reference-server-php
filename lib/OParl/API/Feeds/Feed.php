<?php namespace OParl\API\Feeds;

use OParl\Model\Transaction;

/**
 * Feed
 *
 * Dead simple abstraction for transaction feeds.
 * Uses the picofeed library for actual feed generation.
 *
 * @package OParl\API\Feeds
 **/
abstract class Feed
{
  /**
   * @var \Illuminate\Support\Collection transaction objects
   **/
  protected $objects;

  /**
   * @var string Feed format
   **/
  protected $format;

  /**
   * @var string Feed type (one of: new, updated or removed)
   **/
  protected $type;

  /**
   * Set feed type and format and retrieve the corresponding
   * transaction objects.
   *
   * @param $type feed type
   * @param $format feed format
   */
  public function __construct($type, $format)
  {
    $this->format  = $format;
    $this->type    = $type;

    $this->objects = Transaction::whereAction($this->type)
      ->orderBy('created_at', 'desc')
      ->take(config('oparl.feedElements'))
      ->get();
  }

  /**
   * Generic feed title.
   *
   * @return string
   **/
  protected function feedTitle()
  {
    return sprintf('%s Objects', ucwords($this->type));
  }

  /**
   * Makes a feed.
   *
   * @return string the feed
   **/
  abstract public function make();
}