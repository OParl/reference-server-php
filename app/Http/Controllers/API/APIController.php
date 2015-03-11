<?php namespace App\Http\Controllers\API;

use OParl\System;

class APIController extends Controller
{
  public function getIndex()
  {
    $data = System::find(1)->toArray();
    return $this->respond($data);
  }
}
