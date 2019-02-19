<?php

namespace InetStudio\Comments\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class CommentsBindingsServiceProvider.
 */
class CommentsBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\Comments\Contracts\Models\CommentModelContract' => 'InetStudio\Comments\Models\CommentModel',
        'InetStudio\Comments\Contracts\Transformers\Back\CommentTransformerContract' => 'InetStudio\Comments\Transformers\Back\CommentTransformer',
        'InetStudio\Comments\Contracts\Transformers\Front\CommentTransformerContract' => 'InetStudio\Comments\Transformers\Front\CommentTransformer',
        'InetStudio\Comments\Contracts\Events\Back\ModifyCommentEventContract' => 'InetStudio\Comments\Events\Back\ModifyCommentEvent',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
