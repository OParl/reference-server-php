<?php namespace OParl;

use Illuminate\Database\Eloquent\Model;

class File extends Model {
	public function accessURLAttribute()
  {
    return "";
  }

  public function downloadURLAttribute()
  {
    return "";
  }
}
