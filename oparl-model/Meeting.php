<?php namespace OParl;

class Meeting extends BaseModel {

	protected $fillable = [
    'start_date',
    'end_date',
    'street_address',
    'postal_code',
    'locality'
  ];

  protected $dates = ['start_date', 'end_date'];

  public function organization()
  {
    return $this->belongsTo('OParl\Organization', 'organization_id');
  }

  public function scribe()
  {
    return $this->belongsTo('OParl\Person', 'scribe_id');
  }

  public function chair()
  {
    return $this->belongsTo('OParl\Person', 'chair_person_id');
  }

  public function invitations()
  {
    return $this->belongsToMany('OParl\File', 'meetings_invitations', 'meeting_id', 'invitation_id');
  }

  public function participants()
  {
    return $this->belongsToMany('OParl\Person', 'meetings_participants', 'meeting_id', 'participant_id');
  }

  public function auxiliaryFiles()
  {
    return $this->belongsToMany('OParl\File', 'meetings_auxiliary_files', 'meeting_id', 'auxiliary_id');
  }

  public function location()
  {
    return $this->hasOne('OParl\Location');
  }

  public function resultsProtocol()
  {
    return $this->hasOne('OParl\File', 'results_protocol_id');
  }

  public function verbatimProtocol()
  {
    return $this->hasOne('OParl\File', 'verbatim_protocol_id');
  }

  public function agendaItems()
  {
    return $this->hasMany('OParl\AgendaItem', 'meeting_id', 'id');
  }
}
