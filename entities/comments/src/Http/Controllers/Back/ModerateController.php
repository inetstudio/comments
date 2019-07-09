<?php

namespace InetStudio\CommentsPackage\Comments\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Back\ModerateServiceContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Back\ModerateControllerContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Moderate\ReadResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Moderate\DestroyResponseContract;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Moderate\ActivityResponseContract;

/**
 * Class ModerateController.
 */
class ModerateController extends Controller implements ModerateControllerContract
{
    /**
     * Изменение активности.
     *
     * @param  ModerateServiceContract  $moderateService
     * @param  Request  $request
     *
     * @return ActivityResponseContract
     *
     * @throws BindingResolutionException
     */
    public function activity(ModerateServiceContract $moderateService, Request $request): ActivityResponseContract
    {
        $ids = $request->get('comments') ?? [];

        $result = $moderateService->updateActivity($ids);

        return app()->make(ActivityResponseContract::class, compact('result'));
    }

    /**
     * Пометка "прочитано".
     *
     * @param  ModerateServiceContract  $moderateService
     * @param  Request  $request
     *
     * @return ReadResponseContract
     *
     * @throws BindingResolutionException
     */
    public function read(ModerateServiceContract $moderateService, Request $request): ReadResponseContract
    {
        $ids = $request->get('comments') ?? [];

        $result = $moderateService->updateRead($ids);

        return app()->make(ReadResponseContract::class, compact('result'));
    }

    /**
     * Удаление комментариев.
     *
     * @param  ModerateServiceContract  $moderateService
     * @param  Request  $request
     *
     * @return DestroyResponseContract
     *
     * @throws BindingResolutionException
     */
    public function destroy(ModerateServiceContract $moderateService, Request $request): DestroyResponseContract
    {
        $ids = $request->get('comments') ?? [];

        $result = $moderateService->destroy($ids);

        return app()->make(DestroyResponseContract::class, compact('result'));
    }
}
