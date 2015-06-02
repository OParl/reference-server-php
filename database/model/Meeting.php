<?php namespace OParl;

class Meeting extends BaseModel
{
	protected $fillable = [
    'start_date',
    'end_date',
    'street_address',
    'postal_code',
    'locality'
  ];

  protected $dates = ['start_date', 'end_date'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function organization()
  {
    return $this->belongsTo('OParl\Organization', 'organization_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function scribe()
  {
    return $this->belongsTo('OParl\Person', 'scribe_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function chair()
  {
    return $this->belongsTo('OParl\Person', 'chair_person_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   **/
  public function invitations()
  {
    return $this->belongsToMany('OParl\File', 'meetings_invitations', 'meeting_id', 'invitation_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   **/
  public function participants()
  {
    return $this->belongsToMany('OParl\Person', 'meetings_participants', 'meeting_id', 'participant_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   **/
  public function auxiliaryFiles()
  {
    return $this->belongsToMany('OParl\File', 'meetings_auxiliary_files', 'meeting_id', 'auxiliary_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   **/
  public function location()
  {
    return $this->hasOne('OParl\Location');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   **/
  public function resultsProtocol()
  {
    return $this->hasOne('OParl\File', 'results_protocol_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   **/
  public function verbatimProtocol()
  {
    return $this->hasOne('OParl\File', 'verbatim_protocol_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   **/
  public function agendaItems()
  {
    return $this->hasMany('OParl\AgendaItem', 'meeting_id', 'id');
  }
}
