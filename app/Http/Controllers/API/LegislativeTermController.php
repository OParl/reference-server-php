<?php namespace App\Http\Controllers\API;

use EFrane\Transfugio\Http\APIController;

class LegislativeTermController extends APIController {
  protected $model = 'OParl\LegislativeTerm';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
