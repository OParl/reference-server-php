<?php namespace OParl;

use Illuminate\Database\Eloquent\Model;

class LegislativeTerm extends Model {

  public function getDates() {
    return ['created_at', 'updated_at', 'start_date', 'end_date'];
  }

	public function body()
  {
    return $this->belongsTo('OParl\Body');
  }

}
