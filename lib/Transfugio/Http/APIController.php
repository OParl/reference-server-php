<?php namespace EFrane\Transfugio\Http;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class APIController
 * @package App\Http\Controllers\API
 */
class APIController extends Controller
{
  /**
   * @var \Illuminate\Http\Request
   */
  protected $request = null;

  /**
   * @var \Illuminate\Database\Eloquent\Model
   **/
  protected $model = null;

  /**
   * @var string output format
   **/
  protected $format = '';

  /**
   * @var array
   **/
  protected $only = [];

  /**
   * @param Request $request
   */
  public function __construct(Request $request)
  {
    // check for valid implementing class
    if (!is_string($this->model))
    {
      throw new \LogicException("API controllers must have a valid \$model property.");
    }

    if (((property_exists($this, 'item_id') && $this->item_id !== 0)
    ||  !property_exists($this, 'item_id')) && !class_exists($this->model))
    {
      throw new \LogicException("The requested model {$this->model} is invalid.");
    }

    $this->request = $request;

    // check for only parameter to limit output
    if ($request->input('only'))
    {
      $only = explode(',', $request->input('only'));

      $validator = app('validator')->make(
        ['only' => $only],
        ['only' => 'array|in:data,meta']
      );

      if ($validator->failed())
      {
        $this->respondWithError("Invalid value for `only`.");
      } else
      {
        $this->only = array_flip(array_diff(['data', 'meta'], $only));
      }
    }

    // set output format
    $this->format = config('transfugio.http.format');
  }

  /**
   * @return string
   **/
  protected function getModelName()
  {
    return class_basename($this->model);
  }

  public function __call($method, $parameters)
  {
    if (starts_with($method, 'respond'))
    {
      $responseBuilder = new ResponseBuilder($this->format, [
        'only' => $this->only,
      ]);

      return call_user_func_array([$responseBuilder, $method], $parameters);
    }

    return parent::__call($method, $parameters);
  }

//  /**
//   * @param $data
//   * @param array $headers
//   * @return \Illuminate\Http\Response
//   */
//  private function respond($data, array $headers = [])
//  {
//    // extract pagination code
//    $paginationCode = null;
//    if (array_key_exists('pagination_code', $data))
//    {
//      $paginationCode = $data['pagination_code'];
//      unset($data['pagination_code']);
//    }
//
//
//    $response = null;
//    switch ($this->format)
//    {
//      case 'json':
//      case 'yaml':
////      case 'xml':
//        $command = sprintf('App\Commands\Create%sAPIResponseCommand', strtoupper($this->format));
//        $response = $this->dispatch(new $command($data, $this->statusCode, $headers));
//        break;
//
//      case 'html':
//      default:
//        $response = $this->dispatch(new CreateWebviewAPIResponseCommand(
//          $data,
//          $this->statusCode,
//          $headers,
//          [
//            'modelName'      => $this->getModelName(),
//            'paginationCode' => $paginationCode,
//            'url'            => $this->request->url()
//          ]
//        ));
//    }
//
//    return $response;
//  }
//
//  /**
//   * @param string $message
//   * @param int $code
//   * @param array $headers
//   * @return Illuminate\Http\Response
//   **/
//  private function respondWithError($message, $code = 400, $headers = [])
//  {
//    $this->statusCode = $code;
//
//    $data = ['error' => ['message' => $message, 'status' => $code]];
//
//    return $this->respond($data, $headers);
//  }
//
//  /**
//   * @param string $message
//   * @param array $headers
//   * @return Illuminate\Http\Response
//   **/
//  protected function respondWithForbidden($message, $headers = [])
//  {
//    return $this->respondWithError($message, 403, $headers);
//  }
//
//  /**
//   * @param string $message
//   * @param array $headers
//   * @return Illuminate\Http\Response
//   **/
//  protected function respondWithNotFound($message, $headers = [])
//  {
//    return $this->respondWithError($message, 404, $headers);
//  }
//
//  /**
//   * @param string $message
//   * @param array $headers
//   * @return Illuminate\Http\Response
//   **/
//  protected function respondWithNotAllowed($message, $headers = [])
//  {
//    return $this->respondWithError($message, 405, $headers);
//  }
//
//  /**
//   * @param LengthAwarePaginator $paginator
//   * @return Illuminate\Http\Response
//   **/
//  protected function respondWithPaginated(LengthAwarePaginator $paginator)
//  {
//    if ($paginator->count() == 0)
//      return $this->respondEmpty();
//
//    $dataArray = $this->dispatch(new SerializePaginatedCommand($paginator, $this->request));
//
//    // TODO: WebView!
//    if ($this->format === 'html')
//    {
//      $paginator->appends(['format' => 'html']);
//      $dataArray['pagination_code'] = $paginator->render();
//    }
//
//    return $this->respond($dataArray);
//  }
//
//  /**
//   * @param Model $item
//   * @return Illuminate\Http\Response
//   */
//  protected function respondWithItem(Model $item)
//  {
//    $dataArray = $this->dispatch(new SerializeItemCommand($item, $this->request));
//    return $this->respond($dataArray);
//  }
}