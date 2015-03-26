<?php namespace App\Handlers\Transformers;

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