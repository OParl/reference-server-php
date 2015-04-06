<?php namespace App\Commands;

use Illuminate\Contracts\Bus\SelfHandling;

abstract class CreateAPIResponseCommand extends Command implements SelfHandling
{
  protected $apiData    = [];
  protected $headers    = [];
  protected $statusCode = 200;

  protected $additionalData = null;

  public function __construct(array $apiData, $statusCode = 200, array $headers = [], array $additionalData = [])
  {
    $this->apiData    = $apiData;
    $this->statusCode = $statusCode;
    $this->headers    = $headers;

    $this->additionalData = $additionalData;
  }
}