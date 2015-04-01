<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class System extends Model {
  protected $primaryKey = null;
  public $incrementing  = false;

  protected $hidden  = ['created_at', 'updated_at'];

  public function bodies()
  {
    return $this->hasMany('OParl\Body', 'system_id', 'id');
  }
}
