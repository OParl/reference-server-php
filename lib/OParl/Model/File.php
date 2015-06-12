<?php namespace OParl\Model;

class File extends BaseModel {
  protected $dates = ['file_created', 'file_modified'];
  protected $appends = ['sanitized_file_name'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   **/
  public function masterFile()
  {
    return $this->hasOne('OParl\Model\File', 'master_file_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   **/
  public function derivatives()
  {
    return $this->belongsToMany('OParl\Model\File', 'files_derivatives', 'file_id', 'derivative_id');
  }

  public static function generateFilename($extension = 'pdf', $hashed = true)
  {
    $filename = sprintf('%s.%s', uniqid('file_'), $extension);
    return ($hashed) ? hash_filename($filename) : $filename;
  }

  public function getSanitizedFileNameAttribute()
  {
    return substr($this->attributes['file_name'], strrpos($this->attributes['file_name'], DIRECTORY_SEPARATOR) + 1);
  }
}
