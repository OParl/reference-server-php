<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class System extends Model {

	public function oparlVersionAttribute()
  {
    return 'http://oparl.org/specs/1.0/';
  }

  public function websiteAttribute()
  {
    if ($this->attributes['website'][strlen($this->attributes['website']) - 1] !== '/')
    {
      $this->attributes['website'] .= '/';
      $this->save();
    }

    return $this->attributes['website'];
  }

  public function bodyAttribute()
  {
    return $this->website . 'body/';
  }

  public function newObjectsAttribute()
  {
    return $this->website . 'new_objects/';
  }

  public function updatedObjectsAttribute()
  {
    return $this->website . 'updated_objects/';
  }

  public function removedObjectsAttribute()
  {
    return $this->website . 'removed_objects/';
  }

  public function vendorAttribute()
  {
    return 'http://oparl.org/';
  }

  public function productAttribute()
  {
    return 'http://oparl.org/implementations/php-reference-server';
  }
}
