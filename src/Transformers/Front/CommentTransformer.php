<?php

namespace InetStudio\Comments\Transformers\Front;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Comments\Contracts\Models\CommentModelContract;
use InetStudio\Comments\Contracts\Transformers\Front\CommentTransformerContract;

/**
 * Class CommentTransformer.
 */
class CommentTransformer extends TransformerAbstract implements CommentTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'items',
    ];

    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param CommentModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(CommentModelContract $item): array
    {
        $user = $item->user;

        return [
            'id' => $item->id,
            'user' => [
                'roles' => ($user) ? $user->roles->pluck('name')->toArray() : [],
                'name' => $item->name,
            ],
            'datetime' => (string) $item->created_at,
            'message' => $item->message,
        ];
    }

    /**
     * Включаем дочерние комментарии в трансформацию.
     *
     * @param CommentModelContract $item
     *
     * @return FractalCollection
     */
    public function includeItems(CommentModelContract $item): FractalCollection
    {
        return new FractalCollection($item->children, $this);
    }

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection
    {
        return new FractalCollection($items, $this);
    }
}
