<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

/**
 * Request the System Entity
 *
 * @package OParl\API\Controllers
 */
class SystemController extends APIController {
  protected $model = 'OParl\Model\System';
  protected $item_id = 'Testsystem';

  use \EFrane\Transfugio\Http\Method\IndexItemTrait;
}
