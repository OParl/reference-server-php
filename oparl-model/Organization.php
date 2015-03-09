<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
  protected $touches = ['body', 'suborganizationOf'];

  /*
  public function memberships()
  {
    return $this->hasManyThrough('OParl\Person', 'OParl\Membership', 'person_id', 'id');
  }
  */

  public function body()
  {
    return $this->belongsTo('OParl\Body');
  }

  public function suborganizationOf()
  {
    return $this->belongsTo('OParl\Organization', 'suborganization_of', 'id');
  }
}
