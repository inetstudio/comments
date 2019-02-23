<?php

namespace InetStudio\Comments\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\Comments\Contracts\Services\Back\CommentsServiceContract;
use InetStudio\Comments\Contracts\Http\Requests\Back\SaveCommentRequestContract;
use InetStudio\Comments\Contracts\Services\Back\CommentsDataTableServiceContract;
use InetStudio\Comments\Contracts\Http\Controllers\Back\CommentsControllerContract;
use InetStudio\Comments\Contracts\Http\Responses\Back\Resource\FormResponseContract;
use InetStudio\Comments\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\Comments\Contracts\Http\Responses\Back\Resource\ShowResponseContract;
use InetStudio\Comments\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\Comments\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class CommentsController.
 */
class CommentsController extends Controller implements CommentsControllerContract
{
    /**
     * Список объектов.
     *
     * @param CommentsDataTableServiceContract $datatablesService
     * 
     * @return IndexResponseContract
     */
    public function index(CommentsDataTableServiceContract $datatablesService): IndexResponseContract
    {
        $table = $datatablesService->html();

        return app()->makeWith(IndexResponseContract::class, [
            'data' => compact('table'),
        ]);
    }

    /**
     * Получение объекта.
     *
     * @param CommentsServiceContract $commentsService
     * @param int $id
     *
     * @return ShowResponseContract
     */
    public function show(CommentsServiceContract $commentsService, int $id = 0): ShowResponseContract
    {
        $item = $commentsService->getItemById($id);

        return app()->makeWith(ShowResponseContract::class, [
            'item' => $item,
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param CommentsServiceContract $commentsService
     * @param Request $request
     *
     * @return FormResponseContract
     */
    public function create(CommentsServiceContract $commentsService, Request $request): FormResponseContract
    {
        $item = $commentsService->getItemById();

        $parentItem = ($request->has('parent_comment_id'))
            ? $commentsService->getItemByIdForDisplay($request->get('parent_comment_id'))
            : null;

        return app()->makeWith(FormResponseContract::class, [
            'data' => compact('item', 'parentItem'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param CommentsServiceContract $commentsService
     * @param SaveCommentRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(CommentsServiceContract $commentsService, SaveCommentRequestContract $request): SaveResponseContract
    {
        return $this->save($commentsService, $request);
    }

    /**
     * Редактирование объекта.
     *
     * @param CommentsServiceContract $commentsService
     * @param int $id
     *
     * @return FormResponseContract
     */
    public function edit(CommentsServiceContract $commentsService, int $id = 0): FormResponseContract
    {
        $item = $commentsService->getItemByIdForDisplay($id, [
            'columns' => ['parent_id']
        ]);

        $parentItem = ($item->parent_id)
            ? $commentsService->getItemByIdForDisplay($item->parent_id)
            : null;

        return app()->makeWith(FormResponseContract::class, [
            'data' => compact('item', 'parentItem'),
        ]);
    }

    /**
     * Обновление объекта.
     *
     * @param CommentsServiceContract $commentsService
     * @param SaveCommentRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(CommentsServiceContract $commentsService, SaveCommentRequestContract $request, int $id = 0): SaveResponseContract
    {
        return $this->save($commentsService, $request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param CommentsServiceContract $commentsService
     * @param SaveCommentRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    protected function save(CommentsServiceContract $commentsService, SaveCommentRequestContract $request, int $id = 0): SaveResponseContract
    {
        $data = $request->only($commentsService->model->getFillable());
        $parentId = $request->get('parent_comment_id') ?? 0;

        $item = $commentsService->save($data, $id, $parentId);

        return app()->makeWith(SaveResponseContract::class, [
            'item' => $item,
        ]);
    }

    /**
     * Удаление объекта.
     *
     * @param CommentsServiceContract $commentsService
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(CommentsServiceContract $commentsService, int $id = 0): DestroyResponseContract
    {
        $result = $commentsService->destroy($id);

        return app()->makeWith(DestroyResponseContract::class, [
            'result' => (!! $result),
        ]);
    }
}
