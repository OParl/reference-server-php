<?php namespace Oparl;

class System extends BaseModel {
  protected $primaryKey = null;
  public $incrementing  = false;

  protected $hidden  = ['created_at', 'updated_at'];
  protected $appends = ['oparl_version', 'vendor', 'product'];

	public function getOparlVersionAttribute()
  {
    return 'http://oparl.org/specs/1.0/';
  }

  public function bodies()
  {
    return $this->hasMany('OParl\Body', 'system_id', 'id');
  }

  public function getVendorAttribute()
  {
    return 'http://oparl.org/';
  }

  public function getProductAttribute()
  {
    return 'http://oparl.org/implementations/php-reference-server';
  }
}
