<?php namespace Oparl;

use App\Services\APIQueryService\APIQueryable;
use App\Services\APIQueryService\APIQueryableContract;
use Illuminate\Database\Eloquent\Model;

class Body extends Model implements APIQueryableContract {
  use APIQueryable;

  protected static $queryableRelations = [
    'self.system',
    'organization:self.organizations',
    'person:self.people',
    'legislativeterm:self.legislativeTerms',
  ];

  protected $casts = [
    'equivalent_body' => 'array'
  ];

  protected $dates = ['license_valid_since'];

  /**
   * The system this body belongs to
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function system()
  {
    return $this->belongsTo('OParl\System', 'system_id', 'id');
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
