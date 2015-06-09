<?php namespace App\Http\Controllers\API;

use EFrane\Transfugio\Http\APIController;

class FileController extends APIController {
	protected $model = 'OParl\File';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
