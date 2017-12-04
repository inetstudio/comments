<?php

namespace InetStudio\Comments\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use InetStudio\Comments\Http\Requests\Front\SendCommentRequest;

class CommentsController extends Controller
{
    /**
     * Отправка комментария.
     *
     * @param SendCommentRequest $request
     * @param string $type
     * @param string $id
     * @return JsonResponse
     */
    public function sendComment(SendCommentRequest $request,
                                string $type,
                                string $id): JsonResponse
    {
        $commentsService = app()->make('CommentsService');

        $comment = $commentsService->saveComment($request, $type, $id);

        $result = ($comment && isset($comment->id));

        return response()->json([
            'success' => $result,
            'message' => ($result) ? trans('comments::messages.send_success') : trans('comments::messages.send_fail'),
        ]);
    }

    /**
     * Получаем комментарии к материалу.
     *
     * @param Request $request
     * @param string $type
     * @param string $id
     * @return string
     */
    public function getComments(Request $request,
                                string $type,
                                string $id): string
    {
        $commentsService = app()->make('CommentsService');

        $page = ($request->filled('page')) ? $request->get('page') - 1 : 0;
        $limit = ($request->filled('limit')) ? $request->get('limit') : 3;

        $comments = $commentsService->getCommentsTreeByTypeAndId($type, $id)->sortByDesc('datetime');

        return view('admin.module.comments::front.ajax.more', [
            'comments' => [
                'stop' => (($page+1)*$limit >= $comments->count()),
                'items' => $comments->slice($page*$limit, $limit),
            ],
        ])->render();
    }
}
