<?php namespace App\Http\Controllers\API;

use EFrane\Transfugio\Http\APIController;

class PaperController extends APIController {
	protected $model = 'OParl\Paper';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
