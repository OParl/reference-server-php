<?php namespace OParl;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Person extends Model implements AuthenticatableContract, CanResetPasswordContract {

  use Authenticatable;
  use CanResetPassword;

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
    'postal_code',

    'password'
  ];

  protected $hidden = ['password', 'remember_token'];

  public function body()
  {
    return $this->belongsTo('OParl\Body');
  }
}
