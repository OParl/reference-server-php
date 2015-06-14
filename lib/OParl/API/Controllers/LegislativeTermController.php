<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

/**
 * Request Legislative Terms
 * 
 * @package OParl\API\Controllers
 */
class LegislativeTermController extends APIController {
  protected $model = 'OParl\Model\LegislativeTerm';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
