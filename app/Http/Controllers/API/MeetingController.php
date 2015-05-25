<?php namespace App\Http\Controllers\API;

use App\Services\APIQueryService\APIQueryService;
use App\Services\APIQueryService\ValueExpression;

class MeetingController extends APIController {
	protected $model = 'OParl\Meeting';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;

  protected function queryBody(APIQueryService &$query, ValueExpression $valueExpression)
  {
    $query->whereRaw(
      \DB::raw("organization_id = (select id from organizations where body_id {$valueExpression->getExpression()} ?)"),
      [$valueExpression->getValue()]
    );
  }
}
