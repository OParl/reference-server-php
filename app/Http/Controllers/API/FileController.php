<?php namespace App\Http\Controllers\API;

class FileController extends APIController {
	protected $model = 'OParl\File';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;
}
