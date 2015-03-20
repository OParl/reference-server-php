<?php namespace App\Http\Controllers\API;

use OParl\System;

class APIController extends Controller
{
  public function getIndex()
  {
    $data = System::all()[0]->toArray();
    return $this->respond($data);
  }
}
