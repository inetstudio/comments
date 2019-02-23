<?php

namespace InetStudio\Comments\Http\Controllers\Back;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use InetStudio\Comments\Contracts\Services\Back\CommentsDataTableServiceContract;
use InetStudio\Comments\Contracts\Http\Controllers\Back\CommentsDataControllerContract;

/**
 * Class CommentsDataController.
 */
class CommentsDataController extends Controller implements CommentsDataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param CommentsDataTableServiceContract $datatablesService
     *
     * @return JsonResponse
     */
    public function data(CommentsDataTableServiceContract $datatablesService): JsonResponse
    {
        return $datatablesService->ajax();
    }
}
