<?php namespace OParl\API\Feeds;

use OParl\Model\Transaction;

abstract class Feed
{
  protected $objects;
  protected $format;
  protected $type;

  public function __construct($type, $format)
  {
    $this->format  = $format;
    $this->type    = $type;

    $this->objects = Transaction::whereAction($this->type)
      ->orderBy('created_at', 'desc')
      ->take(config('oparl.feedElements'))
      ->get();
  }

  protected function feedTitle()
  {
    return sprintf('%s Objects', ucwords($this->type));
  }

  abstract public function make();
}