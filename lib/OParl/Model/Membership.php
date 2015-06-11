<?php namespace OParl\Model;

class Membership extends BaseModel {

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function person()
  {
    return $this->belongsTo('OParl\Model\Person');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function organization()
  {
    return $this->belongsTo('OParl\Model\Organization');
  }

}
