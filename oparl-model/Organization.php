<?php namespace Oparl;

class Organization extends BaseModel
{
  protected $touches = ['body', 'suborganizationOf'];

  protected $dates = ['start_date', 'end_date'];

  public function members()
  {
    return $this->hasManyThrough('OParl\Person', 'OParl\Membership', 'person_id', 'id');
  }

  public function body()
  {
    return $this->belongsTo('OParl\Body');
  }

  public function suborganizationOf()
  {
    return $this->belongsTo('OParl\Organization', 'suborganization_of', 'id');
  }

  public function meetings()
  {
    return $this->hasMany('OParl\Meeting', 'organization_id', 'id');
  }
}
