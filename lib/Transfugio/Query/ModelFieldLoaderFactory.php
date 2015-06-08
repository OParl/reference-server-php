<?php namespace EFrane\Transfugio\Query;

class ModelFieldLoaderFactory 
{
  public static function get($table, $databaseSystem)
  {
    switch ($databaseSystem)
    {
      case 'sqlite': return new SQLiteModelFieldLoader($table); break;
      case 'mysql': return new MySQLModelFieldLoader($table); break;

      default:
        throw new \RuntimeException("{$databaseSystem} is not supported.");
    }
  }
}