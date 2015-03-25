<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;

use App\Model\Image;

class ImageTransformer extends TransformerAbstract
{
  public function transform(Image $image)
  {
    return [
      'title' => $image->title,
      'created_at' => $image->created_at->toRfc2822String(),
      'updated_at' => $image->updated_at->toRfc2822String(),
      'width' => (int)$image->width,
      'height' => (int)$image->height
    ];
  }
}