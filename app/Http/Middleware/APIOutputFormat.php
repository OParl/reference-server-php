<?php namespace App\Http\Middleware;

class APIOutputFormat 
{
  private function determineOutputFormat($request)
  {
    if ($request->wantsJson())
      return 'json_accept';

    if ($request->input('format') === 'json')
      return 'json';

    if ($request->input('format') === 'yaml')
      return 'yaml';

    if ($request->input('format') === 'xml')
      return 'xml';

    if ($request->input('format') === 'html')
      return 'html';

    return 'json_accept';
  }

  public function handle($request, \Closure $next)
  {
    config(['api.format' => $this->determineOutputFormat($request)]);

    return $next($request);
  }
}