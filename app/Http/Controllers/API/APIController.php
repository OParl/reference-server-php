<?php namespace App\Http\Controllers\API;

use App\Commands\SerializePaginatedCommand;
use App\Commands\SerializeItemCommand;
use App\Http\Controllers\Controller;
use App\Services\XMLFormatter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\View\Factory;

use Illuminate\Routing\Router;

use Illuminate\Pagination\LengthAwarePaginator;

use Symfony\Component\Yaml\Yaml;

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
   * @var string output format
   **/
  protected $format = 'html';

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



    $this->format = $this->determineOutputFormat();
  }

  private function determineOutputFormat()
  {
    if ($this->request->wantsJson()
      ||  $this->request->input('format') === 'json')
      return 'json';

    if ($this->request->input('format') === 'yaml')
      return 'yaml';

    if ($this->request->input('format') === 'xml')
      return 'xml';

    return 'html';
  }

  /**
   * @return string
   **/
  protected function getModelName()
  {
    return class_basename($this->model);
  }

  /**
   * @param $data
   * @param array $headers
   * @return Illuminate\Http\Response
   */
  private function respond($data, array $headers = [])
  {
    // enable CORS
    $headers['Access-Control-Allow-Origin'] = '*';

    $pagination_code = null;
    if (array_key_exists('pagination_code', $data))
    {
      $pagination_code = $data['pagination_code'];
      unset($data['pagination_code']);
    }

    if ($this->format === 'json')
    {
      $headers['Content-type'] = 'application/json; charset=UTF-8';
      $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

      return $this->response->create($data, $this->statusCode, $headers);
    }

    if ($this->format === 'yaml')
    {
      $headers['Content-type'] = 'text/yaml; charset=UTF-8';
      $data = Yaml::dump($data);

      return $this->response->create($data, $this->statusCode, $headers);
    }

    if ($this->format === 'xml')
    {
      try
      {
        $data = XMLFormatter::format($data);
      } catch (\ErrorException $e)
      {
        $data = $this->viewFactory->make('api.xml_error');
      }

      $headers['Content-type'] = 'text/xml; charset=UTF-8';

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
      'url'            => $this->request->url(),
      'json'           => $data,
      'module'         => $this->getModelName(),
      'isError'        => false,
      'paginationCode' => $pagination_code,
    ];

    if ($this->statusCode != 200)
    {
      $viewData['isError'] = true;
    }

    $view = $this->viewFactory->make('api.base', $viewData);

    return $this->response->create($view, $this->statusCode, $headers);
  }

  /**
   * @return Illuminate\Http\Response
   **/
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

    if ($this->format === 'html')
      $dataArray['pagination_code'] = $paginator->render();

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