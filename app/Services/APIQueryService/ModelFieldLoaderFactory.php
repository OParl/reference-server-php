<?php namespace App\Services\APIQueryService;

class ModelFieldLoaderFactory 
{
  public static function get($table, $databaseSystem)
  {
    switch ($databaseSystem)
    {
      case 'sqlite': return new SQLiteModelFieldLoader($table); break;
      default:
        throw new \RuntimeException("{$databaseSystem} is not supported.");
    }
  }
}