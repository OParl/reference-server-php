<?php namespace App\Http\Controllers\API;

use OParl\System;

class SystemController extends APIController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->respondWithItem(System::first());
	}
}
