<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model {

  public function memberships()
  {
    $this->hasManyThrough('OParl\Person', 'OParl\Membership', 'organization_id', 'person_id');
  }

}
