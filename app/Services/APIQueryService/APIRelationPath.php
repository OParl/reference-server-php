<?php namespace App\Services\APIQueryService;

/**
 * Class APIRelationPath
 * @package Services\APIQueryService
 **/
final class APIRelationPath
{
  /**
   * @var string
   **/
  protected $path = '';

  /**
   * @var string
   **/
  protected $sourceClass = '';
  /**
   * @var string
   **/
  protected $sourceField = '';

  /**
   * @var array
   **/
  protected $joinDestinations = [];

  /**
   * @param $path
   */
  private function __construct($path)
  {
    //        (label :) source class . source field (> dest_n class . dest_n field = dest_n-1 field)+
    $pattern = '/(a-z:)?([a-zA-Z0-9_\]+)\.([a-zA-Z0-9_]+)(?:(>)(a-zA-Z0-9_\)\.([a-zA-Z0-9_]+)=([a-zA-Z0-9_]+))/';
    $matches = null;

    if (preg_match_all($pattern, $path, $matches))
      $this->path = $matches;

    // FIXME: Error handling
  }

  /**
   * @param $path
   * @return APIRelationPath
   **/
  public static function build($path)
  {
    return new APIRelationPath($path);
  }

  /**
   * @return bool
   **/
  public function isLocal()
  {
    return $this->sourceClass === 'self';
  }

  /**
   * @param int $destinationId
   * @return mixed
   **/
  public function getDestinationClass($destinationId = 0)
  {
    if ($this->hasDestination($destinationId))
      return $this->joinDestinations[$destinationId][0];
  }

  /**
   * @param int $destinationId
   * @return mixed
   **/
  public function getDestinationField($destinationId = 0)
  {
    if ($this->hasDestination($destinationId))
      return $this->joinDestinations[$destinationId][1];
  }

  /**
   * @param int $destinationId
   * @return mixed
   **/
  public function getDestinationEqualsClass($destinationId = 0)
  {
    if ($this->hasDestination($destinationId))
      return ($destinationId == 0)
        ? $this->sourceClass()
        : $this->getDestinationClass($destinationId - 1);
  }

  /**
   * @param int $destinationId
   * @return bool
   **/
  protected function hasDestination($destinationId = 0)
  {
    return isset($this->joinDestinations[$destinationId]);
  }
}

if (!function_exists('relation_path'))
{
  /**
   * @param $path
   * @return APIRelationPath
   **/
  function relation_path($path)
  {
    return APIRelationPath::build($path);
  }
}
