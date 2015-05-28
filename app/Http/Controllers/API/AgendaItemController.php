<?php namespace App\Http\Controllers\API;

use App\Services\APIQueryService\APIQueryService;
use App\Services\APIQueryService\ValueExpression;

/**
 * Request agenda items
 *
 * @package App\Http\Controllers\API
 **/
class AgendaItemController extends APIController {
  protected $model = 'OParl\AgendaItem';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;

  protected function queryBody(APIQueryService &$query, ValueExpression $valueExpression)
  {
    $query
      ->join('meetings', 'meetings.id', '=', 'agenda_items.meeting_id')
      ->whereRaw(
        "organization_id = (select id from organizations where body_id {$valueExpression->getExpression()} ?)",
        [$valueExpression->getValue()]
      );
  }
}
