<?php namespace App\Handlers\Transformers;

use App\Model\Text;
use League\Fractal\TransformerAbstract;

class TextTransformer extends TransformerAbstract {
  protected $availableIncludes = ['comments'];
  protected $defaultIncludes   = ['images'];

  public function transform(Text $text)
  {
    $textArray = [
      'id' => (int)$text->id,
      'title' => $text->title,
      'content' => $text->content,

      'updated_at' => $text->updated_at->toRfc2822String(),
      'published_at' => $text->published_at->toRfc2822String(),

      'links' =>
      [
        [
          'rel' => 'self',
          'href' => action('API\TextController@show', $text->id)
        ],
        [
          'rel' => 'canonical',
          'href' => ''
        ]
      ]
    ];

    if (\Auth::check())
    {
      $textArray = array_merge($textArray, [
        'slug' => $text->slug,
        'created_at' => $text->created_at->toRfc2822String()
      ]);
    }

    return $textArray;
  }

  public function includeComments(Text $text)
  {
    return $this->collection($text->comments, new CommentTransformer);
  }

  public function includeImages(Text $text)
  {
    return $this->collection($text->images, new ImageTransformer);
  }
}