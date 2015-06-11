<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

class LegislativeTermController extends APIController {
  protected $model = 'OParl\Model\LegislativeTerm';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
