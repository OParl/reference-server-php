<?php namespace App\Http\Controllers\API;

use EFrane\Transfugio\Http\APIController;
use EFrane\Transfugio\Http\Method\IndexItemTrait;

class SystemController extends APIController {
  protected $model = 'OParl\System';
  protected $item_id = 'Testsystem';

  use IndexItemTrait;
}
