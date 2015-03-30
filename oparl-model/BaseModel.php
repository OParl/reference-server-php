<?php namespace OParl;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
  public static function boot()
  {
    parent::boot();

    static::created(function ($model) {
      Transaction::create(['model' => get_class($model), 'action' => 'new', 'model_id' => $model->id]);
      return true;
    });

    static::updated(function($model) {
      Transaction::create(['model' => get_class($model), 'action' => 'updated', 'model_id' => $model->id]);
      return true;
    });

    static::deleted(function($model) {
      Transaction::create(['model' => get_class($model), 'action' => 'removed', 'model_id' => $model->id]);
      return true;
    });
  }
}
