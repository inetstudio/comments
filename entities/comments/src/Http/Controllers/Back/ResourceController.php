<?php

namespace InetStudio\CommentsPackage\Comments\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Requests\Back\SaveItemRequestContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Back\ResourceControllerContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\FormResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\ShowResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class ResourceController.
 */
class ResourceController extends Controller implements ResourceControllerContract
{
    /**
     * Список объектов.
     *
     * @param  DataTableServiceContract  $datatablesService
     *
     * @return IndexResponseContract
     *
     * @throws BindingResolutionException
     */
    public function index(DataTableServiceContract $datatablesService): IndexResponseContract
    {
        $table = $datatablesService->html();

        return $this->app->make(
            IndexResponseContract::class,
            [
                'data' => compact('table'),
            ]
        );
    }

    /**
     * Получение объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  int  $id
     *
     * @return ShowResponseContract
     *
     * @throws BindingResolutionException
     */
    public function show(ItemsServiceContract $resourceService, int $id = 0): ShowResponseContract
    {
        $item = $resourceService->getItemById($id);

        return $this->app->make(
            ShowResponseContract::class,
            [
                'item' => $item,
            ]
        );
    }

    /**
     * Создание объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  Request  $request
     *
     * @return FormResponseContract
     *
     * @throws BindingResolutionException
     */
    public function create(ItemsServiceContract $resourceService, Request $request): FormResponseContract
    {
        $item = $resourceService->getItemById();

        $parentItem = ($request->has('parent_comment_id'))
            ? $resourceService->getItemByIdForDisplay($request->get('parent_comment_id'))
            : null;

        return $this->app->make(
            FormResponseContract::class,
            [
                'data' => compact('item', 'parentItem'),
            ]
        );
    }

    /**
     * Создание объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  SaveItemRequestContract  $request
     *
     * @return SaveResponseContract
     *
     * @throws BindingResolutionException
     */
    public function store(ItemsServiceContract $resourceService, SaveItemRequestContract $request): SaveResponseContract
    {
        return $this->save($resourceService, $request);
    }

    /**
     * Редактирование объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  int  $id
     *
     * @return FormResponseContract
     *
     * @throws BindingResolutionException
     */
    public function edit(ItemsServiceContract $resourceService, int $id = 0): FormResponseContract
    {
        $item = $resourceService->getItemByIdForDisplay(
            $id,
            [
                'columns' => ['parent_id']
            ]
        );

        $parentItem = ($item->parent_id)
            ? $resourceService->getItemByIdForDisplay($item->parent_id)
            : null;

        return $this->app->make(
            FormResponseContract::class,
            [
                'data' => compact('item', 'parentItem'),
            ]
        );
    }

    /**
     * Обновление объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  SaveItemRequestContract  $request
     * @param  int  $id
     *
     * @return SaveResponseContract
     *
     * @throws BindingResolutionException
     */
    public function update(
        ItemsServiceContract $resourceService,
        SaveItemRequestContract $request,
        int $id = 0
    ): SaveResponseContract {
        return $this->save($resourceService, $request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  SaveItemRequestContract  $request
     * @param  int  $id
     *
     * @return SaveResponseContract
     *
     * @throws BindingResolutionException
     */
    protected function save(
        ItemsServiceContract $resourceService,
        SaveItemRequestContract $request,
        int $id = 0
    ): SaveResponseContract {
        $data = $request->only($resourceService->getModel()->getFillable());
        $parentId = $request->get('parent_comment_id', 0);

        $item = $resourceService->save($data, $id, $parentId);

        return $this->app->make(
            SaveResponseContract::class,
            [
                'item' => $item,
            ]
        );
    }

    /**
     * Удаление объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  int  $id
     *
     * @return DestroyResponseContract
     *
     * @throws BindingResolutionException
     */
    public function destroy(ItemsServiceContract $resourceService, int $id = 0): DestroyResponseContract
    {
        $result = $resourceService->destroy($id);

        return $this->app->make(
            DestroyResponseContract::class,
            [
                'result' => (! ! $result),
            ]
        );
    }
}
