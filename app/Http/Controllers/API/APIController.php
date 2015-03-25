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

  protected $viewFactory;

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
  }

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
      $headers['Content-type'] = 'application/json';

      return $this->response->create($data, $this->statusCode, $headers);
    }

    $data = json_encode($data, JSON_PRETTY_PRINT);
    $data = str_replace('\/', '/', $data);

    // FIXME: This is not how this should be...
    $module = explode('_', snake_case(class_basename(get_called_class())));
    array_pop($module);
    $module = implode('', $module);

    // gzip?!
    if (array_has($this->request->getAcceptableContentTypes(), 'gzip')
    ||  array_has($this->request->getAcceptableContentTypes(), 'compress'))
    {
      $headers['Content-encoding'] = 'gzip';
      $data = gzcompress($data);
    }

    $viewData = [
      'content'      => $data,
      'module'       => $module,
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

  private function respondWithError($message, $code = 400, $headers = [])
  {
    $this->statusCode = $code;

    $data = ['error' => ['message' => $message, 'status' => $code]];

    return $this->respond($data, $headers);
  }

  protected function respondWithNotFound($message, $headers = [])
  {
    return $this->respondWithError($message, 404, $headers);
  }

  /**
   * @param Collection $collection
   * @return mixed
   */
  protected function respondWithCollection(Collection $collection)
  {
    $dataArray = $this->dispatch(new SerializeCollectionCommand($collection, $this->request));
    return $this->respond($dataArray);
  }

  protected function respondWithPaginated(LengthAwarePaginator $paginator)
  {
    $dataArray = $this->dispatch(new SerializePaginatedCommand($paginator, $this->request));
    return $this->respond($dataArray);
  }

  /**
   * @param Model $item
   * @return mixed
   */
  protected function respondWithItem(Model $item)
  {
    $dataArray = $this->dispatch(new SerializeItemCommand($item, $this->request));
    return $this->respond($dataArray);
  }
}