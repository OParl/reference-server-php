<?php namespace App\Http\Controllers\API;

use EFrane\Transfugio\Http\APIController;

class BodyController extends APIController {
	protected $model = 'OParl\Body';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
