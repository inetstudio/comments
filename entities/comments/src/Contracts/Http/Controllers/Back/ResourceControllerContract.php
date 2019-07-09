<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Requests\Back\SaveItemRequestContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\FormResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\ShowResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Interface ResourceControllerContract.
 */
interface ResourceControllerContract
{
    /**
     * Список объектов.
     *
     * @param  DataTableServiceContract  $datatablesService
     *
     * @return IndexResponseContract
     */
    public function index(DataTableServiceContract $datatablesService): IndexResponseContract;

    /**
     * Получение объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  int  $id
     *
     * @return ShowResponseContract
     */
    public function show(ItemsServiceContract $resourceService, int $id = 0): ShowResponseContract;

    /**
     * Создание объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  Request  $request
     *
     * @return FormResponseContract
     */
    public function create(ItemsServiceContract $resourceService, Request $request): FormResponseContract;

    /**
     * Создание объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  SaveItemRequestContract  $request
     *
     * @return SaveResponseContract
     */
    public function store(ItemsServiceContract $resourceService, SaveItemRequestContract $request): SaveResponseContract;

    /**
     * Редактирование объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  int  $id
     *
     * @return FormResponseContract
     */
    public function edit(ItemsServiceContract $resourceService, int $id = 0): FormResponseContract;

    /**
     * Обновление объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  SaveItemRequestContract  $request
     * @param  int  $id
     *
     * @return SaveResponseContract
     */
    public function update(
        ItemsServiceContract $resourceService,
        SaveItemRequestContract $request,
        int $id = 0
    ): SaveResponseContract;

    /**
     * Удаление объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  int  $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(ItemsServiceContract $resourceService, int $id = 0): DestroyResponseContract;
}
