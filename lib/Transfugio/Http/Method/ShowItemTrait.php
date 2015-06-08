<?php  namespace EFrane\Transfugio\Http\Method; 

use LogicException;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\Query\Builder;

/**
 * Show a model entity
 *
 * This show implementation queries the controller's model
 * for a specific entity. If no `resolveMethod` is specified,
 * it does so via the model's id property.
 *
 * @package EFrane\Transfugio\Http\Method
 **/
trait ShowItemTrait
{
  /**
   * @var string
   **/
  protected $resolveMethod = 'model:findOrFail';

  /**
   * @param $id
   * @return \Illuminate\Http\Response
   **/
  public function show($id)
  {
    try
    {
      $item = call_user_func($this->getResolveMethod(), $id);

      if ($item instanceof Builder)
        $item = $item->first();

      return $this->respondWithItem($item);
    } catch(ModelNotFoundException $e)
    {
      return $this->respondWithNotFound("The requested item in `{$this->getModelName()}` does not exist.");
    }
  }

  /**
   * Get the resolve method for the query.
   *
   * By default, entities are resolved by their id field. It is, however,
   * possible to choose a different resolving method for entities. You may
   * for instance have an API endpoint for stored git commits and it is obviously
   * not in anyway logical to return the id of that commit's database entry.
   * In that case, the following would resolve commits by their sha-hash:
   *
   * <code>
   *    class CommitsController extends APIController
   *    {
   *         use \Transfugio\Http\Method\IndexPaginatedTrait;
   *         use \Transfugio\Http\Method\ShowItemTrait;
   *
   *         protected $model = 'Git\Commit';
   *         protected $resolveMethod = 'model:whereSha1'; // or 'self:resolveShow'
   *
   *         protected function resolveShow($id)
   *         {
   *             return Git\Commit::whereSha1($id);
   *         }
   *    }
   * </code>
   *
   * The inclined observer may already have noticed the two core principles for
   * item resolving:
   *
   * 1) You can choose to either implement your own resolver method or to
   *    just use an Eloquent way of retrieving a model instance. This is
   *    signified by prefixing the method name with model (for Eloquent)
   *    or self.
   *
   * 2) It is not necessary to return an actual model instance, the system
   *    automatically checks for `\Illuminate\Database\Builder` instances and
   *    fetches a model from them by calling `first()`.
   *
   * @return array The resolve method callable
   **/
  protected function getResolveMethod()
  {
    if (is_array($this->resolveMethod))
    {
      $method = $this->resolveMethod;
    } else if (strpos($this->resolveMethod, 'model:') >= 0)
    {
      $method = [$this->model, substr($this->resolveMethod, strpos($this->resolveMethod, ':') + 1)];
    } else if (strpos($this->resolveMethod, 'self:') >= 0)
    {
      $method = [$this, substr($this->resolveMethod, strpos($this->resolveMethod, ':') + 1)];
    } else
    {
      throw new LogicException("Unable to determine entity resolve method.");
    }

    if (!method_exists($method[0], $method[1]))
      throw new LogicException("Resolve method does not exist");

    return $method;
  }
}
