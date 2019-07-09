<?php

namespace InetStudio\CommentsPackage\Comments\Http\Responses\Back\Moderate;

use Illuminate\Http\Request;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Moderate\ActivityResponseContract;

/**
 * Class ActivityResponse.
 */
class ActivityResponse implements ActivityResponseContract
{
    /**
     * @var bool
     */
    protected $result;

    /**
     * ActivityResponse constructor.
     *
     * @param  bool  $result
     */
    public function __construct(bool $result)
    {
        $this->result = $result;
    }

    /**
     * Возвращаем ответ при изменении активности.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'success' => $this->result,
            ]
        );
    }
}
