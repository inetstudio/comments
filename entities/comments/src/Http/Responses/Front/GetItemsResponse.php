<?php

namespace InetStudio\CommentsPackage\Comments\Http\Responses\Front;

use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Front\GetItemsResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Front\ItemsServiceContract as CommentsServiceContract;

class GetItemsResponse implements GetItemsResponseContract
{
    public function __construct(
        protected CommentsServiceContract $commentsService
    ) {}

    public function toResponse($request)
    {
        $type = $request->route('type');
        $id = $request->route('id');

        $page = ($request->filled('page')) ? $request->get('page') - 1 : 0;
        $limit = ($request->filled('limit')) ? $request->get('limit') : 3;

        $items = $this->commentsService->getItemsTreeByTypeAndId($type, $id)->sortByDesc('datetime');

        return view(
            'admin.module.comments::front.ajax.more',
            [
                'comments' => [
                    'stop' => (($page + 1) * $limit >= $items->count()),
                    'items' => $items->slice($page * $limit, $limit),
                ],
            ]
        )->render();
    }
}
