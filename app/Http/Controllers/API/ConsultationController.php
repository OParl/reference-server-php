<?php namespace App\Http\Controllers\API;

class ConsultationController extends APIController {
	protected $model = 'OParl\Consultation';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;
}
