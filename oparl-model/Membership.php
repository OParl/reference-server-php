<?php namespace Oparl;

class Membership extends BaseModel {

	public function person()
  {
    return $this->belongsTo('OParl\Person');
  }

  public function organization()
  {
    return $this->belongsTo('OParl\Organization');
  }

}
