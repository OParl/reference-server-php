<?php namespace App\Http\Controllers\API;

class MeetingController extends APIController {
	protected $model = 'OParl\Meeting';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;
}
