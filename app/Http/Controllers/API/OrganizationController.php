<?php namespace App\Http\Controllers\API;

class OrganizationController extends APIController {
	protected $model = 'OParl\Organization';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;
}
