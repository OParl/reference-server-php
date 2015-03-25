<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;
use Oparl\File;

class FileTransformer extends TransformerAbstract
{
  public function transform(File $file)
  {
    return [
      'id' => $file->id
    ];
  }
}