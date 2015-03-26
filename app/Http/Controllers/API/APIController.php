<?php namespace App\Http\Controllers\API;

use App\Commands\SerializeCollectionCommand;
use App\Commands\SerializePaginatedCommand;
use App\Commands\SerializeItemCommand;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Collection;
use Illuminate\View\Factory;

use Illuminate\Routing\Router;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class APIController
 * @package App\Http\Controllers\API
 */
class APIController extends Controller
{
  /**
   * @var Illuminate\Http\Request
   */
  protected $request;
  /**
   * @var Illuminate\Http\Response
   */
  protected $response;

  /**
   * @var int HTTP Status Code
   */
  protected $statusCode = 200;

  /**
   * @var Factory
   **/
  protected $viewFactory;

  /**
   * @var Illuminate\Database\Eloquent\Model
   **/
  protected $model;

  /**
   * @param Request $request
   */
  public function __construct(Request $request, Response $response,
                              Factory $viewFactory, Router $router)
  {
    $this->request = $request;
    $this->response = $response;
    $this->viewFactory = $viewFactory;
    $this->routes = $router->getRoutes();

    if (!is_string($this->model) || !class_exists($this->model))
      throw new \LogicException("API controllers require a valid \$model property.");
  }

  protected function getModelName()
  {
    return class_basename($this->model);
  }

  /**
   * @return array
   **/
  private function getViableRoutes()
  {
    if (!$this->routes) return [];

    $currentRoute = explode('.', \Route::currentRouteName());
    $currentRouteEndpoint = array_pop($currentRoute);

    $routeNameBase = implode('.', $currentRoute).'.';

    $viableRoutes = [
      'index',
      'store',
      'update',
      'destroy'
    ];

    unset($viableRoutes[$currentRouteEndpoint]);

    array_walk($viableRoutes, function (&$val, $key) use ($routeNameBase) {
      $val = [$val, $this->routes->getByName($routeNameBase.$val)];
    });

    return $viableRoutes;
  }

  /**
   * @param $data
   * @param array $headers
   * @return Illuminate\Http\Response
   */
  private function respond($data, array $headers = [])
  {
    if ($this->request->wantsJson()
    ||  $this->request->input('format') === 'json')
    {
      $headers['Content-type'] = 'application/json; charset=UTF-8';
      $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

      return $this->response->create($data, $this->statusCode, $headers);
    }

    $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    // gzip?!
    if (array_has($this->request->getAcceptableContentTypes(), 'gzip')
    ||  array_has($this->request->getAcceptableContentTypes(), 'compress'))
    {
      $headers['Content-encoding'] = 'gzip';
      $data = gzcompress($data);
    }

    $headers['Content-type'] = 'text/html; charset=UTF-8';

    $viewData = [
      'url'          => $this->request->url(),
      'content'      => $data,
      'module'       => $this->getModelName(),
      'isError'      => false,
      'viableRoutes' => $this->getViableRoutes()
    ];

    if ($this->statusCode != 200)
    {
      $viewData['isError'] = true;
    }

    $view = $this->viewFactory->make('api.base', $viewData);

    return $this->response->create($view, $this->statusCode, $headers);
  }

  private function respondEmpty()
  {
    // Technically, this is a tie between '200 OK' and '204 No Content'
    $this->statusCode = 200;
    return $this->respond([
      'info' => [
        'message' => "The requested result set for {$this->getModelName()} is empty.",
        'status' => $this->statusCode
      ]
    ]);
  }

  /**
   * @param string $message
   * @param int $code
   * @param array $headers
   * @return Illuminate\Http\Response
   **/
  private function respondWithError($message, $code = 400, $headers = [])
  {
    $this->statusCode = $code;

    $data = ['error' => ['message' => $message, 'status' => $code]];

    return $this->respond($data, $headers);
  }

  /**
   * @param string $message
   * @param array $headers
   * @return Illuminate\Http\Response
   **/
  protected function respondWithForbidden($message, $headers = [])
  {
    return $this->respondWithError($message, 403, $headers);
  }

  /**
   * @param string $message
   * @param array $headers
   * @return Illuminate\Http\Response
   **/
  protected function respondWithNotFound($message, $headers = [])
  {
    return $this->respondWithError($message, 404, $headers);
  }

  /**
   * @param string $message
   * @param array $headers
   * @return Illuminate\Http\Response
   **/
  protected function respondWithNotAllowed($message, $headers = [])
  {
    return $this->respondWithError($message, 405, $headers);
  }

  /**
   * @param LengthAwarePaginator $paginator
   * @return Illuminate\Http\Response
   **/
  protected function respondWithPaginated(LengthAwarePaginator $paginator)
  {
    if ($paginator->count() == 0)
      return $this->respondEmpty();

    $dataArray = $this->dispatch(new SerializePaginatedCommand($paginator, $this->request));

    return $this->respond($dataArray);
  }

  /**
   * @param Model $item
   * @return Illuminate\Http\Response
   */
  protected function respondWithItem(Model $item)
  {
    $dataArray = $this->dispatch(new SerializeItemCommand($item, $this->request));
    return $this->respond($dataArray);
  }
}