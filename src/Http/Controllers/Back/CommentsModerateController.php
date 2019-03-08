<?php

namespace InetStudio\Comments\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\Comments\Contracts\Services\Back\CommentsModerateServiceContract;
use InetStudio\Comments\Contracts\Http\Responses\Back\Moderate\ReadResponseContract;
use InetStudio\Comments\Contracts\Http\Responses\Back\Moderate\DestroyResponseContract;
use InetStudio\Comments\Contracts\Http\Responses\Back\Moderate\ActivityResponseContract;
use InetStudio\Comments\Contracts\Http\Controllers\Back\CommentsModerateControllerContract;

/**
 * Class CommentsModerateController.
 */
class CommentsModerateController extends Controller implements CommentsModerateControllerContract
{
    /**
     * Изменение активности.
     *
     * @param Request $request
     * @param CommentsModerateServiceContract $moderateService
     *
     * @return ActivityResponseContract
     */
    public function activity(Request $request, CommentsModerateServiceContract $moderateService): ActivityResponseContract
    {
        $ids = $request->get('comments') ?? [];

        $result = $moderateService->updateActivity($ids);

        return app()->makeWith(ActivityResponseContract::class, compact('result'));
    }

    /**
     * Пометка "прочитано".
     *
     * @param Request $request
     * @param CommentsModerateServiceContract $moderateService
     *
     * @return ReadResponseContract
     */
    public function read(Request $request, CommentsModerateServiceContract $moderateService): ReadResponseContract
    {
        $ids = $request->get('comments') ?? [];

        $result = $moderateService->updateRead($ids);

        return app()->makeWith(ReadResponseContract::class, compact('result'));
    }

    /**
     * Удаление комментариев.
     *
     * @param Request $request
     * @param CommentsModerateServiceContract $moderateService
     *
     * @return DestroyResponseContract
     */
    public function destroy(Request $request, CommentsModerateServiceContract $moderateService): DestroyResponseContract
    {
        $ids = $request->get('comments') ?? [];

        $result = $moderateService->destroy($ids);

        return app()->makeWith(DestroyResponseContract::class, compact('result'));
    }
}
