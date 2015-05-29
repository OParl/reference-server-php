<?php namespace App\Http\Controllers\API;

use App\Services\APIQueryService\APIQueryService;
use App\Services\APIQueryService\ValueExpression;

class ConsultationController extends APIController {
	protected $model = 'OParl\Consultation';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;

  /**
   * Resolve Body queries
   *
   * @param APIQueryService $query
   * @param ValueExpression $valueExpression
   **/
  public function queryBody(APIQueryService $query, ValueExpression $valueExpression)
  {
    // technically, consultations are linked to organizations, so that should be a way
    // to access body_id-s
  }
}
