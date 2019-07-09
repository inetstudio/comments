<?php

namespace InetStudio\CommentsPackage\Comments\Http\Responses\Front;

use Illuminate\Http\Request;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Front\SendResponseContract;

/**
 * Class SendResponse.
 */
class SendResponse implements SendResponseContract
{
    /**
     * @var bool
     */
    protected $result;

    /**
     * SendResponse constructor.
     *
     * @param  bool  $result
     */
    public function __construct(bool $result)
    {
        $this->result = $result;
    }

    /**
     * Возвращаем ответ при удалении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return response()->json([
            'success' => $this->result,
            'message' => ($this->result)
                ? trans('comments::messages.send_success')
                : trans('comments::messages.send_fail'),
        ]);
    }
}
