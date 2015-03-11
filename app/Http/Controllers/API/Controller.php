<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\Input;
use \Response;

use Illuminate\Http\Request;

class Controller extends BaseController
{
  protected $request;

  protected $statusCode = 200;

  /**
   * @param Request $request
   */
  public function __construct(Request $request)
  {
    $this->request = $request;
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

      // gzip?!
      if (array_has($this->request->getAcceptableContentTypes(), 'gzip')
      ||  array_has($this->request->getAcceptableContentTypes(), 'compress'))
      {
        $headers['Content-encoding'] = 'gzip';
        $data = gzcompress($data);
      }

      $view = \View::make('api.base', ['content' => $data]);

      return Response::make($view, $this->statusCode, $headers);
    }
  }
}