<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class System extends Model {
  protected $primaryKey = 'pk';

  protected $hidden = ['pk', 'created_at', 'updated_at'];
  protected $appends = ['oparl_version', 'new_objects', 'removed_objects', 'website'];

	public function getOparlVersionAttribute()
  {
    return 'http://oparl.org/specs/1.0/';
  }

  public function getWebsiteAttribute()
  {
    return \URL::to('/api/v1/')."/";
  }

  public function body()
  {
    return $this->hasMany('OParl\Body');
  }

  // TODO: fix urls (maybe add these in the transformer)
  public function getNewObjectsAttribute()
  {
    return $this->website . 'new_objects/';
  }

  public function getUpdatedObjectsAttribute()
  {
    return $this->website . 'updated_objects/';
  }

  public function getRemovedObjectsAttribute()
  {
    return $this->website . 'removed_objects/';
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
