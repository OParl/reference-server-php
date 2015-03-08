<?php namespace OParl;

use Illuminate\Database\Eloquent\Model;

class LegislativeTerm extends Model {

	public function body()
  {
    return $this->belongsTo('OParl\Body');
  }

}
