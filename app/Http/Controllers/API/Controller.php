<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as BaseController;

use Illuminate\Http\Request;

class Controller extends BaseController
{
  protected $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }
}