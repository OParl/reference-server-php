<?php namespace App\Services\APIQueryService;

interface APIQueryableContract
{
  public static function getQueryableRelations();
  public static function getQueryableFields(array $defaultFields);
}