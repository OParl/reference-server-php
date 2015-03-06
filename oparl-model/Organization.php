<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
  protected $touches = ['memberships', 'body', 'suborganizationOf'];

  public function memberships()
  {
    return $this->hasManyThrough('OParl\Person', 'OParl\Membership', 'organization_id', 'id');
  }

  public function body()
  {
    return $this->belongsTo('OParl\Body');
  }

  public function suborganizationOf()
  {
    return $this->belongsTo('OParl\Organization', 'suborganization_of', 'id');
  }
}
