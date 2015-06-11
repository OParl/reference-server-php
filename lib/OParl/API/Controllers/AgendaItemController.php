<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

use EFrane\Transfugio\Query\QueryService;
use EFrane\Transfugio\Query\ValueExpression;

/**
 * Request agenda items
 *
 * @package App\Http\Controllers\API
 **/
class AgendaItemController extends APIController {
  protected $model = 'OParl\Model\AgendaItem';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;

  protected function queryBody(QueryService &$query, ValueExpression $valueExpression)
  {
    $query
      ->join('meetings', 'meetings.id', '=', 'agenda_items.meeting_id')
      ->whereRaw(
        "organization_id = (select id from organizations where body_id {$valueExpression->getExpression()} ?)",
        [$valueExpression->getValue()]
      );
  }
}
