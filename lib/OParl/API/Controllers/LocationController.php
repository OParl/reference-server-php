<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

class LocationController extends APIController {
	protected $model = 'OParl\Model\Location';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
