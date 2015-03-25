<?php namespace App\Http\Controllers\API;

class BodyController extends APIController {
	protected $model = 'OParl\Body';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;
}
