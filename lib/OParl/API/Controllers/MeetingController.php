<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

use EFrane\Transfugio\Query\QueryService;
use EFrane\Transfugio\Query\ValueExpression;

/**
 * Request Meetings
 *
 * @package OParl\API\Controllers
 */
class MeetingController extends APIController {
	protected $model = 'OParl\Model\Meeting';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;

  protected function queryBody(QueryService &$query, ValueExpression $valueExpression)
  {
    $query->whereRaw(
      \DB::raw("organization_id = (select id from organizations where body_id {$valueExpression->getExpression()} ? limit 1)"),
      [$valueExpression->getValue()]
    );
  }
}
