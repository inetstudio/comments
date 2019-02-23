<?php

namespace InetStudio\Comments\Models\Traits;

use Illuminate\Support\Collection;

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
     * @return Collection
     */
    public function commentsTree(): Collection
    {
        return $this->comments()->get()->toTree();
    }
}
