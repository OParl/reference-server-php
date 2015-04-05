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

  public static function generateFilename($extension = 'pdf', $hashed = true)
  {
    $filename = sprintf('%s.%s', uniqid('file_'), $extension);
    return ($hashed) ? hash_filename($filename) : $filename;
  }

  public function getCleanFileName()
  {
    $parts = explode(DIRECTORY_SEPARATOR, $this->attributes['file_name']);
    return $parts[count($parts) - 1];
  }
}
