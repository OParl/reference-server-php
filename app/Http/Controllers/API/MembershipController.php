<?php namespace App\Http\Controllers\API;

class MembershipController extends APIController {
	protected $model = 'OParl\Membership';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;
}
