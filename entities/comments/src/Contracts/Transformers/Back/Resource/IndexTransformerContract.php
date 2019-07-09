<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Transformers\Back\Resource;

use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;

/**
 * Interface IndexTransformerContract.
 */
interface IndexTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  CommentModelContract  $item
     *
     * @return array
     */
    public function transform(CommentModelContract $item): array;
}
