<?php namespace EFrane\Transfugio\Http;

class APIOutputFormatMiddleware
{
  private function determineOutputFormat($request)
  {
    if ($request->wantsJson())
      return 'json_accept';

    switch ($request->input('format'))
    {
      case 'json': return 'json';
      case 'xml':  return 'xml';
      case 'yaml': return 'yaml';
      case 'html': return 'html';

      default: return 'json_accept';
    }
  }

  public function handle($request, \Closure $next)
  {
    config(['transfugio.http.format' => $this->determineOutputFormat($request)]);

    return $next($request);
  }
}