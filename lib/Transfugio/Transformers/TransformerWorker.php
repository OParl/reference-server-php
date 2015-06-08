<?php namespace EFrane\Transfugio\Transformers;

interface TransformerWorker
{
  public function transformModel(\Illuminate\Database\Eloquent\Model $model);
  public function transformPaginated(\Illuminate\Pagination\LengthAwarePaginator $paginator);
}