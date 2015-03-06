<?php namespace OParl\Fakers;

use Faker\Provider\Base;

class MembershipsFaker extends Base {

  // TODO: these probably ought to be some oparl:role thing
  private $roles = [
    'Vorsitzende/r',
    'Mitglied',
    'Protokollant/in',
    'Gruppenleiter/in',
  ];

  public function oparlMembershipRole()
  {
    return $this->roles[$this->generator->numberBetween(0, count($this->roles) - 1)];
  }
}