<?php namespace App\Http\Controllers\API;

class AgendaItemController extends APIController {
  protected $model = 'OParl\AgendaItem';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;
}
