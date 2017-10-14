<?php

namespace Inetstudio\Comments\Transformers;

use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;
use InetStudio\Comments\Models\CommentModel;

class CommentTransformer extends TransformerAbstract
{
    /**
     * @param CommentModel $comment
     * @return array
     */
    public function transform(CommentModel $comment)
    {
        return [
            'id' => (int) $comment->id,
            'read' => view('admin.module.comments::partials.datatables.read', [
                'is_read' => $comment->is_read,
            ])->render(),
            'active' => view('admin.module.comments::partials.datatables.active', [
                'id' => $comment->id,
                'is_active' => $comment->is_active,
            ])->render(),
            'name' => $comment->name,
            'email' => $comment->email,
            'message' => Str::limit($comment->message, 150, '...'),
            'created_at' => (string) $comment->created_at,
            'actions' => view('admin.module.comments::partials.datatables.actions', [
                'id' => $comment->id,
            ])->render(),
        ];
    }
}
