<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class System extends Model {
  protected $primaryKey = null;
  public $incrementing  = false;

  protected $hidden  = ['created_at', 'updated_at'];
  protected $appends = ['oparl_version', 'vendor', 'product'];

	public function getOparlVersionAttribute()
  {
    return 'http://oparl.org/specs/1.0/';
  }

  public function body()
  {
    return $this->hasMany('OParl\Body');
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
