<?php

namespace InetStudio\Comments\Http\Responses\Front;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Comments\Contracts\Http\Responses\Front\SendCommentResponseContract;

/**
 * Class SendCommentResponse.
 */
class SendCommentResponse implements SendCommentResponseContract, Responsable
{
    /**
     * @var bool
     */
    protected $result;

    /**
     * SendCommentResponse constructor.
     *
     * @param bool $result
     */
    public function __construct(bool $result)
    {
        $this->result = $result;
    }

    /**
     * Возвращаем ответ при удалении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'success' => $this->result,
            'message' => ($this->result)
                ? trans('comments::messages.send_success')
                : trans('comments::messages.send_fail'),
        ]);
    }
}
