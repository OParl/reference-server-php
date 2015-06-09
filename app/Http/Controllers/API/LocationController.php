<?php namespace App\Http\Controllers\API;

use EFrane\Transfugio\Http\APIController;

class LocationController extends APIController {
	protected $model = 'OParl\Location';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
