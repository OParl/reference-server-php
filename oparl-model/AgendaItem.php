<?php namespace OParl;

class AgendaItem extends BaseModel {
  protected $fillable = ['consecutive_number', 'name', 'public', 'result'];

	//
  public function auxiliaryFiles()
  {
    return $this->belongsToMany('OParl\File',
                         'agendaitems_auxiliary_files',
                         'agendaitem_id',
                         'auxiliary_id');
  }

  public function papers()
  {
    return $this->hasManyThrough('OParl\Paper', 'OParl\Consultation', 'agenda_item_id', 'paper_id');
  }

  public function consultation()
  {
    return $this->hasOne('OParl\Consultation', 'consultation_id');
  }

  public function meeting()
  {
    return $this->belongsTo('OParl\Meeting', 'meeting_id');
  }
}
