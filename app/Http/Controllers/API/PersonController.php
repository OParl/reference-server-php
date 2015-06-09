<?php namespace App\Http\Controllers\API;

use EFrane\Transfugio\Http\APIController;

class PersonController extends APIController {
  protected $model = 'OParl\Person';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}