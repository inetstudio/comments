<?php

namespace InetStudio\Comments\Http\Responses\Back\Moderate;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Comments\Contracts\Http\Responses\Back\Moderate\ActivityResponseContract;

/**
 * Class ActivityResponse.
 */
class ActivityResponse implements ActivityResponseContract, Responsable
{
    /**
     * @var bool
     */
    protected $result;

    /**
     * ActivityResponse constructor.
     *
     * @param bool $result
     */
    public function __construct(bool $result)
    {
        $this->result = $result;
    }

    /**
     * Возвращаем ответ при изменении активности.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'success' => $this->result,
        ]);
    }
}
