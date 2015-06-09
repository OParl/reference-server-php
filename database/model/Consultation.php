<?php namespace OParl;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model {

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   **/
  public function paper()
  {
    return $this->hasOne('OParl\Paper');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function agendaItem()
  {
    return $this->belongsTo('OParl\AgendaItem', 'agenda_item_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   **/
  public function organizations()
  {
    return $this->belongsToMany('OParl\Consultation', 'consultations_organizations', 'consultation_id', 'organization_id');
  }
}
