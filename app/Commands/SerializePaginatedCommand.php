<?php namespace App\Commands;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

use App\Handlers\Transformers\TransformerFactory;

class SerializePaginatedCommand extends SerializeCommand
{
  protected $paginator;

  public function __construct(LengthAwarePaginator $paginator, Request $request)
  {
    parent::__construct($request);
    $this->paginator = $paginator;
  }

  public function handle()
  {
    $collection = $this->paginator->getCollection();

    $transformer = TransformerFactory::makeForCollection($collection);

    $resource = new FractalCollection($collection, $transformer);
    $resource->setPaginator(new IlluminatePaginatorAdapter($this->paginator));

    return $this->manager->createData($resource)->toArray();
  }
}