<?php namespace App\Services\APIQueryService;

use APIRelationPath;

trait APIQueryable // implements APIQueryableContract
{
  /* protected static $queryableRelations = []; */
  /* protected static $queryableFields = []; */

  public static function getQueryableRelations()
  {
    $queryableRelations = array_map(function ($rel) {
      if (is_string($rel))
        $rel = APIRelationPath::build($rel);

      return $rel;
    }, static::$queryableRelations);

    return $queryableRelations;
  }

  public static function getQueryableFields(array $defaultFields = ['id', 'created_at', 'updated_at'])
  {
    return array_merge(static::$queryableFields, $defaultFields);
  }
}