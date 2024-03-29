<?php

namespace InetStudio\CommentsPackage\Comments\Transformers\Back\Resource;

use Throwable;
use League\Fractal\TransformerAbstract;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;
use InetStudio\CommentsPackage\Comments\Contracts\Transformers\Back\Resource\IndexTransformerContract;

/**
 * Class IndexTransformer.
 */
class IndexTransformer extends TransformerAbstract implements IndexTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  CommentModelContract  $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(CommentModelContract $item): array
    {
        return [
            'checkbox' => view(
                'admin.module.comments::back.partials.datatables.checkbox',
                [
                    'id' => $item['id'],
                ]
            )->render(),
            'id' => (int) $item['id'],
            'read' => view(
                'admin.module.comments::back.partials.datatables.read',
                [
                    'is_read' => $item['is_read'],
                ]
            )->render(),
            'active' => view(
                'admin.module.comments::back.partials.datatables.active',
                [
                    'id' => $item['id'],
                    'is_active' => $item['is_active'],
                ]
            )->render(),
            'name' => $item['name'],
            'email' => $item['email'],
            'media' => view('admin.module.comments::back.partials.datatables.media', compact('item'))
                ->render(),
            'message' => $item['message'],
            'created_at' => (string) $item['created_at'],
            'material' => view(
                'admin.module.comments::back.partials.datatables.material',
                [
                    'item' => $item['commentable'],
                ]
            )->render(),
            'actions' => view(
                'admin.module.comments::back.partials.datatables.actions',
                [
                    'id' => $item['id'],
                ]
            )->render(),
        ];
    }
}
