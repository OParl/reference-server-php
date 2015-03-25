<?php namespace App\Http\Controllers\API;

class LegislativeTermController extends APIController {
  protected $model = 'OParl\LegislativeTerm';

	use APIIndexPaginatedTrait;
  use APIShowItemTrait;
}
