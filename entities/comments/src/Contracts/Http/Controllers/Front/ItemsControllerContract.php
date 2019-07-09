<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Front;

use Illuminate\Http\Request;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Front\SendResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Requests\Front\SendItemRequestContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Front\GetItemsResponseContract;

/**
 * Interface ItemsControllerContract.
 */
interface ItemsControllerContract
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
     */
    public function send(
        ItemsServiceContract $commentsService,
        SendItemRequestContract $request,
        string $type,
        string $id
    ): SendResponseContract;

    /**
     * Получаем комментарии к материалу.
     *
     * @param  ItemsServiceContract  $commentsService
     * @param  Request  $request
     * @param  string  $type
     * @param  string  $id
     *
     * @return GetItemsResponseContract
     */
    public function getItems(
        ItemsServiceContract $commentsService,
        Request $request,
        string $type,
        string $id
    ): GetItemsResponseContract;
}
