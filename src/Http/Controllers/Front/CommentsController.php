<?php

namespace InetStudio\Comments\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\Comments\Contracts\Services\Front\CommentsServiceContract;
use InetStudio\Comments\Contracts\Http\Requests\Front\SendCommentRequestContract;
use InetStudio\Comments\Contracts\Http\Responses\Front\GetCommentsResponseContract;
use InetStudio\Comments\Contracts\Http\Responses\Front\SendCommentResponseContract;
use InetStudio\Comments\Contracts\Http\Controllers\Front\CommentsControllerContract;

/**
 * Class CommentsController.
 */
class CommentsController extends Controller implements CommentsControllerContract
{
    /**
     * Отправка комментария.
     *
     * @param CommentsServiceContract $commentsService
     * @param SendCommentRequestContract $request
     * @param string $type
     * @param string $id
     *
     * @return SendCommentResponseContract
     */
    public function sendComment(CommentsServiceContract $commentsService,
                                SendCommentRequestContract $request,
                                string $type,
                                string $id): SendCommentResponseContract
    {
        $data = $request->only($commentsService->model->getFillable());

        $item = $commentsService->saveComment($data, $type, $id);

        $result = ($item && isset($item->id));

        return app()->makeWith(SendCommentResponseContract::class, compact('result'));
    }

    /**
     * Получаем комментарии к материалу.
     *
     * @param CommentsServiceContract $commentsService
     * @param Request $request
     * @param string $type
     * @param string $id
     *
     * @return GetCommentsResponseContract
     */
    public function getComments(CommentsServiceContract $commentsService,
                                Request $request,
                                string $type,
                                string $id): GetCommentsResponseContract
    {
        $page = ($request->filled('page')) ? $request->get('page') - 1 : 0;
        $limit = ($request->filled('limit')) ? $request->get('limit') : 3;

        $items = $commentsService->getCommentsTreeByTypeAndId($type, $id)->sortByDesc('datetime');

        return app()->makeWith(GetCommentsResponseContract::class, [
            'data' => [
                'comments' => [
                    'stop' => (($page + 1) * $limit >= $items->count()),
                    'items' => $items->slice($page * $limit, $limit),
                ],
            ]
        ]);
    }
}
