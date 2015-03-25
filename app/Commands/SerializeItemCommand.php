<?php namespace App\Commands;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use League\Fractal\Resource\Item;

use App\Handlers\Transformers\TransformerFactory;

/**
 * Class SerializeItemCommand
 * @package App\Commands
 */
class SerializeItemCommand extends SerializeCommand  {
  /**
   * @var Model
   */
  protected $item;

  /**
   * @param Model $item
   */
  public function __construct(Model $item, Request $request)
  {
    parent::__construct($request);

    $this->item = $item;
  }

  /**
   * @return array
   */
  public function handle()
  {
    $transformer = TransformerFactory::makeForModel($this->item);
    $resource    = new Item($this->item, $transformer);

    return $this->manager->createData($resource)->toArray();
  }
}