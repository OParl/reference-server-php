<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

class PersonController extends APIController {
  protected $model = 'OParl\Model\Person';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}