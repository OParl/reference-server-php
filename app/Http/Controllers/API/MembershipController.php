<?php namespace App\Http\Controllers\API;

use App\Services\APIQueryService\APIQueryService;
use App\Services\APIQueryService\ValueExpression;

class MembershipController extends APIController {
	protected $model = 'OParl\Membership';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;

  protected function queryBody(APIQueryService &$query, ValueExpression $valueExpression)
  {
    $where = "(select count(*) from people where body_id {$valueExpression->getExpression()} ? and id = memberships.person_id)";

    $query->whereRaw($where, [$valueExpression->getValue()]);
  }
}
