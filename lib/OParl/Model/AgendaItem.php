<?php namespace OParl\Model;

class AgendaItem extends BaseModel {
  protected $fillable = ['consecutive_number', 'name', 'public', 'result'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   **/
  public function auxiliaryFiles()
  {
    return $this->belongsToMany('OParl\Model\File',
                         'agenda_items_auxiliary_files',
                         'agenda_item_id',
                         'auxiliary_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
   **/
  public function papers()
  {
    return $this->hasManyThrough('OParl\Model\Paper', 'OParl\Model\Consultation', 'agenda_item_id', 'paper_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   **/
  public function consultation()
  {
    return $this->hasOne('OParl\Model\Consultation', 'consultation_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function meeting()
  {
    return $this->belongsTo('OParl\Model\Meeting', 'meeting_id');
  }
}
