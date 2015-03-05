<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class Body extends Model {

	//
  public function system()
  {
    return $this->belongsTo('OParl\System', 'pk');
  }

  
}
