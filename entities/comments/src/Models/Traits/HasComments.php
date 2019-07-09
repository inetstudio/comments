<?php

namespace InetStudio\CommentsPackage\Comments\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;

/**
 * Trait HasComments.
 */
trait HasComments
{
    /**
     * Get Comment class name.
     *
     * @return string
     *
     * @throws BindingResolutionException
     */
    public static function getCommentClassName(): string
    {
        $model = app()->make(CommentModelContract::class);

        return get_class($model);
    }

    /**
     * Set the polymorphic relation.
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    public function comments()
    {
        $className = $this->getCommentClassName();

        return $this->morphMany($className, 'commentable');
    }

    /**
     * Возвращаем комментарии в виде иерархии.
     *
     * @return Collection
     *
     * @throws BindingResolutionException
     */
    public function commentsTree(): Collection
    {
        return $this->comments()->get()->toTree();
    }
}
