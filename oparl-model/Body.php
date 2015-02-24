<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class Body extends Model {

	//
  public function system()
  {
    $this->hasOne('OParl\System');
  }

  
}
