<?php namespace App\Services\APIQueryService;

class MySQLModelFieldLoader extends ModelFieldLoder
{
  protected $query = "DESCRIBE %s";

  protected function parseResult($result)
  {
    foreach ($result as $field) $this->addField($field->type, $field->field);
  }
}