<?php namespace App\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Collection;
use League\Fractal\Manager;

use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;

abstract class SerializeCommand extends Command implements SelfHandling {
  /**
   * @var League\Fractal\Manager
   */
  protected $manager;

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct(\Illuminate\Http\Request $request)
  {
    $this->manager = new Manager;
    $this->manager->setSerializer(new DataArraySerializer());

    if ($request->has('include'))
      $this->manager->parseIncludes($request->input('include'));

    $this->manager->setRecursionLimit(2);
  }
}