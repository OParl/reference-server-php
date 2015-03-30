<?php namespace OParl;

class LegislativeTerm extends BaseModel {

  public function getDates() {
    return ['created_at', 'updated_at', 'start_date', 'end_date'];
  }

	public function body()
  {
    return $this->belongsTo('OParl\Body');
  }

}
