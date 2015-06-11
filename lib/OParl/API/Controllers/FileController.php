<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

class FileController extends APIController {
	protected $model = 'OParl\Model\File';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
