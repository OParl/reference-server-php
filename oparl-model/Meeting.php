<?php namespace OParl;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model {

	protected $fillable = [
    'start',
    'end',
    'street_address',
    'postal_code',
    'locality'
  ];

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

  public function auxiliary_files()
  {
    return $this->belongsToMany('OParl\File', 'meetings_auxiliary_files', 'meeting_id', 'auxiliary_id');
  }
}
