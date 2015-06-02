<?php namespace App\Services\APIQueryService;

class MySQLModelFieldLoader extends ModelFieldLoader
{
  protected $query = "DESCRIBE %s";

  protected function parseResult($result)
  {
    foreach ($result as $field) $this->addField($field->Type, $field->Field);
  }
}