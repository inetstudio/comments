<?php

namespace InetStudio\CommentsPackage\Comments\Http\Controllers\Back;

use Illuminate\Http\JsonResponse;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Back\DataControllerContract;

/**
 * Class DataController.
 */
class DataController extends Controller implements DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param  DataTableServiceContract  $datatablesService
     *
     * @return JsonResponse
     */
    public function data(DataTableServiceContract $datatablesService): JsonResponse
    {
        return $datatablesService->ajax();
    }
}
