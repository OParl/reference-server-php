<?php namespace App\Http\Controllers\API;

class LocationController extends APIController {
	protected $model = 'OParl\Location';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;
}
