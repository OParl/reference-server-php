<?php namespace App\Http\Controllers\API;

use EFrane\Transfugio\Http\APIController;

class OrganizationController extends APIController {
	protected $model = 'OParl\Organization';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
