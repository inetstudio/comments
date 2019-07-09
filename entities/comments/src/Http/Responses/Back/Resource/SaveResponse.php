<?php

namespace InetStudio\CommentsPackage\Comments\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract
{
    /**
     * @var CommentModelContract
     */
    protected $item;

    /**
     * SaveResponse constructor.
     *
     * @param  CommentModelContract  $item
     */
    public function __construct(CommentModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $item = $this->item->fresh();

        return response()->redirectToRoute(
            'back.comments.edit',
            [
                $item['id'],
            ]
        );
    }
}
