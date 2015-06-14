<?php namespace OParl\API\Controllers;

use EFrane\Transfugio\Http\APIController;

/**
 * Request Papers
 *
 * @package OParl\API\Controllers
 */
class PaperController extends APIController {
	protected $model = 'OParl\Model\Paper';

  use \EFrane\Transfugio\Http\Method\IndexPaginatedTrait;
  use \EFrane\Transfugio\Http\Method\ShowItemTrait;
}
