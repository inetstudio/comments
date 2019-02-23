<?php

namespace InetStudio\Comments\Http\Responses\Front;

use Illuminate\View\View;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Comments\Contracts\Http\Responses\Front\GetCommentsResponseContract;

/**
 * Class GetCommentsResponse.
 */
class GetCommentsResponse implements GetCommentsResponseContract, Responsable
{
    /**
     * @var array
     */
    protected $data;

    /**
     * IndexResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии списка объектов.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return View
     */
    public function toResponse($request): View
    {
        return view('admin.module.comments::front.ajax.more', $this->data);
    }
}
