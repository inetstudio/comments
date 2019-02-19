<?php

namespace InetStudio\Comments\Transformers\Back;

use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;
use InetStudio\Comments\Contracts\Models\CommentModelContract;
use InetStudio\Comments\Contracts\Transformers\Back\CommentTransformerContract;

/**
 * Class CommentTransformer.
 */
class CommentTransformer extends TransformerAbstract implements CommentTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param CommentModelContract $comment
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(CommentModelContract $comment): array
    {
        return [
            'checkbox' => view('admin.module.comments::back.partials.datatables.checkbox', [
                'id' => $comment->id,
            ])->render(),
            'id' => (int) $comment->id,
            'read' => view('admin.module.comments::back.partials.datatables.read', [
                'is_read' => $comment->is_read,
            ])->render(),
            'active' => view('admin.module.comments::back.partials.datatables.active', [
                'id' => $comment->id,
                'is_active' => $comment->is_active,
            ])->render(),
            'name' => $comment->name,
            'email' => $comment->email,
            'message' => Str::limit($comment->message, 150, '...'),
            'created_at' => (string) $comment->created_at,
            'material' => view('admin.module.comments::back.partials.datatables.material', [
                'item' => $comment->commentable,
            ])->render(),
            'actions' => view('admin.module.comments::back.partials.datatables.actions', [
                'id' => $comment->id,
            ])->render(),
        ];
    }
}