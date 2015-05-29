<?php namespace OParl;

class AgendaItem extends BaseModel {
  protected $fillable = ['consecutive_number', 'name', 'public', 'result'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   **/
  public function auxiliaryFiles()
  {
    return $this->belongsToMany('OParl\File',
                         'agenda_items_auxiliary_files',
                         'agenda_item_id',
                         'auxiliary_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
   **/
  public function papers()
  {
    return $this->hasManyThrough('OParl\Paper', 'OParl\Consultation', 'agenda_item_id', 'paper_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   **/
  public function consultation()
  {
    return $this->hasOne('OParl\Consultation', 'consultation_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function meeting()
  {
    return $this->belongsTo('OParl\Meeting', 'meeting_id');
  }
}
