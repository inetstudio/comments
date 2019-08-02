<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Services\Front;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends BaseServiceContract
{
    /**
     * Сохраняем комментарий.
     *
     * @param  array  $data
     * @param  string  $type
     * @param  int  $id
     * @param  int  $parentId
     *
     * @return CommentModelContract|null
     */
    public function save(array $data, string $type, int $id, int $parentId): ?CommentModelContract;

    /**
     * Получаем дерево комментариев по типу и id материала.
     *
     * @param  string  $type
     * @param  int  $id
     * @param  array  $params
     *
     * @return mixed
     */
    public function getItemsTreeByTypeAndId(string $type, int $id, array $params = []);

    /**
     * Преобразуем дерево комментариев.
     *
     * @param $tree
     *
     * @return array
     */
    public function getTree($tree): array;
}
