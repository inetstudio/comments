<?php

namespace InetStudio\Comments\Services\Front;

use Illuminate\Support\Collection;
use InetStudio\Comments\Models\CommentModel;
use InetStudio\Comments\Http\Requests\Front\SendCommentRequest;

class CommentsService
{
    public $availableTypes = [];

    /**
     * CommentsService constructor.
     */
    public function __construct()
    {
        $types = config('comments.commentable');

        if ($types) {
            foreach ($types as $type => $model) {
                $this->availableTypes[$type] = new $model();
            }
        }
    }

    /**
     * Сохраняем комментарий.
     *
     * @param SendCommentRequest $request
     * @param string $type
     * @param int $id
     * @return CommentModel
     */
    public function saveComment(SendCommentRequest $request,
                                string $type,
                                int $id): ?CommentModel
    {
        $usersService = app()->make('UsersService');

        if (! isset($this->availableTypes[$type])) {
            return;
        }

        if (! is_null($id) && $id > 0 && $item = $this->availableTypes[$type]::find($id)) {
            $comment = CommentModel::create([
                'commentable_id' => $item->id,
                'commentable_type' => get_class($item),
                'user_id' => $usersService->getUserId(),
                'name' => $usersService->getUserName($request),
                'email' => $usersService->getUserEmail($request),
                'message' => strip_tags($request->get('message')),
            ]);

            $comment->saveAsRoot();

            return $comment;
        } else {
            return;
        }
    }

    /**
     * Получаем дерево комментариев.
     *
     * @param $item
     * @return Collection
     */
    public function getCommentsTree($item): Collection
    {
        $cacheKey = 'CommentsService_getCommentsTree_'.md5(get_class($item).$item->id);

        return \Cache::tags(['comments', 'materials'])->remember($cacheKey, 1440, function () use ($item) {
            return collect($item->commentsTree());
        });
    }

    /**
     * Получаем дерево комментариев по типу и id материала.
     *
     * @param string $type
     * @param int $id
     * @return Collection
     */
    public function getCommentsTreeByTypeAndId(string $type,
                                               int $id): Collection
    {
        if (! isset($this->availableTypes[$type])) {
            return collect([]);
        }

        if (! is_null($id) && $id > 0 && $item = $this->availableTypes[$type]::find($id)) {
            return $this->getCommentsTree($item);
        } else {
            return collect([]);
        }
    }
}
