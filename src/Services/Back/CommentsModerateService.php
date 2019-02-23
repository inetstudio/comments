<?php

namespace InetStudio\Comments\Services\Back;

use InetStudio\AdminPanel\Base\Services\Back\BaseService;
use InetStudio\Comments\Contracts\Services\Back\CommentsModerateServiceContract;

/**
 * Class CommentsModerateService.
 */
class CommentsModerateService extends BaseService implements CommentsModerateServiceContract
{
    /**
     * CommentsModerateService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\Comments\Contracts\Models\CommentModelContract'));
    }

    /**
     * Изменение активности.
     *
     * @param mixed $ids
     * @param array $params
     *
     * @return bool
     */
    public function updateActivity($ids, array $params = []): bool
    {
        $items = $this->getItemById($ids, $params);

        foreach ($items as $item) {
            $item->update([
                'is_active' => ! $item->is_active,
                'is_read' => 1,
            ]);

            event(app()->makeWith('InetStudio\Comments\Contracts\Events\Back\ModifyCommentEventContract', [
                'object' => $item,
            ]));
        }

        return true;
    }

    /**
     * Пометка "прочитано".
     *
     * @param $ids
     * @param array $params
     *
     * @return bool
     */
    public function updateRead($ids, array $params = []): bool
    {
        $items = $this->getItemById($ids, $params);

        foreach ($items as $item) {
            $item->update([
                'is_read' => 1,
            ]);

            event(app()->makeWith('InetStudio\Comments\Contracts\Events\Back\ModifyCommentEventContract', [
                'object' => $item,
            ]));
        }

        return true;
    }
}
