<?php namespace OParl\Model;

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
    return $this->belongsTo('OParl\Model\Organization', 'organization_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function scribe()
  {
    return $this->belongsTo('OParl\Model\Person', 'scribe_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function chair()
  {
    return $this->belongsTo('OParl\Model\Person', 'chair_person_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   **/
  public function invitations()
  {
    return $this->belongsToMany('OParl\Model\File', 'meetings_invitations', 'meeting_id', 'invitation_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   **/
  public function participants()
  {
    return $this->belongsToMany('OParl\Model\Person', 'meetings_participants', 'meeting_id', 'participant_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   **/
  public function auxiliaryFiles()
  {
    return $this->belongsToMany('OParl\Model\File', 'meetings_auxiliary_files', 'meeting_id', 'auxiliary_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   **/
  public function location()
  {
    return $this->hasOne('OParl\Model\Location');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   **/
  public function resultsProtocol()
  {
    return $this->hasOne('OParl\Model\File', 'results_protocol_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   **/
  public function verbatimProtocol()
  {
    return $this->hasOne('OParl\Model\File', 'verbatim_protocol_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   **/
  public function agendaItems()
  {
    return $this->hasMany('OParl\Model\AgendaItem', 'meeting_id', 'id');
  }
}
