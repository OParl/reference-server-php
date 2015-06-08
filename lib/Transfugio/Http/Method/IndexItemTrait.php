<?php namespace EFrane\Transfugio\Http\Method;

use LogicException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Provide a controller index that returns a constant entity
 *
 * The `IndexItemTrait` provides an index function that always
 * returns the same entity from the configured model.
 *
 * This is - among other cases - useful for api entry points that
 * always return the same entity. In combination with Transformers,
 * it is possible to not query the database at all. To achieve this,
 * the `$item_id` property must be set to 0. This will disable the
 * entity lookup as well as the check for an existing model class
 * in `APIController`. However, `$model` should still be set as it
 * is used to dynamically acquire a Transformer.
 *
 * Example Controller:
 *
 * <code>
 *     class EntryPointController extends APIController {
 *         use \Transfugio\Http\Method\IndexItemTrait;
 *
 *         protected $model = 'App\EntryPoint';
 *         protected $item_id = 0;
 *     }
 * </code>
 *
 * Leading to required Transformer:
 *
 * <code>
 *     class EntryPointTransformer extends BaseTransformer {
 *         public function transform() {
 *             return ['version' => '1.0'];
 *         }
 *     }
 * </code>
 *
 * More information on Transformer resolving can be found in `Http\APIController`
 * and `Transformers\TransformerFactory`.
 *
 * @package EFrane\Transfugio\Http\Method
 * @see Transformers\TransfomerFactory
 **/
trait IndexItemTrait
{
  /**
   * @return \Illuminate\Http\Response
   **/
  public function index()
  {
    if (!property_exists($this, 'item_id'))
    {
      throw new LogicException("Item indexes require an \$item_id id property for their \$model.");
    }

    try
    {
      $item = call_user_func([$this->model, 'findOrFail'], $this->item_id);
      return $this->respondWithModel($item);
    } catch (ModelNotFoundException $e)
    {
      throw new LogicException("The provided \$item_id '{$this->item_id}' does not exist.");
    }
  }
}