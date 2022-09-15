<?php

namespace InetStudio\CommentsPackage\Comments\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        $parentId = $request->get('parent_comment_id', 0);
        $data['files'] = Arr::flatten(Arr::wrap($request->allFiles()));

        $item = $commentsService->save($data, $type, $id, $parentId);

        $result = ($item && isset($item->id));

        return $this->app->make(SendResponseContract::class, compact('result'));
    }

    /**
     * Получаем комментарии к материалу.
     *
     * @param  GetItemsResponseContract  $response
     *
     * @return GetItemsResponseContract
     */
    public function getItems(GetItemsResponseContract $response): GetItemsResponseContract
    {
        return $response;
    }
}
