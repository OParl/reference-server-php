<?php namespace App\Commands;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;

use League\Fractal\Resource\Collection as FractalCollection;

use App\Handlers\Transformers\TransformerFactory;

/**
 * Class SerializeCollectionCommand
 * @package App\Commands
 */
class SerializeCollectionCommand extends SerializeCommand {

  /**
   * @var Illuminate\Support\Collection
   */
  protected $collection;

  public function __construct(Collection $collection, Request $request)
  {
    parent::__construct($request);
    $this->collection = $collection;
  }

  /**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
    $transformer = TransformerFactory::makeForCollection($this->collection);
    $resource    = new FractalCollection($this->collection, $transformer);

    return $this->manager->createData($resource)->toArray();
	}
}
