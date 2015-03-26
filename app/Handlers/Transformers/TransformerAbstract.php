<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract as LeagueTransformer;

use Carbon\Carbon;

abstract class TransformerAbstract extends LeagueTransformer
{
  protected function formatDate(Carbon $date = null)
  {
    if (is_null($date)) return null;

    return $date->toRfc2822String();
  }
}