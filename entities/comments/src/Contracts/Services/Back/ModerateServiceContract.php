<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Services\Back;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;

/**
 * Interface ModerateServiceContract.
 */
interface ModerateServiceContract extends BaseServiceContract
{
    /**
     * Изменение активности.
     *
     * @param  mixed  $ids
     * @param  array  $params
     *
     * @return bool
     */
    public function updateActivity($ids, array $params = []): bool;

    /**
     * Пометка "прочитано".
     *
     * @param $ids
     * @param  array  $params
     *
     * @return bool
     */
    public function updateRead($ids, array $params = []): bool;
}
