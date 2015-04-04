<?php namespace OParl;

class File extends BaseModel {
  protected $dates = ['file_created', 'file_modified'];

  public function masterFile()
  {
    return $this->hasOne('OParl\File', 'master_file_id', 'id');
  }

  public function derivatives()
  {
    return $this->belongsToMany('OParl\File', 'files_derivatives', 'file_id', 'derivative_id');
  }
}
