<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

class OrganizationController extends APIController {
	protected $model = 'OParl\Model\Organization';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
