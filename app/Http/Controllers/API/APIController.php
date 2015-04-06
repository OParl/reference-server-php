<?php namespace App\Http\Controllers\API;

use App\Commands\CreateWebviewAPIResponseCommand;
use App\Commands\SerializePaginatedCommand;
use App\Commands\SerializeItemCommand;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
   * @var int HTTP Status Code
   */
  protected $statusCode = 200;

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
  public function __construct(Request $request, Router $router)
  {
    $this->request = $request;
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

    $response = null;
    switch ($this->format)
    {
      case 'json':
      case 'yaml':
      case 'xml':
        $command = sprintf('App\Commands\Create%sAPIResponseCommand', strtoupper($this->format));
        $response = $this->dispatch(new $command($data, $this->statusCode, $headers));
        break;

      case 'html':
      default:
        $response = $this->dispatch(new CreateWebviewAPIResponseCommand(
          $data,
          $this->statusCode,
          $headers,
          [
            'modelName'      => $this->getModelName(),
            'paginationCode' => $pagination_code,
            'url'            => $this->request->url()
          ]
        ));
    }

    return $response;
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