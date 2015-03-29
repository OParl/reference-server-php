<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model {

  public function paper()
  {
    return $this->hasOne('OParl\Paper');
  }

  public function agendaItem()
  {
    return $this->belongsTo('OParl\AgendaItem', 'agenda_item_id', 'id');
  }

	public function consultations()
  {
    return $this->belongsToMany('OParl\Consultation', 'consultations_organizations', 'consultation_id', 'organization_id');
  }

}
