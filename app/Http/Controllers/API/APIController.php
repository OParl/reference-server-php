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
   * @var array
   **/
  protected $only = [];

  /**
   * @param Request $request
   */
  public function __construct(Request $request, Router $router)
  {
    // check for valid implementing class
    if (!is_string($this->model) || !class_exists($this->model))
      throw new \LogicException("API controllers require a valid \$model property.");

    $this->request = $request;
    $this->routes = $router->getRoutes();

    // check for only parameter to limit output
    if ($request->input('only'))
    {
      $only = explode(',', $request->input('only'));

      $validator = \Validator::make(
        ['only' => $only],
        ['only' => 'array|in:data,meta']
      );

      if (!$validator->failed())
        $this->only = array_flip(array_diff(['data', 'meta'], $only));
    }

    // set output format
    $this->format = config('api.format');

    // remove "underscore specifer part" from format
    if (strpos($this->format, '_') > 0)
      $this->format = substr($this->format, 0, strpos($this->format, '_'));
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

    $paginationCode = null;
    if (array_key_exists('pagination_code', $data))
    {
      $paginationCode = $data['pagination_code'];
      unset($data['pagination_code']);
    }

    if (count($this->only) > 0) $data = array_diff_key($data, $this->only);

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
            'paginationCode' => $paginationCode,
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
    {
      $paginator->appends(['format' => 'html']);
      $dataArray['pagination_code'] = $paginator->render();
    }

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