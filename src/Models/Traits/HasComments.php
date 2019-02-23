<?php

namespace InetStudio\Comments\Models\Traits;

use InetStudio\Comments\Contracts\Services\Front\CommentsServiceContract;

/**
 * Trait HasComments.
 */
trait HasComments
{
    /**
     * Get Comment class name.
     *
     * @return string
     */
    public static function getCommentClassName(): string
    {
        $model = app()->make('InetStudio\Comments\Contracts\Models\CommentModelContract');

        return get_class($model);
    }

    /**
     * Set the polymorphic relation.
     *
     * @return mixed
     */
    public function comments()
    {
        return $this->morphMany(static::getCommentClassName(), 'commentable');
    }

    /**
     * Возвращаем комментарии в виде иерархии.
     *
     * @param CommentsServiceContract $commentsServiceContract
     *
     * @return array
     */
    public function commentsTree(CommentsServiceContract $commentsServiceContract): array
    {
        $tree = $this->comments()->where('is_active', 1)->get()->toTree();

        return $commentsServiceContract->getTree($tree);
    }
}
