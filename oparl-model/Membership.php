<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model {

	public function person()
  {
    return $this->belongsTo('OParl\Person');
  }

  public function organization()
  {
    return $this->belongsTo('OParl\Organization');
  }

}
