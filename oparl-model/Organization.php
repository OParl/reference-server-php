<?php namespace OParl;

class Organization extends BaseModel
{
  protected $touches = ['body', 'suborganizationOf'];

  protected $dates = ['start_date', 'end_date'];

  protected $casts = ['post'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
   **/
  public function members()
  {
    return $this->hasManyThrough('OParl\Person', 'OParl\Membership', 'person_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function body()
  {
    return $this->belongsTo('OParl\Body');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function suborganizationOf()
  {
    return $this->belongsTo('OParl\Organization', 'suborganization_of', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   **/
  public function meetings()
  {
    return $this->hasMany('OParl\Meeting', 'organization_id', 'id');
  }
}
