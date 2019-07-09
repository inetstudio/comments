<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Back;

use Illuminate\Http\JsonResponse;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Back\DataTableServiceContract;

/**
 * Interface DataControllerContract.
 */
interface DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param  DataTableServiceContract  $datatablesService
     *
     * @return JsonResponse
     */
    public function data(DataTableServiceContract $datatablesService): JsonResponse;
}
