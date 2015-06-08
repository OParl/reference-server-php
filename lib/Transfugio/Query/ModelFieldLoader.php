<?php namespace EFrane\Transfugio\Query;

abstract class ModelFieldLoader
{
  protected $table  = '';
  protected $fields = [];

  public function __construct($table)
  {
    $this->table = $table;
    $this->queryDB();
  }

  protected function queryDB()
  {
    $connection = app('db');
    // FIXME: for some reason, pdo named parameters seem to throw exceptions (at least on sqlite)
    $result = $connection->select($connection->raw(sprintf($this->query, $this->table)));

    $this->parseResult($result);
  }

  abstract protected function parseResult($result);

  protected function addField($type, $name)
  {
    $this->fields[$name] = $type;
  }

  public function all()
  {
    return $this->fields;
  }

  public function except(array $except)
  {
    return array_diff_key($this->fields, $except);
  }

  public function only(array $only)
  {
    return array_intersect_key($this->fields, $only);
  }
}