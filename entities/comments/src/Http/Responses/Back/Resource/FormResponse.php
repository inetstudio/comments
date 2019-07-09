<?php

namespace InetStudio\CommentsPackage\Comments\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\FormResponseContract;

/**
 * Class FormResponse.
 */
class FormResponse implements FormResponseContract
{
    /**
     * @var array
     */
    protected $data;

    /**
     * FormResponse constructor.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии формы объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return view('admin.module.comments::back.pages.form', $this->data);
    }
}
