<?php namespace App\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use League\Fractal\Manager;

use League\Fractal\Serializer\DataArraySerializer;
use App\Handlers\Commands\APISerializer;

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
    $this->manager->setSerializer(new APISerializer());

    if ($request->has('include'))
      $this->manager->parseIncludes($request->input('include'));

    $this->manager->setRecursionLimit(2);
  }
}