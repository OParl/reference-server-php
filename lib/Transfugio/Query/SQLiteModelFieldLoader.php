<?php namespace EFrane\Transfugio\Query;

class SQLiteModelFieldLoader extends ModelFieldLoader
{
  protected $query = 'PRAGMA table_info("%s")';

  protected function parseResult($result)
  {
    foreach ($result as $field) $this->addField($field->type, $field->name);
  }
}