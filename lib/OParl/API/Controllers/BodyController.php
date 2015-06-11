<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

class BodyController extends APIController {
	protected $model = 'OParl\Model\Body';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
