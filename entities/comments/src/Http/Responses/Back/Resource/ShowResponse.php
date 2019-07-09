<?php

namespace InetStudio\CommentsPackage\Comments\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\ShowResponseContract;

/**
 * Class ShowResponse.
 */
class ShowResponse implements ShowResponseContract
{
    /**
     * @var CommentModelContract
     */
    protected $item;

    /**
     * ShowResponse constructor.
     *
     * @param  CommentModelContract  $item
     */
    public function __construct(CommentModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при получении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return response()->json($this->item);
    }
}
