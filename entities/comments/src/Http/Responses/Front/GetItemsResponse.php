<?php

namespace InetStudio\CommentsPackage\Comments\Http\Responses\Front;

use InetStudio\AdminPanel\Base\Http\Responses\BaseResponse;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Front\GetItemsResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Front\ItemsServiceContract as CommentsServiceContract;

/**
 * Class GetItemsResponse.
 */
class GetItemsResponse extends BaseResponse implements GetItemsResponseContract
{
    /**
     * @var CommentsServiceContract
     */
    protected $commentsService;

    /**
     * GetItemsResponse constructor.
     *
     * @param  CommentsServiceContract  $commentsService
     */
    public function __construct(
        CommentsServiceContract $commentsService
    ) {
        $this->commentsService = $commentsService;

        $this->render = true;
        $this->view = 'admin.module.comments::front.ajax.more';
    }

    /**
     * Prepare response data.
     *
     * @param $request
     *
     * @return array
     */
    protected function prepare($request): array
    {
        $type = $request->route('type');
        $id = $request->route('id');

        $page = ($request->filled('page')) ? $request->get('page') - 1 : 0;
        $limit = ($request->filled('limit')) ? $request->get('limit') : 3;

        $items = $this->commentsService->getItemsTreeByTypeAndId($type, $id)->sortByDesc('datetime');

        return [
            'comments' => [
                'stop' => (($page + 1) * $limit >= $items->count()),
                'items' => $items->slice($page * $limit, $limit),
            ],
        ];
    }
}
