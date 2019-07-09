<?php

namespace InetStudio\CommentsPackage\Comments\Http\Controllers\Front;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Front\SendResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Requests\Front\SendItemRequestContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Front\GetItemsResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Front\ItemsControllerContract;

/**
 * Class ItemsController.
 */
class ItemsController extends Controller implements ItemsControllerContract
{
    /**
     * Отправка комментария.
     *
     * @param  ItemsServiceContract  $commentsService
     * @param  SendItemRequestContract  $request
     * @param  string  $type
     * @param  string  $id
     *
     * @return SendResponseContract
     *
     * @throws BindingResolutionException
     */
    public function send(
        ItemsServiceContract $commentsService,
        SendItemRequestContract $request,
        string $type,
        string $id
    ): SendResponseContract {
        $data = $request->only($commentsService->getModel()->getFillable());

        $item = $commentsService->save($data, $type, $id);

        $result = ($item && isset($item->id));

        return $this->app->make(SendResponseContract::class, compact('result'));
    }

    /**
     * Получаем комментарии к материалу.
     *
     * @param  ItemsServiceContract  $commentsService
     * @param  Request  $request
     * @param  string  $type
     * @param  string  $id
     *
     * @return GetItemsResponseContract
     *
     * @throws BindingResolutionException
     */
    public function getItems(
        ItemsServiceContract $commentsService,
        Request $request,
        string $type,
        string $id
    ): GetItemsResponseContract {
        $page = ($request->filled('page')) ? $request->get('page') - 1 : 0;
        $limit = ($request->filled('limit')) ? $request->get('limit') : 3;

        $items = $commentsService->getitemsTreeByTypeAndId($type, $id)->sortByDesc('datetime');

        return $this->app->make(
            GetItemsResponseContract::class,
            [
                'data' => [
                    'comments' => [
                        'stop' => (($page + 1) * $limit >= $items->count()),
                        'items' => $items->slice($page * $limit, $limit),
                    ],
                ]
            ]
        );
    }
}
