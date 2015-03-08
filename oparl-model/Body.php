<?php namespace Oparl;

use Illuminate\Database\Eloquent\Model;

class Body extends Model {
  protected $casts = [
    'equivalent_body' => 'array'
  ];

  /**
   * The system this body belongs to
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function system()
  {
    return $this->belongsTo('OParl\System', 'pk');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function organizations()
  {
    return $this->hasMany('OParl\Organization');
  }

  /**
   * All people that belong to this body
   *
   * (more details about different groups of people may be accessed via
   * `$body->organizations[$organizationId]->memberships`
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function people()
  {
    return $this->hasMany('OParl\Person');
  }

  public function legislativeTerms()
  {
    return $this->hasMany('OParl\LegislativeTerm');
  }
}
