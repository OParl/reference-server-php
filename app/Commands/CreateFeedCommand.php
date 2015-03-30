<?php namespace App\Commands;

use Illuminate\Contracts\Bus\SelfHandling;

use OParl\Transaction;

abstract class CreateFeedCommand extends Command implements SelfHandling
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
}