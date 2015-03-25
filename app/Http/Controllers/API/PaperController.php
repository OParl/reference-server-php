<?php namespace App\Http\Controllers\API;

class PaperController extends APIController {
	protected $model = 'OParl\Paper';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;
}
