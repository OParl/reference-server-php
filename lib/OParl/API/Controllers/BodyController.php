<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

/**
 * Request Bodies
 *
 * @package OParl\API\Controllers
 **/
class BodyController extends APIController {
	protected $model = 'OParl\Model\Body';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
