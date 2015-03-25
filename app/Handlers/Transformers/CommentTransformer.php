<?php namespace App\Handlers\Transformers;

use League\Fractal\TransformerAbstract;
use App\Model\Comment;

class CommentTransformer extends TransformerAbstract
{
  protected $availableIncludes = ['text'];

  public function transform(Comment $comment)
  {
    return [
      'id' => (int) $comment->id,
      'text_id' => (int) $comment->text_id,

      'author_name' => $comment->author_name,
      'author_url'  => $comment->author_url,

      'content' => $comment->content,

      'created_at' => $comment->created_at->toRfc2822String(),
      'updated_at' => $comment->updated_at->toRfc2822String(),

      'links' => [
        [
          'rel' => 'self',
          'href' => action('API\CommentController@show', $comment->id)
        ],
        [
          'rel' => 'canonical',
          'href' => ''
        ],
        [
          'rel' => 'related',
          'href' => action('API\TextController@show', $comment->text->id)
        ]
      ]
    ];
  }

  public function includeText(Comment $comment)
  {
    return $this->item($comment->text, new TextTransformer);
  }
}