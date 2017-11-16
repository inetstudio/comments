<?php

namespace InetStudio\Comments\Models\Traits;

use InetStudio\Comments\Models\CommentModel;

trait HasComments
{
    /**
     * Get Comment class name.
     *
     * @return string
     */
    public static function getCommentClassName(): string
    {
        return CommentModel::class;
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
     * @return array
     */
    public function commentsTree(): array
    {
        return CommentModel::getTree($this);
    }
}
