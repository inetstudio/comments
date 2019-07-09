<?php

namespace InetStudio\CommentsPackage\Comments\Http\Responses\Front;

use Illuminate\Http\Request;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Front\GetItemsResponseContract;

/**
 * Class GetItemsResponse.
 */
class GetItemsResponse implements GetItemsResponseContract
{
    /**
     * @var array
     */
    protected $data;

    /**
     * GetItemsResponse constructor.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии списка объектов.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return view('admin.module.comments::front.ajax.more', $this->data);
    }
}
