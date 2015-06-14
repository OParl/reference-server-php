<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

/**
 * Request Locations
 *
 * @package OParl\API\Controllers
 */
class LocationController extends APIController {
	protected $model = 'OParl\Model\Location';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
