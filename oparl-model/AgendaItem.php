<?php namespace OParl;

use Illuminate\Database\Eloquent\Model;

class AgendaItem extends Model {

	//
  public function auxiliaryFiles()
  {
    $this->belongsToMany('OParl\File', 
                         'agendaitems_auxiliary_files',
                         'agendaitem_id',
                         'auxiliary_id');
  }

}
