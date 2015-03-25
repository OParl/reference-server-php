<?php namespace App\Http\Controllers\API;

class PersonController extends APIController {
  protected $model = 'OParl\Person';

  use APIIndexPaginatedTrait;
  use APIShowItemTrait;
}