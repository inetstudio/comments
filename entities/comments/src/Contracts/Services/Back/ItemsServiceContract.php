<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Services\Back;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends BaseServiceContract
{
    /**
     * Получаем объект по id (для отображения).
     *
     * @param  int  $id
     * @param  array  $params
     *
     * @return mixed
     */
    public function getItemByIdForDisplay(int $id = 0, array $params = []);

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     * @param  int  $parentId
     *
     * @return CommentModelContract
     */
    public function save(array $data, int $id, int $parentId): CommentModelContract;

    /**
     * Получаем количество непрочитанных комментариев.
     *
     * @return int
     */
    public function getUnreadCommentsCount(): int;

    /**
     * Возвращаем статистику комментариев по активности.
     *
     * @return mixed
     */
    public function getCommentsStatisticByActivity();
}
