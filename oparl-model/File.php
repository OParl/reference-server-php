<?php namespace OParl;

use Illuminate\Database\Eloquent\Model;

class File extends Model {
  protected $dates = ['date', 'file_modified'];

  public function masterFile()
  {
    return $this->hasOne('OParl\File', 'master_file_id', 'id');
  }

  public function derivatives()
  {
    return $this->belongsToMany('OParl\File', 'files_derivatives', 'file_id', 'derivative_id');
  }
}
