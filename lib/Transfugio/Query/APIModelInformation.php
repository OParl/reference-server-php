<?php namespace EFrane\Transfugio\Query;

use DB;
use phpDocumentor\Reflection\DocBlock;

class APIModelInformation
{
  protected $model    = '';
  protected $instance = null;

  protected $fields = [];

  protected $dates     = [];
  protected $relations = [];

  public function __construct($model)
  {
    $this->model = $model;
    $this->instance = new $this->model();

    $this->acquire();

    $this->instance = null;
  }

  /**
   * @return array
   */
  public function getDates()
  {
    return $this->dates;
  }

  public function isDate($field)
  {
    if (in_array($field, $this->dates)) return true;
    if (in_array(snake_case($field), $this->dates)) return true;

    return false;
  }

  /**
   * @return array
   */
  public function getRelations()
  {
    return $this->relations;
  }

  public function isRelation($field)
  {
    if (in_array($field, $this->relations)) return true;
    if (in_array(snake_case($field), $this->relations)) return true;

    return false;
  }

  protected function acquire()
  {
    $this->loadTableFields();

    $this->acquireRelations();
    $this->acquireDates();
  }

  protected function loadTableFields()
  {
    $loader = ModelFieldLoaderFactory::get($this->instance->getTable(), config('database.default'));

    if (count($this->instance->getHidden()) > 0)
    {
      $this->fields = $loader->except($this->instance->getHidden());
    } else if (count($this->instance->getVisible()) > 0)
    {
      $this->fields = $loader->only($this->instance->getVisible());
    } else
    {
      $this->fields = $loader->all();
    }
  }

  protected function acquireDates()
  {
    // getting the date fields is easy
    $this->dates = $this->instance->getDates();
  }

  protected function acquireRelations()
  {
    // getting the relations – on the other hand – is not, since they need to be loaded
    // to be visible. thus, reflection is used to find the methods that return relation
    // objects

    $reflectionClass = new \ReflectionClass($this->model);
    foreach ($reflectionClass->getMethods() as $method)
    {
      $docBlock = new DocBlock($method);

      $returnTag = $docBlock->getTagsByName('return');

      if (count($returnTag) >= 1 && $this->isEloquentRelation($returnTag[0]->getType()))
      {
        $this->relations[] = $method->getName();
      }
    }
  }

  protected function isEloquentRelation($relation)
  {
    return in_array($relation, [
      '\Illuminate\Database\Eloquent\Relations\HasOne',
      '\Illuminate\Database\Eloquent\Relations\HasMany',
      '\Illuminate\Database\Eloquent\Relations\HasManyThrough',
      '\Illuminate\Database\Eloquent\Relations\BelongsTo',
      '\Illuminate\Database\Eloquent\Relations\BelongsToMany'
    ]);
  }
}