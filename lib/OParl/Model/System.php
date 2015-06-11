<?php namespace OParl\Model;

use Illuminate\Database\Eloquent\Model;

class System extends Model {
  protected $primaryKey = 'id';
  public $incrementing  = false;

  protected $hidden  = ['created_at', 'updated_at'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   **/
  public function bodies()
  {
    return $this->hasMany('OParl\Model\Body', 'system_id', 'id');
  }
}
