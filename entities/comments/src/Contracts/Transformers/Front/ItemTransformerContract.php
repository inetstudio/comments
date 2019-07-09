<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Transformers\Front;

use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;

/**
 * Interface ItemTransformerContract.
 */
interface ItemTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  CommentModelContract  $item
     *
     * @return array
     */
    public function transform(CommentModelContract $item): array;

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection;
}
