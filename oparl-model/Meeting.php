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

  public function invitations()
  {
    return $this->belongsToMany('OParl\File', 'meetings_invitations', 'invitation_id');
  }

  public function participants()
  {
    return $this->belongsToMany('OParl\Person', 'meetings_participants', 'participant_id');
  }

  public function auxiliary_files()
  {
    return $this->belongsToMany('OParl\File', 'meetings_auxiliary_files', 'auxiliary_id');
  }
}
