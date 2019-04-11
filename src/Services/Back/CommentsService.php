<?php

namespace InetStudio\Comments\Services\Back;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\Comments\Contracts\Models\CommentModelContract;
use InetStudio\Comments\Contracts\Services\Back\CommentsServiceContract;

/**
 * Class CommentsService.
 */
class CommentsService extends BaseService implements CommentsServiceContract
{
    /**
     * CommentsService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\Comments\Contracts\Models\CommentModelContract'));
    }

    /**
     * Получаем объект по id (для отображения).
     *
     * @param int $id
     * @param array $params
     *
     * @return mixed
     */
    public function getItemByIdForDisplay(int $id = 0, array $params = [])
    {
        $item = $this->getItemById($id, $params);

        if ($item->id && ! $item->is_read) {
            $item->update([
                'is_read' => true,
            ]);
        }

        return $item;
    }

    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     * @param int $parentId
     *
     * @return CommentModelContract
     */
    public function save(array $data, int $id, int $parentId): CommentModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';

        $oldItem = $this->getItemById($id);
        $oldActivity = $oldItem->is_active;

        if ($parentId) {
            $parentItem = $this->getItemById($parentId, [
                'columns' => ['_lft', '_rgt']
            ]);

            $user = auth()->user();
            $data['user_id'] = $user->id;
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['commentable_id'] = $parentItem->commentable_id;
            $data['commentable_type'] = $parentItem->commentable_type;
        }

        $item = $this->saveModel($data, $id);

        if (isset($parentItem)) {
            $item->appendToNode($parentItem)->save();
        }

        event(app()->makeWith('InetStudio\Comments\Contracts\Events\Back\ModifyCommentEventContract', [
            'object' => $item,
        ]));

        if (isset($parentItem) && $item && $item->is_active == 1 && $oldActivity !== $item->is_active) {
            event(app()->makeWith('InetStudio\Comments\Contracts\Events\Back\AnswerEventContract', [
                'object' => $item,
            ]));
        }

        Session::flash('success', 'Комментарий успешно '.$action);

        return $item;
    }

    /**
     * Получаем количество непрочитанных комментариев.
     *
     * @return mixed
     */
    public function getUnreadCommentsCount()
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
