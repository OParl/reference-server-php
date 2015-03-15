<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\View;

/**
 * Class Controller
 * @package App\Http\Controllers\API
 */
class Controller extends BaseController
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
   * @param Request $request
   */
  public function __construct(Request $request, Response $response)
  {
    $this->request = $request;
    $this->response = $response;
  }

  /**
   * @param int $statusCode
   */
  protected function setStatusCode($statusCode)
  {
    $this->statusCode = $statusCode;
    return $this;
  }

  /**
   * @param $data
   * @param array $headers
   * @return mixed
   */
  protected function respond($data, array $headers = [])
  {
    if ($this->request->wantsJson()
    ||  $this->request->input('format') === 'json')
    {
      return Response::json($data, $this->statusCode, $headers);
    } else
    {
      $data = json_encode($data, JSON_PRETTY_PRINT);
      $data = str_replace('\/', '/', $data);

      // gzip?!
      if (array_has($this->request->getAcceptableContentTypes(), 'gzip')
      ||  array_has($this->request->getAcceptableContentTypes(), 'compress'))
      {
        $headers['Content-encoding'] = 'gzip';
        $data = gzcompress($data);
      }

      $view = View::make('api.base', ['content' => $data]);

      return $this->response->create($view, $this->statusCode, $headers);
    }
  }
}