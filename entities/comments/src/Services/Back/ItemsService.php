<?php

namespace InetStudio\CommentsPackage\Comments\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  CommentModelContract  $model
     */
    public function __construct(CommentModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Получаем объект по id (для отображения).
     *
     * @param  int  $id
     * @param  array  $params
     *
     * @return mixed
     */
    public function getItemByIdForDisplay(int $id = 0, array $params = [])
    {
        $item = $this->getItemById($id, $params);

        if ($item->id && ! $item['is_read']) {
            $item->update([
                'is_read' => true,
            ]);
        }

        return $item;
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     * @param  int  $parentId
     *
     * @return CommentModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $id, int $parentId): CommentModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';

        $item = $this->getItemById($id);
        $oldActivity = $item['is_active'];

        $itemData = Arr::only($data, $this->model->getFillable());

        if ($parentId) {
            $parentItem = $this->getItemById(
                $parentId,
                [
                    'columns' => ['_lft', '_rgt']
                ]
            );

            $user = auth()->user();
            $itemData['user_id'] = $user->id;
            $itemData['name'] = $user->name;
            $itemData['email'] = $user->email;
            $itemData['commentable_id'] = $parentItem->commentable_id;
            $itemData['commentable_type'] = $parentItem->commentable_type;
        }

        $item = $this->saveModel($itemData, $id);

        if (isset($parentItem)) {
            $item->appendToNode($parentItem)->save();
        }

        event(
            app()->make(
                'InetStudio\CommentsPackage\Comments\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );


        if (isset($parentItem) && $item && $item['is_active'] == 1 && $oldActivity !== $item['is_active']) {
            event(
                app()->make(
                    'InetStudio\CommentsPackage\Comments\Contracts\Events\Back\AnswerEventContract',
                    compact('item')
                )
            );
        }

        Session::flash('success', 'Комментарий успешно '.$action);

        return $item;
    }

    /**
     * Получаем количество непрочитанных комментариев.
     *
     * @return int
     */
    public function getUnreadCommentsCount(): int
    {
        return $this->model::unread()->count();
    }

    /**
     * Возвращаем статистику комментариев по активности.
     *
     * @return mixed
     */
    public function getCommentsStatisticByActivity()
    {
        $comments = $this->model::select(['is_active', DB::raw('count(*) as total')])
            ->groupBy('is_active')
            ->get();

        return $comments;
    }
}
