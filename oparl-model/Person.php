<?php namespace OParl;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {

  protected $fillable = [
    'created_at',

    'name', 
    'family_name', 
    'given_name', 
    'form_of_address', 
    'title',
    'gender',

    'phone',
    'email',

    'street_address',
    'postal_code'
  ];

  public function body()
  {
    $this->hasOne('OParl\Body');
  }
}
